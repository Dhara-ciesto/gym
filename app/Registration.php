<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use DB;


class Registration extends Model
{
    protected $table='registration';

    protected $fillable = [
        'id','firstname','lastname','dob','phone_no','email_id','credit_validity_day','timing','starting_date','due_date','ending_date','department_id','therapist_id','package_id','designation','regtypeid','gender',
    ];


    // store registration data

    public static function insertregistration($request){
        
         $last_user_id = DB::getPdo()->lastInsertId();

          if(empty($request->input('startingdate'))){
            $start_date = date('Y-m-d');
          } else {
            $start_date = $request->input('startingdate');
          }

          $current_day = date('w', strtotime($start_date));
          if($current_day == 5 || $current_day == 6){
            $expiry_date = date('Y-m-d',strtotime($request->input('startingdate')."+3 days"));
          } else {
            $expiry_date = date('Y-m-d',strtotime($request->input('startingdate')."+2 days"));
          }


    	$registration = [

    						//'id        ' => $request->input('idno'),	
    						'firstname' => $request->input('fname'),
                            'lastname' => $request->input('lname'),
    						'dob' =>  date("y-m-d H:i:s", strtotime($request->input('bdate'))),
    						'designation' => $request->input('designation'),
    						'phone_no' => $request->input('mobileno'),
    						'email_id' => $request->input('email'),
    						'credit_validity_day' => $request->input('validday'),
    						'timing' => $request->input('timing'),
                            'gender'=>$request->input('gender'),

    						'starting_date' => date('Y-m-d', strtotime($request->input('startingdate'))),
    						'due_date' => date("Y-m-d H:i:s", strtotime($request->input('duedate'))),
    						// 'ending_date' => $expiry_date,	
                            'ending_date' => date('Y-m-d', strtotime($request->input('end_date'))),
    						'department_id' => $request->input('department'),
    						'therapist_id' => $request->input('therapist'),
    						'package_id' => $request->input('package'),
    						'regtypeid'=>$request->input('regtypeid'),
                            'created_at'=>now(),
                              'updated_at'=>now(),
    						];
    	

    	 //print_r($registration);

    	DB::table('registration')->insert($registration);

    }

}
