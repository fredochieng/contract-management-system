<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Users_Details;
use App\Notifications\UserCreatedNotification;

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
        foreach ($this->roles()->get() as $role) {
            if ($role->id == 6) {
                return true;
            }
        }
        return false;
    }
    public function isUser()
    {
        return $this->hasRole('Standard User');
    }
    public function isLegal()
    {
        return $this->hasRole('Legal Counsel');
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