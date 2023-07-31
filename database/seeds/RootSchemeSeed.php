<?php

use Illuminate\Database\Seeder;
use App\RootScheme;

class RootSchemeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RootScheme::create([

        	'rootschemeid' => 1,
        	'rootschemename' => '',
        	'description' => '',
        	'status' => 1,



        ]);
    }
}
