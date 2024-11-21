<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolsMaintenance extends Model
{
    use HasFactory;

    protected $table = 'tools_maintenance';

    protected $fillable = [
        'tools_id',
        'maintenance_date',
        'status',
        'description',
    ];
}
