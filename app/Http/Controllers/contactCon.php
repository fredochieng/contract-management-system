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
    // public function index()
    // {
    //     if (auth()->check()) if (auth()->user()->isAdmin()) {
    //         $compare_field = "contracts.contract_id";
    //         $compare_operator = ">=";
    //         $compare_value = 1;
    //     } elseif (auth()->user()->isLegal()) {
    //         $compare_field = "contracts.contract_id";
    //         $compare_operator = ">=";
    //         $compare_value = 1;
    //     } else {
    //         $compare_field = 'contracts.created_by';
    //         $compare_operator = "=";
    //         $compare_value = Auth::user()->id;
    //     }

    //     if (auth()->check()) if (auth()->user()->isLegal()) {
    //         $closed_contract_count = \DB::table('contracts')
    //             ->where($compare_field, $compare_operator, $compare_value)
    //             ->where('contracts.status', '=', 'Closed')
    //             ->where('contracts.legal_approval_id', '=', Auth::user()->id)
    //             ->count();

    //         $approved_contract_count = \DB::table('contracts')
    //             ->where($compare_field, $compare_operator, $compare_value)
    //             ->where('contracts.status', '=', 'Approved')
    //             ->where('contracts.legal_approval_id', '=', Auth::user()->id)
    //             ->count();

    //         $ammended_contract_count = \DB::table('contracts')
    //             ->where($compare_field, $compare_operator, $compare_value)
    //             ->where('contracts.legal_ammendment_id', '=', Auth::user()->id)
    //             ->count();

    //         $terminated_contract_count = \DB::table('contracts')
    //             ->where($compare_field, $compare_operator, $compare_value)
    //             ->where('contracts.legal_termination_id', '=', Auth::user()->id)
    //             ->count();

    //         $total_contracts_count = $closed_contract_count + $approved_contract_count + $ammended_contract_count + $terminated_contract_count;
    //     } else {
    //         $total_contracts_count = contract::where($compare_field, $compare_operator, $compare_value)
    //             ->where(function ($query) {
    //                 $query->where('contracts.contract_id', '>=', '1');
    //             })->count();
    //     }
    //     $created_contract_count = \DB::table('contracts')->where([
    //         [$compare_field, $compare_operator, $compare_value],
    //         ['contracts.status', '=', 'Created']
    //     ])->count();
    //     if (auth()->check()) if (auth()->user()->isLegal()) {
    //         $approved_contract_count = \DB::table('contracts')->where([
    //             [$compare_field, $compare_operator, $compare_value],
    //             ['contracts.status', '=', 'Approved'],
    //             ['contracts.legal_approval_id', '=', Auth::user()->id]
    //         ])->count();

    //         $closed_contract_count = \DB::table('contracts')->where([
    //             [$compare_field, $compare_operator, $compare_value],
    //             ['contracts.status', '=', 'Closed'],
    //             ['contracts.legal_approval_id', '=', Auth::user()->id]
    //         ])->count();
    //     } else {
    //         $approved_contract_count = \DB::table('contracts')->where([
    //             [$compare_field, $compare_operator, $compare_value],
    //             ['contracts.status', '=', 'Approved']
    //         ])->count();

    //         $closed_contract_count = \DB::table('contracts')->where([
    //             [$compare_field, $compare_operator, $compare_value],
    //             ['contracts.status', '=', 'Closed']
    //         ])->count();
    //     }
    //     $published_contract_count = \DB::table('contracts')->where([
    //         [$compare_field, $compare_operator, $compare_value],
    //         ['contracts.stage', '=', '1'],
    //         ['contracts.status', '=', '1']
    //     ])->count();
    //     $published_contract_count = \DB::table('contracts')->where([
    //         [$compare_field, $compare_operator, $compare_value],
    //         ['contracts.stage', '=', '1'],
    //         ['contracts.status', '=', '1']
    //     ])->count();
    //     if (auth()->check()) if (auth()->user()->isLegal()) {
    //         $ammended_contract_count = \DB::table('contracts')->where([
    //             [$compare_field, $compare_operator, $compare_value],
    //             ['contracts.status', '=', 'Amended'],
    //             ['contracts.legal_ammendment_id', '=', Auth::user()->id]
    //         ])->count();
    //     } else {
    //         $ammended_contract_count = \DB::table('contracts')->where([
    //             [$compare_field, $compare_operator, $compare_value],
    //             ['contracts.status', '=', 'Amended'],
    //         ])->count();
    //     }
    //     if (auth()->check()) if (auth()->user()->isLegal()) {
    //         $terminated_contract_count = \DB::table('contracts')->where([
    //             [$compare_field, $compare_operator, $compare_value],
    //             ['contracts.status', '=', 'Terminated'],
    //             ['contracts.legal_termination_id', '=', Auth::user()->id]
    //         ])->count();
    //     } else {
    //         $terminated_contract_count = \DB::table('contracts')->where([
    //             [$compare_field, $compare_operator, $compare_value],
    //             ['contracts.status', '=', 'Terminated']
    //         ])->count();
    //     }

    //     if ($total_contracts_count == 0) {
    //         $total_contracts_count = 0;
    //         $approved_percentage = 0;
    //         $closed_percentage = 0;
    //         $ammended_percentage = 0;
    //         $terminated_percentage = 0;
    //         $published_percentage = 0;
    //     } else {
    //         $closed_percentage = ($closed_contract_count * 100) / $total_contracts_count;
    //         $approved_percentage = ($approved_contract_count * 100) / $total_contracts_count;
    //         $ammended_percentage = ($ammended_contract_count * 100) / $total_contracts_count;
    //         $terminated_percentage = ($terminated_contract_count * 100) / $total_contracts_count;
    //         $published_percentage = ($published_contract_count * 100) / $total_contracts_count;
    //     }

    //     if (auth()->check()) if (auth()->user()->isAdmin() || auth()->user()->isLegal()) {
    //         $compare_field = "contracts.contract_id";
    //         $compare_operator = ">=";
    //         $compare_value = 1;
    //     } else {
    //         $compare_field = 'contracts.created_by';
    //         $compare_operator = "=";
    //         $compare_value = Auth::user()->id;
    //     }
    //     if (auth()->check()) if (auth()->user()->isAdmin()) {
    //         $contract_status = 'Pending';
    //         $contract_status1 = 'Closed';
    //         $contract_assigned = '';
    //         $contract_assigned1 = 1;
    //     } elseif (auth()->user()->isUser()) {
    //         $contract_status = 'Approved';
    //         $contract_status1 = 'Amended';
    //         $contract_assigned = 1;
    //         $contract_assigned1 = 1;
    //     }
    //     if (auth()->user()->isLegal()) {
    //         $contract_status = 'Pending';
    //         $contract_status2 = 'Closed';
    //         $contract_assigned = '';
    //         $contract_assigned1 = 1;
    //     }
    //     $contracts = DB::table('contracts')
    //         ->select(
    //             DB::raw('contracts.*'),
    //             DB::raw('contracts.status AS contract_status'),
    //             DB::raw('parties.*'),
    //             DB::raw('users.name'),
    //             DB::raw('users.id'),
    //             DB::raw('users_details.*'),
    //             DB::raw('contracts.created_at AS created_date'),
    //             DB::raw('contracts.published_time AS contract_published_time'),
    //             DB::raw('contracts.stage AS contract_stage'),
    //             DB::raw('users_organizations.*'),
    //             DB::raw('contract_drafts.*'),
    //             DB::raw('draft_stages.*')
    //         )
    //         ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
    //         ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
    //         ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
    //         ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
    //         ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
    //         ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
    //         ->orderBy('contracts.published_time', 'desc')
    //         ->where([
    //             [$compare_field, $compare_operator, $compare_value],
    //             ['contracts.status', '=', $contract_status],
    //             ['contracts.assigned', '=', $contract_assigned]
    //         ])
    //         ->get();


    //     $contracts->map(function ($item) {
    //         $published_time = Carbon::parse($item->contract_published_time);
    //         $current_time = Carbon::now('Africa/Nairobi');
    //         $duration = $current_time->diffInMinutes($published_time);
    //         $item->escalation_duration = $duration;
    //         return $item;
    //     });

    //     // Dashboard Table Two
    //     if (auth()->check()) if (auth()->user()->isAdmin() || auth()->user()->isUser()) {
    //         $contracts1 = DB::table('contracts')
    //             ->select(
    //                 DB::raw('contracts.*'),
    //                 DB::raw('contracts.status AS contract_status'),
    //                 DB::raw('parties.*'),
    //                 DB::raw('users.name'),
    //                 DB::raw('users.id'),
    //                 DB::raw('users_details.*'),
    //                 DB::raw('contracts.created_at AS created_date'),
    //                 DB::raw('contracts.stage AS contract_stage'),
    //                 DB::raw('users_organizations.*'),
    //                 DB::raw('contract_drafts.*'),
    //                 DB::raw('draft_stages.*')
    //             )

    //             ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
    //             ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
    //             ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
    //             ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
    //             ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
    //             ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
    //             ->orderBy('contracts.updated_at', 'desc')->take(4)
    //             ->where([
    //                 [$compare_field, $compare_operator, $compare_value],
    //                 ['contracts.status', '=', $contract_status1]
    //             ])
    //             ->get();
    //     } elseif (auth()->user()->isLegal()) {

    //         $contracts1 = DB::table('contracts')
    //             ->select(
    //                 DB::raw('contracts.*'),
    //                 DB::raw('contracts.status AS contract_status'),
    //                 DB::raw('parties.*'),
    //                 DB::raw('users.name'),
    //                 DB::raw('users.id'),
    //                 DB::raw('users_details.*'),
    //                 DB::raw('contracts.created_at AS created_date'),
    //                 DB::raw('contracts.stage AS contract_stage'),
    //                 DB::raw('users_organizations.*'),
    //                 DB::raw('contract_drafts.*'),
    //                 DB::raw('draft_stages.*')
    //             )

    //             ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
    //             ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
    //             ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
    //             ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
    //             ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
    //             ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
    //             ->orderBy('contracts.contract_id', 'desc')
    //             ->where([
    //                 [$compare_field, $compare_operator, $compare_value],
    //                 ['contracts.status', '=', $contract_status2],
    //                 ['contracts.legal_approval_id', '=', Auth::user()->id]
    //             ])
    //             ->get();
    //     }

    //     $parties = DB::table('parties')
    //         ->select(
    //             DB::raw('parties.*')
    //         )
    //         ->orderBy('parties.party_id', 'desc')
    //         ->get();

    //     $assigned_contracts = DB::table('contracts')
    //         ->select(
    //             DB::raw('contracts.*'),
    //             DB::raw('contracts.status AS contract_status'),
    //             DB::raw('parties.*'),
    //             DB::raw('users.name'),
    //             DB::raw('users.id'),
    //             DB::raw('users_details.*'),
    //             DB::raw('contracts.created_at AS created_date'),
    //             DB::raw('contracts.published_time AS contract_published_time'),
    //             DB::raw('contracts.stage AS contract_stage'),
    //             DB::raw('users_organizations.*'),
    //             DB::raw('contract_drafts.*'),
    //             DB::raw('draft_stages.*')
    //         )
    //         ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
    //         ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
    //         ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
    //         ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
    //         ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
    //         ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
    //         ->orderBy('contracts.published_time', 'desc')
    //         ->where([
    //             [$compare_field, $compare_operator, $compare_value],
    //             ['contracts.status', '=', $contract_status],
    //             ['contracts.assigned', '=', $contract_assigned1],
    //             ['contracts.assigned_user_id', '=', Auth::user()->id]
    //         ])
    //         ->get();

    //     return view('dashboard')->with([
    //         'contracts' => $contracts,
    //         'contracts1' => $contracts1,
    //         'parties' => $parties,
    //         'assigned_contracts' => $assigned_contracts,
    //         'total_contracts_count' => $total_contracts_count,
    //         'created_contract_count' => $created_contract_count,
    //         'published_contract_count' => $published_contract_count,
    //         'approved_contract_count' => $approved_contract_count,
    //         'closed_contract_count' => $closed_contract_count,
    //         'terminated_contract_count' => $terminated_contract_count,
    //         'ammended_contract_count' => $ammended_contract_count,
    //         'approved_percentage' => $approved_percentage,
    //         'closed_percentage' => $closed_percentage,
    //         'ammended_percentage' => $ammended_percentage,
    //         'terminated_percentage' => $terminated_percentage,
    //         'published_percentage' => $published_percentage
    //     ]);
    // }

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

            $data['draft_execution_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '4')
                ->where('contracts.status', '=', '2')
                ->where('contracts.assigned_user_id', '=', Auth::user()->id)
                ->count();

            $data['sign_off_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '5')
                ->where('contracts.status', '=', '2')
                ->where('contracts.assigned_user_id', '=', Auth::user()->id)
                ->count();

            $data['approved_contract_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '6')
                ->where('contracts.status', '=', '3')
                ->where('contracts.assigned_user_id', '=', Auth::user()->id)
                ->count();

            $data['closed_contract_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '7')
                ->where('contracts.status', '=', '4')
                ->where('contracts.assigned_user_id', '=', Auth::user()->id)
                ->count();

            $data['total_contracts_count'] =  $data['draft_review_count'] + $data['final_draft_count'] + $data['draft_execution_count'] +
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

            $data['draft_execution_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '4')
                ->where('contracts.status', '=', '2')
                ->where('contracts.assigned_user_id', '=', Auth::user()->id)
                ->count();

            $data['sign_off_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '5')
                ->where('contracts.status', '=', '2')
                ->where('contracts.assigned_user_id', '=', Auth::user()->id)
                ->count();

            $data['approved_contract_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '6')
                ->where('contracts.status', '=', '3')
                ->where('contracts.assigned_user_id', '=', Auth::user()->id)
                ->count();

            $data['closed_contract_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '7')
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

            $data['draft_execution_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '4')
                ->where('contracts.status', '=', '2')
                ->count();

            $data['sign_off_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '5')
                ->where('contracts.status', '=', '2')
                ->count();

            $data['approved_contract_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '6')
                ->where('contracts.status', '=', '3')
                ->count();

            $data['closed_contract_count'] = \DB::table('contracts')
                ->where($compare_field, $compare_operator, $compare_value)
                ->where('contracts.stage', '=', '7')
                ->where('contracts.status', '=', '4')
                ->count();
        }
        $data['draft_created_count'] = \DB::table('contracts')->where([
            [$compare_field, $compare_operator, $compare_value],
            ['contracts.stage', '=', '1'],
            ['contracts.status', '=', '1']
        ])->count();

        if($data['total_contracts_count'] == 0) {
            $data['total_contracts_count'] = 0;
            $data['draft_created_per'] = 0;
            $data['draft_review_per'] = 0;
            $data['final_draft_per'] = 0;
            $data['final_exec_per'] = 0;
            $data['sign_off_per'] = 0;
            $data['approved_per'] = 0;
            $data['closed_per'] = 0;
        } else {
            $data['draft_created_per'] =($data['draft_created_count']  * 100) / $data['total_contracts_count'];
            $data['draft_review_per'] =($data['draft_review_count']  * 100) / $data['total_contracts_count'];
            $data['draft_created_per'] =($data['draft_created_count']  * 100) / $data['total_contracts_count'];
            $data['final_draft_per'] =($data['final_draft_count']  * 100) / $data['total_contracts_count'];
            $data['final_exec_per'] =($data[ 'draft_execution_count']  * 100) / $data['total_contracts_count'];
            $data['sign_off_per'] =($data['sign_off_count']  * 100) / $data['total_contracts_count'];
            $data['approved_per'] =($data[ 'approved_contract_count']  * 100) / $data['total_contracts_count'];
            $data['closed_per'] =($data[ 'closed_contract_count']  * 100) / $data['total_contracts_count'];
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
            $contract_status1 = 'Closed';
            $contract_assigned = '';
            $contract_assigned1 = 1;
        } elseif (auth()->user()->isUser()) {
                $contract_stage = '6';
                $contract_status = '3';
            // $contract_status = 'Approved';
            $contract_status1 = 'Amended';
            $contract_assigned = '';
            $contract_assigned1 = 1;
        }
        if (auth()->user()->isLegal()) {
            $contract_stage = '1';
            $contract_status = '1';
            $contract_status2 = 'Closed';
            $contract_assigned = '';
            $contract_assigned1 = 1;
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
                ['contracts.status', '=', $contract_status],
                ['contracts.assigned', '=', $contract_assigned]
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
                    ['contracts.status', '=', $contract_status2],
                    ['contracts.legal_approval_id', '=', Auth::user()->id]
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
                ['contracts.status', '=', $contract_status],
                ['contracts.assigned', '=', $contract_assigned1],
                ['contracts.assigned_user_id', '=', Auth::user()->id]
            ])
            ->get();

        return view('dashboard')->with($data);
    }
}
}
