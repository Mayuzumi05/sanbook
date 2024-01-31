<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = "books";
    protected $primaryKey = "id";
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'release_year',
        'price',
        'total_page',
        'thickness',
        'category_id'
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
