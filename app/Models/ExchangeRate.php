<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ExchangeRate extends Model { protected $fillable=['household_id','from_currency_id','to_currency_id','rate','effective_on']; protected $casts=['rate'=>'decimal:8','effective_on'=>'date']; public function fromCurrency(){return $this->belongsTo(Currency::class,'from_currency_id');} public function toCurrency(){return $this->belongsTo(Currency::class,'to_currency_id');} }
