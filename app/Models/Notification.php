<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'is_read',
    ];

    /**
     * Casting tipe data otomatis
     */
    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Relasi ke Model User (Notifikasi dimiliki oleh 1 user penerima)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}