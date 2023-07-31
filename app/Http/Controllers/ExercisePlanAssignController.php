<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExerciseLevel;
use App\ExercisePlan;
use App\Exercise;
use App\Workout;
use App\Workouttag;
use App\MemberExercise;
use App\MemberWorkout;
use Session;
use App\Notify;
use App\Member;


class ExercisePlanAssignController extends Controller
{
    public function assignExercisetoMember(Request $request){
        $method = $request->method();
              if ($request->isMethod('post')){

                  $loginusername= Session::get('username');
                   $actionbyid=Session::get('employeeid');



                        $exe= MemberExercise::where('memberid',$request['member'])->get()->all();
                        if($exe){

                        foreach ($exe as $key => $value) {

                        $value->status='0';
                        $value->save();
                        }

                        }
                        $tags=$request['exerciselevel'];

                        $i=0;
                        $count=0;
                        for ($i=1; $i <=7 ; $i++) {

                        if($request['tab'.$i.'mycount']>0){


                        $count=$request['tab'.$i.'mycount'];
                        $tags=$request['exerciselevel'];

                        // foreach ($tags as $j => $value) {

                        $commaSeparated = implode(',', $tags);
                        for ($k=1; $k <= $count; $k++) {

                        if($request['tab'.$i.'exercisename'.$k.'']){

                        $exercise =    MemberExercise::create([
                        'memberid'=>$request['member'],
                        'packageid'=>$request['package'],
                        'workoutid' => $request['workout'],
                        'exerciselevel' => $commaSeparated,
                        'exerciseday' =>$i,
                        'assignday' =>$i,
                        'exerciseid' =>$request['tab'.$i.'exercisename'.$k.''],
                        'memberexercisetime'=>$request['tab'.$i.'time'.$k.''],
                        'memberexerciseset'=>$request['tab'.$i.'set'.$k.''],
                        'memberexerciseins'=>$request['tab'.$i.'instruction'.$k.''],
                        'memberexerciserep'=>$request['tab'.$i.'rep'.$k.''],
                        'header'=>$request['tab'.$i.'header'.$k.''],
                        'assignedby'=>$loginusername,
                        ]);

                        }
                        }


                        }
                        }
                        MemberWorkout::create([
                      'memberid'=>$request['member'],
                     'workoutid' => $request['workout'],
                        ]);
                       $wo= Workout::where('workoutid',$request['workout'])->get()->first();
                       $member=Member::where('memberid',$exercise->memberid)->get()->first();
                       $userid=$member->userid;
                        Notify::create([
                          'userid'=> $userid,
                           'details'=> ''.$loginusername.' has assign a workout '.$wo->workoutname,
                            'actionby' =>$actionbyid,

         ]);
return redirect('assignExercise')->withSuccess('Succesfully added');
              }

      return view('admin.exercise.assignexercise')->with('message','Succesfully added');
    }
    public function assignExercisewithMember(Request $request){

       $method = $request->method();
              if ($request->isMethod('post')){


          $tagsmember='';
          $tagsmember =  $request->tags;
          $member = $request->member;
                // print_r($value);
          if(!$tagsmember){
             return redirect('assignExercise')->withErrors(['Tags Not Exist!']);
          }
                // print_r($value);
          // dd($tagsmember);


          $associatetags ='';
          $associatetagsall='';
          if(Workouttag::whereIn('tagid',$tagsmember)->get()->all()){
             $associatetagsall =  Workouttag::whereIn('tagid',$tagsmember)->get()->all();

          }
           if(empty($associatetagsall)){
            return redirect('assignExercise')->withErrors(['Such Tag Not Associates with any Workout ']);
           }
           else{
            $associatetags=$associatetagsall;
           }
        // dd($associatetags);

        $workout1=null;

             foreach ($associatetags as $key => $value) {
                if($associatetags!=null){
                      $workout1[]=$value->workoutid;
                }

             }
         if($workout1===null){
             return redirect('assignExercise')->withErrors(['Selected tag is not associate with any workout']);

         }
        $member=$request->member;
         $package=$request->packageid;
         $tags=$request->tags;
        $tags=  ExerciseLevel::whereIn('exerciselevelid',$tags)->get()->all();
        $workout='';
        if(Workout::whereIn('workoutid',$workout1)->get()->all()){
            $workout= Workout::whereIn('workoutid',$workout1)->get()->all();
        }

       $memberdisplay=Member::where('memberid',$member)->get()->first();

     $exercise=Exercise::get()->all();

       return view('admin.exercise.assignExercisewithMember',compact('memberdisplay','member','package','tags','exercise','workout'));
    }
return redirect('assignExercise');
}

}



