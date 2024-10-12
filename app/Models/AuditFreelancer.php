<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditFreelancer extends Model
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
        'OldInvoice_id',
        'freelancer_id',
        'OldReturn_status',
    ];
}
