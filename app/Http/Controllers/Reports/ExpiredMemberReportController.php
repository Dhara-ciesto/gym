<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\MemberPackages;
use DB;
use Carbon\Carbon;
use App\RootScheme;
use App\Scheme;
use Maatwebsite\Excel\Concerns\FromCollection;
use Excel;


class ExpiredMemberReportController extends Controller
{
    public function expiredmemberreport(Request $request){
        $query=[];
        $paymentdata='';
        $fdate =$request->get('fdate');
        $tdate =$request->get('tdate');
        $username=$request->get('username');
        $day=$request->get('day');

        $keyword =$request->get('keyword');
        $query['fdate']=$request->fdate;
        $query['tdate']=$request->tdate;
        $query['day']=$request->day;
        $query['username']=$request->username;
        $query['keyword']=$request->keyword;
        $query['rootschemeid']=$request->rootschemeid;
        $query['schemeid']=$request->schemeid;
        $query['gender']=$request->gender;
        $query['status']=$request->status;


        $users= DB::table('users')->Join('member', 'member.userid', '=', 'users.userid')->get()->all();
        $rootschemes = RootScheme::where('status',1)->get()->all();
        $schemes= Scheme::where('status',1)->get()->all();

        DB::enableQueryLog();
        $grid=MemberPackages::leftjoin('users','users.userid','memberpackages.userid')
            ->leftjoin('member', 'member.userid','users.userid')
            ->leftjoin('schemes','schemes.schemeid','memberpackages.schemeid');

        if ($request->isMethod('post')){

            if ($fdate != "") {
                $from = date($fdate);
                //$to = date($to);
                if (!empty($tdate)) {
                    $to = date($tdate);
                }else{
                    $to = date('Y-m-d');
                }
                // ->whereBetween('followupdays', [$from, $to])
                $grid->whereBetween('memberpackages.expiredate', [$from, $to]);

            }

            if ($tdate != "") {
                $to = date($tdate);
                if (!empty($fdate)) {
                    $from = date($fdate);
                }else{
                    $from = '';
                }
                $grid->whereBetween('memberpackages.expiredate', [$from, $to]);
            }
            if ($keyword != ""){
                $grid->where ( 'users.username', 'LIKE', '%' . $keyword . '%' );
            }
            if($username != ""){
                $grid->where('users.userid',$username);
            }
            // dd($paymentdata->paginate(5));


            if($query['rootschemeid'] != ""){

                $grid->where('schemes.rootschemeid',$query['rootschemeid']);
            }
            if($query['schemeid'] != ""){
                $grid->where('memberpackages.schemeid',$query['schemeid']);
            }
            if($query['gender'] != ""){
                $grid->where('member.gender',$query['gender']);
            }
            if($query['status'] != ""){
                $grid->where('member.status',$query['status']);
            }
            if($day != ""){
                $date=Carbon::now()->addDays($day);
                $today=date('Y-m-d');
                $grid->whereBetween('memberpackages.expiredate',[$today, $date]);
            }


            $paymentdata=$grid->orderBy('memberpackages.expiredate','asc')->get()->all();

            return view('admin.Reports.expiredmembershiplist',compact('query','paymentdata','users','rootschemes','schemes'));
        }else{

            return view('admin.Reports.expiredmembershiplist',compact('query','users','paymentdata','rootschemes','schemes'));
        }
    }
    public function expiredmemberexcel(Request $request){

        if($request->isMethod('post'))
        {

            DB::enableQueryLog();
            $fdate =$request->get('fdate');
            $tdate =$request->get('tdate');
            $username=$request->get('user');
            $day=$request->get('day');
            $keyword =$request->get('keyword');
            /*for pass to bladefile */
            $query=[];
            $query['fdate']=$fdate ;
            $query['tdate']=$tdate ;
            $query['username']=$username;
            $query['day']= $day;
            $query['keyword']= $keyword;
            $query['rootschemeid']=$request->rootschemeid;
            $query['schemeid']=$request->schemeid;
            $query['gender']=$request->gender;
            $query['status']=$request->status;

            $grid=MemberPackages::leftjoin('users','users.userid','memberpackages.userid')->leftjoin('schemes','schemes.schemeid','memberpackages.schemeid');


            if ($fdate != "empty") {
                $from = date($fdate);
                //$to = date($to);
                if ($tdate != "empty") {
                    $to = date($tdate);
                }else{
                    $to = date('Y-m-d');
                }
                // ->whereBetween('followupdays', [$from, $to])
                $grid->whereBetween('memberpackages.expiredate', [$from, $to]);

            }
            if ($tdate != "empty") {
                $to = date($tdate);
                if ($fdate != "empty") {
                    $from = date($fdate);
                }else{
                    $from = date('Y-m-d');
                }
                $grid->whereBetween('memberpackages.expiredate', [$from, $to]);
            }


            if ($keyword != "empty"){
                $grid->where ( 'users.username', 'LIKE', '%' . $keyword . '%' );
            }
            // dd($username);
            if($username != "empty"){
                $grid->where('users.userid',$username);
            }
            if($query['rootschemeid'] != ""){

                $grid->where('schemes.rootschemeid',$query['rootschemeid']);
            }
            if($query['schemeid'] != ""){
                $grid->where('memberpackages.schemeid',$query['schemeid']);
            }
            if($query['gender'] != ""){
                $grid->where('member.gender',$query['gender']);
            }
            if($query['status'] != ""){
                $grid->where('member.status',$query['status']);
            }
            // dd($paymentdata->paginate(5));

            if($day != "empty"){
                $date=Carbon::now()->addDays($day);
                $today=date('Y-m-d');
                $grid->whereBetween('memberpackages.expiredate',[$today, $date]);
            }

            $gridexcel=$grid->orderBy('memberpackages.expiredate','asc')->get()->all();

            if($gridexcel){
                // $student_array[] = array('InvoiceID','Member','Payment Date', 'Amount','type','GST (%)', 'Gst Amount','GST NO','Companyname', );



                $gridexcel_array[] = array('User',  'Mobile No','Scheme','Day', 'Invoice No','JoinDate','ExpireDate');

                // dd($expensepayment);

                foreach ($gridexcel as $gridexcel1)
                {
                    $diff = strtotime($gridexcel1->expiredate) - strtotime(date('Y-m-d'));
                    $d= abs(round($diff / 86400));

                    $gridexcel_array[] = array(
                        'User' => $gridexcel1->username,
                        'Mobile No'  => $gridexcel1->usermobileno,

                        'Scheme' => $gridexcel1->schemename,
                        'day' => $d,
                        'Invoice No' => $gridexcel1->memberpackagesid,
                        'JoinDate' => date('d-m-Y', strtotime($gridexcel1->joindate)),
                        'ExpireDate' => date('d-m-Y', strtotime($gridexcel1->expiredate)),
                    );
                }

                $myFile=  Excel::create('Expire Member Report', function($excel) use ($gridexcel_array) {
                    $excel->sheet('mySheet', function($sheet) use ($gridexcel_array)
                    {

                        $sheet->fromArray($gridexcel_array);

                    });
                });
                $myFile = $myFile->string('xlsx'); //change xlsx for the format you want, default is xls
                $response =  array(
                    'name' => "Expire Memer Report", //no extention needed
                    'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($myFile) //mime type of used format
                );
                return response()->json($response);
                echo 'yes';

            }
        }

    }
}
