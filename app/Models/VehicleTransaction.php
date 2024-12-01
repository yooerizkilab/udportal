<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleTransaction extends Model
{
    use HasFactory;

    protected $table = 'vehicle_transaction';

    protected $fillable = [
        'vehicle_id',
        'user_id',
        'code',
        'type',
        'from',
        'to',
        'transaction_date',
        'return_date',
        'notes',
        'created_at',
        'updated_at'
    ];
}
