<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Attributes\DB;

class Progress extends Model
{
    use HasFactory;

    protected $table = ['progress'];

    protected $fillable  = ['booK_id', 'user_id','status','position'];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
