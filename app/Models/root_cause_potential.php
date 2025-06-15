<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class root_cause_potential extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'incidents_id', 'category'];

    public function rules() 
    {
        return [
            'description' => 'required',
            'incidents_id' => 'required',
            'category' => 'required'
        ];
    }

    public function feedback() 
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
        ];
    }
}
