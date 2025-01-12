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
        'project_name',
        'document_date',
        'bid_date',
    ];

    public function vendors()
    {
        return $this->hasMany(CostBidsVendor::class, 'cost_bids_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(CostBidsItems::class, 'cost_bids_id', 'id');
    }
}
