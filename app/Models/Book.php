<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    use HasFactory;
    protected $table = 'books';

    protected $fillable = ['id','title', 'cover_photo', 'description','file','year','keywords','status'];

    public $incrementing = false;
    protected $keyType = 'string';

    public static function most_read()
    {
        return DB::table('books')
        ->join('progress', 'progress.book_id', '=', 'books.id')
        ->select('books.id', 'books.title', 'books.cover_photo', 'books.description', DB::raw('COUNT(progress.id) as total'))
        ->groupBy('books.id', 'books.title', 'books.cover_photo', 'books.description')
        ->orderBy('total', 'desc')
        ->get();
    }

    public static function average($id, $user_id)
    {
         // Usar el query builder para construir la consulta SQL
        return DB::table('ratings as r')
        ->join('progress as p', 'r.book_id', '=', 'p.book_id')  // Inner join de ratings y progress
        ->join('users as u', 'u.id', '=', 'r.user_id')          // Inner join de ratings y users
        ->select('r.point', 'p.position', 'u.id')               // Seleccionamos los campos deseados
        ->where('r.book_id', $id)                           // Filtramos por el libro
        ->where('u.id', $user_id)
        ->first();
    }
    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_authors', 'book_id', 'author_id');
    }

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
        return $this->hasMany(Shelvings::class, 'book_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'book_id');
    }

    public function progress()
    {
        return $this->hasMany(Progress::class, 'book_id', 'id');
    }
}
