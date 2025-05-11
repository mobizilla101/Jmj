<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        $loginInput = request()->input('user');
        return filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'user' => 'required|string', // Validate the 'user' input field
            'password' => 'required|string',
        ]);
    }


    protected function credentials(Request $request)
    {
        return [
            $this->username() => $request->input('user'),
            'password' => $request->input('password'),
        ];
    }


}
