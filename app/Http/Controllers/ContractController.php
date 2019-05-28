<?php
namespace App\Http\Controllers;

use App\User;
use App\contract;
use App\party;
use App\contract_drafts;
use App\ContractTerm;
use App\RenewalType;
use App\SupportingDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Redirect;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContractRequestCreation;
use App\Mail\ContractCreatedMail;
use App\Mail\ContractAcknowledgement;
use App\Mail\ContractAcknowledgementMail;
use App\Mail\ContractAcknowledged;
use App\Mail\DraftReviewShared;
use App\Mail\FinalDraftShared;
use App\Mail\CAFUploaded;
use App\Mail\ContractExpiryAlert;
use Laravel\RoundRobin\RoundRobin;
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
    { }
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
    // Created Contracts
    public function createdContracts()
    {
        $user = Auth::user();
        ~$user_role = $user->getRoleNames()->first();
        if ($user_role == "Admin") {
            $compare_field = "contracts.contract_id";
            $compare_operator = ">=";
            $compare_value = 1;
            $contract_status_query = contract::where($compare_field, $compare_operator, $compare_value)
                ->where(function ($query) {
                    $query->where('contracts.status', 'Approved')
                        ->orWhere('contracts.status', 'Submitted')
                        ->orWhere('contracts.status', 'Amended')
                        ->orWhere('contracts.status', 'Terminated')
                        ->orWhere('contracts.status', 'Pending');
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
        $created_contracts = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('contracts.status AS contract_status'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('contracts.updated_at AS contract_updated_at'),
                DB::raw('contracts.stage AS contract_stage'),
                DB::raw('contracts.published_time AS contract_published_time'),
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
            ->where('contracts.status', '=', 'Created')
            ->get();
        return view('contracts.created-contracts')->with([
            'created_contracts' => $created_contracts
        ]);
    }
    // Closed Contracts
    public function myAssignedContracts()
    {
        $user = Auth::user();
        ~$user_role = $user->getRoleNames()->first();
        if ($user_role == "Admin") {
            $compare_field2 = "contracts.contract_id";
            $compare_operator2 = ">=";
            $compare_value2 = 1;
            $compare_field = 'contracts.assigned_user_id';
            $compare_operator = "=";
            $compare_value = Auth::user()->id;
        } elseif ($user_role == "Legal Counsel") {
            $compare_field = 'contracts.assigned_user_id';
            $compare_operator = "=";
            $compare_value = Auth::user()->id;
        }
        $assigned_contracts = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('contracts.status AS contract_status'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.name AS user_name'),
                DB::raw('users.email AS user_email'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('contracts.stage AS contract_stage'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('contract_status.*'),
                DB::raw('draft_stages.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_status', 'contracts.status', '=', 'contract_status.status_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where($compare_field, $compare_operator, $compare_value)
            ->where('contracts.stage', '=', 6)
            ->where('contracts.status', '=', 4)
            ->get();



        $legal_team = User::role("Legal Counsel")->where('users.id', '!=', Auth::user()->id)->pluck('name', 'id');
        return view('contracts.my-assigned-contracts')->with([
            'assigned_contracts' => $assigned_contracts,
            'legal_team' => $legal_team
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
            $compare_field3 = 'contracts.legal_approval_id';
            $compare_operator3 = "=";
            $compare_value3 = Auth::user()->id;
        } elseif ($user_role == "Legal Counsel") {
            $compare_field2 = "contracts.contract_id";
            $compare_operator2 = ">=";
            $compare_value2 = 1;
            $compare_field3 = 'contracts.assigned_user_id';
            $compare_operator3 = "=";
            $compare_value3 = Auth::user()->id;
        } else {
            $compare_field2 = 'contracts.created_by';
            $compare_operator2 = "=";
            $compare_value2 = Auth::user()->id;
            $compare_field3 = 'contracts.created_by';
            $compare_operator3 = "=";
            $compare_value3 = Auth::user()->id;
        }
        $data['approved_contracts'] = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('contracts.status AS contract_status'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.name AS user_name'),
                DB::raw('users.email AS user_email'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('contracts.stage AS contract_stage'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('contract_status.*'),
                DB::raw('draft_stages.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.created_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_status', 'contracts.status', '=', 'contract_status.status_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where($compare_field2, $compare_operator2, $compare_value2)
            ->where('contracts.stage', '=', 5)
            ->where('contracts.status', '=', 3)
            ->get();

        $data['approved_contracts']->map(function ($item) {
            $expiry_date = date('Y-m-d', strtotime(Carbon::parse($item->expiry_date)));
            $current_time = date('Y-m-d', strtotime(Carbon::now('Africa/Nairobi')));
            $contract_id = $item->contract_id;
            $date_send_notification = date('Y-m-d', strtotime(Carbon::parse($item->expiry_date)->subMonths(3)));
            $user_email = $item->user_email;
            $user_name = $item->user_name;
            $contract_code = $item->contract_code;
            $contract_title = $item->contract_title;
            $item->notification_duration = $date_send_notification;
            $item->expired = 1;
            // echo "Current Time: " . $current_time;
            // echo "<br/>";
            // echo "Contract ID: " . $contract_id;
            // echo "<br/>";
            // echo "Expiry Date: " . $expiry_date;
            // echo "<br/>";
            // echo "Date to send notification: " . $date_send_notification;
            // echo "<br/>";
            if (Carbon::now()->toDateString() == $date_send_notification) {
                $objDemo = new \stdClass();
                $objDemo->user_name = $user_name;
                $objDemo->contract_code = $contract_code;
                $objDemo->contract_title = $contract_title;
                $company = "Wananchi Group Ltd";
                $objDemo->company = $company;
                $objDemo->duration = 3;

                $objDemo->subject = 'Contract ' . '#' . $contract_code . ' Expiry Alert';
                $objDemo->expiry_date = $expiry_date;
                Mail::to($user_email)->send(new ContractExpiryAlert($objDemo));
                // echo $user_email;
                // echo "<br/>";
                // echo "<br/>";

                // foreach ($data['legal_members'] as $legal) {
                //     Mail::to($legal->email)->send(new ContractCreatedMail($objDemo));
                // }
            } else {
                // echo "Notification date is still ahead";
                // echo "<br/>";
                // echo "<br/>";
            }
            if (Carbon::now('Africa/Nairobi')->greaterThan(Carbon::parse($item->expiry_date))) {
                $item->expired = 1;
                // echo "Contract Expired";
                //  echo "<br/>";
                //   echo "<br/>";
            } else {
                $item->expired = 0;
                // echo "Contract Not Expired";
                //  echo "<br/>";
                // echo "<br/>";
            }
            // echo "<br/>";
            return $item;
            // echo "<br/>";

            //  exit;
        });
        // Contracts Approved By Me
        $data['approved_by_me_contracts'] = DB::table('contracts')
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
                DB::raw('contract_status.*'),
                DB::raw('draft_stages.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_status', 'contracts.status', '=', 'contract_status.status_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where($compare_field3, $compare_operator3, $compare_value3)
            ->where('contracts.stage', '=', 5)
            ->where('contracts.status', '=', 3)
            ->where('contracts.assigned_user_id', '=', Auth::user()->id)
            ->get();

        return view('contracts.approved-contracts')->with($data);
    }
    // Closed Contracts
    public function closedContracts()
    {
        $user = Auth::user();
        ~$user_role = $user->getRoleNames()->first();
        if ($user_role == "Admin") {
            $compare_field2 = "contracts.contract_id";
            $compare_operator2 = ">=";
            $compare_value2 = 1;
            $compare_field3 = 'contracts.legal_approval_id';
            $compare_operator3 = "=";
            $compare_value3 = Auth::user()->id;
        } elseif ($user_role == "Legal Counsel") {
            $compare_field2 = "contracts.contract_id";
            $compare_operator2 = ">=";
            $compare_value2 = 1;
            $compare_field3 = 'contracts.assigned_user_id';
            $compare_operator3 = "=";
            $compare_value3 = Auth::user()->id;
        } else {
            $compare_field2 = 'contracts.created_by';
            $compare_operator2 = "=";
            $compare_value2 = Auth::user()->id;
            $compare_field3 = 'contracts.created_by';
            $compare_operator3 = "=";
            $compare_value3 = Auth::user()->id;
        }
        $data['approved_contracts'] = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('contracts.status AS contract_status'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.name AS user_name'),
                DB::raw('users.email AS user_email'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('contracts.stage AS contract_stage'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('contract_status.*'),
                DB::raw('draft_stages.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_status', 'contracts.status', '=', 'contract_status.status_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where($compare_field2, $compare_operator2, $compare_value2)
            ->where('contracts.stage', '=', 6)
            ->where('contracts.status', '=', 4)
            ->get();

        $data['approved_contracts']->map(function ($item) {
            $expiry_date = date('Y-m-d', strtotime(Carbon::parse($item->expiry_date)));
            $current_time = date('Y-m-d', strtotime(Carbon::now('Africa/Nairobi')));
            $contract_id = $item->contract_id;
            $date_send_notification = date('Y-m-d', strtotime(Carbon::parse($item->expiry_date)->subMonths(3)));
            $user_email = $item->user_email;
            $user_name = $item->user_name;
            $contract_code = $item->contract_code;
            $contract_title = $item->contract_title;
            $item->notification_duration = $date_send_notification;
            $item->expired = 1;
            // echo "Current Time: " . $current_time;
            // echo "<br/>";
            // echo "Contract ID: " . $contract_id;
            // echo "<br/>";
            // echo "Expiry Date: " . $expiry_date;
            // echo "<br/>";
            // echo "Date to send notification: " . $date_send_notification;
            // echo "<br/>";
            if (Carbon::now()->toDateString() == $date_send_notification) {
                $objDemo = new \stdClass();
                $objDemo->user_name = $user_name;
                $objDemo->contract_code = $contract_code;
                $objDemo->contract_title = $contract_title;
                $company = "Wananchi Group Ltd";
                $objDemo->company = $company;
                $objDemo->duration = 3;

                $objDemo->subject = 'Contract ' . '#' . $contract_code . ' Expiry Alert';
                $objDemo->expiry_date = $expiry_date;
                Mail::to($user_email)->send(new ContractExpiryAlert($objDemo));
                // echo $user_email;
                // echo "<br/>";
                // echo "<br/>";

                // foreach ($data['legal_members'] as $legal) {
                //     Mail::to($legal->email)->send(new ContractCreatedMail($objDemo));
                // }
            } else {
                // echo "Notification date is still ahead";
                // echo "<br/>";
                // echo "<br/>";
            }
            if (Carbon::now('Africa/Nairobi')->greaterThan(Carbon::parse($item->expiry_date))) {
                $item->expired = 1;
                // echo "Contract Expired";
                //  echo "<br/>";
                //   echo "<br/>";
            } else {
                $item->expired = 0;
                // echo "Contract Not Expired";
                //  echo "<br/>";
                // echo "<br/>";
            }
            // echo "<br/>";
            return $item;
            // echo "<br/>";

            //  exit;
        });
        // Contracts Approved By Me
        // $data['approved_by_me_contracts'] = DB::table('contracts')
        //     ->select(
        //         DB::raw('contracts.*'),
        //         DB::raw('contracts.status AS contract_status'),
        //         DB::raw('parties.*'),
        //         DB::raw('users.name'),
        //         DB::raw('users.id'),
        //         DB::raw('users_details.*'),
        //         DB::raw('contracts.created_at AS created_date'),
        //         DB::raw('contracts.stage AS contract_stage'),
        //         DB::raw('users_organizations.*'),
        //         DB::raw('contract_drafts.*'),
        //         DB::raw('contract_status.*'),
        //         DB::raw('draft_stages.*')
        //     )
        //     ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
        //     ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
        //     ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
        //     ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
        //     ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
        //     ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
        //     ->leftJoin('contract_status', 'contracts.status', '=', 'contract_status.status_id')
        //     ->orderBy('contracts.contract_id', 'desc')
        //     ->where([
        //         [$compare_field3, $compare_operator3, $compare_value3],
        //         ['contracts.stage', '=', 6],
        //         ['contracts.status', '=', 4],
        //     ])
        //     ->get();
        $data['approved_by_me_contracts'] = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('contracts.status AS contract_status'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.name AS user_name'),
                DB::raw('users.email AS user_email'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('contracts.stage AS contract_stage'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('contract_status.*'),
                DB::raw('draft_stages.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_status', 'contracts.status', '=', 'contract_status.status_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where($compare_field2, $compare_operator2, $compare_value2)
            ->where('contracts.stage', '=', 6)
            ->where('contracts.status', '=', 4)
            ->where('contracts.assigned_user_id', '=', Auth::user()->id)
            ->get();

        $data['approved_by_me_contracts']->map(function ($item) {
            $expiry_date = date('Y-m-d', strtotime(Carbon::parse($item->expiry_date)));
            $current_time = date('Y-m-d', strtotime(Carbon::now('Africa/Nairobi')));
            $contract_id = $item->contract_id;
            $date_send_notification = date('Y-m-d', strtotime(Carbon::parse($item->expiry_date)->subMonths(3)));
            $user_email = $item->user_email;
            $user_name = $item->user_name;
            $contract_code = $item->contract_code;
            $contract_title = $item->contract_title;
            $item->notification_duration = $date_send_notification;
            $item->expired = 1;
            if (Carbon::now('Africa/Nairobi')->greaterThan(Carbon::parse($item->expiry_date))) {
                $item->expired = 1;
                // echo "Contract Expired";
                //  echo "<br/>";
                //   echo "<br/>";
            } else {
                $item->expired = 0;
                // echo "Contract Not Expired";
                //  echo "<br/>";
                // echo "<br/>";
            }
            // echo "<br/>";
            return $item;
            // echo "<br/>";

            //  exit;
        });
        return view('contracts.closed-contracts')->with($data);
    }
    // Ammended Contracts
    public function ammendedContracts()
    {
        $user = Auth::user();
        ~$user_role = $user->getRoleNames()->first();
        if ($user_role == "Admin") {
            $compare_field2 = "contracts.contract_id";
            $compare_operator2 = ">=";
            $compare_value2 = 1;
            $compare_field3 = 'contracts.legal_ammendment_id';
            $compare_operator3 = "=";
            $compare_value3 = Auth::user()->id;
        } elseif ($user_role == "Legal Counsel") {
            $compare_field2 = "contracts.contract_id";
            $compare_operator2 = ">=";
            $compare_value2 = 1;
            $compare_field3 = 'contracts.legal_ammendment_id';
            $compare_operator3 = "=";
            $compare_value3 = Auth::user()->id;
        } else {
            $compare_field2 = 'contracts.created_by';
            $compare_operator2 = "=";
            $compare_value2 = Auth::user()->id;
            $compare_field3 = 'contracts.created_by';
            $compare_operator3 = "=";
            $compare_value3 = Auth::user()->id;
        }
        $ammended_contracts = DB::table('contracts')
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
            ->where('contracts.status', '=', 'Amended')
            ->get();
        // Contracts Ammended By Me
        $ammended_by_me_contracts = DB::table('contracts')
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
            ->where($compare_field3, $compare_operator3, $compare_value3)
            ->where('contracts.status', '=', 'Amended')
            ->get();
        // My Ammended Contracts
        $my_ammended_contracts = DB::table('contracts')
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
            ->where('contracts.status', '=', 'Amended')
            ->where('contracts.created_by', '=', Auth::user()->id)
            ->get();
        return view('contracts.amended-contracts')->with([
            'ammended_contracts' => $ammended_contracts,
            'ammended_by_me_contracts' => $ammended_by_me_contracts,
            'my_ammended_contracts' => $my_ammended_contracts
        ]);
    }
    // Terminated Contracts
    public function terminatedContracts()
    {
        $user = Auth::user();
        ~$user_role = $user->getRoleNames()->first();
        if ($user_role == "Admin") {
            $compare_field2 = "contracts.contract_id";
            $compare_operator2 = ">=";
            $compare_value2 = 1;
            $compare_field3 = 'contracts.legal_termination_id';
            $compare_operator3 = "=";
            $compare_value3 = Auth::user()->id;
        } elseif ($user_role == "Legal Counsel") {
            $compare_field2 = "contracts.contract_id";
            $compare_operator2 = ">=";
            $compare_value2 = 1;
            $compare_field3 = 'contracts.legal_termination_id';
            $compare_operator3 = "=";
            $compare_value3 = Auth::user()->id;
        } else {
            $compare_field2 = 'contracts.created_by';
            $compare_operator2 = "=";
            $compare_value2 = Auth::user()->id;
            $compare_field3 = 'contracts.created_by';
            $compare_operator3 = "=";
            $compare_value3 = Auth::user()->id;
        }
        $terminated_contracts = DB::table('contracts')
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
            ->where('contracts.status', '=', 'Terminated')
            ->get();
        // Contracts Ammended By Me
        $terminated_by_me_contracts = DB::table('contracts')
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
            ->where($compare_field3, $compare_operator3, $compare_value3)
            ->where('contracts.status', '=', 'Terminated')
            ->get();
        // My Ammended Contracts
        $my_terminated_contracts = DB::table('contracts')
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
            ->where('contracts.status', '=', 'Terminated')
            ->where('contracts.created_by', '=', Auth::user()->id)
            ->get();
        return view('contracts.terminated-contracts')->with([
            'terminated_contracts' => $terminated_contracts,
            'terminated_by_me_contracts' => $terminated_by_me_contracts,
            'my_terminated_contracts' => $my_terminated_contracts
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['terms'] = ContractTerm::getContractTerm();
        $data['renewal_types'] = RenewalType::getRenewalTypes();

        return view('contracts.create')->with($data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'party_name' => 'required',
            'title' => 'required|string|min:5|max:50',
            'term_id' => 'required',
            'renewal_id' => 'required',
            'contract_document' => 'required',
            'filename.*' => 'mimes:doc,pdf,docx,png,jpg,jpeg'
        ]);
        $partyname =  DB::table('parties')
            ->where('party_id', '=', $request->input('party_name'))
            ->first();
        $cont_party_name = substr($partyname->party_name, 0, 3);
        $last_contract = contract::orderBy('contract_id', 'desc')->first();
        if (!$last_contract) {
            $number = 0;
        } else {
            $last_contract = $last_contract->contract_code;
            $number = substr($last_contract, -3);
        }
        $number1 = sprintf('%03d', intval($number) + 1);
        if ($validator->fails()) {
            DB::rollBack();
            Alert::error('New Contract Request', 'Oops!!! An error ocurred while creating new contract request');
            return back();
        } else {
            $contract = new contract;
            $data['random_legal_user'] = User::getLegalUsers();
            $legal_id = $data['random_legal_user']->id;
            $contract->contract_title = ucwords($request->input('title'));
            $contract->party_name_id = $request->input('party_name');
            // $contract->contract_type = 2;
            $contract->term = $request->term_id;
            $contract->renewal_id = $request->renewal_id;
            $contract->description = $request->input('description');
            $contract->stage = 1;
            $contract->status = 1;
            $contract->assigned = 1;
            $contract->assigned_user_id = $legal_id;
            $contract->created_by = Auth::user()->id;
            $contract->updated_by = Auth::user()->id;
            $contract->last_action_by = Auth::user()->id;
            DB::beginTransaction();
            $contract->save();
            $just_saved_contract_id = $contract->contract_id;
            $contract_file = '';
            $contract_title = $contract->contract_title;
            $created_string = "First Draft";
            if ($request->hasFile('contract_document') && $request->file('contract_document')->isValid()) {
                $file = $request->file('contract_document');
                $file_name = $contract_title . '-' . $created_string . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/contract_documents', $file_name);
                $contract_file = 'uploads/contract_documents/' . $file_name;
            }

            $caf_string = "CAF Document";
            if ($request->hasFile('caf_document') && $request->file('caf_document')->isValid()) {
                $file = $request->file('caf_document');
                $file_name = $contract_title . '-' . $caf_string . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/caf_documents', $file_name);
                $caf_file = 'uploads/caf_documents/' . $file_name;
            } else {
                $caf_file = '';
            }

            // Save Multiple Files Related To The Contract
            if ($request->hasfile('filename')) {

                foreach ($request->file('filename') as $file) {
                    $name = $file->getClientOriginalName();
                    $file->move('uploads/other_documents', $name);
                    $data[] = 'uploads/other_documents/' . $name;
                }
            }
            // Save Multiple Files Related To The Contract
            //  $contract->filename=json_encode($data);
            $documents = json_encode($data);
            $cont_code = strtoupper($cont_party_name);
            $default_contract_string = "WGT";
            $ticket = $cont_code . '-' . $default_contract_string . '-' . $number1;

            $save_contract_code = array(
                'contract_code' => $ticket
            );
            $contract_draft_data = array(
                'contract_id' => $just_saved_contract_id,
                'stage_id' => 1,
                'draft_file' => $contract_file,
                'crf_form' => $caf_file,
                'status' => 1,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            );
            $draft_created_date = Carbon::now('Africa/Nairobi');
            $action_dates_data = array(
                'contract_id' => $just_saved_contract_id,
                'contract_stage_id' => 1,
                'status_id' => 1,
                'date' => $draft_created_date
            );

            $other_documents_array = array(
                'contract_id' => $just_saved_contract_id,
                'files' => $documents
            );

            // echo "<pre>";
            // print_r($other_documents_array);
            // exit;
            $default_contract_storage_data = array(
                'contract_id' => $just_saved_contract_id
            );
            $resp = DB::table('contracts')->where('contract_id', $just_saved_contract_id)->update($save_contract_code);
            $last_draft_id = DB::table('contract_drafts')->insertGetId($contract_draft_data);
            $action_dates_data = DB::table('contracts_action_dates')->insertGetId($action_dates_data);
            $other_documents_data = DB::table('other_documents')->insertGetId($other_documents_array);
            $contract_storage = DB::table('contracts_storage')->insertGetId($default_contract_storage_data);
            DB::table('contracts')->where('contract_id', $just_saved_contract_id)->update(array('last_draft_id' => $last_draft_id));
            DB::commit();
            $user = \Auth::user();
            $objDemo = new \stdClass();
            $objDemo->contract_code = $ticket;
            $objDemo->title = $contract_title;
            $objDemo->company = "Wananchi Group Ltd";
            $objDemo->name = $user->name;
            $objDemo->subject = 'Contract Request ' . '#' . $ticket . ' Sent';
            // $objDemo->success = "Successfully";
            Mail::to($user->email)->send(new ContractRequestCreation($objDemo));
            $data['legal_members'] = User::getLegalMembers();
            // echo"<pre>";
            // print_r($data['legal_members']);
            // exit;
            foreach ($data['legal_members'] as $legal) {
                Mail::to($legal->email)->send(new ContractCreatedMail($objDemo));
            }
            Alert::success('Contract Request Creation', 'Contract request uccessfully created');
            return redirect('pending-contracts');
        }
    }
    public function viewContract($contract_id = null)
    {
        $data['contract'] = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('contracts.created_by AS contract_created_by'),
                DB::raw('contracts.updated_at AS contract_updated_date'),
                DB::raw('contracts.status AS contract_status'),
                DB::raw('contracts.stage AS contract_stage'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('other_documents.*'),
                DB::raw('contracts_storage.*'),
                DB::raw('draft_stages.*'),
                DB::raw('contract_status.*'),
                DB::raw('contract_types.*'),
                // DB::raw('contract_duration.*'),
                DB::raw('contracts_renewal_types.*'),
                DB::raw('contracts_action_dates.*'),
                DB::raw('contracts.contract_id AS contract_id')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            // ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftjoin('contracts_storage', 'contracts.contract_id', '=', 'contracts_storage.contract_id')
            ->leftJoin('draft_stages', 'contract_drafts.stage_id', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('other_documents', 'contracts.contract_id', '=', 'other_documents.contract_id')
            ->leftJoin('contract_status', 'contracts.status', '=', 'contract_status.status_id')
            ->leftJoin('contract_types', 'contracts.contract_type', '=', 'contract_types.contract_type_id')
            ->leftJoin('contracts_action_dates', 'contracts.contract_id', '=', 'contracts_action_dates.contract_id')
            // ->leftJoin('contract_duration', 'contracts.term_id', '=', 'contract_duration.id')
            ->leftJoin('contracts_renewal_types', 'contracts.renewal_id', '=', 'contracts_renewal_types.id')
            ->leftJoin('users', 'contracts.assigned_user_id', '=', 'users.id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where('contracts.contract_id', '=', $contract_id)
            ->first();

        $data['contract_types'] = DB::table('contract_types')->select(DB::raw('contract_types.*'))->get();

        // $supporting_documents = SupportingDocuments::first();
        $supporting_documents = SupportingDocuments::where('contract_id', $contract_id)
            ->first();
        $files = explode(';', $supporting_documents->files);
        $docs = array_filter(array_map('trim', $files));
        $docs = str_replace('["', '', $docs);
        $docs = str_replace('"]', '', $docs);
        $docs = str_replace('","', ',', $docs);
        $docs = str_replace('uploads\/other_documents\/', '', $docs);
        foreach ($docs as $key => $value) {
            $docs = $value;
        }
        $data['docs'] = explode(',', $docs);
        //  $data['docs'] = array_filter(array_map('trim', $docs));

        //  echo"<pre>";
        //  print_r($docs);
        //  exit;

        $data['latest'] = contract_drafts::where('contract_draft_id', $data['contract']->last_draft_id)
            ->latest('created_at')
            ->first();
        $data['caf_form'] = contract_drafts::where([
            ['contract_id', '=', $data['contract']->contract_id],
            ['contract_drafts.stage_id', '=', 4]
        ])->first();

        $data['caf_form_standard1'] = contract_drafts::where([
            ['contract_id', '=', $data['contract']->contract_id],
            ['contract_drafts.stage_id', '=', 1]
        ])->first();
        $data['caf_form_standard5'] = contract_drafts::where([
            ['contract_id', '=', $data['contract']->contract_id],
            ['contract_drafts.stage_id', '=', 5]
        ])->first();

        $data['caf_form_standard6'] = contract_drafts::where([
            ['contract_id', '=', $data['contract']->contract_id],
            ['contract_drafts.stage_id', '=', 6]
        ])->first();

        $data['assigned_user'] = DB::table('users')->where('id', '=', $data['contract']->assigned_user_id)->first();
        $data['created_user'] = DB::table('users')->where('id', '=', $data['contract']->contract_created_by)->first();
        $data['draft_created_date'] = DB::table('contracts_action_dates')
            ->where('contract_id', '=', $data['contract']->contract_id)
            ->where('contracts_action_dates.contract_stage_id', '=', '1')->first();
        $data['draft_review_sent_date'] = DB::table('contracts_action_dates')
            ->where('contract_id', '=', $data['contract']->contract_id)
            ->where('contracts_action_dates.contract_stage_id', '=', '2')->first();
        $data['final_draft_sent'] = DB::table('contracts_action_dates')
            ->where('contract_id', '=', $data['contract']->contract_id)
            ->where('contracts_action_dates.contract_stage_id', '=', '3')->first();
        $data['caf_uploaded_date'] = DB::table('contracts_action_dates')
            ->where('contract_id', '=', $data['contract']->contract_id)
            ->where('contracts_action_dates.contract_stage_id', '=', '4')->first();
        $data['caf_approved_date'] = DB::table('contracts_action_dates')
            ->where('contract_id', '=', $data['contract']->contract_id)
            ->where('contracts_action_dates.contract_stage_id', '=', '5')->first();
        $data['contract_closed_date'] = DB::table('contracts_action_dates')
            ->where('contract_id', '=', $data['contract']->contract_id)
            ->where('contracts_action_dates.contract_stage_id', '=', '6')->first();
        $data['last_draft_contract_section'] = DB::table('contracts')
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
            ->where(['contracts.contract_id' => $contract_id, 'contract_drafts.contract_draft_id' => $data['latest']->contract_draft_id])
            ->first();
        $data['contract_drafts'] = DB::table('contract_drafts')
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
        $user = Auth::user();
        ~$user_role = $user->getRoleNames()->first();
        $data['legal_team'] = User::role("Legal Counsel")->get();
        $data['cabinet_number'] = DB::table('cabinets')->pluck('cabinet_number', 'cabinet_id')->all();
        return view('contracts.view')->with($data);
    }
    // Pending Contracts
    public function pendingContracts()
    {
        $user = Auth::user();
        ~$user_role = $user->getRoleNames()->first();
        if ($user_role == "Admin") {
            $compare_field = "contracts.contract_id";
            $compare_operator = ">=";
            $compare_value = 1;
            $contract_status_query = contract::where($compare_field, $compare_operator, $compare_value)
                ->where(function ($query) {
                    $query->where('contracts.status', 'Approved')
                        ->orWhere('contracts.status', 'Submitted')
                        ->orWhere('contracts.status', 'Amended')
                        ->orWhere('contracts.status', 'Terminated')
                        ->orWhere('contracts.status', 1);
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
        $pending_contracts = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('contracts.status AS contract_status'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('contracts.updated_at AS contract_updated_at'),
                DB::raw('contracts.stage AS contract_stage'),
                DB::raw('contracts.published_time AS contract_published_time'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('contract_status.*'),
                DB::raw('draft_stages.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_status', 'contracts.status', '=', 'contract_status.status_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where($compare_field, $compare_operator, $compare_value)
            ->where('contracts.status', '=', 1)
            ->get();
        $pending_contracts->map(function ($item) {
            $published_time = Carbon::parse($item->created_at);
            $current_time = Carbon::now('Africa/Nairobi');
            $duration = $current_time->diffInMinutes($published_time);
            $item->escalation_duration = $duration;
            return $item;
        });
        $overdue_pending_contracts = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('contracts.status AS contract_status'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('contracts.updated_at AS contract_updated_at'),
                DB::raw('contracts.stage AS contract_stage'),
                DB::raw('contracts.published_time AS contract_published_time'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('contract_status.*'),
                DB::raw('draft_stages.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_status', 'contracts.status', '=', 'contract_status.status_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where($compare_field, $compare_operator, $compare_value)
            ->where([
                ['contracts.stage', '=', 1],
                ['contracts.assigned', '=', 0]
            ])
            ->get();
        $overdue_pending_contracts->map(function ($item) {
            $published_time = Carbon::parse($item->created_at);
            $current_time = Carbon::now('Africa/Nairobi');
            $duration = $current_time->diffInMinutes($published_time);
            $item->escalation_duration = $duration;
            return $item;
        });
        // Assigned Pending Contracts
        $assigned_pending_contracts = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('contracts.status AS contract_status'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('contracts.updated_at AS contract_updated_at'),
                DB::raw('contracts.stage AS contract_stage'),
                DB::raw('contracts.published_time AS contract_published_time'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('contract_status.*'),
                DB::raw('draft_stages.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_status', 'contracts.status', '=', 'contract_status.status_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where($compare_field, $compare_operator, $compare_value)
            ->where([
                ['contracts.stage', '=', 1],
                ['contracts.assigned', '=', 1]
            ])->get();
        // My Pending Contracts
        $my_pending_contracts = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('contracts.status AS contract_status'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('contracts.updated_at AS contract_updated_at'),
                DB::raw('contracts.stage AS contract_stage'),
                DB::raw('contracts.published_time AS contract_published_time'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('contract_status.*'),
                DB::raw('draft_stages.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_status', 'contracts.status', '=', 'contract_status.status_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where([
                ['contracts.stage', '=', 1],
                ['contracts.created_by', '=', Auth::user()->id]
            ])->get();
        $my_pending_contracts->map(function ($item) {
            $published_time = Carbon::parse($item->contract_published_time);
            $current_time = Carbon::now('Africa/Nairobi');
            $duration = $current_time->diffInMinutes($published_time);
            $item->escalation_duration = $duration;
            return $item;
        });

        return view('contracts.pending-contracts')->with([
            'pending_contracts' => $pending_contracts,
            'overdue_pending_contracts' => $overdue_pending_contracts,
            'assigned_pending_contracts' => $assigned_pending_contracts,
            'my_pending_contracts' => $my_pending_contracts
        ]);
    }

    public function classifyContract(request $request)
    {
        $classify_contract = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('parties.*'),
                DB::raw('users.name AS user_name'),
                DB::raw('users.id'),
                DB::raw('users.email AS user_email'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('draft_stages.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.created_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where('contracts.contract_id', '=', $request->contract_id)
            ->first();
        $contract_type_id = $request->input('contract_type_id');
        $classified_contract_id = $request->contract_id;

        $message = "You have successfully classified the contract";
        DB::table('contracts')->where('contract_id', $classified_contract_id)
            ->update(['contract_type' => $contract_type_id]);

        Alert::success('Classify Contract', $message);
        return redirect('contract/' . $classified_contract_id . '/view');
    }
    public function workonContract(request $request)
    {
        $contractss = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('parties.*'),
                DB::raw('users.name AS user_name'),
                DB::raw('users.id'),
                DB::raw('users.email AS user_email'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('draft_stages.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.created_by', '=', 'users.id')
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
        $message = "Contract successfully assigned to you";
        DB::table('contracts')->where('contract_id', $assigned_contract_id)
            ->update(['assigned' => $assigned, 'assigned_user_id' => $assigned_user_id]);

        $user = \Auth::user();
        $company = "Wananchi Group Ltd";
        $objDemo = new \stdClass();
        $objDemo->contract_code = $contractss->contract_code;
        $objDemo->title = $contractss->contract_title;
        $objDemo->email = $contractss->user_email;
        $objDemo->name = $contractss->user_name;
        $objDemo->subject = 'Contract ' . '#' . $contractss->contract_code . ' Acknowledged';
        $objDemo->message = "One of our legal members is working on your request";
        $objDemo->company = $company;

        $objDemo->legal_email = $user->email;
        $objDemo->legal_name = $user->name;
        $objDemo->legal_message = "You can view the full details of the contract from the Wananchi Legal System";

        Mail::to($objDemo->email)->send(new ContractAcknowledgement($objDemo));
        Mail::to($user->email)->send(new ContractAcknowledgementMail($objDemo));
        $data['legal_admin'] = User::getLegalAdmin();
        foreach ($data['legal_admin'] as $legal_admin) {
            $objDemo->admin_name = $legal_admin->name;
            $objDemo->admin_message = "You can view the full details of the contract from the Wananchi Legal System";
            Mail::to($legal_admin->email)->send(new ContractAcknowledged($objDemo));
        }
        Alert::success('Work on Contract', $message);
        return redirect('contract/' . $assigned_contract_id . '/view');
    }
    // Admin assign ticket to helpdesk team
    public function assignContract(request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            DB::rollBack();
            Alert::error('New Contract Request', 'Oops!!! An error ocurred while creating new contract request');
            return back();
        } else {
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
            $assigned_user_id = $request->input('id');
            $message = "You have successfully assigned the legal counsel";
            DB::table('contracts')->where('contract_id', $assigned_contract_id)
                ->update(['assigned' => $assigned, 'assigned_user_id' => $assigned_user_id]);
            Alert::success('Assign Contract', $message);
            return redirect('contract/' . $assigned_contract_id . '/view');
        }
    }
    // Transfer contract to another legal counsel member
    public function transferContract(request $request)
    {
        $transfer_contracts = DB::table('contracts')
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
        $transferred_contract_id = $request->contract_id;
        $assigned_user_id = $request->input('id');
        $transfer_comments = $request->input('comments');
        $transferred = 1;
        $message = "You have successfully transferred the contract to ";
        DB::table('contracts')->where('contract_id', $transferred_contract_id)
            ->update(['assigned_user_id' => $assigned_user_id, 'transferred' => $transferred, 'transfer_comments' => $transfer_comments]);
        Alert::success('Transfer Contract', $message);
        return redirect('contract/' . $transferred_contract_id . '/view');
        // ->with('success', $message);
    }
    // Share reviewed contract by the legal department to the user for comments
    public function shareReviewedContract(request $request)
    {
        $reviewed_contract = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.name AS user_name'),
                DB::raw('users.email AS user_email'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('draft_stages.*'),
                DB::raw('contract_status.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_status', 'contracts.status', '=', 'contract_status.status_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where('contracts.contract_id', '=', $request->contract_id)
            ->first();
        $reviewed_contract_file = '';
        $contract_title = $reviewed_contract->contract_title;
        $reviewed_string = "Reviewed Contract";
        if ($request->hasFile('reviewed_contract_document') && $request->file('reviewed_contract_document')->isValid()) {
            $file = $request->file('reviewed_contract_document');
            $file_name = $contract_title . '-' . $reviewed_string . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/contract_documents', $file_name);
            $reviewed_contract_file = 'uploads/contract_documents/' . $file_name;
        }
        $stage = 2;
        $status = 2;
        $reviewed_contract_id = $request->contract_id;
        $reviewed_contract->comments = $request->input('comments');
        $review_comments = $reviewed_contract->comments;
        $created_by = $reviewed_contract->created_by;
        $reviewed_date = Carbon::now('Africa/Nairobi');
        DB::table('contracts')->where('contract_id', $reviewed_contract_id)
            ->update([
                'status' => $status, 'stage' => $stage,
                'updated_by' => Auth::user()->id
            ]);
        $contract_draft_data = array(
            'contract_id' => $reviewed_contract_id,
            'stage_id' => 2,
            'draft_file' => $reviewed_contract_file,
            'status' => 2,
            'comments' => $review_comments,
            'created_by' => $created_by,
            'updated_by' => Auth::user()->id,
        );
        $action_dates_data = array(
            'contract_id' => $reviewed_contract_id,
            'contract_stage_id' => $stage,
            'status_id' => 2,
            'date' => $reviewed_date
        );
        $last_draft_id = DB::table('contract_drafts')->insertGetId($contract_draft_data);
        $action_dates_data = DB::table('contracts_action_dates')->insertGetId($action_dates_data);
        DB::table('contracts')->where('contract_id', $reviewed_contract_id)->update(array('last_draft_id' => $last_draft_id));

        $objDemo = new \stdClass();
        $objDemo->contract_code = $reviewed_contract->contract_code;
        $objDemo->title = $reviewed_contract->contract_title;
        $objDemo->subject = 'Draft Review ' . '('. '#' . $reviewed_contract->contract_code.')' . ' Shared';
        $company = "Wananchi Group Ltd";
        $objDemo->company = $company;

        //1. Send to the user
        $message = "Wananchi Group Legal Department has uploaded a draft review for Contract:";
        $objDemo->email = $reviewed_contract->user_email;
        $objDemo->name = $reviewed_contract->user_name;
        $objDemo->message = $message;

        Mail::to($objDemo->email)->send(new DraftReviewShared($objDemo));

        //2. Send to the legal
        $user = \Auth::user();
        $objDemo1 = new \stdClass();
        $objDemo1->contract_code = $reviewed_contract->contract_code;
        $objDemo1->title = $reviewed_contract->contract_title;
        $objDemo1->subject = 'Draft Review ' . ('#' . $reviewed_contract->contract_code) . ' Shared';
        $objDemo1->company = $company;
        $objDemo1->email = $user->email;
        $objDemo1->name = $user->name;
        $objDemo1->message =  "You have uploaded a draft review for Contract:";

        Mail::to($user->email)->send(new DraftReviewShared($objDemo1));


        $data['legal_admin'] = User::getLegalAdmin();
        foreach ($data['legal_admin'] as $legal_admin) {
            $objDemo2 = new \stdClass();
            $objDemo2->name = $legal_admin->name;
            $objDemo2->contract_code = $reviewed_contract->contract_code;
            $objDemo2->title = $reviewed_contract->contract_title;
            $objDemo2->subject = 'Draft Review ' . ('#' . $reviewed_contract->contract_code) . ' Shared';
            $company = "Wananchi Group Ltd";
            $objDemo2->company = $company;
            $objDemo2->message =  $user->name. " has uploaded a draft review for Contract:";
            Mail::to($legal_admin->email)->send(new DraftReviewShared($objDemo2));
        }

        Alert::success('Upload Reviewed Contract', 'Reviewed Contract successfully sent to the user...');
        return redirect('contract/' . $request->input('contract_id') . '/view');
    }
    // User comments on the reviewed contract received above
    public function commentReviewedContract(request $request)
    {
        $comment_reviewed_contract = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('draft_stages.*'),
                DB::raw('contract_status.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_status', 'contracts.status', '=', 'contract_status.status_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where('contracts.contract_id', '=', $request->contract_id)
            ->first();
        $stage = 2;
        $status = 2;
        $reviewed_contract_id = $request->contract_id;
        $comment_reviewed_contract->comments = $request->input('comments');
        $review_comments = $comment_reviewed_contract->comments;
        DB::table('contract_drafts')->where([
            ['contract_id', $reviewed_contract_id],
            ['stage_id', $stage],
            ['status', $status],
        ])->update([
            'user_comments' => $review_comments
        ]);
        Alert::success('Comment on Reviewed Contract', 'Comments sent successfully..');
        return redirect('contract/' . $request->input('contract_id') . '/view');
    }
    // Share final draft by the legal department to the user
    public function shareFinalDraft(request $request)
    {
        $final_draft = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.name AS user_name'),
                DB::raw('users.email AS user_email'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('draft_stages.*'),
                DB::raw('contract_status.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_status', 'contracts.status', '=', 'contract_status.status_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where('contracts.contract_id', '=', $request->contract_id)
            ->first();
        $final_draft_file = '';
        $contract_title = $final_draft->contract_title;
        $final_draft_string = "Final Draft";
        if ($request->hasFile('final_draft_document') && $request->file('final_draft_document')->isValid()) {
            $file = $request->file('final_draft_document');
            $file_name = $contract_title . '-' . $final_draft_string . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/contract_documents', $file_name);
            $final_draft_file = 'uploads/contract_documents/' . $file_name;
        }
        $stage = 3;
        $status = 2;
        $final_draft_id = $request->contract_id;
        $final_draft->comments = $request->input('comments');
        $review_comments = $final_draft->comments;
        $created_by = $final_draft->created_by;
        $final_draft_date = Carbon::now('Africa/Nairobi');
        DB::table('contracts')->where('contract_id', $final_draft_id)
            ->update([
                'status' => $status, 'stage' => $stage,
                'updated_by' => Auth::user()->id
            ]);
        $contract_draft_data = array(
            'contract_id' => $final_draft_id,
            'stage_id' => 3,
            'draft_file' => $final_draft_file,
            'status' => 2,
            'comments' => $review_comments,
            'created_by' => $created_by,
            'updated_by' => Auth::user()->id,
        );
        $action_dates_data = array(
            'contract_id' => $final_draft_id,
            'contract_stage_id' => $stage,
            'status_id' => 2,
            'date' => $final_draft_date
        );
        $last_draft_id = DB::table('contract_drafts')->insertGetId($contract_draft_data);
        $action_dates_data = DB::table('contracts_action_dates')->insertGetId($action_dates_data);
        DB::table('contracts')->where('contract_id', $final_draft_id)->update(array('last_draft_id' => $last_draft_id));

        $objDemo = new \stdClass();
        $objDemo->contract_code = $final_draft->contract_code;
        $objDemo->title = $final_draft->contract_title;
        $objDemo->subject = 'Final Draft ' . '(' . '#' . $final_draft->contract_code . ')' . ' Shared';
        $company = "Wananchi Group Ltd";
        $objDemo->company = $company;

        //1. Send to the user
        $message = "Wananchi Group Legal Department has uploaded the final draft for your contract. Login in to Wananchi Legal System and upload the CAF document.";
        $objDemo->email = $final_draft->user_email;
        $objDemo->name = $final_draft->user_name;
        $objDemo->message = $message;

        Mail::to($objDemo->email)->send(new FinalDraftShared($objDemo));

        //2. Send to the legal
        $user = \Auth::user();
        $objDemo1 = new \stdClass();
        $objDemo1->contract_code = $final_draft->contract_code;
        $objDemo1->title = $final_draft->contract_title;
        $objDemo1->subject = 'Final Draft '  . '(' . '#' . $final_draft->contract_code . ')' .  ' Shared';
        $objDemo1->company = $company;
        $objDemo1->email = $user->email;
        $objDemo1->name = $user->name;
        $objDemo1->message =  "You have uploaded the final draft for Contract:";

        Mail::to($user->email)->send(new FinalDraftShared($objDemo1));


        $data['legal_admin'] = User::getLegalAdmin();
        foreach ($data['legal_admin'] as $legal_admin) {
            $objDemo2 = new \stdClass();
            $objDemo2->name = $legal_admin->name;
            $objDemo2->contract_code = $final_draft->contract_code;
            $objDemo2->title = $final_draft->contract_title;
            $objDemo2->subject = 'Final Draft ' . ('#' . $final_draft->contract_code) . ' Shared';
            $company = "Wananchi Group Ltd";
            $objDemo2->company = $company;
            $objDemo2->message =  $user->name . " has uploaded the final draft for Contract:";
            Mail::to($legal_admin->email)->send(new FinalDraftShared($objDemo2));
        }


        Alert::success('Upload Final Draft', 'Final Draft successfully sent to the user...');
        return redirect('contract/' . $request->input('contract_id') . '/view');
    }
    // User comments on the final draft received above
    public function commentFinalDraft(request $request)
    {
        $comment_draft = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('draft_stages.*'),
                DB::raw('contract_status.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_status', 'contracts.status', '=', 'contract_status.status_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where('contracts.contract_id', '=', $request->contract_id)
            ->first();
        $stage = 3;
        $status = 2;
        $final_draft_id = $request->contract_id;
        $comment_draft->comments = $request->input('comments');
        $draft_comments = $comment_draft->comments;
        DB::table('contract_drafts')->where([
            ['contract_id', $final_draft_id],
            ['stage_id', 3],
            ['status', $status],
        ])->update([
            'user_comments' => $draft_comments
        ]);
        Alert::success('Comment on Final Draft', 'Comments sent successfully..');
        return redirect('contract/' . $request->input('contract_id') . '/view');
    }
    // Upload CAF
    public function uploadCAF(request $request)
    {
        $upload_caf = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.name AS user_name'),
                DB::raw('users.email AS user_email'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('draft_stages.*'),
                DB::raw('contract_status.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.created_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_status', 'contracts.status', '=', 'contract_status.status_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where('contracts.contract_id', '=', $request->contract_id)
            ->first();
        $caf_document = '';
        $contract_title = $upload_caf->contract_title;
        $upload_caf_string = "CAF Document";
        if ($request->hasFile('caf_document') && $request->file('caf_document')->isValid()) {
            $file = $request->file('caf_document');
            $file_name = $contract_title . '-' . $upload_caf_string . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/caf_documents', $file_name);
            $caf_document = 'uploads/caf_documents/' . $file_name;
        }
        $stage = 4;
        $status = 2;
        $final_draft_id = $request->contract_id;
        $draft_file = $upload_caf->draft_file;
        $upload_caf->comments = $request->input('comments');
        $upload_comments = $upload_caf->comments;
        $created_by = $upload_caf->created_by;
        $upload_caf_date = Carbon::now('Africa/Nairobi');
        DB::table('contracts')->where('contract_id', $final_draft_id)
            ->update([
                'status' => $status, 'stage' => $stage,
                'updated_by' => Auth::user()->id
            ]);
        $contract_draft_data = array(
            'contract_id' => $final_draft_id,
            'stage_id' => 4,
            'draft_file' => $draft_file,
            'crf_form' => $caf_document,
            'status' => 2,
            'user_comments' => $upload_comments,
            'created_by' => $created_by,
            'updated_by' => Auth::user()->id,
        );
        $action_dates_data = array(
            'contract_id' => $final_draft_id,
            'contract_stage_id' => $stage,
            'status_id' => 2,
            'date' => $upload_caf_date
        );
        $last_draft_id = DB::table('contract_drafts')->insertGetId($contract_draft_data);
        $action_dates_data = DB::table('contracts_action_dates')->insertGetId($action_dates_data);

        $objDemo = new \stdClass();
        $objDemo->contract_code = $upload_caf->contract_code;
        $objDemo->title = $upload_caf->contract_title;
        $objDemo->subject = 'CAF ' . '(' . '#' . $upload_caf->contract_code . ')' . ' Uploaded';
        $company = "Wananchi Group Ltd";
        $objDemo->company = $company;

        //1. Send to the user
        $message = "You have uploaded CAF for Contract awaiting approval by the legal department";
        $objDemo->email = $upload_caf->user_email;
        $objDemo->name = $upload_caf->user_name;
        $objDemo->message = $message;

        Mail::to($objDemo->email)->send(new CAFUploaded($objDemo));

        //2. Send to the legal
        $assigned_user = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('users.name AS legal_name'),
                DB::raw('users.email AS legal_email')
            )
            ->leftJoin('users', 'contracts.assigned_user_id', '=', 'users.id')
            ->first();

            echo $assigned_user->legal_email;
            exit;

        $objDemo1 = new \stdClass();
        $objDemo1->contract_code = $upload_caf->contract_code;
        $objDemo1->title = $upload_caf->contract_title;
        $objDemo1->subject = 'CAF '  . '(' . '#' . $upload_caf->contract_code . ')' .  ' Uploaded';
        $objDemo1->company = $company;
        $objDemo1->email = $assigned_user->legal_email;
        $objDemo1->name = $assigned_user->legal_name;
        $objDemo1->message = " CAF for contract " . $upload_caf->contract_code . " has uploaded CAF pending approval from you:";

        Mail::to( $assigned_user->legal_email)->send(new CAFUploaded($objDemo1));

        $data['legal_admin'] = User::getLegalAdmin();
        foreach ($data['legal_admin'] as $legal_admin) {
            $objDemo2 = new \stdClass();
            $objDemo2->name = $legal_admin->name;
            $objDemo2->contract_code = $upload_caf->contract_code;
            $objDemo2->title = $upload_caf->contract_title;
            $objDemo2->subject = 'CAF ' . ('#' . $upload_caf->contract_code) . ' Uploaded';
            $company = "Wananchi Group Ltd";
            $objDemo2->company = $company;
            $objDemo2->message = " CAF for contract" .$upload_caf->contract_code ."  has uploaded CAF pending approval from the legal department:";
            Mail::to($legal_admin->email)->send(new CAFUploaded($objDemo2));
        }



        Alert::success('Upload CAF Document', 'CAF successfully uploaded for review by legal department...');
        return redirect('contract/' . $request->input('contract_id') . '/view');
    }
    public function approveCAF(request $request)
    {
        $approved_caf = DB::table('contracts')
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
        $approved_contract_file = '';
        $approved_string = "Approved";
        $approved_contract_file = $approved_caf->draft_file;
        $stage = 5;
        $status = 3;
        $approved_contract_id = $request->contract_id;
        $approved_contract_file = $approved_caf->draft_file;
        $crf_form = $approved_caf->crf_form;
        $created_by = $approved_caf->created_by;
        // $action_id = Auth::user()->id;
        $approved_date = Carbon::now('Africa/Nairobi');
        $contract_term = $approved_caf->term;
        // $expiry_date = Carbon::now()->addMonths($contract_term);
        DB::table('contracts')->where('contract_id', $approved_contract_id)->update(
            [
                'status' => $status, 'stage' => $stage,
                'updated_by' => Auth::user()->id
            ]
        );
        $contract_draft_data = array(
            'contract_id' => $approved_contract_id,
            'stage_id' => 5,
            'draft_file' => $approved_contract_file,
            'crf_form' => $crf_form,
            'status' => 3,
            'created_by' => $created_by,
            'updated_by' => Auth::user()->id,
        );
        $action_dates_data = array(
            'contract_id' => $approved_contract_id,
            'contract_stage_id' => $stage,
            'status_id' => 3,
            'date' => $approved_date
        );
        $last_draft_id = DB::table('contract_drafts')->insertGetId($contract_draft_data);
        $action_dates_data = DB::table('contracts_action_dates')->insertGetId($action_dates_data);
        DB::table('contracts')->where('contract_id', $approved_contract_id)->update(array('last_draft_id' => $last_draft_id));
        Alert::success('CAF Approval', 'Contract Authorization Form(CAF) successfully approved');
        return redirect('contract/' . $request->input('contract_id') . '/view');
    }
    // Pending Contracts
    public function reviewedContracts()
    {
        $user = Auth::user();
        ~$user_role = $user->getRoleNames()->first();
        if ($user_role == "Admin") {
            $compare_field = "contracts.contract_id";
            $compare_operator = ">=";
            $compare_value = 1;
            $contract_status_query = contract::where($compare_field, $compare_operator, $compare_value)
                ->where(function ($query) {
                    $query->where('contracts.status', 'Approved')
                        ->orWhere('contracts.status', 'Submitted')
                        ->orWhere('contracts.status', 'Amended')
                        ->orWhere('contracts.status', 'Terminated')
                        ->orWhere('contracts.status', 1);
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
        $data['reviewed_contracts'] = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('contracts.status AS contract_status'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('contracts.updated_at AS contract_updated_at'),
                DB::raw('contracts.stage AS contract_stage'),
                DB::raw('contracts.published_time AS contract_published_time'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('contract_status.*'),
                DB::raw('draft_stages.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_status', 'contracts.status', '=', 'contract_status.status_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where($compare_field, $compare_operator, $compare_value)
            ->where('contracts.status', '=', 2)
            ->get();
        $data['draft_sent_for_review'] = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('contracts.status AS contract_status'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('contracts.updated_at AS contract_updated_at'),
                DB::raw('contracts.stage AS contract_stage'),
                DB::raw('contracts.published_time AS contract_published_time'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('contract_status.*'),
                DB::raw('draft_stages.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_status', 'contracts.status', '=', 'contract_status.status_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where($compare_field, $compare_operator, $compare_value)
            ->where('contracts.stage', '=', 2)
            ->where('contracts.status', '=', 2)
            ->get();
        $data['final_draft_sent'] = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('contracts.status AS contract_status'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('contracts.updated_at AS contract_updated_at'),
                DB::raw('contracts.stage AS contract_stage'),
                DB::raw('contracts.published_time AS contract_published_time'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('contract_status.*'),
                DB::raw('draft_stages.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_status', 'contracts.status', '=', 'contract_status.status_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where($compare_field, $compare_operator, $compare_value)
            ->where('contracts.stage', '=', 3)
            ->where('contracts.status', '=', 2)
            ->get();
        $data['uploaded_caf'] = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('contracts.status AS contract_status'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('contracts.updated_at AS contract_updated_at'),
                DB::raw('contracts.stage AS contract_stage'),
                DB::raw('contracts.published_time AS contract_published_time'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('contract_status.*'),
                DB::raw('draft_stages.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            // ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('contract_drafts', 'contracts.contract_id', '=', 'contract_drafts.contract_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_status', 'contracts.status', '=', 'contract_status.status_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where([
                [$compare_field, $compare_operator, $compare_value],
                ['contracts.stage', '=', 4],
                ['contracts.status', '=', 2],
                ['contract_drafts.crf_form', '!=', '']
            ])
            ->get();;
        return view('contracts.reviewed-contracts')->with($data);
    }

    public function closeContract(request $request)
    {
        $closed_contract = DB::table('contracts')
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
        $approved_contract_file = '';
        $closed_string = "Closed";
        $approved_contract_file = $closed_contract->draft_file;
        $stage = 6;
        $status = 4;
        $closed_contract_id = $request->contract_id;
        $approved_contract_file = $closed_contract->draft_file;
        $crf_form = $closed_contract->crf_form;
        $created_by = $closed_contract->created_by;
        // $action_id = Auth::user()->id;
        $closed_date = Carbon::now('Africa/Nairobi');
        DB::table('contracts')->where('contract_id', $closed_contract_id)->update(
            [
                'status' => $status, 'stage' => $stage,
                'updated_by' => Auth::user()->id
            ]
        );
        $contract_draft_data = array(
            'contract_id' => $closed_contract_id,
            'stage_id' => 6,
            'draft_file' => $approved_contract_file,
            'crf_form' => $crf_form,
            'status' => 4,
            'created_by' => $created_by,
            'updated_by' => Auth::user()->id,
        );
        $action_dates_data = array(
            'contract_id' => $closed_contract_id,
            'contract_stage_id' => $stage,
            'status_id' => 4,
            'date' => $closed_date
        );
        $last_draft_id = DB::table('contract_drafts')->insertGetId($contract_draft_data);
        $action_dates_data = DB::table('contracts_action_dates')->insertGetId($action_dates_data);
        DB::table('contracts')->where('contract_id', $closed_contract_id)->update(array('last_draft_id' => $last_draft_id));
        Alert::success('Close Contract', 'Contract successfully closed');
        return redirect('contract/' . $request->input('contract_id') . '/view');
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
        ]);
        $contract->contract_title = ucwords($request->input('title'));
        $contract->party_name_id = $request->input('party_name');
        if ($request->input('expiry_date')) {
            $contract->expiry_date = date("Y-m-d", strtotime($request->input('expiry_date')));
        }
        $contract->description = $request->input('description');
        $contract->stage = 1;
        $contract->status = 1;
        $contract->updated_by = Auth::user()->id;
        $contract->last_action_by = Auth::user()->id;
        $contract->save();
        $just_saved_contract_id = $contract->contract_id;
        $contract_file = '';
        $contract_title = $contract->contract_title;
        $updated_string = "First Draft";
        if ($request->hasFile('contract_document') && $request->file('contract_document')->isValid()) {
            $file = $request->file('contract_document');
            $file_name = $contract_title . '-' . $updated_string . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/contract_documents', $file_name);
            $contract_file = 'uploads/contract_documents/' . $file_name;
        }
        $contract_draft_data = array(
            'contract_id' => $just_saved_contract_id,
            'stage_id' => 1,
            'draft_file' => $contract_file,
            'status' => '1',
            'updated_by' => Auth::user()->id,
        );
        $last_draft_id = DB::table('contract_drafts')->where('contract_draft_id', $contract->last_draft_id)->update($contract_draft_data);
        Alert::success('Update Contract', 'Contract successfully updated');
        return back();
        // ->with('success', 'Contract Successfully Updated!');
    }
    /**
     * Submit the Contract Information to the Legal Team and change the status of the contract
     * from published to
     **/
    function publish(request $request)
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
                DB::raw('contracts_storage.*'),
                DB::raw('draft_stages.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftjoin('contracts_storage', 'contracts.contract_id', '=', 'contracts_storage.contract_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where('contracts.contract_id', '=', $request->contract_id)
            ->first();
        $status = 'Pending';
        $stage = 2;
        $published_contract_id = $request->contract_id;
        $published_contract_draft = $contractss->draft_file;
        $created_by = $contractss->created_by;
        $published_time = Carbon::now('Africa/Nairobi');
        DB::table('contracts')->where('contract_id', $published_contract_id)
            ->update(['status' => $status, 'stage' => $stage, 'published_time' => $published_time]);
        $contract_draft_data = array(
            'contract_id' => $published_contract_id,
            'stage_id' => 2,
            'draft_file' => $published_contract_draft,
            'status' => '2',
            'created_by' => $created_by,
            'updated_by' => Auth::user()->id,
        );
        $action_dates_data = array(
            'contract_id' => $published_contract_id,
            'status' => $status,
            'date' => $published_time
        );
        $last_draft_id = DB::table('contract_drafts')->insertGetId($contract_draft_data);
        $action_dates_data = DB::table('contracts_action_dates')->insertGetId($action_dates_data);
        DB::table('contracts')->where('contract_id', $published_contract_id)->update(array('last_draft_id' => $last_draft_id));
        Alert::success('Submit Contract', 'Contract successfully submitted awaiting approval by the legal department');
        return redirect('contract/' . $request->input('contract_id') . '/view');
    }
    public function uploadsignedContract(request $request)
    {
        $signed_contract = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('contract_status.*'),
                DB::raw('draft_stages.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_status', 'contracts.status', '=', 'contract_status.status_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where('contracts.contract_id', '=', $request->contract_id)
            ->first();
        $signed_contract_file = '';
        $crf_form = $signed_contract->crf_form;
        $contract_title = $signed_contract->contract_title;
        $signed_string = "Signed Contract";
        // $initiated_crf_form = '';
        if ($request->hasFile('signed_contract') && $request->file('signed_contract')->isValid()) {
            $file = $request->file('signed_contract');
            $file_name = $contract_title . '-' . $signed_string . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/contract_documents', $file_name);
            $signed_contract_file = 'uploads/contract_documents/' . $file_name;
        }
        $stage = 6;
        $status = 4;
        $signed_contract_id = $request->contract_id;
        $upload_signed_action_id = Auth::user()->id;
        $created_by = $signed_contract->created_by;
        $closed_date = Carbon::now('Africa/Nairobi');
        $contract_term = $signed_contract->term;
        $expiry_date = Carbon::now()->addMonths($contract_term);
        DB::table('contracts')->where('contract_id', $signed_contract_id)
            ->update([
                'status' => $status, 'stage' => $stage,
                // 'legal_upload_signed_id' => $upload_signed_action_id,
                'expiry_date' => $expiry_date, 'updated_by' => Auth::user()->id
            ]);
        $contract_draft_data = array(
            'contract_id' => $signed_contract_id,
            'stage_id' => 6,
            'draft_file' => $signed_contract_file,
            'crf_form' => $crf_form,
            'status' => 4,
            'created_by' => $created_by,
            'updated_by' => Auth::user()->id,
        );
        $action_dates_data = array(
            'contract_id' => $signed_contract_id,
            'contract_stage_id' => 6,
            'status_id' => 4,
            'date' => $closed_date
        );
        $last_draft_id = DB::table('contract_drafts')->insertGetId($contract_draft_data);
        $action_dates_data = DB::table('contracts_action_dates')->insertGetId($action_dates_data);
        DB::table('contracts')->where('contract_id', $signed_contract_id)->update(array('last_draft_id' => $last_draft_id));
        Alert::success('Upload Signed Contract', 'Signed Contract successfully uploaded...');
        return redirect('contract/' . $signed_contract_id . '/view');
        // ->with('success', 'Contract successfully ammended awaiting action by the contract party');
    }
    public function uploadApprovedCAF(request $request)
    {
        $approved_caf = DB::table('contracts')
            ->select(
                DB::raw('contracts.*'),
                DB::raw('parties.*'),
                DB::raw('users.name'),
                DB::raw('users.id'),
                DB::raw('users_details.*'),
                DB::raw('contracts.created_at AS created_date'),
                DB::raw('users_organizations.*'),
                DB::raw('contract_drafts.*'),
                DB::raw('contract_status.*'),
                DB::raw('draft_stages.*')
            )
            ->leftJoin('parties', 'contracts.party_name_id', '=', 'parties.party_id')
            ->leftJoin('users', 'contracts.last_action_by', '=', 'users.id')
            ->leftJoin('users_details', 'contracts.last_action_by', '=', 'users_details.user_id')
            ->leftJoin('users_organizations', 'users_details.organization_id', '=', 'users_organizations.organization_id')
            ->leftJoin('contract_drafts', 'contracts.last_draft_id', '=', 'contract_drafts.contract_draft_id')
            ->leftJoin('draft_stages', 'contracts.stage', '=', 'draft_stages.draft_stage_id')
            ->leftJoin('contract_status', 'contracts.status', '=', 'contract_status.status_id')
            ->orderBy('contracts.contract_id', 'desc')
            ->where('contracts.contract_id', '=', $request->contract_id)
            ->first();
        $approved_caf_file = '';
        $draft_file = $approved_caf->draft_file;
        $contract_title = $approved_caf->contract_title;
        $approved_string = "Approved CAF";

        // $initiated_crf_form = '';
        if ($request->hasFile('approved_caf') && $request->file('approved_caf')->isValid()) {
            $file = $request->file('approved_caf');
            $file_name = $contract_title . '-' . $approved_string . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/caf_documents', $file_name);
            $approved_caf_file = 'uploads/caf_documents/' . $file_name;
        }
        $stage = 6;
        $status = 4;
        $approved_caf_id = $request->contract_id;
        $created_by = $approved_caf->created_by;
        $closed_date = Carbon::now('Africa/Nairobi');
        $contract_term = $approved_caf->term;
        $expiry_date = Carbon::now()->addMonths($contract_term);
        DB::table('contracts')->where('contract_id', $approved_caf_id)
            ->update([
                'status' => $status, 'stage' => $stage,
                // 'legal_upload_signed_id' => $upload_signed_action_id,
                'expiry_date' => $expiry_date, 'updated_by' => Auth::user()->id
            ]);
        $contract_draft_data = array(
            'contract_id' => $approved_caf_id,
            'stage_id' => 6,
            'draft_file' => $draft_file,
            'crf_form' => $approved_caf_file,
            'status' => 4,
            'created_by' => $created_by,
            'updated_by' => Auth::user()->id,
        );
        $action_dates_data = array(
            'contract_id' => $approved_caf_id,
            'contract_stage_id' => 6,
            'status_id' => 4,
            'date' => $closed_date
        );

        // echo "<pre>";
        // print_r($contract_draft_data);
        // exit;
        $last_draft_id = DB::table('contract_drafts')->insertGetId($contract_draft_data);
        $action_dates_data = DB::table('contracts_action_dates')->insertGetId($action_dates_data);
        DB::table('contracts')->where('contract_id', $approved_caf_id)->update(array('last_draft_id' => $last_draft_id));
        Alert::success('Upload Signed Contract', 'Signed Contract successfully uploaded...');
        return redirect('contract/' . $approved_caf_id . '/view');
        // ->with('success', 'Contract successfully ammended awaiting action by the contract party');
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
        $approved_contract_file = '';
        $contract_title = $approved_contract->contract_title;
        $approved_string = "Approved";
        if ($request->hasFile('approved_contract_document') && $request->file('approved_contract_document')->isValid()) {
            $file = $request->file('approved_contract_document');
            $file_name = $contract_title . '-' . $approved_string . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/contract_documents', $file_name);
            $approved_contract_file = 'uploads/contract_documents/' . $file_name;
        } else {
            $approved_contract_file = $approved_contract->draft_file;
        }
        $status = 'Approved';
        $stage = 3;
        $approved_contract->comments = $request->input('comments');
        $approved_contract->contract_type = $request->input('contract_type');
        $contract_type = $approved_contract->contract_type;
        $submit_comments = $approved_contract->comments;
        $approved_contract_id = $request->contract_id;
        $approved_contract_draft = $approved_contract->draft_file;
        $created_by = $approved_contract->created_by;
        $action_id = Auth::user()->id;
        $approved_time = Carbon::now('Africa/Nairobi');
        DB::table('contracts')->where('contract_id', $approved_contract_id)->update(
            [
                'status' => $status, 'stage' => $stage, 'contract_type' => $contract_type,
                'legal_approval_id' => $action_id, 'updated_by' => Auth::user()->id
            ]
        );
        $contract_draft_data = array(
            'contract_id' => $approved_contract_id,
            'stage_id' => 3,
            'draft_file' => $approved_contract_file,
            'status' => 'Approved',
            'comments' => $submit_comments,
            'created_by' => $created_by,
            'updated_by' => Auth::user()->id,
        );
        $action_dates_data = array(
            'contract_id' => $approved_contract_id,
            'status' => $status,
            'date' => $approved_time
        );
        $last_draft_id = DB::table('contract_drafts')->insertGetId($contract_draft_data);
        $action_dates_data = DB::table('contracts_action_dates')->insertGetId($action_dates_data);
        DB::table('contracts')->where('contract_id', $approved_contract_id)->update(array('last_draft_id' => $last_draft_id));
        Alert::success('Contract Approval', 'Contract successfully submitted to the legal admin awaiting for approval');
        return redirect('contract/' . $request->input('contract_id') . '/view');
        // ->with('success', 'Contract successfully submitted to the legal admin awaiting for approval');
    }
    public function archiveContract(request $request)
    {
        $archived_contract = DB::table('contract_drafts')
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
            ->leftJoin('contracts_eage', 'contract_drafts.contract_id', '=', 'contracts_storage.contract_id')
            ->leftJoin('parties', 'parties.party_id', '=', 'contracts.party_name_id')
            ->leftJoin('users', 'users.id', '=', 'contract_drafts.updated_by')
            ->leftJoin('users_details', 'users_details.user_id', '=', 'contracts.created_by')
            ->leftJoin('users_organizations', 'users_organizations.organization_id', '=', 'users_details.organization_id')
            ->leftJoin('draft_stages', 'draft_stages.draft_stage_id', '=', 'contract_drafts.stage_id')
            ->where('contract_drafts.contract_id', '=',  $request->contract_id)
            ->where('contract_drafts.stage_id', '=', 6)
            ->first();
        $archived_contract_id = $request->contract_id;
        $signed_contract_file = $archived_contract->draft_file;
        $cabinet_id = $request->input('cabinet_id');
        $contract_storage_data = array(
            'cabinet_id' => $cabinet_id,
            'contract_id' => $archived_contract_id,
            'signed_contract_file' => $signed_contract_file,
        );
        $update_contract_storage =  DB::table('contracts_storage')->where('contract_id', $archived_contract_id)->update($contract_storage_data);
        Alert::success('Archive Contract', 'Contract successfully archived');
        return redirect('contract/' . $request->input('contract_id') . '/view');
        // ->with('success', 'Contract successfully ammended awaiting action by the contract party');
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
        $contract_title = $ammended_contract->contract_title;
        $ammended_string = "Amended";
        if ($request->hasFile('ammended_contract_document') && $request->file('ammended_contract_document')->isValid()) {
            $file = $request->file('ammended_contract_document');
            $file_name = $contract_title . '-' . $ammended_string . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/contract_documents', $file_name);
            $ammended_contract_file = 'uploads/contract_documents/' . $file_name;
        } else {
            $ammended_contract_file = $ammended_contract->draft_file;
        }
        $status = 'Amended';
        $stage = 4;
        $ammended_contract->comments = $request->input('comments');
        $ammend_comments = $ammended_contract->comments;
        $ammended_contract_id = $request->contract_id;
        $ammendment_action_id = Auth::user()->id;
        $created_by = $ammended_contract->created_by;
        $amended_date = Carbon::now('Africa/Nairobi');
        DB::table('contracts')->where('contract_id', $ammended_contract_id)
            ->update([
                'status' => $status, 'stage' => $stage,
                'legal_ammendment_id' => $ammendment_action_id, 'updated_by' => Auth::user()->id
            ]);
        $contract_draft_data = array(
            'contract_id' => $ammended_contract_id,
            'stage_id' => 4,
            'draft_file' => $ammended_contract_file,
            'status' => 'Amended',
            'comments' => $ammend_comments,
            'created_by' => $created_by,
            'updated_by' => Auth::user()->id,
        );
        $action_dates_data = array(
            'contract_id' => $ammended_contract_id,
            'status' => $status,
            'date' => $amended_date
        );
        $last_draft_id = DB::table('contract_drafts')->insertGetId($contract_draft_data);
        $action_dates_data = DB::table('contracts_action_dates')->insertGetId($action_dates_data);
        DB::table('contracts')->where('contract_id', $ammended_contract_id)->update(array('last_draft_id' => $last_draft_id));
        Alert::success('Ammend Contract', 'Contract successfully amended awaiting action by the contract party');
        return redirect('contract/' . $request->input('contract_id') . '/view');
        // ->with('success', 'Contract successfully ammended awaiting action by the contract party');
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
        $status = 'Terminated';
        $stage = 5;
        $terminated_contract->comments = $request->input('comments');
        $termination_comments = $terminated_contract->comments;
        $terminated_contract_id = $request->contract_id;
        $terminated_contract_draft = $terminated_contract->draft_file;
        $termination_action_id = Auth::user()->id;
        $created_by = $terminated_contract->created_by;
        $terminated_date = Carbon::now('Africa/Nairobi');
        DB::table('contracts')->where('contract_id', $terminated_contract_id)
            ->update([
                'status' => $status, 'stage' => $stage,
                'legal_termination_id' => $termination_action_id, 'updated_by' => Auth::user()->id
            ]);
        $contract_draft_data = array(
            'contract_id' => $terminated_contract_id,
            'stage_id' => 5,
            'draft_file' => $terminated_contract_draft,
            'status' => 'Terminated',
            'comments' => $termination_comments,
            'created_by' => $created_by,
            'updated_by' => Auth::user()->id,
        );
        $action_dates_data = array(
            'contract_id' => $terminated_contract_id,
            'status' => $status,
            'date' => $terminated_date
        );
        $last_draft_id = DB::table('contract_drafts')->insertGetId($contract_draft_data);
        $action_dates_data = DB::table('contracts_action_dates')->insertGetId($action_dates_data);
        DB::table('contracts')->where('contract_id', $terminated_contract_id)->update(array('last_draft_id' => $last_draft_id));
        Alert::success('Terminate Contract', 'Contract successfully terminated and the contract owner has bee notified');
        return redirect('contract/' . $request->input('contract_id') . '/view');
        // ->with('success', 'Contract successfully terminated and the contract owner has bee notified');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy(contract $contract)
    { }
    public function deleteCreatedContract($contract)
    {
        $resp = DB::table('contracts')->where('contract_id', $contract)->delete();
        Alert::success('Delete Contract', 'Contract successfully deleted');
        return back()->with('success', 'Contract successfully deleted');
        // ->with('success', 'Contract Successfully Deleted');
    }
}
