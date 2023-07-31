<?php

use Illuminate\Database\Seeder;
use App\Employee;


class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create([

        	'roleid' => 1,
            'userid'=>1,
        	'first_name' => 'admin',
        	'last_name' => 'admin',
        	'username' => 'admin',
        	'role' => 'admin',
        	'email' => 'admin@gmail.com',
        	'address' => 'Kotecha Chowk',
        	'city' => 'Rajkot',
        	'department' => 'Department1',
        	'salary' => 60000,
        	'workinghourfrom1' => '06:00',
        	'workinghourto1' => '23:00',
        	'workinghourfrom2' => '06:00',
        	'workinghourto2' => '23:00',
        	'dob' => '2019-06-04',
        	'gender' => 'male',
        	'mobileno' => 1234567890,
        	'password' => 'admin',
        	'status' => 1

        ]);
    }
}
