<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'owner_id', 'status'];
    protected $casts = ['owner_id' => 'integer'];
    public function owner() { return $this->belongsTo(User::class, 'owner_id'); }
    public function subscriptions() { return $this->hasMany(Subscription::class); }
    public function subscription() { return $this->hasOne(Subscription::class)->latestOfMany(); }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('role')->withTimestamps();
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function records()
    {
        return $this->hasMany(Record::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }
}
