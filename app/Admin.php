<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\UserCreatedNotification;

class Admin extends Authenticatable implements MustVerifyEmail
{
    // protected $table = 'users';
    use Notifiable;
}