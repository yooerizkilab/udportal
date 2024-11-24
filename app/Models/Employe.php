<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'employe';

    protected $fillable = [
        'user_id',
        'company_id',
        'department_id',
        'code',
        'nik',
        'full_name',
        'gender',
        'phone',
        'address',
        'position',
        'age',
        'status',
        'photo',
    ];
}
