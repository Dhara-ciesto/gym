<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RootScheme;
use Illuminate\Validation\Rule;

class RootSchemeController extends Controller
{
    public function index(Request $request)
    {
            $rootschemes = RootScheme::get()->all();
            return view('admin.AllRootScheme',compact('rootschemes'));
    }
    public function create(Request $request)
    {   

              $method = $request->method();
            if ($request->isMethod('post')){
            $request->validate([
    		'scheme_name' => 'required|unique:rootschemes,rootschemename',
    		'description' => 'max:255',
        	]);	

     $usr = RootScheme::where('rootschemename', $request['scheme_name'])->get()->all();
    
    if($usr){
      return redirect()->back()->withErrors('RootScheme Already exists');
    }
          RootScheme::create([
            'rootschemename' => $request['scheme_name'],
             'description' => $request['description'],
        ]);
         return redirect('rootschemes')->with('message','Root scheme is succesfully added');
        }
        return view('admin.addRootScheme');
       
    }
    public function  editrootscheme($id, Request $request)
    {
       
      $method = $request->method();
       $scheme=RootScheme::findOrFail($id);
            if ($request->isMethod('post')){
              $request->validate([
              'rootschemename' => ['required', Rule::unique('rootschemes')->ignore($id, 'rootschemeid')],
              'description' => 'max:255',
            ],
            ['rootschemename.unique' => 'Root scheme is already exists']); 
              
      
            $scheme->rootschemename=$request->rootschemename;
              $scheme->description=$request->description;
              $scheme->save();
         return redirect('rootschemes')->with('message','Root scheme is succesfully Edited');
        }
        return view('admin.editrootscheme',compact('scheme'));
    }
     public function destroy($id)
    {
        $scheme=RootScheme::findOrFail($id);
        $scheme->delete();
        return redirect()->back()->with('message','Root scheme is succesfully deleted');
    }
   
}
