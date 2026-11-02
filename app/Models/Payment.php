<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'user_id',
        'event_id',
        'invoice_number',
        'amount',
        'status',
        'bank_name',
        'bank_account_number',
        'bank_account_holder',
        'payment_proof',
        'paid_at',
        'expires_at',
        'rejection_reason',
        'notes',
    ];

    protected $casts = [
        'amount'     => 'decimal:2',
        'paid_at'    => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'              => 'Belum Bayar',
            'waiting_verification' => 'Menunggu Verifikasi',
            'paid'                 => 'Lunas',
            'rejected'             => 'Ditolak',
            default                => ucfirst($this->status),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'pending'              => 'bg-amber-100 text-amber-800 border-amber-300',
            'waiting_verification' => 'bg-blue-100 text-blue-800 border-blue-300',
            'paid'                 => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'rejected'             => 'bg-rose-100 text-rose-800 border-rose-300',
            default                => 'bg-slate-100 text-slate-800 border-slate-300',
        };
    }
}
