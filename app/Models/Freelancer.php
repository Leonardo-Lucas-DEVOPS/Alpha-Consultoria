<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freelancer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'rg',
        'cpf',
        'nascimento',
        'pai',
        'mae',
        'placa',
        'cnh',
        'invoice_id',
        'return_status',
    ];
}
