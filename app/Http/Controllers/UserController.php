<?php

namespace App\Http\Controllers;

use App\User;
use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;
use Spatie\Permission\Traits\HasRoles;
use RealRashid\SweetAlert\Facades\Alert;
use App\Users_Details;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Notifications\UserCreatedNotification;
use App\VerifyAddedUser;
use App\Mail\VerifyMail;
use Notification;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use RegistersUsers;
    use Notifiable;

    public function __construct()
    {

        // $this->middleware(['role:Admin']);
    }
    public function index()
    {
        $organizations = DB::table('users_organizations')->pluck('organization_name', 'organization_id')->all();
        $roles = DB::table('roles')->pluck('name', 'id')->all();
        $legal_counsel_users = DB::table('users')
            ->select(
                DB::raw('users.*'),
                DB::raw('users_details.*'),
                DB::raw('users_organizations.*'),
                DB::raw('model_has_roles.*'),
                DB::raw('roles.name AS role_name')

            )
            ->leftJoin('users_details', 'users.id', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('roles.name', 'Legal Counsel')
            ->orderBy('users.id', 'desc')
            ->get();

        $standard_users = DB::table('users')
            ->select(
                DB::raw('users.*'),
                DB::raw('users_details.*'),
                DB::raw('users_organizations.*'),
                DB::raw('model_has_roles.*'),
                DB::raw('roles.name AS role_name')

            )
            ->leftJoin('users_details', 'users.id', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('roles.name', 'Standard User')
            ->orderBy('users.id', 'desc')
            ->get();

        return view('contracts.users')->with([
            'legal_counsel_users' => $legal_counsel_users,
            'standard_users' => $standard_users,
            'organizations' => $organizations,
            'roles' => $roles
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('parties.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'organization_id' => ['required', 'string', 'max:255'],
            'role_id' => ['required', 'string', 'max:255'],
            'job_title' => ['required', 'string', 'max:255'],
        ]);

        $user = new user;
        if ($request->input('role_id') == 2) {

            $user_date = User::where('last_assigned_date', '!=', '')->orderBy('last_assigned_date', 'asc')->first();

            if (empty($user_date)) {
                $user->last_assigned_date = Carbon::now();
            } else {

                $user->last_assigned_date = Carbon::parse($user_date->last_assigned_date)->subSeconds(10)->format('Y-m-d H:i:s');
            }


        }

        $password_string = str_random(6);
        $user->name = ucwords($request->input('name'));
        $user->email = $request->input('email');

        if ($request->input('role_id') == 2) {
            $user = User::create([
                'name' =>  $user->name,
                'email' => $user->email,
                'last_assigned_date' => $user->last_assigned_date,
                'password' => Hash::make($password_string)
            ]);
        } else {
            $user = User::create([
                'name' =>  $user->name,
                'email' => $user->email,
                'password' => Hash::make($password_string)
            ]);
        }


        // echo $current_time;
        // exit;

        $saved_user_id = $user->id;

        $user_data = array(
            'user_id' => $saved_user_id,
            'organization_id' => $request->input('organization_id'),
            'job_title' => ucwords($request->input('job_title'))
        );

        $user_role_data = array(
            'model_id' => $saved_user_id,
            'role_id' => $request->input('role_id'),
            'model_type' => 'App\User',
        );
        $save_users_details = DB::table('users_details')->insertGetId($user_data);
        $save_role_details = DB::table('model_has_roles')->insertGetId($user_role_data);

        $details = [
            'greeting' => 'Hi' . ' ' . $request['name'],
            'body' => 'You have been registered to Wananchi Group Legal Management System',
            'thanks' => 'Welcome aboard!',
            'password' => 'Your password is ' . ' ' . $password_string,
            'actionText' => 'Click here to login',
            'actionURL' => url('/login')
        ];

        Notification::send($user, new UserCreatedNotification($details));

        $verifyUser = VerifyAddedUser::create([
            'user_id' => $user->id,
            'token' => sha1(time())
        ]);
        \Mail::to($user->email)->send(new VerifyMail($user));
        Alert::success('Create User', 'User successfully created');
        return redirect('system-users/users');
    }


    public function verifyUser($token)
    {
        $verifyUser = VerifyAddedUser::where('token', $token)->first();
        if (isset($verifyUser)) {
            $user = $verifyUser->user;
            $current_time = Carbon::now('Africa/Nairobi');
            if (!$user->email_verified_at) {
                $verifyUser->user->email_verified_at = $current_time;
                $verifyUser->user->save();
                $status = "Your e-mail is verified. You can now login.";
            } else {
                $status1 = "Your e-mail is already verified. You can now login.";
            }
        } else {
            return redirect('/login')->with('warning', "Sorry your email cannot be identified.");
        }
        Alert::error('Email Verification', 'Email already verified');
        return redirect('/login');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\party  $party
     * @return \Illuminate\Http\Response
     */
    public function show(user $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\party  $party
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\party  $party
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user $user)
    {
        $user->name = ucwords($request->input('name'));
        $user->email = $request->input('email');
        $user->save();

        $just_saved_user_id = $user->id;
        $user->organization_id = $request->input('organization_id');
        $user->job_title = ucwords($request->input('job_title'));
        $user->role_id = $request->input('role_id');

        $users_details_data = array(
            'user_id' => $just_saved_user_id,
            'organization_id' => $user->organization_id,
            'job_title' => $user->job_title
        );

        // echo"<pre>";
        // print_r($users_details_data);
        // exit;

        $role_details_data = array(
            'model_id' => $just_saved_user_id,
            'role_id' => $user->role_id,
        );
        $save_user_details = DB::table('users_details')->where('user_id', $user->id)->update($users_details_data);
        $save_role_details = DB::table('model_has_roles')->where('model_id', $user->id)->update($role_details_data);

        Alert::success('Update User', 'User details successfully updated');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\party  $party
     * @return \Illuminate\Http\Response
     */

    public function getUserProfile()
    {
        $user = Auth::user()->id;
        $auth_users = DB::table('users')
            ->select(
                DB::raw('users.*'),
                DB::raw('users.name AS user_name'),
                DB::raw('users_details.*'),
                DB::raw('users_organizations.*'),
                DB::raw('model_has_roles.*'),
                DB::raw('roles.name AS role_name')
            )
            ->leftJoin('users_details', 'users.id', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('users.id', $user)
            ->orderBy('users.id', 'desc')
            ->first();

        $organizations = DB::table('users_organizations')->pluck('organization_name', 'organization_id')->all();

        return view('contracts.profile')->with([
            'auth_users' => $auth_users,
            'organizations' => $organizations
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'confirm_password' => ['required', 'string', 'min:6'],
        ]);
    }

    public function updateUserProfile(Request $request, user $user)
    {
        try {
            if (Hash::check($request->input('confirm_password'), $user->password)) {
                $user->email = $request->input('email');

                if (!empty($request->input('password'))) {
                    $user->password = Hash::make($request->input('password'));
                    $user->save();
                }
                $user->save();

                $just_updated_user_id = $user->id;
                $user->job_title = ucwords($request->input('job_title'));
                $user->organization_id = $request->organization_id;

                $users_details_data = array(
                    'user_id' => $just_updated_user_id,
                    'organization_id' => $user->organization_id,
                    'job_title' => $user->job_title
                );

                $update_user_details = DB::table('users_details')->where('user_id', $user->id)->update($users_details_data);
                Alert::success('Profile Update', 'Profile updated successfully');
                return back();
            }
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        }
        Alert::error('Profile Update', 'Your current password is wrong');
        return back();
    }
    public function destroy(Request $request, user $user)
    {
        DB::table('users')->where('id', $user->id)->delete();
        Alert::success('Delete User', 'User deleted successfully');
        return back();
    }
}
