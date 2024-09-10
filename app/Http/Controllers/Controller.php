<?php

namespace App\Http\Controllers;

abstract class Controller
{
    Public function updateStatusForModel($model)
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
}
