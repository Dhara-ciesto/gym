<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use Illuminate\Validation\Rule;


class CompanyController extends Controller
{
   
    public function index(Request $request)
    {
              $company = Company::orderBy('companyid','desc')->get()->all();

          
            return view('admin.company',compact('company'));
    }
     public function create(Request $request)
    {   

              $method = $request->method();
              if ($request->isMethod('post')){
              $request->validate([
              'companyName' => 'required|min:2|max:255|unique:company,companyname',
              'GstNo' => 'required|max:15',
              'contactPerson' => 'required|min:3|max:30',
              'add' => 'nullable|max:255'
              ],
              ['companyName.unique' => 'Company Already exists' ]
            );
     $usr = Company::where('companyname', $request['companyName'])->orwhere('gstno',$request['GstNo'])->get()->all();
   
    if($usr){
      return redirect()->back()->withErrors('Company Already exists');
    }
          Company::create([
              'companyname' => $request['companyName'],
              'gstno' => $request['GstNo'],
              'contactpersonname' => $request['contactPerson'],
              'contactpersonmobileno' => $request['contactNo'],
              'companyaddress' => $request['add'],
          ]);
         return redirect('company')->with('message','Company is succesfully added');
        }

        return view('admin.addCompany');
       
    }
     public function editcompany($id, Request $request)
    {
       
      $method = $request->method();
       $company=Company::findOrFail($id);
        if ($request->isMethod('post')){
        $request->validate([
        'companyName' => ['required', Rule::unique('company')->ignore($id, 'companyid')],
        'GstNo' => 'required|max:15',
        ]);
            $company->companyname=$request->companyName;
              $company->gstno=$request->GstNo;
              $company->contactpersonname=$request->contactPerson;
              $company->contactpersonmobileno=$request->contactNo;
               $company->companyaddress=$request->add;
              
              $company->save();
         return redirect('company')->with('message','Company is succesfully Edited');
        }
   
        return view('admin.editcompany',compact('company'));
    }
    
}
