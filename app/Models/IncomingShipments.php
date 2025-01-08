<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomingShipments extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'incoming_shipments';

    protected $appends = ['statusName'];

    protected $fillable = [
        'code',
        'branch_id',
        'supplier_id',
        'item_id',
        'drop_site_id',
        'eta',
        'status',
    ];

    public function getStatusNameAttribute()
    {
        $color = [
            'On Progress' => 'secondary',
            'Approved' => 'primary',
            'Rejected' => 'danger',
            'Received' => 'success',
        ];

        return '<span class="badge badge-' . $color[$this->status] . '">' . $this->status . '</span>';
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(IncomingSupplier::class, 'supplier_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(IncomingInventory::class, 'item_id', 'id');
    }

    public function drop()
    {
        return $this->belongsTo(Warehouses::class, 'drop_site_id', 'id');
    }
}
