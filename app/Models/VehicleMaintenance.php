<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleMaintenance extends Model
{
    use HasFactory;

    protected $table = 'vehicle_maintenance_record';

    protected $fillable = [
        'maintenance_date',
        'description',
        'cost',
        'next_maintenance',
    ];
}
