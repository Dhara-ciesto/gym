<?php

use Illuminate\Database\Seeder;
use App\Registrationpayment;

class RegistrationPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Registrationpayment::create([

        	'payment' => 500,
        	'status' => 1


        ]);
    }
}
