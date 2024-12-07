<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'branch';

    protected $fillable = [
        'code',
        'name',
        'type',
        'address',
        'phone',
        'status',
        'description',
        'photo'
    ];
}
