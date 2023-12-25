<?php

namespace App\Http\Controllers\BackendControllers;

use Auth;
use App\Traits\Email;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CustomerInfo;
use App\Models\EmployeInfo;
use App\Models\InvoiceDetail;
use App\Models\InvoiceMaster;
use App\Models\OrderDetail;
use App\Models\OrderMaster;
use App\Models\OrderSheduleInfo;
use App\Models\TaskDetail;
use App\Models\TaskInfo;
use App\Models\TaskLogDetail;
use App\Models\User;
use Illuminate\Support\Carbon;

class EstimationController extends Controller
{
    use Email;

    public function pending_estimation_view()
    {
        return view('dashboard.estimation.pending_estimation');
    }

    public function pending_estimation_data(Request $request, $mode = null)
    {

        if($request->has('CustomerId')){

            $query  = OrderMaster::where('CustomerId', $request->CustomerId)
            ->where('CompanyId', 1)
            ->orderBy('DateCreated', 'DESC');

            if ($mode == "api")
            {
                return $query->get();
            }

        }else{

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

            $query  = OrderMaster::
            // whereBetween('DateCreated', [$start_date . " 00:00:00", $end_date . " 23:59:59"])
             where('IsActive', 1)
            ->where('CompanyId', 1)
            ->orderBy('DateCreated', 'DESC');

        }


        return Datatables::of($query)

            ->addColumn('UserName', function ($result) {

                return CustomerInfo::where('Id', $result->CustomerId)->first()->CustomerName;
            })
            ->addColumn('TotalShedule', function ($result) {
                  return '<div class="badge badge-pill badge-secondary">' .$this->OrderSheduleCount($result->Id). ' </div>';
            })
            ->addColumn('Phone', function ($result) {

                return CustomerInfo::where('Id', $result->CustomerId)->first()->Mobile;
            })
            // ->addColumn('Status', function ($result) {

            //     if($result->Status=="Pending"){
            //         return '<div class="badge badge-pill badge-danger">' . $result->Status . '</div>';
            //     }else if($result->Status=="Completed"){
            //         return '<div class="badge badge-pill badge-success">' . $result->Status . '</div>';
            //     }else{
            //         return '<div class="badge badge-pill badge-primary">' . $result->Status . '</div>';
            //     }

            // })
            ->addColumn('action', function ($result) {
                $dt = "'delete'";

                return '<div role="group" class="btn-group-md btn-group text-white">
                <a href="javascript:void(0);" onclick="get_shedule_html(' . $result->Id . ')"  data-toggle="modal" data-target=".bd-example-modal-lg"  class="btn-shadow btn btn-sm btn-primary" title="Shedules Details"><i class="fa fa-eye"></i></a>
                <a href="javascript:void(0);" onclick="get_item_detsils_html(' . $result->Id . ')"  data-toggle="modal" data-target=".bd-example-modal-lg"  class="btn-shadow btn btn-sm btn-warning" title="Estimate Items"><i class="fa fa-tasks"></i></a>
                </div>';

                //<a href="javascript:void(0);" onclick="ajaxApprove(' . $result->Id . ',this,' . $dt . ')"  class="btn-shadow btn btn-danger" title="Applicant Remove"><i class="fa fa-trash"></i></a>
            })
            ->rawColumns(['UserName','TotalShedule', 'Phone', 'action'])
            ->make(true);
    }

    public  function OrderSheduleCount($OrderId)
    {
       return OrderSheduleInfo::where('OrderMasterId', $OrderId)
        ->where('IsActive', 1)
        ->where('CompanyId', 1)
        ->get()->count();
    }
    public function orderItemList(Request $request)
    {

        $data = OrderDetail::select(
                         'order_detail.Quantity',
                         'order_detail.ItemDetailId',
                         'order_detail.UniteRate',
                         'order_detail.TotalRate',
                         'order_detail.Discount',
                         'order_detail.Status',
                         'item_master.ItemName',
                         Db::raw("(select it.ItemDetailTitle from item_detail it where it.Id=order_detail.ItemDetailId) as ItemDetailTitle")
                      )
                      ->join('item_master' ,'item_master.Id','order_detail.ItemId')
                      ->where('order_detail.OrderMasterId', $request->id)
                      ->where('order_detail.IsActive',1)
                      ->get();


        return view('dashboard.estimation.orderItemList', compact('data'));
    }
    public function orderSheduleList(Request $request)
    {

        $data = OrderSheduleInfo::select(
                         'order_master.Id AS OrderId',
                         'order_master.OrderNumber',
                         'order_master.CustomerId',
                         'order_schedule_info.Id',
                         'order_schedule_info.ScheduleStatus',
                         'order_schedule_info.ScheduleDate',
                         'order_schedule_info.ScheduleTime',
                      )
                      ->join('order_master' ,'order_master.Id','order_schedule_info.OrderMasterId')
                      ->where('order_schedule_info.OrderMasterId', $request->id)
                      ->where('order_schedule_info.IsActive',1)
                      ->where('order_schedule_info.CompanyId',1)
                      ->get();

        return view('dashboard.estimation.orderSheduleList', compact('data'));
    }
    public function getCleanerListView($OrderId,$OrderNumber,$SheduleId,$ScheduleDate,$ScheduleTime,$CustomerId){

        return view('dashboard.estimation.cleaner_list',compact('OrderId','OrderNumber','SheduleId','ScheduleDate','ScheduleTime','CustomerId'));
    }
    public function getCleanerListData (Request $request){


        $query  = EmployeInfo::select(
            'employee_info.Id',
            'employee_info.EmpCode',
            'employee_info.IDCardNumber',
            'employee_info.Email',
            'employee_info.FullName',
            'employee_info.Phone',
            'user_master.IsActive',

            )->join('user_master','user_master.EmpOrCustomerId','employee_info.Id')
            //->join('task_information','user_master.EmpOrCustomerId','employee_info.Id')
            ->where('user_master.model_id',3)
            ->where('user_master.IsActive',1)
            ->where('user_master.IsEmployee',1);
            //->whereBetween('employee_info.DateCreated', [$start_date . " 00:00:00", $end_date . " 23:59:59"])
        return Datatables::of($query)

            ->addColumn('select', function ($result) {

                return '<div class="custom-checkbox custom-control">
                    <input type="checkbox" name="cleaner_array[]" value="' . $result->Id . '" id="SelectCheckbox' . $result->Id . '" class="custom-control-input ">
                    <label class="custom-control-label" for="SelectCheckbox' . $result->Id . '"> ' . $result->EmpCode . '</label>
                   </div>';
            })
            ->rawColumns(['select'])
            ->make(true);

    }
    public function taskAssignToCleaner(Request $request){


        if(!empty($request->cleaner_array)){

            try {
                DB::beginTransaction();
             $taskInfo= new TaskInfo();

             $orderMasterInfo=OrderMaster::where('Id',$request->OrderId)->first();

             $latest=$taskInfo->latest()->first();
             $rowCount = empty($latest)? '1': strval($latest->Id + 1);

             $taskInfo->TasKNumber= "TSK-".date('Y').'-'. str_pad($rowCount, 4, '0', STR_PAD_LEFT);
             $taskInfo->OrderId=$request->OrderId;
             $taskInfo->CustomerId=$request->CustomerId;
             $taskInfo->TaskStatus='Pending';
             $taskInfo->TotalAssignedHour=$orderMasterInfo->TotalHour;
             $taskInfo->TaskDate=$request->TaskDate;
             $taskInfo->ServiceTypeName=$orderMasterInfo->ServiceTypeName;
             $taskInfo->IsCompleted=0;
             $taskInfo->CreatedBy=Auth::user()->EmpOrCustomerId;
             $taskInfo->IsActive=1; //Default 1;
             $taskInfo->save();


              foreach ($request->cleaner_array as $key => $cleanerId) {

                TaskDetail::create([
                    'TaskMasterId' => $taskInfo->Id,
                    'EmployeeId' =>$request->cleaner_array[$key],
                    'DateAssigned' => $request->TaskDate,
                    'TimeAssigned' => $request->TaskTime,
                    'TaskStatus' => "Pending",
                    'CreatedBy' => Auth::user()->EmpOrCustomerId,
                    'IsActive' => 1,
                    'IsAccepted' => 0,
                  ]);

                 // $this->AssingTaskSummerySend($request->cleaner_array[$key],$taskInfo->Id,$request->TaskDate,$request->TaskTime);
                }

             OrderMaster::where('Id',$request->OrderId)->update(['Status'=> 'Assigned']);
             OrderSheduleInfo::where('Id',$request->SheduleId)->update(['ScheduleStatus'=> 'Assigned']);

             DB::commit();
             return redirect("/assign-tasks-view")->with("flashMessageSuccess", "Estimation Assigned To Cleaner Successfully !");

            } catch (\Throwable $th) {
                DB::rollback();
                return redirect("/pending-estimation-list")->with("flashMessageDanger", $th->getMessage());
            }


        }else{
            return redirect()->back()->with("flashMessageDanger", "You Are Not Selected Any Cleaner !");
        }

    }

    public function AssignTaskListView(){

        return view('dashboard.estimation.assign_task_list');

    }
    public function AssignTaskData(Request $request){

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

        $query  = TaskInfo::where('IsActive', 1)
        ->where('IsCompleted', 0)
        // ->whereBetween('DateCreated', [$start_date . " 00:00:00", $end_date . " 23:59:59"])
        ->orderBy('DateCreated', 'DESC');


     return Datatables::of($query)

        ->addColumn('OrderNumber', function ($result) {

            return OrderMaster::where('Id', $result->OrderId)->first()->OrderNumber;
        })
        ->addColumn('Status', function ($result) {

            return '<div class="badge badge-pill badge-info">' . $result->TaskStatus . '</div>';
        })
        ->addColumn('CustomerName', function ($result) {

            return CustomerInfo::where('Id', $result->CustomerId)->first()->CustomerName;
        })
        ->addColumn('action', function ($result) {
            $dt = "'task-delete'";
            $ct = "'task-complete'";

            return '<div role="group" class="btn-group-md btn-group text-white">
            <a href="javascript:void(0);" onclick="ajaxAction(' . $result->Id . ',this,' . $ct . ')"  class="btn-shadow btn btn-success" title="Task Complete"><i class="fa fa-check-circle"></i></a>
            <a href="javascript:void(0);" id="cleaner_assign_table" onclick="get_assign_cleaner_html(' . $result->Id . ')"  data-toggle="modal" data-target=".bd-example-modal-lg"  class="btn-shadow btn btn-sm btn-warning" title="Assign Cleaners"><i class="fa fa-users"></i></a>
            <a href="javascript:void(0);" onclick="ajaxAction(' . $result->Id . ',this,' . $dt . ')"  class="btn-shadow btn btn-danger" title="Task Remove"><i class="fa fa-trash"></i></a>
            </div>';
        })
        ->rawColumns(['OrderNumber', 'CustomerName', 'Status', 'action'])
        ->make(true);

    }
    public function CompleteTaskListView(){

        return view('dashboard.estimation.completed_tasks');

    }
    public function CompleteTasks(Request $request){

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

        $query  = TaskInfo::where('IsActive', 1)
        // ->whereBetween('DateCreated', [$start_date . " 00:00:00", $end_date . " 23:59:59"])
        ->where('IsCompleted', 1)
        ->orderBy('DateCreated', 'DESC');

        if($request->has('CustomerId')){
            $query->where('CustomerId',$request->CustomerId);
        }

     return Datatables::of($query)

        ->addColumn('OrderNumber', function ($result) {

            return OrderMaster::where('Id', $result->OrderId)->first()->OrderNumber;
        })
        ->addColumn('Status', function ($result) {

            return '<div class="badge badge-pill badge-success p-2">' . $result->TaskStatus . '</div>';
        })
        ->addColumn('CustomerName', function ($result) {

            return CustomerInfo::where('Id', $result->CustomerId)->first()->CustomerName;
        })
        ->addColumn('action', function ($result) {

            return '<div role="group" class="btn-group-md btn-group text-white">
            <a href="javascript:void(0);" id="cleaner_assign_table" onclick="get_assign_cleaner_html(' . $result->Id . ')"  data-toggle="modal" data-target=".bd-example-modal-lg"  class="btn-shadow btn btn-sm btn-primary" title="Estimate Items"><i class="fa fa-users"></i></a>
            <a href="javascript:void(0);" onclick="get_item_detsils_html(' . $result->OrderId . ')"  data-toggle="modal" data-target=".bd-example-modal-lg"  class="btn-shadow btn btn-sm btn-warning" title="Estimate Items"><i class="fa fa-tasks"></i></a>
            </div>';
        })
        ->rawColumns(['OrderNumber','CustomerName', 'Status', 'action'])
        ->make(true);

    }
    public function AssignedCleaneresList(Request $request){

        $data = TaskDetail::where('TaskMasterId', $request->TaskId)->where('IsActive',1)->get();

         return view('dashboard.estimation.assigned_cleaners', compact('data'));
    }
    public function pending_estimation_delete(Request $request){

        try {

            OrderMaster::where('Id',$request->id)->update(['IsActive',0]);
            OrderDetail::where('OrderMasterId',$request->id)->update(['IsActive',0]);
            OrderSheduleInfo::where('OrderMasterId',$request->id)->update(['IsActive',0]);

            echo json_encode(['status'=>true,'msg' => 'Success']);

        } catch (\Throwable $th) {

            echo json_encode(['status'=>false,'msg' => "Estimation Delete Faild"]);
        }
    }
    public function TaskInfoAjaxAction(Request $request){


        if($request->action=='task-delete'){
            TaskInfo::where('Id',$request->id)->update(['IsActive'=>0]);
            TaskDetail::where('TaskMasterId',$request->id)->update(['IsActive'=>0]);
            OrderSheduleInfo::where('Id',$request->SheduleId)->update(['ScheduleStatus'=> 'Pending']);
            echo 1;
        }else if($request->action=='task-complete'){

            $result=$this->taskComplete($request->id);
            echo $result;

        }else if($request->action=='cleaner-delete'){
            TaskDetail::where('Id',$request->id)->update(['IsActive'=> 0]);
            echo 3;
        }else{
            echo 0;
        }

    }
    public function taskComplete($id, $apiExtension = []){

        DB::beginTransaction();

        $taskInfo= TaskInfo::findOrFail($id);

        $orderMaster= OrderMaster::findOrFail($taskInfo->OrderId);
         $orderMaster->Status= 'Processing';
         $orderMaster->IsInvoiced=1;
         $orderMaster->PaymentSatus=0;
         $orderMaster->ServiceStatus='Task Completed';
         $orderMaster->TaskComplete+=1;
         if($this->OrderSheduleCount($taskInfo->OrderId)==($orderMaster->TaskComplete+1)){
            $orderMaster->Status="Completed";
         }

        $orderMaster->update();

        OrderSheduleInfo::where('ScheduleDate',$taskInfo->TaskDate)
                       ->where('OrderMasterId',$taskInfo->OrderId)
                      ->update(['ScheduleStatus'=>'Completed','ServiceStatus'=>'Task Completed','IsInvoiced'=>1,'PaymentSatus'=>0]);

        $taskInfo->TaskStatus='Completed';
        $taskInfo->TotalCompletedHour = !empty($apiExtension) && array_key_exists('completed_hour',$apiExtension) ? $apiExtension['completed_hour'] : $taskInfo->TotalAssignedHour;
        $taskInfo->CompletedTime=date('Y-m-d h:m:s');
        $taskInfo->CompleteDate=date('Y-m-d');
        $taskInfo->IsCompleted=1;
        $taskInfo->Remarks='Admin Action';
        $taskInfo->update();

        $TaskDetail=TaskDetail::where('TaskMasterId',$id)->get();

        foreach($TaskDetail as $TaskDetailOne){

            $TaskDetailOne->update(['TaskStatus'=>'Completed',
            'IsAccepted'=>1,
            'FinishTime'=>date('Y-m-d h:m:s'),
            'FinishDate'=>date('Y-m-d'),
            'ModifiedBy'=>!empty($apiExtension) && array_key_exists('created_by',$apiExtension) ? $apiExtension['created_by'] : Auth::user()->EmpOrCustomerId]);

            TaskLogDetail::create([
                'TaskMasterId'=>$id,
                'TaskDetailId'=>$TaskDetailOne->Id,
                'EmployeeId'=>$TaskDetailOne->EmployeeId,
                'DateActivityLog'=>date('Y-m-d'),
                'TimeActivityLog'=>date('Y-m-d h:m:s'),
                'TaskStatus'=>'Completed',
                'CreatedBy'=>!empty($apiExtension) && array_key_exists('created_by',$apiExtension) ? $apiExtension['created_by'] : Auth::user()->EmpOrCustomerId,
                'IsActive'=>1
               ]);
            }


        $InvoiceMaster = new InvoiceMaster();

        $latest=$InvoiceMaster->latest()->first();
        $rowCount = empty($latest)? '1': strval($latest->Id + 1);

        $InvoiceMaster->OrderId=$orderMaster->Id;
        $InvoiceMaster->TaskId=$id;
        $InvoiceMaster->InvoiceNumber="INV-".date('Y').'-'. str_pad($rowCount, 4, '0', STR_PAD_LEFT);
        $InvoiceMaster->InvDate=date('Y-m-d');
        $InvoiceMaster->TotalHour=$orderMaster->TotalHour;
        $InvoiceMaster->TotalItem=$orderMaster->TotalItem;
        $InvoiceMaster->TotalDiscount=$orderMaster->TotalDiscount;
        $InvoiceMaster->TotalRate=round($orderMaster->TotalRate,2);
        $InvoiceMaster->GrossRate=round($orderMaster->GrossRate,2);
        $InvoiceMaster->TotalVAT=round($orderMaster->TotalVAT,2);
        $InvoiceMaster->CustomerId=$orderMaster->CustomerId;
        $InvoiceMaster->Status="UnPaid";
        $InvoiceMaster->ServiceStatus="Task Completed";
        $InvoiceMaster->PaymentSatus=0;
        $InvoiceMaster->IsInvoiced=1;
        $InvoiceMaster->CreatedBy= !empty($apiExtension) && array_key_exists('created_by',$apiExtension) ? $apiExtension['created_by'] : Auth::user()->EmpOrCustomerId;
        $InvoiceMaster->IsActive =1;

        $InvoiceMaster->save();

        $orderDetails= OrderDetail::where('OrderMasterId',$orderMaster->Id)->get();

        foreach($orderDetails as $Item){
            InvoiceDetail::create([
                'InvMasterId'=>$InvoiceMaster->Id,
                'ItemId'=>$Item->ItemId,
                'ItemDetailId'=>$Item->ItemDetailId,
                'Quantity'=>$Item->Quantity,
                'UniteRate'=>$Item->UniteRate,
                'TotalRate'=>$Item->TotalRate,
                'Discount'=>$Item->Discount,
                'Discount'=>$Item->Discount,
                'Status'=>'Complete',
                'IsActive'=>1,

            ]);
        }

        DB::commit();

         $this->SendTaskCompleteInvoice($taskInfo,$InvoiceMaster,$orderMaster->CustomerId); //TaskInfo, CustomerId

        return !empty($apiExtension) ? $InvoiceMaster->Id : 2;

    }

}
