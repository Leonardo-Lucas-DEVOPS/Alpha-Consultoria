<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\AuditVehicle;
use App\Models\Freelancer;
use App\Models\AuditFreelancer;
use App\Models\Employee;
use App\Models\AuditEmployee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
        $allUserIds = User::where('cpf_cnpj',  Auth::user()->cpf_cnpj)->pluck('id');
        // Agora, buscamos todas as consultas da model que pertencem aos IDs da lista $allUserIds
        return $model::whereIn('user_id', $allUserIds)->orderBy('created_at', 'desc')->paginate(5);
    }

    public function filterAudit($model)
    {
        // Lista de IDs dos usuários com o mesmo cnpj do usuário logado
        $allUserIds = User::where('cpf_cnpj',  Auth::user()->cpf_cnpj)->pluck('id');
        // Agora, buscamos todas as consultas da model que pertencem aos IDs da lista $allUserIds
        return $model::whereIn('OldUser_id', $allUserIds)->orderBy('created_at', 'desc')->paginate(3);
    }
}
