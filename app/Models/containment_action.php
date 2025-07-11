<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class containment_action extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'incidents_id', 'users_id', 'status'];

    public function rules() 
    {
        return [
            'description' => 'required',
            'incidents_id' => 'required',
            'users_id' => 'required',
            'status' => 'required'
        ];
    }

    public function feedback() 
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
