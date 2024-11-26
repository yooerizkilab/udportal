<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleAssignment extends Model
{
    use HasFactory;

    protected $table = 'vehicle_assignment';

    protected $fillable = [
        'user_id',
        'assignment_date',
        'return_date',
    ];
}
