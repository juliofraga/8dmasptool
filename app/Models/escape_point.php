<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class escape_point extends Model
{
    use HasFactory;
    protected $fillable = ['why_not', 'detection_stage', 'improvement_plan', 'incident_id'];

    public function rules() 
    {
        return [
            'why_not' => 'required',
            'detection_stage' => 'required',
            'improvement_plan' => 'required',
            'incident_id' => 'required'
        ];
    }

    public function feedback() 
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
        ];
    }
}
