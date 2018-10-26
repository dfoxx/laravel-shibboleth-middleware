<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'demo']);
    }

    public function username()
    {
        return 'unity_id';
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('login');
    }

    public function shibboleth()
    {
        if (app()->environment() == 'local') {
            return redirect('/');
        } elseif (app()->environment() == 'production') {
            $url = config('app.url');
            return redirect("/Shibboleth.sso/Login?target=$url");
        }
    }

    public function logout(Request $request)
    {
        session()->flush();
        auth()->logout();
        return redirect()->route('login');
    }
}
