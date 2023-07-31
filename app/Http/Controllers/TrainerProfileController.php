<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\TrainerProfile;
use App\Notify;
use App\Ptlevel;

class TrainerProfileController extends Controller
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
          	return redirect('viewtrainers')->withSuccess(['Successfully Added']);
    	 }
    	 else{
    	 	$trainer=Employee::where('roleid',4)->get()->all();
    	 	$levels=Ptlevel::get()->all();

    		return view('admin.Trainer.addtrainerprofile',compact('trainer','levels'));
    	 }
    	

    }
    public function viewtrainers(Request $request){
    	
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
		$data= TrainerProfile::select('trainerprofile.photo as trainerphoto','trainerprofile.*','employee.first_name','employee.last_name')->leftjoin('employee','employee.employeeid','trainerprofile.employeeid')->OrderBy('trainerprofileid','desc')->paginate(8);  	
    	return view('admin.Trainer.viewtrainers',compact('query','data'));
    }
    public function viewtrainerprofile(Request $request,$id){
    	$trainerprofile=TrainerProfile::leftjoin('employee','employee.employeeid','trainerprofile.employeeid')->where('trainerprofile.trainerprofileid',$id)->get(['trainerprofile.photo as trainerphoto','trainerprofile.city as trainercity','trainerprofile.*','employee.*'])->first();
    	 // dd($trainerprofile);
    	$timeline=Notify::where('userid',$trainerprofile)->get()->all();
    
    	return view('admin.Trainer.viewtrainerprofile',compact('trainerprofile','timeline'));
    }
    public function gettrainerdetail(Request $request){
    	$trainerdetail=Employee::leftjoin('ptassignlevel','ptassignlevel.trainerid','employee.employeeid')->where('employeeid',$request->trainerid)->get()->first();
    	$level=Ptlevel::where('id',$trainerdetail->levelid)->pluck('id')->first();
    	$trainerfromprofil=TrainerProfile::where('employeeid',$request->trainerid)->get()->first();
    	$trainerdetail['level']=$level;
    	if($trainerfromprofil){
	    	$trainerdetail['exp']=$trainerfromprofil->exp;
			$trainerdetail['achievments']=$trainerfromprofil->achievments;
			$trainerdetail['freeslot']=$trainerfromprofil->freeslots;
    	}
    	else{
    		$trainerdetail['nodata']='nodata';
    	}
      	return $trainerdetail;
    }
}
