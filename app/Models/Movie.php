<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    // Define the fillable attributes
    protected $fillable = [
        'tmdb_id',
        'title',
        'tagline',
        'path_movie',
        'release_date',
        'overview',
        'poster_path',
        'background_path',
        'vote_average',
        'genre_ids',
        'runtime',
        'subtitle_link',
        'vote_count',
    ];

    // Optionally, if you're using dates like 'release_date' that are cast to Carbon instances
    protected $dates = [
        'release_date',
    ];
}
