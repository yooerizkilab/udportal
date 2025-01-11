<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostBidsInventoryVendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cost_bids_inventory_vendor';

    protected $fillable = [
        'cost_bids_id',
        'cost_bids_vendor_id',
        'cost_bids_inventory_id',
        'price_per_unit',
        'sub_total',
    ];

    public function costBidsInventory()
    {
        return $this->hasMany(CostBidsInventory::class, 'cost_bids_inventory_id', 'id');
    }

    public function costBidsVendor()
    {
        return $this->belongsTo(CostBidsVendor::class, 'cost_bids_vendor_id', 'id');
    }

    public function costBids()
    {
        return $this->belongsTo(CostBids::class, 'cost_bids_id', 'id');
    }
}
