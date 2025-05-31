<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;

class News extends Model
{   
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    use HasFactory;
    protected $connection = 'mongodb'; // use MongoDB connection

    protected $collection = 'news'; // Optional if same name

    protected $fillable = [
        'category', 'title', 'image', 'short_description', 'details',
        'language', 'location', 'date', 'time', 'refer_from',
        'link', 'added_by', 'updated_by', 'favourite','author','tags'
    ];
}
