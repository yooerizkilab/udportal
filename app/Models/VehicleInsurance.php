<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleInsurance extends Model
{
    use HasFactory;

    protected $table = 'vehicle_insurance_policie';

    protected $appends = ['status'];

    protected $fillable = [
        'vehicle_id',
        'policy_number',
        'coverage_start',
        'coverage_end',
        'premium',
        'insurance_provider'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function getStatusAttribute()
    {
        return $this->coverage_end > now() ? 'Active' : 'Expired';
    }
}
