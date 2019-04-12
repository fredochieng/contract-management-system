<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\contract;
use Illuminate\Support\Facades\Auth;
use DB;

use App\party;
use App\contract_drafts;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\User;
use function GuzzleHttp\json_decode;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_contracts_count = \DB::table('contracts')
            ->where('contracts.status', '=', 'approved')
            ->orwhere('contracts.status', '=', 'submitted')
            ->orwhere('contracts.status', '=', 'ammended')
            ->orwhere('contracts.status', '=', 'terminated')
            ->orwhere('contracts.status', '=', 'published')
            ->count();
        $submitted_contract_count = \DB::table('contracts')->where('contracts.status', '=', 'submitted')->count();
        $published_contract_count = \DB::table('contracts')->where('contracts.status', '=', 'published')->count();
        $approved_contract_count = \DB::table('contracts')->where('contracts.status', '=', 'approved')->count();
        $ammended_contract_count = \DB::table('contracts')->where('contracts.status', '=', 'ammended')->count();
        $terminated_contract_count = \DB::table('contracts')->where('contracts.status', '=', 'terminated')->count();

        $approved_percentage = ($approved_contract_count*100)/$total_contracts_count;
        $submitted_percentage = ( $submitted_contract_count * 100) / $total_contracts_count;
        $ammended_percentage = ( $ammended_contract_count * 100) / $total_contracts_count;
        $terminated_percentage = ( $terminated_contract_count * 100) / $total_contracts_count;
        $published_percentage = ($published_contract_count * 100) / $total_contracts_count;
        //    print_r( $approved_percentage);
        // exit;

        $user = Auth::user();
        ~$user_role = $user->getRoleNames()->first();
        if ($user_role == "Admin") {
            $compare_field = "contracts.contract_id";
            $compare_operator = ">=";
            $compare_value = 1;
        } else {
            $compare_field = 'contracts.created_by';
            $compare_operator = "=";
            $compare_value = Auth::user()->id;
        }
        $contracts = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('contracts.status AS contract_status'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('contracts.stage AS contract_stage'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('draft_stages.*')
            )

            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where([
                [$compare_field, $compare_operator, $compare_value],
                ['contracts.status', '=', 'submitted']
            ])
            ->get();
        // print_r($contracts);
        // exit;
        return view('home')->with([
            'contracts' => $contracts,
            'submitted_contract_count' => $submitted_contract_count,
            'published_contract_count' => $published_contract_count,
            'approved_contract_count' => $approved_contract_count,
            'ammended_contract_count' => $ammended_contract_count,
            'approved_percentage' => $approved_percentage,
            'submitted_percentage' =>$submitted_percentage,
            'ammended_percentage' =>$ammended_percentage,
            'terminated_percentage' =>$terminated_percentage,
            'published_percentage' => $published_percentage

        ]);
    }
}