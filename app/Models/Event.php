<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $fillable = [
        'organization_id',
        'category_id',
        'title',
        'slug',
        'description',
        'location',
        'start_date',
        'end_date',
        'quota',
        'banner',
        'status',
        'rejection_reason',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}