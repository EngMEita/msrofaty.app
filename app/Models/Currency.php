<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Currency extends Model { use HasFactory; protected $fillable=['household_id','code','name','symbol','is_base','active']; protected $casts=['is_base'=>'boolean','active'=>'boolean']; public function household(){return $this->belongsTo(Household::class);} }
