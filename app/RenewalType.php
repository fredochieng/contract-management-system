<?php

namespace App;

use DB;

use Illuminate\Database\Eloquent\Model;

class RenewalType extends Model
{
    protected $table = 'contracts_renewal_types';
    public static function getRenewalTypes()
    {
        $renewal_types = DB::table('contracts_renewal_types')->orderBy('id', 'asc')->get();
        return $renewal_types;
    }
}
