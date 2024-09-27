<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelvings extends Model
{
    use HasFactory;

    protected $table = 'shelving';
    public $timestamps = false;

    protected $fillable = ['book_id','user_id'];
    
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
