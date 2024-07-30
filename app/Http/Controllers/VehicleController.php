<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class VehicleController extends Controller
{
    public function create()
    {
        return view('vehicle.vehicle', ['vehicle' => null]);
    }
    public function store(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'placa' => 'required|unique:vehicles,placa',
                'chassi' => 'required|unique:vehicles,chassi',
                'renavam' => 'required|unique:vehicles,renavam',

            ]);

            $validatedData['placa'] = preg_replace('/\D/', '', $validatedData['placa']);
            $validatedData['renavam'] = preg_replace('/\D/', '', $validatedData['renavam']);
            $validatedData['chassi'] = preg_replace('/\D/', '', $validatedData['chassi']);


            $userId = Auth::id();
            Vehicle::create(array_merge($validatedData, ['user_id' => $userId]));


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
    public function show(Vehicle $vehicle)
    {
        $vehicles = Vehicle::paginate(10);
        return view('vehicle.partials.show-vehicle', compact('vehicles'));
    }
    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return view('Vehicle.Vehicle', compact('vehicle'));
    }
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
            
                'chassi' => 'required|unique:vehicles,chassi,' . $id,
                'renavam' => 'required|unique:vehicles,renavam,' . $id,  
                'placa' => 'required|unique:vehicles,placa,' . $id,
            ]);

            $vehicle = Vehicle::findOrFail($id);

            // Atualiza os dados do empregado
            $vehicle->chassi = preg_replace('/\D/', '', $request->input('chassi'));
            $vehicle->placa = preg_replace('/\D/', '', $request->input('placa'));
            $vehicle->renavam = preg_replace('/\D/', '', $request->input('renavam'));
            $vehicle->user_id = Auth::id(); // Ou use outro campo se necessário

            $vehicle->save();

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
                Vehicle::destroy($id);
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
