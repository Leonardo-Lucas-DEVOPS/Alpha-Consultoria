<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

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
        $request->validate([
            'name' => 'required',
            'rg' => 'required',
            'cpf' => 'required|unique:employees,cpf',
            'pai' => 'required',
            'mae' => 'required',
            'nascimento' => 'required|date',
        ]);
    
        // Obtém o ID do usuário autenticado
        $userId = Auth::id();
    
        // Cria o registro do empregado com o ID do usuário
        Employee::create(array_merge(
            $request->all(),
            ['user_id' => $userId]  // Adiciona o ID do usuário aos dados
        ));
        
        return redirect(route('dashboard', absolute: false))->with('success','Consulta realizada');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
