<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Entity extends Model
{
    protected $table = 'users_organizations';
    public static function getEntities(){
        $entities = DB::table('users_organizations')->orderBy('organization_id','asc')->get();
        return $entities;
    }
}
