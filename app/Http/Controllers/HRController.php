<?php

namespace App\Http\Controllers;

use App\HR_Loan;
use App\HR_Loandetail;
use App\LeaveEntry;
use Illuminate\Http\Request;
use App\WorkingDays;
use App\Leave;
use App\EmployeeAccount;
use App\Employee;
use App\User_log;
use App\HREmployeeelog;
use App\Salary;
use App\EmployeeLeave;
use App\MonthLeave;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;
use Helper;
use DB;
use Session;
use Datatables;
use App\Ptassignlevel;
use App\Ptmember;
use App\Member;
use App\Claimptsession;
use App\MemberPackages;
use App\ExcelExport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\HR_device_emplog;
use Carbon\Carbon;
class HRController extends Controller
{

    /////////////////////////////////////////// Working Days Start ////////////////////////////////////////////////////////

    public function workingdays(Request $request){


        if($request->isMethod('post')){

            $request->validate([

                'year' => 'required',
                'month' => 'required',
                'workingdays' => 'required|integer',

            ]);

            DB::beginTransaction();
            //try {

            $year = $request->year;
            $month = $request->month;
            $workingdays = $request->workingdays;
            $nonworkingdats = !empty($request->nonworkingdate) ? $request->nonworkingdate : [];

            $nonworgdayscount = count($nonworkingdats);

            $month_exist = WorkingDays::where('year', $year)->where('month', $month)->get()->all();

            if(!empty($month_exist)){
                return redirect()->back()->with('error', 'Month already Exist')->withInput(Input::all());
            }

            if($request->month == 'Janaury'){
                $cal_month = 1;
            }else if($request->month == 'February'){
                $cal_month = 2;
            }else if($request->month == 'March'){
                $cal_month = 3;
            }else if($request->month == 'April'){
                $cal_month = 4;
            }else if($request->month == 'May'){
                $cal_month = 5;
            }else if($request->month == 'June'){
                $cal_month = 6;
            }else if($request->month == 'July'){
                $cal_month = 7;
            }else if($request->month == 'August'){
                $cal_month = 8;
            }else if($request->month == 'September'){
                $cal_month = 9;
            }else if($request->month == 'October'){
                $cal_month = 10;
            }else if($request->month == 'November'){
                $cal_month = 11;
            }else{
                $cal_month = 12;
            }

            $day_in_month = cal_days_in_month(CAL_GREGORIAN,$cal_month,$year);

            $holiday_cal = $day_in_month - $nonworgdayscount;

            $workingdays_obj = new WorkingDays();
            $workingdays_obj->year = $year;
            $workingdays_obj->month = $request->month;
            $workingdays_obj->holidays = $nonworgdayscount;
            $workingdays_obj->workingdays = $holiday_cal;
            $workingdays_obj->save();

            $working_days_id = $workingdays_obj->workingcalid;

            if($nonworgdayscount > 0){
                foreach($nonworkingdats as $nondate){
                    if(!empty($nondate)){
                        $nondateins = new MonthLeave();
                        $nondateins->workingcalanderid = $working_days_id;
                        $nondateins->nonworkingdate = date('Y-m-d', strtotime($nondate));
                        $nondateins->action_by = session()->get('admin_id');
                        $nondateins->save();
                    }
                }
            }

            DB::commit();
            $success = true;

            Session::flash('message', 'Working days is added successfully');
            Session::flash('alert-type', 'success');

            return redirect()->route('viewworkingdays');

            // }

            // catch (\Exception $e) {
            //        Helper::errormail('HR', 'Add Workingdays', 'High');
            //        $success = false;
            //        DB::rollback();

            //      }

            //      if ($success == false) {
            //        return redirect('dashboard');
            //      }


        }


        return view('hr.workingdays.addworkingdays');

    }

    public function viewworkingdays(){

        $working_days = WorkingDays::paginate(10);

        return view('hr.workingdays.viewworkingdays', compact('working_days'));



    }

    public function editworkingdays($id, Request $request){

        $working_days = WorkingDays::with('nonworkingdays')->where('workingcalid',$id)->first();

        if($request->isMethod('post')){


            $request->validate([

                'year' => 'required',
                'month' => 'required',
                'workingdays' => 'required|integer',

            ]);

            DB::beginTransaction();
            try {
                $year = $request->year;
                $month = $request->month;
                $workingdays = $request->workingdays;
                $nonworkingdats = !empty($request->nonworkingdate) ? $request->nonworkingdate : [];

                $nonworgdayscount = count($nonworkingdats);

                $month_exist = WorkingDays::where('year', $year)->where('month', $month)->where('workingcalid' ,'!=', $id)->get()->all();

                if(!empty($month_exist)){
                    return redirect()->back()->with('error', 'Month already Exist')->withInput(Input::all());
                }

                if($request->month == 'Janaury'){
                    $cal_month = 1;
                }else if($request->month == 'February'){
                    $cal_month = 2;
                }else if($request->month == 'March'){
                    $cal_month = 3;
                }else if($request->month == 'April'){
                    $cal_month = 4;
                }else if($request->month == 'May'){
                    $cal_month = 5;
                }else if($request->month == 'June'){
                    $cal_month = 6;
                }else if($request->month == 'July'){
                    $cal_month = 7;
                }else if($request->month == 'August'){
                    $cal_month = 8;
                }else if($request->month == 'September'){
                    $cal_month = 9;
                }else if($request->month == 'October'){
                    $cal_month = 10;
                }else if($request->month == 'November'){
                    $cal_month = 11;
                }else{
                    $cal_month = 12;
                }

                $day_in_month = cal_days_in_month(CAL_GREGORIAN,$cal_month,$year);

                $workingdays = $day_in_month - $nonworgdayscount;

                $holiday_cal = $day_in_month - $workingdays;

                $workingdays_obj = WorkingDays::findOrfail($id);
                $workingdays_obj->year = $year;
                $workingdays_obj->month = $request->month;
                $workingdays_obj->holidays = $nonworgdayscount;
                $workingdays_obj->workingdays = $workingdays;
                $workingdays_obj->save();

                $working_days_id = $workingdays_obj->workingcalid;

                $working_days = MonthLeave::where('workingcalanderid', $working_days_id)->get()->all();
                if(!empty($working_days)){
                    foreach($working_days as $days){
                        $nonworkdate = MonthLeave::findOrfail($days->monthleaveid);
                        if(!empty($nonworkdate)){
                            $nonworkdate->delete();
                        }
                    }
                }

                if($nonworgdayscount > 0){
                    foreach($nonworkingdats as $nondate){
                        if(!empty($nondate)){
                            $nondateins = new MonthLeave();
                            $nondateins->workingcalanderid = $working_days_id;
                            $nondateins->nonworkingdate = date('Y-m-d', strtotime($nondate));
                            $nondateins->action_by = session()->get('admin_id');
                            $nondateins->save();
                        }
                    }
                }

                DB::commit();
                $success = true;

                Session::flash('message', 'Working days is added successfully');
                Session::flash('alert-type', 'success');

                return redirect()->route('viewworkingdays');

            } catch(\Exception $e) {

                Helper::errormail('HR', 'Edit Workingdays', 'High');
                DB::rollback();
                $success = false;

            }

            if ($success == false) {
                return redirect('dashboard');
            }


        }

        return view('hr.workingdays.editworkingdays', compact('working_days'));



    }

    public function searchyear(Request $request){

        $year = $request->year;

        $working_days = WorkingDays::where('year', $year)->orderBy('workingcalid', 'asc')->paginate(10);

        return view('hr.workingdays.viewworkingdays', compact('working_days', 'year'));
    }

    /////////////////////////////////////////// Working Days End   ////////////////////////////////////////////////////////



    /////////////////////////////////////////// Leave Start   ////////////////////////////////////////////////////////


    public function leave(Request $request){


        if($request->isMethod('post')){


            $request->validate([

                'employeeid' => 'required|unique:hr_leave,employeeid',
                'noofleave' => 'required|integer',
                'expirydate' => 'required|date',

            ]);

            DB::beginTransaction();
            try {
                $Leave_obj = new Leave();
                $Leave_obj->employeeid = $request->employeeid;
                $Leave_obj->noofleave = $request->noofleave;
                $Leave_obj->expirydate = date('Y-m-d', strtotime($request->expirydate));
                $Leave_obj->actionby = session()->get('admin_id');
                $Leave_obj->save();

                DB::commit();
                $success = true;

                Session::flash('message', 'Leave is added successfully');
                Session::flash('alert-type', 'success');
                return redirect()->route('viewleave');

            } catch(\Exception $e) {

                Helper::errormail('HR', 'Add Leave', 'High');
                DB::rollback();
                $success = false;

            }

            if($success == false){
                return redirect('dashboard');
            }


        }

        $employee = Employee::where('status', 1)->get()->all();
        return view('hr.leave.addleave', compact('employee'));

    }

    public function viewleave(){

        $Leave = Leave::with('employeename')->paginate(10);
        $employee = Employee::where('status', 1)->get()->all();
        //dd($Leave);
        return view('hr.leave.viewleave', compact('Leave', 'employee'));

    }

    public function searcheleave(Request $request){

        $empid = $request->employeeid;

        $Leave = Leave::with('employeename')->where('employeeid', $empid)->paginate(10);
        $employee = Employee::where('status', 1)->get()->all();

        return view('hr.leave.viewleave', compact('Leave', 'employee'));
    }

    public function editleave($id, Request $request){

        $Leave_obj = Leave::findOrfail($id);


        if($request->isMethod('post')){


            $request->validate([

                'employeeid' => ['required', Rule::unique('hr_leave')->ignore($id, 'leaveid')],
                'noofleave' => 'required|integer',
                'expirydate' => 'required|date',

            ]);

            DB::beginTransaction();
            try {
                $Leave_obj->employeeid = $request->employeeid;
                $Leave_obj->noofleave = $request->noofleave;
                $Leave_obj->expirydate = date('Y-m-d', strtotime($request->expirydate));
                $Leave_obj->actionby = session()->get('admin_id');
                $Leave_obj->save();

                DB::commit();
                $success = true;

                Session::flash('message', 'Leave is edited successfully');
                Session::flash('alert-type', 'success');
                return redirect()->route('viewleave');


            } catch(\Exception $e){
                Helper::errormail('HR', 'Edit Leave', 'High');
                DB::rollback();
                $success = false;

            }

            if($success == false){
                return redirect('dashboard');
            }

        }

        $employee = Employee::where('status', 1)->get()->all();
        return view('hr.leave.editleave', compact('Leave_obj', 'employee'));

    }

    public function searchleaveyear(Request $request){

        $year = $request->year;

        $Leave = Leave::where('leaveyear', $year)->orderBy('leaveid', 'asc')->get()->all();

        return view('hr.leave.viewleave', compact('Leave', 'year'));
    }

    /////////////////////////////////////////// Leave End   ////////////////////////////////////////////////////////

    //////////////////////////////////////////// Employee Acoount Start /////////////////////////////////////////////

    public function ajaxgetpendingloan(Request $request){
        $employeeid=$request->employeeid;
        if(isset($request->type)){
            $loan = HR_Loan::where('employeeid',$employeeid)->where('type',$request->type)->whereColumn('paid_amount','<','total_amount')->get()->all();
        }else{
            $loan =HR_Loan::where('employeeid',$employeeid)->whereColumn('paid_amount','<','total_amount')->get()->all();
        }
        echo json_encode($loan);
    }

    public function ajaxgetpendingloandetail(Request $request){
        $loanid = $request->loanid;
        $loan = HR_Loandetail::where('hr_loan_id',$loanid)->where('status','Active')->get()->all();
        echo json_encode($loan);
    }
    public function employeeaccount(Request $request){

        if($request->isMethod('post')){
//dd($request->all());


            $request->validate([
                'employeeid' => 'required',
                'type' => 'required',
                'loan_date' => 'required',
                'remark' => 'required',
            ]);

            DB::beginTransaction();
            try {
                $amount = $request->amount;
                if($request->type=='EMI'){
//                if(empty($loan)){
//                    return redirect('viewemployeeaccount')->with('message','No loan found');
//                }

                    foreach ($request->loanid as $key => $value) {
                        $loan = HR_Loan::where('hr_loan_id', $value)->whereColumn('paid_amount', '<=', 'total_amount')->get()->first();

                        if (!empty($loan)){

                            $loanddetail = new HR_Loandetail();
                            $loanddetail->hr_loan_id = $loan->hr_loan_id;
                            $loanddetail->type = 'Credit';
                            $loanddetail->amount = $amount[$key];
                            $loanddetail->action_by = session()->get('admin_id');
                            $loanddetail->save();

                            $loan = HR_Loan::FindOrFail($loan->hr_loan_id);
                            $loan->paid_amount = $loan->paid_amount + $amount[$key];
                            $loan->due_amount = $loan->due_amount - $amount[$key];
                            $loan->save();
                        }
                    }
                }

                if($request->type=='Loan' || $request->type=='Fine'){
                    $loan = new HR_Loan();
                    $loan->employeeid = $request->employeeid;
                    $loan->loan_date = $request->loan_date;
                    $loan->type = $request->type;
                    $loan->total_amount = $amount;
                    $loan->due_amount = $amount;
                    $loan->paid_amount = 0;
                    $loan->remark = $request->remark;
                    $loan->actionby = session()->get('admin_id');
                    $loan->save();

                    $loanddetail = new HR_Loandetail();
                    $loanddetail->hr_loan_id = $loan->hr_loan_id;
                    $loanddetail->type = 'Debit';
                    $loanddetail->amount = $amount;
                    $loanddetail->action_by = session()->get('admin_id');
                    $loanddetail->save();
                }

                DB::commit();
                return redirect('viewemployeeaccount')->with('message','Amount is succesfully added');
            } catch(\Exception $e) {
                Helper::errormail('HR', 'Add Employeeaccount', 'High');
                DB::rollback();
                return redirect('dashboard');
            }

        }

        $employee = Employee::where('status', 1)->get()->all();
        return view('hr.account.addemployeeamount', compact('employee'));


    }

    public function viewemployeeaccount(){

        $account = EmployeeAccount::with('employeename')->where('employeeid','<',0)->orderBy('empaccountid','desc')->paginate(1);
        $pendingamt = 0;
        $employee = Employee::where('status', 1)->get()->all();
        return view('hr.account.viewemployeeamount')->with(compact('account', 'employee','pendingamt'));

    }

    public function searchemployeeaccount(Request $request){

        $empid = $request->employeeid;
        $loan = HR_Loan::where('employeeid',$empid)->whereColumn('paid_amount','<=','total_amount')->get()->all();
        $pendingamt = HR_Loan::where('employeeid', $empid)->sum('due_amount');
//		->orderBy('empaccountid','desc')->pluck('amount')->first();
//
//		$account = EmployeeAccount::with('employeename')->where('employeeid', $empid)
//		->orderBy('empaccountid','desc')->paginate(20);
        $employee = Employee::where('status', 1)->get()->all();


        return view('hr.account.viewemployeeamount')->with(compact('loan','pendingamt','employee','empid'));


    }

    //////////////////////////////////////////// Employee Acoount End   /////////////////////////////////////////////


    //////////////////////////////////////////// Employee Log Start //////////////////////////////////////////////

    public function employeelog(){

        $employee = Employee::where('status', 1)->get()->all();

        return view('hr.employeelog.viewemployeelog')->with(compact('employee'));

    }
    public function callhrdevicelog(){
        // define('ROOTUP', realpath(__DIR__ . '/../../nova40up.php'));
        // include ROOTUP . 'dbconfig.php';
        //    $path = app_path("/../../calculateworkinghour.php");
        //    dd($path);
        // include(public_path() . '/calculateworkinghour.php');
        include(public_path() . '/hr_device_emplog.php');
        return redirect()->back();
    }
    public function searchemployeelog(Request $request){
        if ($request->ajax()) {

            $employeeid = $request->employeeid;
            $year = $request->year;
            $month = $request->month;

            if(!empty($employeeid) || !empty($year) || !empty($month)){

                if($request->month == 'January'){
                    $cal_month = 1;
                }else if($request->month == 'February'){
                    $cal_month = 2;
                }else if($request->month == 'March'){
                    $cal_month = 3;
                }else if($request->month == 'April'){
                    $cal_month = 4;
                }else if($request->month == 'May'){
                    $cal_month = 5;
                }else if($request->month == 'June'){
                    $cal_month = 6;
                }else if($request->month == 'July'){
                    $cal_month = 7;
                }else if($request->month == 'August'){
                    $cal_month = 8;
                }else if($request->month == 'September'){
                    $cal_month = 9;
                }else if($request->month == 'October'){
                    $cal_month = 10;
                }else if($request->month == 'November'){
                    $cal_month = 11;
                }else{
                    $cal_month = 12;
                }

                $day_in_month = cal_days_in_month(CAL_GREGORIAN,$cal_month,$year);
                $fromdate = date('Y-m-d',strtotime("$year-$cal_month-01"));
                $todate = date('Y-m-d',strtotime("$year-$cal_month-$day_in_month"));

                $searchparameter = ['employeeid' => $employeeid, 'month' => $month, 'year' => $year];

                $employeelog = HR_device_emplog::where('empid', $employeeid)->whereBetween('dateid', [$fromdate, $todate])->orderBy('timeout1', 'asc')->get();

                return datatables()->of($employeelog)
                    ->editColumn('dateid', function($employeelog){

                        return $employeelog->dateid = date("d-m-Y", strtotime($employeelog->dateid));


                    })
                    ->editColumn('timeout1', function($employeelog){
                        if(!empty($employeelog->timeout1)){
                            return $employeelog->timeout1;
                        }else{
                            if(session()->get('logged_role') == 'Admin'){

                                return "<a href=".route('addpunch', $employeelog->emplogid)." class='btn btn-danger'>Miss</a>";
                            }else{
                                return "<a class='btn btn-danger' disabled title='Dare to edit this'>Miss</a>";
                            }
                        }

                    })

                    ->editColumn('timein2', function($employeelog){
                        if(!empty($employeelog->timein2)){
                            return $employeelog->timein2;
                        }else{
                            if(session()->get('logged_role') == 'Admin'){

                                //return "<a href=".route('addpunch', $employeelog->emplogid)." class='btn btn-danger'>Miss</a>";
                            }else{
                                //return "<a class='btn btn-danger' disabled title='Dare to edit this'>Miss</a>";
                            }
                        }

                    })
                    ->editColumn('timeout2', function($employeelog){
                        if(!empty($employeelog->timeout2)){
                            return $employeelog->timeout2;
                        }else{
                            if(session()->get('logged_role') == 'Admin'){

                                //return "<a href=".route('addpunch', $employeelog->emplogid)." class='btn btn-danger'>Miss</a>";
                            }else{
                                //return "<a class='btn btn-danger' disabled title='Dare to edit this'>Miss</a>";
                            }
                        }

                    })
                    ->editColumn('timein3', function($employeelog){
                        if(!empty($employeelog->timein3)){
                            return $employeelog->timein3;
                        }else{
                            if(session()->get('logged_role') == 'Admin'){

                                //return "<a href=".route('addpunch', $employeelog->emplogid)." class='btn btn-danger'>Miss</a>";
                            }else{
                                //return "<a class='btn btn-danger' disabled title='Dare to edit this'>Miss</a>";
                            }
                        }

                    })
                    ->editColumn('timeout3', function($employeelog){
                        if(!empty($employeelog->timeout3)){
                            return $employeelog->timeout3;
                        }else{
                            if(session()->get('logged_role') == 'Admin'){

                                //return "<a href=".route('addpunch', $employeelog->emplogid)." class='btn btn-danger'>Miss</a>";
                            }else{
                                //return "<a class='btn btn-danger' disabled title='Dare to edit this'>Miss</a>";
                            }
                        }

                    })->escapeColumns([])
                    ->make(true);

                //$employee = Employee::where('status', 1)->get()->all();


                //$employeelog->appends(array('employeeid' => $employeeid, 'year' => $year, 'month' => $month));


                //return view('hr.employeelog.viewemployeelog')->with(compact('employeeid', 'year', 'month', 'employeelog', 'employee', 'searchparameter'));

            }
        }
    }


    public function addpunch($id, Request $request){

        $log = HREmployeeelog::findOrfail($id);

        if($request->isMethod('post')){

            $request->validate([

                'punchtime' => 'required',


            ]);

            $checkout = $request->punchtime;
            $checkin = $log->checkin;

            DB::beginTransaction();
            try {

                $log->checkout = date('H:i:s', strtotime($request->punchtime));
                $log->save();

                DB::commit();
                $success = true;

                Session::flash('message', 'Punch is added successfully');
                Session::flash('alert-type', 'success');


                return redirect()->route('employeelog');

            } catch(\Exception $e){

                Helper::errormail('HR', 'Add Punch', 'High');
                DB::rollback();
                $success = false;
            }

            if($success == false){
                return redirect('dashboard');
            }


        }

        $employee = Employee::where('status', 1)->get()->all();

        return view('hr.employeelog.addemployeelog')->with(compact('employee', 'log'));


    }


    public function addemppunch(Request $request){

        $employee = Employee::where('status', 1)->get()->all();
        if($request->isMethod('POST')){

            $request->validate([

                'employeeid' => 'required',
                'punchdate' => 'required|date',
                'checkin' => 'required',
                'checkout' => 'required',

            ]);
            $error=0;
            $emppunch = HR_device_emplog::where('dateid',$request->punchdate)->where('empid',$request->employeeid)->get()->first();
            $punch = array();
            $finalpunch = array();
            /*******************/
            if($emppunch){
                array_push($punch,$emppunch->timein1,$emppunch->timeout1,$emppunch->timein2,$emppunch->timeout2,$emppunch->timein3,$emppunch->timeout3,$request->checkin,$request->checkout);
                foreach($punch as $punch1){
                    if($punch1 > 0){
                        array_push($finalpunch, $punch1);
                    }
                }

                /*******************/
                sort($finalpunch);
                $punchlength = count($finalpunch);

                for($i= 0; $i<$punchlength;$i++){
                    if($punchlength == 2){
                        if($finalpunch[$i]){
                            $emppunch->timein1 = $finalpunch[$i];
                            $i++;
                        }
                        if($finalpunch[$i]){
                            $emppunch->timeout1 = $finalpunch[$i];
                            $i++;
                        }

                    }
                    else if($punchlength == 4){
                        if($finalpunch[$i]){
                            $emppunch->timein1 = $finalpunch[$i];
                            $i++;
                        }
                        if($finalpunch[$i]){
                            $emppunch->timeout1 = $finalpunch[$i];
                            $i++;
                        }
                        if($finalpunch[$i]){
                            $emppunch->timein2 = $finalpunch[$i];
                            $i++;
                        }
                        if($finalpunch[$i]){
                            $emppunch->timeout2 = $finalpunch[$i];
                            $i++;
                        }
                    }
                    else if($punchlength == 6){
                        if($finalpunch[$i]){
                            $emppunch->timein1 = $finalpunch[$i];
                            $i++;
                        }
                        if($finalpunch[$i]){
                            $emppunch->timeout1 = $finalpunch[$i];
                            $i++;
                        }
                        if($finalpunch[$i]){
                            $emppunch->timein2 = $finalpunch[$i];
                            $i++;
                        }
                        if($finalpunch[$i]){
                            $emppunch->timeout2 = $finalpunch[$i];
                            $i++;
                        }
                        if($finalpunch[$i]){
                            $emppunch->timein3 = $finalpunch[$i];
                            $i++;
                        }
                        if($finalpunch[$i]){
                            $emppunch->timeout3 = $finalpunch[$i];
                            $i++;
                        }
                    }

                }
                $emppunch->save();

                Session::flash('message', 'Punch is added successfully');
                Session::flash('alert-type', 'success');

                return redirect()->route('employeelog');
            }else{
                return redirect()->route('employeelog')->withErrors(['Log Not Exists']);
            }
        }

        return view('hr.employeelog.addemployeepunch')->with(compact('employee'));

    }



    //////////////////////////////////////////// Employee Log End   /////////////////////////////////////////////

    //////////////////////////////////////////// salary start //////////////////////////////////////////////////


    public function salary(Request $request){

        $employee = Employee::where('status', 1)->get()->all();

        return view('hr.salary.salary')->with(compact('employee'));
    }

    public function empsalary(Request $request){

        $employeeid = Input::get('employeeid');
        $year = Input::get('year');
        $month = Input::get('month');

        $if_exist = Salary::where('year', $year)
            ->where('month', $month)->where('employeeid', $employeeid)->first();

        if(!empty($if_exist)){

            $status = $if_exist->status;

            if($status == 'Locked'){

                Session::flash('message', 'Salary is already locked');
                Session::flash('alert-type', 'error');

                return redirect()->route('viewlockedsalary');

            }else{

                Session::flash('message', 'Salary is calculated');
                Session::flash('alert-type', 'error');

                return redirect()->route('viewsalary');
            }

        }

        $workingdays_data = WorkingDays::where('year', $year)->where('month', $month)->first();
        if(empty($workingdays_data)){

            Session::flash('message', 'Please add workingdays of '.$month);
            Session::flash('alert-type', 'error');


            return redirect()->route('workingdays')->with(compact('year', 'month'));
        }
        $empdata = Employee::where('employeeid', $employeeid)->first();
        if($empdata->workinghour <= 0){
            return redirect('users')->withErrors('Kindly Add Working Hours');
        }
        if(!empty($employeeid) || !empty($year) || !empty($month)){

            if($request->month == 'Janaury'){
                $cal_month = 1;
            }else if($request->month == 'February'){
                $cal_month = 2;
            }else if($request->month == 'March'){
                $cal_month = 3;
            }else if($request->month == 'April'){
                $cal_month = 4;
            }else if($request->month == 'May'){
                $cal_month = 5;
            }else if($request->month == 'June'){
                $cal_month = 6;
            }else if($request->month == 'July'){
                $cal_month = 7;
            }else if($request->month == 'August'){
                $cal_month = 8;
            }else if($request->month == 'September'){
                $cal_month = 9;
            }else if($request->month == 'October'){
                $cal_month = 10;
            }else if($request->month == 'November'){
                $cal_month = 11;
            }else{
                $cal_month = 12;
            }

            $day_in_month = cal_days_in_month(CAL_GREGORIAN,$cal_month,$year);
            $fromdate = date('Y-m-d 00:00:00',strtotime("$year-$cal_month-01"));
            $todate = date('Y-m-d 23:59:59',strtotime("$year-$cal_month-$day_in_month"));
            $todate = date('Y-m-d 23:59:59', strtotime("+1 day", strtotime($todate)));

            $account = EmployeeAccount::with('employeename')
                ->where('employeeid', $employeeid)
                ->where('type', '!=' , 'Fine')
                ->where('type', '!=' , 'EMI')
                ->where('salaryid',NULL)
                ->orderBy('empaccountid','desc')->paginate(100);
            DB::enableQueryLog();

            $accountfine = EmployeeAccount::with('employeename')->where('employeeid', $employeeid)->where('type','Fine')->whereBetween('empaccountdate', [$fromdate, $todate])->orderBy('empaccountid','desc')->paginate(100);
//		dd($accountfine);
//          dd(DB::getQueryLog());

            $searchparameter = ['employeeid' => $employeeid, 'month' => $month, 'year' => $year];

            $employee = Employee::where('status', 1)->get()->all();
            $emptime = Employee::where('employeeid', $employeeid)->first();
            $checkintime = $emptime->workinghourfrom1;
            $checkouttime = $emptime->workinghourto1;

            if(!($checkintime) && !($checkouttime)){
                Session::flash('message', 'Please Add Working shift Timing');
                Session::flash('alert-type', 'errors');
                return redirect('edituser/'.$employeeid);

                // return redirect()->back()->with(compact('year', 'month'));
            }
            $employeelog = HR_device_emplog::where('empid', $employeeid)->whereBetween('dateid', [$fromdate, $todate])->where('timein1', null)->select('hr_device_emplog.dateid', 'hr_device_emplog.timein1', 'hr_device_emplog.timeout1', 'hr_device_emplog.timein2', 'hr_device_emplog.hr_device_emplogid')->get()->all();


            $lateemployeelog = HR_device_emplog::where('empid', $employeeid)
                ->whereBetween('dateid', [$fromdate, $todate])
                ->where(function($query) use ($checkintime, $checkouttime){
                    $query->where('timein1', '>', $checkintime)->orWhere('timeout1', '<', $checkouttime);
                })->get()->all();

            $error = 1;
            /*if(!empty($employeelog)){

                Session::flash('message', 'Please complete employee log');
                Session::flash('alert-type', 'error');

                return view('hr.employeelog.viewemployeelog')->with(compact('employeeid', 'year', 'month', 'employee', 'error'));

            }*/


            //  try {

            $employeelog = HR_device_emplog::where('empid', $employeeid)
                ->whereBetween('dateid', [$fromdate, $todate])->get()->all();
            $employeelog_days = HR_device_emplog::where('empid', $employeeid)->whereBetween('dateid', [$fromdate, $todate])->where('timein1','>',0)->groupBy('dateid')->select('dateid')->get()->all();


            $attenddays = count($employeelog_days);

            $totalminute = 0;
            $totalhour = 0;
            $totaldays = 0;
            $givenleave = 0;

            foreach($employeelog as $emplog){

                $difference = ROUND(ABS(strtotime($emplog->timeout1) - strtotime($emplog->timein1))/60);
                $totalminute += abs($difference);

            }

            $totalhour_dispaly_model = round($totalminute/60);

            $totalminute_dispaly = $totalminute;
            /*$hours123 = floor($totalminute / 60);
            $minutes123 = ($totalminute % 60);*/
            //echo $hours123.":".$minutes123;exit;


            $noofleave = Leave::where('employeeid', $employeeid)->first();
            if(!empty($noofleave)){
                $givenleave = $noofleave->noofleave;
            }else{
                $givenleave = 0;
            }

            $paidleave = 0;

            $empleave = LeaveEntry::where('employeeid', $employeeid)
                ->whereBetween('date', [$fromdate, $todate])->get()->all();
            if(!empty($empleave)){
                foreach($empleave as $leaveinfo){
                    if($leaveinfo->leavetype == 'Pl'){
                        $paidleave += 1;
                    }
                }
            }

            $takenleave = count($empleave);
            $takenleave_display = count($empleave);

            $empdata = Employee::where('employeeid', $employeeid)->first();

            /*$employeeaccount = Employeeaccount::where('employeeid', $employeeid)->*/

            $empsalary = $empdata->salary;
            $empworkinghour = $empdata->workinghour;

            $Workindays = 0;
            $holidays = 0;
            $workingdays_data = WorkingDays::where('year', $year)->where('month', $month)->first();
            if(!empty($workingdays_data)){
                $Workindays = $workingdays_data->workingdays;
                $holidays = $workingdays_data->holidays;
            }else{
                $Workindays = 0;
                $holidays = 0;
            }
            /*****for leave cal******/
            $totalworkindays = $Workindays;

            $leavedays_cal = $totalworkindays - $attenddays;

            /*****End *for leave cal******/
            $actualdays = $Workindays - $workingdays_data->holidays ;


            //dd($actualdays);



            if($leavedays_cal < 0){
                $leavedays_cal = 0;
            }

            $empattandedhours=($totalworkindays-$leavedays_cal) * $empworkinghour;

            $totalworkinghour = ($Workindays + $holidays) * $empworkinghour;

            $empworkingminute = ($Workindays + $holidays)  * $empworkinghour * 60;
            $totalminute = $attenddays * $empworkinghour * 60;
            $totalminutedisplay = $totalminute/60;

            $total_hour = ceil($totalminute / 60);


            $takenleave = $Workindays - $attenddays;

            $totalattenddays = $attenddays + $holidays;

            $perdaysalary = ($empsalary/($Workindays + $holidays));

            $current_salary = number_format((float)($perdaysalary * $totalattenddays), 2, '.', '');

            if($current_salary > $empsalary){
                $current_salary = $empsalary;
            }

            $store = !empty($request->store) ? $request->store : 0;

            $success = true;
            $nondutyhours=0;
            $nondutyhoursamount=0;




            $emploanamountfine = EmployeeAccount::where('employeeid', $employeeid)
                ->where('type','Fine')->orderBy('empaccountid', 'desc')->first();

            $emploanamount = EmployeeAccount::where('employeeid', $employeeid)->where('type', '!=' , 'Fine')->orderBy('empaccountid', 'desc')->first();

            /******************* if trainer ******************************/

            if($empdata->role == 'trainer' || $empdata->role == 'Trainer' ){
                $ptlogs=array();
                $ptlogsdisplay=array();
                $nondutylogdisplay=array();
                $allsessionprice=0;
                $trainerdata=Ptassignlevel::where('trainerid',$empdata->employeeid)->leftjoin('ptlevel','ptassignlevel.levelid','ptlevel.id')->get()->first();

                if($trainerdata){
                    $trainerlevel=$trainerdata->level;
                    $trainerpercentage=$trainerdata->percentage;
                    $trainerschemes=[];

                    $trainersession=Claimptsession::where('trainerid',$empdata->employeeid)
                        ->where('status','Active')->whereMonth('actualdate',$cal_month)
                        ->whereYear('actualdate',$year)->where('dutyhours','!=',0)->get()->count();
                    $nondutyhours=Claimptsession::where('trainerid',$empdata->employeeid)->where('status','Active')->whereMonth('actualdate',$cal_month)->whereYear('actualdate',$year)->where('dutyhours',0)->get()->count();
                    $nondutyhoursamount = Claimptsession::where('trainerid',$empdata->employeeid)->where('status','Active')->whereMonth('actualdate',$cal_month)->whereYear('actualdate',$year)->where('dutyhours',0)->sum('amount');

                    $trainersessiondetail=Claimptsession::where('trainerid',$empdata->employeeid)
                        ->where('status','Active')
                        ->whereMonth('actualdate',$cal_month)
                        ->whereYear('actualdate',$year)->orderBy('actualdate','desc')->get()->all();
                    foreach ($trainersessiondetail as $key => $value) {

                        $package=MemberPackages::where('memberpackagesid',$value->packageid)
                            ->leftjoin('schemes','memberpackages.schemeid','schemes.schemeid')
                            ->get()->first();
                        $member=Member::where('memberid',$value->memberid)->get(['member.firstname','member.lastname'])->first();

                        $value['schemename']=$package->schemename;
                        $value['firstname']=$member->firstname;
                        $value['lastname']=$member->lastname;


                    }
                    $ptlogs = Claimptsession::where('trainerid',$empdata->employeeid)->where('status','Active')
                        ->whereMonth('actualdate',$cal_month)
                        ->whereYear('actualdate',$year)
                        ->orderBy('actualdate','desc')->get()->all();
                    foreach($ptlogs as $ptlog){
                        $ptlogcount = 	$trainersessioncount=Claimptsession::where('trainerid',$empdata->employeeid)->where('status','Active')
                            ->whereMonth('actualdate',$cal_month)
                            ->whereYear('actualdate',$year)
                            ->orderBy('actualdate','desc')
                            ->where('memberid',$ptlog->memberid)->get()->count();
                        $member=Member::where('memberid',$ptlog->memberid)->get(['member.firstname','member.lastname'])->first();
                        $ptlog['schemename']=$package->schemename;
                        $ptlog['firstname']=$member->firstname;
                        $ptlog['lastname']=$member->lastname;
                        $ptlog['count']=$ptlogcount;
                    }
                    DB::enableQueryLog();
                    $ptlogspackages = Claimptsession::
                    where('trainerid',$empdata->employeeid)
                        ->where('status','Active')
                        ->whereMonth('actualdate',$cal_month)
                        ->whereYear('actualdate',$year)
                        ->groupBy('packageid')
                        ->orderBy('actualdate','desc')->pluck('packageid')->all();

                    foreach ($ptlogspackages as $key => $value) {
                        $ptlogscountamt=0;
                        $persessionamt=0;
                        $ptlogscount = Claimptsession::
                        where('trainerid',$empdata->employeeid)
                            ->where('status','Active')
                            ->whereMonth('actualdate',$cal_month)
                            ->whereYear('actualdate',$year)
                            ->where('packageid',$value)
                            ->where('dutyhours',1)
                            ->orderBy('actualdate','desc')->get()->all();
                        foreach ($ptlogscount as $key2 => $valueptlog) {
                            $persessionamt = $valueptlog->amount;
                            $ptlogscountamt = $ptlogscountamt+$valueptlog->amount;
                        }
                        $package=MemberPackages::where('memberpackagesid',$value)
                            ->leftjoin('schemes','memberpackages.schemeid','schemes.schemeid')
                            ->get()->first();
                        $member=Member::where('userid',$package->userid)
                            ->get(['member.firstname','member.lastname','member.memberpin'])->first();
                        $ptlogsdisplay[$key] =  (object) ['property' => 'Here we go'];
                        $ptlogsdisplay[$key]->pin = $member->memberpin;
                        $ptlogsdisplay[$key]->schemename = $package->schemename;
                        $ptlogsdisplay[$key]->firstname = $member->firstname;
                        $ptlogsdisplay[$key]->lastname = $member->lastname;
                        $ptlogsdisplay[$key]->persessionamt = $persessionamt;
                        $ptlogsdisplay[$key]->count = count($ptlogscount);
                        $ptlogsdisplay[$key]->ptlogscountamt = $ptlogscountamt;
                    }
                    if($ptlogsdisplay){
                        $ptlogsdisplay=$ptlogsdisplay;
                    }

                    $count = 0;
                    foreach ($ptlogspackages as $key => $value) {
                        $nondutycountamt=0;
                        $nondutyptlogscount = Claimptsession::
                        where('trainerid',$empdata->employeeid)
                            ->where('status','Active')
                            ->whereMonth('actualdate',$cal_month)
                            ->whereYear('actualdate',$year)
                            ->where('packageid',$value)
                            ->where('dutyhours',0)
                            ->orderBy('actualdate','desc')->get()->all();
                        foreach ($nondutyptlogscount as $key => $valueptlog) {
                            $persessionamt = $valueptlog->amount;
                            $nondutycountamt = $nondutycountamt+$valueptlog->amount;
                        }
                        if($nondutyptlogscount){
                            $package=MemberPackages::where('memberpackagesid',$value)
                                ->leftjoin('schemes','memberpackages.schemeid','schemes.schemeid')
                                ->get()->first();
                            $member=Member::where('userid',$package->userid)
                                ->get(['member.firstname','member.lastname','member.memberpin'])->first();
                            $nondutylogdisplay[$count] =  (object) ['property' => 'Here we go'];
                            $nondutylogdisplay[$count]->pin = $member->memberpin;
                            $nondutylogdisplay[$count]->schemename=$package->schemename;
                            $nondutylogdisplay[$count]->firstname=$member->firstname;
                            $nondutylogdisplay[$count]->lastname=$member->lastname;
                            $nondutylogdisplay[$count]->persessionamt = $persessionamt;
                            $nondutylogdisplay[$count]->count=count($nondutyptlogscount);
                            $nondutylogdisplay[$count]->nondutycountamt = $nondutycountamt;
                            $count++;
                        }


                    }
                    if($nondutylogdisplay){
                        $nondutylogdisplay=$nondutylogdisplay;
                    }


                    $trainerdetail['trainerlevel'] = $trainerlevel;
                    $trainerdetail['trainerpercentage'] = $trainerpercentage;
                    $trainerdetail['trainershemes'] = $trainersessiondetail;

                    $perhoursalary = $perdaysalary / $empworkinghour;
                    $totalsessionprice=0;

                    $current_salary = $current_salary - ($perhoursalary*$trainersession);

                    foreach($trainerdetail['trainershemes'] as $schemedetail)
                    {
                        $totalsessionprice += $schemedetail->amount;
                    }
                    if($nondutyhoursamount){
                        $current_salary = $current_salary + $nondutyhoursamount;
                    }
                    $current_salary = $current_salary + $totalsessionprice;
                    $current_salary = round($current_salary ,  2);

                    $allsessionprice = $totalsessionprice;
                    // dd($current_salary);
                }else{
                    Session::flash('message', 'Please assign level to trainer ');
                    Session::flash('alert-type', 'error');
                    return redirect()->route('assignptlevel');
                }

            }
            else {

                $trainerdetail =[];
                $trainersession =0;
                $allsessionprice=0;
                $trainersessiondetail=[];
                $ptlogs = array();
                $ptlogsdisplay=array();
                $nondutylogdisplay=array();

            }
            $roleid= $empdata->roleid;
            // dd($empdata);
            if (in_array($roleid,[5,6])){

                $trainerdetail =[];
                $trainersession = 0;
                $allsessionprice = 0;
                $trainersessiondetail = [];
                $ptlogs = array();
                $ptlogsdisplay = array();
                $nondutylogdisplay = array();
                $current_salary = $empsalary;
            }
            // dd($emploanamountfine);
            /*******************for trainer session wise salary***************************** */

            /*********************for trainer session wise salary*************************** */

            /*******************end if trainer***************************** */
            return view('hr.salary.calculatesalary')->with(compact('roleid','attenddays','account','accountfine','empleave' ,'totalminute', 'totalhour', 'totaldays', 'givenleave', 'takenleave', 'empdata', 'empsalary','empattandedhours', 'empworkinghour', 'total_hour', 'year', 'month','cal_month', 'Workindays', 'holidays', 'empworkingminute', 'current_salary', 'employeeid', 'takenleave_display', 'Workindays', 'leavedays_cal', 'totalworkinghour', 'employeelog', 'totalminute_dispaly', 'totalhour_dispaly_model', 'emploanamount', 'lateemployeelog', 'actualdays','trainersession','trainersessiondetail','trainerdetail','nondutyhours','nondutyhoursamount','allsessionprice','emploanamountfine','ptlogs','ptlogsdisplay','nondutylogdisplay'));

            // }  catch(\Exception $e) {

            // 	Helper::errormail('Hr', 'Calculate Salary', 'High');

            // 	$success = false;
            // }

            // if($success == false){
            // 	return redirect('dashboard');
            // }




        }
    }

    public function storeempsalary(Request $request){
        /*$request->validate([

            'attenddays_display' => 'required|numeric|digits_between:1,2',
            'takenleave_display' => 'required|numeric|digits_between:1,2',
            'casualleave' => 'nullable|numeric|digits_between:1,2',
            'medicalleave' => 'nullable|numeric|digits_between:1,2',
            'paidleave' => 'nullable|numeric|digits_between:1,2',
            'current_salary' => 'required|numeric|digits_between:1,10',

        ]);*/

        $if_exist = Salary::where('year', $request->year)->where('month', $request->month)->where('employeeid', $request->employeeid)->first();

        if(!empty($if_exist)){

            Session::flash('message', 'Employee Salary is already locked');
            Session::flash('alert-type', 'error');

            return redirect()->route('viewlockedsalary');
        }

        DB::beginTransaction();
        try {


            $tsessionsalary=[];
            $tsessionsalarystring='';
            if($tsessionsalary > 0){

                $trainersession = Claimptsession::where('trainerid',$request->employeeid)->where('status','Active')->whereMonth('actualdate', $request->cal_month)->whereYear('actualdate',$request->year)->get()->count();
                $trainersessiondetail = Claimptsession::where('trainerid',$request->employeeid)->where('status','Active')->whereMonth('actualdate', $request->cal_month)->whereYear('actualdate',$request->year)->orderBy('actualdate','asc')->get()->all();

                foreach($trainersessiondetail as $tsession){
                    $tsession->status = "PaidPending";
                    $tsession->save();
                    $sessionpt=Ptmember::where('trainerid',$request->employeeid)->where('date',$tsession->scheduledate)->where('hoursfrom',$tsession->scheduletime)->get()->first();

                    $sessionpt->status = "PaidPending";
                    $sessionpt->save();
                    array_push($tsessionsalary,$tsession->claimptsessionid);
                }
            }
            if(count($tsessionsalary) > 0){
                $tsessionsalarystring = implode (",", $tsessionsalary);
            }


            $salary = new Salary();
            $salary->remark = $request->remark;
            $salary->employeeid = $request->employeeid;
            $salary->workingdays = $request->Workindays;
            $salary->attenddays = $request->attenddays_display;
            $salary->actualdays = $request->actualdays_display;
            $salary->totalminute = $request->workingminute;
            $salary->empworkingminute = $request->empworkingminute;
            $salary->empworkinghour = $request->monthlyworking_hour_display;
            $salary->extrahoursalary = $request->extrahoursalary;
            $salary->extrahour = $request->extrahour;
            $salary->totalhour = $request->totalworkinghour_display;
            $salary->givenleave = $request->givenleave;
            $salary->takenleave = $request->takenleave_display;
            $salary->empsalary = $request->empsalary;
            $salary->currentsalary = $request->current_salary;
            $salary->holidays = $request->holidays;
            $salary->bonus = $request->bonus;
            $salary->casualleave = !empty($request->casualleave) ? $request->casualleave : 0;
            $salary->medicalleave = !empty($request->medicalleave) ? $request->medicalleave : 0;
            $salary->paidleave = !empty($request->paidleave) ? $request->paidleave : 0;
            $salary->year = $request->year;
            $salary->month = $request->month_display;
            $salary->ptsessionid = $tsessionsalarystring;
            $salary->ptsessionsalary = $request->totalsessionprice;
            $salary->subtotal = $request->subtotal;
//            $salary->salaryemi = !empty($request->emi) ? $request->emi : 0;
//            $salary->salaryemi2 = !empty($request->emi2) ? $request->emi2 : 0;

            $salary->salaryothercharges = !empty($request->otheramount) ? $request->otheramount : 0;
            $salary->salarydeductedamount = !empty($request->deductedamount) ? $request->deductedamount : 0;

//            $salary->loanamount = !empty($request->loan) ? $request->loan : 0;
//            $salary->loanfine = !empty($request->loanfine) ? $request->loanfine : 0;

            $salary->status = 'Unlocked';
            $salary->actionby = session()->get('admin_id');

            $salary->save();

            $loanid = $request->Loan_loanid;
            $loan_amount = $request->Loan_amount;
            if(!empty($loanid)) {
                for ($i = 0; $i < count($loanid); $i++) {
                    $loan_detail = new HR_Loandetail();
                    $loan_detail->hr_loan_id = $loanid[$i];
                    $loan_detail->salary_id = $salary->salaryid;
                    $loan_detail->type = 'Credit';
                    $loan_detail->amount = $loan_amount[$i];
                    $loan_detail->action_by = session()->get('admin_id');
                    $loan_detail->status = 'Pending';
                    $loan_detail->save();
                }
            }
            $fine_loanid = $request->Fine_loanid;
            $fine_amount = $request->Fine_amount;
            if(!empty($fine_loanid)) {
                for ($i = 0; $i < count($fine_loanid); $i++) {
                    $loan_detail = new HR_Loandetail();
                    $loan_detail->hr_loan_id = $fine_loanid[$i];
                    $loan_detail->salary_id = $salary->salaryid;
                    $loan_detail->type = 'Credit';
                    $loan_detail->amount = $fine_amount[$i];
                    $loan_detail->action_by = session()->get('admin_id');
                    $loan_detail->status = 'Pending';
                    $loan_detail->save();
                }
            }

//            if($request->emi > 0){
//
//				$empaccount = EmployeeAccount::where('employeeid', $request->employeeid)->where('type', '!=' , 'Fine')->orderBy('empaccountid', 'desc')->first();
//
//				if(!empty($empaccount)){
//
//
//					$empamount = $empaccount->amount;
//					if($empamount > 0 || $empamount >= $request->emi){
//						$finalamount = $empamount - $request->emi;
//
//						$newempaccount = new EmployeeAccount();
//						$newempaccount->employeeid = $request->employeeid;
//                        $newempaccount->salaryid =  $salary->salaryid;
//						$newempaccount->amount = $finalamount;
//						$newempaccount->type = 'EMI';
//						$newempaccount->enteramount =  $request->emi;
//						$newempaccount->remark =  $request->remark;
//
//						$newempaccount->empaccountdate = date('Y-m-d');
//						$newempaccount->actionby = session()->get('admin_id');
//						$newempaccount->save();
//
//					}
//
//				}
//
//			}
//			if($request->emi2 > 0){
//
//				$empaccount = EmployeeAccount::where('employeeid', $request->employeeid)->where('type','Fine')->orderBy('empaccountid', 'desc')->first();
//
//				if(!empty($empaccount)){
//
//					$empamount = $empaccount->amount;
//					if($empamount > 0 || $empamount >= $request->emi2){
//						$finalamount = $empamount - $request->emi2;
//
//						$newempaccount = new EmployeeAccount();
//						$newempaccount->employeeid = $request->employeeid;
//                        $newempaccount->salaryid =  $salary->salaryid;
//						$newempaccount->amount = $finalamount;
//						$newempaccount->type = 'Fine';
//						$newempaccount->enteramount =  $request->emi2;
//						$newempaccount->remark =  $request->remark;
//						$newempaccount->empaccountdate = date('Y-m-d');
//						$newempaccount->actionby = session()->get('admin_id');
//						$newempaccount->save();
//
//					}
//
//				}
//
//			}

            DB::commit();
            $success = true;

            Session::flash('message', 'Employee Salary is locked');
            Session::flash('alert-type', 'success');

            return redirect()->route('viewsalary');
//
        } catch(\Exception $e) {

//			Helper::errormail('HR', 'Store Salary', 'High');

            DB::rollback();
            dd($e);
            $success = false;
        }

        if($success == false){
            return redirect('dashboard');
        }

    }

    public function viewlockedsalary(Request $request){

        $months = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"];
        $salary = Salary::with('employee')->where('status', 'Locked');
        if(isset($request->employeeid)){
            $salary = $salary->where('employeeid', $request->employeeid);
        }
        if(isset($request->month) && isset($request->year)){

            if($request->month=='All') {

                $salary = $salary->whereIN('month',$months)->whereIN('year', $request->year);
            }else{
                $salary = $salary->where('month',$request->month)->whereIN('year', $request->year);
            }
        }
        $salary = $salary->orderBy('salaryid','desc')->paginate(10);

        $employee  = Employee::where('status', 1)->get()->all();

        return view('hr.salary.viewlockedsalary')->with(compact('salary', 'employee','months'));

    }


    public function viewsalary(){

        $salary = Salary::with('employee')->where('status', 'Unlocked')->orderBy('salaryid','desc')->paginate(10);

        $employee = Employee::where('status', 1)->get()->all();

        return view('hr.salary.viewsalary')->with(compact('salary', 'employee'));

    }

    public function editsalary($id, Request $request){

        $salary = Salary::with('employee')->where('salaryid', $id)->first();
        $allsession='';
        $dutyhours=array();
        $nondutyhours=[];
        $dutyhourssalary=0;
        $nondutyhourssalary=0;
        $ptsessionarray='';
        $ptlogsdisplay='';
        $nondutylogdisplay='';
        $nondutyhoursamount=0;
        $empattandedhours=0;
        if(!empty($salary->ptsessionid)){
            $ptsessionarray = explode (",", $salary->ptsessionid);
            $allsession = Claimptsession::whereIn('claimptsessionid',$ptsessionarray)->get()->all();
        }



        $empdata = Employee::where('employeeid', $salary->employeeid)->first();
        $cal_month = $salary->month;
        $year = $salary->year;

        if($allsession){
            foreach ($allsession as $key => $value) {
                if($value->dutyhours == 1){
                    $dutyhours[]=$value;
                    $dutyhourssalary+=$value->amount;
                }else{
                    $nondutyhours[]=$value;
                    $nondutyhourssalary+=$value->amount;
                }
            }
        }

        if($ptsessionarray){
            /****** for modal popup display *******/
            $ptlogsdisplay=array();
            $nondutylogdisplay=array();
            $ptlogspackages = Claimptsession::whereIn('claimptsessionid',$ptsessionarray)->
            where('trainerid',$salary->employeeid)
//                    ->whereIN('status',['Active','PaidPending'])
                ->whereMonth('actualdate',date('m',strtotime($cal_month)))
                ->whereYear('actualdate',$year)
                ->groupBy('packageid')
                ->orderBy('actualdate','desc')->pluck('packageid')->all();
            DB::enableQueryLog();
            $nondutyhours=Claimptsession::where('trainerid',$empdata->employeeid)->whereIn('status',['Active','PaidPending'])->whereMonth('actualdate',date('m',strtotime($cal_month)))->whereYear('actualdate',$year)->where('dutyhours',0)->get()->all();
//                dd(DB::getQueryLog());
            $nondutyhoursamount = Claimptsession::where('trainerid',$empdata->employeeid)->whereIn('status',['Active','PaidPending'])->whereMonth('actualdate',date('m',strtotime($cal_month)))->whereYear('actualdate',$year)->where('dutyhours',0)->sum('amount');

            foreach ($ptlogspackages as $key => $value) {
                $ptlogscountamt=0;
                $ptlogscount = Claimptsession::whereIn('claimptsessionid',$ptsessionarray)->
                where('trainerid',$empdata->employeeid)
//                        ->whereIN('status',['Active','PaidPending'])
                    ->whereMonth('actualdate',date('m',strtotime($cal_month)))
                    ->whereYear('actualdate',$year)
                    ->where('packageid',$value)
                    ->where('dutyhours',1)
                    ->orderBy('actualdate','desc')->get()->all();
                $persessionamt=0;
                foreach ($ptlogscount as $subkey => $valueptlog) {
                    $persessionamt =$valueptlog->amount;
                    $ptlogscountamt = $ptlogscountamt+$valueptlog->amount;
                }
                $package=MemberPackages::where('memberpackagesid',$value)
                    ->leftjoin('schemes','memberpackages.schemeid','schemes.schemeid')
                    ->get()->first();
                $member=Member::where('userid',$package->userid)
                    ->get(['member.firstname','member.lastname','member.memberpin'])->first();
                $ptlogsdisplay[$key] =  (object) ['property' => 'Here we go'];
                $ptlogsdisplay[$key]->pin = $member->memberpin;
                $ptlogsdisplay[$key]->schemename = $package->schemename;
                $ptlogsdisplay[$key]->firstname = $member->firstname;
                $ptlogsdisplay[$key]->lastname = $member->lastname;
                $ptlogsdisplay[$key]->persessionamt = $persessionamt;
                $ptlogsdisplay[$key]->count=count($ptlogscount);
                $ptlogsdisplay[$key]->ptlogscountamt = $ptlogscountamt;

            }
            if($ptlogsdisplay){
                $ptlogsdisplay=$ptlogsdisplay;
            }

            foreach ($ptlogspackages as $key => $value) {
                $nondutycountamt=0;
                $nondutyptlogscount = Claimptsession::
                where('trainerid',$empdata->employeeid)
                    ->whereIn('status',['Active','PaidPending'])
                    ->whereMonth('actualdate',date('m',strtotime($cal_month)))
                    ->whereYear('actualdate',$year)
                    ->where('packageid',$value)
                    ->where('dutyhours',0)
                    ->orderBy('actualdate','desc')->get()->all();
                foreach ($nondutyptlogscount as $key => $valueptlog) {
                    $nondutycountamt = $nondutycountamt+$valueptlog->amount;
                }
                if($nondutyptlogscount){
                    $package=MemberPackages::where('memberpackagesid',$value)
                        ->leftjoin('schemes','memberpackages.schemeid','schemes.schemeid')
                        ->get()->first();
                    $member=Member::where('userid',$package->userid)
                        ->get(['member.firstname','member.lastname','member.memberpin'])->first();
                    $nondutylogdisplay[$key] =  (object) ['property' => 'Here we go'];
                    $nondutylogdisplay[$key]->pin = $member->memberpin;
                    $nondutylogdisplay[$key]->schemename=$package->schemename;
                    $nondutylogdisplay[$key]->firstname=$member->firstname;
                    $nondutylogdisplay[$key]->lastname=$member->lastname;
                    $nondutylogdisplay[$key]->persessionamt = $persessionamt;
                    $nondutylogdisplay[$key]->count=count($nondutyptlogscount);
                    $nondutylogdisplay[$key]->nondutycountamt = $nondutycountamt;
                }


            }
            if($nondutylogdisplay){
                $nondutylogdisplay=$nondutylogdisplay;
            }
        }
        /***************************/
        $employeeid = $salary->employeeid;


        $month = $salary->month;
        $year = $salary->year;

        if($month == 'Janaury'){
            $cal_month = 1;
        }else if($month == 'February'){
            $cal_month = 2;
        }else if($month == 'March'){
            $cal_month = 3;
        }else if($month == 'April'){
            $cal_month = 4;
        }else if($month == 'May'){
            $cal_month = 5;
        }else if($month == 'June'){
            $cal_month = 6;
        }else if($month == 'July'){
            $cal_month = 7;
        }else if($month == 'August'){
            $cal_month = 8;
        }else if($month == 'September'){
            $cal_month = 9;
        }else if($month == 'October'){
            $cal_month = 10;
        }else if($month == 'November'){
            $cal_month = 11;
        }else{
            $cal_month = 12;
        }

        $day_in_month = cal_days_in_month(CAL_GREGORIAN,$cal_month,$year);
        $fromdate = date('Y-m-d',strtotime("$year-$cal_month-01"));
        $todate = date('Y-m-d',strtotime("$year-$cal_month-$day_in_month"));
        $todate = date('Y-m-d', strtotime("+1 day", strtotime($todate)));

        $accountfine = EmployeeAccount::with('employeename')->where('employeeid', $employeeid)->where('type','Fine')->whereBetween('empaccountdate', [$fromdate, $todate])->orderBy('empaccountid','desc')->paginate(100);

        $account = EmployeeAccount::with('employeename')->where('employeeid', $employeeid)->where('type', '!=' , 'Fine')
            ->whereBetween('empaccountdate', [$fromdate, $todate])->orderBy('empaccountid','desc')->paginate(100);
        $employeelog = HR_device_emplog::where('empid', $employeeid)
            ->whereBetween('dateid', [$fromdate, $todate])->get()->all();

        $empleave = LeaveEntry::where('employeeid', $employeeid)
            ->whereBetween('date', [$fromdate, $todate])
            ->get()->all();
        // $emploanamount = EmployeeAccount::where('employeeid', $employeeid)->orderBy('empaccountid', 'desc')->pluck('amount')->first();
        $emploanamount = EmployeeAccount::where('employeeid', $employeeid)->where('type', '!=' , 'Fine')->whereBetween('empaccountdate', [$fromdate, $todate])->orderBy('empaccountid', 'desc')->first();
        $emploanamountfine = EmployeeAccount::where('employeeid', $employeeid)->where('type','Fine')->whereBetween('empaccountdate', [$fromdate, $todate])->orderBy('empaccountid', 'desc')->first();

        $empdata = Employee::where('employeeid', $employeeid)->first();
        $employeelog_days = HR_device_emplog::where('empid', $employeeid)->whereBetween('dateid', [$fromdate, $todate])->where('timein1','>',0)->groupBy('dateid')->select('dateid')->get()->all();

        $attenddays = count($employeelog_days);

        $totalminute = 0;
        $totalhour = 0;
        $totaldays = 0;
        $givenleave = 0;

        foreach($employeelog as $emplog){

            $difference = ROUND(ABS(strtotime($emplog->timeout1) - strtotime($emplog->timein1))/60);
            $totalminute += abs($difference);

        }

        $totalhour_dispaly_model = round($totalminute/60);

        $totalminute_dispaly = $totalminute;
        /*$hours123 = floor($totalminute / 60);
        $minutes123 = ($totalminute % 60);*/
        //echo $hours123.":".$minutes123;exit;


        $noofleave = Leave::where('employeeid', $employeeid)->first();
        if(!empty($noofleave)){
            $givenleave = $noofleave->noofleave;
        }else{
            $givenleave = 0;
        }

        $paidleave = 0;

        $empleave = LeaveEntry::where('employeeid', $employeeid)
            ->whereBetween('date', [$fromdate, $todate])->get()->all();
        if(!empty($empleave)){
            foreach($empleave as $leaveinfo){
                if($leaveinfo->leavetype == 'Pl'){
                    $paidleave += 1;
                }
            }
        }

        $takenleave = count($empleave);
        $takenleave_display = count($empleave);

        $empdata = Employee::where('employeeid', $employeeid)->first();

        $empsalary = $empdata->salary;
        $empworkinghour = $empdata->workinghour;

        $Workindays = 0;
        $holidays = 0;
        $workingdays_data = WorkingDays::where('year', $year)->where('month', $month)->first();
        if(!empty($workingdays_data)){
            $Workindays = $workingdays_data->workingdays;
            $holidays = $workingdays_data->holidays;
        }else{
            $Workindays = 0;
            $holidays = 0;
        }
        /*****for leave cal******/
        $totalworkindays = $Workindays;

        $leavedays_cal = $totalworkindays - $attenddays;

        /*****End for leave cal******/
        $actualdays = $Workindays - $workingdays_data->holidays ;


        //dd($actualdays);



        if($leavedays_cal < 0){
            $leavedays_cal = 0;
        }

        $empattandedhours=($totalworkindays-$leavedays_cal) * $empworkinghour;

        $totalworkinghour = ($Workindays + $holidays) * $empworkinghour;

        $empworkingminute = ($Workindays + $holidays)  * $empworkinghour * 60;
        $totalminute = $attenddays * $empworkinghour * 60;
        $totalminutedisplay = $totalminute/60;

        $total_hour = ceil($totalminute / 60);


        $takenleave = $Workindays - $attenddays;

        $totalattenddays = $attenddays + $holidays;

        $perdaysalary = ($empsalary/($Workindays + $holidays));

        $current_salary = number_format((float)($perdaysalary * $totalattenddays), 2, '.', '');

        if($current_salary > $empsalary){
            $current_salary = $empsalary;
        }
        if($empdata->role == 'trainer' || $empdata->role == 'Trainer' ){
            $ptlogs=array();
            $ptlogsdisplay=array();
            $nondutylogdisplay=array();
            $trainerdata=Ptassignlevel::where('trainerid',$empdata->employeeid)->leftjoin('ptlevel','ptassignlevel.levelid','ptlevel.id')->get()->first();
            if($trainerdata){
                $trainerlevel=$trainerdata->level;
                $trainerpercentage=$trainerdata->percentage;
                $trainerschemes=[];

                $trainersession=Claimptsession::where('trainerid',$empdata->employeeid)
                    ->where('status','Paid')->whereMonth('actualdate',$cal_month)
                    ->whereYear('actualdate',$year)->where('dutyhours','!=',0)->get()->count();
                $nondutyhours=Claimptsession::where('trainerid',$empdata->employeeid)->where('status','Paid')->whereMonth('actualdate',$cal_month)->whereYear('actualdate',$year)->where('dutyhours',0)->get()->count();
                $nondutyhoursamount = Claimptsession::where('trainerid',$empdata->employeeid)->where('status','Paid')->whereMonth('actualdate',$cal_month)->whereYear('actualdate',$year)->where('dutyhours',0)->sum('amount');

                $trainersessiondetail=Claimptsession::where('trainerid',$empdata->employeeid)
                    ->where('status','Paid')
                    ->whereMonth('actualdate',$cal_month)
                    ->whereYear('actualdate',$year)->orderBy('actualdate','desc')->get()->all();
                foreach ($trainersessiondetail as $key => $value) {

                    $package=MemberPackages::where('memberpackagesid',$value->packageid)
                        ->leftjoin('schemes','memberpackages.schemeid','schemes.schemeid')
                        ->get()->first();
                    $member=Member::where('memberid',$value->memberid)->get(['member.firstname','member.lastname'])->first();

                    $value['schemename']=$package->schemename;
                    $value['firstname']=$member->firstname;
                    $value['lastname']=$member->lastname;


                }
                $ptlogs = Claimptsession::where('trainerid',$empdata->employeeid)->where('status','Paid')
                    ->whereMonth('actualdate',$cal_month)
                    ->whereYear('actualdate',$year)
                    ->orderBy('actualdate','desc')->get()->all();
                foreach($ptlogs as $ptlog){
                    $ptlogcount = 	$trainersessioncount=Claimptsession::where('trainerid',$empdata->employeeid)->where('status','Paid')
                        ->whereMonth('actualdate',$cal_month)
                        ->whereYear('actualdate',$year)
                        ->orderBy('actualdate','desc')
                        ->where('memberid',$ptlog->memberid)->get()->count();
                    $member=Member::where('memberid',$ptlog->memberid)->get(['member.firstname','member.lastname'])->first();
                    $ptlog['schemename']=$package->schemename;
                    $ptlog['firstname']=$member->firstname;
                    $ptlog['lastname']=$member->lastname;
                    $ptlog['count']=$ptlogcount;
                }
                DB::enableQueryLog();
                $ptlogspackages = Claimptsession::
                where('trainerid',$empdata->employeeid)
                    ->where('status','Paid')
                    ->whereMonth('actualdate',$cal_month)
                    ->whereYear('actualdate',$year)
                    ->groupBy('packageid')
                    ->orderBy('actualdate','desc')->pluck('packageid')->all();

                foreach ($ptlogspackages as $key => $value) {
                    $ptlogscountamt=0;
                    $persessionamt=0;
                    $ptlogscount = Claimptsession::
                    where('trainerid',$empdata->employeeid)
                        ->where('status','Paid')
                        ->whereMonth('actualdate',$cal_month)
                        ->whereYear('actualdate',$year)
                        ->where('packageid',$value)
                        ->where('dutyhours',1)
                        ->orderBy('actualdate','desc')->get()->all();
                    foreach ($ptlogscount as $key2 => $valueptlog) {
                        $persessionamt = $valueptlog->amount;
                        $ptlogscountamt = $ptlogscountamt+$valueptlog->amount;
                    }
                    $package=MemberPackages::where('memberpackagesid',$value)
                        ->leftjoin('schemes','memberpackages.schemeid','schemes.schemeid')
                        ->get()->first();
                    $member=Member::where('userid',$package->userid)
                        ->get(['member.firstname','member.lastname','member.memberpin'])->first();
                    $ptlogsdisplay[$key] =  (object) ['property' => 'Here we go'];
                    $ptlogsdisplay[$key]->pin = $member->memberpin;
                    $ptlogsdisplay[$key]->schemename = $package->schemename;
                    $ptlogsdisplay[$key]->firstname = $member->firstname;
                    $ptlogsdisplay[$key]->lastname = $member->lastname;
                    $ptlogsdisplay[$key]->persessionamt = $persessionamt;
                    $ptlogsdisplay[$key]->count = count($ptlogscount);
                    $ptlogsdisplay[$key]->ptlogscountamt = $ptlogscountamt;
                }
                if($ptlogsdisplay){
                    $ptlogsdisplay=$ptlogsdisplay;
                }

                $count = 0;
                foreach ($ptlogspackages as $key => $value) {
                    $nondutycountamt=0;
                    $nondutyptlogscount = Claimptsession::
                    where('trainerid',$empdata->employeeid)
                        ->where('status','Paid')
                        ->whereMonth('actualdate',$cal_month)
                        ->whereYear('actualdate',$year)
                        ->where('packageid',$value)
                        ->where('dutyhours',0)
                        ->orderBy('actualdate','desc')->get()->all();
                    foreach ($nondutyptlogscount as $key => $valueptlog) {
                        $persessionamt = $valueptlog->amount;
                        $nondutycountamt = $nondutycountamt+$valueptlog->amount;
                    }
                    if($nondutyptlogscount){
                        $package=MemberPackages::where('memberpackagesid',$value)
                            ->leftjoin('schemes','memberpackages.schemeid','schemes.schemeid')
                            ->get()->first();
                        $member=Member::where('userid',$package->userid)
                            ->get(['member.firstname','member.lastname','member.memberpin'])->first();
                        $nondutylogdisplay[$count] =  (object) ['property' => 'Here we go'];
                        $nondutylogdisplay[$count]->pin = $member->memberpin;
                        $nondutylogdisplay[$count]->schemename=$package->schemename;
                        $nondutylogdisplay[$count]->firstname=$member->firstname;
                        $nondutylogdisplay[$count]->lastname=$member->lastname;
                        $nondutylogdisplay[$count]->persessionamt = $persessionamt;
                        $nondutylogdisplay[$count]->count=count($nondutyptlogscount);
                        $nondutylogdisplay[$count]->nondutycountamt = $nondutycountamt;
                        $count++;
                    }


                }
                if($nondutylogdisplay){
                    $nondutylogdisplay=$nondutylogdisplay;
                }

                $trainerdetail=[];
                $trainerdetail['trainerlevel'] = $trainerlevel;
                $trainerdetail['trainerpercentage'] = $trainerpercentage;
                $trainerdetail['trainershemes'] = $trainersessiondetail;

                $perhoursalary = $perdaysalary / $empworkinghour;
                $totalsessionprice=0;

                $current_salary = $current_salary - ($perhoursalary*$trainersession);

                foreach($trainerdetail['trainershemes'] as $schemedetail)
                {
                    $totalsessionprice += $schemedetail->amount;
                }
                if($nondutyhoursamount){
                    $current_salary = $current_salary + $nondutyhoursamount;
                }
                $current_salary = $current_salary + $totalsessionprice;
                $current_salary = round($current_salary ,  2);

                $allsessionprice = $totalsessionprice;
                // dd($current_salary);
            }else{
                Session::flash('message', 'Please assign level to trainer ');
                Session::flash('alert-type', 'error');
                return redirect()->route('assignptlevel');
            }

        }
//		if($empdata->role == 'trainer' || $empdata->role == 'Trainer' ){
//           $trainersession=Claimptsession::where('trainerid',$empdata->employeeid)->where('status','Paid')->whereMonth('actualdate',$cal_month)->whereYear('actualdate',$year)->where('dutyhours','!=',0)->get()->count();
//           $trainersession=$attenddays;
//        }
        else{
            $dutyhourssalary = 0;
            $trainerdetail =[];
            $trainersession = 0;
            $allsessionprice = 0;
            $trainersessiondetail = [];
            $ptlogs = array();
            $ptlogsdisplay = array();
            $nondutylogdisplay = array();
            $current_salary = $empsalary;
        }
        $roleid= $empdata->roleid;

        // dd($empdata);
        if (in_array($roleid,[5,6])){
            $dutyhourssalary = 0;
            $trainerdetail =[];
            $trainersession =0;
            $allsession=0;
            $dutyhours = array();
            $ptlogs = array();
            $ptlogsdisplay=array();
            $nondutylogdisplay=array();
        }

        //GET LOAN //
        $loandetail = HR_Loandetail::select('hr_loan.*','hr_loandetail.*')->leftjoin('hr_loan','hr_loan.hr_loan_id','hr_loandetail.hr_loan_id')->where('hr_loan.type','Loan')->where('hr_loandetail.salary_id',$salary->salaryid)->where('hr_loandetail.status','Pending')->get()->all();

        $finedetail = HR_Loandetail::select('hr_loan.*','hr_loandetail.*')->leftjoin('hr_loan','hr_loan.hr_loan_id','hr_loandetail.hr_loan_id')->where('hr_loan.type','Fine')->where('hr_loandetail.salary_id',$salary->salaryid)->where('hr_loandetail.status','Pending')->get()->all();

        if($request->isMethod('POST')){
            $request->validate([

                'attenddays_display' => 'required|numeric',
                'takenleave_display' => 'required|numeric',
                'casualleave' => 'nullable|numeric',
                'medicalleave' => 'nullable|numeric',
                'paidleave' => 'nullable|numeric',
                'current_salary' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',

            ]);

            DB::beginTransaction();
            try {
                $oldempaccount = EmployeeAccount::where('employeeid', $request->employeeid)->where('salaryid',$salary->salaryid)->get()->all();
                foreach ($oldempaccount as $key => $value) {
                    $value->delete();
                }

                $loanid = $request->Loan_loanid;
                $loan_amount = $request->Loan_amount;
                if(!empty($loanid)) {
                    for ($i = 0; $i < count($loanid); $i++) {
                        $loan_detail = HR_Loandetail::FindOrFail($loanid[$i]);
                        $loan_detail->amount = $loan_amount[$i];
                        $loan_detail->action_by = session()->get('admin_id');
                        $loan_detail->save();
                    }
                }
                $fine_loanid = $request->Fine_loanid;
                $fine_amount = $request->Fine_amount;
                if(!empty($fine_loanid)) {
                    for ($i = 0; $i < count($fine_loanid); $i++) {
                        $loan_detail = HR_Loandetail::FindOrFail($fine_loanid[$i]);
                        $loan_detail->amount = $fine_amount[$i];
                        $loan_detail->action_by = session()->get('admin_id');
                        $loan_detail->save();
                    }
                }

//			if($request->emi > 0){
//
//				$empaccount = EmployeeAccount::where('employeeid', $request->employeeid)->where('type', '!=' , 'Fine')->orderBy('empaccountid', 'desc')->first();
//
//				if(!empty($empaccount)){
//
//					$empamount = $empaccount->amount;
//					if($empamount > 0 || $empamount >= $request->emi){
//						$finalamount = $empamount - $request->emi;
//
//						$newempaccount = new EmployeeAccount();
//						$newempaccount->employeeid = $request->employeeid;
//						$newempaccount->amount = $finalamount;
//						$newempaccount->type = 'EMI';
//						$newempaccount->enteramount =  $request->emi;
//							$newempaccount->remark =  $request->remark;
//
//						$newempaccount->empaccountdate = date('Y-m-d');
//						$newempaccount->actionby = session()->get('admin_id');
//						$newempaccount->save();
//
//					    }
//
//				    }
//                }
//
//			if($request->emi2 > 0){
//
//				$empaccount = EmployeeAccount::where('employeeid', $request->employeeid)->where('type','Fine')->orderBy('empaccountid', 'desc')->first();
//
//				if(!empty($empaccount)){
//
//					$empamount = $empaccount->amount;
//					if($empamount > 0 || $empamount >= $request->emi2){
//						$finalamount = $empamount - $request->emi2;
//
//						$newempaccount = new EmployeeAccount();
//						$newempaccount->employeeid = $request->employeeid;
//						$newempaccount->amount = $finalamount;
//						$newempaccount->type = 'Fine';
//						$newempaccount->enteramount =  $request->emi2;
//							$newempaccount->remark =  $request->remark;
//
//						$newempaccount->empaccountdate = date('Y-m-d');
//						$newempaccount->actionby = session()->get('admin_id');
//						$newempaccount->save();
//
//                    }	}
//
//                    }

                //******* PT Session ***********//
                $tsessionsalary=[];
                $tsessionsalarystring='';

                $trainersession = Claimptsession::where('trainerid',$employeeid)->whereIN('status',['Active','PaidPending'])->whereMonth('actualdate', date('m',strtotime($salary->month)))->whereYear('actualdate',$salary->year)->get()->count();
//                    DB::enableQueryLog();
                $trainersessiondetail = Claimptsession::where('trainerid',$employeeid)->whereIN('status',['Active','PaidPending'])->whereMonth('actualdate', date('m',strtotime($salary->month)))->whereYear('actualdate',$salary->year)->orderBy('actualdate','asc')->get()->all();
//                    dd(DB::getQueryLog());

                foreach($trainersessiondetail as $tsession){
                    $tsession->status = "PaidPending";
                    $tsession->save();
                    $sessionpt=Ptmember::where('date',$tsession->scheduledate)->where('hoursfrom',$tsession->scheduletime)->get()->first();

                    $sessionpt->status = "PaidPending";
                    $sessionpt->save();
                    array_push($tsessionsalary,$tsession->claimptsessionid);
                }

                if(count($tsessionsalary) > 0){
                    $tsessionsalarystring = implode (",", $tsessionsalary);
                }
                //******* End PT Session ***********//

                $salary->employeeid = $request->employeeid;
                $salary->workingdays = $request->workingdays_display;
                $salary->attenddays = $request->attenddays_display;
                $salary->actualdays = $request->actualdays_display;
                $salary->totalminute = $request->workingminute;
                $salary->empworkingminute = $request->empworkingminute;
                $salary->empworkinghour = $request->monthlyworking_hour_display;
                $salary->extrahoursalary = $request->extrahoursalary;
                $salary->extrahour = $request->extrahour;
                $salary->totalhour = $request->totalworkinghour_display;
                $salary->givenleave = $request->givenleave;
                $salary->takenleave = $request->takenleave_display;
                $salary->empsalary = $request->empsalary;
                $salary->currentsalary = $request->current_salary;
                $salary->holidays = $request->holidays;
                $salary->bonus = $request->bonus;
                $salary->casualleave = !empty($request->casualleave) ? $request->casualleave : 0;
                $salary->medicalleave = !empty($request->medicalleave) ? $request->medicalleave : 0;
                $salary->paidleave = !empty($request->paidleave) ? $request->paidleave : 0;
                $salary->year = $request->year;
                $salary->month = $request->month_display;
                $salary->salaryemi = $request->emi;
                $salary->salaryemi2 = $request->emi2;
                $salary->salaryothercharges = $request->otheramount;
                $salary->salarydeductedamount = $request->deductedamount;
                $salary->loanfine = $request->loanfine;
                $salary->loanamount = $request->loan;
                $salary->remark = $request->remark;
                $salary->ptsessionid = $tsessionsalarystring;
                $salary->ptsessionsalary = $request->totalsessionprice;
                $salary->status = 'Unlocked';
                $salary->actionby = session()->get('admin_id');

                $salary->save();

                DB::commit();
                $success = true;

                Session::flash('message', 'Employee Salary is updated');
                Session::flash('alert-type', 'success');

                return redirect()->route('viewsalary');

            } catch(\Exception $e) {
                dd($e);
                Helper::errormail('HR', 'Edit Salary', 'High');

                DB::rollback();
                $success = false;
            }

            if($success == false){
                return redirect('dashboard');
            }


        }

        return view('hr.salary.editsalary')->with(compact('salary','account','accountfine','emploanamountfine','empleave','trainersession', 'employeelog','emploanamount','allsession','dutyhours','nondutyhours','dutyhourssalary','nondutyhourssalary','ptlogsdisplay','nondutylogdisplay','roleid','empworkinghour','loandetail','finedetail','nondutyhoursamount','trainerdetail','empworkinghour','Workindays','holidays','empsalary','trainersession','empattandedhours','allsessionprice','current_salary'));

    }

    public function locksalary($id){

        $salary = Salary::findOrfail($id);

        DB::beginTransaction();
        try {

            $salary->status = 'Locked';
            $salary->save();

            DB::commit();
            $success = true;

            Session::flash('message', 'Employee Salary is locked');
            Session::flash('alert-type', 'success');

            return redirect()->route('viewlockedsalary');

        } catch(\Exception $e) {

            Helper::errormail('HR', 'Lock Salary', 'High');

            DB::rollback();
            $success = false;
        }

        if($success == false){

            return redirect('dashboard');
        }

    }

    public function unlocksalary($id){

        $salary = Salary::findOrfail($id);

        DB::beginTransaction();
        try {
            $salary->status = 'Unlocked';
            $salary->save();
            DB::commit();
            $success = true;
            Session::flash('message', 'Employee Salary is Unlocked');
            Session::flash('alert-type', 'success');

            return redirect()->route('viewsalary');

        } catch(\Exception $e) {

            Helper::errormail('HR', 'Unlock Salary', 'High');

            DB::rollback();
            $success = false;
        }

        if($success == false){

            return redirect('dashboard');
        }

    }

    public function confirmsalary(Request $request){

        $accountno = $request->accountno;
        $empname = $request->empname;
        $empid = $request->empid;
        $salaryid = $request->salaryid;

        DB::beginTransaction();
        try {
            $salary = Salary::findOrfail($salaryid);
            $salary->accountno = $accountno;
            $salary->ispaid = 1;
//		$emi = $salary->salaryemi;
            $employeeid = $salary->employeeid;
            $salary->paymenttype = $request->paymenttype;
            $salary->Chequeno = $request->Chequeno;
            $salary->remark2 = $request->remark2;

            $salary->paidby = session()->get('admin_id');
            $salary->paiddate = date('Y-m-d');
            $salary->save();

            //*******PT Session Update*****//
            if(!empty($salary->ptsessionid)){
                $ptsessionarray = explode (",", $salary->ptsessionid);
                $allsession = Claimptsession::whereIn('claimptsessionid',$ptsessionarray)->update(['status'=>'Paid']);
            }
            //******* End PT Session Update*****//

            $loandetail = HR_Loandetail::where('salary_id',$salaryid)->get()->all();
            foreach ($loandetail as $value){
                $hr_loan = HR_Loan::FindOrFail($value->hr_loan_id);
                $hr_loan->paid_amount = $hr_loan->paid_amount + $value->amount;
                $hr_loan->due_amount = $hr_loan->due_amount - $value->amount;
                $hr_loan->save();

                $hr_loandetail = HR_Loandetail::FindOrFail($value->hr_loandetail_id);
                $hr_loandetail->status = 'Active';
                $hr_loandetail->save();
            }

//		if($emi > 0){
//
//				$empaccount = EmployeeAccount::where('employeeid', $employeeid)->orderBy('empaccountid', 'desc')->first();
//
//				if(!empty($empaccount)){
//
//					$empamount = $empaccount->amount;
//					if($empamount > 0 || $empamount >= $emi){
//						$finalamount = $empamount - $emi;
//
//						$newempaccount = new EmployeeAccount();
//						$newempaccount->employeeid = $employeeid;
//						$newempaccount->amount = $finalamount;
//						$newempaccount->type = 'EMI';
//						$newempaccount->empaccountdate = date('Y-m-d');
//						$newempaccount->actionby = session()->get('admin_id');
//						$newempaccount->save();
//
//					}
//
//				}
//
//			}
            DB::commit();
            return 201;
        } catch(\Exception $e) {

            DB::rollback();
            dd($e);
        }
    }

    public function viewlockedsalarysearch(Request $request){

        $employeeid = $request->employeeid;
        $month = $request->month;
        $year = $request->year;

        $salary = Salary::where('employeeid', $employeeid)->where('month', $month)->where('year', $year)->paginate(10);
        $employee  = Employee::where('status', 1)->get()->all();

        return view('hr.salary.viewlockedsalary')->with(compact('salary', 'employee', 'employeeid', 'month', 'year'));

    }

    public function searchsalary(Request $request){

        $employeeid = Input::get('employeeid');
        $year = Input::get('year');
        $month = Input::get('month');

        $salary = Salary::where('employeeid', $employeeid)->where('month', $month)->where('year', $year)->paginate(10);
        $employee  = Employee::where('status', 1)->get()->all();
        /*dd($salary->month);*/

        return view('hr.salary.viewsalary')->with(compact('salary', 'employee', 'employeeid', 'year', 'month'));


    }

    //////////////////////////////////////////// salary end   //////////////////////////////////////////////////




///////////////////////////////////// Employee Leave start //////////////////////////////////////////////////////////////

    public function employeeleave(Request $request){



        if($request->isMethod('post')){

            $request->validate([

                'employeeid' =>  'required',
                'fromdate' =>  'required',
                'todate' =>  'required',
                'reason' =>  'nullable|max:255',

            ]);


            $employeeid = $request->employeeid;
            $leavecount = 0;
            $totalleave = 0;

            $empleave = Leave::where('employeeid', $employeeid)->first();
            if(empty($empleave)){
                $employee = $request->employeeid;
                $employee  = Employee::where('status', 1)->get()->all();

                Session::flash('message', 'Please add employee leave');
                Session::flash('alert-type', 'error');

                return redirect()->route('leave')->with(compact('employee'));
            }else{
                $totalleave = $empleave->noofleave;
            }


            $leavecount  = EmployeeLeave::where('employeeid', $employeeid)->whereIN('leavetype',['Cl','Pl','Ml'])->get()->all();
            $leavehalfcount  = EmployeeLeave::where('employeeid', $employeeid)->where('leavetype','Hl')->get()->count();
            $leavecount = count($leavecount) + ($leavehalfcount/2);


            if($leavecount > $totalleave){
                return back()->with('error', 'You can not add leave as Employee leaves are already used!');
            }

            $existleave = EmployeeLeave::where('employeeid', $employeeid)->where('date', date('Y-m-d', strtotime($request->leavedate)))->first();
            if(!empty($existleave)){
                return back()->withInput()->with('error', 'You can not add same leave!');

            }

            DB::beginTransaction();
            try {
                $end_date = date('Y-m-d', strtotime($request->todate));
                $date = date('Y-m-d', strtotime($request->fromdate));
                while (strtotime($date) <= strtotime($end_date)) {
                    $employeeleave = new EmployeeLeave();
                    $employeeleave->employeeid = $employeeid;
                    $employeeleave->date = $date;
                    $employeeleave->leavetype = $request->leavetype;
                    $employeeleave->reason = !empty($request->reason) ? $request->reason : null;
                    $employeeleave->actionby = session()->get('admin_id');
                    $employeeleave->Save();

                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date))); // for date vise looping
                }

                DB::commit();
                $success = true;

                Session::flash('message', 'Employee leave is added successfully');
                Session::flash('alert-type', 'success');

                return redirect()->route('viewemployeeleave')->with('success', 'Employee leave is added successfully.');

            } catch(\Exception $e) {

                Helper::errormail('HR', 'Add Employee Leave', 'High');

                DB::rollback();
                $success = false;
            }

            if($success == false){
                return redirect('dashboard');
            }



        }


        $employee = Employee::where('status', 1)->get()->all();

        return view('hr.employeeleave.addemployeeleave')->with(compact('employee'));



    }

    public function editemployeeleave($id, Request $request){

        $empleave = EmployeeLeave::where('employeeleaveid', $id)->first();

        $empexpirydate = Leave::where('employeeid', $empleave->employeeid)->first();

        if(!empty($empexpirydate)){

            $expirydate = $empexpirydate->expirydate;

        }else{

            $expirydate='';
        }

        if($request->isMethod('post')){

            $request->validate([

                'leavedate' =>  'required',
                'reason' =>  'nullable|max:255',

            ]);

            $employeeid = $empleave->employeeid;

            $existleave = EmployeeLeave::where('employeeid', $employeeid)->where('date', date('Y-m-d', strtotime($request->leavedate)))->where('employeeleaveid', '!=', $id)->first();
            if(!empty($existleave)){
                return back()->with('error', 'You can not add same leave!');

            }

            DB::beginTransaction();
            try {

                $empleave->date =  date('Y-m-d', strtotime($request->leavedate));
                $empleave->reason =  !empty($request->reason) ? $request->reason : null;
                $empleave->leavetype = $request->leavetype;
                $empleave->actionby = session()->get('admin_id');
                $empleave->Save();

                DB::commit();
                $success = true;

                Session::flash('message', 'Employee leave is updated successfully');
                Session::flash('alert-type', 'success');

                return redirect()->route('viewemployeeleave')->with('success', 'Employee leave is updated successfully');

            } catch(\Exception $e) {

                Helper::errormail('HR', 'Edit Employee Leave', 'High');

                DB::rollback();
                $success = false;
            }

            if($success == false){
                return redirect('dashboard');
            }



        }


        $employee = Employee::where('status', 1)->get()->all();

        return view('hr.employeeleave.editemployeeleave')->with(compact('empleave', 'employee', 'expirydate'));






    }

    public function viewemployeeleave(){

        $employeeleave = EmployeeLeave::with('empname')->paginate(10);
        $employee = Employee::where('status', 1)->get()->all();

        return view('hr.employeeleave.viewemployeeleave')->with(compact('employeeleave', 'employee'));


    }

    public function searchemployeeleave(Request $request){

        $employeeid = $request->employeeid;

        $employeeleave = EmployeeLeave::where('employeeid', $employeeid)->get()->all();
        $employee = Employee::where('status', 1)->get()->all();

        return view('hr.employeeleave.viewemployeeleave')->with(compact('employeeleave', 'employee', 'employeeid'));

    }

    public function empexpirydate(){

        $empid = $_REQUEST['empid'];

        $empexpirydate = Leave::where('employeeid', $empid)->first();
        //dd($empexpirydate);

        if(!empty($empexpirydate)){

            $expirydate = $empexpirydate->expirydate;

            return $expirydate;

        }else{

            return 'leavenotfound';

        }



    }



    public function deleteemployeeleave($id){

        DB::beginTransaction();
        try {

            $empexpirydate = EmployeeLeave::where('employeeleaveid', $id)->first();
            if($empexpirydate){
                $empexpirydate->delete();
            }


            DB::commit();
            $success = true;

            return redirect()->route('viewemployeeleave')->with('error', 'Employee leave is deleted');

        } catch(\Exception $e) {

            Helper::errormail('HR', 'Delete Employee Leave', 'High');

            DB::rollback();
            $success = false;
        }

        if($success == false){
            return redirect('dashboard');
        }


    }

    public function employeelogdaywise(Request $request){

        $employee = Employee::where('status', 1)->get()->all();

        return view('hr.employeelog.viewemployeelogdaywise')->with(compact('employee'));

    }

    public function searchemployeelogdaywise(Request $request){

        if ($request->ajax()) {
            $employeeid = $request->employeeid;
            $year = date('Y',strtotime($request->fromdate));
            $month = date('m',strtotime($request->fromdate));

            $cal_month = date('m',strtotime($request->fromdate));

            // $fromdate = date('Y-m-d',strtotime("$year-$cal_month-01"));
            // $todate = date('Y-m-d',strtotime("$year-$cal_month-$day_in_month"));


            if(!empty($employeeid) || !empty($year) || !empty($month)){
                $fromdate = $request->fromdate;
                $todate = $request->todate;
                $day_in_month = cal_days_in_month(CAL_GREGORIAN,$cal_month,$year);
                // $fromdate = date('Y-m-d',strtotime("$year-$cal_month-01"));
                // $todate = date('Y-m-d',strtotime("$year-$cal_month-$day_in_month"));

                $searchparameter = ['employeeid' => $employeeid, 'month' => $month, 'year' => $year];
                DB::enableQueryLog();

                $employeelog = HR_device_emplog::with('empname')->where('empid','>',0);

                if($employeeid){
                    $employeelog->where('empid', $employeeid);
                }
                if($fromdate || $todate){
                    $employeelog->whereBetween('dateid', [$fromdate, $todate]);
                }

                $employeelog =$employeelog->orderBy('dateid','desc')->get();
                return datatables()->of($employeelog)

                    ->addColumn('employee', function($employeelog){
                        return $employeelog->employee = $employeelog->empname->first_name.' '.$employeelog->empname->last_name;
                    })
                    ->editColumn('dateid', function($employeelog){
                        return $employeelog->dateid = date("d-m-Y", strtotime($employeelog->dateid));

                    })->editColumn('timein1', function($employeelog){
                        if(!empty($employeelog->timein1)){
                            return $employeelog->timein1;
                        }else{
                            if(session()->get('logged_role') == 'Admin'){

                                //return "<a href=".route('addpunch', $employeelog->emplogid)." class='btn btn-danger'>Miss</a>";
                            }else{
                                //return "<a class='btn btn-danger' disabled title='Dare to edit this'>Miss</a>";
                            }
                        }

                    })->editColumn('timeout1', function($employeelog){
                        if(!empty($employeelog->timeout1)){
                            return $employeelog->timeout1;
                        }else{
                            if(session()->get('logged_role') == 'Admin'){

                                //return "<a href=".route('addpunch', $employeelog->emplogid)." class='btn btn-danger'>Miss</a>";
                            }else{
                                //return "<a class='btn btn-danger' disabled title='Dare to edit this'>Miss</a>";
                            }
                        }

                    })->editColumn('timein2', function($employeelog){
                        if(!empty($employeelog->timein2)){
                            return $employeelog->timein2;
                        }else{
                            if(session()->get('logged_role') == 'Admin'){

                                //return "<a href=".route('addpunch', $employeelog->emplogid)." class='btn btn-danger'>Miss</a>";
                            }else{
                                //return "<a class='btn btn-danger' disabled title='Dare to edit this'>Miss</a>";
                            }
                        }

                    })->editColumn('timeout2', function($employeelog){
                        if(!empty($employeelog->timeout2)){
                            return $employeelog->timeout2;
                        }else{
                            if(session()->get('logged_role') == 'Admin'){

                                //return "<a href=".route('addpunch', $employeelog->emplogid)." class='btn btn-danger'>Miss</a>";
                            }else{
                                //return "<a class='btn btn-danger' disabled title='Dare to edit this'>Miss</a>";
                            }
                        }

                    })->editColumn('timein3', function($employeelog){
                        if(!empty($employeelog->timein3)){
                            return $employeelog->timein3;
                        }else{
                            if(session()->get('logged_role') == 'Admin'){

                                //return "<a href=".route('addpunch', $employeelog->emplogid)." class='btn btn-danger'>Miss</a>";
                            }else{
                                //return "<a class='btn btn-danger' disabled title='Dare to edit this'>Miss</a>";
                            }
                        }

                    })
                    ->editColumn('timeout3', function($employeelog){
                        if(!empty($employeelog->timeout3)){
                            return $employeelog->timeout3;
                        }else{
                            if(session()->get('logged_role') == 'Admin'){

                                //return "<a href=".route('addpunch', $employeelog->emplogid)." class='btn btn-danger'>Miss</a>";
                            }else{
                                //return "<a class='btn btn-danger' disabled title='Dare to edit this'>Miss</a>";
                            }
                        }

                    })
                    ->escapeColumns([])
                    ->make(true);

                //$employee = Employee::where('status', 1)->get()->all();


                //$employeelog->appends(array('employeeid' => $employeeid, 'year' => $year, 'month' => $month));


                //return view('hr.employeelog.viewemployeelog')->with(compact('employeeid', 'year', 'month', 'employeelog', 'employee', 'searchparameter'));

            }
        }
    }






///////////////////////////////////// Employee Leave End ////////////////////////////////////////////////////////////////


////////////////////////////////////////// import punch /////////////////////////////////////////////////////////////
    public function importpunch(Request $request){


        $employee = Employee::where('status', 1)->get()->all();

        return view('hr.employeelog.importpunch')->with(compact('employee'));

    }


    public function downloaddemosheet(Request $request){


        if($request->isMethod('POST')){


            $employeeid = $request->employeeid;
            $month = $request->month;
            $year = $request->year;

            ExcelExport::truncate();
            /*$excel = ExcelExport::all();
            if(!empty($excel)){
                foreach($excel as $e){
                    ExcelExport::where('excelexportid', $e->excelexportid)->delete();
                }
            }*/

            $fullname = '';

            if($employeeid && $month && $year){

                $empdetail = Employee::where('employeeid', $employeeid)->first();
                if(!empty($empdetail)){

                    $fullname = ucfirst($empdetail->first_name).' '.ucfirst($empdetail->last_name);
                }
                if($request->month == 'January'){
                    $cal_month = 1;
                }else if($request->month == 'February'){
                    $cal_month = 2;
                }else if($request->month == 'March'){
                    $cal_month = 3;
                }else if($request->month == 'April'){
                    $cal_month = 4;
                }else if($request->month == 'May'){
                    $cal_month = 5;
                }else if($request->month == 'June'){
                    $cal_month = 6;
                }else if($request->month == 'July'){
                    $cal_month = 7;
                }else if($request->month == 'August'){
                    $cal_month = 8;
                }else if($request->month == 'September'){
                    $cal_month = 9;
                }else if($request->month == 'October'){
                    $cal_month = 10;
                }else if($request->month == 'November'){
                    $cal_month = 11;
                }else{
                    $cal_month = 12;
                }

                $day_in_month = cal_days_in_month(CAL_GREGORIAN,$cal_month,$year);
                $fromdate = date('Y-m-d',strtotime("$year-$cal_month-01"));
                $todate = date('Y-m-d',strtotime("$year-$cal_month-$day_in_month"));

                $export_array = [];

                for($i = 1; $i<= $day_in_month; $i++){

                    $current_date = date('Y-m-d',strtotime("$year-$cal_month-$i"));

                    $excel = new ExcelExport();

                    $current_date;
                    $excel->dateid = $current_date;
                    $excel->empid = $employeeid;
                    $excel->timein1 = '00:00:00';
                    $excel->timeout1 = '00:00:00';
                    $excel->timein2 = '00:00:00';
                    $excel->timeout2 ='00:00:00';
                    $excel->timein3 ='00:00:00';
                    $excel->timeout3 = '00:00:00';
                    $excel->type = '';
                    $excel->leave = '';
                    $excel->totalworkinghours = '';
                    $excel->salary = '';
                    $excel->save();

                }

                $isexport = 1;
                $employee = Employee::where('status', 1)->get()->all();
                $employee_name = $fullname.'-'.$request->month.'-'.$request->year.'.csv';

                Session::flash('downloadexcel', 'downloadexcel');
                Session::put('empname', $employee_name);

                Session::flash('message', 'Employee sheet will download shortly');
                Session::flash('alert-type', 'success');

                //return Excel::download(new EmployeeExport(),'user.csv');

                //return view('hr.employeelog.importpunch')->with(compact('employee', 'employeeid', 'month', 'year', 'isexport'));

                return redirect()->route('importpunch');

            }
        }

    }

    public function downloadexcel(){

        $empname = session()->get('empname');
        $grid=ExcelExport::get()->all();
        $employeename='';

        if($grid){

            $student_array[] = array('dateid','Employeeid','timein1','timeout1','timein2','timeout2','timein3','timeout3','type','leave','totalworkinghours','salary');

            foreach ($grid as $student)
            {

                $student_array[] = array(
                    'dateid' =>$student->dateid,
                    'empid' =>$student->empid,
                    'timein1' => $student->timein1,
                    'timeout1' => $student->timeout1,
                    'timein2' => $student->timein2,
                    'timeout2' =>$student->timeout2,
                    'timein3' =>$student->timein3,
                    'timeout3'=>$student->timeout3,
                    'type'=>$student->type,
                    'leave'=>$student->leave,
                    'totalworkinghours' => $student->totalworkinghours,
                    'salary'=>$student->salary,

                );

            }

            Excel::create($empname, function($excel) use ($student_array) {
                $excel->sheet('mySheet', function($sheet) use ($student_array)
                {

                    $sheet->fromArray($student_array);

                });
            })->export('csv');

        }

    }



    public function importemppunchcsv(Request $request){

        $request->validate([

            'file' => 'required'

        ]);

        $file = $request->file('file');

        // File Details
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $path = $file->getRealPath();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();

        $valid_extension = array("csv");

        $maxFileSize = 2097152;

        // Check file extension
        if(in_array(strtolower($extension),$valid_extension)){

            // Check file size
            if($fileSize <= $maxFileSize){

                $data = array_map('str_getcsv', file($path));

                foreach($data as $key => $csv_data){
                    if($key > 1){
                        $dateid= $csv_data[0];
                        $empid = $csv_data[1];
                        $empdate = $csv_data[0];
                        $timein1 = $csv_data[2];
                        $timeout1 = $csv_data[3];
                        $timein2 = $csv_data[4];
                        $timeout2 = $csv_data[5];
                        $timein3 = $csv_data[6];
                        $timeout3 = $csv_data[7];


                        if(!empty($empid) && is_numeric($empid) && !empty($empdate) && strtotime($empdate) && !empty($timein1) &&  !empty($timeout1)){

                            $employeelog_exist = HR_device_emplog::where('empid', $empid)->where('dateid', date('Y-m-d', strtotime($empdate)))->first();

                            if(empty($employeelog_exist)){

                                $employeelog = new HR_device_emplog();
                                $employeelog->dateid = date('Y-m-d', strtotime($empdate));
                                $employeelog->empid = $empid;
                                $employeelog->timein1 = $csv_data[2];
                                $employeelog->timeout1 =$csv_data[3];
                                $employeelog->timein2 = $csv_data[4];
                                $employeelog->timeout2 =$csv_data[5];
                                $employeelog->timein3= $csv_data[6];
                                $employeelog->timeout3 =$csv_data[7];
                                $employeelog->save();

                            }else{
                                $employeelog_exist->delete();

                                $employeelog = new HR_device_emplog();
                                $employeelog->dateid = date('Y-m-d', strtotime($empdate));
                                $employeelog->empid = $empid;
                                $employeelog->timein1 = $csv_data[2];
                                $employeelog->timeout1 =$csv_data[3];
                                $employeelog->timein2 = $csv_data[4];
                                $employeelog->timeout2 =$csv_data[5];
                                $employeelog->timein3= $csv_data[6];
                                $employeelog->timeout3 =$csv_data[7];
                                $employeelog->save();

                            }
                        }
                        /**********************for calculate working hours*******************************/
                        //   $sumdiff =0;
                        //   $total=0;

                        // 		for ($i=1;$i<=3;$i++){
                        // 			// if($employeelog->totalworkinghours > 0){
                        // 			// 	$sumdiff =	$employeelog->totalworkinghours;

                        // 			// }

                        // 			$ts1 = Carbon::parse($employeelog['timein'.$i]);

                        // 			$ts2 = Carbon::parse($employeelog['timeout'.$i]);
                        // 			$diff=$ts2->diff($ts1)->format('%H:%I:%S');
                        // 			// $difference = round(abs($ts2 - $ts1) / 3600,2);
                        // 			if($diff > 0){
                        // 				$sumdiff =  strtotime($employeelog->totalworkinghours) + strtotime($diff);


                        // 				$sumdiff = strtotime($employeelog->totalworkinghours) + strtotime($total);
                        // 				$total =   date('h:i:s',$sumdiff);
                        // 			}

                        // 			}

                        // 	   $employeelog->totalworkinghours = 	$total ;
                        // 	   $employeelog->save();

                        /*********************End for calculate working hours***************************/

                    }
                }

                Session::flash('message', 'Employee punch is added successfully');
                Session::flash('alert-type', 'success');

                return redirect()->back();

            }

        }

    }
    ////////////////////////////////////////// import punch end/////////////////////////////////////////////////////////////

    /***************************** Salary Slip ************************************** */
    public function printsalaryslip($id){

        $salary=Salary::select('hr_salary.*')->selectRaw('SUM(hr_loandetail.amount) as paidloan')->leftjoin('hr_loandetail',function($join)
        {
            $join->on('hr_loandetail.salary_id', '=', 'hr_salary.salaryid');
            $join->on('hr_loandetail.type', '=', DB::raw('"Credit"'));
            $join->on('hr_loandetail.status', '=', DB::raw('"Active"'));
        })->where('hr_salary.salaryid',$id)->get();
        $salary = $salary[0];
        $employee=Employee::where('employeeid',$salary->employeeid)->get()->first();
        $employeefullname=ucfirst($employee->first_name).' '.ucfirst($employee->last_name);
        $pdf = PDF::loadView('hr.salary.salaryslip', compact('salary','employeefullname'));

        return $pdf->stream('Salary Slip.pdf');
    }
    /********************************************************************/
    public function getpunchrecord(Request $request){
        $punchdate=$request->punchdate;
        $empid = $request->empid;
        $result=HR_device_emplog::where('empid',$empid)->where('dateid',$punchdate)->get()->first();
        return $result;
    }


}
