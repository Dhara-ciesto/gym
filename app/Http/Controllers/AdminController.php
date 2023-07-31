<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Hash;
use App\Admin;
use App\Member;
use App\Files;
use Illuminate\Support\Facades\Input;
use Session;
use Carbon\Carbon;
use App\Payment;
use App\Role;
use App\MemberPackages;
use App\Scheme;
use App\User_log;
use App\User;
use App\DeviceFetchlogs;
use Illuminate\Pagination\LengthAwarePaginator;
use DateTime;
use App\Inquiry;
use App\Followup;
use Mail;
use App\Registration;
use App\ApiTrack;
use PHPMailerAutoload;
use Curl;
use App\Ptmember;
use App\Measurement;
use App\RootScheme;
use App\LeaveEntry;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('admin.dashboad');
    }

    public function dashboard(Request $request)
    {


        // $startdate = date('Y-m-d');
        // $expensepayment1 = DB::table('expensepayment')->select(DB::raw('SUM(amount) as amount'))->get();
        // $expensepayment2 = DB::table('expensepayment')->Where('dte', '=', $startdate)->select(DB::raw('SUM(amount) as amount'))->get();
        // $today = Carbon::today();
        // $today = $today->format('Y-m-d');
        // $numberofinquiry = 0;
        // $numberofinquirytoday = 0;
        // $numberofinquirythismonth = '';
        // $data = [];
        // $inq = DB::table('inquiries')->where('createddate', $today)->get()
        //     ->all();
        // if ($inq) {
        //     $numberofinquirytoday = count($inq);
        // }

        // $inquirytotal = DB::table('inquiries')->get()
        //     ->all();
        // $numberofinquirytotal = count($inquirytotal);
        // $data['numberofinquirytoday'] = $numberofinquirytoday;
        // $month = date('m');
        // $data['numberofinquirythismonth'] = DB::table('inquiries')->whereMonth('created_at', '=', $month)->get()
        //     ->count();

        // $data['numberofinquirytotal'] = $numberofinquirytotal;

        // $numberofmembertoday = 0;
        // $member = DB::table('member')->where('createddate', $today)->get()
        //     ->all();

        // if ($member) {
        //     $numberofmembertoday = count($member);
        // }
        // $male = DB::table('member')->where('gender', 'Male')->where('status', '1')->get()
        //     ->all();
        // $female = DB::table('member')->where('gender', 'Female')->where('status', '1')->get()
        //     ->all();

        // $membertotal2 = DB::table('member')->where('status', '1')->get()
        //     ->all();
        // $membertotal = DB::table('member')->get()
        //     ->all();
        // $numberofmembertotal = count($membertotal);
        // $numberofmembertotal2 = count($membertotal2);
        // $numberofmale = count($male);

        // $numberoffemale = count($female);

        // $data['numberofmembertotal2'] = $numberofmembertotal2;
        // $data['numberofmale'] = $numberofmale;

        // $data['numberoffemale'] = $numberoffemale;


        // $data['numberofmembertotal'] = $numberofmembertotal;
        // $data['numberofmembertoday'] = $numberofmembertoday;
        // $data['numberofmemberthismonth'] = DB::table('inquiries')->whereMonth('created_at', $month)->get()
        //     ->count();

        // $followup = Inquiry::leftjoin('followup', 'followup.inquiryid', 'inquiries.inquiriesid')->where('followup.followupdays', date('Y-m-d'))
        //     ->where('followup.status', "1")
        //     ->paginate(5);
        // $users = User::get()->all();
        // $regs = Registration::get()->all();
        // $regstoday = Registration::whereDate('created_at', $today)->get()
        //     ->all();
        // $registrationtoday = count($regstoday);
        // $registrationtotal = count($regs);
        // $data['registrationtoday'] = $registrationtoday;
        // $data['registrationtotal'] = $registrationtotal;

        // $data['reregistration'] = Registration::select('phone_no')->selectRaw('count(`phone_no`) as `occurences`')
        //     ->groupBy('phone_no')
        //     ->having('occurences', '>', 1)
        //     ->get()
        //     ->count();
        // $paymenttoday = 0;

        // $payment = DB::table('payments')->where('date', $today)->whereIn('mode', ['no mode', 'total'])
        //     ->get()
        //     ->all();
        // if ($payment) {
        //     $paymenttoday = count($payment);
        // }
        // $paymenttotal = DB::table('payments')->where('mode', 'no mode')
        //     ->orwhere('mode', 'total')
        //     ->get()
        //     ->all();
        // $paymenttotal = count($paymenttotal);
        // $data['paymenttotal'] = $paymenttotal;
        // $data['paymenttoday'] = $paymenttoday;

        // // $payment = Payment::select(['payments.memberid as mid','payments.*'])->with('Scheme.RootScheme')->leftJoin('member','member.memberid','=','payments.memberid')->where('mode','!=','total')->paginate(10);
        // // DB::enableQueryLog();
        // $allrootschemes  = RootScheme::where('status', 1)->get()->all();
        // foreach ($allrootschemes as $key => $value) {
        //     $schemes = Scheme::where('rootschemeid', $value->rootschemeid)->pluck('schemeid')->all();
        //     $value->schemeids = $schemes;
        //     $value->payments = array();
        //     $value->yeartotal = 0;
        //     $value->monthtotal = 0;
        //     $value->todaytotal = 0;
        //     foreach ($value->schemeids as $key => $onevalue) {
        //         $payments = Payment::where('schemeid', $onevalue)
        //             ->whereIn('mode', ['total', 'no mode'])
        //             // ->whereYear("date",date('Y'))
        //             ->select(DB::raw('sum(amount) AS total'))
        //             ->pluck('total')->first();
        //         if ($payments) {
        //             $value->yeartotal = $value->yeartotal + $payments;
        //         }
        //         $monthpayments = Payment::where('schemeid', $onevalue)
        //             ->whereIn('mode', ['total', 'no mode'])
        //             ->whereMonth("date", date('m'))
        //             ->whereYear("date", date('Y'))
        //             ->select(DB::raw('sum(amount) AS total'))
        //             ->pluck('total')->first();
        //         if ($payments) {
        //             $value->monthtotal = $value->monthtotal + $monthpayments;
        //         }
        //         $todaypayments = Payment::where('schemeid', $onevalue)
        //             ->whereIn('mode', ['total', 'no mode'])
        //             ->whereMonth("date", date('m'))
        //             ->whereYear("date", date('Y'))
        //             ->whereDay("date", date('d'))
        //             ->select(DB::raw('sum(amount) AS total'))
        //             ->pluck('total')->first();
        //         if ($payments) {
        //             $value->todaytotal =  $value->todaytotal + $todaypayments;
        //         }
        //     }
        // }
        // // dd($allrootschemes );

        // $year = date('Y');
        // $month = date('m');
        // $day = date('d');
        // $monthtotal = '';
        // $daytotal = '';
        // // dd($year);
        // $filterquery = DB::select("SELECT tmp3.rootschemeid, tmp3.rootschemename,tmp3.date, tmp3.Total, DATE_FORMAT(STR_TO_DATE(tmp3.date, '%d-%m-%Y'), '%m') Month from (SELECT tmp2.rootschemeid, rootschemes.rootschemename,tmp2.date, SUM(tmp2.Total) Total from rootschemes JOIN (SELECT tmp1.rootschemeid, rootschemes.rootschemename, tmp1.schemeid, tmp1.date, tmp1.Total from rootschemes join (select schemes.rootschemeid, temp.schemeid, temp.date, temp.Total from schemes JOIN (SELECT payments.schemeid, DATE_FORMAT(payments.date, '%d-%m-%Y') date, SUM(payments.amount) Total FROM `payments`  left join schemes on schemes.schemeid = payments.schemeid  where payments.mode IN('total','no mode') GROUP by payments.schemeid, DATE_FORMAT(payments.date, '%d-%m-%Y') ) temp on schemes.schemeid = temp.schemeid) tmp1 on rootschemes.rootschemeid = tmp1.rootschemeid ORDER BY tmp1.date) tmp2 on rootschemes.rootschemeid = tmp2.rootschemeid GROUP by tmp2.date, tmp2.rootschemeid, rootschemes.rootschemename) tmp3 ");

        // foreach ($filterquery as $key => $value) {

        //     $monthtotal = DB::select("SELECT tmp3.rootschemeid, tmp3.rootschemename,tmp3.date, tmp3.Total, DATE_FORMAT(STR_TO_DATE(tmp3.date, '%d-%m-%Y'), '%m') Month from (SELECT tmp2.rootschemeid, rootschemes.rootschemename,tmp2.date, SUM(tmp2.Total) Total from rootschemes JOIN (SELECT tmp1.rootschemeid, rootschemes.rootschemename, tmp1.schemeid, tmp1.date, tmp1.Total from rootschemes join (select schemes.rootschemeid, temp.schemeid, temp.date, temp.Total from schemes JOIN (SELECT payments.schemeid, DATE_FORMAT(payments.date, '%d-%m-%Y') date, SUM(payments.amount) Total FROM `payments`  left join schemes on schemes.schemeid = payments.schemeid where payments.mode IN('total','no mode') GROUP by payments.schemeid, DATE_FORMAT(payments.date, '%d-%m-%Y') ) temp on schemes.schemeid = temp.schemeid) tmp1 on rootschemes.rootschemeid = tmp1.rootschemeid ORDER BY tmp1.date) tmp2 on rootschemes.rootschemeid = tmp2.rootschemeid GROUP by tmp2.date, tmp2.rootschemeid, rootschemes.rootschemename) tmp3 WHERE DATE_FORMAT(STR_TO_DATE(tmp3.date, '%d-%m-%Y'), '%m') = " . $month . "");
        //     //  DB::enableQueryLog();


        //     $daytotal = DB::select("SELECT tmp3.rootschemeid, tmp3.rootschemename,tmp3.date, tmp3.Total, DATE_FORMAT(STR_TO_DATE(tmp3.date, '%d-%m-%Y'), '%m') Month from (SELECT tmp2.rootschemeid, rootschemes.rootschemename,tmp2.date, SUM(tmp2.Total) Total from rootschemes JOIN (SELECT tmp1.rootschemeid, rootschemes.rootschemename, tmp1.schemeid, tmp1.date, tmp1.Total from rootschemes join (select schemes.rootschemeid, temp.schemeid, temp.date, temp.Total from schemes JOIN (SELECT payments.schemeid, DATE_FORMAT(payments.date, '%d-%m-%Y') date, SUM(payments.amount) Total FROM `payments` left join schemes on schemes.schemeid = payments.schemeid where payments.mode IN('total','no mode') GROUP by payments.schemeid, DATE_FORMAT(payments.date, '%d-%m-%Y') ) temp on schemes.schemeid = temp.schemeid) tmp1 on rootschemes.rootschemeid = tmp1.rootschemeid ORDER BY tmp1.date) tmp2 on rootschemes.rootschemeid = tmp2.rootschemeid GROUP by tmp2.date, tmp2.rootschemeid, rootschemes.rootschemename) tmp3 WHERE  DATE_FORMAT(STR_TO_DATE(tmp3.date, '%d-%m-%Y'), '%d') = " . $day . " and DATE_FORMAT(STR_TO_DATE(tmp3.date, '%d-%m-%Y'), '%m') = " . $month . " and DATE_FORMAT(STR_TO_DATE(tmp3.date, '%d-%m-%Y'), '%Y') = " . $year . "");
        //     //SELECT tmp3.rootschemeid, tmp3.rootschemename,tmp3.date, tmp3.Total, DATE_FORMAT(STR_TO_DATE(tmp3.date, '%d-%m-%Y'), '%m') Month from (SELECT tmp2.rootschemeid, rootschemes.rootschemename,tmp2.date, SUM(tmp2.Total) Total from rootschemes JOIN (SELECT tmp1.rootschemeid, rootschemes.rootschemename, tmp1.schemeid, tmp1.date, tmp1.Total from rootschemes join (select schemes.rootschemeid, temp.schemeid, temp.date, temp.Total from schemes JOIN (SELECT payments.schemeid, DATE_FORMAT(payments.date, '%d-%m-%Y') date, SUM(payments.amount) Total FROM `payments` left join schemes on schemes.schemeid = payments.schemeid GROUP by payments.schemeid, DATE_FORMAT(payments.date, '%d-%m-%Y') ) temp on schemes.schemeid = temp.schemeid) tmp1 on rootschemes.rootschemeid = tmp1.rootschemeid ORDER BY tmp1.date) tmp2 on rootschemes.rootschemeid = tmp2.rootschemeid GROUP by tmp2.date, tmp2.rootschemeid, rootschemes.rootschemename) tmp3 WHERE  DATE_FORMAT(STR_TO_DATE(tmp3.date, '%d-%m-%Y'), '%d') = "06" and DATE_FORMAT(STR_TO_DATE(tmp3.date, '%d-%m-%Y'), '%m') = "01" and DATE_FORMAT(STR_TO_DATE(tmp3.date, '%d-%m-%Y'), '%Y') = "2020"
        //     // $daytotal=DB::select("SELECT SUM(amount)Total,schemes.rootschemeid FROM payments JOIN schemes on schemes.schemeid = payments.schemeid WHERE date='".$today."' GROUP BY(schemes.rootschemeid)");
        //     // dd(DB::getQueryLog());

        // }

        // $total = 0;
        // foreach ($filterquery as $key => $value) {
        //     $total += $value->Total;
        // } //WHERE DATE_FORMAT(STR_TO_DATE(tmp3.date, '%d-%m-%Y'), '%m') = ".$month."  dd(DB::getQueryLog());
        // $today_date = date('Y-m-d');
        // $finalarray = [];
        // $finalarray['filterquery'] = $filterquery;
        // $finalarray['daytotal'] = $daytotal;
        // $finalarray['monthtotal'] = $monthtotal;

        // $rootschemes = Payment::where('payments.schemeid', '!=', 0)->leftjoin('schemes', 'schemes.schemeid', 'payments.schemeid')
        //     ->groupBy('schemes.rootschemeid')
        //     ->get(['schemes.rootschemeid'])
        //     ->all();

        // foreach ($rootschemes as $key => $value) {
        //     $rootschemename = RootScheme::where('rootschemeid', $value->rootschemeid)
        //         ->pluck('rootschemename')
        //         ->first();

        //     foreach ($finalarray['daytotal'] as $key => $value1) {
        //         if ($value1->rootschemeid == $value->rootschemeid) {
        //             $value['daywisetotal'] += $value1->Total;
        //             $value['rootschemename'] = $rootschemename;
        //         }
        //     }
        //     foreach ($finalarray['monthtotal'] as $key => $value1) {
        //         if ($value1->rootschemeid == $value->rootschemeid) {
        //             $value['monthwisetotal'] += $value1->Total;
        //             $value['rootschemename'] = $rootschemename;
        //         }
        //     }
        //     foreach ($filterquery as $key => $value1) {
        //         if ($value1->rootschemeid == $value->rootschemeid) {
        //             $value['yearwisetotal'] += $value1->Total;
        //             $value['rootschemename'] = $rootschemename;
        //         }
        //     }
        // }
        // $collection = $rootschemes;
        // $duepayment = Payment::leftJoin('member', 'member.memberid', '=', 'payments.memberid')
        //     ->whereRaw('paymentid IN (select MAX(paymentid) FROM payments GROUP BY memberid)')
        //     ->where('payments.remainingamount', '>', 0)
        //     ->paginate(1000);

        // $packageexpirenearlydate = date('Y-m-d');
        // $packageexpirenearly = [];

        // $now = date('Y-m-d', strtotime(' + 15 days'));
        // $userids = MemberPackages::where('memberpackages.status', 1)
        //     ->leftjoin('member', 'member.userid', 'memberpackages.userid')
        //     ->groupBy('memberpackages.userid')
        //     // ->where('max(memberpackages.expiredate)', '<', $now)
        //     ->havingRaw('MAX(memberpackages.expiredate) < ?', [$now])
        //     ->pluck('memberpackages.userid')->all();
        // // dd($userids);
        // // $packages = MemberPackages::where('memberpackages.status', 1)
        // //     ->leftjoin('member', 'member.userid', 'memberpackages.userid')
        // //     ->leftjoin('schemes', 'schemes.schemeid', 'memberpackages.schemeid')
        // //     ->where('memberpackages.expiredate', '<', $now)
        // //     ->where('memberpackages.expiredate','>',$packageexpirenearlydate)
        // //     ->orderBy('expiredate','asc')->get()->all();
        // // dd($packages);
        // foreach ($userids as $key => $userid) {
        //     $r =  MemberPackages::where('memberpackages.status', 1)
        //         ->where('memberpackages.userid', $userid)
        //         ->leftjoin('member', 'member.userid', 'memberpackages.userid')
        //         ->leftjoin('schemes', 'schemes.schemeid', 'memberpackages.schemeid')
        //         // ->where('memberpackages.expiredate', MemberPackages::max('expiredate'))
        //         ->where('memberpackages.expiredate', '<', $now)
        //         ->where('memberpackages.expiredate', '>', $packageexpirenearlydate)
        //         ->orderBy('expiredate', 'asc')
        //         ->get()->first();
        //     if ($r) {
        //         // dd($r);
        //         // $r = MemberPackages::where('memberpackages.status', 1)
        //         // ->where('memberpackages.expiredate', '<', $now)
        //         // ->where('memberpackages.expiredate','>',$packageexpirenearlydate)
        //         // ->leftjoin('member', 'member.userid', 'memberpackages.userid')
        //         //     ->leftjoin('schemes', 'schemes.schemeid', 'memberpackages.schemeid')
        //         //     ->where('schemes.rootschemeid', '=', $pack->rootschemeid)
        //         //     ->where('memberpackages.expiredate', '>', $pack->expiredate)
        //         //     ->get()
        //         //     ->all();
        //         $date1 = date_create($r->expiredate);
        //         $date2 = date_create(date('Y-m-d'));

        //         $diff = date_diff($date2, $date1);
        //         if ($diff) {
        //             // $r->diff = $diff->interval;
        //             $r->diff = $diff->format("%R%a days");
        //             array_push($packageexpirenearly, $r);
        //         }
        //     }
        //     // if ($r)
        //     // {

        //     // }
        //     // else
        //     // {
        //     //     // dd($pack);
        //     //     $date1 = date_create($pack->expiredate);
        //     //     $date2 = date_create(date('Y-m-d'));

        //     //     $diff = date_diff($date2, $date1);
        //     //     /*if diff is positive*/
        //     //     if ($diff->invert == 0)
        //     //     {
        //     //         if ($diff->days == 0)
        //     //         {
        //     //             $diff = 'Today';
        //     //             $pack->diff = $diff;
        //     //         }
        //     //         else
        //     //         {
        //     //             $diff = $diff->format("%R%a days");
        //     //             $pack->diff = $diff;
        //     //         }

        //     //         array_push($packageexpirenearly, $pack);
        //     //     }
        //     //     /*if diff is negative*/
        //     //     else
        //     //     {
        //     //         $diff = $diff->format("%R%a days");
        //     //         if ($diff <= - 7)
        //     //         {
        //     //         }
        //     //         else
        //     //         {
        //     //             // $diff=$diff->format("%R%a days");
        //     //             $pack->diff = 'Expired';
        //     //             array_push($packageexpirenearly, $pack);

        //     //         }
        //     //     }
        //     // }

        // }
        // // dd( $packageexpirenearly);
        // $currentPage = LengthAwarePaginator::resolveCurrentPage();
        // $packageexpirenearly = collect($packageexpirenearly);
        // $perPage = 10;
        // $currentPageItems = $packageexpirenearly->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        // $paginatedItems = new LengthAwarePaginator($currentPageItems, count($packageexpirenearly), $perPage);
        // $paginatedItems->setPath($request->url());
        // $packageexpirenearly = $paginatedItems;

        // $today = date('Y-m-d 00:00:00');

        // $membercounttoday = '';
        // $membercounttotal = '';
        // $membercounttoday = User_log::leftjoin('users', 'users.userid', 'user_log.UserId')->where('user_log.PunchDateTime', 'LIKE', $today)->where('user_log.UserId', '!=', 0)
        //     ->whereIn('users.userstatus', ['reg', 'mem'])
        //     ->get()
        //     ->all();
        // // dd($today);
        // // dd($membercounttoday);
        // $membercounttoday = count($membercounttoday);

        // $membercounttotal = User_log::leftjoin('users', 'users.userid', 'user_log.UserId')->where('user_log.UserId', '!=', 0)
        //     ->whereIn('users.userstatus', ['reg', 'mem'])
        //     ->get()
        //     ->all();
        // $membercounttotal = count($membercounttotal);
        // // dd($membercounttoday);
        // $data['membercounttotal'] = $membercounttotal;
        // $data['membercounttoday'] = $membercounttoday;
        // //dd($packageexpirenearly);
        // $followup = Inquiry::leftjoin('followup', 'followup.inquiryid', 'inquiries.inquiriesid')
        //     ->leftjoin('followupcalldetails', 'followupcalldetails.inquiriesid', 'inquiries.inquiriesid')->where('followupcalldetails.calldate', date('Y-m-d'))
        //     ->where('followup.status', "1")
        //     ->paginate(5);
        // $users = User::get()->all();
        // $regs = Registration::get()->all();
        // $regstoday = Registration::whereDate('created_at', 'LIKE', $today)->get()
        //     ->all();
        // $registrationtoday = count($regstoday);
        // $registrationtotal = count($regs);
        // $data['registrationtoday'] = $registrationtoday;
        // $data['registrationtotal'] = $registrationtotal;

        // $data['reregistration'] = Registration::select('phone_no')->selectRaw('count(`phone_no`) as `occurences`')
        //     ->groupBy('phone_no')
        //     ->having('occurences', '>', 1)
        //     ->get()
        //     ->count();

        // $data['footsteptoday'] = User_log::whereDate('created_at', $today)->count();
        // $data['footsteptotal'] = User_log::count();
        // $data['footstepthismonth'] = User_log::whereMonth('created_at', '=', $month)->get()
        //     ->count();

        // $packexpiretrainer = array();
        // $trainerid = $this->auth = Session::get('employeeid');
        // $packexpiretrainerall = Ptmember::where('trainerid', $trainerid)->groupBy('memberid')
        //     ->pluck('memberid')
        //     ->all();
        // // dd($packexpiretrainerall);
        // foreach ($packexpiretrainerall as $key => $value) {
        //     $member = Member::where('memberid', $value)->get()
        //         ->first();
        //     $now = date('Y-m-d', strtotime(' + 15 days'));
        //     $memberpackage = MemberPackages::leftjoin('member', 'member.userid', 'memberpackages.userid')->where('memberpackages.expiredate', '<', $now)->where('memberpackages.userid', $member->userid)
        //         ->orderBy('memberpackages.expiredate', 'desc')
        //         ->leftjoin('schemes', 'schemes.schemeid', 'memberpackages.schemeid')
        //         ->get()
        //         ->first();
        //     if ($memberpackage) {

        //         $date1 = date_create($memberpackage->expiredate);
        //         $date2 = date_create(date('Y-m-d'));

        //         $diff = date_diff($date2, $date1);
        //         // dd( $diff);
        //         /*if diff is positive*/
        //         if ($diff->invert == 0) {
        //             if ($diff->days == 0) {
        //                 $diff = 'Today';
        //                 $finaldiff = $diff;
        //             } else {
        //                 $diff = $diff->format("%R%a days");
        //                 $finaldiff = $diff;
        //             }
        //         }
        //         /*if diff is negative*/ else {
        //             $diff = $diff->format("%R%a days");
        //             // dd( $diff);
        //             if ($diff < -7) {
        //                 $finaldiff = '';
        //             } else {
        //                 // $diff=$diff->format("%R%a days");
        //                 $finaldiff = 'Expired';
        //             }
        //         }

        //         if ($finaldiff) {
        //             $memberpackage['diff'] = $finaldiff;
        //             array_push($packexpiretrainer, $memberpackage);
        //         }
        //     }
        // }
        // $trainersession2 = Ptmember::leftjoin('member', 'member.memberid', 'ptmember.memberid')
        //     ->leftjoin('schemes', 'schemes.schemeid', 'ptmember.schemeid')
        //     ->whereIn('ptmember.status', ['Active', 'Pending'])
        //     ->where('hoursfrom', '!=', '')
        //     ->select('member.memberid', 'member.firstname', 'member.lastname')
        //     ->groupBy('member.memberid', 'member.firstname', 'member.lastname')
        //     ->get()
        //     ->all();

        // $trainersession = Ptmember::where('trainerid', $trainerid)->leftjoin('member', 'member.memberid', 'ptmember.memberid')
        //     ->leftjoin('schemes', 'schemes.schemeid', 'ptmember.schemeid')
        //     ->whereIn('ptmember.status', ['Active', 'Pending'])
        //     ->where('ptmember.hoursfrom', '!=', '')
        //     ->select('member.memberid', 'member.firstname', 'member.lastname')
        //     ->groupBy('member.memberid', 'member.firstname', 'member.lastname')
        //     ->get()
        //     ->all();


        // foreach ($trainersession2 as $key => $value) {
        //     # code...
        //     $activecount = Ptmember::where('ptmember.memberid', $value->memberid)
        //         ->leftjoin('member', 'member.memberid', 'ptmember.memberid')
        //         ->leftjoin('schemes', 'schemes.schemeid', 'ptmember.schemeid')
        //         ->whereIn('ptmember.status', ['Active', 'Pending'])
        //         ->where('ptmember.hoursfrom', '!=', '')
        //         ->select('member.*', 'ptmember.*', 'ptmember.status as ptstatus', 'schemes.schemename')
        //         ->get()
        //         ->all();

        //     $value['schemenameprint'] = $activecount[0]->schemename;
        //     $activecount = count($activecount);
        //     $deductedcount = Ptmember::where('ptmember.memberid', $value->memberid)
        //         ->leftjoin('member', 'member.memberid', 'ptmember.memberid')
        //         ->leftjoin('schemes', 'schemes.schemeid', 'ptmember.schemeid')
        //         ->whereIn('ptmember.status', ['Conducted', 'Marked'])
        //         ->where('ptmember.hoursfrom', '!=', '')
        //         ->select('member.*', 'ptmember.*', 'ptmember.status as ptstatus', 'schemes.schemename')
        //         ->count();

        //     $value['activecount'] = $activecount;
        //     $value['deductedcount'] = $deductedcount;
        // }

        // foreach ($trainersession as $key => $value) {
        //     # code...
        //     $activecount = Ptmember::where('trainerid', $trainerid)->where('ptmember.memberid', $value->memberid)
        //         ->leftjoin('member', 'member.memberid', 'ptmember.memberid')
        //         ->leftjoin('schemes', 'schemes.schemeid', 'ptmember.schemeid')
        //         ->whereIn('ptmember.status', ['Active', 'Pending'])
        //         ->where('ptmember.hoursfrom', '!=', '')
        //         ->select('member.*', 'ptmember.*', 'ptmember.status as ptstatus', 'schemes.schemename')
        //         ->get()
        //         ->all();

        //     $value['schemenameprint'] = $activecount[0]->schemename;
        //     $activecount = count($activecount);
        //     $deductedcount = Ptmember::where('trainerid', $trainerid)->where('ptmember.memberid', $value->memberid)
        //         ->leftjoin('member', 'member.memberid', 'ptmember.memberid')
        //         ->leftjoin('schemes', 'schemes.schemeid', 'ptmember.schemeid')
        //         ->whereIn('ptmember.status', ['Conducted'])
        //         ->where('ptmember.hoursfrom', '!=', '')
        //         ->select('member.*', 'ptmember.*', 'ptmember.status as ptstatus', 'schemes.schemename')
        //         ->count();

        //     $value['activecount'] = $activecount;
        //     $value['deductedcount'] = $deductedcount;
        // }

        // $measurements = [];
        // $trainermembermeasur = DB::table("ptmember")->select('memberid')
        //     ->groupBy('memberid')
        //     ->where('trainerid', $trainerid)->whereNotIn('memberid', function ($query) {
        //         $query->select('memberid')
        //             ->from('measurement');
        //     })->get()->all();

        // foreach ($trainermembermeasur as $key => $value) {

        //     $memtr = Member::where('memberid', $value->memberid)->get()->first();
        //     array_push($measurements, $memtr);
        // }
        // $todaybday = Member::whereMonth("birthday", date('m'))
        //     ->whereDay("birthday", date('d'))->get()->all();
        // // dd(DB::getQueryLog());
        // $todayanniv = Member::whereMonth("anniversary", date('m'))
        //     ->whereDay("anniversary", date('d'))->get()->all();

        // $data['todaybday'] = $todaybday;
        // $data['todayanniv'] = $todayanniv;

        // $employeeleave = LeaveEntry::with('empname')->where('status', 'Pending')->get()->all();
        return view('admin.dashboard');
    }
    public function loaduserbytype(Request $request)
    {
        DB::enablequeryLog();
        $users = User::join('member', 'member.userid', 'users.userid')
            ->orwhere('username', 'LIKE', $request->typehead . '%')
            ->orwhere('usermobileno', 'LIKE', $request->typehead . '%')
            ->get();
        //        dd(DB::getqueryLog());
        return $users;
    }
    public function loaduserprofile(Request $request)
    {
        $userpro = User::where('users.userid', $request->userid)
            ->leftjoin('member', 'member.userid', 'users.userid')
            ->get()
            ->first();
        $userpropackges = array();
        $packages = MemberPackages::where('memberpackages.userid', $request->userid)
            ->leftjoin('schemes', 'schemes.schemeid', 'memberpackages.schemeid')
            ->get()
            ->all();
        $month = date('m');

        $logs = User_log::where('UserId', $request->userid)
            ->whereMonth('PunchDateTime', $month)->get()
            ->all();

        // foreach($packages as $pack){
        //   $pay= Payment::where('invoiceno', $pack->memberpackagesid)
        //   ->where('userid',$request->userid)->get()->first();
        //   if($pay){
        //       dd($pack->memberpackagesid);
        //       array_push($userpropackges,$pack);
        //     // $userpro['packages'] = $pack;
        //   }
        // }
        $userpro['packages'] = $packages;
        $userpro['logs'] = $logs;
        return $userpro;
    }
    public function check(Request $request)
    {

        if ($request->isMethod('post')) {
            $admin[0] = '';
            $admin = DB::table('admin')->where(['username' => $request
                ->username])
                ->get();

            $usernamedata = $request->username;
            if (count($admin) != 0) $employeeid = $admin[0]->employeeid;

            $u = Admin::where('username', Input::get('username'))->first();

            if ($u) {

                if (Hash::check(Input::get('password'), $u->password)) {

                    $role = $u->role;

                    $permission = Role::where('employeerole', $role)->first();

                    if (empty($permission->permission)) {
                        $permission = '';
                    } else {
                        $permission = $permission->permission;
                    }

                    session(['username' => $usernamedata]);
                    session(['role' => $role]);
                    session(['employeeid' => $employeeid]);
                    session(['admin_id' => $u->adminid]);
                    session(['permission' => $permission]);
                    // dd(session());
                    return redirect('dashboard');
                    // return response()->json(['success'=>false, 'message' => 'Login successfull']);

                } else {

                    $msg = 'Invalid Username or Password';
                    return redirect('check')->with('message', $msg);
                }
            } else {
                $msg = 'Invalid Username or Password';
                return redirect('check')->with('message', $msg);
            }
        }

        return view('admin.loginpage');
    }
    public function loginpage()
    {

        $this->auth = Session::get('role');

        $role = ['admin', 'receptionist', 'manager', 'trainer', 'member'];
        if (in_array($this->auth, $role)) {
            // return abort(403, "No access here, sorry!");
            return redirect('dashboard');
        } else {
            $msg = 'Invalid Username or Password';
            return view('admin.loginpage')->with('msg');
        }
    }

    public function logout(Request $request)
    {
        //auth()->logout();
        Session::flush();
        //return redirect('/check')->with('msgsuccess', 'Succesfully logged out');
        return redirect('adminloginpage');
    }

    public function todaymember()
    {

        $today = date('Y-m-d');

        $membercounttotal = DeviceFetchlogs::leftjoin('users', 'users.userid', 'devicefetchlogs.detail1')->where('devicefetchlogs.date', $today)->where('devicefetchlogs.detail1', '!=', 0)
            ->where('users.userstatus', '!=', 'emp')
            ->groupBy('detail1')
            ->orderBy('detail1', 'DESC')
            ->select('detail1')
            ->get()
            ->all();
        //dd($membercounttotal);
        $memberdata = [];
        if (!empty($membercounttotal)) {
            foreach ($membercounttotal as $key => $member) {

                $checkin = DeviceFetchlogs::where('detail1', $member->detail1)
                    ->pluck('time')
                    ->first();
                $checkout = DeviceFetchlogs::where('detail1', $member->detail1)
                    ->latest('time')
                    ->pluck('time')
                    ->first();
                $username = User::where('userid', $member->detail1)
                    ->pluck('username')
                    ->first();
                $data = ['username' => $username, 'checkin' => $checkin, 'checkout' => $checkout];
                array_push($memberdata, $data);
            }
        }

        return view('admin.todaymember')->with(compact('memberdata'));
    }

    public function testapi()
    {

        $api = ApiTrack::where('api', 'like', '%165.22.250.103:8443%')->get()
            ->all();

        foreach ($api as $apidata) {
            $apicontent = str_replace('165.22.250.103:8443', '165.22.250.103:8080', $apidata->api);

            $apiupdate = ApiTrack::where('apitrackid', $apidata->apitrackid)
                ->first();
            if (!empty($apiupdate)) {
                $apiupdate->api = $apicontent;
                $apiupdate->save();
            }

            /* $packageexpiry = Curl::to($apicontent)->get();
             echo "<pre>";print_r($packageexpiry);*/
        }
    }
    public function sessionreportadmin(Request $request)
    {

        $query = [];
        $query['username'] = '';
        $query['mobileno'] = '';

        if ($request->isMethod('post')) {
            $username = $request->get('username');
            $mobileno = $request->get('mobileno');



            $query['username'] = $username;
            $query['mobileno'] = $mobileno;


            $trainersession2 = Ptmember::leftjoin('member', 'member.memberid', 'ptmember.memberid')
                ->leftjoin('schemes', 'schemes.schemeid', 'ptmember.schemeid')
                ->whereIn('ptmember.status', ['Active', 'Pending'])
                ->where('hoursfrom', '!=', '')

                ->select('member.memberid', 'member.firstname', 'member.mobileno', 'member.lastname')
                ->groupBy('member.memberid', 'member.firstname', 'member.mobileno', 'member.lastname');

            if ($username != "") {
                $trainersession2->where('member.userid', '=', $username);
            }
            if ($mobileno != "") {
                $trainersession2->where('member.userid', '=', $mobileno);
            }
            $trainersession2 = $trainersession2->get()->all();
            $users = DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();



            foreach ($trainersession2 as $key => $value) {

                $activecount = Ptmember::where('ptmember.memberid', $value->memberid)
                    ->leftjoin('member', 'member.memberid', 'ptmember.memberid')
                    ->leftjoin('schemes', 'schemes.schemeid', 'ptmember.schemeid')
                    ->whereIn('ptmember.status', ['Active', 'Pending'])
                    ->where('ptmember.hoursfrom', '!=', '')
                    ->select('member.*', 'ptmember.*', 'ptmember.status as ptstatus', 'schemes.schemename')
                    ->get();

                $value['schemenameprint'] = $activecount[0]->schemename;
                $activecount = count($activecount);
                $deductedcount = Ptmember::where('ptmember.memberid', $value->memberid)
                    ->leftjoin('member', 'member.memberid', 'ptmember.memberid')
                    ->leftjoin('schemes', 'schemes.schemeid', 'ptmember.schemeid')
                    ->whereIn('ptmember.status', ['Conducted', 'Marked'])
                    ->where('ptmember.hoursfrom', '!=', '')
                    ->select('member.*', 'ptmember.*', 'ptmember.status as ptstatus', 'schemes.schemename')
                    ->count();

                $value['activecount'] = $activecount;
                $value['deductedcount'] = $deductedcount;
            }

            return view('admin.sessionreportadmin', compact('trainersession2', 'users', 'query'));
        } else {

            $trainersession2 = Ptmember::leftjoin('member', 'member.memberid', 'ptmember.memberid')
                ->leftjoin('schemes', 'schemes.schemeid', 'ptmember.schemeid')
                ->whereIn('ptmember.status', ['Active', 'Pending'])
                ->where('hoursfrom', '!=', '')
                ->select('member.memberid', 'member.firstname', 'member.mobileno', 'member.lastname')
                ->groupBy('member.memberid', 'member.firstname', 'member.mobileno', 'member.lastname')
                ->get();

            $users = DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();



            foreach ($trainersession2 as $key => $value) {
                $activecount = Ptmember::where('ptmember.memberid', $value->memberid)
                    ->leftjoin('member', 'member.memberid', 'ptmember.memberid')
                    ->leftjoin('schemes', 'schemes.schemeid', 'ptmember.schemeid')
                    ->whereIn('ptmember.status', ['Active', 'Pending'])
                    ->where('ptmember.hoursfrom', '!=', '')
                    ->select('member.*', 'ptmember.*', 'ptmember.status as ptstatus', 'schemes.schemename')
                    ->get();

                $value['schemenameprint'] = $activecount[0]->schemename;
                $activecount = count($activecount);
                $deductedcount = Ptmember::where('ptmember.memberid', $value->memberid)
                    ->leftjoin('member', 'member.memberid', 'ptmember.memberid')
                    ->leftjoin('schemes', 'schemes.schemeid', 'ptmember.schemeid')
                    ->whereIn('ptmember.status', ['Conducted', 'Marked'])
                    ->where('ptmember.hoursfrom', '!=', '')
                    ->select('member.*', 'ptmember.*', 'ptmember.status as ptstatus', 'schemes.schemename')
                    ->count();

                $value['activecount'] = $activecount;
                $value['deductedcount'] = $deductedcount;
            }



            return view('admin.sessionreportadmin', compact('trainersession2', 'users', 'query'));
        }
    }
}
