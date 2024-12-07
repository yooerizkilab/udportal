<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
// use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $appends = ['badgeClass'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        if (is_null($this->last_name)) {
            return "{$this->name}";
        }

        return "{$this->name} {$this->last_name}";
    }

    /**
     * Set the user's password.
     *
     * @param string $value
     * @return void
     */
    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = Hash::make($value);
    // }

    public function getBadgeClassAttribute()
    {
        $statusColor = [
            'Superadmin' => 'danger',
            'Admin' => 'info',
            'Staff' => 'success',
            'User' => 'primary',
        ];

        // Berikan warna default jika status tidak ditemukan
        return $statusColor[$this->getRoleNames()[0]] ?? 'secondary';
    }

    public function employe()
    {
        return $this->hasOne(Employe::class);
    }

    public function assignments()
    {
        return $this->hasMany(VehicleAssignment::class, 'vehicle_id');
    }
}
