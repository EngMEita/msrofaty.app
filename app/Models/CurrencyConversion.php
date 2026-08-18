<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CurrencyConversion extends Model { protected $fillable=['household_id','from_account_id','to_account_id','from_currency_id','to_currency_id','from_amount','rate','to_amount','date','note']; protected $casts=['from_amount'=>'decimal:2','rate'=>'decimal:8','to_amount'=>'decimal:2','date'=>'date']; public function fromAccount(){return $this->belongsTo(Account::class,'from_account_id');} public function toAccount(){return $this->belongsTo(Account::class,'to_account_id');} public function fromCurrency(){return $this->belongsTo(Currency::class,'from_currency_id');} public function toCurrency(){return $this->belongsTo(Currency::class,'to_currency_id');} }
