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
            $closed_contract_count = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.status', '=', 'Closed')
                ->where('contracts.legal_approval_id', '=', Auth::user()->id)
                ->count();

            $ammended_contract_count = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.legal_ammendment_id', '=', Auth::user()->id)
                ->count();

            $terminated_contract_count = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.legal_termination_id', '=', Auth::user()->id)
                ->count();

            $total_contracts_count = $closed_contract_count + $ammended_contract_count + $terminated_contract_count;
        } else {
            $total_contracts_count = contract::where($compare_field, $compare_operator, $compare_value)
                ->where(function ($query) {
                    $query->where('contracts.status', '!=', 'Created');
                })->count();
        }
        $created_contract_count = \DB::table('contracts')->where([
            [$compare_field, $compare_operator, $compare_value],
            ['contracts.status', '=', 'Created']
        ])->count();
        if (auth()->check()) if (auth()->user()->isLegal()) {
            $approved_contract_count = \DB::table('contracts')->where([
                [$compare_field, $compare_operator, $compare_value],
                ['contracts.status', '=', 'Approved'],
                ['contracts.legal_approval_id', '=', Auth::user()->id]
            ])->count();

            $closed_contract_count = \DB::table('contracts')->where([
                [$compare_field, $compare_operator, $compare_value],
                ['contracts.status', '=', 'Closed'],
                ['contracts.legal_approval_id', '=', Auth::user()->id]
            ])->count();
        } else {
            $approved_contract_count = \DB::table('contracts')->where([
                [$compare_field, $compare_operator, $compare_value],
                ['contracts.status', '=', 'Approved']
            ])->count();

            $closed_contract_count = \DB::table('contracts')->where([
                [$compare_field, $compare_operator, $compare_value],
                ['contracts.status', '=', 'Closed']
            ])->count();
        }
        $published_contract_count = \DB::table('contracts')->where([
            [$compare_field, $compare_operator, $compare_value],
            ['contracts.status', '=', 'Pending']
        ])->count();
        if (auth()->check()) if (auth()->user()->isLegal()) {
            $ammended_contract_count = \DB::table('contracts')->where([
                [$compare_field, $compare_operator, $compare_value],
                ['contracts.status', '=', 'Amended'],
                ['contracts.legal_ammendment_id', '=', Auth::user()->id]
            ])->count();
        } else {
            $ammended_contract_count = \DB::table('contracts')->where([
                [$compare_field, $compare_operator, $compare_value],
                ['contracts.status', '=', 'Amended'],
            ])->count();
        }
        if (auth()->check()) if (auth()->user()->isLegal()) {
            $terminated_contract_count = \DB::table('contracts')->where([
                [$compare_field, $compare_operator, $compare_value],
                ['contracts.status', '=', 'Terminated'],
                ['contracts.legal_termination_id', '=', Auth::user()->id]
            ])->count();
        } else {
            $terminated_contract_count = \DB::table('contracts')->where([
                [$compare_field, $compare_operator, $compare_value],
                ['contracts.status', '=', 'Terminated']
            ])->count();
        }

        if ($total_contracts_count == 0) {
            $total_contracts_count = 0;
            $approved_percentage = 0;
            $closed_percentage = 0;
            $ammended_percentage = 0;
            $terminated_percentage = 0;
            $published_percentage = 0;
        } else {
            $closed_percentage = ($closed_contract_count * 100) / $total_contracts_count;
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
            $contract_status = 'pending';
            $contract_status1 = 'closed';
            $contract_assigned = '';
            $contract_assigned1 = 1;
        } elseif (auth()->user()->isUser()) {
            $contract_status = 'approved';
            $contract_status1 = 'amended';
            $contract_assigned = 1;
            $contract_assigned1 = 1;
        }
        if (auth()->user()->isLegal()) {
            $contract_status = 'pending';
            $contract_status2 = 'closed';
            $contract_assigned = '';
            $contract_assigned1 = 1;
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
                ['contracts.status', '=', $contract_status],
                ['contracts.assigned', '=', $contract_assigned]
            ])
            ->get();


        $contracts->map(function ($item) {
            $published_time = Carbon::parse($item->contract_published_time);
            $current_time = Carbon::now('Africa/Nairobi');
            $duration = $current_time->diffInMinutes($published_time);
            $item->escalation_duration = $duration;
            return $item;
        });

        // Dashboard Table Two
        if (auth()->check()) if (auth()->user()->isAdmin() || auth()->user()->isUser()) {
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
                ->orderBy('contracts.updated_at', 'desc')->take(4)
                ->where([
                    [$compare_field, $compare_operator, $compare_value],
                    ['contracts.status', '=', $contract_status1]
                ])
                ->get();
        } elseif (auth()->user()->isLegal()) {
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
                    ['contracts.status', '=', $contract_status2],
                    ['contracts.legal_approval_id', '=', Auth::user()->id]
                ])
                ->get();
        }

        $parties = DB::table('parties')
            ->select(
                DB::raw('parties.*')
            )
            ->leftJoin('contracts', 'parties.party_id', '=', 'contracts.party_name_id')
            ->orderBy('parties.party_id', 'desc')->take(4)
            ->get();

        $assigned_contracts = DB::table('contracts')
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
                ['contracts.status', '=', $contract_status],
                ['contracts.assigned', '=', $contract_assigned1],
                ['contracts.assigned_user_id', '=', Auth::user()->id]
            ])
            ->get();


        return view('dashboard')->with([
            'contracts' => $contracts,
            'contracts1' => $contracts1,
            'parties' => $parties,
            'assigned_contracts' => $assigned_contracts,
            'total_contracts_count' => $total_contracts_count,
            'created_contract_count' => $created_contract_count,
            'published_contract_count' => $published_contract_count,
            'approved_contract_count' => $approved_contract_count,
            'closed_contract_count' => $closed_contract_count,
            'terminated_contract_count' => $terminated_contract_count,
            'ammended_contract_count' => $ammended_contract_count,
            'approved_percentage' => $approved_percentage,
            'closed_percentage' => $closed_percentage,
            'ammended_percentage' => $ammended_percentage,
            'terminated_percentage' => $terminated_percentage,
            'published_percentage' => $published_percentage
        ]);
    }
}
