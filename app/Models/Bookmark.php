<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;


class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_type',
        'product_id',
    ];

    protected $connection = 'mongodb';  // Make sure your DB connection is mongodb
    protected $collection = 'bookmarks'; // Mongo collection name
    
    protected $primaryKey = '_id';  // MongoDB uses _id as primary key
    
    public $timestamps = true;  // if your collection has created_at, updated_at

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }}
