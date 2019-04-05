<?php

namespace App\Http\Controllers;

use App\contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\party;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\User;
use function GuzzleHttp\json_decode;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use HasRoles;
    protected $guard_name = 'web';

    public function index()
    {

        $user = Auth::user();
        ~$user_role = $user->getRoleNames()->first();

        if ($user_role == "Admin") {
            $compare_field = "contracts.contract_id";
            $compare_operator = ">";
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
            ->where($compare_field, $compare_operator, $compare_value)
            ->get();

        // echo "<pre>";
        // var_dump($contracts);exit;



        return view('admin/contracts.index')->with([
            'contracts' => $contracts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/contracts.create');

        //->with([ ]);
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
            'title' => 'required',
            'effective_date' => 'required',
            'contract_document' => 'required',
        ]);

        $contract = new contract;

        $contract->contract_title = $request->input('title');
        $contract->party_name_id = $request->input('party_name');
        $contract->effective_date = date("Y-m-d", strtotime($request->input('effective_date')));
        if ($request->input('expiry_date')) {
            $contract->expiry_date = date("Y-m-d", strtotime($request->input('expiry_date')));
        }
        $contract->description = $request->input('description');
        $contract->stage = 1;
        $contract->status = 'created';
        $contract->created_by = Auth::user()->id;
        $contract->updated_by = Auth::user()->id;
        $contract->last_action_by = Auth::user()->id;

        $contract->save();

        $just_saved_contract_id = $contract->contract_id;


        $contract_file = '';
        $contract_crf = '';

        if ($request->hasFile('contract_document') && $request->file('contract_document')->isValid()) {
            $file = $request->file('contract_document');
            $file_name = str_random(30) . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/contract_documents', $file_name);
            $contract_file = 'uploads/contract_documents/' . $file_name;
        }

        if ($request->hasFile('contract_crf') && $request->file('contract_crf')->isValid()) {
            $file = $request->file('contract_crf');
            $file_name = str_random(30) . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/contract_documents', $file_name);
            $contract_crf = 'uploads/contract_documents/' . $file_name;
        }



        $contract_draft_data = array(
            'contract_id' => $just_saved_contract_id,
            'stage_id' => 1,
            'draft_file' => $contract_file,
            'status' => 'created',
            'crf_file' => $contract_crf,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,

        );

        $last_draft_id = DB::table('contract_drafts')->insertGetId($contract_draft_data);
        DB::table('contracts')->where('contract_id', $just_saved_contract_id)->update(array('last_draft_id' => $last_draft_id));
        return redirect('admin/contract')->with('success', 'Contract Successfull Saved!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\contract  $contract
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit(contract $contract)
    {

        $contract->party_name = DB::table('parties')->where(array('party_id' => $contract->party_name_id))->first()->party_name;

        // echo "<pre>";

        // print_r($contract);
        // exit;
        return view('admin/contracts.edit')->with([
            'contract' => $contract
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, contract $contract)
    {

        $this->validate($request, [
            'party_name' => 'required',
            'title' => 'required',
            'effective_date' => 'required',
            //'contract_document'=>'required',
        ]);


        $contract->contract_title = $request->input('title');
        $contract->party_name_id = $request->input('party_name');
        $contract->effective_date = date("Y-m-d", strtotime($request->input('effective_date')));
        if ($request->input('expiry_date')) {
            $contract->expiry_date = date("Y-m-d", strtotime($request->input('expiry_date')));
        }
        $contract->description = $request->input('description');
        $contract->stage = 1;
        $contract->status = 'created';
        //$contract->created_by=Auth::user()->id;
        $contract->updated_by = Auth::user()->id;
        $contract->last_action_by = Auth::user()->id;

        $contract->save();

        $just_saved_contract_id = $contract->contract_id;


        $contract_file = '';
        $contract_crf = '';

        if ($request->hasFile('contract_document') && $request->file('contract_document')->isValid()) {
            $file = $request->file('contract_document');
            $file_name = str_random(30) . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/contract_documents', $file_name);
            $contract_file = 'uploads/contract_documents/' . $file_name;
        }

        if ($request->hasFile('contract_crf') && $request->file('contract_crf')->isValid()) {
            $file = $request->file('contract_crf');
            $file_name = str_random(30) . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/contract_documents', $file_name);
            $contract_crf = 'uploads/contract_documents/' . $file_name;
        }



        $contract_draft_data = array(
            'contract_id' => $just_saved_contract_id,
            'stage_id' => 1,
            'draft_file' => $contract_file,
            'status' => 'created',
            'crf_file' => $contract_crf,
            //'created_by'=>Auth::user()->id,
            'updated_by' => Auth::user()->id,
        );

        $last_draft_id = DB::table('contract_drafts')->where('contract_draft_id', $contract->last_draft_id)->update($contract_draft_data);

        return redirect('admin/contract')->with('success', 'Contract Successfully Updated!');
    }

    /**
     * Submit the Contract Information to the Legal Team and change the status of the contract
    * from published to
    **/
    public function submit(request $request)
    {

        $contract = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
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
            ->where('contracts.contract_id', '=', $request->contract_id)
            ->first();

                    // echo "<pre>";
                    // print_r($contract);
                    // exit;


        $status = 'draft_review';
        $published_contract_id = $request->contract_id;
        $published_contract_draft = $contract->draft_file;
        $published_crf_file = $contract->crf_file;
        DB::table('contracts')->where('contract_id', $published_contract_id)->update(['status' => $status]);

         $contract_draft_data = array(
            'contract_id' => $published_contract_id,
            'stage_id' => 3,
            'draft_file' => $published_contract_draft,
            'crf_file' => $published_crf_file,
            'status' => 'draft_review',
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,

        );



        $last_draft_id = DB::table('contract_drafts')->insertGetId($contract_draft_data);

        return redirect('admin/contract')->with('success', 'Contract Successfully Sent to the Legal Team for review');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy(contract $contract)
    {
        $contract->delete();

        return redirect('admin/contract')->with('success', 'Contract Successfully Deleted');
    }

    public function viewContract($contract_id = null)
    {

        $contract = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('contracts.status AS contract_status'),
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
            ->where('contracts.contract_id', '=', $contract_id)
            ->first();

        // echo "<pre>";
        // print_r($contract);
        // exit;


        $contract_drafts = DB::table('contract_drafts')
            ->select(
                DB::raw('contract_drafts.*'),
                DB::raw('contract_drafts.created_at AS contract_drafts_created_at'),
                DB::raw('contract_drafts.updated_at AS contract_drafts_update_at'),
                DB::raw('contract_drafts.created_by AS contract_drafts_created_by'),
                DB::raw('contract_drafts.status AS contract_drafts_status'),
                DB::raw('contracts.status AS contract_status'),
                DB::raw('contracts.*'),
                DB::raw('contracts.created_at AS contracts_created_at'),
                DB::raw('contracts.updated_at AS contracts_update_at'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('users_organizations.*'),
                DB::raw('draft_stages.*')
            )
            ->leftJoin('contracts', 'contracts.contract_id', '=', 'contract_drafts.contract_id')
            ->leftJoin('parties', 'parties.party_id', '=', 'contracts.party_name_id')
            // ->leftJoin('users', 'users.id', '=', 'contracts.created_by')
            ->leftJoin('users', 'users.id', '=', 'contract_drafts.created_by')
            ->leftJoin('users_details', 'users_details.user_id', '=', 'contracts.created_by')
            ->leftJoin('users_organizations', 'users_organizations.organization_id', '=', 'users_details.organization_id')

            ->leftJoin('draft_stages', 'draft_stages.draft_stage_id', '=', 'contract_drafts.stage_id')
            ->orderBy('contract_drafts.contract_draft_id', 'desc')
            ->where('contract_drafts.contract_id', '=', $contract_id)
            ->get();

        // echo "<pre>";
        // print_r( $contract_drafts);
        // exit;



        return view('admin/contracts.view')->with([
            'contract' => $contract, 'contract_drafts' => $contract_drafts
        ]);
  }
}