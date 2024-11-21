<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolsTransaction extends Model
{
    use HasFactory;

    protected $table = 'tools_transaction';

    protected $appends = ['badgeClass'];

    protected $fillable = [
        'tools_id',
        'user_id',
        'type',
        'from',
        'to',
        'quantity',
        'location',
        'activity',
        'transaction_date',
        'notes',
    ];

    public function tools()
    {
        return $this->belongsTo(Tools::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBadgeClassAttribute()
    {
        $statusColor = [
            'In' => 'secondary',
            'Out' => 'danger',
            'Return' => 'success',
            'Transfer' => 'primary',
        ];

        // Berikan warna default jika status tidak ditemukan
        return $statusColor[$this->type] ?? 'secondary';
    }
}
