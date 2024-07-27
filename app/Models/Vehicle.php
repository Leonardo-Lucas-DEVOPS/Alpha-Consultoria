<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    
    protected $fillable =[
        'placa',
        'chassi',
        'renavam',
        'user_id',
        'return_status',
    ];
}
