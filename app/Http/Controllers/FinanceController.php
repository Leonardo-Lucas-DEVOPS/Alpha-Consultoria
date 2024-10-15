<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf;

define('VALIDACAO_INPUT', 'required|numeric');

class FinanceController extends Controller
{
    public function show(Request $request)
    {
        $companies = $this->consultsPerCompany();
        return view('finance.show-finance', compact('companies'));
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'valueEmployee.*' => VALIDACAO_INPUT,
                'valueFreelancer.*' => VALIDACAO_INPUT,
                'valueVehicle.*' => VALIDACAO_INPUT,
            ]);

            // // Pegando as empresas
            $companies = $this->consultsPerCompany();

            foreach ($companies as $company) {
                $valueEmployee = $request->input("valueEmployee.{$company->id}", $company->cost_employee);
                $valueFreelancer = $request->input("valueFreelancer.{$company->id}", $company->cost_freelancer);
                $valueVehicle = $request->input("valueVehicle.{$company->id}", $company->cost_vehicle);

                // Calcula o total com base nos valores capturados
                $totalEmployees = $valueEmployee * $company->Employees;
                $totalFreelancers = $valueFreelancer * $company->Freelancers;
                $totalVehicles = $valueVehicle * $company->Vehicles;

                // Atualiza o preço total
                $price = $totalEmployees + $totalFreelancers + $totalVehicles;

                // Atualiza a tabela
                DB::table('invoices')
                    ->where('id', $company->id)
                    ->update([
                        'cost_employee' => $valueEmployee,
                        'cost_freelancer' => $valueFreelancer,
                        'cost_vehicle' => $valueVehicle,
                        'price' => $price,
                    ]);
            }

            return redirect(route('finance.show'))->with('success', 'Preços estabelecidos com sucesso');
        } catch (ValidationException $e) {
            return redirect(route('finance.show'))->with('fail', 'Falha ao atualizar os preços: ' . $e->getMessage());
        }
    }

    public function generateInvoice(string $id)
    {
        try {
            $invoice = User::findOrFail($id);

            $invoices = [
                'id' => $invoice->id,
                'generation_date' => $invoice->created_at->format('d/m/Y'),
                'due_date' => $invoice->created_at->format('d/m/Y')->addDays(30),
                'company' => $invoice->name,
                'email' => $invoice->email,
                'phone' => $invoice->phone,
                'address' => $invoice->address,
            ];

            $company = $this->consultsPerCompany($id)->first();

            if (!$company) {
                return redirect(route('finance.show'))->with('fail', 'Empresa não encontrada');
            }

            $pdf = Pdf::loadView('finance.partials.finance-pdf', compact('invoices', 'company'));
            return $pdf->stream('fatura.pdf');
        } catch (ValidationException $e) {
            return redirect(route('finance.show'))->with('fail', 'Empresa não encontrada: ' . $e->getMessage());
        }
    }
}
