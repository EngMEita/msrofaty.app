<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'platform_admin',
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
        'platform_admin' => 'boolean',
    ];

    public function setPasswordAttribute($value = null)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    public function households()
    {
        return $this->belongsToMany(Household::class)->withPivot('role')->withTimestamps();
    }

    public function household()
    {
        return $this->households()->first();
    }
}
