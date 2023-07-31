<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Curl;
use Hash;
use Mail;
use Session;
use App\Role;
use App\User;
use DateTime;
use App\Admin;
use App\Files;
use App\Member;
use App\Scheme;
use App\Inquiry;
use App\Payment;
use App\ApiTrack;
use App\Followup;
use App\Ptmember;
use App\User_log;
use Carbon\Carbon;
use App\LeaveEntry;
use App\MemberDiet;
use App\RootScheme;
use App\Measurement;
use App\Registration;
use PHPMailerAutoload;
use App\MemberDietPlan;
use App\MemberExercise;
use App\MemberPackages;
use App\questionmaster;
use App\DeviceFetchlogs;
use App\userrequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;

class APIController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function otpverify(Request $request)
    {
        $otp = $_REQUEST['otp'];
        $mobileno = $_REQUEST['mobileno'];

        $otpverify = DB::table('otpverify')->where('mobileno', $mobileno)->where('isexpired', 0)->orderBy('otpverifyid', 'desc')->first();

        if (!empty($otpverify)) {
            $code = $otpverify->code;
        }
        $member = Member::where('mobileno', $mobileno)->get()->first();

        if ((isset($code) && $code == $otp)) {
            if ($member) {
                return response()->json([
                    'success' => true,
                    'member_id' => $member->memberid,
                    'user_id' => $member->userid,
                    'msg' => 'OTP Verified successfully'
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'msg' => 'Member Not found'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Incorrect OTP'
            ]);
        }
    }

    public function sendotp(Request $request)
    {
        $request->validate(['mobileno' => 'required|integer']);
        // $rndno = rand(1000, 999999);
        $rndno = '12345';
        $mobileno = $request['mobileno'];

        $otpverify = [
            'mobileno'      => $request['mobileno'],
            'email'         => $request->input('email'),
            'code'          => $rndno,
            'isexpired'    => '0',
            'created_at'     => date('Y-m-d  H:i:s'),
            'updated_at'     => date('Y-m-d  H:i:s'),
        ];

        DB::table('otpverify')->insert($otpverify);
        $msg =   'Hello, Your Fitness5 OTP is [otp]';
        $msg = str_replace("[otp]", $rndno, $msg);
        $msg = urlencode($msg);
        // $smssetting = Smssetting::where('status', 1)->where('smsonoff', 'Active')->first();

        // if ($smssetting) {

        //     $u = $smssetting->url;
        //     $url = str_replace('$mobileno', $mobileno, $u);
        //     $url = str_replace('$msg', $msg, $url);

        //     $otpsend = Curl::to($url)->get();

        //     # code...
        // }
        return response()->json([
            'success' => true,
            'msg' => 'Otp Send successfully'
        ]);
    }

    public function getmemberworkout(Request $request, $memberid)
    {
        $exercise = MemberExercise::with('Workout', 'Exercise')->where('memberid', $memberid)->where('status', '1')->get()->all();
        // $member = Member::with('ExerciseProgram')->where('memberid',$memberid)->get()->first();
        if ($exercise) {
            return response()->json([
                'success' => true,
                'workout' => $exercise,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Workout not Assigned'
            ]);
        }
    }
    public function getmemberdietplan(Request $request, $memberid)
    {
        // Member::where('memberid',2864)->update(['status'=>1]);
        $dietplan = MemberDiet::with('DietPlanname')->where('memberid', $memberid)
            ->leftJoin('mealmaster', 'mealmaster.mealmasterid', '=', 'memberdiet.mealid')->where('memberdiet.status', '=', '1')
            ->get()->all();
        // $member = Member::with('ExerciseProgram')->where('memberid',$memberid)->get()->first();
        if ($dietplan) {
            return response()->json([
                'success' => true,
                'dietplan' => $dietplan
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'DietPlan not Assigned'
            ]);
        }
    }
    public function getpackages(Request $request, $memberid)
    {

        $member = Member::where('memberid', $memberid)->where('status', 1)->get()->first();

        // =========

        $allpackages = MemberPackages::with('Scheme')->where('userid', $member->userid)->get()->all();
        $packages = [];
        foreach ($allpackages as $key => $value) {
            // $a =  Payment::where('memberid',$id)->where('schemeid',$value->schemeid)->where('invoiceno',$value->memberpackagesid)->latest()->first();
            $a =  Payment::where('memberid', $memberid)
                ->where('schemeid', $value->schemeid)
                ->where('invoiceno', $value->memberpackagesid)->latest()->first();
            if ($a) {
                if ($a->remainingamount > 0) {
                    $value->remainingamount = $a->remainingamount;
                    $value->invoiceno = $a->invoiceno;
                } else {
                    $value->remainingamount = 0;
                    $value->invoiceno = 0;
                }
            }
            $packages[] = $value;
        }
        // ================
        if ($packages) {
            return response()->json([
                'success' => true,
                'packages' => $packages,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'No any current package'
            ]);
        }
    }
    public function getprofile(Request $request, $memberid)
    {

        $member = Member::where('memberid', $memberid)->where('status', 1)->get()->first();

        if ($member) {
            return response()->json([
                'success' => true,
                'member' => $member,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'No any user found'
            ]);
        }
    }
    public function getmeasurements(Request $request, $memberid)
    {
        $measurement = Measurement::where('memberid', $memberid)->get()->all();
        if ($measurement) {
            return response()->json([
                'success' => true,
                'measurement' => $measurement,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'No any user measurement found'
            ]);
        }
    }
    public function postquestion(Request $request, $memberid)
    {
        $request->validate([
            'question' => 'required|unique:questionmaster,qustionname',
            'requestsub' => 'required',
        ]);
        // $usr = questionmaster::where('qustionname', $request['question'])->get()->all();

        // if ($usr) {
        //     return redirect()->back()->withErrors('Question Already exists');
        // }

        $member = Member::where('memberid', $memberid)->get()->first();

        $question = userrequest::create([
            'requestsub' => $request['requestsub'],
            'requestdetail' => $request['question'],
            'mobileno' => $member->mobileno,
        ]);
        if ($question) {
            return response()->json([
                'success' => true,
                'question' => $question,
                'msg' => 'We get your query,will contact you soon'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Something went wrong'
            ]);
        }
    }
    public function getcompanyinfo(){

        $data['address'] = '"Karuna Nidhan" Kotecha Chowk,university main road Rajkot-5, Gujrat, India';
        $data['mobileno'] = '92750 92755';
        $data['site'] = 'www.fitness5.in';
        $data['email'] = 'info@fitness5.in';

        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Something went wrong'
            ]);
        }
    }
}
