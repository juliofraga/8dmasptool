<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class five_why extends Model
{
    use HasFactory;
    protected $table = 'five_whys';
    protected $fillable = ['step_number', 'why', 'is_root_cause', 'root_cause_potentials_id', 'root_cause_potentials_incidents_id'];

    public function rules() 
    {
        return [
            'step_number' => 'required',
            'why' => 'required',
            'root_cause_potentials_id' => 'required',
            'root_cause_potentials_incidents_id' => 'required'
        ];
    }

    public function feedback() 
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
        ];
    }
}
