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

    public static function getTopBooksForUser($userId)
    {
        $sql = "
            SELECT 
                b.id,
                b.title,
                b.cover_photo,
                b.description,
                b.file,
                b.year,
                b.keywords,
                b.status,
                COALESCE(GROUP_CONCAT(DISTINCT a.name ORDER BY a.name SEPARATOR ', '), '') AS authors,
                COALESCE(COUNT(DISTINCT s.user_id), 0) AS shelving_users,
                COALESCE(ROUND(AVG(r.point), 1), 0) AS ranking,
                COALESCE(p.position, 0) AS position,
                IF(MAX(s2.book_id) IS NULL, FALSE, TRUE) as my_shelving
            FROM books b
            LEFT JOIN book_authors ba ON ba.book_id = b.id
            LEFT JOIN authors a ON a.id = ba.author_id
            LEFT JOIN shelving s ON s.book_id = b.id
            LEFT JOIN ratings r ON r.book_id = b.id
            LEFT JOIN progress p ON p.book_id = b.id AND p.user_id = :user_id_1
            LEFT JOIN shelving s2 ON s2.book_id = b.id AND s2.user_id = :user_id_2
            GROUP BY 
                b.id, 
                b.title, 
                b.cover_photo, 
                b.description, 
                b.file, 
                b.year, 
                b.keywords, 
                b.status, 
                p.position
            ORDER BY shelving_users DESC
            LIMIT 5
        ";

        return DB::select($sql, [
            'user_id_1' => $userId,
            'user_id_2' => $userId
        ]);
    }

    public static function most_read()
    {
        return self::select('books.id', 'books.title', 'books.cover_photo', 'books.description')
        ->with('authors') 
        ->join('progress', 'progress.book_id', '=', 'books.id')
        ->selectRaw('COUNT(progress.id) as total')
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
