<?php

namespace App\Http\Controllers;

use App\Models\log;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;

class LogController extends Controller
{
    
    public function index()
    {
        //
    }

    public static function store($data, int $user, string $action)
    {
        $description = '';
        if (is_array($data)) {
            $class = $description = $action;
        } elseif ($data instanceof Model) {
            $class = $data->getTable();
            $class_id = $data->getAttributes()['id'];
            $changes = $data->getChanges();
        } else {
            return null;
        }
        if ($action === 'update') {
            foreach ($changes as $field => $value) {
                $description .= $field . ': ' . $value . '<br>';
            }
        } elseif ($action === 'insert' || $action === 'delete') {
            $attributes = $data->getAttributes();
            unset($attributes['password']);
            foreach ($attributes as $field => $value) {
                $description .= $field . ': ' . $value . '<br>';
            }
        }
        log::create([
            'user_id' => $user,
            'class' => $class,
            'class_id' => $class_id ?? null,
            'action' => $action,
            'description' => $description
        ]);
    }

    public function show(log $log)
    {
        //
    }
}
