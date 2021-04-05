<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SickleaveController extends Controller
{
    public function store(Request $request)
    {
        return view('sickleaves');
    }
}
