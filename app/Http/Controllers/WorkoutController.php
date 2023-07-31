<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Workout;
use Illuminate\Validation\Rule;

class WorkoutController extends Controller
{
    public function index(Request $request)
    {
            $workout = Workout::get()->all();
          
            return view('admin.exercise.viewWorkout',compact('workout'));
    }
     public function addWorkout(Request $request)
    {   

              $method = $request->method();
              if ($request->isMethod('post')){
             
              $request->validate([
              'workoutname' => 'required|max:255|unique:workout,workoutname',
              
              ]);

     $usr = Workout::where('workoutname', $request['workoutname'])->get()->all();
   
    if($usr){
      return redirect()->back()->withErrors('exercise Already exists');
    }
    	
       
           
          
          Workout::create([
              'workoutname' => $request['workoutname'],
              
       
          ]);
         return redirect('viewWorkout')->with('message','Workout is succesfully added');
        }

        return view('admin.exercise.addWorkout');
       
    }

      public function editWorkout($id, Request $request)
    {
       
      $method = $request->method();
       $workout=Workout::findOrFail($id);
        if ($request->isMethod('post')){
         $request->validate([
              'workoutname' => ['required', Rule::unique('workout')->ignore($id, 'workoutid')],
              
              ]);
            $workout->workoutname=$request->workoutname;
          
              $workout->save();
         return redirect('viewWorkout')->with('message','Workout is succesfully Edited');
        }
   
        return view('admin.exercise.editWorkout',compact('workout'));
    }
}
