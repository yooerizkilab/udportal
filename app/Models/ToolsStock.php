<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolsStock extends Model
{
    use HasFactory;

    protected $table = 'tools_stock';

    protected $fillable = [
        'tools_id',
        'quantity',
        'unit',
    ];

    public function tools()
    {
        return $this->belongsTo(Tools::class);
    }
}
