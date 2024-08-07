<?php

namespace App\Http\Controllers;

use App\Models\AuditFreelancer;
use App\Models\Freelancer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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
                'rg' => 'required|string', 'cpf' => [
                    'required',
                    'string',
                    Rule::unique('freelancers')     ,
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

            Freelancer::create(array_merge($validatedData, ['user_id' => $userId]));
            return redirect(route('dashboard'))->with('success', 'Registro criado com sucesso');
        } catch (ValidationException $e) {   // Armazena os dados na sessão para depuração
            return redirect(route('dashboard'))
                ->with('fail', 'Falha na validação dos dados: ' . $e->getMessage());
        } catch (ValidationException $e) {
            // Armazena os dados na sessão para depuração
            return redirect(route('dashboard'))
                ->with('fail', 'Falha no registro: ' . $e->getMessage());
        }
    }
    public function show(Freelancer $freelancer)
    {
        
        $page = 'show';
        $freelancers = Freelancer::orderBy('created_at', 'desc')->paginate(10);
        $olddatas = AuditFreelancer::orderBy('created_at', 'asc')->paginate(1);
        return view('freelancer.show-freelancer', compact('page','freelancers','olddatas'));
    }
    public function edit($id)
    {
        $freelancer = Freelancer::findOrFail($id);
        return view('freelancer.create-freelancer', compact('freelancer'));
    }
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required',
                'rg' => 'required|string', 'cpf' => [
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
            $freelancer->user_id = Auth::id(); // Ou use outro campo se necessário

            $freelancer->save();

            return redirect(route('dashboard'))->with('success', 'Registro atualizado com sucesso');
        } catch (ValidationException $e) {
            // Armazena os dados na sessão para depuração
            return redirect(route('dashboard'))
                ->with('fail', 'Falha na validação dos dados: ' . $e->getMessage());
        } catch (ValidationException $e) {
            // Armazena os dados na sessão para depuração
            return redirect(route('dashboard'))
                ->with('fail', 'Falha no registro: ' . $e->getMessage());
        }
    }
    public function destroy(string $id)
    {
        // Obtém o usuário autenticado
        $user = auth()->user();

        // Verifica se o usuário tem permissão para deletar (usertype 2 ou 3)
        if ($user->usertype == 2 || $user->usertype == 3) {
            try {
                $freelancer = Freelancer::findOrFail($id);
                if ($freelancer->return_status != 'Em análise') {

                    return redirect(route('dashboard'))
                        ->with('fail', 'Consultas completas não podem ser excluídas.');
                }
                    Freelancer::destroy($id);
                    return redirect(route('dashboard'))->with('success', 'Registro deletado com sucesso');
                
            } catch (ValidationException $e) {
                // Armazena os dados na sessão para depuração
                return redirect(route('dashboard'))
                    ->with('fail', 'Falha na validação dos dados: ' . $e->getMessage());
            } catch (\Exception $e) {
                // Armazena os dados na sessão para depuração
                return redirect(route('dashboard'))
                    ->with('fail', 'Falha no registro: ' . $e->getMessage());
            }
        } else {
            return redirect(route('dashboard'))->with('fail', 'Você não tem permissão para deletar este registro.');
        }
    }
}
