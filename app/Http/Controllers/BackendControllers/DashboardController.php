<?php

namespace App\Http\Controllers\BackendControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

        $ActiveCleaners = 30;
        $Customers = 10;
        $PendingOrders = 8;
        $PendingShedule = 22;
        $TaskAssigned = 15;
        $TaskCompleted = 10;

        return  view('dashboard/index', compact('ActiveCleaners', 'Customers', 'PendingOrders', 'PendingShedule', 'TaskAssigned', 'TaskCompleted'));
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
