<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'vehicle';

    protected $appends = ['badgeClass'];

    protected $fillable = [
        'owner_id',
        'type_id',
        'code',
        'brand',
        'model',
        'color',
        'transmission',
        'fuel',
        'year',
        'license_plate',
        'tax_year',
        'tax_five_year',
        'inspected',
        'purchase_date',
        'purchase_price',
        'status',
        'description',
        'origin',
        'photo',
    ];

    public function getBadgeClassAttribute()
    {
        $statusColor = [
            'Active' => 'success',
            'Maintenance' => 'warning',
            'Inactive' => 'danger',
        ];

        // Berikan warna default jika status tidak ditemukan
        return $statusColor[$this->status] ?? 'secondary';
    }

    public function type()
    {
        return $this->belongsTo(VehicleType::class, 'type_id');
    }

    public function ownership()
    {
        return $this->belongsTo(VehicleOwnership::class, 'owner_id', 'id');
    }

    public function assigned()
    {
        return $this->hasOneThrough(Employe::class, VehicleAssignment::class, 'vehicle_id', 'id', 'id', 'user_id')->latest('vehicle_assignment.created_at');
        // return $this->hasManyThrough(Employe::class, VehicleAssignment::class, 'vehicle_id', 'id', 'id', 'user_id');
    }

    // public function getAssignedEmployeAttribute()
    // {
    //     return $this->assigned()->orderBy('assignment_date', 'desc')->first();
    // }

    public function maintenanceRecords()
    {
        return $this->hasMany(VehicleMaintenance::class, 'id');
    }

    public function insurancePolicies()
    {
        return $this->belongsTo(VehicleInsurance::class, 'id');
    }
}
