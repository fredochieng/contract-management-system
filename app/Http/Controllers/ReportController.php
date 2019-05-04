<?php

namespace App\Http\Controllers;

use App\contract;
use App\contract_drafts;
use App\party;
use App\User;
use App\User_Details;

use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = DB::table('contract_status')->select(
            DB::raw('contract_status.*')
        )->where('contract_status.status_name', '!=', 'Created')->get();

        $status1 = DB::table('contract_status')->select(
            DB::raw('contract_status.*')
        )->where('contract_status.status_name', '!=', 'Created')->get();

        $contract_types = DB::table('contract_types')->select(DB::raw('contract_types.*'))->get();
        $parties = DB::table('parties')->select(DB::raw('parties.*'))->get();
        return view('reports.reports')
            ->with([
                'status' => $status, 'contract_types' => $contract_types, 'parties' => $parties
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { }

    /**
     * Display the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $report_type)
    {
        $status = $request->status_name;
        $from = $request->start_date;
        $to = $request->end_date;

            $partyid = $request->contract_party_id;
            $party =  DB::table('parties')
                            ->where('party_id', '=' , $partyid )
                            ->first();

        $contracts = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('contracts.updated_at AS contract_updated_date'),
                DB::raw('contracts.status AS contract_status'),
                DB::raw('contracts.stage AS contract_stage'),
                DB::raw('draft_stages.task AS draft_stages_task'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('contracts_action_dates.*'),
                DB::raw('contracts_action_dates.date AS action_date'),
                DB::raw('contracts_storage.*'),
                DB::raw('draft_stages.*'),
                DB::raw('contract_types.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftjoin('contracts_action_dates', 'contracts.contract_id', '=', 'contracts_action_dates.contract_id')
            ->leftjoin('contracts_storage', 'contracts.contract_id', '=', 'contracts_storage.contract_id')
            ->leftJoin('draft_stages', 'contract_drafts.stage_id', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_types', 'contracts.contract_type', '=', 'contract_types.contract_type_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where('contracts.status', '=', $status)
            ->where('contracts_action_dates.status', '=', $status)
            ->whereBetween('contracts_action_dates.date', array($from, $to))
            ->get();

        $contract_type = $request->contract_type_id;
        $contract_status = 'Closed';

        if ($contract_type == 1) {
            $contract_type_name = "Standard";
        } else {
            $contract_type_name = "Non Standard";
        }

        $contract_type_report = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('contracts.updated_at AS contract_updated_date'),
                DB::raw('contracts.status AS contract_status'),
                DB::raw('contracts.stage AS contract_stage'),
                DB::raw('draft_stages.task AS draft_stages_task'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('contracts_action_dates.date'),
                DB::raw('contracts_action_dates.date AS action_date'),
                DB::raw('contracts_storage.*'),
                DB::raw('draft_stages.*'),
                DB::raw('contract_types.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftjoin('contracts_action_dates', 'contracts.contract_id', '=', 'contracts_action_dates.contract_id')
            ->leftjoin('contracts_storage', 'contracts.contract_id', '=', 'contracts_storage.contract_id')
            ->leftJoin('draft_stages', 'contract_drafts.stage_id', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_types', 'contracts.contract_type', '=', 'contract_types.contract_type_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where('contracts.contract_type', '=', $contract_type)
            ->where('contracts_action_dates.status', $contract_status)
            ->get();

        $contract_party_id = $request->contract_party_id;

        $contract_party_report = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('contracts.updated_at AS contract_updated_date'),
                DB::raw('contracts.status AS contract_status'),
                DB::raw('contracts.stage AS contract_stage'),
                DB::raw('draft_stages.task AS draft_stages_task'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('contracts_action_dates.date'),
                DB::raw('contracts_action_dates.date AS action_date'),
                DB::raw('contracts_storage.*'),
                DB::raw('draft_stages.*'),
                DB::raw('contract_types.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftjoin('contracts_action_dates', 'contracts.contract_id', '=', 'contracts_action_dates.contract_id')
            ->leftjoin('contracts_storage', 'contracts.contract_id', '=', 'contracts_storage.contract_id')
            ->leftJoin('draft_stages', 'contract_drafts.stage_id', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_types', 'contracts.contract_type', '=', 'contract_types.contract_type_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where('contracts.party_name_id', '=', $contract_party_id)
            ->where('contracts_action_dates.status', $contract_status)
            ->get();

            return view('reports.view')
            ->with([
                'contracts' => $contracts, 'report_type' => $report_type, 'status' => $status, 'from' => $from, 'to' => $to,
                'contract_type_name' => $contract_type_name, 'contract_type_report' => $contract_type_report,
                'contract_party_report' => $contract_party_report, 'contract_party_id'=> $contract_party_id , 'party' => $party
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
