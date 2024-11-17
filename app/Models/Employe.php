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
        'employe_code',
        'nik',
        'full_name',
        'gender',
        'phone',
        'address',
        'position',
        'age',
        'photo',
        'status',
    ];
}
