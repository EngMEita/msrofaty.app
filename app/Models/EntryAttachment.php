<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryAttachment extends Model
{
    use HasFactory;
    protected $fillable = ['entry_id', 'disk', 'path', 'original_name', 'mime_type', 'size'];
    public function entry() { return $this->belongsTo(Entry::class); }
}
