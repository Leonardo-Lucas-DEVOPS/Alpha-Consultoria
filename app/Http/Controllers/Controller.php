<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

abstract class Controller
{
    public function updateStatusForModel($model)
    {
        // Busca todos os registros criados há mais de 3 meses
        $records = $model::where('updated_at', '<=', now()->subMonths(6))
            ->where('return_status', '!=', 'Em Análise') // Evita alterar se já estiver "Em Análise"
            ->get();

        // Atualiza o status de consulta para "Em Analise"
        foreach ($records as $record) {
            $record->return_status = 'Em Análise';
            $record->save();
        }
    }
    public function filterConsults($model)
    {
        // Lista de faturas responsáveis do usuário logado
        $allInvoicesPerUser = Invoice::where('user_id', Auth::user()->id)->pluck('id');

        // Agora, buscamos todas as consultas da model que pertencem à todas as faturas da lista $allInvoicesPerUser
        return $model::whereIn('invoice_id', $allInvoicesPerUser)->orderBy('created_at', 'desc')->paginate(5);
    }

    public function filterAudit($model)
    {
        // Lista de faturas responsáveis do usuário logado
        $allInvoicesPerUser = Invoice::where('user_id',  Auth::user()->id)->pluck('id');

        // Agora, buscamos todas as consultas da model que pertencem à todas as faturas da lista $allInvoicesPerUser
        return $model::whereIn('OldInvoice_id', $allInvoicesPerUser)->orderBy('created_at', 'desc')->paginate(3);
    }

    public function invoicesPerCompany()
    {
        return User::leftJoin('invoices', 'users.id', '=', 'invoices.user_id')
            ->select(
                'users.name',
                'invoices.id',
                DB::raw('COUNT(DISTINCT invoices.id) AS NumberInvoices')
            )
            ->where('users.id', '=', Auth::user()->id)
            ->groupBy('invoices.id', 'users.name')
            ->orderBy('invoices.created_at', 'desc')
            ->first();
    }

    public function invoicesPerDate()
    {
        return User::leftJoin('invoices', 'users.id', '=', 'invoices.user_id')
            ->select(
                DB::raw('DATE_ADD(invoices.created_at, INTERVAL 30 DAY) AS InvoiceDate'),
                'invoices.created_at'
            )
            ->where('users.id', '=', Auth::user()->id)
            ->orderBy('invoices.created_at', 'desc')
            ->first();
    }

    public function consultsPerCompany($id = null)
    {
        $company = User::leftJoin('invoices', 'users.id', '=', 'invoices.user_id')
            ->leftJoin('employees', 'invoices.id', '=', 'employees.invoice_id')
            ->leftJoin('freelancers', 'invoices.id', '=', 'freelancers.invoice_id')
            ->leftJoin('vehicles', 'invoices.id', '=', 'vehicles.invoice_id')
            ->select(
                'users.name AS Company',
                'invoices.id',
                'invoices.created_at AS InvoiceMonth',
                'invoices.cost_employee',
                'invoices.cost_freelancer',
                'invoices.cost_vehicle',
                'invoices.price AS Price',
                DB::raw('COUNT(DISTINCT employees.id) AS Employees'),
                DB::raw('COUNT(DISTINCT freelancers.id) AS Freelancers'),
                DB::raw('COUNT(DISTINCT vehicles.id) AS Vehicles')
            )
            ->groupBy('users.name', 'invoices.id', 'invoices.created_at', 'invoices.cost_employee', 'invoices.cost_freelancer', 'invoices.cost_vehicle', 'invoices.price')
            ->orderBy('users.created_at', 'desc');

        if ($id) {
            $company->where('users.id', $id);
        }

        if (Auth::check() && Auth::user()->usertype == 2) {
            $company->where('users.id', Auth::user()->id);
        } else {
            $company->where('users.usertype', '2');
        }

        return $company->paginate(5);
    }
}
