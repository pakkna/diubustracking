<?php

namespace App\Http\Controllers\BackendControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use DB;
use Auth;
use App\Services\Expense\ExpenseService;

class ExpenseController extends Controller
{
    
    protected $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }
    
    public function expense_category_list(Request $request)
    {
        $data['expenseCategoryList'] = $this->expenseService->getExpenseCategoryList();
        $data['paymentTypeList'] = $this->expenseService->getAllPaymentType();
        return view('expense.allexpensecategorylist', $data);
    }

    public function expense_list_view(Request $request)
    {
        $data['expenseCategoryList'] = $this->expenseService->getExpenseCategoryList();
        $data['paymentTypeList'] = $this->expenseService->getAllPaymentType();
        return view('expense.allexpenselist', $data);
    }
    
    public function save_expense_details(Request $request)
    {
        $post_data['input'] = $request->input();
        $post_data['file'] = $_FILES;
        $result = $this->expenseService->save_expense_details($post_data);
        return $result;
    }

    public function expense_action(Request $request)
    {                
        $post_data['input'] = $request->input();
        $result = $this->expenseService->expense_action($post_data);
        return $result;
    }

    public function expense_head_action(Request $request)
    {        
        $post_data['input'] = $request->input();
        $result = $this->expenseService->expense_head_action($post_data);
        return $result;
    }

    public function save_expense_head_details(Request $request)
    {        
        $post_data['input'] = $request->input();
        $result = $this->expenseService->save_expense_head_details($post_data);
        return $result;
    }

    public function all_expense_list(Request $request)
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

        $getAllExpenseList = $this->expenseService->getAllExpenseList($start_date, $end_date);        

        return Datatables::of($getAllExpenseList)
            ->addColumn('download', function ($result) {
                if($result->FileUrl != '' && $result->FileName != ''){
                    return '<a href="'.$result->FileUrl.'/'.$result->FileName.'" download class="" title="" style="text-decoration: none;"><b><i class="fa fa-download"></i> Download</b></a>';
                } else {
                    return '';
                }
            })
            ->addColumn('action', function ($result) {                
                $dt = "'delete'";
                return '<div role="group" class="btn-group-md btn-group text-white">
                            <a href="javascript:void(0);" onclick="ajaxApprove(' . $result->expense_id . ',this,' . $dt . ')"  class="btn-shadow btn btn-danger" title="Applicant Remove"><i class="fa fa-trash"></i></a>
                        </div>';                
            })
            ->rawColumns(['download','action'])
            ->make(true);
    }

    public function all_expense_head_list(Request $request)
    {
        $date = $request->get('columns')[2]['search']['value'];
        if ($date != '') {
            list($start_date, $end_date) = explode('~', preg_replace('/\s+/', '', $date));
            $start_date = date_validate($start_date);
            $end_date = date_validate($end_date);
        } else {
            $time = strtotime(date('Y-m-d') . '-30 days');
            $start_date = date_validate(date('Y-m-d', $time));
            $end_date = date_validate(date('Y-m-d'));
        }

        $getAllExpenseHeadList = $this->expenseService->getAllExpenseHeadList($start_date, $end_date);
        return Datatables::of($getAllExpenseHeadList)            
            ->addColumn('action', function ($result) {                
                $dt = "'delete'";
                return '<div role="group" class="btn-group-md btn-group text-white">
                            <a href="javascript:void(0);" onclick="ajaxApprove(' . $result->category_id . ',this,' . $dt . ')"  class="btn-shadow btn btn-danger" title="Applicant Remove"><i class="fa fa-trash"></i></a>
                        </div>';                
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    
    
}
