<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ContractTerm extends Model
{
    protected $table = 'contract_duration';
    public static function getContractTerm()
    {
        $terms = DB::table('contract_duration')->orderBy('id', 'asc')->get();
        return $terms;
    }

}
