<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'branches';

    protected $appends = ['activeBranch'];

    protected $fillable = [
        'company_id',
        'code',
        'type',
        'name',
        'phone',
        'address',
        'status',
        'description',
        'photo'
    ];

    public function getActiveBranchAttribute()
    {
        $color = [
            'Active' => 'success',
            'Inactive' => 'danger',
        ];

        return '<span class="badge badge-' . $color[$this->status] . '">' . $this->status . '</span>';
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
