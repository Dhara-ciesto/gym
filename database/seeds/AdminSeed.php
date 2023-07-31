<?php

use Illuminate\Database\Seeder;
use App\Admin;

class AdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([

        	'adminid' => 1,
        	'employeeid' => 1,
        	'name' => 'admin',
        	'role' => 'admin',
        	'address' => 'morbi',
        	'mobileno' => '9586944555',
        	'username' => 'admin',
        	'password' => '$2y$10$yZPC34boMMCxZ2TPQxKh.eeilxb4UiLdhq6V9XUs/DX4x9iXpAN1C',
        	'status' => 1
        	
        ]);
    }
}
