<?php

namespace App\Http\Controllers\BackendControllers;

use DB;
use App\Models\User;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    public function registration_view()
    {

        return view('dashboard.driver.adddriver');
    }
    public function driverStore(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'email|unique:users,email',
            'mobile' => 'numeric|unique:users,mobile',
            'address' => 'required',
            'dob' => 'required|date',
            'nid_no' => 'required|numeric'
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:500',
        ]);


        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator->errors())->withInput();
        } else {

            try {

                //DB::beginTransaction();
                if ($request->hasFile('nid_image')) {

                    $image = $request->file('nid_image');

                    $name = time() . '.' . $image->getClientOriginalExtension();

                    $destination_path = public_path('/assets/images/avatars/driver_nid/');

                    $image_path = '/assets/images/avatars/driver_nid/' . $name;
                } else {
                    $image_path = '/assets/images/avatars/driver_nid/demonidpic.jpg';
                }


                $userData = [
                    'name' => $request->name,
                    'username' => $request->mobile,
                    'email' => $request->email ?? '',
                    'mobile' => $request->mobile ?? '',
                    'address' => $request->address ?? '',
                    'usertype' => 'Driver',
                    'password' => Hash::make($request->address),
                    'register_by' => 'System Administrator',
                    'is_active' => 'Active',
                ];

                $userSave = User::create($userData);

                if ($userSave->id > 0) {

                    $driverData = [
                        'driver_name' => $request->name,
                        'primary_contact' => $request->mobile ?? '',
                        'license_number' => $request->license_number ?? '',
                        'license_photo' => $request->license_photo ?? '',
                        'address' => $request->address ?? '',
                        'date_of_birth' => date('Y-m-d', strtotime($request->dob)),
                        'sex' => "Male",
                        'nid_number' => $request->nid_no,
                        'nid_photo' => $image_path,
                        'user_id' => $userSave->id,
                        'is_sign_in' => "None",
                    ];

                    $driverSave = Driver::create($driverData);
                } else {
                    return redirect()->back()->withErrors("flashMessageDanger", "User Not Save");
                }

                //DB::commit();

                if ($request->hasFile('nid_image')) {
                    $image->move($destination_path, $name);
                }

                //$this->send_raw_email_with_attachment($request->Email, $password);

                return redirect()->back()->with("flashMessageSuccess", "Your Driver info Stored Succesfully");
            } catch (\Throwable $th) {
                //DB::rollback();

                return redirect()->back()->withErrors("flashMessageDanger", $th->getMessage());
            }
        }
    }
    public function registered_drivers()
    {
        $allDrivers = User::getUserByType('Driver');

        return view('dashboard.driver.showdrivers', compact('allDrivers'));
    }
    public function driver_delete($user_id = null)
    {
        $driver = User::find($user_id);

        if ($driver->driver->delete()) {
            $driver->delete();
            return redirect()->back()->with("flashMessageSuccess", "Driver Deleted Succesfully");
        } else {
            return redirect()->back()->withErrors("flashMessageDanger", "Driver Deletetion Error!");
        }
    }
}
