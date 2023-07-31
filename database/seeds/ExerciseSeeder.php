<?php

use Illuminate\Database\Seeder;
use App\Exercise;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Exercise::create([
        	'exercisename' => '',
        	'videoname' => ''
        ]);
    }
}
