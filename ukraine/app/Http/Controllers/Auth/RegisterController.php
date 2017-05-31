<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/cabinet/registered?status=1';

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
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        $validation = Validator::make($data, [
            'name' => 'required|max:100',
            'payer' => 'required|max:200',
            'region' => 'required|integer',
            'post_index' => 'required|numeric',
            'city' => 'required|integer',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email_work' => 'required|email|max:255',
            'email_addly' => 'email|max:255',
            'charter' => 'required|string|max:1000',
            'bank' => 'required|string|max:100',
            'bill' => 'required|numeric',
            'mfo' => 'required|numeric',
            'ipn' => 'required|numeric',
            'tax_type' => 'required|string|max:50',
            'nps' => 'required|numeric',
            'egr' => 'required|numeric',
            'fio_manager' => 'required|string|max:50',
            'job_position_manager' => 'required|string|max:50',
            'phone_manager' => 'required|string',
            'accountant' => 'required|string|max:100',
            'accountant_phone' => 'required|string',
            'instructor' => 'required|string|max:50',
            'instructor_phone' => 'required|string',
            'doctor' => 'required|string|max:50',
            'doctor_phone' => 'required|string', // x:/^\+380([0-9]){10}$/
            'doctor_diplom' => 'required|string|max:300',
            'doctor_courses' => 'required|string|max:300',
            'licence' => 'required|string|max:50',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        if ($validation->fails()) {
            //dd($validation->errors()->all()); die();
        }

        return $validation;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {

        //dd($data);

        $user = User::create([
            'name' => $data["name"], 'type_account' => 1, 'egr' => $data["egr"], 'doctor_courses' => $data['doctor_courses'], 'charter' => $data['charter'], 'mfo' => $data['mfo'], 'nps' => $data['nps'], 'licence' => $data["licence"], 'doctor_phone' => $data["doctor_phone"], 'doctor_diplom' => $data["doctor_diplom"], 'accountant_phone' => $data["accountant_phone"], 'accountant' => $data["accountant"], 'email' => $data["email"], 'instructor_phone' => $data["instructor_phone"], 'password' => bcrypt($data['password']), 'payer' => $data["payer"], 'instructor' => $data["instructor"], 'city' => $data["city"], 'fio_manager' => $data["fio_manager"], 'tax_type' => $data["tax_type"], 'job_position_manager' => $data["job_position_manager"], 'phone_manager' => $data["phone_manager"], 'post_index' => $data["post_index"], 'phone' => $data["phone"], 'address' => $data["address"], 'doctor' => $data["doctor"], 'email_work' => $data["email_work"], 'bank' => $data["bank"], 'IPN' => $data["ipn"], 'bill' => $data["bill"], 'region' => $data["region"]
        ]);


        $settings = new Settings();
        $settings->user_id = $user->id;
        $settings->save();

        return $user;
    }
}
