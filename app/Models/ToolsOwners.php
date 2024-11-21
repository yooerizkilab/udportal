<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolsOwners extends Model
{
    use HasFactory;

    protected $table = 'tools_ownership';

    protected $fillable = [
        'name',
        'address',
        'phone',
    ];
}
