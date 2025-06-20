<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class root_cause_test extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'result', 'approved', 'approved_at', 'user_id', 'five_whys_id', 'incident_id'];

    public function rules() 
    {
        return [
            'description' => 'required',
            'approved' => 'required',
            'user_id' => 'required',
            'five_whys_id' => 'required',
            'incident_id' => 'required',
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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function fiveWhy()
    {
        return $this->belongsTo(five_why::class, 'five_whys_id');
    }
}
