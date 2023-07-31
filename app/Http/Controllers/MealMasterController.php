<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\MealMaster;

class MealMasterController extends Controller
{
	public function index(Request $request)
    {
          $meals= MealMaster::where('status',1)->get()->all();
          return view('admin.meal.viewMeal',compact('meals')); 
    }
     public function addMeal(Request $request)
    {
    	 $method = $request->method();
          if ($request->isMethod('post')){

            $request->validate([
              	'mealname' => 'required|unique:mealmaster,mealname',
            ]);
	          $mealmaster =     MealMaster::create([
	            'mealname'=> $request['mealname'],
	          ]);
            return redirect('viewMeal')->withSuccess('Meal Succesfilly Added');

          }

    	return view('admin.meal.addMeal');
    }
     public function editMeal($id,Request $request)
    {

    	  $meal=MealMaster::findOrFail($id);

       $method = $request->method();
          if ($request->isMethod('post')){

          $request->validate([
              'mealname' => ['required', Rule::unique('mealmaster')->ignore($id, 'mealmasterid')],
             
              ]);
            $meal->mealname=$request->mealname;
            $meal->save();
            return redirect('viewMeal')->withSuccess('Meal Succesfilly Edited');
          }

      return view('admin.meal.editMeal',compact('meal'));
    }
}
