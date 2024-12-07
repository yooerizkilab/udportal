<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tools extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tools';

    protected $appends = ['badge', 'badgeClass'];

    protected $fillable = [
        'owner_id',
        'categorie_id',
        'code',
        'serial_number',
        'name',
        'brand',
        'type',
        'model',
        'year',
        'origin',
        'quantity',
        'unit',
        'condition',
        'status',
        'description',
        'purchase_date',
        'purchase_price',
        'warranty',
        'warranty_start',
        'warranty_end',
        'photo',
    ];

    public function getBadgeAttribute()
    {
        $statusColor = [
            'New' => 'success',
            'Used' => 'primary',
            'Broken' => 'danger'
        ];

        return $statusColor[$this->condition] ?? 'secondary';
    }

    public function getBadgeClassAttribute()
    {
        $statusColor = [
            'Maintenance' => 'danger',
            'Active' => 'success',
            'Inactive' => 'secondary',
        ];

        return $statusColor[$this->status] ?? 'secondary';
    }

    public function categorie()
    {
        return $this->belongsTo(ToolsCategorie::class);
    }

    public function owner()
    {
        return $this->belongsTo(ToolsOwners::class);
    }
}
