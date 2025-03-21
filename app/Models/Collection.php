<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $table = 'collections';

    protected $fillable = ['name'];

    public $timestamps = false;
    
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_collection', 'collection_id', 'book_id');
    }

}
