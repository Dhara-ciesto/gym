<?php

use Illuminate\Database\Seeder;
use App\PaymentType;

class PaymentTypeSeeder extends Seeder

{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          PaymentType::create([

        	'paymenttypeid' => 1,
        	'paymenttype' => 'Cash',
        	'description' => 'Cash',
        	'status' => 1

        ]);
          
        PaymentType::create([

        	'paymenttypeid' => 2,
        	'paymenttype' => 'Card',
        	'description' => 'Card',
        	'status' => 1

        ]);

    }
}
