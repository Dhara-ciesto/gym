<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentType;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Excel;
use App\Company;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Payment;

class PaymentReportController extends Controller
{
   public function paymentreport(Request $request)
   {

   		/*for Post request */
   		   $fdate =$request->get('fdate');
	          $tdate =$request->get('tdate');
	          $username=$request->get('username');
	          $mode=$request->get('mode');
	          $amount=$request->get('amount');
	          $keyword =$request->get('keyword');
				/*for pass to bladefile */
	          $query=[];
	            // if ($fdate == "") {

             //            $query['fdate']=date('Y-m-d');
             //          }
             //          else
             //          {
                        $query['fdate']=$request->get('fdate');
                    //  }

  // if ($tdate == "") {

  //                       $query['tdate']=date('Y-m-d');
  //                     }
  //                     else
  //                     {
                        $query['tdate']=$request->get('tdate');
                     // }
            // $query['fdate']=$fdate ;
         //   $query['tdate']=$tdate ;
	          $query['username']=$username;
	          $query['mode']=$mode;
	          $query['amount']= $amount;
	          $query['keyword']= $keyword;


   		if($request->isMethod('post'))
    	{
    	
			$users1=  DB::table('users')->join('registration','registration.id','users.regid')->where('users.regid','!=',0)->where('registration.is_member','!=',1)->where('users.useractive',1)->get();
			
			$users2= DB::table('users')->Join('member', 'member.userid', '=', 'users.userid')->get();
			$merged = $users1->merge($users2);
			$users = $merged->all();    
        
        	$modes=PaymentType::get(['paymenttype','paymenttypeid'])->all();

	        $paymentdata = Payment::
	       leftJoin('users', 'users.userid', '=', 'payments.userid')
	        ->leftJoin('member', 'member.memberid', '=', 'payments.memberid')
	                     ->leftJoin('schemes', 'schemes.schemeid', '=', 'payments.schemeid')

	        ->leftJoin('registration', 'registration.id', '=',  'users.regid')
	        ->leftJoin('company', 'company.companyid', '=', 'member.companyid')
	        ->leftJoin('admin', 'admin.adminid', '=', 'payments.takenby')
	        ->where('payments.mode', '!=', 'total')
	        ->select('users.userid as usertableuserid','users.*','payments.*','member.*','registration.firstname as rfirstname','registration.lastname as rlastname','payments.amount as pamount','schemes.schemename as schemename','company.companyname as companyname','admin.name as name')->orderBy('paymentid','desc');

	         if ($fdate != "") {
	                   $from = date($fdate);
	                   //$to = date($to);
	                   if (!empty($tdate)) {
	                       $to = date($tdate);
	                   }else{
	                       $to = date('Y-m-d');
	                   }
	                   // ->whereBetween('followupdays', [$from, $to])
	                   $paymentdata->whereBetween('date', [$from, $to]);
	                 
	       }
	       if ($tdate != "") {
	                   $to = date($tdate);
	                   if (!empty($fdate)) {
	                       $from = date($fdate);
	                   }else{
	                       $from = '';
	                   }
	                     $paymentdata->whereBetween('date', [$from, $to]);
	       }
	        if ($keyword != ""){
	             $paymentdata->where ( 'member.firstname', 'LIKE', '%' . $keyword . '%' )->orwhere ( 'registration.firstname', 'LIKE', '%' . $keyword . '%' )->orwhere ( 'registration.lastname', 'LIKE', '%' . $keyword . '%' )->orWhere ('member.email', 'LIKE', '%' . $keyword . '%' )->orWhere ( 'member.lastname', 'LIKE', '%' . $keyword . '%' )->orWhere ('mode', 'LIKE', '%' . $keyword . '%' );
	        }
	        // dd($username);
	        if($username != ""){
	        	$paymentdata->where('users.userid',$username);
	        }
	        // dd($paymentdata->paginate(5));
	        if($amount != ""){
	        	$paymentdata->where('payments.amount',$amount);
	        }
	        if($mode != ""){
	        	$paymentdata->where('payments.mode',$mode);
	        }
			$paymentdatahidden=$paymentdata->get()->all();
		
	        $paymentdata=$paymentdata->paginate(1000)->appends('query');
	        // dd($paymentdata);
 			








        if($request->excel == 1){
          $grid =json_decode(json_encode($request->paymentreport));
     
          if($grid){
            $student_array[] = array('Date','Invoice ID'	,'Name'	,'Mode'	,'Amount'	,'TakenBy'	,'ReceiptNo	','Company Name');
  
          foreach ($grid as $student)
          {
            $student=json_decode($student);
          
           	if($student->firstname){
				$fname = $student->firstname;
				$lname = $student->lastname;
			}else{
				$fname = $student->rfirstname;
				$lname = $student->rlastname;
			}
            $student_array[] = array(
              'Date' => date('d-m-Y', strtotime($student->date)),
              'Invoice ID'=>$student->invoiceno,
              'Name' =>  $fname.$lname,


              'Mode' => $student->mode,

              'Amount' => $student->pamount,
              'TakenBy' => $student->name,

              'ReceiptNo' => $student->receiptno,

              'Company Name' => $student->companyname

  
            );
          }
  
          $myFile=  Excel::create('Payment Report', function($excel) use ($student_array) {
                          $excel->sheet('mySheet', function($sheet) use ($student_array)
                          {
  
                            $sheet->fromArray($student_array);
  
                          });
                    
  
          })->download('xlsx');
        
          }
        }










	        return view('admin.paymentreport.paymentreport',compact('paymentdata','paymentdatahidden','users','modes','query'));


    	}

   		/*for get request */

		$users1=  DB::table('users')->join('registration','registration.id','users.regid')->where('users.regid','!=',0)->where('registration.is_member','!=',1)->where('users.useractive',1)->get();

		$users2= DB::table('users')->Join('member', 'member.userid', '=', 'users.userid')->get();
		$merged = $users1->merge($users2);
		$users = $merged->all();

		$modes=PaymentType::get(['paymenttype','paymenttypeid'])->all();

   		$paymentdata = Payment::
    	leftJoin('users', 'users.userid', '=', 'payments.userid')
        ->leftJoin('member', 'member.memberid', '=', 'payments.memberid')
                ->leftJoin('schemes', 'schemes.schemeid', '=', 'payments.schemeid')

        ->leftJoin('registration', 'registration.id', '=', 'users.regid')
        ->leftJoin('company', 'company.companyid', '=', 'member.companyid')
        ->leftJoin('admin', 'admin.adminid', '=', 'payments.takenby')
        ->where('payments.mode', '!=', 'total')
        ->select('users.userid as usertableuserid','users.*','payments.*','member.*','registration.firstname as rfirstname','registration.lastname as rlastname','payments.amount as pamount','company.companyname as companyname','schemes.schemename as schemename','admin.name as name')->orderBy('paymentid','desc')
        ->get()->all();
           /* dd($paymentdata);*/
 			$paymentdatahidden=$paymentdata;

   		
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $itemCollection = collect($paymentdata);
            $perPage = 15;
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
            $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
            $paginatedItems->setPath($request->url());
            $paymentdata =  $paginatedItems;

   		return view('admin.paymentreport.paymentreport',compact('paymentdata','paymentdatahidden','users','modes','query'));

   

   }
}
