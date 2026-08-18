<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'note',
        'user_id',
        'household_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date' => 'date',
        'user_id' => 'integer',
        'household_id' => 'integer',
    ];

    public function records()
    {
        return $this->hasMany(Record::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function household()
    {
        return $this->belongsTo(Household::class);
    }

    public function getStatusAttribute()
    {
        // Return true if entry is balanced (withdraw == deposit)
        return $this->withdraw == $this->deposit;
    }

    public function getWithdrawAttribute()
    {
        $value = 0;
        foreach ($this->records as $record) {
            $value += $record->type < 0 ? abs($record->value) : 0;
        }
        return $value;
    }

    public function getDepositAttribute()
    {
        $value = 0;
        foreach ($this->records as $record) {
            $value += $record->type > 0 ? $record->value : 0;
        }
        return $value;
    }
}
