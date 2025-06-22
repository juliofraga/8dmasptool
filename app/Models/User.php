<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'profile'];
    protected $hidden = ['password','remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

    public function rules() 
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$this->id,
            'password' => 'required',
            'profile' => 'required'
        ];
    }

    public function feedback() 
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'email.unique' => 'Este e-mail já está cadastrado no nosso sistema, informe outro.'
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function areas()
    {
        return $this->belongsToMany(Area::class, 'users_has_area', 'user_id', 'area_id')
                    ->withPivot('manager');
    }

    public function incidents()
    {
        return $this->belongsToMany(Area::class, 'users_has_incidents', 'user_id', 'incidents_id')
                    ->withPivot('leader');
    }
}
