<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Member;
use App\Measurement;
use DB;
use Session;
use App\Ptmember;

class MeasurementController extends Controller
{
     public function addMeasurement(Request $request)
    {   


              $method = $request->method();
              if ($request->isMethod('post')){

              $request->validate([
              'selectusername' => 'required',
              'weight' => 'numeric|nullable',
              'height' => 'numeric|nullable',
              'neck' => 'numeric|nullable',
              'leftupperarm' => 'numeric|nullable',
              'rightupperarm' => 'numeric|nullable',
              'chest' => 'numeric|nullable',
              'leftthigh' => 'numeric|nullable',
              'rightthigh' => 'numeric|nullable',
              'leftcalf' => 'numeric|nullable',
              'rightcalf' => 'numeric|nullable',
              'waist' => 'numeric|nullable',
              'hips' => 'numeric|nullable',

              ]);

              Measurement::create([
                'todaydate'=>$request['todaydate'],
                'memberid'=>$request['selectusername'],
                'weight'=>$request['weight'],
                'height'=>$request['height'],
                'neck'=>$request['neck'],
                'leftupperarm'=>$request['leftupperarm'],
                'rightupperarm'=>$request['rightupperarm'],
                'chest'=>$request['chest'],
                'leftthigh'=>$request['leftthigh'],
                'rightthigh'=>$request['rightthigh'],
                'leftcalf'=>$request['leftcalf'],
                'rightcalf'=>$request['rightcalf'],
                'waist'=>$request['waist'],
                'hips'=>$request['hips'],
              ]);
            return  redirect('viewMeasurement')->with('message','Succesfully Added');
              }
              if(Session::get('role')=='trainer'){
                $users=[];
               $usersall= Ptmember::where('trainerid', Session::get('employeeid'))->leftjoin('member','member.memberid','ptmember.memberid')->groupBy('ptmember.memberid')->pluck('ptmember.memberid')->all();
                foreach ($usersall as $key => $value) {
                 $val= Member::where('memberid',$value)->where('status',1)->join('users', 'member.userid', '=', 'users.userid')->first();
                  if($val){
                    array_push($users, $val);
                  }
                }
              }
              else{

               $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->whereIN('member.status',[1,0])->get()->all();
              }

       return  view('admin.measurement.addMeasurement',compact('users'));
       
    }
    public function measurementgetuser(Request $request){
    	$id=$request->get('username');
    	$request->get('MobileNo');
    	$user=Member::where('memberid',$id)->get()->first();
    	echo json_encode($user);

    }
     public function viewMeasurement(Request $request)
    {
        
        if(Session::get('role')=='trainer'){
          $users=[];
          $measurement=[];
          $usersall= Ptmember::where('trainerid', Session::get('employeeid'))
          ->leftjoin('member','member.memberid','ptmember.memberid')
          ->groupBy('ptmember.memberid')->pluck('ptmember.memberid')
          ->all();
          
          foreach ($usersall as $key => $value) {
            $val= Member::where('memberid',$value)->join('users', 'member.userid', '=', 'users.userid')->first();
              if($val){
                array_push($users, $val);
              }
       
          $measurement1=Measurement::leftjoin('member','member.memberid','measurement.memberid')->where('measurement.memberid',$value)->get()->first();
          if($measurement1){
            array_push($measurement, $measurement1);    
          }
          }
        }
       
        else{
          $measurement=Measurement::leftjoin('member','member.memberid','measurement.memberid')->get()->all();
          $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();
        }
        
      if($request->isMethod('post'))
      {
        DB::enableQueryLog();
        if(Session::get('role')=='trainer'){
           $users=[];
          $usersall= Ptmember::where('trainerid', Session::get('employeeid'))->leftjoin('member','member.memberid','ptmember.memberid')->groupBy('ptmember.memberid')->pluck('ptmember.memberid')->all();
          foreach ($usersall as $key => $value){
            $val= Member::where('memberid',$value)->where('status',1)->join('users', 'member.userid', '=', 'users.userid')->first();
             if($val){
          array_push($users, $val);
        }

            $measurement = Measurement::whereIn('memberid' ,$usersall)->orderBy('measurementid','desc')->get()->all();
          }
        }else{
          $measurement = Measurement::where('measurement.memberid','>','0')->leftjoin('member','member.memberid','measurement.memberid')->orderBy('measurementid','desc');
          if($request->get('selectusername')!="")
          {
            $id=$request->get('selectusername');
    
            $measurement->where('measurement.memberid',$id);
          }
          if($request->get('from')!="")
        {
          $from = date($request->get('from'));
          if($request->get('to')){
            $to = date($request->get('to'));
          }
          else{
            $to = date('Y-m-d');
          }
          $measurement->whereBetween('todaydate', [$from, $to]);
        }
        if($request->get('to')!="")
        {
        
          $to = date($request->get('to'));
          if($request->get('from')){
            $from = date($request->get('from'));
          }
          else{
            $from = date('Y-m-d');
          }
          $measurement->whereBetween('todaydate', [$from, $to]);
      }
     
     
       $measurement=$measurement->get()->all();
      
        }
        
     
        // dd(DB::getQueryLog());

      
        return view('admin.measurement.viewMeasurement',compact('users','measurement'));
      }

        return view('admin.measurement.viewMeasurement',compact('users','measurement'));
     }
     public function editMeasurement(Request $request,$id)
     {
      
        $method = $request->method();
        if ($request->isMethod('post')){

              $request->validate([
              'selectusername' => 'required',
              'weight' => 'numeric|nullable',
              'height' => 'numeric|nullable',
              'neck' => 'numeric|nullable',
              'leftupperarm' => 'numeric|nullable',
              'rightupperarm' => 'numeric|nullable',
              'chest' => 'numeric|nullable',
              'leftthigh' => 'numeric|nullable',
              'rightthigh' => 'numeric|nullable',
              'leftcalf' => 'numeric|nullable',
              'rightcalf' => 'numeric|nullable',
              'waist' => 'numeric|nullable',
              'hips' => 'numeric|nullable',

              ]);

        
         $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();
        $editmeasurement=Measurement::where('measurementid',$id)->get()->first();
          $editmeasurement->todaydate=$request['todaydate'];
          $editmeasurement->memberid=$request['selectusername'];
          $editmeasurement->weight=$request['weight'];
          $editmeasurement->height=$request['height'];
          $editmeasurement->neck=$request['neck'];
          $editmeasurement->leftupperarm=$request['leftupperarm'];
          $editmeasurement->rightupperarm=$request['rightupperarm'];
          $editmeasurement->chest=$request['chest'];
          $editmeasurement->leftthigh=$request['leftthigh'];
          $editmeasurement->rightthigh=$request['rightthigh'];
          $editmeasurement->leftcalf=$request['leftcalf'];
          $editmeasurement->rightcalf=$request['rightcalf'];
          $editmeasurement->waist=$request['waist'];
          $editmeasurement->hips=$request['hips'];
          $editmeasurement->save();
          return  redirect('viewMeasurement')->with('message','Succesfully Edited');       
                 }
            $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();
        $editmeasurement=Measurement::where('measurementid',$id)->get()->first();              
        return view('admin.measurement.editMeasurement',compact('editmeasurement','users'));
     }
}
