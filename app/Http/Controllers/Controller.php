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
        // Lista de IDs dos usuários com o mesmo cnpj do usuário logado
        $allUserIds = Invoice::where('user_cpf',  Auth::user()->cpf_cnpj)->pluck('id');

        // Agora, buscamos todas as consultas da model que pertencem aos IDs da lista $allUserIds
        return $model::whereIn('invoice_id', $allUserIds)->orderBy('created_at', 'desc')->paginate(5);
    }

    public function filterAudit($model)
    {
        // Lista de IDs dos usuários com o mesmo cnpj do usuário logado
        $allUserIds = Invoice::where('user_cpf',  Auth::user()->cpf_cnpj)->pluck('id');

        // Agora, buscamos todas as consultas da model que pertencem aos IDs da lista $allUserIds
        return $model::whereIn('OldInvoice_id', $allUserIds)->orderBy('created_at', 'desc')->paginate(3);
    }

    public function invoicesPerCompany()
    {
        $allUserIds = User::where('cpf_cnpj', Auth::user()->cpf_cnpj)->pluck('id');

        return User::leftJoin('invoices', 'users.cpf_cnpj', '=', 'invoices.user_cpf')
            ->select(
                'users.name',
                'invoices.id',
                DB::raw('COUNT(DISTINCT invoices.id) AS NumberInvoices')
            )
            ->whereIn('users.id', $allUserIds)
            ->groupBy('users.name', 'invoices.id', 'users.cpf_cnpj')
            ->orderBy('invoices.created_at', 'desc')
            ->first();
    }

    public function invoicesPerDate()
    {
        $allUserIds = User::where('cpf_cnpj', Auth::user()->cpf_cnpj)->pluck('id');

        return User::leftJoin('invoices', 'users.cpf_cnpj', '=', 'invoices.user_cpf')
            ->select(
                DB::raw('DATE_ADD(invoices.created_at, INTERVAL 30 DAY) AS InvoiceDate')
            )
            ->whereIn('users.id', $allUserIds)
            ->orderBy('invoices.created_at', 'desc')
            ->first();
    }

    public function consultsPerCompany($id = null)
    {
        $allUserIds = User::where('cpf_cnpj', Auth::user()->cpf_cnpj)->pluck('id');

        $invoices = User::leftJoin('invoices', 'users.cpf_cnpj', '=', 'invoices.user_cpf')
            ->leftJoin('employees', 'invoices.id', '=', 'employees.invoice_id')
            ->leftJoin('freelancers', 'invoices.id', '=', 'freelancers.invoice_id')
            ->leftJoin('vehicles', 'invoices.id', '=', 'vehicles.invoice_id')
            ->select(
                'users.name AS Company',
                'invoices.id',
                DB::raw('
                    DATE_FORMAT(
                        DATE_ADD(invoices.created_at, INTERVAL CASE WHEN invoices.id = (
                            SELECT MIN(invoices.id) FROM invoices WHERE invoices.user_id = users.id
                        ) THEN 35 ELSE 30 END DAY),
                        "%d/%m/%Y"
                    ) AS InvoiceDue
                '),
                'invoices.cost_employee',
                'invoices.cost_freelancer',
                'invoices.cost_vehicle',
                'invoices.price AS Price',
                'invoices.status',
                DB::raw('COUNT(DISTINCT employees.id) AS Employees'),
                DB::raw('COUNT(DISTINCT freelancers.id) AS Freelancers'),
                DB::raw('COUNT(DISTINCT vehicles.id) AS Vehicles')
            )
            ->where('users.usertype', 2)
            ->groupBy(
                'users.id',
                'users.name',
                'invoices.id',
                'invoices.created_at',
                'invoices.cost_employee',
                'invoices.cost_freelancer',
                'invoices.cost_vehicle',
                'invoices.price',
                'invoices.status'
            )
            ->orderBy('users.created_at', 'desc');

        if ($id) {
            $invoices->where('invoices.id', $id);
        }

        if (Auth::check() && Auth::user()->usertype == 2) {
            $invoices->whereIn('invoices.user_id', $allUserIds);
            $invoices->whereRaw("
                DATE_ADD(
                    invoices.created_at,
                    INTERVAL CASE
                        WHEN invoices.id = (
                            SELECT MIN(i.id)
                            FROM invoices AS i
                            WHERE i.user_id = invoices.user_id
                        ) THEN 30
                        ELSE 25
                    END DAY
                ) <= NOW()
            ");
        } else {
            $invoices->where('invoices.status', '!=', 'Pago');
        }

        return $invoices->paginate(5);
    }
}
