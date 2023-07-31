<?php

namespace App\Http\Controllers;

use App\Extendhistory;
use Illuminate\Http\Request;
use App\User;
use App\RootScheme;
use App\PaymentType;
use App\Payment;
use App\Member;
use App\Scheme;
use App\AdminMaster;
use App\MemberPackages;
use App\Notify;
use Session;
use DB;
use Carbon\Carbon;

class PackageController extends Controller
{
     public function packageEdit($id,Request $request)
    {   
          
            $packages = MemberPackages::where('userid',$id)->with('Scheme','User','Member')->where('member.status',1)->get()->all();
          $pa=0;
            if($packages){
                foreach ($packages as  $package) {
                    $pa = Payment::where('userid',$package->userid)->where('mode','=','-')->get()->all();
                }

            return view('admin.packageEdit',compact('packages','pa'));
            }

     return view('admin.packageEdit',compact('packages','pa'));
    }

   public function changeStatus(Request $request,$id)
   {

        $memberdata=MemberPackages::where('memberpackagesid',$id)->get()->first();
        $memberdata->status=0;
       $schemeid = $memberdata->schemeid;
     $userid=$memberdata->userid;  
        $memberdata->save();
             $loginuser = session()->get('username');
              
              $scheme = Scheme::where('schemeid', $schemeid)->first();

        if(!empty($scheme)){
          $scheme_name = $scheme->schemename;
          $rootschemeid = $scheme->rootschemeid;
        }
        $actionbyid=session()->get('employeeid');
          $notify=Notify::create([
           'userid'=> $userid,
           'details'=> ''.$loginuser.' deactivate package '.$scheme_name,
           'actionby'=>$actionbyid,
         ]);

        return redirect()->back()->withSuccess('Package Deactivated');

      
    }


   public function changedate(Request $request){
        $loginuser = Session::get('username');

      $id= $request->get('id');
      $extendreason= $request->get('extendreason');
      $packageid = $request->get('packageid');
      $newdate = $request->get('newdate');
      $newdatefornotify=\Carbon\Carbon::parse($newdate)->format('d-m-Y'); 

      $newdate=\Carbon\Carbon::parse($newdate)->format('Y-m-d');
      $edit=MemberPackages::find($packageid);

      $olddatefornotify= \Carbon\Carbon::parse($edit->joindate)->format('d-m-Y'); 
      $oldenddatefornotify=\Carbon\Carbon::parse($edit->expiredate)->format('d-m-Y');

      $scheme= Scheme::findOrFail($edit->schemeid);
      $days=$scheme->numberofdays;
      $days=($days-1);

           

      $edit->joindate = $newdate;
       $enddate = date('Y-m-d', strtotime($edit->joindate . '+'.$days.'days'));
      $enddate=\Carbon\Carbon::parse($enddate)->format('Y-m-d');

      $edit->expiredate = $enddate;
      $newenddatefornotify=\Carbon\Carbon::parse($edit->expiredate)->format('d-m-Y');
      $edit->save();

       if($edit->expiredate >= date('Y-m-d')){
           $edit->status = 1;
           $edit->save();
       }else{
           $edit->status = 0;
           $edit->save();
       }
       $actionbyid=Session::get('employeeid');

       $extendhistory = new Extendhistory();
       $extendhistory->userid = $edit->userid;
       $extendhistory->memberpackageid = $edit->memberpackagesid;
       $extendhistory->changedatename = 'Joindate';
       $extendhistory->oldjoindate = date('Y-m-d',strtotime($olddatefornotify));
       $extendhistory->newjoindate = date('Y-m-d',strtotime($newdatefornotify));
       $extendhistory->oldenddate = date('Y-m-d',strtotime($oldenddatefornotify));
       $extendhistory->newenddate = date('Y-m-d',strtotime($newenddatefornotify));
       $extendhistory->reason = $extendreason;
       $extendhistory->actionby = $actionbyid;
       $extendhistory->save();

         $notify=Notify::create([
                  
                  'userid'=> $id,
                 'details'=> ''.$loginuser.' changed joindate from '.$olddatefornotify.' to '.$newdatefornotify. ' and  expiredate from '.$oldenddatefornotify.' to '.$newenddatefornotify .' With ('.$extendreason.') Reason.',
                 'actionby' =>$actionbyid,

                ]); 
       

      $enddate = $edit->expiredate;
      $enddate=\Carbon\Carbon::parse($enddate)->format('d-m-Y');
      echo $enddate;
                  
    }
        public function changeenddate(Request $request){
          $loginuser = Session::get('username');

      $id= $request->get('id');      
      $extendreason= $request->get('extendreason');
      $packageid = $request->get('packageid');
      $newdate = $request->get('newdate');
      $newdatefornotify = \Carbon\Carbon::parse($newdate)->format('d-m-Y');
      $newdate = \Carbon\Carbon::parse($newdate)->format('Y-m-d');
      $edit = MemberPackages::find($packageid);
      $olddatefornotify = \Carbon\Carbon::parse($edit->expiredate)->format('d-m-Y');
      $edit->expiredate = $newdate;
      $edit->save();
      if($edit->expiredate >= date('Y-m-d')){
        $edit->status = 1;
        $edit->save();
      }else{
          $edit->status = 0;
          $edit->save();
      }
      $actionbyid=Session::get('employeeid');

            $extendhistory = new Extendhistory();
            $extendhistory->userid = $edit->userid;
            $extendhistory->memberpackageid = $edit->memberpackagesid;
            $extendhistory->changedatename = 'Enddate';
            $extendhistory->oldjoindate = $edit->joindate;
            $extendhistory->newjoindate = $edit->joindate;
            $extendhistory->oldenddate = date('Y-m-d',strtotime($olddatefornotify));
            $extendhistory->newenddate = date('Y-m-d',strtotime($newdatefornotify));
            $extendhistory->reason = $extendreason;
            $extendhistory->actionby = $actionbyid;
            $extendhistory->save();

       $notify=Notify::create([
                  
                  'userid'=> $id,
                 'details'=> ''.$loginuser.' changed expiredate from '.$olddatefornotify.' to '.$newdatefornotify .' With ('.$extendreason.') Reason.',
                 'actionby' =>$actionbyid,
                ]); 

      echo $edit;
                  
    }
    
    public function editpackage($id,Request $request)
    {   


         $method = $request->method();
        if ($request->isMethod('post')){
      
           $edit=MemberPackages::find($id);

             $Payment = Payment::where('UserId', $edit->User_id)->where('SchemeID',$edit->Scheme_id)->where('Mode','!=','-')->get()->first(); 
            $Payment->delete();
       $member = User::find($id)->get()->first();

       $MemberId=$member->id;
        $Memberpackages = Memberpackages::create([
          'User_id'=> $id,
          'Scheme_id'=> $request['SchemeID'],
          'Join_date'=> $request['Join_date'],
          'Expire_date'=> \Carbon\Carbon::parse($request['Expire_date'])->format('Y-m-d'),
          
          ]);
            
      // 
     $p=AdminMaster::where('Title','Tax')->get()->first();
  
        $mode= $request['Mode'];
         $remark= $request['Remark'];
         $amount= $request['Amount'];
         $ActualAmount = 0;
               $ReceiptNo = '';
$receipt = Payment::latest()->first();

if($receipt==null){
  $ReceiptNo = '1';
}
elseif($request['ReceiptNo']){
          $ReceiptNo = $request['ReceiptNo'];
         }
else{
  $ReceiptNo = $receipt->ReceiptNo+1;

}
  
       
          if($request->has('CashCredit')){
            $payment =  PaymentDetails::create([
              'ReceiptNo' =>  $ReceiptNo,   
              'Amount' =>    $request['CashCredit'],
            ]);
            $member = Member::Where('User_id',$id)->get()->first();
            $member->amount -= $request['CashCredit'];
            $member->save();

          }

        for ($n=0; $n < count($mode) ; $n++) { 

        $ActualAmount += $amount[$n];

         $payment =  Payment::create([
        'MemberId' =>  $MemberId,      
        'UserId' => $id,
        'ActualAmount' =>  $request['ActualAmount'],
        'Amount' =>  $amount[$n],
        'Tax' => $p->description,
        'TaxAmount' => $request['TaxAmount'],
        'Discount' => $request['Discount'],
        'DiscountAmount' => $request['DiscountAmount'],
        'Discount2' => $request['Discount2'],
        'Discount2Amount' => $request['Discount2Amount'],
        'Date' => $request['Date'],
        'PaymentDate' => now(),
        'Mode' => $request['Mode'][$n],
        'SchemeID' => $request['SchemeID'],

        'OtherChargesDetailsId' => $request['OtherChargesDetailsId'],
        'ExpenseId' => $request['ExpenseId'],
        'ExpenseDetailsId' => $request['ExpenseDetailsId'],
        'EmployeeId' => $request['EmployeeId'],
        'VoucherId' => $request['VoucherId'],
        'BillId' => $request['BillId'],
        'StoreBillId' => $request['StoreBillId'],
        'ReceiptNo' => $ReceiptNo,
        'EmployeeSalaryId' => $request['EmployeeSalaryId'],
        'Type' => 'Credit',
        'Remarks' =>  $remark[$n],

        
     ]);
       }
       
          $payment =  Payment::create([
        'MemberId' =>  $MemberId,      
        'UserId' => $id,
        'ActualAmount' =>  $request['ActualAmount'],
        'Amount' =>  $ActualAmount,
        'Tax' => $p->description,
        'TaxAmount' => $request['TaxAmount'],
        'Discount' => $request['Discount'],
        'DiscountAmount' => $request['DiscountAmount'],
        'Discount2' => $request['Discount2'],
        'Discount2Amount' => $request['Discount2Amount'],
        'Date' => $request['Date'],
        'PaymentDate' => now(),
        'Mode' =>'-',
        'SchemeID' => $request['SchemeID'],

        'OtherChargesDetailsId' => $request['OtherChargesDetailsId'],
        'ExpenseId' => $request['ExpenseId'],
        'ExpenseDetailsId' => $request['ExpenseDetailsId'],
        'EmployeeId' => $request['EmployeeId'],
        'VoucherId' => $request['VoucherId'],
        'BillId' => $request['BillId'],
        'StoreBillId' => $request['StoreBillId'],
        'ReceiptNo' => $ReceiptNo,
        'EmployeeSalaryId' => $request['EmployeeSalaryId'],
        'Type' => 'Debit',
        'Remarks' =>  '-',
        
     ]);
            return redirect('packageEdit/'.$id)->with('message','Succesfully edited');

     
        }

        $edit=MemberPackages::find($id);
        $useredit=User::where('id',$edit->User_id)->get()->first();
        $member=$useredit->Member;
        $Schemes=Scheme::get()->all();
         $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();
        $RootScheme = RootScheme::get()->all();
        $PaymentTypes = PaymentType::get()->all();

        $Payment = Payment::where('UserId', $edit->User_id)->where('SchemeID',$edit->Scheme_id)->where('Mode','!=','-')->get();
      
         return view('admin.editpackage',compact('id','edit','users','RootScheme','PaymentTypes','useredit','Schemes','member','Payment'));
    }
  public function assignPackage(Request $request)
    { 
        $method = $request->method();
        
    $username = $request->get('username');
    $MobileNo = $request->get('MobileNo');
      $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->where('member.status',1)->get()->all();
   
     // $users=User::where()get()->all();
      $RootScheme = RootScheme::get()->all();
    $PaymentTypes = PaymentType::get()->all();
   $ReceiptNo = '';
$receipt = Payment::latest()->first();

if($receipt==null){
  $ReceiptNo = '1';
}
elseif($request['ReceiptNo']){
          $ReceiptNo = $request['ReceiptNo'];
         }
else{
  $ReceiptNo = Payment::max('ReceiptNo');
  // $ReceiptNo = $receipt->ReceiptNo+1;

}
      $ReceiptNo = (Payment::max('receiptno')+1);
      $sgst = AdminMaster::where('title','sgst')->pluck('description')->first();
      $cgst = AdminMaster::where('title','cgst')->pluck('description')->first();

      $sgst = (int)$sgst;
      $cgst = (int)$cgst;
      $tax =  $sgst + $cgst;

      return view('admin.assignorrenewalpackage',compact('users','tax','RootScheme','PaymentTypes','ReceiptNo'));
    }
     public function getuser(Request $request)
    { 
        $method = $request->method();

      $username = $request->get('username');
      $MobileNo = $request->get('MobileNo');
     
          
      // $Payment2 = Payment::where('UserId',$user->id)->where('Type','Credit')->WhereNull('SchemeID')->get()->first(); 
            $usercase = Member::where('memberid',$username)->where('member.status',1)->get()->first();
           
      echo json_encode($usercase);
    }
    public function getusername(Request $request)
    {   
        $method = $request->method();

            $username = $request->get('username');

            $user = Member::where('memberid', $username)->where('member.status',1)->where('status',1)->get()->first();

    // dd($user);
            echo json_encode($user);
    }
    public function checktime(){

     $scheme = $_REQUEST['scheme'];
     $user_id = $_REQUEST['user_id'];

     $scheme = Scheme::where('schemeid', $scheme)->first();

     $scheme_from = date('H:i', strtotime($scheme->workinghourfrom));
     $scheme_to = date('H:i', strtotime($scheme->workinghourto));
	//dd( $scheme_from);
		//dd( $scheme_to);
     $member = member::where('userid', $user_id)->first();
    
     $member_from = date('H:i', strtotime($member->workinghourfrom));
     $member_to = date('H:i', strtotime($member->workinghourto));
	
     //if(!($member_from <= $scheme_from && $member_to >= $scheme_to)){
       if(!($scheme_from <= $member_from &&  $scheme_to >= $member_to)){
       return 202;
     } else {
       return 201;
     }
   }
   public function getuseridforpayment(Request $request)
    {   
        $method = $request->method();
        $username = $_REQUEST['username'];
        $user = Member::where('userid','=', $username)->whereIn('status',[1,2,0])->get()->first();
          
       // dd($user);
        echo json_encode($user);
    }

public function schemeforpayment(Request $request)
    {
      $id=$request->get('name');
      $userid=$request->get('id');
      $member=Member::where('userid',$userid)->get()->first();
      $gender=$member->gender;
   
   /*   if($gender=='Female'){
*/
       $row=DB::table('schemes')->select('schemeid','schemename','numberofdays','male','female')->where('rootschemeid','=',$id)->where('validity','>=', Carbon::now())->where('status','1')->get();
     /* }*/
      // elseif($gender=='Male'){
      //  $row=DB::table('schemes')->select('schemeid','schemename','numberofdays','male','female')->where('male',1)->where('rootschemeid','=',$id)->where('validity','>=', Carbon::now())->where('status','1')->get();
      //   //dd($row);
      // }
      echo json_encode($row);
    }
 public function memberpackagehistory(Request $request){
            $userid = $_REQUEST['userid'];
      $member_data = Member::join('payments', 'member.userid', 'payments.userid')
                    
                   // ->join('memberpackages', 'member.userid', 'memberpackages.userid')
                   // ->join('schemes', 'memberpackages.schemeid', 'schemes.schemeid')
                   ->where('member.status', 1)->whereIn('payments.mode', ['total','no mode'])->where('payments.invoicetype', 'm')->where('payments.status', 1)->where('member.userid', $userid)->get()->all();
                    // dd($member_data);
      if(!empty($member_data)){
        $member_package = '<table class="table">';
        $member_package .= '<tr><th colspan="5">Member Packages</th></tr>';
        $member_package .= '<tr>';
        $member_package .= '<th>Scheme Name</td>';
        $member_package .= '<th>Discount</td>';
        $member_package .= '<th>Amount</td>';
        $member_package .= '<th>Payment Date</td>';
        $member_package .= '<th>Join Date</td>';
        $member_package .= '<th>Expiry Date</td>';
        $member_package .= '</tr>';
        foreach($member_data as $member){
          $schemename=Scheme::where('schemeid',$member->schemeid)->get()->first();
          $member->schemename = $schemename->schemename;
          $memberpackage_data=MemberPackages::where('userid',$userid)->where('memberpackagesid',$member->invoiceno)->get()->first();
              if($memberpackage_data) {
        $member_package .= '<tr>';
        $member_package .= '<td>'.ucfirst($member->schemename).'</td>';
        $member_package .= '<td>'.$member->discountamount.'</td>';
        $member_package .= '<td>'.$member->amount.'</td>';
        $member_package .= '<td>'.date('d-m-Y', strtotime($member->date)).'</td>';
        $member_package .= '<td>'.date('d-m-Y', strtotime($memberpackage_data->joindate)).'</td>';
        $member_package .= '<td>'.date('d-m-Y', strtotime($memberpackage_data->expiredate)).'</td>';
        $member_package .= '</tr>';
      }
        }
        $member_package .= '</table>';
      }else{  
        $member_package = '';
      }
      return $member_package;
  }

}
