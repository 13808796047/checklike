<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FreeCheckController extends Controller
{
    public function index()
    {
        return view('freecheck.index');
    }
}
