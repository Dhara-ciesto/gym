<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\LeaveEntry;
use App\Leave;
use App\EmployeeLeave;
use DB;
use Session;

class EmployeeLeaveController extends Controller
{
    public function addleave(Request $request)
    {
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

				Session::flash('error', 'Please add employee leave');
				Session::flash('alert-type', 'error');
				return redirect()->route('viewleaveentry')->with(compact('employee'));
			}else{

				$totalleave = $empleave->noofleave;
			}

            $leavecount  = LeaveEntry::where('employeeid', $employeeid)->whereIN('leavetype',['Cl','Pl','Ml'])->get()->all();
            $leavehalfcount  = LeaveEntry::where('employeeid', $employeeid)->where('leavetype','Hl')->get()->count();
            $leavecount = count($leavecount) + ($leavehalfcount/2);


			if($leavecount > $totalleave){
				return back()->with('error', 'You can not add leave as Employee leaves are already used!');
			}

			$existleave = LeaveEntry::where('employeeid', $employeeid)
            ->where('date', date('Y-m-d', strtotime($request->leavedate)))->first();
			if(!empty($existleave)){
				return back()->withInput()->with('error', 'You can not add same Day leave!');

			}

			DB::beginTransaction();
			try {
                $end_date = date('Y-m-d', strtotime($request->todate));
                $date = date('Y-m-d', strtotime($request->fromdate));
                while (strtotime($date) <= strtotime($end_date)) {
				$employeeleave = new LeaveEntry();
				$employeeleave->employeeid =  $employeeid;
				$employeeleave->date =  $date;
				$employeeleave->leavetype = $request->leavetype;
                // $employeeleave->fromdate = $request->fromdate;
                // $employeeleave->todate = $request->todate;
				$employeeleave->reason =  !empty($request->reason) ? $request->reason : null;
				$employeeleave->actionby = session()->get('admin_id');
				$employeeleave->Save();

                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date))); // for date vise looping
                }

				DB::commit();
				$success = true;

				Session::flash('message', 'Employee leave is added successfully');
				Session::flash('alert-type', 'success');

				return redirect()->route('viewleaveentry')->with('success', 'Employee leave is added successfully.');

			} catch(\Exception $e) {

				DB::rollback();
				$success = false;
			}

			if($success == false){
				return redirect('dashboard');
			}



		}
        $employee = Employee::where('status', 1)->get()->all();

		return view('hr.leaveentry.addleave')->with(compact('employee'));
    }
    public function viewleaveentry(Request $request){

        if(Session()->get('role') == 'admin' || Session()->get('role') == 'Admin' || Session()->get('role') == 'manager'){
            $employeeleave = LeaveEntry::with('empname');
            if($request->employeeid){
                $employeeleave->where('employeeid',$request->employeeid);
            }
            if($request->status){
                $employeeleave->where('status',$request->status);
            }
            $employeeleave = $employeeleave->orderby('leaveentry.leaveentryid','desc')->paginate(10);
        }else{
            $employeeleave = LeaveEntry::with('empname');
            $employeeleave->where('employeeid',Session()->get('employeeid'));
            if($request->status){
                $employeeleave->where('status',$request->status);
            }
            $employeeleave = $employeeleave->orderby('leaveentry.leaveentryid','desc')->paginate(10);
        }
		$employee = Employee::where('status', 1)->get()->all();

		return view('hr.leaveentry.viewleaveentry')->with(compact('employeeleave', 'employee','request'));


	}
    public function approveleave($leaveentryid){

		$employeeleave = LeaveEntry::where('leaveentryid',$leaveentryid)->get()->first();
        $employeeleave->status = 'Approve';
        $employeeleave->save();

//        $approveleave = new EmployeeLeave();
//        $approveleave->employeeid =  $employeeleave->employeeid;
//        $approveleave->date =  date('Y-m-d', strtotime($employeeleave->date));
//        $approveleave->leavetype = $employeeleave->leavetype;
//        $approveleave->reason =  !empty($employeeleave->reason) ? $employeeleave->reason : null;
//        $approveleave->actionby = session()->get('admin_id');
//        $approveleave->Save();



        return redirect()->back()->with('message', 'Employee leave is Approved successfully.');

	}
    public function rejectleave($leaveentryid){

		$employeeleave = LeaveEntry::where('leaveentryid',$leaveentryid)->get()->first();
        $employeeleave->status = 'Reject';
        $employeeleave->save();

        return redirect()->back()->with('message', 'Employee leave is Rejected successfully.');

	}

	public function changeleavestatus(Request $request){
        $leaveids = $request->leaveid;
        if(!empty($leaveids)) {
            if ($request->has('approveall')) {
//                dd($leaveids);
                LeaveEntry::whereIN('leaveentryid',$leaveids)->where('status','Pending')->update(['status'=>'Approve']);

                return redirect()->back()->with('message', 'All Leave Approved');
            }
            if ($request->has('rejectall')) {
                LeaveEntry::whereIN('leaveentryid',$leaveids)->where('status','Pending')->update(['status'=>'Reject']);
                return redirect()->back()->with('message', 'All Leave Rejected');
            }
        }else{
            return redirect()->back()->with('error', 'Leave Not Found');
        }
    }

}
