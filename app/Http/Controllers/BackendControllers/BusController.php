<?php

namespace App\Http\Controllers\BackendControllers;

use DB;
use App\Models\Bus;
use App\Models\User;
use App\Models\Driver;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;


class BusController extends Controller
{
    public function bus_registration_view()
    {

        return view('dashboard.bus.addbus');
    }
    public function busStore(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'bus_name' => 'required|max:255',
            'bus_number' => 'required|unique:bus_list,bus_number',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        } else {

            try {
                $BusSave = Bus::create($request->all());
                return redirect()->back()->with("flashMessageSuccess", "Your Bus info Stored Succesfully");
            } catch (\Throwable $th) {
                //DB::rollback();

                return redirect()->back()->withErrors("flashMessageDanger", $th->getMessage());
            }
        }
    }
    public function busList(Request $request)
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

        $query  = Bus::orderBy('created_at', 'DESC');


        return Datatables::of($query)

            ->addColumn('bus_id', function ($result) {
                return "Bus-" . $result->id;
            })
            ->addColumn('is_active', function ($result) {

                if ($result->is_active == "Active") {
                    return '<div class="badge badge-pill badge-success">' . $result->is_active . '</div>';
                } else {
                    return '<div class="badge badge-pill badge-danger">' . $result->is_active . '</div>';
                }
            })
            ->addColumn('action', function ($result) {

                $statusShow = $result->is_active == "Active" ? '<i class="fa fa-ban mr-2"></i>InActive' : '<i class="fa fa-check-circle mr-2"></i>Active';
                $class = $result->is_active == "Active" ? "btn-warning" : "btn-success";


                return '<div role="group" class="btn-group-md btn-group text-white">
                <a href="/bus-status/' . $result->is_active . '/' . $result->id . '"  class="btn-shadow btn ' . $class . ' mr-3" title="Change Status">' . $statusShow . '</a>
                <a href="/bus-delete/' . $result->id . '" class="btn-shadow btn btn-danger" title="Bus Remove"><i class="fa fa-trash"></i></a>
                </div>';
            })
            ->rawColumns(['action', 'is_active'])
            ->make(true);
    }
    public function busStatusChange($status = null, $id = null)
    {;
        $status = ($status == "Active") ? "InActive" : "Active";
        $bus = Bus::find($id);
        $bus->is_active = $status;
        if ($bus->update()) {
            return redirect()->back()->with("flashMessageSuccess", "Your Bus Status Updated Succesfully");
        } else {
            return redirect()->back()->with("flashMessageDanger", "Your Bus Status Updated Faild");
        }
    }
    public function busDelete($id = null)
    {


        $bus = Bus::find($id);
        if ($bus->delete()) {
            return redirect()->back()->with("flashMessageSuccess", "Your Bus  Deleted Succesfully");
        } else {
            return redirect()->back()->with("flashMessageDanger", "Your Bus  deletetion Faild");
        }
    }
}
