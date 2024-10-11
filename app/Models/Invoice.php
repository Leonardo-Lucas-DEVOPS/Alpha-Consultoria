<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'cost_employee',
        'cost_freelancer',
        'cost_vehicle'
    ];

    // Definir relacionamento com o usuário, se necessário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
