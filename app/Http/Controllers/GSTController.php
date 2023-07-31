<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Excel;
use App\Company;
use Illuminate\Pagination\LengthAwarePaginator;

class GSTController extends Controller
{
    public function gstreport(Request $request)
  { 

    $method = $request->method();

    if ($request->isMethod('post'))
    {     
    	// print_r($request->gstreport[0]);
    	$grid =json_decode(json_encode($request->gstreport));

    if($grid){
       $student_array[] = array('InvoiceID','Member','Payment Date', 'Amount','type','GST (%)', 'Gst Amount','GST NO','Companyname', );

    foreach ($grid as $student)
    {
   $student=json_decode($student);
   $gstno='';
   	$companyname='';
   if ($student->companyid!='' || $student->companyid!= null) {
   	$companyname1=	Company::where('companyid',$student->companyid)->get()->first();
   	$companyname=$companyname1->companyname;
   	$gstno=$companyname1->gstno;
   }
   $amount='';
   	if ($student->pamount == 0 || $student->pamount == null || $student->pamount =='') {
   		$amount=0;	
   	}
   	else{
   		$amount=$student->pamount;
   	}
   	$gstamount='';
  
   	if($student->taxamount){
   			$gstamount=$student->taxamount;
   	}
   
   	
        $student_array[] = array(
        	'InvoiceID' => $student->receiptno,
          'Member'=>$student->firstname.$student->lastname,
        	'Payment Date' => date('d-m-Y', strtotime($student->paymentdate)),
        	'Amount' => $amount,
        	'type' => ($student->mode != 'no mode') ? $student->mode : 'No Mode',
        	'Gst' => $student->tax,
        	'Gst Amount' => $gstamount,
        	'GST NO' => $gstno,
        	'Companyname' => $companyname,

        );
    }

    $myFile=  Excel::create('GST Report', function($excel) use ($student_array) {
                    $excel->sheet('mySheet', function($sheet) use ($student_array)
                    {

                       $sheet->fromArray($student_array);

                    });
              

    })->download('xlsx');
    	 
    }
}


   $gst=Payment::leftjoin('member','member.memberid','=','payments.memberid')->leftjoin('schemes','schemes.schemeid','=','payments.schemeid')->where('payments.status',1)->where('payments.memberid','!=',0)->where('payments.mode','!=','total')->get(['payments.amount as pamount','payments.tax as ptax','payments.*','member.*','schemes.*'])->all();
   $gstall=$gst;

      $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $itemCollection = collect($gst);
            $perPage = 10;
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
            $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
            $paginatedItems->setPath($request->url());
            $gst =  $paginatedItems;

    return view('admin.gst.gstreport',compact('gst','gstall'));
     
  }

 
  
}
