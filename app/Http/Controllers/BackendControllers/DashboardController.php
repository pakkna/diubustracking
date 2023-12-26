<?php

namespace App\Http\Controllers\BackendControllers;

use App\Models\Bus;
use App\Models\User;
use App\Models\Route;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;


class DashboardController extends Controller
{
    public function index(Request $request)
    {

        // $ActiveCleaners = EmployeInfo::where('IsActive', 1)->count();
        // $Customers = EmployeInfo::count();
        // $PendingOrders = OrderMaster::where('Status', "Pending")->count();
        // $PendingShedule = OrderSheduleInfo::where('ScheduleStatus', "Pending")->where('IsInvoiced', '0')->count();
        // $TaskAssigned = TaskInfo::where('IsCompleted', 0)->count();
        // $TaskCompleted = TaskInfo::where('IsCompleted', 1)->count();

        $totalBus = Bus::count();
        $totalDriver = Driver::count();
        $unAssignBus = 0;
        $assignBus = 0;
        $totalRoute = Route::count();
        $totalUser = User::where('usertype', 'Active')->count();


        return  view('dashboard/index', compact('totalBus', 'totalDriver', 'totalRoute', 'unAssignBus', 'assignBus', 'totalUser'));
    }

    public function all_clear()
    {
        $exitCode1 = Artisan::call('cache:clear');
        $exitCode2 = Artisan::call('route:clear');
        $exitCode3 = Artisan::call('config:clear');
        $exitCode1 = Artisan::call('cache:clear');
        $exitCode1 = Artisan::call('view:clear');

        return redirect('dashboard');
    }
}
