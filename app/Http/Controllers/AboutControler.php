<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutControler extends Controller
{
    public function index()
    {
        return view('ecom.about');
    }
}
