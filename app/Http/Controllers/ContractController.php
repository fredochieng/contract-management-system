<?php
namespace App\Http\Controllers;

use App\contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\party;
use App\contract_drafts;
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
            $compare_operator = ">=";
            $compare_value = 1;

            $contract_status_query = contract::where($compare_field, $compare_operator, $compare_value)
                ->where(function ($query) {
                    $query->where('contracts.status', 'approved')
                        ->orWhere('contracts.status', 'submitted')
                        ->orWhere('contracts.status', 'ammended')
                        ->orWhere('contracts.status', 'terminated')
                        ->orWhere('contracts.status', 'published');
                })->get();
        } elseif ($user_role == "Legal Counsel") {
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
                [$compare_field, $compare_operator, $compare_value]
            ])
            ->get();

        return view('contracts.index')->with([
            'contracts' => $contracts,
        ]);
    }

    public function assign(request $request)
    {
        $contractss = DB::table('contracts')
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

        $assigned = 1;
        $assigned_contract_id = $request->contract_id;
        $assigned_user_id = Auth::user()->id;
        DB::table('contracts')->where('contract_id', $assigned_contract_id)
            ->update(['assigned' => $assigned, 'assigned_user_id' => $assigned_user_id]);

        // return redirect('contract/view')->with('success', 'Contract successfully assigned to you');
        return redirect('contract/' . $assigned_contract_id . '/view')
            ->with('success', 'Contract successfully assigned to you');
    }

    // My Contracts Scetion
    public function mycontracts()
    {
        $user = Auth::user();
        ~$user_role = $user->getRoleNames()->first();
        if ($user_role == "Admin") {
            $compare_field1 = 'contracts.created_by';
            $compare_operator1 = "=";
            $compare_value1 = Auth::user()->id;
        } elseif ($user_role == "Legal Counsel") {
            $compare_field1 = 'contracts.created_by';
            $compare_operator1 = "=";
            $compare_value1 = Auth::user()->id;
        } else {
            $compare_field1 = 'contracts.created_by';
            $compare_operator1 = "=";
            $compare_value1 = Auth::user()->id;
        }
        $my_contracts = DB::table('contracts')
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
            ->where($compare_field1, $compare_operator1, $compare_value1)
            ->get();
        return view('contracts.my-contracts')->with([
            'my_contracts' => $my_contracts,
        ]);
    }

    // Approved Contracts
    public function approvedContracts()
    {
        $user = Auth::user();
        ~$user_role = $user->getRoleNames()->first();
        if ($user_role == "Admin") {
            $compare_field2 = "contracts.contract_id";
            $compare_operator2 = ">=";
            $compare_value2 = 1;
        } elseif ($user_role == "Legal Counsel") {
            $compare_field2 = 'contracts.legal_submission_id';
            $compare_operator2 = "=";
            $compare_value2 = Auth::user()->id;
        } else {
            $compare_field2 = 'contracts.created_by';
            $compare_operator2 = "=";
            $compare_value2 = Auth::user()->id;
        }
        $approved_contracts = DB::table('contracts')
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
            ->where($compare_field2, $compare_operator2, $compare_value2)
            ->where('contracts.status', '=', 'approved')
            ->get();

        return view('contracts.approved-contracts')->with([
            'approved_contracts' => $approved_contracts,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contracts.create');
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

        return redirect('contract/' . $request->input('contract_id'))
            ->with('success', 'Contract successfully created...');
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
        return view('contracts.edit')->with([
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
            'updated_by' => Auth::user()->id,
        );
        $last_draft_id = DB::table('contract_drafts')->where('contract_draft_id', $contract->last_draft_id)->update($contract_draft_data);
        return back()->with('success', 'Contract Successfully Updated!');
    }

    /**
     * Submit the Contract Information to the Legal Team and change the status of the contract
     * from published to
     **/

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
            ->orderBy('contracts.contract_id', 'desc')
            ->where('contracts.contract_id', '=', $contract_id)
            ->first();

        $latest = contract_drafts::where('contract_draft_id', $contract->last_draft_id)
            ->latest('created_at')
            ->first();

        $last_draft_contract_section = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('contracts.status AS contract_status'),
                DB::raw('contracts.stage AS contract_stage'),
                DB::raw('draft_stages.task AS draft_stages_task'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('draft_stages.*'),
                DB::raw('contract_types.*')
            )

            ->leftJoin('contract_drafts', 'contract_drafts.contract_id', '=', 'contracts.contract_id')
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('draft_stages', 'contract_drafts.stage_id', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_types', 'contracts.contract_type', '=', 'contract_types.contract_type_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where(['contracts.contract_id' => $contract_id, 'contract_drafts.contract_draft_id' => $latest->contract_draft_id])
            ->first();

        $contract_drafts = DB::table('contract_drafts')
            ->select(
                DB::raw('contract_drafts.*'),
                DB::raw('contract_drafts.created_at AS contract_drafts_created_at'),
                DB::raw('contract_drafts.updated_at AS contract_drafts_update_at'),
                DB::raw('contract_drafts.updated_by AS contract_drafts_updated_by'),
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
            ->leftJoin('users', 'users.id', '=', 'contract_drafts.updated_by')
            ->leftJoin('users_details', 'users_details.user_id', '=', 'contracts.created_by')
            ->leftJoin('users_organizations', 'users_organizations.organization_id', '=', 'users_details.organization_id')
            ->leftJoin('draft_stages', 'draft_stages.draft_stage_id', '=', 'contract_drafts.stage_id')
            ->orderBy('contract_drafts.contract_draft_id', 'desc')
            ->where('contract_drafts.contract_id', '=', $contract_id)
            ->get();

        return view('contracts.view')->with([
            'contract' => $contract,
            'contract_drafts' => $contract_drafts,
            'last_draft_contract_section' => $last_draft_contract_section
        ]);
    }
    public function publish(request $request)
    {
        $contractss = DB::table('contracts')
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

        $status = 'published';
        $stage = 2;
        $published_contract_id = $request->contract_id;
        $published_contract_draft = $contractss->draft_file;
        $published_crf_file = $contractss->crf_file;
        $created_by = $contractss->created_by;
        DB::table('contracts')->where('contract_id', $published_contract_id)
            ->update(['status' => $status, 'stage' => $stage]);
        $contract_draft_data = array(
            'contract_id' => $published_contract_id,
            'stage_id' => 2,
            'draft_file' => $published_contract_draft,
            'crf_file' => $published_crf_file,
            'status' => 'published',
            'created_by' => $created_by,
            'updated_by' => Auth::user()->id,
        );

        $last_draft_id = DB::table('contract_drafts')->insertGetId($contract_draft_data);
        DB::table('contracts')->where('contract_id', $published_contract_id)->update(array('last_draft_id' => $last_draft_id));
        return redirect('contract/' . $request->input('contract_id') . '/view')
            ->with('success', 'Contract successfully published awaiting approval by the legal department');
    }
    public function approve(request $request)
    {
        $approved_contract = DB::table('contracts')
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

        $status = 'approved';
        $stage = 3;
        $approved_contract->comments = $request->input('comments');
        $approved_contract->contract_type = $request->input('contract_type');
        $contract_type = $approved_contract->contract_type;
        $submit_comments = $approved_contract->comments;
        $approved_contract_id = $request->contract_id;
        $approved_contract_draft = $approved_contract->draft_file;
        $approved_crf_file = $approved_contract->crf_file;
        $created_by = $approved_contract->created_by;
        $action_id = Auth::user()->id;

        DB::table('contracts')->where('contract_id', $approved_contract_id)->update(
            [
                'status' => $status, 'stage' => $stage, 'contract_type' => $contract_type,
                'legal_approval_id' => $action_id, 'updated_by' => Auth::user()->id
            ]
        );
        $contract_draft_data = array(
            'contract_id' => $approved_contract_id,
            'stage_id' => 3,
            'draft_file' => $approved_contract_draft,
            'crf_file' => $approved_crf_file,
            'status' => 'approved',
            'comments' => $submit_comments,
            'created_by' => $created_by,
            'updated_by' => Auth::user()->id,
        );
        $last_draft_id = DB::table('contract_drafts')->insertGetId($contract_draft_data);
        DB::table('contracts')->where('contract_id', $approved_contract_id)->update(array('last_draft_id' => $last_draft_id));
        return redirect('contract/' . $request->input('contract_id') . '/view')
            ->with('success', 'Contract successfully submitted to the legal admin awaiting for approval');
    }
    public function ammend(request $request)
    {
        $ammended_contract = DB::table('contracts')
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

        $ammended_contract_file = '';
        $ammended_contract_crf = '';
        if ($request->hasFile('ammended_contract_document') && $request->file('ammended_contract_document')->isValid()) {
            $file = $request->file('ammended_contract_document');
            $file_name = str_random(30) . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/contract_documents', $file_name);
            $ammended_contract_file = 'uploads/contract_documents/' . $file_name;
        } else {
            $ammended_contract_file = $ammended_contract->draft_file;
        }

        if ($request->hasFile('ammended_contract_crf') && $request->file('ammended_contract_crf')->isValid()) {
            $file1 = $request->file('ammended_contract_crf');
            $file_name = str_random(30) . '.' . $file->getClientOriginalExtension();
            $file1->move('uploads/contract_documents', $file_name);
            $ammended_contract_crf = 'uploads/contract_documents/' . $file_name;
        } else {
            $ammended_contract_crf = $ammended_contract->crf_file;
        }

        $status = 'ammended';
        $stage = 4;
        $ammended_contract->comments = $request->input('comments');
        $ammend_comments = $ammended_contract->comments;
        $ammended_contract_id = $request->contract_id;
        $ammendment_action_id = Auth::user()->id;
        $created_by = $ammended_contract->created_by;
        DB::table('contracts')->where('contract_id', $ammended_contract_id)
            ->update([
                'status' => $status, 'stage' => $stage,
                'legal_ammendment_id' => $ammendment_action_id, 'updated_by' => Auth::user()->id
            ]);

        $contract_draft_data = array(
            'contract_id' => $ammended_contract_id,
            'stage_id' => 4,
            'draft_file' => $ammended_contract_file,
            'crf_file' => $ammended_contract_crf,
            'status' => 'ammended',
            'comments' => $ammend_comments,
            'created_by' => $created_by,
            'updated_by' => Auth::user()->id,
        );

        $last_draft_id = DB::table('contract_drafts')->insertGetId($contract_draft_data);
        DB::table('contracts')->where('contract_id', $ammended_contract_id)->update(array('last_draft_id' => $last_draft_id));
        return redirect('contract/' . $request->input('contract_id') . '/view')

            ->with('success', 'Contract successfully ammended awaiting action by the contract party');
    }
    /** Terminate a contract by legal team **/
    public function terminate(request $request)
    {
        $terminated_contract = DB::table('contracts')
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

        $status = 'terminated';
        $stage = 5;
        $terminated_contract->comments = $request->input('comments');
        $termination_comments = $terminated_contract->comments;
        $terminated_contract_id = $request->contract_id;
        $terminated_contract_draft = $terminated_contract->draft_file;
        $terminated_crf_file = $terminated_contract->crf_file;
        $termination_action_id = Auth::user()->id;
        $created_by = $terminated_contract->created_by;
        DB::table('contracts')->where('contract_id', $terminated_contract_id)
            ->update([
                'status' => $status, 'stage' => $stage,
                'legal_termination_id' => $termination_action_id, 'updated_by' => Auth::user()->id
            ]);

        $contract_draft_data = array(
            'contract_id' => $terminated_contract_id,
            'stage_id' => 5,
            'draft_file' => $terminated_contract_draft,
            'crf_file' => $terminated_crf_file,
            'status' => 'terminated',
            'comments' => $termination_comments,
            'created_by' => $created_by,
            'updated_by' => Auth::user()->id,

        );

        $last_draft_id = DB::table('contract_drafts')->insertGetId($contract_draft_data);
        DB::table('contracts')->where('contract_id', $terminated_contract_id)->update(array('last_draft_id' => $last_draft_id));

        return redirect('contract/' . $request->input('contract_id') . '/view')
            ->with('success', 'Contract successfully terminated and the contract owner has bee notified');
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

        return redirect('contract')->with('success', 'Contract Successfully Deleted');
    }
}