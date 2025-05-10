<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Movie extends Model
{
    protected $connection = 'mongodb'; // Ensure MongoDB is used
    protected $collection = 'movies';

    protected $fillable = [
        'title',
        'location',
        'release_date',
        'language',
        'refer_from',
    ];
}