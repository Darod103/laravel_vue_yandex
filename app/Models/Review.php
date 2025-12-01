<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'place_id',
        'author',
        'rating',
        'text',
        'raw_date',
        'date_iso',
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
