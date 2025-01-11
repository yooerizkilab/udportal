<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostBidsVendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cost_bids_vendor';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
    ];

    public function costInventory()
    {
        return $this->belongsTo(CostBidsInventoryVendor::class, 'id', 'cost_bids_vendor_id');
    }

    public function costAnalysis()
    {
        return $this->belongsTo(CostBidsAnalysis::class, 'id', 'selected_vendor_id');
    }
}
