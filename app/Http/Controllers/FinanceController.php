<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf;

define('FORMATACAO_DATA', 'd/m/Y');
define('VALIDACAO_INPUT', 'required|numeric');

class FinanceController extends Controller
{
    public function show()
    {
        $invoices = $this->consultsPerCompany();

        foreach ($invoices as $invoice) {
            $invoiceGenerationDate = Carbon::createFromFormat(FORMATACAO_DATA, $invoice->InvoiceGeneration);
            $invoiceDueDate = Carbon::createFromFormat(FORMATACAO_DATA, $invoice->InvoiceDue);

            if ($invoice->status != 'Fatura vencida' || ($invoice->status == 'Fatura vencida' && !$invoice->price_updated)) {
                if (!$invoiceGenerationDate->isPast() && !$invoiceDueDate->isPast()) {
                    DB::table('invoices')->where('id', $invoice->id)->update(['status' => 'Fatura aberta']);
                } else if ($invoiceGenerationDate->isPast() && !$invoiceDueDate->isPast()) {
                    DB::table('invoices')->where('id', $invoice->id)->update(['status' => 'Aguardando pagamento']);
                } else if ($invoiceGenerationDate->isPast() && $invoiceDueDate->isPast()) {
                    DB::table('invoices')
                        ->where('status', '!=', 'Fatura vencida')
                        ->whereRaw("DATE_ADD(invoices.created_at, INTERVAL 35 DAY) <= NOW()")
                        ->update([
                            'status' => 'Fatura vencida',
                            'price' => DB::raw('price * 1.10'),
                            'price_updated' => true,
                        ]);
                }
            }
        }

        return view('finance.show-finance', compact('invoices'));
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'valueEmployee.*' => VALIDACAO_INPUT,
                'valueFreelancer.*' => VALIDACAO_INPUT,
                'valueVehicle.*' => VALIDACAO_INPUT,
            ]);

            // Pegando as empresas
            $invoices = $this->consultsPerCompany();

            foreach ($invoices as $invoice) {
                $valueEmployee = $request->input("valueEmployee.{$invoice->id}", $invoice->cost_employee);
                $valueFreelancer = $request->input("valueFreelancer.{$invoice->id}", $invoice->cost_freelancer);
                $valueVehicle = $request->input("valueVehicle.{$invoice->id}", $invoice->cost_vehicle);

                $totalEmployees = $valueEmployee * $invoice->Employees;
                $totalFreelancers = $valueFreelancer * $invoice->Freelancers;
                $totalVehicles = $valueVehicle * $invoice->Vehicles;

                $price = $totalEmployees + $totalFreelancers + $totalVehicles;

                DB::table('invoices')
                    ->where('id', $invoice->id)
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

    public function confirmPayment(string $id)
    {
        try {
            $invoice = Invoice::findOrFail($id);

            $invoice->status = 'Fatura paga';
            $invoice->save();

            return redirect(route('finance.show'))->with('success', 'Pagamento da fatura confirmada com sucesso');
        } catch (ValidationException $e) {
            return redirect(route('finance.show'))->with('fail', 'Falha ao confirmar fatura: ' . $e->getMessage());
        }
    }

    public function generateInvoice(string $id)
    {
        try {
            $invoice = Invoice::findOrFail($id);
            $user = User::findOrFail($invoice->company_id);

            $firstInvoice = Invoice::where('company_id', $user->id)->orderBy('created_at')->first();

            $generationDate = $invoice->created_at;
            $dueDate = $invoice->created_at;

            if ($invoice->id === $firstInvoice->id) {
                $generationDate = $generationDate->addDays(30)->format(FORMATACAO_DATA);
                $dueDate = $dueDate->addDays(35)->format('d/m/y');
            } else {
                $generationDate = $generationDate->addDays(25)->format(FORMATACAO_DATA);
                $dueDate = $dueDate->addDays(30)->format('d/m/Y');
            }

            $invoices = [
                'logo' => public_path('images/logo.png'),
                'id' => $invoice->id,
                'generation_date' => $generationDate,
                'due_date' => $dueDate,
                'status' => $invoice->status,
                'company' => $user->name,
                'cpf_cnpj' => $user->cpf_cnpj,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
                'whatsapp' => public_path('images/whatsapp.png')
            ];

            $consults = $this->consultsPerCompany($id)->first();

            if (!$consults) {
                return redirect(route('finance.show'))->with('fail', 'Empresa não encontrada');
            }

            $pdf = Pdf::loadView('finance.partials.finance-pdf', compact('invoices', 'consults'));
            return $pdf->stream('fatura.pdf');
        } catch (ValidationException $e) {
            return redirect(route('finance.show'))->with('fail', 'Erro ao gerar fatura: ' . $e->getMessage());
        }
    }
}
