<?php

namespace App\Http\Controllers;

use App\party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Alert;

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

        $party->party_name = ucwords($request->input('party_name'));
        $party->contact_person = ucwords($request->input('contact_person'));
        $party->telephone = $request->input('telephone');
        $party->email = $request->input('email');
        $party->physical_address = ucwords($request->input('physical_address'));
        $party->postal_address = $request->input('postal_address');
        $party->created_by = Auth::user()->id;
        $party->updated_by = Auth::user()->id;

        $party->save();
        Alert::success('Contract Party Creation', 'Contract party successfully created');

        return redirect('party');
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
            'contact_person' => 'required',
            'telephone' => 'required',
            'email' => 'required',
            'physical_address' => 'required',
            'postal_address' => 'required'
        ]);


        $party->party_name = ucwords($request->input('party_name'));
        $party->contact_person = ucwords($request->input('contact_person'));
        $party->telephone = $request->input('telephone');
        $party->email = $request->input('email');
        $party->physical_address = ucwords($request->input('physical_address'));
        $party->postal_address = $request->input('postal_address');
        $party->updated_by = Auth::user()->id;

        $party->save();
        Alert::success('Update Contract Party', 'Contract party successfully updated');
        return redirect('party');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\party  $party
     * @return \Illuminate\Http\Response
     */

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
        $data['party'] = DB::table('parties')
            ->select(
                DB::raw('parties.*'),
                DB::raw('contracts.*')
            )
            ->leftJoin('contracts', 'parties.party_id', '=', 'contracts.party_name_id')
            ->where('parties.party_id', '=', $party_id)
            ->first();

        $data['total_contracts'] = \DB::table('contracts')
            ->where('contracts.party_name_id', '=', $party_id)
            ->count();

        $data['total_pending_contracts'] = \DB::table('contracts')
            ->where('contracts.party_name_id', '=', $party_id)
            ->where('contracts.stage', '=', 1)
            ->where('contracts.status', '=', 1)
            ->count();

        $data['total_approved_contracts'] = \DB::table('contracts')
            ->where('contracts.party_name_id', '=', $party_id)
            ->where('contracts.stage', '=', 5)
            ->where('contracts.status', '=', 3)
            ->count();

        $data['total_closed_contracts'] = \DB::table('contracts')
            ->where('contracts.party_name_id', '=', $party_id)
            ->where('contracts.stage', '=', 6)
            ->where('contracts.status', '=', 4)
            ->count();

        $data['total_reviewed_contracts'] = \DB::table('contracts')
            ->where('contracts.party_name_id', '=', $party_id)
            ->where('contracts.stage', '=', 2)
            ->where('contracts.status', '=', 2)
            ->count();

        $data['total_ammended_contracts'] = \DB::table('contracts')
            ->where('contracts.party_name_id', '=', $party_id)
            ->where('contracts.status', '=', 'Amended')
            ->count();

        $data['total_terminated_contracts'] = \DB::table('contracts')
            ->where('contracts.party_name_id', '=', $party_id)
            ->where('contracts.status', '=', 'Terminated')
            ->count();

        // Contract party approved contracts
        $data['approved_contracts'] = DB::table('contracts')
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
            ->where('contracts.stage', '=', 5)
            ->where('contracts.status', '=', 3)
            ->get();

        // Contract party approved contracts
        $data['closed_contracts'] = DB::table('contracts')
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
            ->where('contracts.stage', '=', 6)
            ->where('contracts.status', '=', 4)
            ->get();
        // Contract party approved contracts
        $data['reviewed_contracts'] = DB::table('contracts')
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
            ->where('contracts.stage', '=', 2)
            ->where('contracts.status', '=', 2)
            ->get();


        // Contract party ammended contracts
        $data['ammended_contracts'] = DB::table('contracts')
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
            ->where('contracts.status', '=', 'Amended')
            ->get();

        // Contract party terminated contracts
        $data['terminated_contracts'] = DB::table('contracts')
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
            ->where('contracts.status', '=', 'Terminated')
            ->get();

        return view('contracts.view-contract-party')->with($data);
    }

    public function destroy(party $party)
    {
        $party->delete();
        Alert::success('Delete Contract Party', 'Contract party deleted successfully');
        return redirect('party');
    }
}
