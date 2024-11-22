<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditVehicle extends Model
{
    use HasFactory;

    protected  $fillable = [
        'OldPlaca',
        'OldChassi',
        'OldRenavam',
        'OldInvoice_id',
        'OldInvoice_cpfcnpj',
        'vehicle_id',
        'OldReturn_status',
    ];
}
