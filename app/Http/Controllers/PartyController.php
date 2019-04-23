<?php

namespace App\Http\Controllers;

use App\party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parties = party::all();

        return view('contracts.parties')->with([
            'parties' => $parties
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('parties.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'party_name' => 'required',
        ]);


        $party = new party;

        $party->party_name = $request->input('party_name');
        $party->address = $request->input('address');
        $party->telephone = $request->input('telephone');
        $party->email = $request->input('email');
        $party->created_by = Auth::user()->id;
        $party->updated_by = Auth::user()->id;

        $party->save();

        return redirect('party')->with('success', 'Contract party successfully saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\party  $party
     * @return \Illuminate\Http\Response
     */
    public function show(party $party)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\party  $party
     * @return \Illuminate\Http\Response
     */
    public function edit(party $party)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\party  $party
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, party $party)
    {
        $this->validate($request, [
            'party_name' => 'required',
        ]);


        $party->party_name = $request->input('party_name');
        $party->address = $request->input('address');
        $party->telephone = $request->input('telephone');
        $party->email = $request->input('email');
        //$party->created_by=Auth::user()->id;
        $party->updated_by = Auth::user()->id;

        $party->save();

        return redirect('party')->with('success', 'Record Successfully saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\party  $party
     * @return \Illuminate\Http\Response
     */
    public function destroy(party $party)
    {
        $party->delete();
        return redirect('party')->with('success', 'Record Successfully Deleted');
    }



    public function get_party(Request $request)
    {
        $search_term = $request->input('q');
        $search_term = '%' . $search_term . '%';

        $data = DB::table('parties')
            ->select(
                DB::raw('party_name as text'),
                DB::raw('party_id as id')
            )
            ->where('party_name', 'like', $search_term)
            ->get()->take(10);

        echo json_encode($data);
        exit;
    }

    public function contractParty($party_id = null)
    {
        $party = DB::table('parties')
            ->select(
                DB::raw('parties.*'),
                DB::raw('contracts.*')
            )
            ->leftJoin('contracts', 'parties.party_id', '=', 'contracts.party_name_id')
            ->where('parties.party_id', '=', $party_id)
            ->first();

        $total_contracts = \DB::table('contracts')
            ->where('contracts.party_name_id', '=', $party_id)
            ->where('contracts.status', '!=', 'created')
            ->count();

        $total_pending_contracts = \DB::table('contracts')
            ->where('contracts.party_name_id', '=', $party_id)
            ->where('contracts.status', '=', 'published')
            ->count();

        $total_approved_contracts = \DB::table('contracts')
            ->where('contracts.party_name_id', '=', $party_id)
            ->where('contracts.status', '=', 'approved')
            ->count();

        $total_ammended_contracts = \DB::table('contracts')
            ->where('contracts.party_name_id', '=', $party_id)
            ->where('contracts.status', '=', 'ammended')
            ->count();

        $total_terminated_contracts = \DB::table('contracts')
            ->where('contracts.party_name_id', '=', $party_id)
            ->where('contracts.status', '=', 'terminated')
            ->count();

        // Contract party approved contracts
        $approved_contracts = DB::table('contracts')
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
                DB::raw('draft_stages.*'),
                DB::raw('contract_types.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contract_drafts.stage_id', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_types', 'contracts.contract_type', '=', 'contract_types.contract_type_id')
            ->orderBy('contracts.contract_id', 'desc')->take(2)
            ->where('contracts.party_name_id', '=', $party_id)
            ->where('contracts.status', '=', 'approved')
            ->get();

        // Contract party ammended contracts
        $ammended_contracts = DB::table('contracts')
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
                DB::raw('draft_stages.*'),
                DB::raw('contract_types.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contract_drafts.stage_id', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_types', 'contracts.contract_type', '=', 'contract_types.contract_type_id')
            ->orderBy('contracts.contract_id', 'desc')->take(2)
            ->where('contracts.party_name_id', '=', $party_id)
            ->where('contracts.status', '=', 'ammended')
            ->get();

        // Contract party terminated contracts
        $terminated_contracts = DB::table('contracts')
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
                DB::raw('draft_stages.*'),
                DB::raw('contract_types.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contract_drafts.stage_id', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_types', 'contracts.contract_type', '=', 'contract_types.contract_type_id')
            ->orderBy('contracts.contract_id', 'desc')->take(2)
            ->where('contracts.party_name_id', '=', $party_id)
            ->where('contracts.status', '=', 'terminated')
            ->get();

        return view('contracts.view-contract-party')->with([
            'party' => $party,
            'total_contracts' => $total_contracts,
            'total_pending_contracts' => $total_pending_contracts,
            'total_approved_contracts' => $total_approved_contracts,
            'total_ammended_contracts' => $total_ammended_contracts,
            'total_terminated_contracts' => $total_terminated_contracts,
            'approved_contracts' => $approved_contracts,
            'ammended_contracts' => $ammended_contracts,
            'terminated_contracts' => $terminated_contracts
        ]);
    }
}