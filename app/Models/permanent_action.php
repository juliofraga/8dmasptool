<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permanent_action extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'description', 'incidents_id', 'category', 'status', 'deadline', 'users_id'];

    public function rules() 
    {
        return [
            'description' => 'required',
            'incidents_id' => 'required',
            'category' => 'required',
            'type' => 'required',
            'status' => 'required',
            'deadline' => 'required',
            'users_id' => 'required'
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

    public function verifications()
    {
        return $this->hasMany(Verification::class, 'permanent_actions_id');
    }
}
