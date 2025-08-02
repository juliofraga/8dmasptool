<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class verification extends Model
{
    use HasFactory;

    protected $fillable = ['method', 'result', 'date', 'effective', 'permanent_actions_id'];

    public function rules() 
    {
        return [
            'method' => 'required',
            'result' => 'required',
            'date' => 'required',
            'effective' => 'required',
            'permanent_actions_id' => 'required',
        ];
    }

    public function feedback() 
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
        ];
    }

    public function permanent_action()
    {
        return $this->belongsTo(permanent_action::class, 'permanent_actions_id');
    }
}
