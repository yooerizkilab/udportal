<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleReimbursement extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vehicle_reimbursement';

    protected $appends = ['statusName', 'typeName'];

    protected $fillable = [
        'vehicle_id',
        'data_recorded',
        'fuel',
        'amount',
        'price',
        'first_mileage',
        'last_mileage',
        'notes',
        'status',
        'type',
    ];

    public function getStatusNameAttribute()
    {
        $color = [
            'Approved' => 'success',
            'Rejected' => 'danger',
            'Pending' => 'warning',
        ];

        return '<span class="badge badge-' . $color[$this->status] . '">' . $this->status . '</span>';
    }

    public function getTypeNameAttribute()
    {
        $color = [
            'Refueling' => 'success',
            'Parking' => 'secondary',
            'E-Toll' => 'primary',
        ];

        return '<span class="badge badge-' . $color[$this->type] . '">' . $this->type . '</span>';
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
