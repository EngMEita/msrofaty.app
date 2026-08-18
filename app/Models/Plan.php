<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['name', 'price', 'billing_period', 'max_members', 'max_accounts', 'max_transactions', 'active'];
    protected $casts = ['price' => 'decimal:2', 'active' => 'boolean'];
    public function subscriptions() { return $this->hasMany(Subscription::class); }
}
