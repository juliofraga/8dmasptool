<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class log extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'class', 'class_id', 'action', 'description'];

    public function setUpdatedAt($value)
    {
        
    }

    public function getUpdatedAtColumn()
    {
        return null;
    }
}
