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
            $total_contracts_count = contract::where($compare_field, $compare_operator, $compare_value)
                ->where(function ($query) {
                    $query->where('contracts.status', '!=', 'created');
                })
                ->where('contracts.legal_approval_id', '=', Auth::user()->id)
                ->count();

        } else {
            $total_contracts_count = contract::where($compare_field, $compare_operator, $compare_value)
                ->where(function ($query) {
                    $query->where('contracts.status', '!=', 'created');
                })->count();
        }
        $created_contract_count = \DB::table('contracts')->where([
            [$compare_field, $compare_operator, $compare_value],
            ['contracts.status', '=', 'created']
        ])->count();
        if (auth()->check()) if (auth()->user()->isLegal()) {
            $approved_contract_count = \DB::table('contracts')->where([
                [$compare_field, $compare_operator, $compare_value],
                ['contracts.status', '=', 'approved'],
                ['contracts.legal_approval_id', '=', Auth::user()->id]
            ])->count();
        } else {
            $approved_contract_count = \DB::table('contracts')->where([
                [$compare_field, $compare_operator, $compare_value],
                ['contracts.status', '=', 'approved']
            ])->count();
        }
        $published_contract_count = \DB::table('contracts')->where([
            [$compare_field, $compare_operator, $compare_value],
            ['contracts.status', '=', 'published']
        ])->count();
        if (auth()->check()) if (auth()->user()->isLegal()) {
            $ammended_contract_count = \DB::table('contracts')->where([
                [$compare_field, $compare_operator, $compare_value],
                ['contracts.status', '=', 'ammended'],
                ['contracts.legal_ammendment_id', '=', Auth::user()->id]
            ])->count();
            //   print_r($ammended_contract_count);
            // exit;
        } else {
            $ammended_contract_count = \DB::table('contracts')->where([
                [$compare_field, $compare_operator, $compare_value],
                ['contracts.status', '=', 'ammended'],
            ])->count();
        }
        if (auth()->check()) if (auth()->user()->isLegal()) {
            $terminated_contract_count = \DB::table('contracts')->where([
                [$compare_field, $compare_operator, $compare_value],
                ['contracts.status', '=', 'terminated'],
                ['contracts.legal_termination_id', '=', Auth::user()->id]
            ])->count();
        } else {
            $terminated_contract_count = \DB::table('contracts')->where([
                [$compare_field, $compare_operator, $compare_value],
                ['contracts.status', '=', 'terminated']
            ])->count();

        }

        if ($total_contracts_count == 0) {
            $total_contracts_count = 0;
            $approved_percentage = 0;
            $ammended_percentage = 0;
            $terminated_percentage = 0;
            $published_percentage = 0;
        } else {
            $approved_percentage = ($approved_contract_count * 100) / $total_contracts_count;
            $ammended_percentage = ($ammended_contract_count * 100) / $total_contracts_count;
            $terminated_percentage = ($terminated_contract_count * 100) / $total_contracts_count;
            $published_percentage = ($published_contract_count * 100) / $total_contracts_count;
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
            $contract_status = 'published';
            $contract_status1 = 'approved';
        }
//          elseif (auth()->user()->isLegal()) {
//             $contract_status = 'published';
//         //     $contract_status1 = 'approved';
//  }
        elseif (auth()->user()->isUser()) {
            $contract_status = 'approved';
            $contract_status1 = 'ammended';
        }
        if (auth()->user()->isLegal()) {
            $contract_status = 'published';
            $contract_status1 = 'approved';
            $contract_status2 = 'published';
            $contract_status3 = 'approved';
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
                ['contracts.status', '=', $contract_status],

            ])
            ->get();

        // Dashboard Table Two
        $contracts1 = DB::table('contracts')
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
                ['contracts.status', '=', $contract_status1]
            ])
            ->get();

        $legal_approved_contracts = DB::table('contracts')
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
                ['contracts.status', '=', $contract_status],

            ])
            ->get();

        $users = User::all();
        $organizations = DB::table('users_organizations')->pluck('organization_name', 'organization_id')->all();
        $roles = DB::table('roles')->pluck('name', 'id')->all();

        $user = Auth::user();
        ~$user_role = $user->getRoleNames()->first();
        $users = DB::table('users')
            ->select(
                DB::raw('users.*'),
                DB::raw('users_details.*'),
                DB::raw('users_organizations.*'),
                DB::raw('model_has_roles.*'),
                DB::raw('roles.name AS role_name')

            )
            ->leftJoin('users_details', 'users.id', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('users.id', '>', 2)
            ->orderBy('users.id', 'desc')
            ->get();

        return view('home')->with([
            'contracts' => $contracts,
            'contracts1' => $contracts1,
            'legal_approved_contracts' => $legal_approved_contracts,
            'users' => $users,
            'organizations' => $organizations,
            'roles' => $roles,
            'total_contracts_count' => $total_contracts_count,
            'created_contract_count' => $created_contract_count,
            'published_contract_count' => $published_contract_count,
            'approved_contract_count' => $approved_contract_count,
            'terminated_contract_count' => $terminated_contract_count,
            'ammended_contract_count' => $ammended_contract_count,
            'approved_percentage' => $approved_percentage,
            'ammended_percentage' => $ammended_percentage,
            'terminated_percentage' => $terminated_percentage,
            'published_percentage' => $published_percentage
        ]);
    }
}
