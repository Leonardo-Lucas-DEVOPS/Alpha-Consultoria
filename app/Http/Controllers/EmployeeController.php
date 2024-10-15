<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Employee;
use App\Models\AuditEmployee;
use Illuminate\Validation\ValidationException;

define('FORMATACAO', '/[^a-zA-Z0-9]/');
define('EM_ANALISE', 'Em análise');

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

            $validatedData['rg'] = preg_replace(FORMATACAO, '', $validatedData['rg']);
            $validatedData['cpf'] = preg_replace(FORMATACAO, '', $validatedData['cpf']);

            $userId = Auth::id();

            // Pegar o número de faturas e o último ID da fatura para o usuário
            $companyInvoice = $this->invoicesPerCompany();
            // Pegar a data da última fatura e adicionar 30 dias
            $invoiceDate = $this->invoicesPerDate();

            // Comparar a data e verificar se já passou o intervalo de 30 dias
            if (!$companyInvoice || $companyInvoice->NumberInvoices == 0 || Carbon::parse($invoiceDate->InvoiceDate)->isPast()) {
                // Criar uma nova fatura se não houver faturas ou se o intervalo de 30 dias já passou
                $invoice = Invoice::create([
                    'user_id' => $userId
                ]);
            } else {
                // Se já existe uma fatura válida, use a existente
                $invoice = $companyInvoice;
            }

            // Criar o empregado relacionado à fatura
            Employee::create(array_merge($validatedData, ['invoice_id' => $invoice->id]));

            // Retornar para o dashboard com a mensagem de sucesso
            return redirect(route('dashboard'))->with('success', 'Registro criado com sucesso');
        } catch (ValidationException $e) {
            // Armazena os dados na sessão para depuração
            return redirect(route('dashboard'))
                ->with('fail', 'Falha na validação dos dados: ' . $e->getMessage());
        }
    }

    public function show(Employee $employee)
    {
        // Atualiza o status dos funcionários com mais de 3 meses
        $this->updateStatusForModel(Employee::class);

        if (Auth::user()->usertype == 3) {
            $employees = Employee::orderBy('created_at', 'desc')->paginate(5);
            $olddatas = AuditEmployee::orderBy('created_at', 'desc')->paginate(5);
            return view('employee.show-employee', compact('employees', 'olddatas'));
        }

        // Filtrar os funcionários que pertencem à empresa do usuário logado
        $employees = $this->filterConsults(Employee::class);

        // Filtrar os dados de auditoria de funcionários pertencentes à mesma empresa
        $olddatas = $this->filterAudit(AuditEmployee::class);

        // Retorna a view 'employee.show-employee' com os dados filtrados
        return view('employee.show-employee', compact('employees', 'olddatas'));
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);

        if ($employee->return_status != EM_ANALISE) {
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
                'OldInvoice_id' => $employee->invoice_id,
                'OldReturn_status' => $employee->return_status,
            ]);
            // Atualiza os dados do empregado
            $employee->rg = preg_replace(FORMATACAO, '', $request->input('rg'));
            $employee->cpf = preg_replace(FORMATACAO, '', $request->input('cpf'));
            $employee->name = $request->input('name');
            $employee->pai = $request->input('pai');
            $employee->mae = $request->input('mae');
            $employee->nascimento = $request->input('nascimento');
            $employee->return_status = EM_ANALISE;

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
            return redirect(route('employee.show'))
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
            return redirect(route('employee.show'))
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
            $employee = Employee::findOrFail($id);

            if ($employee->return_status != EM_ANALISE && Auth::user()->usertype == 2) {

                return redirect(route('dashboard'))
                    ->with('fail', 'Consultas completas não podem ser excluídas.');
            }
            Employee::destroy($id);
            return redirect(route('employee.show'))
                ->with('success', 'Registro deletado com sucesso');
        } else {
            return redirect(route('dashboard'))->with('fail', 'Você não tem permissão para deletar este registro.');
        }
    }
}
