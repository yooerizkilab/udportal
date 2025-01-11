<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostBidsAnalysis extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cost_bids_analysis';

    protected $fillable = [
        'cost_bids_id',
        'selected_vendor_id',
        'total_price',
        'discount_percentage',
        'discount_amount',
        'total_after_discount',
        'terms_of_payment',
        'lead_time',
        'notes',
    ];

    public function costBids()
    {
        return $this->belongsTo(CostBids::class, 'cost_bids_id', 'id');
    }

    public function costBidsVendor()
    {
        return $this->belongsTo(CostBidsVendor::class, 'selected_vendor_id', 'id');
    }
}
