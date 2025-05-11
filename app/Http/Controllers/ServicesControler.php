<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServicesControler extends Controller
{
    public function index()
    {
        return view('ecom.services');
    }
}
