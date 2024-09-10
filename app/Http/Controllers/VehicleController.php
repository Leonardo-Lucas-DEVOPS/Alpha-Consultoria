<?php

namespace App\Http\Controllers;

use App\Models\AuditVehicle;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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
        // Atualiza o status dos veículos com mais de 3 meses 
        $this->updateStatusForModel(Vehicle::class);

        // Filtrar os veículos que pertencem à empresa do usuário logado
        $vehicles = Vehicle::where('cpf_cnpj', Auth::user()->cpf_cnpj)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        // Filtrar os dados de auditoria de veículos pertencentes à mesma empresa
        $olddatas = AuditVehicle::where('cpf_cnpj', Auth::user()->cpf_cnpj)
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        // Retornar a view com os veículos e dados de auditoria filtrados
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

            // Atualiza os dados do veículo
            $vehicle->chassi = preg_replace('/[^a-zA-Z0-9]/', '', $request->input('chassi'));
            $vehicle->placa = preg_replace('/[^a-zA-Z0-9]/', '', $request->input('placa'));
            $vehicle->renavam = preg_replace('/[^a-zA-Z0-9]/', '', $request->input('renavam'));
            $vehicle->return_status = 'Em análise';
            $vehicle->user_id = Auth::id();

            $vehicle->save();

            return redirect(route('dashboard'))->with('success', 'Registro atualizado com sucesso');
        } catch (ValidationException $e) {
            return redirect(route('dashboard'))
                ->with('fail', 'Falha na atualização dos dados: ' . $e->getMessage());
        }
    }

    public function accept(string $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        try {
            $vehicle->return_status = "Aprovado";
            $vehicle->save();
            return redirect(route('vehicle.show'))
                ->with('success', 'Registro aprovado.');
        } catch (ValidationException $e) {
            return redirect(route('dashboard'))
                ->with('fail', 'Falha na aprovação dos dados: ' . $e->getMessage());
        }
    }

    public function reject(string $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        try {
            $vehicle->return_status = "Rejeitado";
            $vehicle->save();
            return redirect(route('vehicle.show'))
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
                $vehicle = Vehicle::findOrFail($id);

                if ($vehicle->return_status != 'Em análise' && Auth::user()->usertype == 2) {

                    return redirect(route('dashboard'))
                        ->with('fail', 'Consultas completas não podem ser excluídas.');
                }
                Vehicle::destroy($id);
                return redirect(route('vehicle.show'))
                    ->with('success', 'Registro deletado com sucesso');
            } catch (ValidationException $e) {
                // Armazena os dados na sessão para depuração
                return redirect(route('dashboard'))
                    ->with('fail', 'Falha na exclusão dos dados: ' . $e->getMessage());
            }
        } else {
            return redirect(route('dashboard'))->with('fail', 'Você não tem permissão para deletar este registro.');
        }
    }
}
