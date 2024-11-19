<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rg',
        'cpf',
        'nascimento',
        'pai',
        'mae',
        'invoice_id',
        'invoice_cpf',
        'return_status',
    ];

    // Definir relacionamento com a fatura, se necessário
    public function user()
    {
        return $this->belongsTo(Invoice::class);
    }
}
