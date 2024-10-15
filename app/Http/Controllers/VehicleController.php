<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Vehicle;
use App\Models\AuditVehicle;
use Illuminate\Validation\ValidationException;

define('FORMATACAO', '/[^a-zA-Z0-9]/');
define('EM_ANALISE', 'Em análise');

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

            $validatedData['placa'] = preg_replace(FORMATACAO, '', $validatedData['placa']);
            $validatedData['renavam'] = preg_replace(FORMATACAO, '', $validatedData['renavam']);
            $validatedData['chassi'] = preg_replace(FORMATACAO, '', $validatedData['chassi']);

            $userId = Auth::id();

            $companyInvoice = $this->invoicesPerCompany();
            $invoiceData = $this->invoicesPerDate();

            if (!$companyInvoice || $companyInvoice->NumberInvoices == 0 || Carbon::parse($invoiceData->InvoiceDate)->isPast()) {
                $invoice = Invoice::create([
                    'user_id' => $userId,
                    'status' => 'Pendente',
                    'cost_employee' => 0,
                    'cost_freelancer' => 0,
                    'cost_vehicle' => 0,
                    'price' => 0
                ]);
            } else {
                $invoice = $companyInvoice;
            }

            Vehicle::create(array_merge($validatedData, ['invoice_id' => $invoice->id]));

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

        if (Auth::user()->usertype == 3) {
            $vehicles = Vehicle::orderBy('created_at', 'desc')->paginate(5);
            $olddatas = AuditVehicle::orderBy('created_at', 'desc')->paginate(5);
            return view('vehicle.show-vehicle', compact('vehicles', 'olddatas'));
        }
        // Busca os veículos e dados
        $vehicles = $this->filterConsults(Vehicle::class);
        // Busca os veículos e dados
        $olddatas = $this->filterAudit(AuditVehicle::class);
        // Retornar a view com os veículos e dados de auditoria filtrados
        return view('vehicle.show-vehicle', compact('vehicles', 'olddatas'));
    }

    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        if ($vehicle->return_status != EM_ANALISE) {
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
                'OldInvoice_id' => $vehicle->invoice_id,
                'OldReturn_status' => $vehicle->return_status,
            ]);

            // Atualiza os dados do veículo
            $vehicle->chassi = preg_replace(FORMATACAO, '', $request->input('chassi'));
            $vehicle->placa = preg_replace(FORMATACAO, '', $request->input('placa'));
            $vehicle->renavam = preg_replace(FORMATACAO, '', $request->input('renavam'));
            $vehicle->return_status = EM_ANALISE;

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
            $vehicle = Vehicle::findOrFail($id);

            if ($vehicle->return_status != EM_ANALISE && Auth::user()->usertype == 2) {

                return redirect(route('dashboard'))
                    ->with('fail', 'Consultas completas não podem ser excluídas.');
            }
            Vehicle::destroy($id);
            return redirect(route('vehicle.show'))
                ->with('success', 'Registro deletado com sucesso');
        } else {
            return redirect(route('dashboard'))->with('fail', 'Você não tem permissão para deletar este registro.');
        }
    }
}
