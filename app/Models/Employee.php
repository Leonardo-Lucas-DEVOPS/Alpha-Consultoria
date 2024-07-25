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
        'user_id',
        'return_status',
    ];

    // Definir relacionamento com o usuário, se necessário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
