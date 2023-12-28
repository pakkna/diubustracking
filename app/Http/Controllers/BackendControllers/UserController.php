<?php

namespace App\Http\Controllers\BackendControllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function registered_app_users()
    {
        return view('dashboard..app_users.registered_app_users');
    }

    public function app_users_data(Request $request)
    {
        $date = $request->get('columns')[5]['search']['value'];

        if ($date != '') {

            list($start_date, $end_date) = explode('~', preg_replace('/\s+/', '', $date));

            $start_date = date_validate($start_date);
            $end_date = date_validate($end_date);
        } else {

            $time = strtotime(date('Y-m-d') . '-30 days');
            $start_date = date_validate(date('Y-m-d', $time));
            $end_date = date_validate(date('Y-m-d'));
        }

        $query  = User::whereBetween('created_at', [$start_date . " 00:00:00", $end_date . " 23:59:59"])->where('usertype', 'User')->get();


        return Datatables::of($query)

            ->addColumn('is_active', function ($result) {

                if ($result->is_active == "Active") {
                    return '<div class="badge badge-pill badge-success">' . $result->is_active . '</div>';
                } else {
                    return '<div class="badge badge-pill badge-danger">' . $result->is_active . '</div>';
                }
            })
            ->addColumn('action', function ($result) {
                $dt = "'delete'";
                return '<div role="group" class="btn-group-md btn-group text-white">
                <a href="javascript:void(0)" onclick="ajaxStatus(' . $result->id . ',this,' . $dt . ')" class="btn-shadow btn btn-danger" title="Bus Remove"><i class="fa fa-trash"></i></a>
                </div>';
                /*  <a href="/route-update/' . $result->id . '"  class="btn-shadow btn btn-warning mr-3" title="Route Update"><i class="fa fa-edit"></i></a> */
            })
            ->rawColumns(['action', 'is_active'])
            ->addIndexColumn()
            ->make(true);
    }

    public function app_users_delete(Request $request)
    {
        $user = User::find($request->id);
        if ($user->delete()) {
            echo json_encode(['msg' => 'Success', 'type' => 'delete', 'action' => '1']);
        } else {
            echo json_encode(['msg' => 'Error', 'type' => 'delete', 'action' => '0']);
        }
    }
}
