<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    public function create(){
        return view('vehicle.create-vehicle');
    }
    
    public function store(Request $request){
        try {
            
            $validatedData = $request->validade([
                'placa'=>'required|unique:vehicles,placa',
                'chassi'=>'required|unique:vehicles,chassi',
                'renavam'=>'required|unique:vehicles,renavam',
                
            ]); 
            
            $validatedData['placa'] = preg_replace('/\D/', '', $validatedData['placa']);
            $validatedData['cnh'] = preg_replace('/\D/', '', $validatedData['cnh']);
            $validatedData['placa'] = preg_replace('/\D/', '', $validatedData['placa']);


            $userId = Auth::id();
            Vehicle::create(array_merge($validatedData, ['user_id' => $userId]));
            

            return redirect(route('dashboard'))->with('success','Registro criado com sucesso');
        }
        catch (ValidationException $e) {
            return redirect(route('dashboard'))->with('fail','Falha na validação dos dados' . $e->getMessage());
        }
        catch (ValidationException $e) {
            return redirect(route('dashboard'))->with('fail','Falha no registros dos dados' . $e->getMessage());
        }
    }
}
