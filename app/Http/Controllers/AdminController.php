<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $organizations = DB::table('users_organizations')->pluck('organization_name', 'organization_id')->all();
        $roles = DB::table('roles')->pluck('name', 'id')->all();

        $users = DB::table('users')
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
            ->orderBy('users.id', 'desc')
            ->get();
        return view('contracts.users')->with([
            'users' => $users,
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
        $user->password = Hash::make($password_string);
        $user->save();

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
        return redirect('user')->with('success', 'User Successfully saved!');
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
        $this->validate($request, [
            'name' => 'required',
        ]);


        // $party->party_name = $request->input('party_name');
        // $party->address = $request->input('address');
        // $party->telephone = $request->input('telephone');
        // $party->email = $request->input('email');
        // //$party->created_by=Auth::user()->id;
        // $party->updated_by = Auth::user()->id;

        // $party->save();

        // return redirect('party')->with('success', 'Record Successfully saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\party  $party
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $user)
    {
        $user->delete();
        return redirect('user')->with('success', 'Record Successfully Deleted');
    }
}