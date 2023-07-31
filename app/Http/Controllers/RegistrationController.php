<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Registration;
use Illuminate\Database\Eloquent\Collection;
use App\Department;
use App\Employee;
use App\Scheme;
use App\RegisterPaymentDetails;
use DB;
use PDF;
use App\OTPVerify;
use Carbon\Carbon;
// use Mail;
use App\Therapist;
use App\RootScheme;
use App\Apicheck;
use App\User;
use App\PaymentType;
use App\Company;
use App\UserTrack;
use App\Actionlog;
use App\Registrationpayment;
use Curl;
use Auth;
use App\Deviceusers;
use App\Payment;
use App\RegPaymentMaster;
use App\TransactionModel;
use App\Smssetting;
use App\Notificationmsgdetails;
use App\Emailsetting;
use Illuminate\Support\Facades\Mail;
use App\Emailnotificationdetails;

class RegistrationController extends Controller
{
  public function index()
  {

    return redirect('registration#tologin')->with('regtype');
  }

  public function create(Request $request)
  {

    $department = Department::get()->all();
    $therapist = Employee::where('status', 1)->whereIn('roleid', [4, 5])->get()->all();
    $rootscheme = RootScheme::get()->all();
    $packages = Scheme::get()->all();
    $registration_uid = Registration::select('id')->get()->last();
    $Registrationpayment = Registrationpayment::all();
    $regpaymenttype = RegPaymentMaster::where('status', 1)->get()->all();
    $regtypes = RegPaymentMaster::where('status', 1)->get()->all();




    if ($request->isMethod('post')) {


      $registration = Registration::insertregistration($request);
      $last_reg_id = DB::getPdo()->lastInsertId();
      $registration_id = RegisterPaymentDetails::insertregistrationpayment($request);

      $action = new Actionlog();
      $action->user_id = session()->get('admin_id');
      $action->ip = $request->ip();
      $action->action_type = 'create';
      $action->action = 'registration';
      $action->action_on = $registration_id;
      $action->save();

      $current_day = date('w', strtotime(date('Y-m-d')));
      if ($current_day == 5 || $current_day == 6) {
        $expiry_date = date('d-m-Y', strtotime($start_date . "+3 days"));
      } else {
        $expiry_date = date('d-m-Y', strtotime($start_date . "+2 days"));
      }



      $last_user_id = DB::getPdo()->lastInsertId();

      $action = new Actionlog();
      $action->user_id = session()->get('admin_id');
      $action->ip = $request->ip();
      $action->action_type = 'create';
      $action->action = 'user';
      $action->action_on = $last_user_id;
      $action->save();

      return view('admin.registration.reg_print');

      //return view('admin.Registration', compact('department','therapist','packages','registration','registration_uid'));

      //return view('admin.reg_print')->withHeaders(['refresh' => '3;url=google.com']);

    } else {
      return view('admin.registration.Registration', compact('rootscheme', 'department', 'therapist', 'packages', 'registration_uid', 'Registrationpayment', 'regtypes'));
    }
  }

  public function show(Request $request)
  {

    $registrationcoloum = DB::getSchemaBuilder()->getColumnListing('registration');
    /*********** */
    $fdate = $request->get('fdate');
    $tdate = $request->get('tdate');
    $username = $request->get('username');
    $mobileno = $request->get('mobileno');
    $keyword = $request->get('keyword');
    $smsmale = '';
    $smsfemale = '';
    $query = [];
    $query['fdate'] = $fdate;
    $query['tdate'] = $tdate;
    $query['mobileno'] = $mobileno;
    $query['username'] = $username;
    $query['keyword'] = $keyword;
    /*********** */
    $registrationfield = Registration::leftjoin('users', 'registration.id', 'users.regid')
      ->leftjoin('schemes', 'registration.package_id', 'schemes.schemeid')
      ->leftjoin('deviceusers', 'users.userid', 'deviceusers.userrefid')
      ->select('users.*', 'registration.*', 'schemes.*', 'registration.status as rstatus', 'deviceusers.*', 'deviceusers.expirydate as device_expirydate')
      ->where('registration.is_member', 0)
      ->where('registration.status', 1);

    /************** */
    if ($fdate != "") {
      $from = date($fdate);
      //$to = date($to);
      if (!empty($tdate)) {
        $to = date($tdate);
      } else {
        $to = date('Y-m-d');
      }
      // ->whereBetween('followupdays', [$from, $to])
      $registrationfield->whereDate('registration.created_at', '>=', $from)
        ->whereDate('registration.created_at', '<=', $to);
    }
    if ($tdate != "") {
      $to = date($tdate);
      if (!empty($fdate)) {
        $from = date($fdate);
      } else {
        $from = date('Y-m-d');
      }
      $registrationfield->whereDate('registration.created_at', '>=', $from)
        ->whereDate('registration.created_at', '<=', $to);
    }


    if ($username != "") {
      $registrationfield->where('id', $username);
    }
    if ($mobileno != "") {
      $registrationfield->where('id', $mobileno);
    }
    if ($keyword != "") {
      $registrationfield->where(function ($query) use ($keyword) {
        $query->where('firstname', 'LIKE', '%' . $keyword . '%')
          ->orwhere('email_id', 'LIKE', '%' . $keyword . '%')
          ->orwhere('lastname', 'LIKE', '%' . $keyword . '%')
          ->orwhere('gender', 'LIKE', '%' . $keyword . '%');
      });
    }

    $registrationfield = $registrationfield->orderBy('id', 'DESC')->paginate(20);

    $admin = Employee::where('role', 'admin')->get()->all();
    $users = Registration::where('is_member', 0)->get()->all();
    return view('admin.registration.view_registration', compact('users', 'registrationcoloum', 'registrationfield', 'admin', 'query'));
  }
  public  function generateregistrationPDF()
  {

    $data = ['title' => 'Welcome to HDTuto.com'];

    $pdf = PDF::loadview('admin.registration.pdfview', $data);

    return $pdf->download('invoice.pdf');
  }
  public  function viewregistrationdetails(Request $request, $id)
  {

    $phone_no = Registration::where('id', $id)->pluck('phone_no')->first();
    $registrations = Registration::where('phone_no', $phone_no)
      ->leftjoin('schemes', 'registration.package_id', 'schemes.schemeid')->orderBy('registration.created_at', 'desc')
      ->get(['registration.*', 'schemes.schemename', 'registration.status as rstatus', 'registration.created_at  as rdate'])->all();
    return view('admin.registration.viewregdetail', compact('registrations'));
  }
  public function receipt()
  {

    return view('admin.registration.pdfview');
  }

  public function otpverify(Request $request)
  {

    //dd($request);
    $rndno = rand(1000, 999999);
    $mobileno = $request->input('mobileno');
    $fname = $request->get('fname');
    $lname = $request->get('lname');

    $otpverify = [
      'mobileno'      => $mobileno,
      'email'         => $request->input('email'),
      'code'          => $rndno,
      'isexpired'    => '0',
      'created_at'     => date('Y-m-d  H:i:s'),
      'updated_at'     => date('Y-m-d  H:i:s'),
    ];


    DB::table('otpverify')->insert($otpverify);
    $last_id = DB::getPdo()->lastInsertId();


    $msg =   DB::table('messages')->where('messagesid', '17')->get()->first();


    $msg = $msg->message;
    $msg = str_replace("[FirstName]", $fname, $msg);
    $msg = str_replace("[LastName]", $lname, $msg);
    $msg = str_replace("[otp]", $rndno, $msg);

    $msg = urlencode($msg);

    $smssetting = Smssetting::where('status', 1)->where('smsonoff', 'Active')->first();

    if ($smssetting) {

      $u = $smssetting->url;
      $url = str_replace('$mobileno', $mobileno, $u);
      $url = str_replace('$msg', $msg, $url);

      $otpsend = Curl::to($url)->get();

      $action = new Actionlog();

      $action->user_id = session()->get('admin_id');
      $action->ip = $request->ip();
      $action->action_type = 'send';
      $action->action = 'OTP';
      $action->action_on = $last_id;
      $action->save();
    }
  }

  public function regresendotp(Request $request)
  {

    $rndno = rand(1000, 999999);
    $mobileno = $request['mobileno'];
    $fname = $request->input('fname');
    $lname = $request->input('lname');

    $otpverify = [
      'mobileno'      => $request['mobileno'],
      'email'         => $request->input('email'),
      'code'          => $rndno,
      'isexpired'    => '0',
      'created_at'     => date('Y-m-d  H:i:s'),
      'updated_at'     => date('Y-m-d  H:i:s'),
    ];

    DB::table('otpverify')->insert($otpverify);
    $last_id = DB::getPdo()->lastInsertId();


    $action = new Actionlog();
    $action->user_id = session()->get('admin_id');
    $action->ip = $request->ip();
    $action->action_type = 'resend';
    $action->action = 'OTP';
    $action->action_on = $last_id;

    $action->save();

    $msg =   DB::table('messages')->where('messagesid', '17')->get()->first();

    $msg = $msg->message;
    $msg = str_replace("[FirstName]", $fname, $msg);
    $msg = str_replace("[LastName]", $lname, $msg);
    $msg = str_replace("[otp]", $rndno, $msg);

    $msg = urlencode($msg);

    $smssetting = Smssetting::where('status', 1)->where('smsonoff', 'Active')->first();

    if ($smssetting) {

      $u = $smssetting->url;
      $url = str_replace('$mobileno', $mobileno, $u);
      $url = str_replace('$msg', $msg, $url);

      $otpsend = Curl::to($url)->get();

      # code...
    }
  }


  public function rpostverify(Request $request)
  {
    // dd($request);

    $department = Department::get()->all();
    $therapist = Therapist::get()->all();
    $packages = Scheme::get()->all();
    $regonnumber = Registration::where('phone_no', $request->mobileno)->get()->all();

    if ($regonnumber) {
      foreach ($regonnumber as $key => $value) {
        $value->status = '0';
        $value->save();
      }
    }
    $registration_uid = Registration::select('id')->get()->last();

    /*****************************************************************/
    //  DB::beginTransaction();
    // try{


    /*****************************************************************/
    Registration::create([

      'firstname' => $request->input('fname'),
      'lastname' => $request->input('lname'),
      'dob' =>  date("y-m-d H:i:s", strtotime($request->input('bdate'))),
      'designation' => $request->input('designation'),
      'phone_no' => $request->input('mobileno'),
      'email_id' => $request->input('email'),
      'credit_validity_day' => $request->input('validday'),
      'timing' => $request->input('timing'),
      'gender' => $request->input('gender'),
      'starting_date' => date('Y-m-d', strtotime($request->input('startingdate'))),
      'due_date' => date("Y-m-d H:i:s", strtotime($request->input('duedate'))),
      // 'ending_date' => $expiry_date, 
      'ending_date' => date('Y-m-d', strtotime($request->input('end_date'))),
      'department_id' => $request->input('department'),
      'therapist_id' => $request->input('therapist'),
      'package_id' => $request->input('package'),
      'regtypeid' => $request->input('regtypeid'),

      'created_at' => now(),
      'updated_at' => now(),

    ]);


    // $registration = Registration::insertregistration($request);


    $last_reg_id = DB::getPdo()->lastInsertId();

    // $registration_id = RegisterPaymentDetails::insertregistrationpayment($request);
    $fname = $request->input('fname');
    $lname = $request->input('lname');

    /**************************for user track************************************/

    // $user_track = new UserTrack();
    // $user_track->register_id = $last_reg_id;
    // $user_track->register_date = now();
    // $user_track->action_by = session()->get('admin_id');
    // $user_track->save();

    /************************end* for user track**************************************/

    /*  $action = new Actionlog();
          $action->user_id = session()->get('admin_id');
          $action->ip = $request->ip();
          $action->action_type = 'insert';
          $action->action = 'registration';
          $action->action_on = $last_reg_id;

          $action->save();

          $action = new Actionlog();
          $action->user_id = session()->get('admin_id');
          $action->ip = $request->ip();
          $action->action_type = 'insert';
          $action->action = 'registration payment';
          $action->action_on = $last_reg_id;

          $action->save();
        */

    $userexist = User::where('usermobileno', $request->mobileno)->get()->first();

    if (!$userexist) {

      $user = new User();
      $user->regid = $last_reg_id;
      $user->userroleid = 0;
      $user->usermobileno = $request->mobileno;
      $user->useremail = !empty($request->email) ? $request->email : '';
      $user->username = $request->fname . $request->lname;
      $user->userpassword = $request->fname . $request->lname;

      $user->userexpirydate =  date('Y-m-d', strtotime($request->input('end_date')));
      $user->userstatus = 'reg';
      $user->save();
      $last_user_id = $user->userid;
    } else {
      $userexist->regid = $last_reg_id;
      $userexist->userexpirydate = date('Y-m-d', strtotime($request->input('end_date')));
      $userexist->save();
      $last_user_id = $userexist->userid;
    }
    // $last_user_id = DB::getPdo()->lastInsertId();


    /**************************for device user************************************/


    /* $deviceuser = new Deviceusers();
          $deviceuser->userid = $last_user_id;
          $deviceuser->role = 0;
          $deviceuser->deviceusername = $request->fname.$request->lname;
          $deviceuser->serialnumber = 0;
          $deviceuser->expirydate = $expiry_date;
          $deviceuser->status = 'reg';
          $deviceuser->save();


          $last_deviceuser_id = DB::getPdo()->lastInsertId();

          $action = new Actionlog();
          $action->user_id = session()->get('admin_id');
          $action->ip = $request->ip();
          $action->action_type = 'create';
          $action->action = 'user';
          $action->action_on = $last_deviceuser_id;
          $action->save();
        */
    // $code = $request->get('otp');    
    // $mobileno = $request->get('mobileno');
    // return redirect('registrationdetails')->with('message','Succesfully Registerd');
    //  }
    $schemename = Scheme::where('schemeid', $request->input('package'))->get()->first();
    if ($schemename) {
      $schemename = $schemename->schemename;
    }
    $amount = $request->regtypeprice;
    if ($amount > 0) {
      $reg_fee = $amount;
      $scheme_id = $request->input('package');
      $transaction_no = hexdec(uniqid());

      $transaction = new TransactionModel();
      $transaction->transactionno = $transaction_no;
      $transaction->transactionuserid = $last_user_id;
      $transaction->paymenttypeid = 2;
      $transaction->transactiondate = date('Y-m-d');
      $transaction->transactionstatus = 0;
      $transaction->transactionamount = $amount;
      $transaction->transactionschemeid = $scheme_id;
      $transaction->save();

      $last_transaction_id = DB::getPdo()->lastInsertId();

      DB::commit();
      $success = true;

      $PaymentTypes = PaymentType::get()->all();
      $register_data = Registration::where('id', $last_reg_id)->get()->first();


      return view('admin.transaction.regstration.orderview')->with(compact('scheme_id', 'last_user_id', 'last_reg_id', 'amount', 'register_data', 'PaymentTypes', 'last_transaction_id', 'schemename', 'reg_fee'));
    } else {
      $regid_update = Registration::where('id', $last_reg_id)->first();
      if (!empty($regid_update)) {
        $regid_update->status = 1;
        $regid_update->save();
      }
      return redirect('registrationdetails')->with('message', 'Succesfully Registerd');
    }



    //     } catch(\Exception $e){
    //   $success = false;
    //   DB::rollback();
    // }

    //  if ($success == false) {
    //   return redirect('dashboard');

    //       }
  }

  /**************************end for device user************************************/


  //                         //'id        ' => $request->input('idno'),  
  //                         'code' => $request->input('otp'),
  //                     ];

  /************************** for otp verify ***********************************/


  /*    $q=OTPVerify::where('code',$code)->where('isexpired','!=','1')->where('created_at', '>',
         Carbon::now()->subMinute(30)->toDateTimeString())->first();

            
          if($q){
            $q->isexpired = 1;
            $q->save();

              if($q){
            echo ("<SCRIPT LANGUAGE='JavaScript'>
          window.alert('Succesfully Registered');
             </SCRIPT>");
            }

              $msg=   DB::table('messages')->where('messagesid','16')->get()->first();

              $msg =$msg->message;         
              $msg = str_replace("[FirstName]",$fname,$msg);
              $msg= str_replace("[LastName]",$lname,$msg);
                               

              $msg = urlencode($msg);

              $otpsend = Curl::to('http://sms.weybee.in/api/sendapi.php?auth_key=2169KrEMnx2ZgAqSfavSSC&mobiles='.$mobileno.'&message='.$msg.'&sender=PYOFIT&route=4')->get();

            $regresend = DB::table('registration')->where('phone_no', $mobileno)->first();


            return view('admin.registration.reg_print',compact('regresend'));

          }
          else{

              echo ("<SCRIPT LANGUAGE='JavaScript'>
          window.alert('OTP is incorrect !');
             </SCRIPT>");

            $regresend = DB::table('registration')->where('phone_no', $mobileno)->first();
          

              return view('admin.registration.regotpresend',compact('regresend'));

          }*/

  /************************** end for otp verify ***********************************/




  public function regpostverify(Request $request)
  {


    $code = $request->input('otp');

    $mobileno = $request['mobileno'];
    $fname = $request->input('fname');
    $lname = $request->input('lname');


    $regresend = DB::table('registration')->where('phone_no', $mobileno)->first();

    $code = $request->get('otp');

    $q = OTPVerify::where('code', $code)->where('isexpired', '!=', '1')->where(
      'created_at',
      '>',
      Carbon::now()->subMinute(30)->toDateTimeString()
    )->first();




    if ($q) {
      $q->isexpired = 1;
      $q->save();

      if ($q) {
        echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Succesfully Registered');
           </SCRIPT>");
      }

      $msg =   DB::table('messages')->where('messagesid', '16')->get()->first();

      $msg = $msg->message;
      $msg = str_replace("[FirstName]", $fname, $msg);
      $msg = str_replace("[LastName]", $lname, $msg);


      $msg = urlencode($msg);

      $smssetting = Smssetting::where('status', 1)->where('smsonoff', 'Active')->first();

      if ($smssetting) {

        $u = $smssetting->url;
        $url = str_replace('$mobileno', $mobileno, $u);
        $url = str_replace('$msg', $msg, $url);

        $otpsend = Curl::to($url)->get();

        # code...
      }


      $regresend = DB::table('registration')->where('phone_no', $mobileno)->first();

      return view('admin.registration.reg_print', compact('regresend'));


      // dd($this->request);
      // $query1="UPDATE otpverify SET is_expired = 1 WHERE otp = '" . $_POST["otp"] . "'";
      //return view('admin.verify')->with('message','User Verified');
    } else {
      // return view('admin.verify')->with('message','try again');
      echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('OTP is wrong. Please check otp !');
           </SCRIPT>");

      $regresend = DB::table('registration')->where('phone_no', $mobileno)->first();


      return view('admin.registration.regotpresend', compact('regresend'));
      //return view('admin.verify')->with('mobileno',$mobileno)->with('message','');
    }
  }

  public function AddBiometric()
  {

    echo "string";
  }

  public function convertmember($id, Request $request)
  {

    $regmo = $request->get('mobileno');
    $member = Registration::findOrFail($id);

    $registration = Registration::where('phone_no', $member->mobileno)->first();


    // if (!$registration) {

    //   return redirect('registration#tologin');
    // }

    $register_id = $id;
    $exerciseprogram = DB::getSchemaBuilder()->getColumnListing('exerciseprogram');
    $RootScheme = RootScheme::get()->all();
    $users = User::where('userstatus', 1)->get()->all();
    $PaymentTypes = PaymentType::get()->all();
    $company = Company::get()->all();

    $action = new Actionlog();

    $action->user_id = session()->get('admin_id');
    $action->ip = $request->ip();
    $action->action_type = 'create';
    $action->action = 'convert member';

    $action->save();
    $memfromreg = 'memfromreg';

    return view('admin.registration.addMemberfromconfirmreg', compact('member', 'exerciseprogram', 'RootScheme', 'users', 'PaymentTypes', 'company', 'register_id', 'memfromreg'));
  }

  public function schemeforregistration()
  {
    $id = $_REQUEST['root'];
    $scheme = Scheme::where('rootschemeid', $id)->where('validity', '>=', Carbon::now())->where('status', '1')->get();
    $option = '';
    if ($scheme->count() > 0) {
      $option .= '<option value="">--Select--</option>';
      foreach ($scheme as $package) {
        $option .= '<option value="' . $package->schemeid . '">' . $package->schemename . '</option>';
      }
    } else {
      $option .= '<option value="">--No package found--</option>';
    }
    return $option;
  }



  public function skipotp(Request $request)
  {

    $numberotp = $request->get('numberotp');

    $data = [

      $mobileno = $request->get('mobileno'),
      $fname = $request->get('fname'),
      $lname = $request->get('lname'),
      $email = $request->get('email'),
      $Designation = $request->get('Designation'),
      $rootscheme = $request->get('rootscheme'),
      $package = $request->get('package'),
      $therapist = $request->get('therapist'),
      $payment = $request->get('payment'),
      $time = $request->get('time'),
      $start_date = $request->get('start_date'),
      $due_date = $request->get('due_date'),
      $end_date = $request->get('end_date'),
      $regtype =  $request->get('regtype'),

    ];



    // print_r($data);exit;

    $skipotp = OTPVerify::where('mobileno', $mobileno)->get()->last();

    if ($numberotp == '') {

      $skipotp = DB::table('otpverify')->get()->last();

      $data = [
        'isexpired' => '2',
      ];

      DB::table('otpverify')->where('mobileno', '=', $mobileno)->update($data);

      //return redirect('inquiry');
      // return redirect('viewconfirmedinquiry');

    }

    $registration = Registration::insertregistration($request);

    $last_reg_id = DB::getPdo()->lastInsertId();

    $registration_id = RegisterPaymentDetails::insertregistrationpayment($request);


    $start_date = $request->input('startingdate');
    if (empty($start_date)) {
      $start_date = date('Y-m-d');
    }
    $current_day = date('w', strtotime(date('Y-m-d')));
    if ($current_day == 5 || $current_day == 6) {
      $expiry_date = date('Y-m-d', strtotime($start_date . "+3 days"));
    } else {
      $expiry_date = date('Y-m-d', strtotime($start_date . "+2 days"));
    }


    $user = new User();
    $user->regid = $last_reg_id;
    $user->userroleid = 0;
    $user->usermobileno = $request->mobileno;
    $user->useremail = !empty($request->email) ? $request->email : '';
    $user->username = $request->fname . $request->lname;
    $user->userexpirydate = $expiry_date;
    $user->userstatus = 'reg';
    $user->save();


    $last_user_id = DB::getPdo()->lastInsertId();

    /***********************#########deviceuser table related ****************************************/

    // $deviceuser = new Deviceusers();
    // $deviceuser->userid = $last_user_id;
    // $deviceuser->role = 0;
    // $deviceuser->deviceusername = $request->fname.$request->lname;
    // $deviceuser->serialnumber = 0;
    // $deviceuser->expirydate = $expiry_date;
    // $deviceuser->status = 'reg';
    // $deviceuser->save();



    // $last_deviceuser_id = DB::getPdo()->lastInsertId();

    // $action = new Actionlog();
    // $action->user_id = session()->get('admin_id');
    // $action->ip = $request->ip();
    // $action->action_type = 'create';
    // $action->action = 'user';
    // $action->action_on = $last_deviceuser_id;
    // $action->save();

    /***********************END #########deviceuser table related ****************************************/
  }

  public function sendotptoadmin(Request $request)
  {

    $admin_id = $_REQUEST['admin_id'];

    $admin_data = Employee::where('employeeid', $admin_id)->first();
    if (!empty($admin_data)) {
      $contact_no = $admin_data->mobileno;
      $first_name = $admin_data->first_name;
      $last_name = $admin_data->last_name;
      $email = $admin_data->email;
    }

    $rndno = rand(1000, 999999);
    $mobileno = $contact_no;
    $fname = $first_name;
    $lname = $last_name;
    $email = $email;

    //insert into table
    $otpverify = [
      'mobileno'      => $mobileno,
      'email'         => $email,
      'code'          => $rndno,
      'isexpired'    => '0',
      'created_at'     => date('Y-m-d  H:i:s'),
      'updated_at'     => date('Y-m-d  H:i:s'),
    ];

    DB::table('otpverify')->insert($otpverify);
    $last_id = DB::getPdo()->lastInsertId();

    $action = new Actionlog();
    $action->user_id = session()->get('admin_id');
    $action->ip = $request->ip();
    $action->action_type = 'resend';
    $action->action = 'OTP';
    $action->action_on = $last_id;

    $action->save();

    $msg =   DB::table('messages')->where('messagesid', '37')->get()->first();

    $msg = $msg->message;
    $msg = str_replace("[firstname]", ucfirst($fname), $msg);
    $msg = str_replace("[lastname]", ucfirst($lname), $msg);
    $msg = str_replace("[otp]", $rndno, $msg);

    $msg = urlencode($msg);

    $smssetting = Smssetting::where('status', 1)->where('smsonoff', 'Active')->first();

    if ($smssetting) {

      $u = $smssetting->url;
      $url = str_replace('$mobileno', $mobileno, $u);
      $url = str_replace('$msg', $msg, $url);

      $otpsend = Curl::to($url)->get();

      # code...
    }

    if (strpos($otpsend, 'success') !== false) {
      $success = true;
    }

    if ($success == true) {
      return response()->json($success);
    }
  }

  // public function setextendedregdate(Request $request){

  //   $otp = $_REQUEST['otp'];
  //   $admin_id = $_REQUEST['admin_id'];
  //   $extend_date = $_REQUEST['extend_date'];
  //   $deviceusersid = $_REQUEST['deviceusersid'];
  //   $deviceip = config('constants.localip');

  //   $admin_data = Employee::where('employeeid', $admin_id)->first();
  //   if(!empty($admin_data)){
  //     $contact_no = $admin_data->mobileno;
  //   } 

  //   $otp_verify = DB::table('otpverify')->where('mobileno', $contact_no)->orderBy('otpverifyid', 'desc')->latest()->first();

  //   if($otp_verify->code == $otp){

  //     $otp_verify->isexpired = 1;
  //     $otp_verify_id = $otp_verify->otpverifyid;
  //     DB::table('otpverify')->where('mobileno', $contact_no)->where('otpverifyid', $otp_verify_id)->update(['isexpired' => 1]);

  //     $extend_date_device = date('d-m-Y', strtotime($extend_date));

  //     $regsetexpiry = Curl::to('http://'.$deviceip.':8080/iclock/api/WebAPI/SetUserExpiration?SerialNumber=DC67C417C3749B37&StaffBiometricCode='.$deviceusersid.'&ExpirationDate='.$extend_date_device.'')->get();
  //       $success_msg = json_decode($regsetexpiry);
  //       if($success_msg != null){
  //         if($success_msg->Message == 'Command Send Successfully.'){

  //           $apickeck = new Apicheck();
  //           $apickeck->apitype = 'registration extend';
  //           $apickeck->deviceuserid = $deviceusersid;
  //           $apickeck->fullname = !empty($fullname) ? $fullname : '';
  //           $apickeck->apiresponse = $success_msg->Message;
  //           $apickeck->apidateofuser = date('Y-m-d', strtotime($extend_date));
  //           $apickeck->apistatus = 1;
  //           $apickeck->save();

  //           $deviceuser = Deviceusers::where('deviceusersid', $deviceusersid)->first();
  //           if(!empty($deviceuser)){
  //             $userid = $deviceuser->userid;
  //             $deviceuser->expirydate = date('Y-m-d', strtotime($extend_date));
  //             $deviceuser->save();

  //             $user_data = User::where('userid', $userid)->first();
  //             if(!empty($user_data)){
  //               $user_data->userexpirydate = date('Y-m-d', strtotime($extend_date));
  //               $user_data->save();

  //               return response()->json('date is extended');
  //             }
  //           }
  //         } else {

  //           $apickeck = new Apicheck();
  //           $apickeck->apitype = 'registration extend';
  //           $apickeck->deviceuserid = $id;
  //           $apickeck->fullname = !empty($fullname) ? $fullname : '';
  //           $apickeck->apiresponse = $success_msg;
  //           $apickeck->apidateofuser = date('Y-m-d', strtotime($extend_date));
  //           $apickeck->apistatus = 2;
  //           $apicheck->save();

  //           return "device problem";
  //         }
  //       } else {

  //         $apickeck = new Apicheck();
  //         $apickeck->apitype = 'registration not extend';
  //         $apickeck->deviceuserid = $id;
  //         $apickeck->apifullname = !empty($fullname) ? $fullname : '';
  //         $apickeck->apiresponse = $success_msg;
  //         $apickeck->apidateofuser = date('Y-m-d', strtotime($extend_date));
  //         $apickeck->apistatus = 2;
  //         $apicheck->save();

  //         return "device problem";

  //       }

  //   } else {
  //     return response()->json('opt wrong');
  //   }

  // }
  public function deletereg($id)
  {

    $reg_delete = Registration::where('id', $id)->first();
    if (!empty($reg_delete)) {
      $reg_delete->status = 3;
      $reg_delete->save();
    }

    return redirect('registrationdetails')->with('message', 'Registration is deleted successfully.');
  }
  public function expirreg()
  {

    $registration = Registration::leftjoin('users', 'registration.id', 'users.regid')
      ->leftjoin('schemes', 'registration.package_id', 'schemes.schemeid')
      ->leftjoin('deviceusers', 'users.userid', 'deviceusers.userid')
      ->leftjoin('regpaymentmaster', 'registration.regtypeid', 'regpaymentmaster.regpaymentid')
      ->select('users.*', 'registration.*', 'registration.status as rstatus', 'deviceusers.*', 'deviceusers.expirydate as device_expirydate', 'schemes.*', 'regpaymentmaster.*')
      ->where('registration.is_member', 0)
      ->where('registration.status', 3)
      ->orderBy('id', 'DESC')
      ->get()
      ->all();

    return view('admin.registration.deleteregistration')->with(compact('registration'));
  }
  public function loadreghistory(Request $request)
  {
    $mobileno = $request->get('mobileno');
    $reghistory = DB::table('registration')->select('registration.*', 'regpaymentmaster.*', 'registration.created_at AS regcreatedate')->leftjoin('regpaymentmaster', 'regpaymentmaster.regpaymentid', 'registration.regtypeid')
      ->where('registration.phone_no', $mobileno)->get()->all();
    // dd($reghistory);
    echo json_encode($reghistory);
  }
  public function getpriceofregtype(Request $request)
  {
    $regtypeid = $request->get('regtype');
    $price = RegPaymentMaster::where('regpaymentid', $regtypeid)->where('status', 1)->get()->first();
    $priceofregtype = $price->amount;
    // dd($reghistory);
    echo json_encode($priceofregtype);
  }

  /* public function setextendedregdate(Request $request){

      $otp = $_REQUEST['otp'];
      $admin_id = $_REQUEST['admin_id'];
      $extend_date = $_REQUEST['extend_date'];
      $deviceusersid = $_REQUEST['deviceusersid'];

      $admin_data = Employee::where('employeeid', $admin_id)->first();
      if(!empty($admin_data)){
        $contact_no = $admin_data->mobileno;
      } 

      $otp_verify = DB::table('otpverify')->where('mobileno', $contact_no)->orderBy('otpverifyid', 'desc')->latest()->first();

      if($otp_verify->code == $otp){

        $otp_verify->isexpired = 1;
        $otp_verify_id = $otp_verify->otpverifyid;
        DB::table('otpverify')->where('mobileno', $contact_no)->where('otpverifyid', $otp_verify_id)->update(['isexpired' => 1]);

        $deviceuser = Deviceusers::where('deviceusersid', $deviceusersid)->first();
        if(!empty($deviceuser)){
          $userid = $deviceuser->userid;
          $deviceuser->expirydate = date('Y-m-d', strtotime($extend_date));
          $deviceuser->save();

          $user_data = User::where('userid', $userid)->first();
          if(!empty($user_data)){
            $user_data->userexpirydate = date('Y-m-d', strtotime($extend_date));
            $user_data->save();

            $apickeck = new Apicheck();
            $apickeck->apitype = 'registration extend';
            $apickeck->deviceuserid = $deviceusersid;
            $apickeck->apifullname = !empty($fullname) ? $fullname : '';
            $apickeck->apiresponse = '';
            $apickeck->apidateofuser = date('Y-m-d', strtotime($extend_date));
            $apickeck->apistatus = 1;
            $apickeck->save();

            return response()->json('date is extended');
          }
        }
      } else {
        return response()->json('opt wrong');
      }
    }*/
}
