<?php

namespace App\Http\Controllers\BackendControllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
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

    public function show()
    {
        return view('dashboard.app_users.admin_profile');
    }
    public function edit(Request $request)
    {


        $data = DB::table('users')->select('profile_photo', 'password')->where('id', $request->id)->first();

        if (!empty($request->image)) {

            $image = $request->file('image');

            $input['image_name'] = time() . '.' . $image->getClientOriginalExtension();

            $destination_path = public_path('/assets/images/avatars');

            $image->move($destination_path, $input['image_name']);
        } else {
            $input['image_name'] = $data->profile_photo;
        }

        if (!empty($request->password)) {
            $pass = Hash::make($request->password);
        } else {
            $pass = $data->password;
        }


        $data = [

            "name" => $request->name,

            "email" => $request->email,

            "username" => $request->email,

            "profile_photo" => $input['image_name'],

            "mobile" => $request->mobile,

            "password" => $pass,

            "updated_at" => date('Y-m-d H:i:s')

        ];


        try {

            DB::table('users')->where('id', $request->id)->update($data);
            return redirect("edit-profile")->with("flashMessageSuccess", "Profile Changed Successfully");
        } catch (\Illuminate\Database\QueryException $e) {

            $errorCode = $e->errorInfo[1];
            if ($errorCode == '1062') {
                return redirect("edit-profile")->with("flashMessageDanger", "User Name Already Exists ! Try Another One.");
            }
        }
    }
}
