<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_url',
        'published_year',
        'description',
        'is_showing',
        'genre_id'
    ];
    protected $attributes = [
        'published_year' => null,
        'description' => null,
        'is_showing' => true,
    ];
    protected $casts = [
        'is_showing' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $table = 'movies';
    protected $dates = ['created_at', 'updated_at'];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class)->orderBy('start_time', 'asc');
    }
}