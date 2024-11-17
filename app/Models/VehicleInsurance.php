<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleInsurance extends Model
{
    use HasFactory;

    protected $table = 'vehicle_insurance_policie';

    protected $fillable = [
        'insurance_provider	',
        'policy_number',
        'coverage_start',
        'coverage_end',
        'premium',
    ];
}
