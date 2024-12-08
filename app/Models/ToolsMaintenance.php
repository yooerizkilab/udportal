<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolsMaintenance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tools_maintenance';

    protected $append = ['badgeClass'];

    protected $fillable = [
        'tools_id',
        'code',
        'maintenance_date',
        'cost',
        'completion_date',
        'status',
        'description',
    ];

    public function getBadgeClassAttribute()
    {

        $colorText = [
            'Completed' => 'success',
            'Pending' => 'warning',
            'In Progress' => 'info',
            'Cancelled' => 'danger',
        ];

        return $colorText[$this->status] ?? 'info';
    }

    public function tools()
    {
        return $this->belongsTo(Tools::class);
    }
}
