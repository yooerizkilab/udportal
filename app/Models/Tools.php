<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tools extends Model
{
    use HasFactory;

    protected $table = 'tools';

    protected $fillable = [
        'owner_id',
        'categorie_id',
        'code',
        'serial_number',
        'name',
        'brand',
        'type',
        'model',
        'year',
        'origin',
        'condition',
        'status',
    ];

    public function categorie()
    {
        return $this->belongsTo(ToolsCategorie::class);
    }

    public function stock()
    {
        return $this->hasOne(ToolsStock::class);
    }
}
