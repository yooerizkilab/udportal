<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleAssignment extends Model
{
    use HasFactory;

    protected $table = 'vehicle_assignment';

    protected $fillable = [
        'vehicle_id',
        'user_id',
        'code',
        'assignment_date',
        'return_date',
        'notes'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }
}
