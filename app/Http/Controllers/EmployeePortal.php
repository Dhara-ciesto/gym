<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Deviceuser;
use App\Salary;
use App\Department;
use Hash;
use Session;
use Helper;
use DB;
use App\EmployeeLog;
use Illuminate\Validation\Rule;

class EmployeePortal extends Controller
{
    public function empdashboard(){

    	$empid = session()->get('admin_id');

        $today = date('Y-m-d');

        $min = EmployeeLog::where('userid', $empid)->where('punchdate', $today)->min('checkin');
        $max = EmployeeLog::where('userid', $empid)->where('punchdate', $today)->max('checkout');

    	return view('empportal.dashboard')->with(compact('min', 'max'));

    }

    public function empprofile(){

    	$empid = session()->get('admin_id');

    	$employee = Employee::findOrFail($empid);
    	$department = Department::where('status', 1)->get()->all();
        $state = DB::table('states')->get()->all();
        $city_id = DB::table('cities')->where('id', $employee->city)->first();
        $cities = DB::table('cities')->get()->all();

    	return view('empportal.viewempprofile')->with(compact('employee', 'department', 'state', 'city_id', 'cities'));

    }

    public function emplogemp(){

        $employee = Employee::all();
        $empid = session()->get('admin_id');

        return view('empportal.viewemployeelog')->with(compact('employee', 'empid'));
    }
}
