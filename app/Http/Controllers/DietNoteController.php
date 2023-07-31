<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\DietNote;



class DietNoteController extends Controller
{
	public function index(Request $request)
    {
          $dietnotes= DietNote::where('status',1)->get()->all();
          return view('admin.dietnote.viewDietnote',compact('dietnotes')); 
    }
     public function addDietnote(Request $request)
    {
    	 $method = $request->method();
          if ($request->isMethod('post')){

            $request->validate([
              	'dietnote' => 'required|unique:dietnotes,dietnote',
              	
            ],
             ['dietnote.unique' => 'Diet Note already Exist']
        );
	          $mealmaster =     DietNote::create([
	            'dietnote'=> $request['dietnote'],
	          ]);

            return redirect('viewDietnote')->withSuccess('Note Succesfilly Added');

          }

    	return view('admin.dietnote.addDietnote');
    }
     public function editDietnote($id,Request $request)
    {

    	  $dietnote=DietNote::findOrFail($id);

       $method = $request->method();
          if ($request->isMethod('post')){

          $request->validate([
              'dietnote' => ['required', Rule::unique('dietnotes')->ignore($id, 'dietnoteid')]
              ],
               ['dietnote.unique' => 'Diet Note already Exist']
            
          );
            $dietnote->dietnote=$request->dietnote;
            $dietnote->save();
            return redirect('viewDietnote')->withSuccess('Note Succesfilly Edited');
          }

      return view('admin.dietnote.editDietnote',compact('dietnote'));
    }
}
