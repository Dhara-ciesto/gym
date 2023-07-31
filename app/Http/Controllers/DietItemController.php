<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\DietItem;

class DietItemController extends Controller
{
   public function index(Request $request)
    {
          $dietitems= DietItem::where('status',1)->get()->all();
          return view('admin.diet.viewDietitem',compact('dietitems')); 
    }
     public function addDietitem(Request $request)
    {
    	 $method = $request->method();
          if ($request->isMethod('post')){

            $request->validate([
              	'dietitem' => 'required|unique:dietitems,dietitem',
            ]);
	          $mealmaster =     DietItem::create([
	            'dietitem'=> $request['dietitem'],
	          ]);
            return redirect('viewDietitem')->withSuccess('Item Succesfilly Added');

          }

    	return view('admin.diet.addDietitem');
    }
     public function editDietitem($id,Request $request)
    {

    	  $dietitem=DietItem::findOrFail($id);

       $method = $request->method();
          if ($request->isMethod('post')){

          $request->validate([
              'dietitem' => ['required', Rule::unique('dietitems')->ignore($id, 'dietitemid')],
             
              ]);
            $dietitem->dietitem=$request->dietitem;
            $dietitem->save();
            return redirect('viewDietitem')->withSuccess('Item Succesfilly Edited');
          }

      return view('admin.diet.editDietitem',compact('dietitem'));
    }
}
