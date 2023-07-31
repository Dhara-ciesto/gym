<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\TrainerProfile;
use App\Notify;
use App\Ptlevel;
use App\BookTrainer;
use App\Emailsetting;
use Illuminate\Support\Facades\Mail;
use App\Emailnotificationdetails;
use DB;
use App\Admin;
use App\Member;

class TrainerProfileControllerApp extends Controller
{
    public function addtrainerprofile(Request $request){
    	 if ($request->isMethod('post')){

    	 	
		  	 $request->validate([
              	'trainerid' => 'required',
              	'photo' => 'mimes:jpeg,bmp,png|max:4000',
    			'results.*' => 'mimes:jpeg,bmp,png|max:4000',
            ]);
		  	$trainerprofile=TrainerProfile::where('employeeid', $request['trainerid'])->get()->first();
		  	if($trainerprofile){
		  		$trainerprofile->leveloftrainer =  $request['level'];
		  		$trainerprofile->city = $request['city'];
		  		$trainerprofile->exp = $request['exp'];
		  		$trainerprofile->achievments = $request['achievments'];
		  		$trainerprofile->freeslots = implode(',', (array) $request->get('slots'));
		  		$trainerprofile->save();

		  	}else{
		  		
	    	 	$trainerprofile=TrainerProfile::create([

		            'employeeid' => $request['trainerid'],
		            'leveloftrainer' => $request['level'],
		            'city' => $request['city'],
		            'exp' => $request['exp'],
		            'achievments' => $request['achievments'],
	        		'freeslots' => implode(',', (array) $request->get('slots')),
		            'photo' => $request['photo'],
	    	 	]);
		  	}
    	 	if($request->hasfile('results'))
		    {
		      foreach($request->file('results') as $file)
		      {
		        $name=$file->getClientOriginalName();
		         $name= $request['trainerid'].'_'.$name;
		        $file->move(public_path().'/files/', $name);  
		        $data[] = $name;  
		      }
		
		      $trainerprofile->results=json_encode($data);
		 
		      $trainerprofile->save();
		    }
		    if($file = $request->file('photo')){

	           $file_name = $file->getClientOriginalName();
	           $file_size = $file->getClientSize();
	            $file_name= $request['trainerid'].'_'.$file_name;
	           $file->move(public_path().'/files/', $file_name);

	           $photo = $file_name;
	           $trainerprofile->photo= $photo;
	           $trainerprofile->save();
          	}
          	return redirect('viewtrainersApp')->withSuccess(['Successfully Added']);
    	 }
    	 else{
    	 	$trainer=Employee::where('roleid',4)->get()->all();
    	 	$levels=Ptlevel::get()->all();

    		return view('admin.Trainer.addtrainerprofile',compact('trainer','levels'));
    	 }
    	

    }
    public function viewtrainers(Request $request){
    	
		$mobileNo = request()->route("id");
		
		$isAvail = Member::select('mobileno')->where('mobileno',$mobileNo)->get()->first();
		
		if(!($isAvail)){return "Sorry for the inconvenience! Service is temporarily unavailable, please try again later";}
		
		
		$fdate =$request->get('fdate');
		$tdate =$request->get('tdate');
		$username=$request->get('username');
		$keyword =$request->get('keyword');
		/*for pass to bladefile */
		$query=[];
		$data = array( );
		$query['fdate']=$fdate;
		$query['tdate']=$tdate;
		$query['username']=$username;
		$query['keyword']= $keyword;  
		$data= TrainerProfile::select('trainerprofile.photo as trainerphoto','trainerprofile.*','employee.first_name','employee.last_name')->leftjoin('employee','employee.employeeid','trainerprofile.employeeid')->paginate(8);  	
    	return view('admin.Trainer.viewtrainersApp',compact('query','data'));
    }
    public function viewtrainerprofile(Request $request,$id){
    	$trainerprofile=TrainerProfile::leftjoin('employee','employee.employeeid','trainerprofile.employeeid')->where('trainerprofile.trainerprofileid',$id)->get(['trainerprofile.photo as trainerphoto','trainerprofile.city as trainercity','trainerprofile.*','employee.*'])->first();
    	 // dd($trainerprofile);
    	$timeline=Notify::where('userid',$trainerprofile)->get()->all();
    
    	return view('admin.Trainer.viewtrainerprofileApp',compact('trainerprofile','timeline'));
    }
    public function gettrainerdetail(Request $request){
    	$trainerdetail=Employee::leftjoin('ptassignlevel','ptassignlevel.trainerid','employee.employeeid')->where('employeeid',$request->trainerid)->get()->first();
    	$level=Ptlevel::where('id',$trainerdetail->levelid)->pluck('level')->first();
    	$trainerdetail['level']=$level;
      	return $trainerdetail;
	}
	public function BookTrainer(Request $request)
	{
		$slot = request()->slots;
		
		$BookTrainer = new BookTrainer();
		$BookTrainer->trainerprofileid = $request->trainerid;
		$BookTrainer->membermobileno = $request->mobileno;
		$BookTrainer->timingslot = json_encode($slot);
		$BookTrainer->save();
		$newresult='';
		$emailsetting =  Emailsetting::where('status',1)->first();
		$employeeid=TrainerProfile::where('trainerprofileid',$request->trainerid)->pluck('employeeid')->first();
		$trainername=Employee::where('employeeid',$employeeid)->pluck('username')->first();
	
		if($slot){

			$msg='';
			$admins=Employee::whereIn('role',['admin','Admin'])->pluck('email')->all();

				if ($emailsetting) {
					
					$msg.="<br> Today's booked slots for Trainer ".$trainername." : <br>";
					$slots=implode("<br>", $slot);
					$msg.=$slots;
					

					foreach ($admins as $key => $value) {
						$data = [
							'msg' => $msg,
							'mail'=> $value,
							'subject' => $emailsetting->hearder,
							'senderemail'=> $emailsetting->senderemailid,
						];
					//	Mail::send(['html' =>'admin.name'], ["data1"=>$data], function($message) use ($data){

					//			$message->from($data['senderemail'], 'Booking of Trainer');
					//			$message->to($data['mail']);
					//			$message->subject($data['subject']);
								

					//	});

						$action = new Emailnotificationdetails();
						$action->user_id = session()->get('admin_id');
						$action->mobileno = $request->mobileno;
						$action->message = $data['msg'];
						$action->emailform = $data['senderemail'];
						$action->emailto = $data['mail'];
						$action->subject = $data['subject'];
						$action->messagefor = 'Booking of Trainer';
						$action->save();
						echo $value;
				}
			}
		}
		return "Your request is sent to the GYM, well get back to you shortly";
	}
}
