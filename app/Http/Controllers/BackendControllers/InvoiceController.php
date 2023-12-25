<?php

namespace App\Http\Controllers\BackendControllers;

use Auth;
use App\Traits\Email;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CustomerInfo;
use App\Models\InvoiceMaster;
use App\Models\OrderMaster;
use App\Models\OrderSheduleInfo;
use App\Models\TaskInfo;
use App\Models\User;

class InvoiceController extends Controller
{

    public function PendingInvoiceView(){
        return view('dashboard.invoices.pending_invoice');
    }

    public function PendingInvoiceData(Request $request){

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

        $query  = InvoiceMaster::
        // whereBetween('DateCreated', [$start_date . " 00:00:00", $end_date . " 23:59:59"])
        where('IsActive', 1)
        ->orderBy('DateCreated', 'DESC');


        return Datatables::of($query)

        ->addColumn('OrderNumber', function ($result) {

            return OrderMaster::where('Id', $result->OrderId)->first()->OrderNumber;
        })
        ->addColumn('TaskNumber', function ($result) {

            return TaskInfo::where('Id', $result->TaskId)->first()->TasKNumber;
        })
        ->addColumn('UserName', function ($result) {

            return CustomerInfo::where('Id', $result->CustomerId)->first()->CustomerName;
        })
        ->addColumn('Phone', function ($result) {

            return CustomerInfo::where('Id', $result->CustomerId)->first()->Mobile;
        })
        ->addColumn('Status', function ($result) {

            if($result->PaymentSatus==0){
                return '<div class="badge badge-pill badge-danger">' . $result->Status . '</div>';
            }else{
                return '<div class="badge badge-pill badge-success">' . $result->Status . '</div>';
            }
        })
        ->addColumn('action', function ($result) {

            $dt = "'delete'";

            $html = '<div role="group" class="btn-group-md btn-group text-white">
            <a href="javascript:void(0);" id="cleaner_assign_table" onclick="get_assign_cleaner_html(' . $result->TaskId . ')"  data-toggle="modal" data-target=".bd-example-modal-lg"  class="btn-shadow btn btn-sm btn-primary" title="Assign Cleaners"><i class="fa fa-users"></i></a>
            <a href="javascript:void(0);" onclick="get_item_detsils_html(' . $result->OrderId . ')"  data-toggle="modal" data-target=".bd-example-modal-lg"  class="btn-shadow btn btn-sm btn-success" title="Estimate Items"><i class="fa fa-list"></i></a>
            <a href="javascript:void(0);" onclick="get_user_payment_log_html(' . $result->Id . ')"  data-toggle="modal" data-target=".bd-example-modal-lg"  class="btn-shadow btn btn-sm btn-warning" title="payment log"><i class="fas fa-info"></i></a>
            ';

            if($result->PaymentSatus == 0){
                $html .='<a href="javascript:void(0);" onclick="card_payment(' . $result->Id . ')" class="btn-shadow btn btn-sm btn-danger" title="paymnet"><i class="fas fa-credit-card"></i></a>';
            }
            $html .='</div>';

            return $html;

            //<a href="javascript:void(0);" onclick="ajaxApprove(' . $result->Id . ',this,' . $dt . ')"  class="btn-shadow btn btn-danger" title="Applicant Remove"><i class="fa fa-trash"></i></a>
        })

        ->rawColumns(['OrderNumber','TaskNumber','UserName','Phone','Status','action'])
        ->make(true);
    }

    public function UserPaymentLogView(Request $request){

        $PaymentLog =DB::table('payment_transaction_log')
         ->where('invoice_id',$request->InvoiceId)
         ->get();

        return view('dashboard.payment.payment_log', compact('PaymentLog'));

    }

}
