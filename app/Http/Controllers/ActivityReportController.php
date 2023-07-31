<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Notify;
use App\MemberPackages;
use App\Member;
use App\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Excel;
use App\Company;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;
use App\PaymentType;
class ActivityReportController extends Controller
{
    public function activityreport(Request $request)
    {	
    	
    	$fdate =$request->get('fdate');
		$tdate =$request->get('tdate');
		$username=$request->get('username');
		$keyword =$request->get('keyword');
		/*for pass to bladefile */
		$query=[];
		$query['fdate']=$fdate ;
		$query['tdate']=$tdate ;
		$query['username']=$username;
		$query['keyword']= $keyword;
		$users=Employee::where('status',1)->get()->all();

    	 if ($request->isMethod('post'))
   		 { 	
   		 	$data=Notify::select('notify.*','employee.first_name','employee.last_name','users.username')->leftjoin('employee','employee.employeeid','notify.actionby')->leftjoin('users','users.userid','notify.userid');
   		 	   if ($fdate != "") {
	                   $from = date($fdate);
	                   //$to = date($to);
	                   if (!empty($tdate)) {
	                       $to = date($tdate);
	                   }else{
	                       $to = date('Y-m-d');
	                   }
	                   // ->whereBetween('followupdays', [$from, $to])
	                   $data->whereBetween('notify.created_at', [$from, $to]);
	                 
	       }
	       if ($tdate != "") {
	                   $to = date($tdate);
	                   if (!empty($fdate)) {
	                       $from = date($fdate);
	                   }else{
	                       $from = '';
	                   }
	                     $data->whereBetween('notify.created_at', [$from, $to]);
	       }
	        if ($keyword != ""){
	             $data->where ( 'employee.first_name', 'LIKE', '%' . $keyword . '%' )->orwhere ( 'employee.last_name', 'LIKE', '%' . $keyword . '%' )->orWhere ( 'employee.username', 'LIKE', '%' . $keyword . '%' )->orWhere ('notify.details', 'LIKE', '%' . $keyword . '%' );
	        }
	        // dd($username);
	        if($username != ""){
	        	$data->where('employee.userid',$username);
	        }
	        // dd($paymentdata->paginate(5));
	       

	        $data=$data->paginate(1000)->appends('query');





        if($request->excel == 1){
		  $grid = Notify::select('notify.*','employee.first_name','employee.last_name',
								'users.username')->leftjoin('employee','employee.employeeid','notify.actionby')
								->leftjoin('users','users.userid','notify.userid')->get()->all();
     
          if($grid){
            $student_array[] = array('Date','Action BY','Client Name','Action' );
  
          foreach ($grid as $student)
          {
            // $student=json_decode($student);
          
            $student_array[] = array(
              'Date' => date('d-m-Y', strtotime($student->created_at)),
			  'Action BY'=>$student->first_name.$student->last_name,
			  'Client Name'=>$student->username,
			  'Action' => $student->details
            );
          }
  
          $myFile=  Excel::create('Activity Report', function($excel) use ($student_array) {
                          $excel->sheet('mySheet', function($sheet) use ($student_array)
                          {
  
                            $sheet->fromArray($student_array);
  
                          });
                    
  
          })->download('xlsx');
        
          }
        }
   		 	
   		 	return view('admin.activityreport.activityreport',compact('query','data','users'));
   		 }










   		 else
   		 {
   		 	$data=Notify::select('notify.*','employee.first_name','employee.last_name','users.username')->leftjoin('employee','employee.employeeid','notify.actionby')->leftjoin('users','users.userid','notify.userid')->orderBy('notifyid','desc')->get()->all();




      $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $itemCollection = collect($data);
            $perPage = 15;
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
            $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
            $paginatedItems->setPath($request->url());
            $data =  $paginatedItems;



   		 //dd($data);
   		 	return view('admin.activityreport.activityreport',compact('query','data','users'));
   		 }



    }
}
