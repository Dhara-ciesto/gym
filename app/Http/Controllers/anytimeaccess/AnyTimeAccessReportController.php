<?php

namespace App\Http\Controllers\anytimeaccess;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserAssignedBelt;
use App\AnyTimeAccessBelt;
use DB;

class AnyTimeAccessReportController extends Controller
{
     public function anytimeaccessreport(Request $request)
   {

   		/*for Post request */
   		   $fdate =$request->get('fdate');
	          $tdate =$request->get('tdate');
	          	   $rfdate =$request->get('rfdate');
	          $rtdate =$request->get('rtdate');
	          $username=$request->get('username');
	          $mode=$request->get('mode');
	          $amount=$request->get('amount');
	          $keyword =$request->get('keyword');
	          $beltno =$request->get('beltno');
	          
				/*for pass to bladefile */
	          $query=[];

	          $query['fdate']=$fdate ;
	          $query['tdate']=$tdate ;
	          $query['rfdate']=$rfdate ;
	          $query['rtdate']=$rtdate ;
	          $query['username']=$username;
	         
	          $query['keyword']= $keyword;
	          $query['beltno']=$beltno ;
	          $beltnos=AnyTimeAccessBelt::get()->all();

				$users1=  DB::table('users')->join('registration','registration.id','users.regid')->where('users.useractive',1)->get();
				/*->where('users.regid','!=',0)->where('registration.is_member','!=',1)*/
				// dd($users1);
				// $users2= DB::table('users')->Join('member', 'member.userid', '=', 'users.userid')->get();
				// $merged = $users1->merge($users2);
				// $users = $merged->all();
				$users=$users1;


   		if($request->isMethod('post'))
    	{
    	
		$anytimeaccessdata= UserAssignedBelt::leftjoin('anytimeaccessbelt','anytimeaccessbelt.beltno','userassignedbelt.userbeltno')->leftjoin('users','users.userid','userassignedbelt.userid')->leftjoin('registration','registration.id','users.regid')->orderBy('userassignedbeltid','desc');
		// dd($anytimeaccessdata);
	         if ($fdate != "") {
	                   $from = date($fdate);
	                   //$to = date($to);
	                   if (!empty($tdate)) {
	                       $to = date($tdate);
	                  
	                   }else{
	                       $to = date('Y-m-d');
	                       $to=date($to);
	                   }
	                     // $to = $to->getTimestamp();

	                   // ->whereBetween('followupdays', [$from, $to])
	                   $anytimeaccessdata->whereBetween('userassignedbelt.assigneddate', [$from, $to]);
	                 
	       }
	       if ($tdate != "") {
	                   $to = date($tdate);
	                   if (!empty($fdate)) {
	                       $from = date($fdate);
	                   }else{
	                       $from ='';
	                      
	                   }
	              
	                     $anytimeaccessdata->whereBetween('userassignedbelt.assigneddate', [$from, $to]);
	       }
	        if ($rfdate != "") {
	                   $from = date($rfdate);
	                   //$to = date($to);
	                   if (!empty($rtdate)) {
	                       $to = date($rtdate);
	                  
	                   }else{
	                       $to = date('Y-m-d');
	                       $to=date($to);
	                   }
	                     // $to = $to->getTimestamp();

	                   // ->whereBetween('followupdays', [$from, $to])
	                   // echo $from;
	                   // echo $to;
	                   // exit;
	                   $anytimeaccessdata->whereBetween('userassignedbelt.returndate', [$from, $to]);
	                 
	       }
	       if ($rtdate != "") {
	                   $to = date($rtdate);
	                   if (!empty($rfdate)) {
	                       $from = date($rfdate);
	                   }else{
	                       $from ='';
	                   }
	                   // dd($to);
	                     $anytimeaccessdata->whereBetween('userassignedbelt.returndate', [$from, $to]);
	       }
	       

	        if ($keyword != ""){
	             $anytimeaccessdata->where( 'userassignedbelt.userbeltno', 'LIKE', '%' . $keyword . '%' )->orwhere ( 'userassignedbelt.userrfidno', 'LIKE', '%' . $keyword . '%' )->orwhere ( 'registration.firstname', 'LIKE', '%' . $keyword . '%' )->orwhere ( 'registration.lastname', 'LIKE', '%' . $keyword . '%' );
	        }
	        // dd($username);
	        if($username != ""){
	        	$anytimeaccessdata->where('users.userid',$username);
	        }
	        if($beltno != ""){
	        	$anytimeaccessdata->where('userassignedbelt.userbeltno',$beltno);
	        }
	        // dd($anytimeaccessdata->paginate(5));
	
	       
	        $anytimeaccessdata=$anytimeaccessdata->paginate(8)->appends('query');
	        // dd($anytimeaccessdata);
	       return view('admin.anytimeaccess.anytimeaccesscardreport',compact('anytimeaccessdata','query','beltnos','users'));


    	}

   		/*for get request */

		$anytimeaccessdata= UserAssignedBelt::leftjoin('anytimeaccessbelt','anytimeaccessbelt.beltno','userassignedbelt.userbeltno')->leftjoin('users','users.userid','userassignedbelt.userid')->leftjoin('registration','registration.id','users.regid')->orderBy('userassignedbeltid','desc')->paginate(10);
		// dd($anytimeaccessdata);
   		return view('admin.anytimeaccess.anytimeaccesscardreport',compact('anytimeaccessdata','query','beltnos','users'));

   

   }
}
