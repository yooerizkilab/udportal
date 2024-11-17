<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branch';

    protected $fillable = [
        'code_branch',
        'name_branch',
        'address',
        'phone',
        'status',
        'description',
        'photo'
    ];
}
