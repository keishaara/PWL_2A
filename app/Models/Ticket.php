<?php

namespace App\Models;

use App\Support\TicketQr;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['registration_id', 'ticket_code', 'status'];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
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