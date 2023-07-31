<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Concerns\FromCollection;
use Excel;
use Illuminate\Http\Request;
use DB;

class MemberReportController extends Controller
{	

    public function expensegstreport(Request $request)
  { 
      if($request->isMethod('post'))
      {

        DB::enableQueryLog();
            $fdate =$request->get('fdate');
            $tdate =$request->get('tdate');
            $username=$request->get('user');
            $keyword =$request->get('keyword');

        /*for pass to bladefile */
            $query=[];
            $query['fdate']=$fdate ;
            $query['tdate']=$tdate ;
            $query['username']=$username;
            $query['keyword']= $keyword;

         
      $expensepayment= 	 DB::select( DB::raw("select  `member`.memberid as memid,`memberdietplan`.`memberdietplanid`,`member`.`createddate`,`member`.`firstname`,`member`.`lastname`,dietplanname.dietplanname,workout.workoutname,memberworkout.workoutid,memberdietplan.created_at as dietassigndate,memberworkout.created_at as workoutassigndate from `member` left join `memberdietplan` on `memberdietplan`.`memberid` = `member`.`memberid` AND memberdietplan.status='1' left join dietplanname on memberdietplan.plannameid=dietplanname.dietplannameid  left join memberworkout on member.memberid = memberworkout.memberid AND memberworkout.status='1' left join workout on workout.workoutid= memberworkout.workoutid  ORDER BY member.createddate  ASC") );

           if ($fdate != "empty") {
                     $from = date($fdate);
                     //$to = date($to);
                     if ($tdate != "empty") {
                         $to = date($tdate);
                     }else{
                         $to = date('Y-m-d');
                     }
        $expensepayment=	 DB::select( DB::raw("select   `member`.memberid as memid,`memberdietplan`.`memberdietplanid`,`member`.`createddate`,`member`.`firstname`,`member`.`lastname`,dietplanname.dietplanname,workout.workoutname,memberworkout.workoutid,memberdietplan.created_at as dietassigndate,memberworkout.created_at as workoutassigndate from `member` left join `memberdietplan` on `memberdietplan`.`memberid` = `member`.`memberid` AND memberdietplan.status='1' left join dietplanname on memberdietplan.plannameid=dietplanname.dietplannameid  left join memberworkout on member.memberid = memberworkout.memberid AND memberworkout.status='1' left join workout on workout.workoutid= memberworkout.workoutid WHERE `member`.`createddate` BETWEEN '".$from."' AND '".$to."'   ORDER BY member.createddate  ASC") );                   
         }
         if ($tdate != "empty") {
                     $to = date($tdate);
                     if ($fdate != "empty") {
                         $from = date($fdate);
                     }else{
                         $from = date('Y-m-d');
                     }
                           $expensepayment=	 DB::select( DB::raw("select   `member`.memberid as memid,`memberdietplan`.`memberdietplanid`,`member`.`createddate`,`member`.`firstname`,`member`.`lastname`,dietplanname.dietplanname,workout.workoutname,memberworkout.workoutid,memberdietplan.created_at as dietassigndate,memberworkout.created_at as workoutassigndate from `member` left join `memberdietplan` on `memberdietplan`.`memberid` = `member`.`memberid` AND memberdietplan.status='1' left join dietplanname on memberdietplan.plannameid=dietplanname.dietplannameid  left join memberworkout on member.memberid = memberworkout.memberid AND memberworkout.status='1' left join workout on workout.workoutid= memberworkout.workoutid WHERE `member`.`createddate` BETWEEN '".$from."' AND '".$to."'  ORDER BY member.createddate  ASC") );
         }

          if ($keyword != "empty"){
              
	       		 			$expensepayment=	 DB::select( DB::raw("select   `member`.memberid as memid,`memberdietplan`.`memberdietplanid`,`member`.`createddate`,`member`.`firstname`,`member`.`lastname`,dietplanname.dietplanname,workout.workoutname,memberworkout.workoutid,memberdietplan.created_at as dietassigndate,memberworkout.created_at as workoutassigndate from `member` left join `memberdietplan` on `memberdietplan`.`memberid` = `member`.`memberid` AND memberdietplan.status='1' left join dietplanname on memberdietplan.plannameid=dietplanname.dietplannameid  left join memberworkout on member.memberid = memberworkout.memberid AND memberworkout.status='1' left join workout on workout.workoutid= memberworkout.workoutid  left join users on member.userid=users.userid WHERE `member`.`firstname` Like '%".$keyword."%' or  `member`.`lastname` Like '%".$keyword."%'  ORDER BY member.createddate  ASC") );
          }
          
          if($username != "empty"){
        $expensepayment=	 DB::select( DB::raw("select  `member`.memberid as memid, `memberdietplan`.`memberdietplanid`,`member`.`createddate`,`member`.`firstname`,`member`.`lastname`,dietplanname.dietplanname,workout.workoutname,memberworkout.workoutid,memberdietplan.created_at as dietassigndate,memberworkout.created_at as workoutassigndate from `member` left join `memberdietplan` on `memberdietplan`.`memberid` = `member`.`memberid` AND memberdietplan.status='1' left join dietplanname on memberdietplan.plannameid=dietplanname.dietplannameid  left join memberworkout on member.memberid = memberworkout.memberid AND memberworkout.status='1' left join workout on workout.workoutid= memberworkout.workoutid  left join users on member.userid=users.userid WHERE `users`.`userid` = '".$username."'  ORDER BY member.createddate  ASC") );          }
        
       
    if($expensepayment){
     

                $expensepayment_array[] = array('Date','Name','Diet', 'Diet AssignDate','Exercise','Workout AssignDate' );


                foreach ($expensepayment as $expensepayment1) 
                {

                   $expensepayment_array[] = array(
                      'Date' => date('d-m-Y', strtotime($expensepayment1->createddate)),
                      'Name' => $expensepayment1->firstname.$expensepayment1->lastname,
                      'Diet' =>  ($expensepayment1->memberdietplanid != NULL) ? $expensepayment1->dietplanname :  'Not Assigned',

                           'Diet AssignDate' => $expensepayment1->dietassigndate,
                      'Exercise' => ($expensepayment1->workoutid != NULL) ? $expensepayment1->workoutname : 'Not Assigned',


                      'Workout AssignDate' => $expensepayment1->workoutassigndate

                      );
                }    

            $myFile =  Excel::create('Member Report', function($excel) use ($expensepayment_array) {
                    $excel->sheet('mySheet', function($sheet) use ($expensepayment_array)
                    {

                       $sheet->fromArray($expensepayment_array);

                    });
               });
         $myFile = $myFile->string('xlsx'); //change xlsx for the format you want, default is xls
    $response =  array(
       'name' => "Member Report", //no extention needed
       'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($myFile) //mime type of used format
    );
    return response()->json($response);
       echo 'yes';

    
        }
      }
     
  } 

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
	                 
	                  
    				$data=	 DB::select( DB::raw("select   `member`.memberid as memid,`memberdietplan`.`memberdietplanid`,`member`.`createddate`,`member`.`firstname`,`member`.`lastname`,dietplanname.dietplanname,workout.workoutname,memberworkout.workoutid,memberdietplan.created_at as dietassigndate,memberworkout.created_at as workoutassigndate from `member` left join `memberdietplan` on `memberdietplan`.`memberid` = `member`.`memberid` AND memberdietplan.status='1' left join dietplanname on memberdietplan.plannameid=dietplanname.dietplannameid  left join memberworkout on member.memberid = memberworkout.memberid AND memberworkout.status='1' left join workout on workout.workoutid= memberworkout.workoutid WHERE `member`.`createddate` BETWEEN '".$from."' AND '".$to."'   ORDER BY member.createddate  ASC") );

    				 	return view('admin.memberreport.memberreport',compact('query','data','users'));
	                 
	      	 	 }
	      	 	 if ($tdate != "") {
	                   $to = date($tdate);
	                   if (!empty($fdate)) {
	                       $from = date($fdate);
	                   }else{
	                       $from = date('Y-m-d');
	                   }

	                  $data=	 DB::select( DB::raw("select   `member`.memberid as memid,`memberdietplan`.`memberdietplanid`,`member`.`createddate`,`member`.`firstname`,`member`.`lastname`,dietplanname.dietplanname,workout.workoutname,memberworkout.workoutid,memberdietplan.created_at as dietassigndate,memberworkout.created_at as workoutassigndate from `member` left join `memberdietplan` on `memberdietplan`.`memberid` = `member`.`memberid` AND memberdietplan.status='1' left join dietplanname on memberdietplan.plannameid=dietplanname.dietplannameid  left join memberworkout on member.memberid = memberworkout.memberid AND memberworkout.status='1' left join workout on workout.workoutid= memberworkout.workoutid WHERE `member`.`createddate` BETWEEN '".$from."' AND '".$to."'  ORDER BY member.createddate  ASC") );
	                  	return view('admin.memberreport.memberreport',compact('query','data','users'));
	      		 }
	      		 if($username != ""){

	        		$data=	 DB::select( DB::raw("select  `member`.memberid as memid, `memberdietplan`.`memberdietplanid`,`member`.`createddate`,`member`.`firstname`,`member`.`lastname`,dietplanname.dietplanname,workout.workoutname,memberworkout.workoutid,memberdietplan.created_at as dietassigndate,memberworkout.created_at as workoutassigndate from `member` left join `memberdietplan` on `memberdietplan`.`memberid` = `member`.`memberid` AND memberdietplan.status='1' left join dietplanname on memberdietplan.plannameid=dietplanname.dietplannameid  left join memberworkout on member.memberid = memberworkout.memberid AND memberworkout.status='1' left join workout on workout.workoutid= memberworkout.workoutid  left join users on member.userid=users.userid WHERE `users`.`userid` = '".$username."'  ORDER BY member.createddate  ASC") );

	                  	return view('admin.memberreport.memberreport',compact('query','data','users'));
	       		 }
	       		 if($keyword != ""){

	       		 			$data=	 DB::select( DB::raw("select   `member`.memberid as memid,`memberdietplan`.`memberdietplanid`,`member`.`createddate`,`member`.`firstname`,`member`.`lastname`,dietplanname.dietplanname,workout.workoutname,memberworkout.workoutid,memberdietplan.created_at as dietassigndate,memberworkout.created_at as workoutassigndate from `member` left join `memberdietplan` on `memberdietplan`.`memberid` = `member`.`memberid` AND memberdietplan.status='1' left join dietplanname on memberdietplan.plannameid=dietplanname.dietplannameid  left join memberworkout on member.memberid = memberworkout.memberid AND memberworkout.status='1' left join workout on workout.workoutid= memberworkout.workoutid  left join users on member.userid=users.userid WHERE `member`.`firstname` Like '%".$keyword."%' or  `member`.`lastname` Like '%".$keyword."%'  ORDER BY member.createddate  ASC") );

	                  	return view('admin.memberreport.memberreport',compact('query','data','users'));
	       		 }
	       		 else{
	       		 		$data=	 DB::select( DB::raw("select  `member`.memberid as memid,`memberdietplan`.`memberdietplanid`,`member`.`createddate`,`member`.`firstname`,`member`.`lastname`,dietplanname.dietplanname,workout.workoutname,memberworkout.workoutid,memberdietplan.created_at as dietassigndate,memberworkout.created_at as workoutassigndate from `member` left join `memberdietplan` on `memberdietplan`.`memberid` = `member`.`memberid` AND memberdietplan.status='1' left join dietplanname on memberdietplan.plannameid=dietplanname.dietplannameid  left join memberworkout on member.memberid = memberworkout.memberid AND memberworkout.status='1' left join workout on workout.workoutid= memberworkout.workoutid  ORDER BY member.createddate  ASC") );

			//  dd($data);

            $users1=  DB::table('users')->join('registration','registration.id','users.regid')->where('users.regid','!=',0)->where('registration.is_member','!=',1)->where('users.useractive',1)->get();
            $users2= DB::table('users')->Join('member', 'member.userid', '=', 'users.userid')->get();
            $merged = $users1->merge($users2);
            $users = $merged->all();


            return view('admin.memberreport.memberreport',compact('query','data','users'));
	       		 }

    			
			return view('admin.memberreport.memberreport',compact('query','data','users'));

    	}

			$data=	 DB::select( DB::raw("select  `member`.memberid as memid,`memberdietplan`.`memberdietplanid`,`member`.`createddate`,`member`.`firstname`,`member`.`lastname`,dietplanname.dietplanname,workout.workoutname,memberworkout.workoutid,memberdietplan.created_at as dietassigndate,memberworkout.created_at as workoutassigndate from `member` left join `memberdietplan` on `memberdietplan`.`memberid` = `member`.`memberid` AND memberdietplan.status='1' left join dietplanname on memberdietplan.plannameid=dietplanname.dietplannameid  left join memberworkout on member.memberid = memberworkout.memberid AND memberworkout.status='1' left join workout on workout.workoutid= memberworkout.workoutid  ORDER BY member.createddate  ASC") );

			//  dd($data);

		$users1=  DB::table('users')->join('registration','registration.id','users.regid')->where('users.regid','!=',0)->where('registration.is_member','!=',1)->where('users.useractive',1)->get();
		$users2= DB::table('users')->Join('member', 'member.userid', '=', 'users.userid')->get();
		$merged = $users1->merge($users2);
		$users = $merged->all();


		return view('admin.memberreport.memberreport',compact('query','data','users'));
	}


	
	
}
