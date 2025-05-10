<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopping extends Model
{
    protected $table = 'shopping';

    protected $fillable = [
        'title', 'name', 'media', 'link_url', 'author',
        'added_by', 'updated_by', 'create_date',
        'short_description', 'long_description',
        'is_delete', 'category', 'subcategory'
    ];
}