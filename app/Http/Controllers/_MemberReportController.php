<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Excel;
use App\Company;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Payment;
use App\Member;
use App\MemberDietPlan;
use App\DietPlanname;
use App\MemberWorkout;
use App\Workout;
use App\User;



use App\CustomCollection;
use Illuminate\Database\Eloquent\Model;
class MemberReportController extends Controller
{	
    public function memberreport(Request $request){

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

		

			$users1=  DB::table('users')->join('registration','registration.id','users.regid')->where('users.regid','!=',0)->where('registration.is_member','!=',1)->where('users.useractive',1)->get();
		$users2= DB::table('users')->Join('member', 'member.userid', '=', 'users.userid')->get();
		$merged = $users1->merge($users2);
		$users = $merged->all();





 $freezememberships =  Member::select('member.memberid as memid','memberdietplan.memberdietplanid as memmid','member.createddate','member.firstname','member.lastname','dietplanname.dietplanname','workout.workoutname','memberworkout.workoutid as word','memberdietplan.created_at as dietassigndate','memberworkout.created_at as workoutassigndate')->
	       leftJoin('memberdietplan', 'memberdietplan.memberid', '=', 'member.memberid')->where('memberdietplan.status',1)
	       ->leftJoin('dietplanname', 'memberdietplan.plannameid', '=', 'dietplanname.dietplannameid')
	        ->leftJoin('memberworkout', 'member.memberid', '=',  'memberworkout.memberid' )->where('memberworkout.status',1)->leftJoin('workout', 'workout.workoutid', '=', 'memberworkout.workoutid')  ->leftJoin('users', 'member.userid', '=', 'users.userid')
	        ->groupBy('memberdietplan.memberid','member.memberid','memberdietplan.memberdietplanid','member.createddate','member.firstname','member.lastname','dietplanname.dietplanname','workout.workoutname','memberworkout.workoutid', 'memberdietplan.created_at','memberworkout.created_at')
	      ->orderBy('member.createddate', 'desc');


 $data = Member::select('member.memberid as memid','memberdietplan.memberdietplanid as memmid','member.createddate','member.firstname','member.lastname','dietplanname.dietplanname','workout.workoutname','memberworkout.workoutid as word','memberdietplan.created_at as dietassigndate','memberworkout.created_at as workoutassigndate')->
	       leftJoin('memberdietplan', 'memberdietplan.memberid', '=', 'member.memberid')->where('memberdietplan.status',1)
	       ->leftJoin('dietplanname', 'memberdietplan.plannameid', '=', 'dietplanname.dietplannameid')
	        ->leftJoin('memberworkout', 'member.memberid', '=',  'memberworkout.memberid' )->where('memberworkout.status',1)->leftJoin('workout', 'workout.workoutid', '=', 'memberworkout.workoutid')->leftJoin('users', 'member.userid', '=', 'users.userid')
	        ->groupBy('memberdietplan.memberid','member.memberid','memberdietplan.memberdietplanid','member.createddate','member.firstname','member.lastname','dietplanname.dietplanname','workout.workoutname','memberworkout.workoutid', 'memberdietplan.created_at','memberworkout.created_at')
	      ->orderBy('member.createddate', 'desc')->get()->all();

   		if($request->isMethod('post'))
    	{	
   
    			 if ($fdate != "") 
    			 {
	                   $from = date($fdate);
	                   //$to = date($to);
	                   if (!empty($tdate)) {
	                       $to = date($tdate);
	                   }else{
	                       $to = date('Y-m-d');
	                   }
	                   // ->whereBetween('followupdays', [$from, $to])
	                  
    			      $freezememberships->whereBetween('member.createddate', [$from, $to]);
	                 

    				 //	return view('admin.memberreport.memberreport',compact('query','data','users'));
	                 
	      	 	 }
	      	 	 if ($tdate != "") {
	                   $to = date($tdate);
	                   if (!empty($fdate)) {
	                       $from = date($fdate);
	                   }else{
	                       $from = date('Y-m-d');
	                   }

	              $freezememberships->whereBetween('member.createddate', [$from, $to]);


	               
	                 // 	return view('admin.memberreport.memberreport',compact('query','data','users'));
	      		 }
	      		if($username != ""){

	        		$freezememberships->where('users.userid',$username);
    				 //	return view('admin.memberreport.memberreport',compact('query','data','users'));

			
	       		 }
	       		 if($keyword != ""){

	       		 				$freezememberships->where ('member.firstname', 'LIKE', '%' . $keyword . '%' )->orWhere('member.lastname', 'LIKE', '%' . $keyword . '%' );


	                  	//return view('admin.memberreport.memberreport',compact('query','data','users'));
	       		 }




			$data=$freezememberships->get()->all();
        $paymentdatahidden=$data;
	        // dd($paymentdata);
 			







  if($request->excel == 1){
          $grid =json_decode(json_encode($request->memberreport));
     
          if($grid){
            $student_array[] = array('Date','Name','Diet', 'Exercise','Diet AssignDate','Workout AssignDate');
  
          foreach ($grid as $student)
          {
            $student=json_decode($student);
        
            $student_array[] = array(
              'Date' => date('d-m-Y', strtotime($student->createddate)),
              'Name'=>$student->firstname.$student->lastname,
              'Diet' => date('d-m-Y', strtotime($student->paymentdate)),
              'Diet AssignDate' => date('d-m-Y', strtotime($student->paymentdate)),
              'Workout AssignDate' => date('d-m-Y', strtotime($student->paymentdate)),
             
            );
          }
  
          $myFile=  Excel::create('data Report', function($excel) use ($student_array) {
                          $excel->sheet('mySheet', function($sheet) use ($student_array)
                          {
  
                            $sheet->fromArray($student_array);
  
                          });
                    
  
          })->download('xlsx');
        
          }
        }




    			
		return view('admin.memberreport.memberreport',compact('query','paymentdatahidden','data','users','freezememberships'));

    	}

	

 			$paymentdatahidden=$data;


		return view('admin.memberreport.memberreport',compact('query','paymentdatahidden','data','users','freezememberships'));
	}
	
}
