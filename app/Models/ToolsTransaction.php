<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolsTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tools_transaction';

    protected $appends = ['badgeClass'];

    protected $fillable = [
        'tools_id',
        'user_id',
        'code',
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

    public function employee()
    {
        return $this->hasOneThrough(
            Employe::class,
            User::class,
            'id',         // Foreign key di tabel User
            'user_id',    // Foreign key di tabel Employee
            'user_id',    // Local key di tabel ToolTransaction
            'id'          // Local key di tabel User
        );
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
