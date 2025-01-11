<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostBids extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cost_bids';

    protected $fillable = [
        'code',
        'document_date',
        'for_company',
    ];

    public function costBidsInventoryVendor()
    {
        return $this->hasMany(CostBidsInventoryVendor::class, 'cost_bids_id', 'id');
    }

    public function costBidsAnalysis()
    {
        return $this->hasMany(CostBidsAnalysis::class, 'cost_bids_id', 'id');
    }
}
