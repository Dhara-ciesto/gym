<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExerciseLevel;

use App\Exercise;

use Illuminate\Validation\Rule;


class ExerciseLevelcontroller extends Controller
{
     public function index(Request $request)
    {
            $exerciseleveldata = ExerciseLevel::get()->all();
          
            return view('admin.exercise.viewExerciseLevel',compact('exerciseleveldata'));
    }
     public function addExerciseLevel(Request $request)
    {   

              $method = $request->method();
              if ($request->isMethod('post')){
              $request->validate([
              'exerciselevel' => 'required|unique:exerciselevel,exerciselevel',
         
              ]);
     /*$usr = Exerciselevel::where('exerciselevelname', $request['exerciselevelname'])->get()->all();
   
    if($usr){
      return redirect()->back()->withErrors('Exercise Level Already exists');
    }*/
          ExerciseLevel::create([
              'exerciselevel' => $request['exerciselevel'],
       
          ]);
         return redirect('viewExerciseLevel')->with('message','Succesfully added');
        }

        return view('admin.exercise.addExerciseLevel');
       
    }
      public function editExerciseLevel($id, Request $request)
    {
       
      $method = $request->method();
       $exerciselevel=ExerciseLevel::findOrFail($id);
        if ($request->isMethod('post')){
         $request->validate([
              'exerciselevel' => ['required', Rule::unique('exerciselevel')->ignore($id, 'exerciselevelid')],
             
              ]);
            $exerciselevel->exerciselevel=$request->exerciselevel;
          
              $exerciselevel->save();
         return redirect('viewExerciseLevel')->with('message','Succesfully Edited');
        }
   
        return view('admin.exercise.editExerciseLevel',compact('exerciselevel'));
    }
}
