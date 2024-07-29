<?php

namespace App\Http\Controllers;

use App\Models\Freelancer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class FreelancerController extends Controller
{
    public function create()
    {
        return view('freelancer.freelancer', ['freelancer'=>null]);
    }
    public function store(Request $request)
    {
        try {

            // Validação dos dados (aceitar qualquer formato para RG e CPF)
            $validatedData = $request->validate([
                'rg' => 'required|string',
                'cpf' => 'required|string|unique:freelancers,cpf',
                'name' => 'required',
                'pai' => 'nullable',
                'mae' => 'required',
                'nascimento' => 'required|date',
                'cnh' => 'required|unique:freelancers,placa',
                'placa' => 'required|unique:freelancers,placa',
            ]);
            $validatedData['rg'] = preg_replace('/\D/', '', $validatedData['rg']);
            $validatedData['cpf'] = preg_replace('/\D/', '', $validatedData['cpf']);
            $validatedData['cnh'] = preg_replace('/\D/', '', $validatedData['cnh']);
            $validatedData['placa'] = preg_replace('/\D/', '', $validatedData['placa']);

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
        $freelancers = Freelancer::paginate(10);
        return view('freelancer.partials.show-freelancer', compact('freelancers'));
    }
    public function edit($id)
    {
        $freelancer = Freelancer::findOrFail($id);
        return view('freelancer.freelancer', compact('freelancer'));
    }
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required',
                'rg' => 'required|string',
                'cpf' => 'required|string|unique:freelancers,cpf,' . $id,
                'pai' => 'nullable',
                'mae' => 'required',
                'nascimento' => 'required|date',
                'cnh' => 'required|unique:freelancers,cnh,' . $id,
                'placa' => 'required|unique:freelancers,placa,' . $id,
            ]);

            $freelancer = Freelancer::findOrFail($id);

            // Atualiza os dados do empregado
            $freelancer->name = $request->input('name');
            $freelancer->rg = preg_replace('/\D/', '', $request->input('rg'));
            $freelancer->cpf = preg_replace('/\D/', '', $request->input('cpf'));
            $freelancer->pai = $request->input('pai');
            $freelancer->mae = $request->input('mae');
            $freelancer->nascimento = $request->input('nascimento');
            $freelancer->placa = $request->input('placa');
            $freelancer->cnh = $request->input('cnh');
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
}
