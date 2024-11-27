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
        'year',
        'license_plate',
        'tax_year',
        'tax_five_years',
        'inspected',
        'purchase_date',
        'purchase_price',
        'status',
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

    public function assignments()
    {
        return $this->belongsTo(VehicleAssignment::class, 'id');
    }

    public function maintenanceRecords()
    {
        return $this->hasMany(VehicleMaintenance::class, 'id');
    }

    public function insurancePolicies()
    {
        return $this->belongsTo(VehicleInsurance::class, 'id');
    }
}
