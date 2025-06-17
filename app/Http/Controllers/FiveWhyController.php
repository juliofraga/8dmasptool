<?php

namespace App\Http\Controllers;

use App\Models\five_why;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\FiveWhyRepository;

class FiveWhyController extends Controller
{
    public $fiveWhy;
    public $fiveWhyRepository;

    public function __construct(five_why $fiveWhy) 
    {
        $this->fiveWhy = $fiveWhy;
        $this->fiveWhyRepository = new FiveWhyRepository($this->fiveWhy);
    }

    public function store(Request $request)
    {

    }
}