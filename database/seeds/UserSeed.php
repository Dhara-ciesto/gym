<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	User::create([

    		'userid' => 1,
    		'empid' => 1,
    		'regid' => 0,
    		'memid' => 0,
    		'userexpirydate' => '2030-01-01',
    		'username' => 'admin',
    		'userpassword' => 'admin',
    		'usermobileno' => '',
    		'useremail' => 'admin@yopmail.com',
    		'userbranch1' => 0,
    		'userbranch2' => 0,
    		'useractive' => 1,
    		'userstatus' => 'emp'
    	]);
    }
}
