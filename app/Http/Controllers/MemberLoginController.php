<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use Session;
use App\User;

class MemberLoginController extends Controller
{
  public function memberlogin(Request $request)
  {


       if($request->isMethod('post'))
       {
       		$mobileno=$request['mobileno'];
       		$fitpin=$request['fitpin'];
       		$member=Member::where('mobileno',$mobileno)->get()->first();
       		$user=User::where('userid',$member->userid)->get()->first();
       		if($member->memberpin == $fitpin ){

       						 $username=$user->username;
       						 // dd($username);
       				 session(['username' => $username]);

       				 return redirect('memberdashboard/'.$member->userid); 
       			
       		}
       		else {
       			 $msg = 'Invalid Username or Password';
       			 return redirect()->back()->with('message',$msg);  
       		}

       }

  		return view('admin.memberlogin.memberlogin');
  }
  public function memberdashboard($userid){


  		return view('admin.memberlogin.memberdashboard');
  }
}
