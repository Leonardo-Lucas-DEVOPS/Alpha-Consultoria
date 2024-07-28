<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee.create-employee');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validação dos dados (aceitar qualquer formato para RG e CPF)
            $validatedData = $request->validate([
                'rg' => 'required|string',
                'cpf' => 'required|string|unique:employees,cpf',
                'name' => 'required',
                'pai' => 'nullable',
                'mae' => 'required',
                'nascimento' => 'required|date',
            ]);

            // Formatação dos dados (remover pontos, traços e outros caracteres não numéricos)
            $validatedData['rg'] = preg_replace('/\D/', '', $validatedData['rg']);
            $validatedData['cpf'] = preg_replace('/\D/', '', $validatedData['cpf']);

            // Obtém o ID do usuário autenticado
            $userId = Auth::id();

            // Cria o registro do empregado com o ID do usuário
            Employee::create(array_merge($validatedData,['user_id' => $userId]));

            return redirect(route('dashboard'))->with('success', 'Registro criado com sucesso');
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




    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        // Recupera todos os registros da tabela 'employees'
        $employees = Employee::paginate(10);

        // Retorna a view 'employee.partials.show-employee' com os dados recuperados
        return view('employee.partials.show-employee', compact('employees'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
