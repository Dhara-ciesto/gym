<?php

namespace App\Http\Controllers\Reports;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Excel;
use App\Company;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;
use App\PaymentType;


class GSTController extends Controller
{
    public function gstreport(Request $request)
  { 

    $fdate =$request->get('fdate');
    $tdate =$request->get('tdate');
    $username=$request->get('username');
    $mode=$request->get('mode');
    $amount=$request->get('amount');
    $keyword =$request->get('keyword');
/*for pass to bladefile */
    $query=[];
    $query['fdate']=$fdate ;
    $query['tdate']=$tdate ;
    $query['username']=$username;
    $query['mode']=$mode;
    $query['amount']= $amount;
    $query['keyword']= $keyword;
    $users1=  DB::table('users')->join('registration','registration.id','users.regid')->where('users.regid','!=',0)->where('registration.is_member','!=',1)->where('users.useractive',1)->get();

    $users2= DB::table('users')->Join('member', 'member.userid', '=', 'users.userid')->get();
    $merged = $users1->merge($users2);
    $users = $merged->all();

    $modes=PaymentType::get(['paymenttype','paymenttypeid'])->all();
    
    if ($request->isMethod('post'))
    {     
      $gst=Payment::leftjoin('member','member.memberid','=','payments.memberid')
      ->leftjoin('schemes','schemes.schemeid','=','payments.schemeid')->where('payments.status',1)
      ->where('payments.memberid','!=',0)->where('payments.mode','!=','total')
      ->select('payments.amount as pamount','payments.tax as ptax','payments.*','member.*','schemes.*');
   
      if ($fdate != "") {
        $from = date($fdate);
        //$to = date($to);
        if (!empty($tdate)) {
            $to = date($tdate);
        }else{
            $to = date('Y-m-d');
        }
        // ->whereBetween('followupdays', [$from, $to])
          $gst->whereBetween('payments.date', [$from, $to]);
        
        }
        if ($tdate != "") {
          $to = date($tdate);
          if (!empty($fdate)) {
              $from = date($fdate);
          }else{
              $from = '';
          }
            $gst->whereBetween('payments.date', [$from, $to]);
        }
        if ($keyword != ""){
          $gst->where ( 'member.firstname', 'LIKE', '%' . $keyword . '%' )->orWhere ('member.email', 'LIKE', '%' . $keyword . '%' )->orWhere ( 'member.lastname', 'LIKE', '%' . $keyword . '%' )->orWhere ('payments.mode', 'LIKE', '%' . $keyword . '%' );
        }
        // dd($username);
        if($username != ""){
          $gst->where('member.userid',$username);
        }
        // dd($paymentdata->paginate(5));
        if($amount != ""){
          $gst->where('payments.amount',$amount);
        }
        if($mode != ""){
          $gst->where('payments.mode',$mode);
        }
        $gst=$gst->get()->all();
        $gstall=$gst;
     
   
        if($request->excel == 1){
          $grid =json_decode(json_encode($request->gstreport));
     
          if($grid){
            $student_array[] = array('InvoiceID','Member','Payment Date', 'Amount','type','GST (%)', 'Gst Amount','GST NO','Companyname', );
  
          foreach ($grid as $student)
          {
            $student=json_decode($student);
            $gstno='';
            $companyname='';
            if ($student->companyid!='' || $student->companyid!= null) {
              $companyname1=  Company::where('companyid',$student->companyid)->get()->first();
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
      return view('admin.gst.gstreport',compact('gst','gstall','query','modes','users'));
}


   $gst=Payment::leftjoin('member','member.memberid','=','payments.memberid')->leftjoin('schemes','schemes.schemeid','=','payments.schemeid')->where('payments.status',1)->where('payments.memberid','!=',0)->where('payments.mode','!=','total')->get(['payments.amount as pamount','payments.tax as ptax','payments.*','member.*','schemes.*'])->all();
   $gstall=$gst;

      $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $itemCollection = collect($gst);
            $perPage = 16;
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
            $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
            $paginatedItems->setPath($request->url());
            $gst =  $paginatedItems;
          

    return view('admin.gst.gstreport',compact('gst','gstall','query','modes','users'));
     
  }

 
  
}
