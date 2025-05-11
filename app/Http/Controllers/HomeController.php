<?php

namespace App\Http\Controllers;

use App\Models\Model;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function index(Request $request){

//        notify()->success('Notify working perfectly');

        return view('ecom.home', []);
    }
}
