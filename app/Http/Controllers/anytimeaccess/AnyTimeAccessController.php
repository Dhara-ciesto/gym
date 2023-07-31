<?php

namespace App\Http\Controllers\anytimeaccess;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AnyTimeAccessBelt;
use Illuminate\Validation\Rule;
use App\User;
use App\ApiCronJob;
use App\UserAssignedBelt;
use DB;
use App\Actionlog;
use session;
use App\notify;

class AnyTimeAccessController extends Controller
{
	public function index(Request $request)
    {
            $belts = AnyTimeAccessBelt::paginate(10);
          
            return view('admin.anytimeaccess.viewanytimeaccess',compact('belts'));
    }
  public function addanytimeaccesscard(Request $request){

  	if($request->isMethod('post'))
    {

         $did = AnyTimeAccessBelt::orderBy('anytimeaccessbeltid','desc')->first();

        

        if ($did) {

          $deviceid = $did->deviceid + 1;
         
          $request->request->add(['deviceid' => $deviceid,'beltusername' => 'Belt'.$deviceid,'validity' => $request['validity'],'for'=>'belt']);

            # code...
        }else{

          $deviceid = 10001;

          $request->request->add(['deviceid' => $deviceid,'beltusername' => 'Belt'.$deviceid,'validity' => $request['validity'],'for'=>'belt']);

        }


      $request->validate([
      'beltno' => 'required|max:255|unique:anytimeaccessbelt,beltno',
      
      ], ['beltno.unique' => 'Access Card Is Already Used ! Try With Different Access Card']);

      $belt = AnyTimeAccessBelt::where('beltno', $request['beltno'])->get()->all();

      
	  if($belt){

	      return redirect()->back()->withErrors('Card Already exists');
	  }

     $set = app()->call('App\Http\Controllers\DeviceController@setuserfromsummary');

    

     if ($request->setapistatus == 'Success') {

       

             AnyTimeAccessBelt::create([
                    'beltno' => $request['beltno'],
                    'validity' => $request['validity'],
                    'beltstatus'=>'free',
                    'deviceid' => $deviceid,
                    'username' => 'Belt'.$deviceid,

                ]);

                  $action = new Actionlog();
                  $action->user_id = session()->get('admin_id');
                  $action->ip = $request->ip();
                  $action->action_type = 'insert';
                  $action->action = 'Insert Belt InTo Device';
                  $action->save();

          

             return redirect('viewanytimeaccesscard')->with('message','Card is succesfully Added');


         }else{

           return redirect()->back()->withErrors('Some Things Went Wrong ! Please Try Again');

         }

    }
    else
    {
    	return view('admin.anytimeaccess.addanytimeaccess');
    }
  
  }
     public function editanytimeaccesscard($id, Request $request)
    {
       
     
       $belt=AnyTimeAccessBelt::findOrFail($id);
       
        if ($request->isMethod('post')){

         $beltdeviceid = $belt->deviceid;
         $beltdeviceusername = $belt->username;
         $validity = $request->validity;

         $request->request->add(['deviceid' => $beltdeviceid,'beltusername' => $beltdeviceusername,'validity' => $validity,'for'=>'belt']);

         $request->validate([
              'beltno' => ['required', Rule::unique('anytimeaccessbelt')->ignore($id, 'anytimeaccessbeltid')],
              
              ]);

          $extendexpiry = app()->call('App\Http\Controllers\DeviceController@extendexpiry');

          $belt->beltno=$request->beltno;
          $belt->validity=$request->validity;
          $belt->save();

         return redirect('viewanytimeaccesscard')->with('message','Card is succesfully Edited');
        }
   
        return view('admin.anytimeaccess.editanytimeaccess',compact('belt'));
    }
    public function atacardassigntomember(Request $request){
	    if($request->isMethod('post'))
	    {

       $userassigned= UserAssignedBelt::where('userid',$request['userid'])->where('userbeltstatus','1')->get()->all();

       if($userassigned){
         return redirect()->back()->withErrors('Card Already Assigned to User');
       }
        $belt=AnyTimeAccessBelt::where('beltno',$request['finalbeltno'])->where('beltstatus','free')->get()->first();
        if(!$belt){
         return redirect()->back()->withErrors('Card Already Assigned to User');
       }
       $belt= AnyTimeAccessBelt::where('beltno',$request['finalbeltno'])->get()->first();
       $beltvalidity=$belt->validity;

       if($request['returndate'] > $beltvalidity){

          return redirect()->back()->withErrors("Card's validity is expired");
       }
	       UserAssignedBelt::create([

             'userbeltno' => $request['finalbeltno'],
             
              'returndate' => $request['returndate'],
              'userid'=>$request['userid'],
              'assigneddate'=>now(),
              'userrfidno' => $request['finalrfidno'],
              'userbeltstatus'=>'1',
         ]);
         $belt->beltstatus='used';
         $belt->lastassignuserid=$request['userid'];
         $belt->save();

          $action = new Actionlog();
          $action->user_id = session()->get('admin_id');
          $action->ip = $request->ip();
          $action->action_type = 'insert';
          $action->action = 'Assign Access Card';
          $action->save();

          $loginuser = session()->get('username');
          $actionbyid=Session::get('employeeid');

          $notify=Notify::create([
            'userid'=>session()->get('admin_id'),
            'details'=> ''.$loginuser.''.'assign'.''.'card'.''.'no'.' '.$request['finalbeltno'].''.'to'.''.$request['userid'],
            'actionby' =>$actionbyid,
        ]);
         
		   return redirect('atacardassigntomember')->with('message','Card is Assigned SuccessFully');
	    }
	    else
	    {
        $users= DB::table('users')->join('registration','registration.id','users.regid')->where('users.useractive',1)->get();
        $cards=AnyTimeAccessBelt::get()->all();

	    	return view('admin.anytimeaccess.atacardassigntomember',compact('users','cards'));
	    }
    
    }
    public function viewbeltdataajax(Request $request){

      $userassigned= UserAssignedBelt::leftjoin('anytimeaccessbelt','anytimeaccessbelt.beltno','userassignedbelt.userbeltno')->leftjoin('users','users.userid','userassignedbelt.userid')->where('userassignedbelt.userbeltno',$request->get('beltno'))->where('userbeltstatus','1')->get()->first();
      // dd($userassigned);
     echo json_encode($userassigned);
      
    }
    public function returnuserbelt(Request $request){
        $userid = $request['beltuserid'];
        $beltno = $request['userbeltno'];
        $return = UserAssignedBelt::where('userid',$userid)->where('userbeltno',$beltno)->where('userbeltstatus','1')->get()->first();

        $freebelt = AnyTimeAccessBelt::where('beltno',$beltno)->where('beltstatus','used')->get()->first();
         if(!$return){
           return redirect('atacardassigntomember')->withErrors('Something went Wrong');
         }
          if(!$freebelt){
           return redirect('atacardassigntomember')->withErrors('Something went Wrong');
         }

           $return->userbeltstatus='0';
           $return->save();
        
          $freebelt->beltstatus='free';
          $freebelt->save();

          $action = new Actionlog();
          $action->user_id = session()->get('admin_id');
          $action->ip = $request->ip();
          $action->action_type = 'update';
          $action->action = 'Return Access Card';
          $action->save();

         return redirect('atacardassigntomember')->with('message','Card is Returned SuccessFully');

    }


    public function Checkbeltname(){

      $beltname = $_REQUEST['beltname'];

      $ifexist = AnyTimeAccessBelt::where('beltno', $beltname)->first();
      if(!empty($ifexist)){
        return 201;
      }else{
        return 202;
      }



    }

    public function enrollanytimeaccesscard(Request $request){

      $beltno = $_REQUEST['beltno'];
      $finalcard = $_REQUEST['finalcard'];
      $validity_date = $_REQUEST['validity_date'];
      $sdate = explode('-', $validity_date);
      $portno_const = config('constants.port');
      $did = AnyTimeAccessBelt::orderBy('anytimeaccessbeltid','desc')->first();

        

        if ($did) {

          $deviceid = $did->deviceid + 1;
         
        }else{

          $deviceid = 10001;

        }

       
        $deviceinfo = DB::table('deviceinfo')
        ->where('devicetype','independent')
        ->where('portno', $portno_const)
        ->first();

        if(!empty($deviceinfo)){

          try{

           AnyTimeAccessBelt::create([
            'beltno' => $beltno,
            'validity' => date('Y-m-d', strtotime($validity_date)),
            'beltstatus'=>'free',
            'rfidcardno1'=> $finalcard,
            'deviceid' => $deviceid,
            'username' => 'Belt'.$deviceid,
          ]);

          $fusername = 'Belt'.$deviceid;

           $action = new Actionlog();
           $action->user_id = session()->get('admin_id');
           $action->ip = $request->ip();
           $action->action_type = 'insert';
           $action->action = 'Insert Belt InTo Device';
           $action->save();

           $url = 'http://'.$deviceinfo->ipaddress.'';

           $username = $deviceinfo->username;

           $password = $deviceinfo->password;

           $api_anytimeaccess = 'http://'.$deviceinfo->ipaddress.':'.$deviceinfo->portno.'/device.cgi/users?action=set&user-id='.$deviceid.'&name='.$fusername.'&ref-user-id='.$deviceid.'&user-active=1&validity-enable=1&validity-date-dd='.$sdate[2].'&validity-date-mm='.$sdate[1].'&validity-date-yyyy='.$sdate[0].'&card1='.$finalcard.'';

           $cronjob = new ApiCronJob();
           $cronjob->apiuserid = $deviceid;
           $cronjob->apitype = 'any time access';
           $cronjob->api = $api_anytimeaccess;
           $cronjob->response_code = '';
           $cronjob->status = 0;
           $cronjob->save();

           return 201;

          } catch(\Exception $e) {

            return 202;

          }

        }else{

          return 205;

        }



    }


}
