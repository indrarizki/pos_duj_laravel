<?php

namespace App\Http\Controllers\Auth;

use App\Absent;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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

    // use AuthenticatesUsers;

    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    protected function authenticated(Request $request, $user)
    {
        $role = $user->role;

        if ($user->is_active == 0) {
            $this->performLogout($request);
            return redirect('/');
        }

        Absent::create_absent($user);

        if ($role == 'manager') { // do your magic here
            return redirect()->route('manager.ui');
        } elseif ($role == 'kasir') {
            return redirect()->route('kasir.ui');
        } elseif ($role == 'resepsionist') {
            return redirect()->route('resepsionist.ui');
        }

        return redirect('/home');
    }

    public function logout(Request $request)
    {
        Auth::user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        $this->performLogout($request);
        return redirect('/');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
