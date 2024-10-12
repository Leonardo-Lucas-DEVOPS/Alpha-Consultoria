<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Freelancer;
use App\Models\AuditFreelancer;
use App\Models\Invoice;
use Illuminate\Validation\ValidationException;

class FreelancerController extends Controller
{
    public function create()
    {
        return view('freelancer.create-freelancer', ['freelancer' => null]);
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
                'cnh' => 'required|unique:freelancers,placa',
                'placa' => 'required|unique:freelancers,placa',
            ]);

            $validatedData['rg'] = preg_replace('/[^a-zA-Z0-9]/', '', $validatedData['rg']);
            $validatedData['cpf'] = preg_replace('/[^a-zA-Z0-9]/', '', $validatedData['cpf']);
            $validatedData['cnh'] = preg_replace('/[^a-zA-Z0-9]/', '', $validatedData['cnh']);
            $validatedData['placa'] = preg_replace('/[^a-zA-Z0-9]/', '', $validatedData['placa']);

            // Obtém o ID do usuário autenticado
            $userId = Auth::id();

            Invoice::create([
                'user_id' => $userId,
                'status' => 'Pendente',
                'cost_employee' => 0,
                'cost_freelancer' => 0,
                'cost_vehicle' => 0,
            ]);

            Freelancer::create(array_merge($validatedData, ['invoice_id' => $userId]));

            return redirect(route('dashboard'))->with('success', 'Registro criado com sucesso');
        } catch (ValidationException $e) {   // Armazena os dados na sessão para depuração
            return redirect(route('dashboard'))
                ->with('fail', 'Falha na validação dos dados: ' . $e->getMessage());
        }
    }
    public function show(Freelancer $freelancer)
    {
        // Atualiza o status dos freelancers com mais de 3 meses
        $this->updateStatusForModel(Freelancer::class);

        if (Auth::user()->usertype == 3){
            $freelancers = Freelancer::orderBy('created_at', 'desc')->paginate(5);
            $olddatas = AuditFreelancer::orderBy('created_at', 'desc')->paginate(5);
            return view('freelancer.show-freelancer', compact('freelancers', 'olddatas'));
        }
        // Filtrar os freelancers que pertencem à empresa do usuário logado
        $freelancers = $this->filterConsults(Freelancer::class);

        // Filtrar os dados de auditoria de freelancers pertencentes à mesma empresa
        $olddatas = $this->filterAudit(AuditFreelancer::class);

        // Retornar a view 'freelancer.show-freelancer' com os freelancers e dados de auditoria filtrados
        return view('freelancer.show-freelancer', compact('freelancers', 'olddatas'));
    }

    public function edit($id)
    {
        $freelancer = Freelancer::findOrFail($id);

        if ($freelancer->return_status != 'Em análise') {
            return redirect(route('dashboard'))->with('fail', 'Uma consulta já finalizada não poderá mais ser alterada, agende uma nova');
        }
        return view('freelancer.create-freelancer', compact('freelancer'));
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
                'cnh' => 'required|unique:freelancers,cnh,' . $id,
                'placa' => 'required|unique:freelancers,placa,' . $id,
            ]);

            $freelancer = Freelancer::findOrFail($id);

            // Criação de uma auditoria antes de atualizar os dados
            AuditFreelancer::create([
                'freelancer_id' => $freelancer->id,
                'OldName' => $freelancer->name,
                'OldRg' => $freelancer->rg,
                'OldCpf' => $freelancer->cpf,
                'OldNascimento' => $freelancer->nascimento,
                'OldPai' => $freelancer->pai,
                'OldMae' => $freelancer->mae,
                'OldCnh' => $freelancer->cnh,
                'OldPlaca' => $freelancer->placa,
                'OldUser_id' => $freelancer->user_id,
                'OldReturn_status' => $freelancer->return_status,
            ]);

            // Atualiza os dados do empregado
            $freelancer->name = $request->input('name');
            $freelancer->rg = preg_replace('/[^a-zA-Z0-9]/', '', $request->input('rg'));
            $freelancer->cpf = preg_replace('/[^a-zA-Z0-9]/', '', $request->input('cpf'));
            $freelancer->placa = preg_replace('/[^a-zA-Z0-9]/', '', $request->input('placa'));
            $freelancer->cnh = preg_replace('/[^a-zA-Z0-9]/', '', $request->input('cnh'));
            $freelancer->pai = $request->input('pai');
            $freelancer->mae = $request->input('mae');
            $freelancer->nascimento = $request->input('nascimento');
            $freelancer->return_status = 'Em análise';

            $freelancer->save();

            return redirect(route('dashboard'))->with('success', 'Registro atualizado com sucesso');
        } catch (ValidationException $e) {
            // Armazena os dados na sessão para depuração
            return redirect(route('dashboard'))
                ->with('fail', 'Falha na atualização dos dados: ' . $e->getMessage());
        }
    }
    public function accept(string $id)
    {
        $freelancer = Freelancer::findOrFail($id);
        try {
            $freelancer->return_status = "Aprovado";
            $freelancer->save();
            return redirect(route('freelancer.show'))
                ->with('success', 'Registro aprovado.');
        } catch (ValidationException $e) {
            return redirect(route('dashboard'))
                ->with('fail', 'Falha na aprovação dos dados: ' . $e->getMessage());
        }
    }
    public function reject(string $id)
    {
        $freelancer = Freelancer::findOrFail($id);
        try {
            $freelancer->return_status = "Rejeitado";
            $freelancer->save();
            return redirect(route('freelancer.show'))
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
                $freelancer = Freelancer::findOrFail($id);

                if ($freelancer->return_status != 'Em análise' && Auth::user()->usertype == 2) {

                    return redirect(route('dashboard'))
                        ->with('fail', 'Consultas completas não podem ser excluídas.');
                }
                Freelancer::destroy($id);
                return redirect(route('freelancer.show'))
                    ->with('success', 'Registro deletado com sucesso');
            } catch (ValidationException $e) {
                // Armazena os dados na sessão para depuração
                return redirect(route('freelancer.show'))
                    ->with('success', 'Registro deletado com sucesso');
            }
        } else {
            return redirect(route('dashboard'))->with('fail', 'Você não tem permissão para deletar este registro.');
        }
    }
}
