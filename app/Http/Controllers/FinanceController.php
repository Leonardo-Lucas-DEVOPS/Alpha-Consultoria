<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf;

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
                'valueEmployee.*' => 'required|numeric',
                'valueFreelancer.*' => 'required|numeric',
                'valueVehicle.*' => 'required|numeric',
            ]);

            // Pegando as empresas
            $companies = $this->consultsPerCompany();

            foreach ($companies as $company) {
                $valueEmployee = $request->input("valueEmployee.{$company->id}", $company->cost_Employee);
                $valueFreelancer = $request->input("valueFreelancer.{$company->id}", $company->cost_Freelancer);
                $valueVehicle = $request->input("valueVehicle.{$company->id}", $company->cost_Vehicle);

                // Calcula o total com base nos valores capturados
                $totalEmployees = $valueEmployee * $company->Employees;
                $totalFreelancers = $valueFreelancer * $company->Freelancers;
                $totalVehicles = $valueVehicle * $company->Vehicles;

                // Atualiza o preço total
                $price = $totalEmployees + $totalFreelancers + $totalVehicles;

                // Atualiza a tabela
                DB::table('users')
                    ->where('id', $company->id)
                    ->update([
                        'cost_Employee' => $valueEmployee,
                        'cost_Freelancer' => $valueFreelancer,
                        'cost_Vehicle' => $valueVehicle,
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
                'data' => $invoice->created_at,
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
