<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryPaymentSplit extends Model
{
    use HasFactory;

    protected $fillable = ['entry_id', 'account_id', 'amount', 'note'];
    protected $casts = ['amount' => 'decimal:2'];

    public function entry() { return $this->belongsTo(Entry::class); }
    public function account() { return $this->belongsTo(Account::class); }
}
