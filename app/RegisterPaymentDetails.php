<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Registration;
use DB;

class RegisterPaymentDetails extends Model
{
    protected $table='registration_payment_details';
    
    protected $fillable = [
    	
        'id', 'register_id','amout','receipt_no','payment_type',
    ];

     public static function insertregistrationpayment($request){

     	$registration_id = Registration::select('id')->get()->last();

       
                    $insert_registration_payment_details = [


                                'register_id'      => $registration_id->id,
                                'amount'           => $request->input('payment'),
                                'payment_type'     => 'cash',
                                'receipt_no'       => $registration_id->id,

                                ];        


        DB::table('registration_payment_details')->insert($insert_registration_payment_details);


     }

}
