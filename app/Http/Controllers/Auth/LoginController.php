<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

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

    use AuthenticatesUsers {
		logout as performLogout;
	}

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

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
        $login = request()->input('username');

        if(is_numeric($login)){
            $field = 'nis';
        } else {
            $field = 'username';
        }
        
        request()->merge([$field => $login]);

        return $field;
    }

    public function logout(Request $request)
	{
		$this->performLogout($request);

		return redirect()->route('login');
	}

    protected function authenticated(Request $request, $user)
    {   
        $role = $user->roles->first();

        switch ($role->name) {
            case 'admin':
            case 'petugas':
                return redirect()->route('admin.dashboard');
            case 'siswa':
                return redirect()->route('siswa.dashboard');
            case 'headmaster':
                return redirect()->route('headmaster.dashboard');
        }

        return redirect()->route('logout')->withErrors([
            'error' => 'Terjadi Kesalahan Data User'
        ]);
    }
}
