<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolsTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tools_transactions';

    protected $appends = ['badgeClass'];

    protected $fillable = [
        'user_id',
        'tool_id',
        'source_project_id',
        'destination_project_id',
        'document_code',
        'document_date',
        'delivery_date',
        'quantity',
        'unit',
        'driver',
        'driver_phone',
        'plate_number',
        'last_location',
        'type',
        'notes',
    ];

    public function tools()
    {
        return $this->belongsTo(Tools::class, 'tool_id', 'id');
    }

    public function sourceTransactions()
    {
        return $this->belongsTo(Projects::class, 'source_project_id', 'id');
    }

    public function destinationTransactions()
    {
        return $this->belongsTo(Projects::class, 'destination_project_id', 'id');
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
            'Return' => 'secondary',
            'Delivery Note' => 'success',
            'Transfer' => 'primary',
        ];

        // Berikan warna default jika status tidak ditemukan
        return $statusColor[$this->type] ?? 'success';
    }
}
