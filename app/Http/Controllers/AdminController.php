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
use Notification;

class AdminController extends Controller
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
        $password_string = "Wananchi.1234";
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        // $user->password = Hash::make($password_string);
        // $user->save();
        $user = User::create([
            'name' =>  $user->name,
            'email' => $user->email,
            'password' => Hash::make($password_string)
        ]);

        $details = [
            'greeting' => 'Hi' . ' ' . $request['name'],
            'body' => 'Thank you for registering to Wananchi Group Legal Management System',
            'thanks' => 'Welcome aboard!',
            'password' => 'Your password is' . $request['password'],
            'actionText' => 'Click here to login',
            'actionURL' => url('/'),
            'Your password is' . $user[$password_string]
        ];

        Notification::send($user, new UserCreatedNotification($details));

        $saved_user_id = $user->id;

        $user_data = array(
            'user_id' => $saved_user_id,
            'organization_id' => $request->input('organization_id'),
            'job_title' => $request->input('job_title')
        );

        $user_role_data = array(
            'model_id' => $saved_user_id,
            'role_id' => $request->input('role_id'),
            'model_type' => 'App\User',
        );

        $save_users_details = DB::table('users_details')->insertGetId($user_data);
        $save_role_details = DB::table('model_has_roles')->insertGetId($user_role_data);
        Alert::success('Create User', 'User successfully created');
        return redirect('system-users/users');
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
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        $just_saved_user_id = $user->id;
        $user->organization_id = $request->input('organization_id');
        $user->job_title = $request->input('job_title');
        $user->role_id = $request->input('role_id');

        $users_details_data = array(
            'user_id' => $just_saved_user_id,
            'organization_id' => $user->organization_id,
            'job_title' => $user->job_title
        );

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
    public function destroy(Request $request, user $user)
    {
        DB::table('users')->where('id', $user->id)->delete();
        Alert::success('Delete User', 'User deleted successfully');
        return back();
    }
}