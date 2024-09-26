<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class book extends Model
{
    use HasFactory;
    protected $table = 'books';

    protected $fillable = ['id','title', 'cover_photo', 'description','file','year','keywords','status'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category', 'book_id', 'category_id');
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'book_collection', 'book_id', 'collection_id');
    }

    public function shelving()
    {
        return $this->hasMany(Shelving::class, 'book_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'book_id');
    }

    public function progress()
    {
        return $this->hasMany(Progress::class, 'book_id');
    }
}
