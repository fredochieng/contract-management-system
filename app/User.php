<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Users_Details;
use App\Notifications\UserCreatedNotification;
use DB;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    public function users_details()
    {
        return $this->hasOne('Users_Details');
    }

    protected $table = 'users';

    public function isAdmin()
    {
        return $this->hasRole('Admin');
    }
    public function isUser()
    {
        return $this->hasRole('Standard User');
    }
    public function isLegal()
    {
        return $this->hasRole('Legal Counsel');
    }

    public function verifyUser()
    {
        return $this->hasOne('App\VerifyAddedUser');
    }

    public static function getLegalUsers(){
          $legal_users = DB::table('users')->select(DB::raw('users.*'), DB::raw('model_has_roles.*'),DB::raw('roles.name AS role_name'))
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('roles.name', 'Legal Counsel')
            ->inRandomOrder()
            ->take(1)
            ->first();
        return $legal_users;
    }

    public static function getLegalMembers(){
        $legal_members = DB::table('users')->select(DB::raw('users.*'), DB::raw('model_has_roles.*'), DB::raw('roles.name AS role_name'))
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('roles.name', '!=', 'Standard User')
            ->get();
        return $legal_members;
    }

    public static function getLegalAdmin(){
        $legal_members = DB::table('users')->select(DB::raw('users.*'), DB::raw('model_has_roles.*'), DB::raw('roles.name AS role_name'))
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('roles.name', '=', 'Admin')
            ->get();
        return $legal_members;
    }

    public static function getUsers(){
        $legal_members = DB::table('users')->select(DB::raw('users.*'), DB::raw('model_has_roles.*'), DB::raw('roles.name AS role_name'))
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('roles.name', '=', 'Admin')
            ->get();
        return $legal_members;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
