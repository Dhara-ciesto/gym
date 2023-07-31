<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Excel;
use App\Company;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Validation\Rule;
use App\expensemaster;
use App\Admin;
use App\Employee;
use App\expensepayment;
use App\bankmaster;

use App\Passwordsettings;

use DB;

class PasswordsettingsController extends Controller
{
	 public function index(Request $request)
    {
          $viewpassword= passwordsettings::where('status','Active')->get()->all();

          
          return view('admin.passwordsettings.viewpassword',compact('viewpassword')); 
    }

     public function addpassword(Request $request)
    {
       $method = $request->method();
          if ($request->isMethod('post')){

            $request->validate([
                'excelpassword' => 'required|unique:passwordsettings,excelpassword',
            ]);
            $viewpassword =     passwordsettings::create([
              'excelpassword'=> $request['excelpassword'],
            ]);
            return redirect('viewpassword')->withSuccess('Password Succesfilly Added');

          }

      return view('admin.passwordsettings.addpassword');
    }


      public function editpassword($id,Request $request)
    { 

        $viewpassword=passwordsettings::findOrFail($id);

       $method = $request->method();
          if ($request->isMethod('post')){

          $request->validate([
              'excelpassword' => ['required', Rule::unique('passwordsettings')->ignore($id, 'passwordsettingsid')],
             
              ]);
            $viewpassword->excelpassword=$request->excelpassword;
            $viewpassword->save();
            return redirect('viewpassword')->withSuccess('Password Succesfilly Edited');
          }

      return view('admin.passwordsettings.editpassword',compact('viewpassword'));
    }
    public function checkexcelpwd(Request $request){
       $passwordget= $request->get('excelpassword');
        $passwordoriginal=passwordsettings::where('passwordsettingsid', 1)->pluck('excelpassword')->first();
        if($passwordoriginal==$passwordget)
        {
           return $chkpwd = 'true';
        }
        else
       {
         return $chkpwd = 'false';
       }
    }
}
