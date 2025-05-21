<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RepairControler extends Controller
{
    public function index()
    {
        return view('ecom.repair');
    }
}
