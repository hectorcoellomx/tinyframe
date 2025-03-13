<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model
// class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    protected $table = 'users';

    protected $fillable = ['name','email','type','last_access'];

    public function getTypeTextAttribute()
    {
        switch ($this->type) {
            case 1:
                return 'Alumno';
            case 2:
                return 'Docente';
            case 3:
                return 'Administrativo';
            default:
                return 'Invitado';
        }
}

    // public function getJWTIdentifier()
    // {
    //     return $this->getKey();
    // }

    // public function getJWTCustomClaims()
    // {
    //     return [];
    // }
}
