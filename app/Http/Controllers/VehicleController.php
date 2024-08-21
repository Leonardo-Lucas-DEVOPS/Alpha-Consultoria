<?php

namespace App\Http\Controllers;

use App\Models\AuditVehicle;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class VehicleController extends Controller
{
    public function create()
    {
        return view('vehicle.create-vehicle', ['vehicle' => null]);
    }
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'chassi' => 'required|unique:vehicles,chassi',
                'renavam' => 'required|unique:vehicles,renavam',
                'placa' => [
                    'required',
                    'string',
                    Rule::unique('freelancers'),
                    Rule::unique('vehicles'),
                ],
            ]);

            $validatedData['placa'] = preg_replace('/[^a-zA-Z0-9]/', '', $validatedData['placa']);
            $validatedData['renavam'] = preg_replace('/[^a-zA-Z0-9]/', '', $validatedData['renavam']);
            $validatedData['chassi'] = preg_replace('/[^a-zA-Z0-9]/', '', $validatedData['chassi']);

            $userId = Auth::id();
            Vehicle::create(array_merge($validatedData, ['user_id' => $userId]));

            return redirect(route('dashboard'))->with('success', 'Registro criado com sucesso');
        } catch (ValidationException $e) {
            return redirect(route('dashboard'))
                ->with('fail', 'Falha na validação dos dados: ' . $e->getMessage());
        }
    }

    public function show(Vehicle $vehicle)
    {
        $vehicles = Vehicle::orderBy('created_at', 'desc')->paginate(5);
        $olddatas = AuditVehicle::orderBy('created_at', 'desc')->paginate(3);

        return view('vehicle.show-vehicle', compact('vehicles', 'olddatas'));
    }

    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        if ($vehicle->return_status != 'Em análise') {
            return redirect(route('dashboard'))->with('fail', 'Uma consulta já finalizada não poderá mais ser alterada, agende uma nova');
        }

        return view('Vehicle.create-vehicle', compact('vehicle'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'chassi' => 'required|unique:vehicles,chassi,' . $id,
                'renavam' => 'required|unique:vehicles,renavam,' . $id,
                'placa' => [
                    'required',
                    'string',
                    Rule::unique('freelancers')->ignore($id),
                    Rule::unique('vehicles')->ignore($id),
                ],
            ]);

            $vehicle = Vehicle::findOrFail($id);

            // Criação de uma auditoria antes de atualizar os dados
            AuditVehicle::create([
                'vehicle_id' => $vehicle->id,
                'OldChassi' => $vehicle->chassi,
                'OldRenavam' => $vehicle->renavam,
                'OldPlaca' => $vehicle->placa,
                'OldUser_id' => $vehicle->user_id,
                'OldReturn_status' => $vehicle->return_status,
            ]);
            $vehicle->chassi = preg_replace('/[^a-zA-Z0-9]/', '', $request->input('chassi'));
            $vehicle->placa = preg_replace('/[^a-zA-Z0-9]/', '', $request->input('placa'));
            $vehicle->renavam = preg_replace('/[^a-zA-Z0-9]/', '', $request->input('renavam'));
            $vehicle->return_status = 'Em análise';
          
            $vehicle->user_id = Auth::id();

            $vehicle->save();

            return redirect(route('dashboard'))->with('success', 'Registro atualizado com sucesso');
        } catch (ValidationException $e) {
            return redirect(route('dashboard'))
                ->with('fail', 'Falha na validação dos dados: ' . $e->getMessage());
        }
    }

    public function accept(string $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        try {
            $vehicle->return_status = "Aprovado";
            $vehicle->save();
            return redirect(route('dashboard'))
                ->with('success', 'Veículo aprovado.');
        } catch (ValidationException $e) {
            return redirect(route('dashboard'))
                ->with('fail', 'Falha na validação dos dados: ' . $e->getMessage());
        }
        $vehicle->save();
    }

    public function reject(string $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        try {
            $vehicle->return_status = "Recusado";
            $vehicle->save();
            return redirect(route('dashboard'))
                ->with('fail', 'Veículo recusado');
        } catch (ValidationException $e) {
            return redirect(route('dashboard'))
                ->with('fail', 'Falha na validação dos dados: ' . $e->getMessage());
        }
        $vehicle->save();
    }

    public function destroy(string $id)
    {
        // Verifica se o usuário tem permissão para deletar (usertype 2 ou 3)
        if (Auth::user()->usertype >= 2) {
            try {
                $vehicle = Vehicle::findOrFail($id);

                if ($vehicle->return_status != ANALISE && Auth::user()->usertype == 2) {

                    return redirect(route('dashboard'))
                        ->with('fail', 'Consultas completas não podem ser excluídas.');
                }
                Vehicle::destroy($id);
                return redirect(route('dashboard'))
                    ->with('success', 'Registro deletado com sucesso');
            } catch (ValidationException $e) {
                // Armazena os dados na sessão para depuração
                return redirect(route('dashboard'))
                    ->with('fail', 'Falha na validação dos dados: ' . $e->getMessage());
            }
        } else {
            return redirect(route('dashboard'))->with('fail', 'Você não tem permissão para deletar este registro.');
        }
    }
}