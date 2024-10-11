<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditEmployee extends Model
{
    use HasFactory;
    
    protected  $fillable = [
        'OldName',
        'OldRg',
        'OldCpf',
        'OldNascimento',
        'OldPai',
        'OldMae',
        'OldInvoice_id',
        'employee_id',
        'OldReturn_status',
    ];
}
