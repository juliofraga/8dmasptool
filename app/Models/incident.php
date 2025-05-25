<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class incident extends Model
{
    use HasFactory;

    protected $fillable = ['item_description', 'category', 'client_supplier', 'internal_code', 'quantity_detected', 'recidivism', 'batch', 'invoice', 'incident_description', 'date_deadline', 'date_opening', 'status', 'mode'];

    public function rules() 
    {
        return [
            'item_description' => 'required',
            'incident_description' => 'required',
            'date_deadline' => 'required',
            'date_opening' => 'required',
            'status' => 'required',
            'mode' => 'required'
        ];
    }

    public function feedback() 
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
        ];
    }
}
