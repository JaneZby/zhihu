<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;
use Naux\Mail\SendCloudTemplate;

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
     * Where to redirect users after login / registration.
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
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
        $users = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'avatar' => '/images/avatars/default.jpg',
            'confirmation_token' => str_random(40),
            'password' => bcrypt($data['password']),
        ]);
        $this->sendVerifyEmailTo($users);
        return $users;
    }

    private function sendVerifyEmailTo($user)
    {
        // 模板变量
        $bind_data = [
            'url' => route('email.verify',
                [
                    'token'=>$user->confirmation_token
                ]
            ),
            'name' => $user->name,
        ];

        $template = new SendCloudTemplate('register_verify', $bind_data);

        Mail::raw($template, function ($message) use ($user) {
            $message->from('476564406@qq.com', 'h476564406_test_L1qJrf');
            $message->to($user->email);
        });
    }
}
