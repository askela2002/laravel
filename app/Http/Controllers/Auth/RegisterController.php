<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;


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
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|max:20',
            'first_name' => 'string|max:20',
            'last_name' => 'string|max:40',
            'country' => 'string|max:100',
            'city' => 'string|max:100',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        return User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'first_name' => array_key_exists('first_name', $data) ? $data['first_name'] : Null,
            'last_name' => array_key_exists('last_name', $data) ? $data['last_name'] : Null,
            'country' => array_key_exists('country', $data) ? $data['country'] : Null,
            'city' => array_key_exists('city', $data) ? $data['city'] : Null,
            'phone' => array_key_exists('phone', $data) ? $data['phone'] : Null,
            'role_id' => array_key_exists('role_id', $data) ? $data['role_id'] : 0,
            'api_token',
        ]);
    }

    protected function registered(Request $request, $user)
    {
        $user->generateToken();
        return response()->json($user, 201);
    }
}
