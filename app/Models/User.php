<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',     
        'npm',  
        'major',
        'semester',
        'phone',
        'avatar',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    // wishlist menggunakan tabel histories yang sudah ada (action = 'bookmark', description = id event)
    public function bookmarkedEventIds(): array
    {
        return \App\Models\History::where('user_id', $this->id)
            ->where('action', 'bookmark')
            ->pluck('description')
            ->map(fn ($id) => (int) $id)
            ->all();
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
