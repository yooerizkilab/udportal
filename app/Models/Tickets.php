<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tickets extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tickets';

    protected $appends = ['badgeClass', 'priorityClass'];

    protected $fillable = [
        'user_id',
        'category_id',
        'assignee_to',
        'fixed_by',
        'code',
        'title',
        'description',
        'solution',
        'attachment',
        'closed_date',
        'priority',
        'status',
    ];

    public function getBadgeClassAttribute()
    {
        // Status Open : primary Status Closed : success Status In Progress : secondary Status Cancelled : danger
        return $this->status == 'Open' ? 'info' : ($this->status == 'Closed' ? 'success' : ($this->status == 'In Progress' ? 'secondary' : 'danger'));
    }

    public function getPriorityClassAttribute()
    {
        // Priority High : danger Priority Medium : warning Priority Low : primary
        return $this->priority == 'High' ? 'danger' : ($this->priority == 'Medium' ? 'warning' : 'primary');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(TicketsCategories::class, 'category_id', 'id');
    }

    public function assignee()
    {
        return $this->belongsTo(Department::class, 'assignee_id', 'id');
    }

    public function fixed()
    {
        return $this->belongsTo(User::class, 'fixed_by', 'id');
    }

    public function comments()
    {
        return $this->hasMany(TicketsComments::class, 'ticket_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'assignee_id', 'id');
    }
}
