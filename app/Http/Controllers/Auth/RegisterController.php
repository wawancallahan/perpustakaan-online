<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Models\Siswa;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nis' => 'required',
            'name' => 'required',
            'generation' => 'required',
            'class' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'address' => 'nullable',
            'password' => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'], 
            'username' => $data['nis'], 
            'password' => $data['password'],
            'is_active' => 0
        ]);

        $user->assignRole('siswa');

        Siswa::create([
            'nis' => $data['nis'],
            'name' => $data['name'],
            'generation' => $data['generation'],
            'class' => $data['class'],
            'gender' => $data['gender'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'status' => 0,
            'user_id' => $user->id
        ]);

        return $user;
    }

    public function register(Request $request) {
        $this->validator($request->all())->validate();

        $hasNisDuplicate = Siswa::where('nis', $request->nis)->count() > 0;

        if ($hasNisDuplicate) {
            session()->flash('flash', [
                'type' => 'danger',
                'message' => 'NIS telah ada sebelumnya'
            ]);

            return redirect()->back();
        }
    
        $user = $this->create($request->all());
    
        if($user === null) { // Failed to register user
            redirect('/register'); // Wherever you want to redirect
        }

        session()->flash('flash', [
            'type' => 'success',
            'message' => 'Silahkan login untuk melanjutkan'
        ]);
    
        event(new Registered($user));
    
        $this->guard()->login($user);
    
        // Success redirection - which will be attribute `$redirectTo`
        return redirect()->route('siswa.dashboard');
    }
}
