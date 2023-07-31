<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MemberDietPlan;
use App\ExerciseLevel;
use App\MealMaster;
use App\DietItem;
use App\DietTags;
use App\DietNote;
use App\DietPlan;
use App\DietPlanname;
use App\Member;
use App\MemberPackages;
use App\MemberDiet;
use Session;
use App\Notify;

class MemberDietPlanController extends Controller
{
   public function assigndiettomember(Request $request)
   {
   		// dd($request);
   		 $tags= ExerciseLevel::get()->all();
       $members= Member::where('status',1)->get()->all();
   		return view('admin.assigndiettomember.memberdiet',compact('members','tags'));
   }
     public function dietpackageload(Request $request){

        $memberid=$request->get('member');
		$member=Member::where('memberid',$memberid)->where('status',1)->get()->first();
		$userid=$member->userid;
       
        $packages = MemberPackages::with('Scheme')->where('userid',$userid)->where('status',1)->get()->all();

        echo json_encode($packages);
    }
        public function dietplanload(Request $request){
     
        $member=$request->get('member');
        $workout=null;
        if(MemberDietPlan::where('memberid',$member)->get()->all()){
            $workout=MemberDietPlan::where('memberid',$member)->with('DietPlanname')->get()->all();

        }

        echo json_encode($workout);

    }
    public function dietmemberload(Request $request){
      $plannameid=$request->get('plannameid');
      $memberid=$request->memberid;
    $workouthistory= MemberDiet::with('DietPlanname','MealMaster')->where('memberid',$memberid)->where('plannameid',$plannameid)->get()->all();
    // dd($workouthistory);
     echo json_encode($workouthistory);
    }

    public function memberdietassign(Request $request){
    	  $method = $request->method();
              if ($request->isMethod('post')){
                

          $tagsmember =  $request->tags;
          $member = $request->member;
                // print_r($value);
          // dd($tagsmember);
        
        
            $associatetags ='';
          $associatetagsall='';
          if(DietTags::whereIn('tagid',$tagsmember)->get()->all()){
             $associatetagsall =  DietTags::whereIn('tagid',$tagsmember)->get()->all();
          
          }
           if(empty($associatetagsall)){
            return redirect('assigndiettomember')->withErrors(['No any Tags Exist ']);
           }
           else{
            $associatetags=$associatetagsall;
           }
           
           // $associatetags=  DietTags::whereIn('tagid',$tagsmember)->get()->all();
        // dd($associatetags);

        $dietplan1=null;
        
             foreach ($associatetags as $key => $value) {
                if($associatetags!=null){
                      $dietplan1[]=$value->dietid;
                }
              
             }
         if($dietplan1===null){
             return redirect('assigndiettomember')->withErrors(['Selected tag is not associate with any DietPlan']);

         }
        $member=$request->member;
         $package=$request->packageid;
         $tags=$request->tags;
        $tags=  ExerciseLevel::whereIn('exerciselevelid',$tags)->get()->all();
        $dietplan='';
        if(DietPlanname::whereIn('dietplannameid',$dietplan1)->get()->all()){
            $dietplan= DietPlanname::whereIn('dietplannameid',$dietplan1)->get()->all();
        }
           
       $memberdisplay=Member::where('memberid',$member)->get()->first();
   
      $meals=MealMaster::where('status',1)->get()->all();
  $dietitems=DietItem::where('status',1)->get()->all();
  $dietnotes=DietNote::where('status',1)->get()->all();
  $dietplaname = DietPlanname::where('status',1)->get()->all();
     // $exercise=Exercise::get()->all();

       return view('admin.assigndiettomember.assigndietwithmember',compact('memberdisplay','member','package','tags','dietplan','dietnotes','meals','dietitems'));   
   		 }
	}
	 public function assigndietmember(Request $request){
  $method = $request->method();
              if ($request->isMethod('post')){
                // dd($request);
              $exe= MemberDiet::where('memberid',$request['member'])->get()->all();
                        if($exe){
                       
                        foreach ($exe as $key => $value) {
                         
                        $value->status='0';
                        $value->save();
                        }

                        }
                  $loginusername= Session::get('username');

          $tags=$request['exerciselevel'];
          $notes=$request['dietnotes'];

          $i=0;
          $count=0;
          $seq=1;
           if(is_int(MemberDiet::latest('dietsequence')->pluck('dietsequence')->first())){
           $s=MemberDiet::latest('dietsequence')->pluck('dietsequence')->first();
                    $seq=$s+1;      
                        }
                       
                       
          for ($i=1; $i <=7 ; $i++) { 

            if($request['tab'.$i.'mycount']>0){
            

              $count=$request['tab'.$i.'mycount'];
               $tags=$request['exerciselevel'];
  
                // foreach ($tags as $j => $value) {
                                  
        $commaSeparatedtags = implode(',', $tags); 
        $commaSeparatednotes = implode(',', $notes); 
        
              for ($k=1; $k <= $count; $k++) {

                $items=$request['tab'.$i.'items'.$k.''];
                $commaSeparateditems='';
                if($items){
                  $commaSeparateditems =  implode(',', $items); 
                }
                

                  if($request['tab'.$i.'mealname'.$k.'']){
              
             $dietplan =    MemberDiet::create([
             		'memberid' => $request['member'],
                   'plannameid' => $request['dietplanname'],
                   'compulsary'=>$request['tab'.$i.'iscompulsary'.$k.''] == 1 ? $request['tab'.$i.'iscompulsary'.$k.''] :0 ,
                     'tagsid' => $commaSeparatedtags ,
                       'notesid' =>$commaSeparatednotes,
                      'dietday' =>$i,
                      'mealid' =>$request['tab'.$i.'mealname'.$k.''],
                      'diettime'=>$request['tab'.$i.'time'.$k.''] != null ? $request['tab'.$i.'time'.$k.''] :0,
                      'dietitemid'=>$commaSeparateditems,
                      'remark'=>$request['tab'.$i.'instruction'.$k.''],
                       'dietsequence'=>$seq,
                       'fromdate'=>$request['fromdate'],
                        'todate'=>$request['todate'],
                  ]);

              }
              }

            
            }
          }
MemberDietPlan::create([
                      'memberid'=>$request['member'],
                     'plannameid' => $request['dietplanname'],
                     'fromdate'=>$request['fromdate'],
                     'todate'=>$request['todate'],
                        ]);
                       $wo= DietPlanname::where('dietplannameid',$request['dietplanname'])->get()->first();
                       $member=Member::where('memberid',$request['member'])->get()->first();
                       $userid=$member->userid;
                       $actionbyid=Session::get('employeeid');

                        Notify::create([
                          'userid'=> $userid,
                           'details'=> ''.$loginusername.' has assign a Diet Plan '.$wo->dietplanname,
                            'actionby' =>$actionbyid,
         ]);  
return redirect('assigndiettomember')->withSuccess('Succesfully added');
  }
}


}
