<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellControler extends Controller
{
    public function index()
    {
        return view('ecom.sell.index');
    }
}
