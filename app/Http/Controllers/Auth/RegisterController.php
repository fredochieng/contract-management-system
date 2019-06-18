<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Admin;
use App\User_Details;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Notifications\UserCreatedNotification;
use Notification;
use RealRashid\SweetAlert\Facades\Alert;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    //  public function index()
    // {
    //     $organizations=DB::table('users_organizations')->pluck('organization_name','organization_id')->all();
    //     return view('contracts.users')->with([
    //         'organizations' => $organizations,
    //     ]);

    //     print_r($organizations);
    //     exit;

    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'organization_id' => ['required', 'string', 'max:255'],
            // 'job_title' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function create(array $data)
    {
        $user = User::create([
            'name' => ucwords($data['name']),
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $just_saved_user_id = $user->id;

        $user_details_data = array(
            'user_id' => $just_saved_user_id
        );

        $save_users_details = DB::table('users_details')->insertGetId($user_details_data);

        $user_inserted = User::find($user->id);

        $user_inserted->assignRole('Standard User');

        $details = [
            'greeting' => 'Hi' . ' ' . $data['name'],
            'body' => 'Thank you for registering to Wananchi Group Contracts Management System',
            'thanks' => 'Welcome aboard!',
            // 'actionText' => 'Click here to login',
        //     'actionURL' => url('/')
         ];
        Notification::send($user, new UserCreatedNotification($details));

        return $user;


    }
}
