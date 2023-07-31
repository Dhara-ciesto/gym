<?php

use Illuminate\Database\Seeder;
use App\Deviceusers;

class DeviceUserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Deviceusers::create([

        	'deviceusersid' => 1,
        	'userid' => 1;
        	'deviceusername' => 'admin',
        	'role' => 0,
        	'expirydate' => '2030-01-01',
        	'serialnumber' => 0,
        	'status' => 'emp',
        	'isactive' => 1,
        ]);
    }
}
