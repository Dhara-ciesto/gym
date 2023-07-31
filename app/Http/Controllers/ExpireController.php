<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\MemberPackages;
use DB;
use Carbon\Carbon;
use App\RootScheme;
use App\Scheme;
use App\Member;
use Maatwebsite\Excel\Concerns\FromCollection;
use Excel;

class ExpireController extends Controller
{
    public function expirereport(Request $request)
    {
        $query=[];
        $paymentdata='';
        $fdate =$request->get('fdate');
        $tdate =$request->get('tdate');
        $username=$request->get('username');
        $day=$request->get('day');
        
        $keyword =$request->get('keyword');
         $pstatus =$request->get('pstatus');
        $query['fdate']=$request->fdate;
        $query['tdate']=$request->tdate;
        $query['day']=$request->day;
        $query['username']=$request->username;
        $query['keyword']=$request->keyword;
        $query['rootschemeid']=$request->rootschemeid;
        $query['schemeid']=$request->schemeid; 
        $query['gender']=$request->gender; 
        $query['status']=$request->status; 
        $query['pstatus']=$request->pstatus; 
        

        $users= Member::get()->all();
        $rootschemes = RootScheme::where('status',1)->get()->all();
        $schemes= Scheme::where('status',1)->get()->all();

        $grid=MemberPackages::leftjoin('users','users.userid','memberpackages.userid')
        ->leftjoin('member', 'member.userid','users.userid')
        ->leftjoin('schemes','schemes.schemeid','memberpackages.schemeid');

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
          $grid->where('member.memberid',$username);
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
        if($query['pstatus'] != ""){
            $grid->where('memberpackages.status',$query['pstatus']);
        }
        if($day != ""){
            $date=Carbon::now()->addDays($day);
            $today=date('Y-m-d');
            $grid->whereBetween('memberpackages.expiredate',[$today, $date]);
        }
        $paymentdata=$grid->orderBy('memberpackages.expiredate','asc')->get()->all();
        return view('admin.Reports.expirereport',compact('query','paymentdata','users','rootschemes','schemes'));
    }    
}
