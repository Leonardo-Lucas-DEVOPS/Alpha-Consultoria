<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;
    protected  $fillable = [

        'OldName',
        'OldRg',
        'OldCpf',
        'OldNascimento',
        'OldPai',
        'OldMae',
        'OldCnh',
        'OldPlaca',
        'OldChassi',
        'OldRenavam',
        'OldUser_id',
        'employee_id',
        'freelancer_id',
        'vehicle_id',
        'OldReturn_status',
        
    ];
}
