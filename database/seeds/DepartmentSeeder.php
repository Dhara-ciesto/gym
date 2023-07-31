<?php

use Illuminate\Database\Seeder;
use App\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([

        	'name' => 'Department1'

        ]);
        Department::create([

        	'name' => 'Department2'

        ]);
        Department::create([

        	'name' => 'Department3'

        ]);
        Department::create([

        	'name' => 'Department4'

        ]);
        Department::create([

        	'name' => 'Department5'

        ]);
        Department::create([

        	'name' => 'Department6'

        ]);

    }
}
