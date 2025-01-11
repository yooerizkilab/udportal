<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostBidsInventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cost_bids_inventory';

    protected $fillable = [
        'name',
        'quantity',
        'uom',
    ];

    public function costBidsInventoryVendor()
    {
        return $this->belongsTo(CostBidsInventoryVendor::class, 'id', 'cost_bids_inventory_id');
    }
}
