<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::created(fn (Entry $entry) => $entry->writeAudit('created', $entry->getAttributes()));
        static::updated(fn (Entry $entry) => $entry->writeAudit('updated', $entry->getChanges()));
        static::deleted(fn (Entry $entry) => $entry->writeAudit('deleted', $entry->getOriginal()));
    }

    protected function writeAudit(string $action, array $changes): void
    {
        AuditLog::create(['household_id' => $this->household_id, 'user_id' => auth()->id(), 'auditable_type' => static::class, 'auditable_id' => $this->id, 'action' => $action, 'changes' => $changes]);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'note',
        'total_amount',
        'entry_type',
        'workflow_status',
        'reference_number',
        'currency',
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
        'total_amount' => 'decimal:2',
    ];

    public function records()
    {
        return $this->hasMany(Record::class);
    }

    public function paymentSplits()
    {
        return $this->hasMany(EntryPaymentSplit::class);
    }

    public function attachments()
    {
        return $this->hasMany(EntryAttachment::class);
    }

    public function getPaidAmountAttribute()
    {
        return $this->paymentSplits->sum(fn ($split) => (float) $split->amount);
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
        return $this->total_amount !== null
            ? abs((float) $this->total_amount - (float) ($this->withdraw + $this->deposit)) < 0.01
            : $this->withdraw == $this->deposit;
    }

    public function getTypeLabelAttribute(): string
    {
        return ['income' => 'دخل', 'expense' => 'مصروف', 'transfer' => 'تحويل داخلي', 'refund' => 'استرداد', 'other' => 'أخرى'][$this->entry_type] ?? 'أخرى';
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
