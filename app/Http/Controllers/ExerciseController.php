<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exercise;

class ExerciseController extends Controller
{

    public function index(Request $request)
    {
            $exercisedata = Exercise::get()->all();
          
            return view('admin.exercise.viewExercise',compact('exercisedata'));
    }
     public function addExercise(Request $request)
    {   

              $method = $request->method();
              if ($request->isMethod('post')){
             
              $request->validate([
              'exercisename' => 'required',
              'file' => ''
              ]);

     $usr = Exercise::where('exercisename', $request['exercisename'])->get()->all();
   
    if($usr){
      return redirect()->back()->withErrors('exercise Already exists');
    }
    	
       
             $photo = $request->file;
          
          Exercise::create([
              'exercisename' => $request['exercisename'],
              'videoname' => $photo,
       
          ]);
         return redirect('viewExercise')->with('message','Succesfully added');
        }

        return view('admin.exercise.addExercise');
       
    }

      public function editExercise($id, Request $request)
    {
       
      $method = $request->method();
       $exercise=Exercise::findOrFail($id);
        if ($request->isMethod('post')){
          //  $photo = $request->file;
         $request->validate([
              'exercisename' => 'required',
              'videoname' => ''
              ]);
           // $photo = $request->file;
            
            $exercise->exercisename=$request->exercisename;

            $exercise->videoname =$request->videoname;
 
              $exercise->save();
         return redirect('viewExercise')->with('message','Succesfully Edited');
        }
   
        return view('admin.exercise.editExercise',compact('exercise'));
    }
    
    

}
