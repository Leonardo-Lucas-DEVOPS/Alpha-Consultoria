<?php

namespace App\Http\Controllers;

use App\Models\Freelancer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use PHPUnit\TextUI\Configuration\Merger;

class FreelancerController extends Controller
{
    public function create()
    {
        return view('freelancer.create-freelancer');
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
        // Recupera todos os registros da tabela 'employees'
        $freelancers = Freelancer::paginate(10);

        // Retorna a view 'employee.partials.show-employee' com os dados recuperados
        return view('freelancer.partials.show-freelancer', compact('freelancers'));
    }

}
