<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function records()
    {
        return $this->hasMany(Record::class);
    }

    public function getBalanceAttribute()
    {
        $records = $this->records();
        $balance = 0;
        foreach ( $records as $record )
        {
            $balance += $record->value * $record->type ;
        }
        return $balance;
    }
}
