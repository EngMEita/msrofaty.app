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
    ];

    public function records()
    {
        return $this->hasMany(Record::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusAttribute ()
    {
        $d = $this->withdraw - $this->deposit;

        if ( $d > 0 || $d < 0)
        {
            return false;
        }

        return true;
    }

    public function getWithdrawAttribute()
    {
        $value = 0;
        foreach ($this->records as $record)
        {
            $value += $record->type < 0 ? $record->value : 0;
        }
        return $value;
    }

    public function getDepositAttribute()
    {
        $value = 0;
        foreach ($this->records as $record)
        {
            $value += $record->type > 0 ? $record->value : 0;
        }
        return $value;
    }
}
