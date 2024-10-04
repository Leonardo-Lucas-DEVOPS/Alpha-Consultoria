<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\ValidationException;

class FinanceController extends Controller
{
    public function show(Request $request)
    {
        $companies = User::join('employees', 'users.id', '=', 'employees.user_id')
            ->join('freelancers', 'users.id', '=', 'freelancers.user_id')
            ->join('vehicles', 'users.id', '=', 'vehicles.user_id')
            ->select(
                'users.id',
                'users.name AS Usuario',
                User::raw('COUNT(DISTINCT employees.id) AS Funcionarios'),
                User::raw('COUNT(DISTINCT freelancers.id) AS Prestadores'),
                User::raw('COUNT(DISTINCT vehicles.id) AS Veiculos'),
                User::raw('COUNT(DISTINCT employees.id) AS ValorFuncionarios')
            )
            ->where('users.usertype', '2')
            ->groupBy('users.id', 'users.name')
            ->orderBy('users.created_at', 'desc')
            ->paginate(5);

        return view('finance.show-finance', compact('companies'));
    }

    public function update(Request $request, $id)
    {
        try {
            $companies = User::findOrFail($id);

            $companies->name = "Nome teste";
            $companies->save();

            return redirect(route('finance.show'))->with('success', 'Preços estabelecidos com sucesso');
        } catch (ValidationException) {
            return redirect(route('finance.show'))->with('fail', 'Falha ao atualizar os preços');
        }
    }

    public function generateInvoice(string $id)
    {
        $invoice = User::findOrFail($id);

        $invoices = [
            'id' => $invoice->id,
            'data' => $invoice->created_at,
            'company' => $invoice->name,
            'email' => $invoice->email,
            'phone' => $invoice->phone,
            'address' => $invoice->address,
        ];

        $companies = User::join('employees', 'users.id', '=', 'employees.user_id')
            ->join('freelancers', 'users.id', '=', 'freelancers.user_id')
            ->join('vehicles', 'users.id', '=', 'vehicles.user_id')
            ->select(
                'users.id',
                'users.name AS Usuario',
                User::raw('COUNT(DISTINCT employees.id) AS Funcionarios'),
                User::raw('COUNT(DISTINCT freelancers.id) AS Prestadores'),
                User::raw('COUNT(DISTINCT vehicles.id) AS Veiculos')
            )
            ->where('users.id', $id)
            ->groupBy('users.id', 'users.name')
            ->orderBy('users.created_at', 'desc')
            ->paginate(5);

        $pdf = Pdf::loadView('finance.partials.finance-pdf', compact('invoices', 'companies'));
        return $pdf->stream('fatura.pdf');
    }
}
