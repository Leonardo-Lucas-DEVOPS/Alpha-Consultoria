<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class VehicleController extends Controller
{
    public function create(){
        return view('vehicle.create-vehicle');
    }
    
    public function store(Request $request){
        try {
            
            $validatedData = $request->validate([
                'placa'=>'required|unique:vehicles,placa',
                'chassi'=>'required|unique:vehicles,chassi',
                'renavam'=>'required|unique:vehicles,renavam',
                
            ]); 
            
            $validatedData['placa'] = preg_replace('/\D/', '', $validatedData['placa']);
            $validatedData['renavam'] = preg_replace('/\D/', '', $validatedData['renavam']);
            $validatedData['chassi'] = preg_replace('/\D/', '', $validatedData['chassi']);


            $userId = Auth::id();
            Vehicle::create(array_merge($validatedData, ['user_id' => $userId]));
            

            return redirect(route('dashboard'))->with('success','Registro criado com sucesso');
        }
        catch (ValidationException $e) {
            // Armazena os dados na sessão para depuração
            return redirect(route('dashboard'))
                ->with('fail', 'Falha na validação dos dados: ' . $e->getMessage());
        } catch (ValidationException $e) {
            // Armazena os dados na sessão para depuração
            return redirect(route('dashboard'))
                ->with('fail', 'Falha no registro: ' . $e->getMessage());
        }
    }

    public function show(Vehicle $vehicle)
    {
        // Recupera todos os registros da tabela 'employees'
        $vehicles = Vehicle::paginate(10);

        // Retorna a view 'employee.partials.show-employee' com os dados recuperados
        return view('vehicle.partials.show-vehicle', compact('vehicles'));
    }

}
