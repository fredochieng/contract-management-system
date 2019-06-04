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
use Carbon\Carbon;
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
        $this->middleware('verified');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        if (auth()->check()) if (auth()->user()->isAdmin()) {
            $compare_field = "contracts.contract_id";
            $compare_operator = ">=";
            $compare_value = 1;
        } elseif (auth()->user()->isLegal()) {
            $compare_field = "contracts.contract_id";
            $compare_operator = ">=";
            $compare_value = 1;
        } else {
            $compare_field = 'contracts.created_by';
            $compare_operator = "=";
            $compare_value = Auth::user()->id;
        }

        if (auth()->check()) if (auth()->user()->isLegal()) {

            $data['draft_review_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '2')
                ->where('contracts.status', '=', '2')
                ->where('contracts.assigned_user_id', '=', Auth::user()->id)
                ->count();

            $data['final_draft_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '3')
                ->where('contracts.status', '=', '2')
                ->where('contracts.assigned_user_id', '=', Auth::user()->id)
                ->count();

            $data['sign_off_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '4')
                ->where('contracts.status', '=', '2')
                ->where('contracts.assigned_user_id', '=', Auth::user()->id)
                ->count();

            $data['tot_reviewed_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.status', '=', '2')
                ->where('contracts.assigned_user_id', '=', Auth::user()->id)
                ->count();

            $data['approved_contract_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '5')
                ->where('contracts.status', '=', '3')
                ->where('contracts.assigned_user_id', '=', Auth::user()->id)
                ->count();

            $data['closed_contract_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '6')
                ->where('contracts.status', '=', '4')
                ->where('contracts.assigned_user_id', '=', Auth::user()->id)
                ->count();

            $data['total_contracts_count'] =  $data['draft_review_count'] + $data['final_draft_count']  +
                $data['sign_off_count'] + $data['approved_contract_count'] + $data['closed_contract_count'];
        } else {
            $data['total_contracts_count'] = contract::where($compare_field, $compare_operator, $compare_value)
                ->where(function ($query) {
                    $query->where('contracts.contract_id', '>=', '1');
                })->count();
        }
        if (auth()->check()) if (auth()->user()->isLegal()) {
            $data['draft_review_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '2')
                ->where('contracts.status', '=', '2')
                ->where('contracts.assigned_user_id', '=', Auth::user()->id)
                ->count();

            $data['final_draft_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '3')
                ->where('contracts.status', '=', '2')
                ->where('contracts.assigned_user_id', '=', Auth::user()->id)
                ->count();

            $data['sign_off_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '4')
                ->where('contracts.status', '=', '2')
                ->where('contracts.assigned_user_id', '=', Auth::user()->id)
                ->count();

            $data['tot_reviewed_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.status', '=', '2')
                ->where('contracts.assigned_user_id', '=', Auth::user()->id)
                ->count();

            $data['approved_contract_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '5')
                ->where('contracts.status', '=', '3')
                ->where('contracts.assigned_user_id', '=', Auth::user()->id)
                ->count();

            $data['closed_contract_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '6')
                ->where('contracts.status', '=', '4')
                ->where('contracts.assigned_user_id', '=', Auth::user()->id)
                ->count();
        } else {
            $data['draft_review_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '2')
                ->where('contracts.status', '=', '2')
                ->count();

            $data['final_draft_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '3')
                ->where('contracts.status', '=', '2')
                ->count();

            $data['sign_off_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '4')
                ->where('contracts.status', '=', '2')
                ->count();

            $data['tot_reviewed_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.status', '=', '2')
                ->count();

            $data['approved_contract_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '5')
                ->where('contracts.status', '=', '3')
                ->count();

            $data['closed_contract_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '6')
                ->where('contracts.status', '=', '4')
                ->count();
        }
        $data['draft_created_count'] = \DB::table('contracts')->where([
            [$compare_field, $compare_operator, $compare_value],
            ['contracts.stage', '=', '1'],
            ['contracts.status', '=', '1']
        ])->count();

        if ($data['total_contracts_count'] == 0) {
            $data['total_contracts_count'] = 0;
            $data['draft_created_per'] = 0;
            $data['draft_review_per'] = 0;
            $data['final_draft_per'] = 0;
            $data['sign_off_per'] = 0;
            $data['reviewed_per'] = 0;
            $data['approved_per'] = 0;
            $data['closed_per'] = 0;
        } else {
            $data['draft_created_per'] = ($data['draft_created_count']  * 100) / $data['total_contracts_count'];
            $data['draft_review_per'] = ($data['draft_review_count']  * 100) / $data['total_contracts_count'];
            $data['draft_created_per'] = ($data['draft_created_count']  * 100) / $data['total_contracts_count'];
            $data['final_draft_per'] = ($data['final_draft_count']  * 100) / $data['total_contracts_count'];
            $data['sign_off_per'] = ($data['sign_off_count']  * 100) / $data['total_contracts_count'];
            $data['reviewed_per'] = ($data['tot_reviewed_count']  * 100) / $data['total_contracts_count'];
            $data['approved_per'] = ($data['approved_contract_count']  * 100) / $data['total_contracts_count'];
            $data['closed_per'] = ($data['closed_contract_count']  * 100) / $data['total_contracts_count'];
        }

        if (auth()->check()) if (auth()->user()->isAdmin() || auth()->user()->isLegal()) {
            $compare_field = "contracts.contract_id";
            $compare_operator = ">=";
            $compare_value = 1;
        } else {
            $compare_field = 'contracts.created_by';
            $compare_operator = "=";
            $compare_value = Auth::user()->id;
        }
        if (auth()->check()) if (auth()->user()->isAdmin()) {
            $contract_stage = '1';
            $contract_status = '1';

            $contract_stage1 = '6';
            $contract_status1 = '4';

            // $contract_assigned = '';
            // $contract_assigned1 = 1;
        } elseif (auth()->user()->isUser()) {
            $contract_stage = '5';
            $contract_status = '3';

            $contract_stage1 = '6';
            $contract_status1 = '4';

            // $contract_assigned = '';
            // $contract_assigned1 = 1;
        }
        if (auth()->user()->isLegal()) {
            $contract_stage = '1';
            $contract_status = '1';

            $contract_stage2= '6';
            $contract_status2 = '4';

            // $contract_assigned = '';
            // $contract_assigned1 = 1;
        }
        $data['contracts'] = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('contracts.status AS contract_status'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('contracts.published_time AS contract_published_time'),
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
            ->orderBy('contracts.published_time', 'desc')
            ->where([
                [$compare_field, $compare_operator, $compare_value],
                ['contracts.stage', '=', $contract_stage],
                ['contracts.status', '=', $contract_status]
            ])
            ->get();

        // echo"<pre>";
        // print_r($data['contracts']);
        // exit;

        $data['contracts']->map(function ($item) {
            $published_time = Carbon::parse($item->created_at);
            $current_time = Carbon::now('Africa/Nairobi');
            $duration = $current_time->diffInMinutes($published_time);
            $item->escalation_duration = $duration;
            return $item;
        });

        // Dashboard Table Two
        if (auth()->check()) if (auth()->user()->isAdmin() || auth()->user()->isUser()) {
            $data['contracts1'] = DB::table('contracts')
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
                ->orderBy('contracts.updated_at', 'desc')->take(4)
                ->where([
                    [$compare_field, $compare_operator, $compare_value],
                    ['contracts.stage', '=', $contract_stage1],
                    ['contracts.status', '=', $contract_status1]
                ])
                ->get();
        } elseif (auth()->user()->isLegal()) {

            $data['contracts1'] = DB::table('contracts')
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
                    ['contracts.stage', '=', $contract_stage2],
                    ['contracts.status', '=', $contract_status2],
                    ['contracts.assigned_user_id', '=', Auth::user()->id]
                ])
                ->get();
        }

        $data['parties'] = DB::table('parties')
            ->select(
                DB::raw('parties.*')
            )
            ->orderBy('parties.party_id', 'desc')
            ->get();

        $data['assigned_contracts'] = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('contracts.status AS contract_status'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('contracts.published_time AS contract_published_time'),
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
            ->orderBy('contracts.published_time', 'desc')
            ->where([
                [$compare_field, $compare_operator, $compare_value],
                ['contracts.assigned_user_id', '=', Auth::user()->id]
            ])
            ->get();

        return view('dashboard')->with($data);
    }
}
