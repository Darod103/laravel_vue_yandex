<?php

namespace App\Models;

use App\Enum\PlaceStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Place extends Model
{
    protected $fillable = [
        'user_id',
        'url',
        'name',
        'rating',
        'total_reviews',
        'parsed_at',
        'status',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'parsed_at' => 'datetime',
        'status' => PlaceStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
