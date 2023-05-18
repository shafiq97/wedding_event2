<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'venue_id',
        'path',
        // Other fields if you have any...
    ];

    /**
     * Get the venue that owns the image.
     */
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
