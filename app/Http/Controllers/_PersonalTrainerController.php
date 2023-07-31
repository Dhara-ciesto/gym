<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Employee;
use App\Addpt;
use App\Ptslot;
use App\Member;
use Session;
use App\Scheme;
use App\MemberPackages;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Facades\Excel;
use App\Ptmember;
use App\Claimptsession;

class PersonalTrainerController extends Controller
{
    public function checkfromdateajax(Request $request){
        DB::enableQueryLog();
        $fromdate=$request->get('fromdate');
        $memberpackagesid=$request->get('memberpackagesid');
        $query=DB::table('memberpackages')->where('memberpackagesid',$memberpackagesid)->get();
        $resp = '';
        if($query[0]->joindate <= $fromdate && $query[0]->expiredate >= $fromdate)
        {
            $resp= "valid";
        }
        else
        {
            if($request->packageexpire=='yes'){
                $resp= "valid"; // you can claim expire package
            }else{
//             $resp= "invalid"; // for restrict from expire package
                $resp= "valid";
            }

        }
        $samedate = Claimptsession::where('packageid',$memberpackagesid)->where('actualdate',$fromdate)->first();
        if($samedate){
            $resp= "samedate";
        }
        return $resp;
        // echo  $memberid;
    }
    public function index(){
        echo "string";
    }

    public function editpttime(Request $request){
        DB::enableQueryLog();

        if($request->isMethod('post'))
        {
            // echo $request;
            $n=$request->post('index');
            // echo $n;
            for($i=0;$i<=$n-1;$i++)
            {
                // echo "$i";
                $strainerid= $request->post('strainerid');
                $todate= $request->post('todate');
                $sdays= $request->post('sdays'.$i);
                // echo $sdays;exit;
                if($request->post('600'.$i)=="")
                {
                    $t6='-1';
                }
                else
                {
                    $t6='0';
                }
                if($request->post('700'.$i)=="")
                {
                    $t7='-1';
                }
                else
                {
                    $t7=0;
                }
                if($request->post('800'.$i)=="")
                {
                    $t8='-1';
                }
                else
                {
                    $t8=0;
                }
                if($request->post('900'.$i)=="")
                {
                    $t9='-1';
                }
                else
                {
                    $t9='0';
                }
                if($request->post('1000'.$i)=="")
                {
                    $t10='-1';
                }
                else
                {
                    $t10=0;
                }
                if($request->post('1100'.$i)=="")
                {
                    $t11='-1';
                }
                else
                {
                    $t11=0;
                }
                if($request->post('1200'.$i)=="")
                {
                    $t12='-1';
                }
                else
                {
                    $t12=0;
                }
                if($request->post('1300'.$i)=="")
                {
                    $t13='-1';
                }
                else
                {
                    $t13=0;
                }
                if($request->post('1400'.$i)=="")
                {
                    $t14='-1';
                }
                else
                {
                    $t14=0;
                }
                if($request->post('1500'.$i)=="")
                {
                    $t15='-1';
                }
                else
                {
                    $t15=0;
                }
                if($request->post('1600'.$i)=="")
                {
                    $t16='-1';
                }
                else
                {
                    $t16=0;
                }
                if($request->post('1700'.$i)=="")
                {
                    $t17='-1';
                }
                else
                {
                    $t17=0;
                }
                if($request->post('1800'.$i)=="")
                {
                    $t18='-1';
                }
                else
                {
                    $t18=0;
                }
                if($request->post('1900'.$i)=="")
                {
                    $t19='-1';
                }
                else
                {
                    $t19=0;
                }
                if($request->post('2000'.$i)=="")
                {
                    $t20='-1';
                }
                else
                {
                    $t20=0;
                }
                if($request->post('2100'.$i)=="")
                {
                    $t21='-1';
                }
                else
                {
                    $t21=0;
                }
                if($request->post('2200'.$i)=="")
                {
                    $t22='-1';
                }
                else
                {
                    $t22=0;
                }
                if($request->post('2300'.$i)=="")
                {
                    $t23='-1';
                }
                else
                {
                    $t23=0;
                }

                $update=[
                    't600' => $t6,
                    't700' => $t7,
                    't800' => $t8,
                    't900' => $t9,
                    't1000' =>$t10,
                    't1100' =>$t11,
                    't1200' =>$t12,
                    't1300' =>$t13,
                    't1400' =>$t14,
                    't1500' =>$t15,
                    't1600' =>$t16,
                    't1700' =>$t17,
                    't1800' =>$t18,
                    't1900' =>$t19,
                    't2000' =>$t20,
                    't2100' =>$t21,
                    't2200' =>$t22,
                    't2300' =>$t23,
                    'fromdate'=>$todate];
                $ptslot = DB::table('ptslot')->where(['trainerid' => $strainerid,'day' => $sdays])->update($update);

                // dd($ptslot);
                // dd( DB::getQueryLog());
                // $ptslot->save();
            }
        }
        // dd($trainerid);
        // return view('admin.Add_PT_Time',compact('ptslots','employees','day','trainerid'));

        return redirect('personaltrainer/addpttime');
        // dd($query);
        // echo $percentage;
        // echo json_encode($percentage);
        // return view('admin.Assign_PT_Level');
    }

    public function editassignptlevel(Request $request){

        $employee= $request->post('employee');
        $mobile_no= $request->post('mobileno');
        $level= $request->post('level');
        $percentage= $request->post('percentage');
        $query =  DB::table('ptassignlevel')->where('ptassignlevelid','=',$request->post('id'))->update(
            ['trainerid' => $employee, 'levelid' => $level,'percentage'=>$percentage,'created_at'=>date('y-m-d'),'updated_at'=>date('y-m-d')]
        );
        $employee = DB::table('employee')->get();
        $ptlevel = DB::table('ptlevel')->get();
        $ptassignlevel = DB::table('ptassignlevel')->leftJoin('employee', 'ptassignlevel.trainerid', '=', 'employee.employeeid')->get();

        session()->put('edit_assign_level', 1);

        return redirect('personaltrainer/assignptlevel');
        // dd($query);
        // echo $percentage;
        // echo json_encode($percentage);
        // return view('admin.Assign_PT_Level');
    }

    public function assignPTTime(Request $request){
        DB::enableQueryLog();
        $trainerid='';
        $day=array();
        if($request->isMethod('post'))
        {
            $trainerid= $request->post('trainerid');
            $day= $request->post('day');
            // dd($day);
            $ptslots =  Ptslot::where(['trainerid' => $trainerid])->whereIn('day',$day)->get()->all();
            // print_r($ptslots);exit;
            // dd( DB::getQueryLog());
            if($ptslots == null)
            {

                $day=array();
                $day[0]='Sunday';
                $day[1]='Monday';
                $day[2]='Tuesday';
                $day[3]='Wednesday';
                $day[4]='Thursday';
                $day[5]='Friday';
                $day[6]='Saturday';
                $todate=date('Y-m-d');
                // dd($day);
                for($n=0;$n<count($day);$n++)
                {
                    // dd($day[$n]);
                    $insert=new Ptslot;
                    $insert->trainerid=$trainerid;
                    $insert->day=$day[$n];
                    $insert->fromdate=$todate;
                    $insert->{'t600'}=0;
                    $insert->{'t700'}=0;
                    $insert->{'t800'}=0;
                    $insert->{'t900'}=0;
                    $insert->{'t1000'}=0;
                    $insert->{'t1100'}=0;
                    $insert->{'t1200'}=0;
                    $insert->{'t1300'}=0;
                    $insert->{'t1400'}=0;
                    $insert->{'t1500'}=0;
                    $insert->{'t1600'}=0;
                    $insert->{'t1700'}=0;
                    $insert->{'t1800'}=0;
                    $insert->{'t1900'}=0;
                    $insert->{'t2000'}=0;
                    $insert->{'t2100'}=0;
                    $insert->{'t2200'}=0;
                    $insert->{'t2300'}=0;
                    $insert->save();
                }
            }
            $ptslots =  Ptslot::where(['trainerid' => $trainerid])->whereIn('day',$day)->get()->all();
        }

        else
        {
            $ptslots =  DB::table('ptslot')->where('ptslotid','=','')->get();
        }

        $employees=Employee::where('roleid','4')->where('status','1')->get()->all();
        // dd($trainerid);

        return view('admin.Add_PT_Time',compact('ptslots','employees','day','trainerid'));

        // return redirect('personaltrainer/addpttime')->with('ptslots');
        // dd($query);
        // echo $percentage;
        // echo json_encode($percentage);
        // return view('admin.Assign_PT_Level');
    }

    public function addassignptlevel(Request $request){
        $request->validate([
            'employee' => 'unique:ptassignlevel,trainerid',
            //    'level' => 'unique:ptassignlevel,levelid',
        ]);
        $employee= $request->post('employee');
        $mobile_no= $request->post('mobile_no');
        $level= $request->post('level');
        $percentage= $request->post('percentage');
        $query =  DB::table('ptassignlevel')->insert(
            ['trainerid' => $employee, 'levelid' => $level,'percentage'=>$percentage,'created_at'=>date('y-m-d'),'updated_at'=>date('y-m-d')]
        );
        $employee = DB::table('employee')->where('roleid','4')->where('status','1')->get();
        $ptlevel = DB::table('ptlevel')->get();
        // $ptassignlevel = DB::table('ptassignlevel')->leftJoin('employee', 'ptassignlevel.trainerid', '=', 'employee.employeeid')->get();

        $ptassignlevel = DB::table('ptassignlevel')->leftJoin('employee', 'ptassignlevel.trainerid', '=', 'employee.employeeid')->where('employee.roleid','4')->OrderBy('ptassignlevelid','desc')->get();
        $msg = 'PT level is assign successfully';

        return view('admin.Assign_PT_Level',compact('employee','ptlevel','ptassignlevel','msg'));
        // dd($query);
        // echo $percentage;
        // echo json_encode($percentage);
        // return view('admin.Assign_PT_Level');
    }
    public function setpercentage(Request $request){

        $level= $request->get('level');
        $percentage =  DB::table('ptlevel')->select('percentage')->where('level','=',$level)->get();
        // dd($percentage);
        // echo $percentage;
        echo json_encode($percentage);
        // return view('admin.Add_PT_Level',compact('percentage'));
    }
    public function addptlevel(){

        $addptlevel =  DB::table('ptlevel')->get();


        return view('admin.Add_PT_Level',compact('addptlevel'));
    }

    public function addptleveldatacreate(Request $request){

        $request->validate([
            'level' => 'unique:ptlevel,level'

        ]);
        $data = [

            'level'     => $request['level'],
            'percentage' => $request['percentage'],

        ];

        DB::table('ptlevel')->insert($data);
        session()->put('add_pt-level', 'PT level is successfully added');
        return redirect('personaltrainer/addptlevel');

    }

    public function editptlevel(Request $request){

        $id = $request->input('id');
        $level = $request->input('level');
        $percentage = $request->input('percentage');

        $data = [

            'level' => $level,
            'percentage' => $percentage

        ];


        DB::table('ptlevel')->where('id',$id)->update($data);

        return redirect('personaltrainer/addptlevel');

    }

    public function assignptlevel(){

        $employee = DB::table('employee')->where('roleid','4')->where('status','1')->get();
        $ptlevel = DB::table('ptlevel')->get();
        $ptassignlevel = DB::table('ptassignlevel')->leftJoin('employee', 'ptassignlevel.trainerid', '=', 'employee.employeeid')->OrderBy('ptassignlevelid','desc')->get();

        return view('admin.Assign_PT_Level',compact('employee','ptlevel','ptassignlevel'));
    }

    public function assignptlevelajax(Request $request){

        $employee = $request->get('employee');


        $demo =  DB::table('employee')->where('employeeid', '=', $employee)->pluck('mobileno');



        // $demo =  DB::table('employee')->select('id','mobile_no')->get()->all();
        // $q = $demo->mobile_no;
        // print_r($demo['0']);exit;

        return response()->json($demo);
    }
    public function assignptmemberajax(Request $request){
// DB::enableQueryLog();
        $member = $request->get('memberid');
        // print_r($member);


        $demo =  DB::table('member')->select('mobileno')->where('memberid', '=', $member)->get();
        // dd($demo);
        // dd( DB::getQueryLog());
        echo $demo[0]->mobileno;
        // return response()->json($demo['mobileno']);
    }
    public function ajaxgetjoindate(Request $request){
        // DB::enableQueryLog();
        $memberpackagesid = $request->get('memberpackagesid');
        // print_r($member);

        $memberpackages =DB::table('memberpackages')->where('memberpackagesid',$memberpackagesid)->get();
        echo json_encode($memberpackages);

        // $ptslots =  DB::table('ptslot')->leftJoin('ptmember',['ptslot.TrainerId'=>'ptmember.TrainerId','ptslot.Day'=>'ptmember.day'])->where(['ptslot.TrainerId' => $trainerid ,'ptmember.status' => 'Active'])->get()->all();
        // dd( DB::getQueryLog());
        // return response()->json($demo['mobileno']);
    }
    public function assignptpackageajax(Request $request){
// DB::enableQueryLog();
        $member = $request->get('memberid');
        $userid=Member::where('memberid',$member)->pluck('userid')->first();
        $type = $request->get('type');
        $schemeid = $request->get('schemeid');

        // print_r($member);
        if($type=='package')
        {
            $demo =  DB::table('member')
                ->select('userid')
                ->where('memberid', '=', $member)->get();
            if($demo){
                $package=array();
                $allpackage = MemberPackages::
                where('userid',$demo[0]->userid)
                    ->leftJoin('schemes','schemes.schemeid','memberpackages.schemeid')
                    ->where('schemes.rootschemeid',2);
                if(isset($request->status)){
                    $allpackage =  $allpackage->where('memberpackages.status',$request->status);
                }
                $allpackage = $allpackage->get()->all();

                foreach ($allpackage as $key => $value) {
                    $ptassign = Ptmember::where('packageid',$value->memberpackagesid)->where('status','Active')->get()->all();
                    if($ptassign){
                        $package[]= $value;
                    }

                }

            }

            // DB::enableQueryLog();

            //   $package = DB::select( DB::raw("SELECT memberpackages.*,schemes.schemeid,schemes.schemename  from ptmember   left Join schemes on schemes.schemeid=ptmember.schemeid
            //   left join  memberpackages on memberpackages.memberpackagesid = ptmember.packageid
            //  where ptmember.memberid='".$member."' and memberpackages.status = 1 group by memberpackages.memberpackagesid"));
            // dd( DB::getQueryLog());
            //  $package = DB::select( DB::raw("SELECT memberpackages.*,schemes.schemeid,schemes.schemename
            //                                   from memberpackages
            //                                   left Join schemes on memberpackages.schemeid=schemes.schemeid
            //                                   left Join schemeterms on schemeterms.schemeid=schemes.schemeid
            //                                   where memberpackages.userid='".$demo[0]->userid."'
            //                                   AND memberpackages.status='1'
            //                                   AND schemeterms.value != 0"));

            echo json_encode($package);
        }
        if($type=='pthour')
        {
            // echo 'hi';
            // $demo =  DB::table('schemeterms')->select('value')->where('Schemeid', '=', $schemeid)->where('Termid','5')->get();
            $demo =  DB::table('memberpackages')
                ->leftJoin('schemeterms','memberpackages.schemeid','=','schemeterms.schemeid')
                ->where('memberpackages.memberpackagesid', '=', $schemeid)
                ->where('schemeterms.termsid','2')->get();
            //  dd($demo);
            // dd( DB::getQueryLog());
            if($demo){
                echo $demo[0]->value;
            }else{
                echo false;
            }

        }
        if($type=='memberpackageassign'){
            $package = DB::select( DB::raw("SELECT memberpackages.*,schemes.schemeid,schemes.schemename
                                              from memberpackages
                                               left Join schemes on memberpackages.schemeid=schemes.schemeid
                                              left Join schemeterms on schemeterms.schemeid=schemes.schemeid
                                            where memberpackages.userid='".$userid."' AND schemes.rootschemeid = '2'
                                             AND schemeterms.value != 0"));
            echo json_encode($package);
        }
        // return response()->json($demo['mobileno']);
    }

    public function claimptsession(Request $request){
        $msg='';
        //  dd($request);
        if($request->has('tid'))
        {
            $ptmember=DB::table('ptmember')->where(['trainerid'=>$request->tid,'memberid'=>$request->memberid,'status'=>'Active'])->where('hoursfrom','!=','')->orderBy('date','ASC')->first();
            echo json_encode($ptmember);exit;
        }

        if($request->has('ptid'))
        {
            $member=DB::table('ptmember')->where(['ptmemberid'=>$request->ptid])->first();
            $trainer=DB::table('employee')->where('employeeid',$member->trainerid)->get()->first();
            $member=DB::table('member')->where(['memberid'=>$member->memberid])->get()->first();
            if($request->ptp==$trainer->fitpin)
            {
                // echo "hi";
                $update=['status'=>'Conducted'];
                $ptmember=DB::table('ptmember')->where(['ptmemberid'=>$request->ptid])->update($update);
                echo json_encode('success');exit;
            }
            else
            {
                echo json_encode('error');exit;
            }

        }

        if($request->isMethod('post'))
        {
            $dutyhours=0;
            // dd($request->actualtime);

            $trainer=DB::table('employee')->where('employeeid',$request->trainerid)->get()->first();
            // dd($request->actualtime,$request->actualtime >= $trainer->workinghourfrom2,$request->actualtime <= $trainer->workinghourto2);
            if($request->actualtime >= $trainer->workinghourfrom1  &&  $request->actualtime <= $trainer->workinghourto1){
                $dutyhours=1;
            }else if($request->actualtime >= $trainer->workinghourfrom2 &&  $request->actualtime <= $trainer->workinghourto2){
                $dutyhours=1;
            }else{
                $dutyhours=0;
            }
            if($request->has('skip'))
            {
                // dd($request->all());
                $query=DB::table('ptmember')->where(['trainerid'=>$request->trainerid,'memberid'=>$request->memberid,'packageid'=>$request->packageid,'status'=>'Active'])
                    ->where('hoursfrom','!=','')->orderBy('date','ASC')->first();
                if(!$query){
                    $msg="No Any Session Available";
                    return redirect('claimptsession')->withErrors(['msg' => $msg]);
                }
//             $ptlevel=DB::table('ptassignlevel')->where('trainerid',$request->trainerid)->get();
//             if(count($ptlevel) == 0){
//               $msg="Please Assign PT level";
//
//               return redirect('claimptsession')->withErrors(['msg' => $msg]);
//             }

                $session =  DB::table('memberpackages')
                    ->leftJoin('schemeterms','memberpackages.schemeid','=','schemeterms.schemeid')
                    ->where('memberpackages.memberpackagesid', '=', $request->packageid)
                    ->where('schemeterms.termsid','2')->get();

                $schemes =  DB::table('schemes')->leftJoin('memberpackages','memberpackages.schemeid','=','schemes.schemeid')->where('memberpackages.memberpackagesid', '=', $request->packageid)->get();

                $comission=$query->commision;
                $session=$session[0]->value;
                $baseprice=$schemes[0]->baseprice;
                $persession =$baseprice/$session;
                $amount = ($persession*$comission)/100;

                $update=['status'=>'Pending','commision'=>$request->comission];
                $query1=DB::table('ptmember')->where(['ptmemberid'=>$query->ptmemberid])->update($update);

                // dd( $query);

                $insert=['trainerid'=>$request->trainerid,
                    'actualtrainerid' => $request->actualtrainerid,
                    'memberid'=>$request->memberid,
                    'packageid'=>$request->packageid,
                    'scheduletime'=>$query->hoursfrom,
                    'actualtime'=>$request->actualtime,
                    'scheduledate'=>$query->date,
                    'actualdate'=>$request->actualdate,
                    'comission'=>$comission,
                    'amount'=>$amount,
                    'dutyhours'=>$dutyhours,

                ];
                $query=DB::table('claimptsession')->insert($insert);
                $msg="Claim is Skiped";


            }elseif($request->has('mark_conduct')){

                $query=DB::table('ptmember')->where(['trainerid'=>$request->trainerid,'memberid'=>$request->memberid,'status'=>'Active','packageid'=>$request->packageid])->where('hoursfrom','!=','')->orderBy('date','ASC')->first();
                if(!$query){
                    $msg="No Any Session Available";
                    return redirect('claimptsession')->withErrors(['msg' => $msg]);
                }
//          $ptlevel = DB::table('ptassignlevel')->where('trainerid',$request->trainerid)->get();
//          if(count($ptlevel) == 0){
//          $msg="Please Assign PT level";
//
//          return redirect('claimptsession')->withErrors(['msg' => $msg]);
//          }

                $session =  DB::table('memberpackages')
                    ->leftJoin('schemeterms','memberpackages.schemeid','=','schemeterms.schemeid')
                    ->where('memberpackages.memberpackagesid', '=', $request->packageid)
                    ->where('schemeterms.termsid','2')->get();

                $schemes =  DB::table('schemes')->leftJoin('memberpackages','memberpackages.schemeid','=','schemes.schemeid')->where('memberpackages.memberpackagesid', '=', $request->packageid)->get();

                $comission=$query->commision;
                $session=$session[0]->value;
                $baseprice=$schemes[0]->baseprice;
                $persession = $baseprice/$session;
                $amount = ($persession*$comission)/100;

                $update=['status'=>'Marked'];
                $query1=DB::table('ptmember')
                    ->where(['ptmemberid'=>$query->ptmemberid])
                    ->update($update);

                // dd( $query);

                $insert=['trainerid'=>$request->trainerid,
                    'actualtrainerid' => $request->actualtrainerid,
                    'memberid'=>$request->memberid,
                    'packageid'=>$request->packageid,
                    'scheduletime'=>$query->hoursfrom,
                    'actualtime'=>$request->actualtime,
                    'scheduledate'=>$query->date,
                    'actualdate'=>$request->actualdate,
                    'comission'=>$comission,
                    'amount'=>$amount,
                    'dutyhours'=>$dutyhours,
                ];
                $query=DB::table('claimptsession')->insert($insert);
                $msg="Session is successfully Marked As Conducted";
            }
            else
            {

                $employee= DB::table('employee')->where('employeeid',$request->trainerid)->get()->first();

                $member=DB::table('member')->where(['memberid'=>$request->memberid])->get()->first();
                if($request->ptp==$member->memberpin)
                {
                    $query=DB::table('ptmember')->where(['trainerid'=>$request->trainerid,'memberid'=>$request->memberid,'status'=>'Active'])
                        ->where('packageid',$request->packageid)
                        ->where('hoursfrom','!=','')->orderBy('date','ASC')->first();
                    if(!$query){
                        $msg="No Any Session Available";
                        return redirect('claimptsession')->withErrors(['msg' => $msg]);
                    }
                    // DB::enableQueryLog();
//             $ptlevel=DB::table('ptassignlevel')->where('trainerid',$request->trainerid)->get();
                    // dd( DB::getQueryLog());
                    $session =  DB::table('memberpackages')->leftJoin('schemeterms','memberpackages.schemeid','=','schemeterms.schemeid')->where('memberpackages.memberpackagesid', '=', $request->packageid)->where('schemeterms.termsid','2')->get();

                    $schemes =  DB::table('schemes')->leftJoin('memberpackages','memberpackages.schemeid','=','schemes.schemeid')->where('memberpackages.memberpackagesid', '=', $request->packageid)->get();
                    //echo


                    if(count($session)==0 || count($schemes)==0)
                    {
                        // dd(count($ptlevel));
                        $msg="Something Went Wrong";
                    }
                    else
                    {
                        $comission=$query->commision;
                        $session=$session[0]->value;
                        $baseprice=$schemes[0]->baseprice;
                        $persession = $baseprice/$session;
                        $amount = ($persession*$comission)/100;

                        $update=['status'=>'Conducted'];
                        $query1=DB::table('ptmember')->where(['ptmemberid'=>$query->ptmemberid])->update($update);

                        // dd( $query);

                        $insert=['trainerid'=>$request->trainerid,
                            'actualtrainerid' => $request->actualtrainerid,
                            'memberid'=>$request->memberid,
                            'packageid'=>$request->packageid,
                            'scheduletime'=>$query->hoursfrom,
                            'actualtime'=>$request->actualtime,
                            'scheduledate'=>$query->date,
                            'actualdate'=>$request->actualdate,
                            'comission'=>$comission,
                            'amount'=>$amount,
                            'dutyhours'=>$dutyhours,
                        ];
                        $query=DB::table('claimptsession')->insert($insert);
                        $msg="Session is successfully Claimed";
                    }
                }
                else
                {
                    $msg="Incorrect OTP";
                    // return redirect()->back()->with('msg', 'Incorrect OTP')->withInput();
                }
            }
            // dd($members);
            // $members=DB::table('member')->whereIn('memberid',$members)->get();

            // return redirect('claimptsession')->with('msg');

        }

        $employees=Employee::where('roleid','4')->where('status','1')->get()->all();
        $trainername=Session::get('username');
        $trainerid=Session::get('employeeid');
        $ptlevel=DB::table('ptassignlevel')->where('trainerid',$trainerid)->get();
        DB::enableQueryLog();
        $members=DB::table('member')->select('member.*')->leftJoin('ptmember',['ptmember.memberid'=>'member.memberid'])->where(['ptmember.trainerid'=>$trainerid,'ptmember.status'=>'Active'])->distinct()->get();
        // dd($members);
        // $members=DB::table('member')->whereIn('memberid',$members)->get();
// dd($msg);
        return view('admin.claimptsession',compact('members','employees','ptlevel','trainername','trainerid','msg'));
    }

    public function getpriceofpackageajax(Request $request){

        $memberpackagesid= $request->get('schemeid');
        // dd($percentage);
        // echo $percentage;
        echo json_encode($demo[0]->baseprice);
        // return view('admin.Add_PT_Level',compact('percentage'));

        // return view('admin.Add_PT_Level',compact('percentage'));
    }

    public function getclaimmemberajax(Request $request){

        $trainerid=$request->trainerid;

        $members=DB::table('member')->select('member.*')->leftJoin('ptmember',['ptmember.memberid'=>'member.memberid'])->where(['ptmember.trainerid'=>$trainerid,'ptmember.status'=>'Active'])->distinct()->get();
        // dd($percentage);
        // echo $percentage;
        echo json_encode($members);
    }

    public function ajaxgetptslot(Request $request){

        $trainerid= $request->get('trainerid');
        $ptslots =  Ptslot::where(['trainerid' => $trainerid])->get();
        // dd($percentage);
        // echo $percentage;
        echo json_encode($ptslots);
        // return view('admin.Add_PT_Level',compact('percentage'));
    }

    public function assigntimeslotajax(Request $request){
        // DB::enableQueryLog();
        $trainerid = $request->get('trainerid');
        $packageid = $request->get('packageid');
        $memberid = $request->get('memberid');
        // print_r($member);
        $q=array();
        $q=DB::select( DB::raw("SELECT schemeid from memberpackages where memberpackagesid=".$packageid." AND (status = 1 OR status=0)"));
        $schemeid = $q[0]->schemeid;
        $nottime=Ptslot::where('trainerid',$trainerid)->get()->count();
        if(!$nottime>0){
            $ptslots='noslots';
        }
        else{
            // $query =DB::select( DB::raw("SELECT COUNT(ptmemberid)  from ptmember where memberid = '".$memberid."' AND packageid='".$packageid."'"));
            $query=DB::table('ptmember')->where(['memberid'=>$memberid,'packageid'=>$packageid])->get();
            $ptslots=array();
            if(count($query) === 0)
            {
                $ptslots =DB::select( DB::raw("SELECT ptslot.day as Day,ptmember.fromdate as ptfromdate,ptslot.*,ptmember.* from ptslot LEFT JOIN  ptmember ON ptslot.trainerid = ptmember.trainerid AND ptmember.status='Active' AND ptslot.day=ptmember.day AND ptmember.schemeid='".$schemeid."' where ptslot.trainerid = '".$trainerid."'"));

            }
            else
            {
                $query=DB::table('ptmember')->where(['memberid'=>$memberid,'trainerid'=>$trainerid,'packageid'=>$packageid])->get();
                if(count($query)>0)
                {
                    $ptslots =DB::select( DB::raw("SELECT ptslot.day as Day,ptmember.fromdate as ptfromdate,ptslot.*,ptmember.* from ptslot LEFT JOIN  ptmember ON ptslot.trainerid = ptmember.trainerid AND ptmember.status='Active' AND ptslot.day=ptmember.day AND ptmember.schemeid='".$schemeid."' where ptslot.trainerid = '".$trainerid."'"));
                }
                else{
                    $ptslots =DB::select( DB::raw("SELECT ptslot.day as Day,ptmember.fromdate as ptfromdate,ptslot.*,ptmember.* from ptslot LEFT JOIN  ptmember ON ptslot.trainerid = ptmember.trainerid AND ptmember.status='Active' AND ptslot.day=ptmember.day AND ptmember.schemeid='".$schemeid."' where ptslot.trainerid = '".$trainerid."'"));
                }
            }

        }
        // $ptslots =  DB::table('ptslot')->leftJoin('ptmember',['ptslot.TrainerId'=>'ptmember.TrainerId','ptslot.Day'=>'ptmember.day'])->where(['ptslot.TrainerId' => $trainerid ,'ptmember.status' => 'Active'])->get()->all();
        // dd( DB::getQueryLog());
        echo json_encode($ptslots);
        // return response()->json($demo['mobileno']);
    }
    public function assignpttomember(Request $request){
        DB::enableQueryLog();

        if($request->isMethod('post'))
        {

            $ptlevel = DB::table('ptassignlevel')->where('trainerid',$request->strainerid)->get();
            if(count($ptlevel) == 0){
                $msg="Please Assign PT level";

                return redirect('personaltrainer/assignmembertotrainer')->withErrors(['msg' => $msg]);
            }

            $trainerchanges= Ptmember::where('memberid',$request->memberid)->where('packageid',$request->memberpackagesid)->get()->all();

            if($trainerchanges){
                foreach ($trainerchanges as $key => $value) {
                    $value->status = 'Deactive';
                    $value->save();
                }
            }
            $session=DB::select( DB::raw("SELECT  value from schemeterms where schemeid=(select schemeid from memberpackages where memberpackagesid=".$request->post('memberpackagesid')." AND (status = 1 OR status=0)) And termsid=2"));
            $j=0;
            $n=6;

            for($i=0;$i<=$n;$i++)
            {

                $strainerid= $request->post('strainerid');
                $memberid=$request->post('memberid');
                $fromdate= $request->post('fromdate');
                $enddate=$request->post('enddate');
                $sday=$request->post('sday'.$i);
                $memberpackagesid=$request->post('memberpackagesid');
                $q=DB::select( DB::raw("SELECT  expiredate,schemeid from memberpackages where memberpackagesid=".$memberpackagesid." AND (status = 1 OR status=0)"));

//                $todate= $q[0]->expiredate;
                $todate= $enddate;
                $schemeid=$q[0]->schemeid;

                for($date=$fromdate;$date<=$todate;$date=date('Y-m-d',strtotime($date.'+ 1 days ')))
                {
                    if($j < $session[0]->value)
                    {

                        $day=date('l',strtotime($date));
                        if($day==$sday)
                        {
                            $ptlevel = DB::table('ptassignlevel')->where('trainerid',$strainerid)->get();
                            $comission=$ptlevel[0]->percentage;

                            $t='';
                            if($request->post('600'.$i)!="")
                            {
                                $t=$request->post('600'.$i);
                            }
                            if($request->post('700'.$i)!="")
                            {
                                $t=$request->post('700'.$i);
                            }
                            if($request->post('800'.$i)!="")
                            {
                                $t=$request->post('800'.$i);
                            }
                            if($request->post('900'.$i)!="")
                            {
                                $t=$request->post('900'.$i);
                            }
                            if($request->post('1000'.$i)!="")
                            {
                                $t=$request->post('1000'.$i);
                            }
                            if($request->post('1100'.$i)!="")
                            {
                                $t=$request->post('1100'.$i);
                            }
                            if($request->post('1200'.$i)!="")
                            {
                                $t=$request->post('1200'.$i);
                            }
                            if($request->post('1300'.$i)!="")
                            {
                                $t=$request->post('1300'.$i);
                            }
                            if($request->post('1400'.$i)!="")
                            {
                                $t=$request->post('1400'.$i);
                            }
                            if($request->post('1500'.$i)!="")
                            {
                                $t=$request->post('1500'.$i);
                            }
                            if($request->post('1600'.$i)!="")
                            {
                                $t=$request->post('1600'.$i);
                            }
                            if($request->post('1700'.$i)!="")
                            {
                                $t=$request->post('1700'.$i);
                            }
                            if($request->post('1800'.$i)!="")
                            {
                                $t=$request->post('1800'.$i);
                            }
                            if($request->post('1900'.$i)!="")
                            {
                                $t=$request->post('1900'.$i);
                            }
                            if($request->post('2000'.$i)!="")
                            {
                                $t=$request->post('2000'.$i);
                            }
                            if($request->post('2100'.$i)!="")
                            {
                                $t=$request->post('2100'.$i);
                            }
                            if($request->post('2200'.$i)!="")
                            {
                                $t=$request->post('2200'.$i);
                            }
                            if($request->post('2300'.$i)!="")
                            {
                                $t=$request->post('2300'.$i);
                            }

                            $insert=[
                                'trainerid' => $strainerid,
                                'memberid' => $memberid,
                                'date'=>$date,
                                'fromdate' => $fromdate,
                                'todate' => $todate,
                                'day' => $day,
                                'packageid'=>$memberpackagesid,
                                'commision'=>$comission,
                                'schemeid'=>$schemeid,
                                'hoursfrom' =>$t];
                            $pm = DB::table('ptmember')->insert($insert);
                            if($t!="")
                            {
                                $j++;
                            }
                        }
                    }
                }
            }
        }

        return redirect('personaltrainer/assignmembertotrainer');
    }
    public function editassignpttomember(Request $request){
        DB::enableQueryLog();

        if($request->isMethod('post'))
        {
            $ptlevel = DB::table('ptassignlevel')->where('trainerid',$request->strainerid)->get();
            if(count($ptlevel) == 0){
                $msg="Please Assign PT level";

                return redirect('personaltrainer/assignmembertotrainer')->withErrors(['msg' => $msg]);
            }

            // echo $request;exit;
            $strainerid= $request->post('strainerid');
            $memberid=$request->post('memberid');
            $memberpackagesid=$request->post('memberpackagesid');

            $claimptmember = Ptmember::where(['trainerid' => $strainerid,'packageid'=>$memberpackagesid,'memberid' => $memberid])->where('status','!=','Active')->get()->count();
            if($claimptmember!=0){
                $msg="Can't Edit Cause Of Session Started";
                return redirect('personaltrainer/assignmembertotrainer')->withErrors(['msg' => $msg]);
            }

            $fromdate= $request->post('fromdate');
            $enddate= $request->post('enddate');
            $update=[
                'status' => 'Updated'];
//            $ptmemberupdate = DB::table('ptmember')->where(['trainerid' => $strainerid,'status'=>'Active','packageid'=>$memberpackagesid,'memberid' => $memberid])->where('date','>=',$fromdate)->where('date','<=',$enddate)->update($update);
            $ptmemberupdate = DB::table('ptmember')->where(['trainerid' => $strainerid,'packageid'=>$memberpackagesid,'memberid' => $memberid])->where('date','>=',$fromdate)->where('date','<=',$enddate)->delete();

//            $fdate = DB::select( DB::raw("SELECT distinct ptmember.fromdate from ptmember  where trainerid = '".$strainerid."' AND memberId = '".$memberid."'"));
            $fd=$fromdate;

            $q=DB::select( DB::raw("SELECT  expiredate,schemeid from memberpackages where memberpackagesid=".$memberpackagesid." AND (status = 1 OR status=0)"));
//            // $nod=$q[0]->expiredate;
//            $td= $q[0]->expiredate;
            $td= $enddate;
            $schemeid=$q[0]->schemeid;
            // dd($schemeid);
            $session=DB::select( DB::raw("SELECT  value from schemeterms where schemeid=(select schemeid from memberpackages where memberpackagesid=".$request->post('memberpackagesid')." AND (status = 1 OR status=0)) And termsid=2"));
            // $j=DB::table('ptmember')->where(['trainerid' => $strainerid,'status'=>'Active','packageid'=>z$memberpackagesid,'memberid' => $memberid])->count();
            $j = 0;
            // echo $td;exit;
            $n=6;
            // echo $n;
            $ptlevel = DB::table('ptassignlevel')->where('trainerid',$strainerid)->get();
            $comission=$ptlevel[0]->percentage;

            for($i=0;$i<=$n;$i++)
            {
                echo "$i";
                $sday=$request->post('sday'.$i);
                for($date=$fromdate;$date<=$enddate;$date=date('Y-m-d',strtotime($date.'+ 1 days ')))
                {
                    if($j < $session[0]->value)
                    {
                        $day=date('l',strtotime($date));
                        if($day==$sday)
                        {
                            // dd($i);
                            $t='';
                            if($request->post('600'.$i)!="")
                            {
                                $t=$request->post('600'.$i);
                            }
                            if($request->post('700'.$i)!="")
                            {
                                $t=$request->post('700'.$i);
                            }
                            if($request->post('800'.$i)!="")
                            {
                                $t=$request->post('800'.$i);
                            }
                            if($request->post('900'.$i)!="")
                            {
                                $t=$request->post('900'.$i);
                            }
                            if($request->post('1000'.$i)!="")
                            {
                                $t=$request->post('1000'.$i);
                            }
                            if($request->post('1100'.$i)!="")
                            {
                                $t=$request->post('1100'.$i);
                            }
                            if($request->post('1200'.$i)!="")
                            {
                                $t=$request->post('1200'.$i);
                            }
                            if($request->post('1300'.$i)!="")
                            {
                                $t=$request->post('1300'.$i);
                            }
                            if($request->post('1400'.$i)!="")
                            {
                                $t=$request->post('1400'.$i);
                            }
                            if($request->post('1500'.$i)!="")
                            {
                                $t=$request->post('1500'.$i);
                            }
                            if($request->post('1600'.$i)!="")
                            {
                                $t=$request->post('1600'.$i);
                            }
                            if($request->post('1700'.$i)!="")
                            {
                                $t=$request->post('1700'.$i);
                            }
                            if($request->post('1800'.$i)!="")
                            {
                                $t=$request->post('1800'.$i);
                            }
                            if($request->post('1900'.$i)!="")
                            {
                                $t=$request->post('1900'.$i);
                            }
                            if($request->post('2000'.$i)!="")
                            {
                                $t=$request->post('2000'.$i);
                            }
                            if($request->post('2100'.$i)!="")
                            {
                                $t=$request->post('2100'.$i);
                            }
                            if($request->post('2200'.$i)!="")
                            {
                                $t=$request->post('2200'.$i);
                            }
                            if($request->post('2300'.$i)!="")
                            {
                                $t=$request->post('2300'.$i);
                            }
                            // echo $t;
                            $insert=[
                                'trainerid' => $strainerid,
                                'memberid' => $memberid,
                                'date'=>$date,
                                'fromdate' => $fd,
                                'todate' => $td,
                                'day' => $day,
                                'packageid'=>$memberpackagesid,
                                'commision'=>$comission,
                                'schemeid'=>$schemeid,
                                'hoursfrom' =>$t,
                                'created_at' =>date('Y-m-d H:i:s'),
                                'updated_at' =>date('Y-m-d H:i:s')
                            ];
                            $pm = DB::table('ptmember')->insert($insert);
                            if($t!="")
                            {
                                $j++;
                            }
                        }
                    }
                }

            }
        }

        return redirect('personaltrainer/assignmembertotrainer');
    }

    // public function claimptsession(Request $request){

    //    $employees=Employee::where('roleid','4')->get()->all();
    //    $members=Member::get()->all();
    //    $grid=array();

    //    $memberid=$request->post('ptmemberid');
    //    $update=['status'=>'conducted',
    //            'conducteddate'=>date('Y-m-d H:i:s')
    //    ];
    //    $query=DB::table('ptmember')->where('ptmemberid',$memberid)->update($update);

    //  return view('admin.manageassignedmember',compact('members','employees','grid'));
    // }
    public function edittimeofmemberajax(Request $request){
        DB::enableQueryLog();
        $memberid=$request->get('ptmemberid');
        $trainerid=$request->get('trainerid');
        $time=$request->get('time');
        $update=['hoursfrom'=>$time,
            'trainerid'=>$trainerid
        ];
        $query=DB::table('ptmember')->where('ptmemberid',$memberid)->update($update);

        // echo  $memberid;
    }
    public function assignmembertotrainer(){

        $employees=Employee::where('roleid','4')->where('status','1')->get()->all();
        $members=Member::get()->all();

        return view('admin.Assign_Member_To_PT',compact('members','employees'));
    }



    /*********************************************************************************/



    public function manageassignedmember(Request $request){
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        if($request->isMethod('post'))
        {
            $memberid=$request->post('memberid');
            $packageid=$request->post('packageid');
            $trainerid=$request->post('trainerid');
            $trainername=Session::get('username');
            DB::enableQueryLog();

            $employees=Employee::where('roleid','4')->where('status','1')->get()->all();

            if(empty($todate))
            {
                $todate=date('Y-m-d');
            }

            $members = DB::select( DB::raw("select distinct `member`.* from `member` left join `ptmember` on (`ptmember`.`memberid` = `member`.`memberid`) where `ptmember`.`trainerid` = '".$trainerid."' and (`ptmember`.`status` = 'Active' or `ptmember`.`status` = 'Pending' or `ptmember`.`status` = 'Paid' or `ptmember`.`status` = 'Conducted' or `ptmember`.`status` = 'Marked' or `ptmember`.`status` = 'PaidPending') ORDER BY date Asc"));

            if(!empty($fromdate))
            {
                $grid = DB::select( DB::raw("select `ptmember`.*, `employee`.`username`, `employee`.`employeeid` from `ptmember` left join `employee` on `employee`.`employeeid` = `ptmember`.`trainerid` where `ptmember`.`memberid` = '".$memberid."' and `packageid` = '".$packageid."' and `ptmember`.`trainerid` = '".$trainerid."' and  ptmember.date >= '".$fromdate."' AND ptmember.date <= '".$todate."' and (`ptmember`.`status` = 'Active' or `ptmember`.`status` = 'Pending' or `ptmember`.`status` = 'Paid' or `ptmember`.`status` = 'Conducted' or `ptmember`.`status` = 'Marked' or `ptmember`.`status` = 'PaidPending') ORDER BY date Asc"));
            }
            else
            {
                $grid = DB::select( DB::raw("select `ptmember`.*, `employee`.`username`, `employee`.`employeeid` from `ptmember` left join `employee` on `employee`.`employeeid` = `ptmember`.`trainerid` where `ptmember`.`memberid` = '".$memberid."' and `packageid` = '".$packageid."' and `ptmember`.`trainerid` = '".$trainerid."' and (`ptmember`.`status` = 'Active' or `ptmember`.`status` = 'Pending' or `ptmember`.`status` = 'Paid' or `ptmember`.`status` = 'Conducted' or `ptmember`.`status` = 'Marked' or `ptmember`.`status` = 'PaidPending') ORDER BY date Asc"));
            }

            return view('admin.manageassignedmember',compact('members','employees','grid','memberid','packageid','trainerid','trainername','fromdate','todate'));
        }

        else
        {
            $employees=Employee::where('roleid','4')->where('status','1')->get()->all();
            if(Session::get('role')=="admin")
            {
                $members = DB::select( DB::raw("select distinct `member`.* from `member` left join `ptmember` on (`ptmember`.`memberid` = `member`.`memberid`) where (`ptmember`.`status` = 'Active' or `ptmember`.`status` = 'Pending' or `ptmember`.`status` = 'Conducted' or `ptmember`.`status` = 'Paid' or `ptmember`.`status` = 'Marked' or `ptmember`.`status` = 'PaidPending')"));
                $grid=array();
            }
            else
            {
                $trainerid=Session::get('employeeid');
                $trainername=Session::get('username');
                $members = DB::select( DB::raw("select distinct `member`.* from `member` left join `ptmember` on (`ptmember`.`memberid` = `member`.`memberid`) where `ptmember`.`trainerid` = '".$trainerid."' and (`ptmember`.`status` = 'Active' or `ptmember`.`status` = 'Pending' or `ptmember`.`status` = 'Paid' or `ptmember`.`status` = 'Conducted' or `ptmember`.`status` = 'Marked' or `ptmember`.`status` = 'PaidPending')"));
                $grid=array();
            }
            $trainerid=Session::get('employeeid');
            $trainername=Session::get('username');
            return view('admin.manageassignedmember',compact('members','employees','grid','trainername','trainerid','fromdate','todate'));
        }
    }


    public function sessionreport(Request $request){
        $fromdate = $request->fromdate;
        $todate = $request->todate;

        if($request->isMethod('post'))
        {

            $packageid=$request->packageid;
            $traineridgen=$request->trainerid;
            $memberidgen=$request->memberid;
            $employees=Employee::where('roleid','4')->where('status','1')->get()->all();
            $members = DB::select( DB::raw("select distinct `member`.* from `member` left join `ptmember` on (`ptmember`.`memberid` = `member`.`memberid`) where `ptmember`.`trainerid` = '".$traineridgen."' and (`ptmember`.`status` = 'Active' or `ptmember`.`status` = 'Pending' or `ptmember`.`status` = 'Marked')"));

            if(empty($todate))
            {
                $todate=date('Y-m-d');
            }
            $grid=array();
            if(!empty($fromdate)){
                $grid= Claimptsession::
                join('ptmember',['ptmember.trainerid'=>'claimptsession.trainerid','ptmember.packageid'=>'claimptsession.packageid','ptmember.memberid'=>'claimptsession.memberid','ptmember.date'=>'claimptsession.scheduledate'])
                    ->where('ptmember.status','!=','Updated')
                    ->where('claimptsession.memberid',$memberidgen)->where('claimptsession.packageid',$packageid)->where('claimptsession.trainerid',$traineridgen)
                    ->leftjoin('employee','employee.employeeid','claimptsession.trainerid')
                    ->whereBetween('claimptsession.actualdate', [$fromdate, $todate])
                    ->orderBy('claimptsession.created_at','asc')
                    ->get(['claimptsession.*','claimptsession.memberid as pmemberid','claimptsession.trainerid AS ptrainerid','claimptsession.packageid AS ppackageid','ptmember.status AS ptmemberstatus', 'employee.username', 'employee.employeeid','ptmember.ptmemberid'])->all();

//          $ptmember =  Ptmember::where('memberid',$memberidgen)->where('packageid',$packageid)->where('trainerid',$traineridgen)
//          ->where('hoursfrom','!=','')
//          ->orderBy('date','ASC')
//          ->get()->all();
//            foreach ($grid as $key => $value) {
//             $grid[$key]->status = $ptmember[$key]->status;
//             $grid[$key]->paymentstatus = $ptmember[$key]->paymentstatus;
//             $grid[$key]->day = $ptmember[$key]->day;
//             $grid[$key]->hoursfrom = $ptmember[$key]->hoursfrom;
//             $grid[$key]->toddate = $ptmember[$key]->toddate;
//             $grid[$key]->ptmemberid = $ptmember[$key]->ptmemberid;
//            }
                // DB::enableQueryLog();
                // $grid = DB::select( DB::raw("select `ptmember`.*,claimptsession.*,ptmember.memberid AS 'pmemberid',ptmember.trainerid AS 'ptrainerid',ptmember.packageid AS 'ppackageid',ptmember.status AS 'ptmemberstatus', `employee`.`username`, `employee`.`employeeid` from `ptmember`
                // left join `employee` on `employee`.`employeeid` = `ptmember`.`trainerid` right join claimptsession on ptmember.trainerid=claimptsession.trainerid AND ptmember.memberid=claimptsession.memberid AND ptmember.date=claimptsession.scheduledate  where `ptmember`.`memberid` = '".$memberidgen."' and `ptmember`.`packageid` = '".$packageid."'
                // and `ptmember`.`trainerid` = '".$traineridgen."' and  claimptsession.actualdate >= '".$fromdate."' AND
                // claimptsession.actualdate <= '".$todate."' and (`ptmember`.`status` = 'Active' or `ptmember`.`status` = 'Pending'  or `ptmember`.`status` = 'Deactive' or `ptmember`.`status` = 'Conducted' or `ptmember`.`status` = 'Marked')"));

                // dd( DB::getQueryLog());
            }
            else
            {
                $grid= Claimptsession::
                leftjoin('employee','employee.employeeid','claimptsession.trainerid')
                    ->join('ptmember',['ptmember.trainerid'=>'claimptsession.trainerid','ptmember.packageid'=>'claimptsession.packageid','ptmember.memberid'=>'claimptsession.memberid','ptmember.date'=>'claimptsession.scheduledate'])
                    ->where('ptmember.status','!=','Updated')
                    ->where('claimptsession.memberid',$memberidgen)->where('claimptsession.packageid',$packageid)->where('claimptsession.trainerid',$traineridgen)
                    ->orderBy('claimptsession.created_at','asc')
                    ->get(['claimptsession.*','claimptsession.memberid as pmemberid','claimptsession.trainerid AS ptrainerid','claimptsession.packageid AS ppackageid','ptmember.status AS ptmemberstatus', 'employee.username', 'employee.employeeid','ptmember.ptmemberid'])->all();

//          $ptmember =  Ptmember::where('memberid',$memberidgen)->where('packageid',$packageid)->where('trainerid',$traineridgen)
//          ->where('hoursfrom','!=','')
//          ->orderBy('date','ASC')
//          ->get()->all();
////            dd($grid);
//            foreach ($grid as $key => $value) {
//             $grid[$key]->status = $ptmember[$key]->status;
//             $grid[$key]->paymentstatus = $ptmember[$key]->paymentstatus;
//             $grid[$key]->day = $ptmember[$key]->day;
//             $grid[$key]->hoursfrom = $ptmember[$key]->hoursfrom;
//             $grid[$key]->toddate = $ptmember[$key]->toddate;
//             $grid[$key]->ptmemberid = $ptmember[$key]->ptmemberid;
//            }
                DB::enableQueryLog();
                // $grid = DB::select( DB::raw("select `ptmember`.*,claimptsession.*,ptmember.memberid AS 'pmemberid',ptmember.trainerid AS 'ptrainerid',ptmember.packageid AS 'ppackageid',ptmember.status AS 'ptmemberstatus', `employee`.`username`, `employee`.`employeeid` from `ptmember`
                // left join `employee` on `employee`.`employeeid` = `ptmember`.`trainerid` right join claimptsession on ptmember.trainerid=claimptsession.trainerid AND ptmember.memberid=claimptsession.memberid AND ptmember.date=claimptsession.scheduledate  where `ptmember`.`memberid` = '".$memberidgen."' and `ptmember`.`packageid` = '".$packageid."'
                // and `ptmember`.`trainerid` = '".$traineridgen."' and (`ptmember`.`status` = 'Active' or `ptmember`.`status` = 'Pending'  or `ptmember`.`status` = 'Deactive' or `ptmember`.`status` = 'Conducted' or `ptmember`.`status` = 'Marked' )"));
                // dd( DB::getQueryLog());
            }
            $trainerid=$traineridgen;
            return view('admin.sessionreport',compact('members','employees','grid','trainerid','fromdate','todate'));
        }

        $employees=Employee::where('roleid','4')->where('status','1')->get()->all();

//         $members = DB::select( DB::raw("select distinct `member`.* from `member` left join `ptmember` on (`ptmember`.`memberid` = `member`.`memberid`) and (`ptmember`.`status` = 'Active' or `ptmember`.`status` = 'Pending' or `ptmember`.`status` = 'Marked' or `ptmember`.`status` = 'Conducted')"));
        $grid=array();


        $trainerid=Session::get('employeeid');

        return view('admin.sessionreport',compact('employees','grid','trainerid','fromdate','todate'));
    }
    public function  gettrainermember(Request $request){

        $trainerid = $request->get('trainerid');

        $reportmembers=DB::select( DB::raw("select distinct `member`.* from `member` left join memberpackages on memberpackages.userid = member.userid left join `schemes` on `schemes`.`schemeid` = `memberpackages`.`schemeid` where `schemes`.`rootschemeid`= 2 and (memberpackages.status=0 OR memberpackages.status=1)"));

        return  json_encode($reportmembers);

    }
    public function  getsessiontrainermember(Request $request){

        $trainerid = $request->get('trainerid');

        $reportmembers=DB::select( DB::raw("select distinct `member`.* from `member` left join `ptmember` on `ptmember`.`memberid` = `member`.`memberid` left join memberpackages on memberpackages.memberpackagesid = ptmember.packageid where `ptmember`.`trainerid` = '".$trainerid."'  And(`ptmember`.`status` = 'Active' or `ptmember`.`status` = 'Deactive' or `ptmember`.`status` = 'Pending')"));

        // $reportmembers=DB::select( DB::raw("select distinct `member`.* from `member` left join memberpackages on memberpackages.userid = member.userid left join `schemes` on `schemes`.`schemeid` = `memberpackages`.`schemeid` where `schemes`.`rootschemeid`= 2 and memberpackages.status=1"));
        return  json_encode($reportmembers);
    }
    public function getpackage(Request $request){

        $member = $request->get('memberid');



        $demo =  DB::table('member')->where('memberid', '=', $member)->get()->first();

        $mobileno=$demo->mobileno;
        $package = DB::select( DB::raw("SELECT memberpackages.*,schemes.schemeid,schemes.schemename from memberpackages
                                            left Join schemes on memberpackages.schemeid=schemes.schemeid
                                            left Join schemeterms on schemeterms.schemeid=schemes.schemeid
                                              where memberpackages.userid='".$demo->userid."'AND schemes.rootschemeid = '2' AND schemeterms.value != 0"));
        if($package){
            foreach ($package as $key => $value) {
                $value->mobileno = $mobileno;
            }
        }

        echo json_encode($package);



    }
    public function excel(Request $request) {

        $packageid=$request->packageid;
        $traineridgen=$request->trainerid;
        $memberidgen=$request->memberid;

        $grid = DB::select( DB::raw("select `ptmember`.*,claimptsession.*,ptmember.memberid AS 'pmemberid',ptmember.trainerid AS 'ptrainerid',ptmember.packageid AS 'ppackageid',ptmember.status AS 'ptmemberstatus', `employee`.`username`, `employee`.`employeeid`
     from `ptmember` left join `employee` on `employee`.`employeeid` = `ptmember`.`trainerid` left join claimptsession on ptmember.trainerid=claimptsession.trainerid AND ptmember.memberid=claimptsession.memberid
     AND ptmember.date=claimptsession.scheduledate  where `ptmember`.`memberid` = '".$memberidgen."' and `ptmember`.`packageid` = '".$packageid."' and `ptmember`.`trainerid` = '".$traineridgen."' and `ptmember`.`hoursfrom` is NOT NULL and (`ptmember`.`status` = 'Active' or `ptmember`.`status` = 'Pending' or `ptmember`.`status` = 'Conducted' or `ptmember`.`status` = 'Marked')"));
        $employee=Employee::where('employeeid',$traineridgen)->where('status',1)->get()->first();
        $employeename=$employee->username;
        $member=Member::where('memberid',$memberidgen)->where('status',1)->get()->first();
        $membername=$member->firstname.' '.$member->lastname;
        $package=MemberPackages::where('memberpackagesid',$packageid)->get()->first();
        $schemeid=$package->schemeid;
        $scheme= Scheme::where('schemeid',$schemeid)->where('status',1)->get()->first();
        $schemename=$scheme->schemename;
        if($grid){
            $student_array[] = array('Member','Trainer', 'Day','Date', 'Fromdate','Todate', 'Hoursfrom','Hoursto','Actualdate','Status','Packageid','Schemeid','Commision','Persessioncommision','Persessionamount','Paymentstatus','Conducteddate','Conductedtime');

            foreach ($grid as $student)
            {

                $student_array[] = array(
                    'Member' => $membername,
                    'Trainer' =>$employeename,
                    'Day'      => $student->day,
                    'Date'      => $student->date,
                    'Fromdate'   => $student->fromdate,
                    'Todate'   => $student->todate,
                    'Hoursfrom'   => $student->hoursfrom,
                    'Hoursto'   => $student->hoursto,
                    'Actualdate'   => $student->actualdate,
                    'Status'   => $student->ptmemberstatus,
                    'Packageid'   => $student->ppackageid,
                    'Scheme'   => $schemename,
                    'Commision'   => $student->commision,
                    'Persessioncommision' => $student->persessioncommision,
                    'Persessionamount'   => $student->persessionamount,
                    'Paymentstatus'   => $student->paymentstatus,
                    'Conducteddate'   => $student->conducteddate,
                    'Conductedtime'   => $student->conductedtime,
                );
            }

            $myFile=  Excel::create('salesdet', function($excel) use ($student_array) {
                $excel->sheet('mySheet', function($sheet) use ($student_array)
                {

                    $sheet->fromArray($student_array);

                });
            });


            // $myFile= Excel::create('payments', function($excel) use ($student_array) {

            //       // Set the spreadsheet title, creator, and description
            //       $excel->setTitle('Payments');
            //       $excel->setCreator('Laravel')->setCompany('WJ Gilmore, LLC');
            //       $excel->setDescription('payments file');

            //       // Build the spreadsheet, passing in the payments array
            //       $excel->sheet('sheet1', function($sheet) use ($student_array) {
            //           $sheet->fromArray($student_array, null, 'A1', false, false);
            //       });

            //   });
            $myFile = $myFile->string('xlsx'); //change xlsx for the format you want, default is xls
            $response =  array(
                'name' => "Claim Session Report", //no extention needed
                'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($myFile) //mime type of used format
            );
            return response()->json($response);
            echo 'yes';

        }


    }
    public function getqueryresultforexcel(Request $request){
        $packageid=$request->packageid;
        $traineridgen=$request->trainerid;
        $memberidgen=$request->memberid;

        $grid = DB::select( DB::raw("select `ptmember`.*,claimptsession.*,ptmember.memberid AS 'pmemberid',ptmember.trainerid AS 'ptrainerid',ptmember.packageid AS 'ppackageid',ptmember.status AS 'ptmemberstatus', `employee`.`username`, `employee`.`employeeid` from `ptmember` left join `employee` on `employee`.`employeeid` = `ptmember`.`trainerid` left join claimptsession on ptmember.trainerid=claimptsession.trainerid AND ptmember.memberid=claimptsession.memberid AND ptmember.date=claimptsession.scheduledate  where `ptmember`.`memberid` = '".$memberidgen."' and `ptmember`.`packageid` = '".$packageid."' and `ptmember`.`trainerid` = '".$traineridgen."' and (`ptmember`.`status` = 'Active' or `ptmember`.`status` = 'Pending' or `ptmember`.`status` = 'Conducted')"));
        echo json_encode($grid);

    }
    public function deletesession(Request $request,$id,$tid,$mid,$pid){


        DB::beginTransaction();
        try{
            $ptmember=Ptmember::where('ptmemberid',$id)->get()->first();
            $ptmember->status = "Active";
            $ptmember->save();
            $claimptsession = Claimptsession::where('trainerid',$ptmember->trainerid)
                ->where('memberid',$ptmember->memberid)
                ->where('packageid',$ptmember->packageid)
                ->where('scheduledate',$ptmember->date)
                ->where('scheduletime',$ptmember->hoursfrom)
                ->first();
            $claimptsession->status = "Deleted";
            $claimptsession->save();

            DB::commit();
            $success =true;
            return redirect()->to('sessionreport/'.$tid.'/'.$mid.'/'.$pid)->withSuccess('Succesfully Deleted');
        }catch(\Exception $e){
            $success = false;
            DB::rollback();
        }

        if($success == false){
            return redirect()->to('sessionreport/'.$tid.'/'.$mid.'/'.$pid)->withError('Succesfully Deleted');
        }


    }
}
