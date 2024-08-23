<?php

namespace App\Http\Controllers;

use App\Models\AuditEmployee;
use App\Models\Employee;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function create()
    {
        return view('employee.create-employee', ['employee' => null]);
    }
    public function store(Request $request)
    {
        try {
            // Validação dos dados (aceitar qualquer formato para RG e CPF)
            $validatedData = $request->validate([
                'rg' => 'required|string',
                'cpf' => [
                    'required',
                    'string',
                    Rule::unique('freelancers'),
                    Rule::unique('employees'),
                ],
                'name' => 'required',
                'pai' => 'nullable',
                'mae' => 'required',
                'nascimento' => 'required|date',
            ]);

            // Formatação dos dados (remover pontos, traços e outros caracteres não numéricos)
            $validatedData['rg'] = preg_replace('/[^a-zA-Z0-9]/', '', $validatedData['rg']);
            $validatedData['cpf'] = preg_replace('/[^a-zA-Z0-9]/', '', $validatedData['cpf']);

            // Obtém o ID do usuário autenticado
            $userId = Auth::id();

            // Cria o registro do empregado com o ID do usuário
            Employee::create(array_merge($validatedData, ['user_id' => $userId]));

            return redirect(route('dashboard'))->with('success', 'Registro criado com sucesso');
        } catch (ValidationException $e) {
            // Armazena os dados na sessão para depuração
            return redirect(route('dashboard'))
                ->with('fail', 'Falha na validação dos dados: ' . $e->getMessage());
        }
    }
    public function show(Employee $employee)
    {
        // Recupera todos os registros da tabela 'employees'
        $employees = Employee::orderBy('created_at', 'desc')->paginate(5);
        $olddatas = AuditEmployee::orderBy('created_at', 'desc')->paginate(3);


        // Retorna a view 'employee.partials.show-employee' com os dados recuperados
        return view('employee.show-employee', compact('employees', 'olddatas'));
    }
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);

        if ($employee->return_status != 'Em análise') {
            return redirect(route('dashboard'))->with('fail', 'Uma consulta já finalizada não poderá mais ser alterada, agende uma nova');
        }
        return view('employee.create-employee', compact('employee'));
    }
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'rg' => 'required|string',
                'cpf' => [
                    'required',
                    'string',
                    Rule::unique('freelancers')->ignore($id),
                    Rule::unique('employees')->ignore($id),
                ],
                'pai' => 'nullable',
                'mae' => 'required',
                'nascimento' => 'required|date',
            ]);

            $employee = Employee::findOrFail($id);
            // Criação de uma auditoria antes de atualizar os dados
            AuditEmployee::create([
                'employee_id' => $employee->id,
                'OldName' =>     $employee->name,
                'OldRg' =>       $employee->rg,
                'OldCpf' =>      $employee->cpf,
                'OldNascimento' => $employee->nascimento,
                'OldPai' =>      $employee->pai,
                'OldMae' =>      $employee->mae,
                'OldUser_id' =>  $employee->user_id,
                'OldReturn_status' => $employee->return_status,
            ]);
            // Atualiza os dados do empregado
            $employee->rg = preg_replace('/[^a-zA-Z0-9]/', '', $request->input('rg'));
            $employee->cpf = preg_replace('/[^a-zA-Z0-9]/', '', $request->input('cpf'));
            $employee->name = $request->input('name');
            $employee->pai = $request->input('pai');
            $employee->mae = $request->input('mae');
            $employee->nascimento = $request->input('nascimento');
            $employee->return_status = 'Em análise';
            $employee->user_id = Auth::id(); // Ou use outro campo se necessário

            $employee->save();

            return redirect(route('dashboard'))->with('success', 'Registro atualizado com sucesso');
        } catch (ValidationException $e) {
            // Armazena os dados na sessão para depuração
            return redirect(route('dashboard'))
                ->with('fail', 'Falha na atualização dos dados: ' . $e->getMessage());
        }
    }

    public function accept(string $id)
    {
        $employee = Employee::findOrFail($id);
        try {
            $employee->return_status = "Aprovado";
            $employee->save();
            return redirect(route('dashboard'))
                ->with('success', 'Registro aprovado.');
        } catch (ValidationException $e) {
            return redirect(route('dashboard'))
                ->with('fail', 'Falha na aprovação dos dados: ' . $e->getMessage());
        }
    }

    public function reject(string $id)
    {
        $employee = Employee::findOrFail($id);
        try {
            $employee->return_status = "Rejeitado";
            $employee->save();
            return redirect(route('dashboard'))
                ->with('success', 'Registro rejeitado.');
        } catch (ValidationException $e) {
            return redirect(route('dashboard'))
                ->with('fail', 'Falha na rejeição dos dados: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        // Verifica se o usuário tem permissão para deletar (usertype 2 ou 3)
        if (Auth::user()->usertype >= 2) {
            try {
                $employee = Employee::findOrFail($id);

                if ($employee->return_status != 'Em análise' && Auth::user()->usertype == 2) {

                    return redirect(route('dashboard'))
                        ->with('fail', 'Consultas completas não podem ser excluídas.');
                }
                Employee::destroy($id);
                return redirect(route('dashboard'))
                    ->with('success', 'Registro deletado com sucesso');
            } catch (ValidationException $e) {
                // Armazena os dados na sessão para depuração
                return redirect(route('dashboard'))
                    ->with('fail', 'Falha na exclusão dos dados: ' . $e->getMessage());
            }
        } else {
            return redirect(route('dashboard'))->with('fail', 'Você não tem permissão para deletar este registro.');
        }
    }
}
