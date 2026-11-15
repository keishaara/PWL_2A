<?php

namespace App\Models;

use App\Support\TicketQr;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['registration_id', 'ticket_code', 'status', 'checked_in_at'];

    protected $casts = [
        'checked_in_at' => 'datetime',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(EventReview::class);
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class);
    }

    public function getQrDataUriAttribute(): string
    {
        return TicketQr::dataUri($this->ticket_code);
    }

    // tidak membuat tiket ganda untuk satu registrasi
    public static function issueFor(Registration $registration): self
    {
        return static::firstOrCreate(
            ['registration_id' => $registration->id],
            [
                'ticket_code' => 'TIX-' . strtoupper(Str::random(8)),
                'status'      => 'unused',
            ]
        );
    }
}