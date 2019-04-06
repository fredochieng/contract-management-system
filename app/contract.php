<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class contract extends Model
{
    protected $primaryKey = 'contract_id';

    public static function contracts (request $request)
    {
        // $contract = DB::table('contracts')
        //     ->select(
        //         DB::raw('contracts.*'),
        //         DB::raw('parties.*'),
        //         DB::raw('users.name'),
        //         DB::raw('users.id'),
        //         DB::raw('users_details.*'),
        //         DB::raw('contracts.created_at AS created_date'),
        //         DB::raw('contracts.status AS contract_status'),
        //         DB::raw('contracts.stage AS contract_stage'),
        //         DB::raw('draft_stages.task AS draft_stages_task'),
        //         DB::raw('users_organizations.*'),
        //         DB::raw('contract_drafts.*'),
        //         DB::raw('draft_stages.*'),
        //         DB::raw('contract_types.*')
        //     )

        //     ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
        //     ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
        //     ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
        //     ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
        //     ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
        //     ->leftJoin('draft_stages', 'contract_drafts.stage_id', '=', 'draft_stages.draft_stage_id')
        //     ->leftJoin('contract_types', 'contracts.contract_type', '=', 'contract_types.contract_type_id')
        //     ->orderBy('contracts.contract_id', 'desc')
        //     ->where('contracts.contract_id', '=', $request->contract_id)
        //     ->first();

        //     return $contract;

    }
}