<?php


namespace App\Http\Controllers\BackendControllers;

use DB;
use App\Models\Bus;
use App\Models\User;
use App\Models\Driver;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    public function route_create()
    {

        return view('dashboard.route.addroute');
    }
    public function routeStore()
    {

        //return view('dashboard.route.addroute');
    }
    public function routeList()
    {

        return view('dashboard.route.routelist');
    }
}
