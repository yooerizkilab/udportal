<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleOwnership extends Model
{
    use HasFactory;

    protected $table = 'vehicle_ownership';

    protected $fillable = [
        'owner',
        'purchase_date',
        'purchase_price',
    ];
}
