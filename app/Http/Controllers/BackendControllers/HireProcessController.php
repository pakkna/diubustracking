<?php

namespace App\Http\Controllers\BackendControllers;

use Auth;
use App\Traits\Email;
use App\Models\Applicants;
use App\Models\QueryAnswer;
use App\Models\EmployeInfo;
use App\Models\QuestionBank;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use DB;

class HireProcessController extends Controller
{
    use Email;

    public function pending_applicants_view(Request $request)
    {

        return view('dashboard.applicants.pending_applicants');
    }
    public function shortlist_applicants_view()
    {
        return view('dashboard.applicants.shortlisted_applicants');
    }
    public function query_applied_applicants_view()
    {
        return view('dashboard.applicants.query_applied_applicants');
    }
    public function hired_employes_view()
    {
        return view('dashboard.applicants.hired_empoyes');
    }
    public function application_store(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'email' => 'required|email|unique:job_application',
            'name' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        } else {

            $application = new Applicants();

            $application->name = $request->name;
            $application->email = $request->email;
            $application->address = $request->address;
            $application->address_line2 = $request->address2;
            $application->street_address = $request->street_address;
            $application->city_name = $request->city;
            $application->state_name = $request->state;
            $application->zip_code = $request->zip_code;
            $application->phone = $request->phone;
            $application->prior_experience = $request->experience;
            $application->work_experience = implode(",", $request->cleaningtype);
            $application->other_experience = $request->other_working_area;
            $application->time_available = $request->time_available;
            $application->time_duration_present_address = $request->time_available_other;
            $application->employment_background = $request->em_background;
            $application->qualifications = implode(",", $request->qualifications);;
            $application->remarks = $request->comments;
            $application->is_active = $request->addcleaner == 0 ? 0 : 1;
            $application->is_query_submited = $request->addcleaner == 0 ? 0 : 1;
            $application->is_selected = $request->addcleaner == 0 ? 0 : 1;

            DB::beginTransaction();

            try {

                if ($application->save()) {
                    DB::commit();

                    if ($request->addcleaner == 0) {

                        $sub = "Application Confirmation";

                        $msg = "Dear Concern, <br>
                         Your application has been successfully submitted to our getacleaner team.If you are selected you will get another mail for Interview Questions.So, look up your mail for final interview.
                         <br><br> For further queries email at: <br>jobs@getacleaner.ca
                         <br><br>
                         Regards, <br>
                         Team GetaCleaner<br>
                         www.getacleaner.ca";
                        $this->send_raw_email($request->email, $sub, $msg);

                        return redirect()->back()->with("flashMessageSuccess", "Application Summitted Successfully.Check Your Mail Further Information");
                    } else {

                        $this->send_raw_email_with_attachment($request->email);

                        return redirect()->back()->with("flashMessageSuccess", "Application Summitted Successfully.Now you can assign task !");
                    }
                } else {
                    return redirect()->back()->with("flashMessageDanger", "Your Application Submission faild! Try Again.");
                }
            } catch (\Throwable $th) {
                DB::rollback();

                return redirect()->back()->with("flashMessageDanger", $th->getMessage());
            }
        }
    }

    public function applicant_action(Request $request)
    {

        if ($request->type == 'approve') {
            $result = Applicants::findOrFail($request->id);
            $result->is_active = 1;

            if ($result->update()) {
                echo json_encode(['msg' => 'Success', 'type' => 'approve']);
            }
        } elseif ($request->type == 'delete') {
            $result = Applicants::findOrFail($request->id);
            if ($result->delete()) {

                QueryAnswer::where('ApplicantId', $request->id)->delete();
                echo json_encode(['msg' => 'Success', 'type' => 'delete']);
            }
        } elseif ($request->type == 'pending') {
            $result = Applicants::findOrFail($request->id);
            $result->is_active = 0;

            if ($result->update()) {
                echo json_encode(['msg' => 'Success', 'type' => 'pending']);
            }
        } elseif ($request->type == 'status') {

            try {
                EmployeInfo::where('Id', $request->id)->update(['IsActive' => (int)$request->action]);
                User::where('EmpOrCustomerId', $request->id)->update(['IsActive' => (int)$request->action]);
                echo json_encode(['msg' => 'Success', 'type' => $request->type, 'action' => $request->action]);
            } catch (\Throwable $th) {
                echo json_encode(['msg' => $th->getMessage(), 'type' => $request->type,'action' => $request->action]);
            }


        } else {
            echo json_encode(['msg' => 'error', 'type' => '']);
        }
    }

    public function pending_applicants_data(Request $request)
    {

        $date = $request->get('columns')[7]['search']['value'];

        if ($date != '') {

            list($start_date, $end_date) = explode('~', preg_replace('/\s+/', '', $date));

            $start_date = date_validate($start_date);
            $end_date = date_validate($end_date);
        } else {

            $time = strtotime(date('Y-m-d') . '-30 days');
            $start_date = date_validate(date('Y-m-d', $time));
            $end_date = date_validate(date('Y-m-d'));
        }



        $query  = Applicants::select(DB::raw("*,CONCAT(address,', ',city_name,', ',state_name,', ',zip_code) AS full_address"))
            ->where('is_active', 0)
            ->whereBetween('added_date', [$start_date . " 00:00:00", $end_date . " 23:59:59"])
            ->orderBy('added_date', 'DESC');

        return Datatables::of($query)
            ->filterColumn('full_address', function ($query, $keyword) {
                $query->whereRaw("concat_ws(' ', address, city_name,state_name,zip_code) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('select', function ($result) {

                return '<div class="custom-checkbox custom-control">
                    <input type="checkbox" name="checkbox[]" value="' . $result->id . '" id="exampleCustomCheckbox' . $result->id . '" class="custom-control-input">
                    <label class="custom-control-label" for="exampleCustomCheckbox' . $result->id . '"> REG-ID-' . $result->id . '</label>
                   </div>';
            })
            ->addColumn('status', function ($result) {
                if ($result->is_active == 0) {
                    return '<div class="badge badge-pill badge-danger">Pending</div>';
                } else {
                    return '<div class="badge badge-pill badge-success">Active</div>';
                }
            })
            ->addColumn('action', function ($result) {

                $ap = "'approve'";
                $dt = "'delete'";

                return '<div role="group" class="btn-group-md btn-group text-white">
                <a href="javascript:void(0);" onclick="ajaxApprove(' . $result->id . ',this,' . $ap . ')"  class="btn-shadow btn btn-sm btn-success" title="Approve Applicant"><i class="fa fa-check-circle"></i></a>
                <a href="/applicant-info/' . $result->id . '" class="btn-shadow btn btn-primary" title="Apllicant Info"><i class="fa fa-eye"></i></a>
                <a href="javascript:void(0);" onclick="ajaxApprove(' . $result->id . ',this,' . $dt . ')"  class="btn-shadow btn btn-danger" title="Applicant Remove"><i class="fa fa-trash"></i></a>
                </div>';
                //return '<a  href="javascript:void(0);" onclick="ajaxApprove(' . $result->id . ',this,' . $ap . ')" class="btn-shadow btn btn-success btn-sm" title="">Approve</a> | <a href="javascript:void(0);" onclick="ajaxApprove(' . $result->id . ',this,' . $dt . ')"   class="btn-shadow btn btn-danger btn-sm">Delete</a>';
            })
            ->rawColumns(['select', 'status', 'action'])
            ->make(true);
    }

    public  function AllCombineShortList(Request $request)
    {

        if (!empty($request->checkbox)) {

            foreach ($request->checkbox as $key => $val) {
                $id = $request->checkbox[$key];
                $result = Applicants::findOrFail($id);
                $result->is_active = 1;
                $result->update();
            }

            return redirect("/pending-applicants-list")->with("flashMessageSuccess", "Selected Applicants Short Listed Successfully !");
        } else {
            return redirect("/pending-applicants-list")->with("flashMessageDanger", "You Are Not Selected Any Applicant !");
        }
    }
    public function shortlist_applicants_data(Request $request)
    {

        $date = $request->get('columns')[7]['search']['value'];

        if ($date != '') {

            list($start_date, $end_date) = explode('~', preg_replace('/\s+/', '', $date));

            $start_date = date_validate($start_date);
            $end_date = date_validate($end_date);
        } else {

            $time = strtotime(date('Y-m-d') . '-30 days');
            $start_date = date_validate(date('Y-m-d', $time));
            $end_date = date_validate(date('Y-m-d'));
        }



        $query  = Applicants::select(DB::raw("*,CONCAT(address,', ',city_name,', ',state_name,', ',zip_code) AS full_address"))
            ->where('is_active', 1)
            ->where('is_query_submited', 0)
            ->whereBetween('added_date', [$start_date . " 00:00:00", $end_date . " 23:59:59"])
            ->orderBy('is_mail', 'ASC')
            ->orderBy('added_date', 'DESC');

        return Datatables::of($query)
            ->filterColumn('full_address', function ($query, $keyword) {
                $query->whereRaw("concat_ws(' ', address, city_name,state_name,zip_code) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('select', function ($result) {

                if ($result->is_mail != 1) {
                    return '<div class="custom-checkbox custom-control">
                        <input type="checkbox" name="checkbox[]" value="' . $result->email . '" id="exampleCustomCheckbox' . $result->id . '" class="custom-control-input">
                        <label class="custom-control-label" for="exampleCustomCheckbox' . $result->id . '"> RRG-ID-' . $result->id . '</label>
                    </div>';
                } else {
                    return 'RRG-ID-' . $result->id;
                }
            })
            ->addColumn('status', function ($result) {
                if ($result->is_active == 0) {
                    return '<div class="badge badge-pill badge-danger">Pending</div>';
                } else {
                    return '<div class="badge badge-pill badge-success">Approved</div>';
                }
            })
            ->addColumn('mail', function ($result) {
                if ($result->is_mail == 0) {
                    return '<div class="badge badge-pill badge-danger">No</div>';
                } else {
                    return '<div class="badge badge-pill badge-primary">Yes</div>';
                }
            })
            ->addColumn('action', function ($result) {

                $pn = "'pending'";
                $dt = "'delete'";

                return '<div role="group" class="btn-group-md btn-group text-white">
                <a href="javascript:void(0);" onclick="ajaxApprove(' . $result->id . ',this,' . $pn . ')"  class="btn-shadow btn btn-sm btn-success" title="Return To Pending"><i class="fa fa-undo"></i></a>
                <a href="/applicant-info/' . $result->id . '" class="btn-shadow btn btn-primary" title="View Info"><i class="fa fa-eye"></i></a>
                <a href="javascript:void(0);" onclick="ajaxApprove(' . $result->id . ',this,' . $dt . ')"  class="btn-shadow btn btn-danger" title="Applicant Remove"><i class="fa fa-trash"></i></a>
                </div>';
                //return '<a  href="javascript:void(0);" onclick="ajaxApprove(' . $result->id . ',this,' . $pn . ')" class="btn-shadow btn btn-warning btn-sm">Pending</a> | <a href="javascript:void(0);" onclick="ajaxApprove(' . $result->id . ',this,' . $dt . ')"   class="btn-shadow btn btn-danger btn-sm">Delete</a>';
            })
            ->rawColumns(['mail', 'select', 'status', 'action'])
            ->make(true);
    }
    public function query_form_view(Request $request){

        $questions=QuestionBank::where('IsActive',1)->get()->pluck('Question','Id',);

        return  view('fontend.query-form',compact('questions'));
    }
    public function query_submit_applicants_data(Request $request)
    {

        $date = $request->get('columns')[7]['search']['value'];

        if ($date != '') {

            list($start_date, $end_date) = explode('~', preg_replace('/\s+/', '', $date));

            $start_date = date_validate($start_date);
            $end_date = date_validate($end_date);
        } else {

            $time = strtotime(date('Y-m-d') . '-30 days');
            $start_date = date_validate(date('Y-m-d', $time));
            $end_date = date_validate(date('Y-m-d'));
        }



        $query  = Applicants::select(DB::raw("*,CONCAT(address,', ',city_name,', ',state_name,', ',zip_code) AS full_address"))
            ->where('is_active', 1)
            ->where('is_query_submited', 1)
            ->where('is_selected', 0)
            ->whereBetween('added_date', [$start_date . " 00:00:00", $end_date . " 23:59:59"])
            ->orderBy('added_date', 'DESC');

        return Datatables::of($query)
            ->filterColumn('full_address', function ($query, $keyword) {
                $query->whereRaw("concat_ws(' ', address, city_name,state_name,zip_code) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('select', function ($result) {

                return 'REG-ID-' . $result->id;
            })
            ->addColumn('status', function ($result) {
                if ($result->is_query_submited == 0) {
                    return '<div class="badge badge-pill badge-danger">Pending</div>';
                } else {
                    return '<div class="badge badge-pill badge-success">Submitted</div>';
                }
            })
            ->addColumn('action', function ($result) {

                $dt = "'delete'";

                return '<div role="group" class="btn-group-md btn-group text-white">
                <a href="/emp-hired/' . $result->id . '" class="btn-shadow btn btn-sm btn-success" title="Hire"><i class="fa fa-check-circle"></i></a>
                <a href="javascript:void(0);" onclick="get_modal_html(' . $result->id . ')"  data-toggle="modal" data-target=".bd-example-modal-lg"  class="btn-shadow btn btn-sm btn-warning" title="Query Answer"><i class="fa fa-question-circle"></i></a>
                <a href="/applicant-info/' . $result->id . '" class="btn-shadow btn btn-primary" title="View Info"><i class="fa fa-eye"></i></a>
                <a href="javascript:void(0);" onclick="ajaxApprove(' . $result->id . ',this,' . $dt . ')"  class="btn-shadow btn btn-danger" title="Applicant Remove"><i class="fa fa-trash"></i></a>
                </div>';
            })
            ->rawColumns(['select', 'status', 'action'])
            ->make(true);
    }

    public function hired_employee_data(Request $request)
    {

        $date = $request->get('columns')[7]['search']['value'];

        if ($date != '') {

            list($start_date, $end_date) = explode('~', preg_replace('/\s+/', '', $date));

            $start_date = date_validate($start_date);
            $end_date = date_validate($end_date);
        } else {

            $time = strtotime(date('Y-m-d') . '-30 days');
            $start_date = date_validate(date('Y-m-d', $time));
            $end_date = date_validate(date('Y-m-d'));
        }

        //DB::raw("*,CONCAT(address,', ',city_name,', ',state_name,', ',zip_code) AS full_address");
        $query  = EmployeInfo::select(
            'employee_info.Id',
            'employee_info.EmpCode',
            'employee_info.IDCardNumber',
            'employee_info.Email',
            'employee_info.FullName',
            'employee_info.PresentAddress',
            'employee_info.Phone',
            'employee_info.DateCreated',
            'employee_info.IsActive',

            )->join('user_master','user_master.EmpOrCustomerId','employee_info.Id')
            ->where('user_master.model_id',3)
            ->where('user_master.IsEmployee',1)
            ->whereBetween('employee_info.DateCreated', [$start_date . " 00:00:00", $end_date . " 23:59:59"])
            ->orderBy('employee_info.DateCreated', 'DESC');

        return Datatables::of($query)

            ->addColumn('status', function ($result) {
                if ($result->IsActive == 1) {
                    return '<div class="badge badge-pill badge-success">Active</div>';
                } else {
                    return '<div class="badge badge-pill badge-danger">Inactive</div>';
                }
            })
            ->addColumn('action', function ($result) {
                if ($result->IsActive != 1) {
                    $st_msg = ' <a  href="javascript:void(0);" onclick="ajaxStatus(' . $result->Id . ',this,1)" class="btn-shadow btn btn-success btn-sm title="Active"><i class="fa fa-check-circle mr-2"></i>Active</a>';
                } else {
                    $st_msg = ' <a  href="javascript:void(0);" onclick="ajaxStatus(' . $result->Id . ',this,0)" class="btn-shadow btn btn-danger btn-sm title="Inactive"><i class="fa fa-ban mr-2"></i>Inactive</a>';
                }

                return '<div role="group" class="btn-group-md btn-group text-white">
               ' . $st_msg . '
                <a href="/cleaner-info/' . $result->Id . '" class="btn-shadow btn btn-primary" title="View Info"><i class="fa fa-eye mr-2"></i>Info</a>
                </div>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function get_query_ans(Request $request)
    {

        $data = QueryAnswer::join('question_bank', 'question_bank.Id', 'applicant_question_answer.QestionId')
            ->select('applicant_question_answer.Answer', 'question_bank.Question', 'applicant_question_answer.ApplicantId')
            ->where('applicant_question_answer.ApplicantId', $request->id)
            ->get();

        return view('dashboard.applicants.modal_query_ans', compact('data'));
    }
    public function modal_send_mail(Request $request)
    {

        if (!empty($request->checkbox)) {

            try {
                foreach ($request->checkbox as $email) {

                    $token = md5(rand(1, 10) . microtime());
                    // Email===============
                    $sub = $request->subject; // "Confirmation | Preliminary Hiring Process";
                    $msg = "Dear Concern, <br> " . $request->message . "<br>
                        Congratulation ! You have been shortlisted at getacleaner hiring process
                        <br><br> You want to go forward then fill up final submission form. <strong><a href='http://" . $request->getHost() . "/query-form/{$token}'>Click here</a> </strong>
                        <br><br> For further queries email at: <br>jobs@getacleaner.ca
                        <br><br>
                        Regards, <br>
                        Team GetaCleaner<br>
                        www.getacleaner.ca";
                    //email traits=============

                    $isSuccess  = $this->send_raw_email($email, $sub, $msg);
                    if ($isSuccess == true) {
                        $applicants = Applicants::where('email', $email)->first();
                        $applicants->mail_token = $token;
                        $applicants->is_mail = 1;
                        $applicants->update();
                    }
                }
                return redirect("/applicants-shortlist")->with("flashMessageSuccess", "All Applicants Mail Send Successfully !");
            } catch (\Throwable $th) {
                return redirect("/applicants-shortlist")->with("flashMessageDanger", $th->getMessage());
            }
        } else {
            return redirect("/applicants-shortlist")->with("flashMessageDanger", "You Are Not Select Any Applicants To Send Mail !");
        }
    }

    public function employeHired($id)
    {

        try {
            $applicant = Applicants::findOrFail($id);

            DB::beginTransaction();

            $employeInfo = new EmployeInfo();

            $latest=$employeInfo->latest()->first();
            $rowCount = empty($latest)? '1': strval($latest->Id + 1);

            $employeInfo->EmpCode = "GAC-" . str_pad($rowCount, 4, '0', STR_PAD_LEFT);
            $employeInfo->IDCardNumber = "GAC-CLR-" . str_pad($rowCount, 4, '0', STR_PAD_LEFT);
            $employeInfo->FullName = $applicant->name;
            $employeInfo->PresentAddress = $applicant->address_line2 . ',' . $applicant->street_address . ',' . $applicant->city_name . ',' . $applicant->state_name . ',' . $applicant->zip_code;
            $employeInfo->Nationality = 'US';
            $employeInfo->Email = $applicant->email;
            $employeInfo->Phone = $applicant->phone;
            $employeInfo->CreatedBy = Auth::user()->EmpOrCustomerId;
            $employeInfo->IsActive = 1;
            $employeInfo->save();

            $userMaster = new User();

            $password =str_random(8);
            $userMaster->Email = $applicant->email;
            $userMaster->PasswordHash = bcrypt($password);
            $userMaster->UserName = $applicant->name;
            $userMaster->phone = $applicant->phone;
            $userMaster->IsEmployee =1;
            $userMaster->IsActive = 1;
            $userMaster->EmpOrCustomerId = $employeInfo->Id;
            $userMaster->model_id = 3; //cleaner

            $userMaster->save();

            $mangeRole = new UserRole();

            $mangeRole->UserId = $userMaster->Id;
            $mangeRole->RoleId = 3; //cleaner
            $mangeRole->IsActive = 1;
            $mangeRole->save();

            $applicant->is_selected = 1;
            $applicant->save();

            DB::commit();

            $this->send_raw_email_with_attachment($applicant->email,$password);

            return redirect('hired-employes-list')->with("flashMessageSuccess", "Mr/Mrs " . $applicant->name . " Created As A Cleaner Employee.");
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->withErrors("flashMessageDanger", $th->getMessage());
        }
    }

    public function query_submit_store(Request $request)
    {

        $application = Applicants::where('mail_token', $request->mail_token)->first();

        if (isset($application->id) && $application->is_query_submited != 1 && !empty($request->question_array_id)) {

            DB::beginTransaction();

            try {

                foreach ($request->question_array_id as $key => $question_id) {

                    QueryAnswer::create([
                        'QestionId' => $question_id,
                        'Answer' => !empty($request->query_ans[$key]) ? $request->query_ans[$key] : "",
                        'ApplicantId' => $application->id,
                        'IsActive' => 1,
                        'Status' => !empty($request->query_ans[$key]) ? 1 : 0,
                    ]);
                }

                Applicants::where('id', $application->id)->update(["is_query_submited" => 1]);

                DB::commit();

                $sub = "Interview Application";
                $msg = "Dear Concern, <br>
                    Your Interview question apllication successfully submitted to getacleaner team.If You are selelected you get a another mail for confirmation.So,Look up your mail to final selection.
                    <br><br> For further queries email at: <br>jobs@getacleaner.ca
                    <br><br>
                    Regards, <br>
                    Team GetaCleaner<br>
                    www.getacleaner.ca";

                //using SMTP Mail

                //$this->send_raw_email($application->email, $sub, $msg);

                return redirect("/query-form")->with("flashMessageSuccess", "Application Summitted Successfully.Check Your Mail Further Information !");
            } catch (\Throwable $th) {
                DB::rollback();
                return redirect("/query-form")->with("flashMessageDanger", $th->getMessage());
            }
        } else {
            return redirect("/query-form")->with("flashMessageDanger", 'Appliction Link Expired Or Already Submitted');
        }
    }
    public function add_cleaner_view()
    {

        return view('dashboard.applicants.addcleaner');
    }
    public function cleanerStore(Request $request)
    {

        $validator = \Validator::make($request->all(), [

            'Email' => 'required|email|unique:employee_info',
            'name' => 'required',
            'phone' => 'required',
            'present_address' => 'required'
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:500',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator->errors());

        }else {

            try {

                DB::beginTransaction();

                if($request->hasFile('image')){

                    $image = $request->file('image');

                    $name = time().'.'.$image->getClientOriginalExtension();

                    $destination_path = public_path('/assets/images/avatars/cleaner/');

                    $image_path='/assets/images/avatars/cleaner/'.$name;

                 }else{
                    $image_path='';
                 }

                $employeInfo = new EmployeInfo();

                $latest=$employeInfo->latest()->first();
                $rowCount = empty($latest)? '1': strval($latest->Id + 1);

                $employeInfo->EmpCode = "GAC-" . str_pad($rowCount, 4, '0', STR_PAD_LEFT);
                $employeInfo->IDCardNumber = "GAC-CLR-" . str_pad($rowCount, 4, '0', STR_PAD_LEFT);
                $employeInfo->FullName = $request->name;
                $employeInfo->FatherName = $request->father;
                $employeInfo->MotherName = $request->mother;
                $employeInfo->PresentAddress = $request->present_address;
                $employeInfo->PermanentAddress = $request->permanent_address;
                $employeInfo->Nationality = 'US';
                $employeInfo->Email = $request->Email;
                $employeInfo->Phone =$request->phone;
                $employeInfo->MaritalStatus =$request->marital_status;
                $employeInfo->DOB = date_validate($request->dob);
                $employeInfo->PassportNumber =$request->doc_no;
                $employeInfo->ImageUrl =$image_path;
                $employeInfo->CreatedBy = Auth::user()->EmpOrCustomerId;
                $employeInfo->IsActive = 1;


                $employeInfo->save();

                $userMaster = new User();

                $password =str_random(8);
                $userMaster->Email = $request->Email;
                $userMaster->PasswordHash = bcrypt($password);
                $userMaster->RawPassword = $password;
                $userMaster->UserName = $request->name;
                $userMaster->phone = $request->phone;
                $userMaster->ImageUrl =   $image_path;
                $userMaster->IsEmployee=1;
                $userMaster->IsActive = 1;
                $userMaster->EmpOrCustomerId = $employeInfo->Id;
                $userMaster->model_id = 3; //cleaner

                $userMaster->save();

                $mangeRole = new UserRole();

                $mangeRole->UserId = $userMaster->Id;
                $mangeRole->RoleId = 3; //decrypt($request->useRole); 3 //cleaner
                $mangeRole->IsActive = 1;
                $mangeRole->save();


                DB::commit();

                if($request->hasFile('image')){
                    $image->move($destination_path, $name);
                }

                $this->send_raw_email_with_attachment($request->Email,$password);


                return redirect('/hired-employes-list')->with("flashMessageSuccess","Your Employee info Stored Succesfully");

            } catch (\Throwable $th) {
                DB::rollback();

                return redirect()->back()->withErrors("flashMessageDanger", $th->getMessage());
            }
        }
    }
    public function applicant_info($id)
    {

        $cleaner = Applicants::where('id', $id)->first();

        return view('dashboard.applicants.applicant_info', compact('cleaner'));
    }
    public function EmployeInfo($id)
    {

        $employeInfo = EmployeInfo::where('Id', $id)->first();

        return view('dashboard.applicants.employee_info', compact('employeInfo'));
    }
}
