<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Events\UserEvents;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Crypt;

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
    protected $redirectTo = '/home';

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
            'name'          => 'required|max:255|alpha_num',
            'email'         => 'required|email|max:255|unique:users',
            'password'      => 'required|min:6|confirmed',
            'first_name'    => 'required|min:3|max:32',
            'last_name'     => 'required|min:3|max:32',
            'account_type'  => 'required|in:1,0'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        // dd($data);
        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => bcrypt($data['password']),
        ]);

        $user->profile()->create([
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'account_type'  => $data['account_type'],
        ]);

        // Generate user verify token and store in database
        $verify_key = Crypt::encryptString($data['email']);
        $user->verifyUser()->create([
            'verify_key' => $verify_key
        ]);

        // Dispatch the event to send the email
        event(new UserEvents($user));

        // Return the newly created user
        return $user;

    }
}
