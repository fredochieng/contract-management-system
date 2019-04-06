<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class party extends Model
{
    protected $primaryKey = 'party_id';
    protected $table = 'parties';

    public static function contract_drafts(request $request){
        // $contract_drafts = DB::table('contract_drafts')
        //     ->select(
        //         DB::raw('contract_drafts.*'),
        //         DB::raw('contract_drafts.created_at AS contract_drafts_created_at'),
        //         DB::raw('contract_drafts.updated_at AS contract_drafts_update_at'),
        //         DB::raw('contract_drafts.created_by AS contract_drafts_created_by'),
        //         DB::raw('contract_drafts.status AS contract_drafts_status'),
        //         DB::raw('contracts.status AS contract_status'),
        //         DB::raw('contracts.*'),
        //         DB::raw('contracts.created_at AS contracts_created_at'),
        //         DB::raw('contracts.updated_at AS contracts_update_at'),
        //         DB::raw('parties.*'),
        //         DB::raw('users.name'),
        //         DB::raw('users.id'),
        //         DB::raw('users_details.*'),
        //         DB::raw('users_organizations.*'),
        //         DB::raw('draft_stages.*')
        //     )
        //     ->leftJoin('contracts', 'contracts.contract_id', '=', 'contract_drafts.contract_id')
        //     ->leftJoin('parties', 'parties.party_id', '=', 'contracts.party_name_id')
        //     ->leftJoin('users', 'users.id', '=', 'contract_drafts.created_by')
        //     ->leftJoin('users_details', 'users_details.user_id', '=', 'contracts.created_by')
        //     ->leftJoin('users_organizations', 'users_organizations.organization_id', '=', 'users_details.organization_id')
        //     ->leftJoin('draft_stages', 'draft_stages.draft_stage_id', '=', 'contract_drafts.stage_id')
        //     ->orderBy('contract_drafts.contract_draft_id', 'desc')
        //     ->where('contract_drafts.contract_id', '=', $request->contract_id)
        //     ->get();

        //     return $contract_drafts;
    }
}