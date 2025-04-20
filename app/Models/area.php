<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class area extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function rules() 
    {
        return [
            'name' => 'required',
        ];
    }

    public function feedback() 
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
        ];
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_has_area', 'area_id', 'user_id')
                    ->withPivot('manager');
    }
}
