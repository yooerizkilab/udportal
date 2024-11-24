<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

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
