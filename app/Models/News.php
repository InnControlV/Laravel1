<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'category', 'title', 'image', 'short_description', 'details',
        'language', 'location', 'date', 'time', 'refer_from',
        'link', 'added_by', 'updated_by', 'favourite','author'
    ];
}
