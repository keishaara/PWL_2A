<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = [
        'registration_id',
        'ticket_code',
        'status',
    ];

    /**
     * Relasi ke model Registration
     */
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}