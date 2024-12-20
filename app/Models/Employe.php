<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employe extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'employees';

    protected $fillable = [
        'user_id',
        'company_id',
        'branch_id',
        'department_id',
        'code',
        'nik',
        'full_name',
        'gender',
        'age',
        'phone',
        'position',
        'address',
        'status',
        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
