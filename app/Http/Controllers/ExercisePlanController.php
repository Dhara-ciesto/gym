<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exercise;
use App\ExerciseLevel;
use App\ExercisePlan;
use App\Member;
use App\MemberPackages;
use DB;
use App\Workout;
use App\Workouttag;
use App\MemberExercise;
use App\MemberWorkout;
use Session;
use App\Ptmember;

class ExercisePlanController extends Controller
{
    public function planExercise(Request $request)
    {
        $tags = ExerciseLevel::get()->all();
        $exercise = Exercise::get()->all();
        $workouts = WorkOut::get()->all();
        return view('admin.exercise.planExercise', compact('exercise', 'tags', 'workouts'));
    }
    public function addplan(Request $request)
    {


        $method = $request->method();
        if ($request->isMethod('post')) {

            $exe = Workout::where('workoutname', $request['workout'])->get()->all();
            if ($exe) {

                return redirect('addplan')->with('message', 'WorkOut Is Already Exits');
            }
            $workoutname = WorkOut::create([
                'workoutname' => $request['workout'],
            ]);
            $tags = $request['exerciselevel'];
            $i = 0;
            $count = 0;
            for ($i = 1; $i <= 7; $i++) {

                if ($request['tab' . $i . 'mycount'] > 0) {

                    $count = $request['tab' . $i . 'mycount'];
                    $tags = $request['exerciselevel'];

                    // foreach ($tags as $j => $value) {

                    $commaSeparated = implode(',', $tags);
                    for ($k = 1; $k <= $count; $k++) {
                        // dd($request['tab'.$i.'header'.$k.'']);
                        if ($request['tab' . $i . 'exercisename' . $k . '']) {
                            $exercise =  ExercisePlan::create([
                                'workoutid' => $workoutname->workoutid,
                                'exerciseplanlevel' => $commaSeparated,
                                'exerciseplanday' => $i,
                                'exerciseid' => $request['tab' . $i . 'exercisename' . $k . ''],
                                'exerciseplantime' => $request['tab' . $i . 'time' . $k . ''],
                                'exerciseplanset' => $request['tab' . $i . 'set' . $k . ''],
                                'exerciseplanins' => $request['tab' . $i . 'instruction' . $k . ''],
                                'exerciseplanlevelrep' => $request['tab' . $i . 'rep' . $k . ''],
                                'header' => 'sdfsd',
                            ]);
                        }
                    }
                }
            }
            foreach ($tags as $j => $value) {
                Workouttag::create([
                    'workoutid' => $workoutname->workoutid,
                    'tagid' => $tags[$j],
                ]);
            }
            return redirect('planExercise')->with('message', 'Succesfully added');
        }
        $tags = ExerciseLevel::get()->all();

        $exercise = Exercise::get()->all();
        $workouts = WorkOut::get()->all();

        return view('admin.exercise.planExercise', compact('exercise', 'tags', 'workouts'));
    }
    public function editplan(Request $request)
    {

        $method = $request->method();
        if ($request->isMethod('post')) {
            $old =  ExercisePlan::where('workoutid', $request['workout'])->get()->all();
            foreach ($old as $key => $oldone) {
                $oldone->delete();
            }


            $i = 0;
            $count = 0;
            for ($i = 1; $i <= 7; $i++) {

                if ($request['tab' . $i . 'mycount'] > 0) {


                    $count = $request['tab' . $i . 'mycount'];
                    $tags = $request['exerciselevel'];

                    // foreach ($tags as $j => $value) {
                    $commaSeparated = implode(',', $tags);

                    for ($k = 1; $k <= $count; $k++) {

                        if ($request['tab' . $i . 'exercisename' . $k . '']) {


                            ExercisePlan::create([
                                'workoutid' => $request['workout'],
                                'exerciseplanlevel' => $commaSeparated,
                                'exerciseplanday' => $i,
                                'exerciseid' => $request['tab' . $i . 'exercisename' . $k . ''],
                                'exerciseplantime' => $request['tab' . $i . 'time' . $k . ''],
                                'exerciseplanset' => $request['tab' . $i . 'set' . $k . ''],
                                'exerciseplanins' => $request['tab' . $i . 'instruction' . $k . ''],
                                'exerciseplanlevelrep' => $request['tab' . $i . 'rep' . $k . ''],
                                'header' => $request['tab' . $i . 'header' . $k . ''],
                            ]);
                        }
                    }
                }
            }
            foreach ($tags as $j => $value) {
                Workouttag::create([
                    'workoutid' => $request['workout'],
                    'tagid' => $tags[$j],
                ]);
            }
            return redirect('ExerciseplanView')->with('message', 'Succesfully Edited');
        }
        $tags = ExerciseLevel::get()->all();
        $exercise = Exercise::get()->all();
        $workout = ExercisePlan::all()->unique('workout');
        return redirect('ExerciseplanView')->with('exercise', 'tags', 'workout');
    }
    public function assignExercise(Request $request)
    {

        $method = $request->method();
        if ($request->isMethod('post')) {
        }

        $tags = ExerciseLevel::pluck('exerciselevelid')->all();

        $tagsassign = ExercisePlan::pluck('exerciseplanlevel')->all();
        $tags = ExerciseLevel::get()->all();
        if (Session::get('role') == 'trainer') {
            $members = [];
            $usersall = Ptmember::where('trainerid', Session::get('employeeid'))->leftjoin('member', 'member.memberid', 'ptmember.memberid')->groupBy('ptmember.memberid')->pluck('ptmember.memberid')->all();
            foreach ($usersall as $key => $value) {
                $val = Member::where('memberid', $value)->where('status', 1)->join('users', 'member.userid', '=', 'users.userid')->first();
                if ($val) {
                    array_push($members, $val);
                }
            }
        } else {
            $members = Member::where('status', 1)->get()->all();
        }
        return view('admin.exercise.assignexercise', compact('members', 'tags'));
    }
    public function packageload(Request $request)
    {
        $memberid = $request->get('member');

        $member = Member::where('memberid', $memberid)->get()->first();
        $userid = $member->userid;


        $packages = MemberPackages::with('Scheme')->where('userid', $userid)->where('status', 1)->get()->all();

        echo json_encode($packages);
    }
    public function ExerciseplanView(Request $request)
    {
        $tags = ExerciseLevel::get()->all();
        $exercise = Exercise::get()->all();
        $workout = ExercisePlan::get()->all();
        $workout = Workout::get()->all();

        return view('admin.exercise.viewExercisePlan', compact('exercise', 'tags', 'workout'));
    }
    public function exerciseload(Request $request)
    {
        $exerciseplan = $request->get('exerciseplan');
        $exerciseplanlevel = $request->get('exerciseplanlevel');

        // $exercise= ExercisePlan::where('workout',$exerciseplan)->get()->all();
        // $exercise = DB::select(DB::raw("SELECT * FROM exerciseplan GROUP BY exerciseplanlevel, workout,exerciseplanday"));

        // $exercise = DB::table('exerciseplan')
        //             ->select('exerciseplanlevel','workout','exerciseplanday')
        //             ->groupBy('exerciseplanlevel','workout','exerciseplanday')
        //             ->get()->all();
        // $exercise=  DB::select(DB::raw("select max(exerciseplanid) as exerciseplanid,exerciseplanday,exerciseplanlevel,workout FROM exerciseplan  GROUP BY exerciseplanlevel,exerciseplanday,workout"));
        // var_dump($exercise[0]->exerciseplanid);
        // $exerciseall=array();
        // foreach ($exercise as $key => $value) {
        //  array_push($exerciseall, $value->exerciseplanid);

        // }

        // $exercise= ExercisePlan::where('workout',$exerciseplan)->get()->all();
        // $count=count($exercise);
        // for ($i=0; $i < $count; $i++) {
        //   $ex1=DB::select(DB::raw("select * from exerciseplan where exerciseplanid = $exercise[$i]->exerciseplanid"));
        //  array_push($exerciseall, $ex1);
        // }
        // $ex1=DB::select(DB::raw("select * from exerciseplan where exerciseplanid = $ex->exerciseplanid"));
        // $ex=implode(",",$exerciseall);
        // print_r($ex);


        // $exercisefinal = DB::select(DB::raw("select * from exerciseplan where exerciseplanid In ($ex)"));
        // print_r($exercisefinal);
        DB::enableQueryLog();
        $exercise = ExercisePlan::where('workoutid', $exerciseplan)
        ->orderBy('exerciseplanday', 'desc')->get()->all();
        //  dd(DB::getqueryLog());
        echo json_encode($exercise);
    }
    public function checkworkout(Request $request)
    {
        $username = $request->get('workout');
        $row = DB::table('workout')->select('workoutname')->where('workoutname', '=', $username)->get()->all();

        if (count($row) <= 0) {
            echo 'unique';
        } else {
            echo 'not_unique';
        }
    }
    public function workoutload(Request $request)
    {

        $member = $request->get('member');
        $workout = null;
        if (MemberWorkout::where('memberid', $member)->get()->all()) {
            $workout = MemberWorkout::where('memberid', $member)->with('Workout')->get()->all();
        }
        echo json_encode($workout);
    }
    public function workoutmemberload(Request $request)
    {
        $workoutid = $request->get('workoutid');
        $memberid = $request->memberid;
        $workouthistory = MemberExercise::with('Workout', 'Exercise')->where('memberid', $memberid)->where('workoutid', $workoutid)->where('status', 1)->get()->all();
        // dd( $workouthistory);
        echo json_encode($workouthistory);
    }
    public function exercisepdf($id, Request $request)
    {

        $request->memid = $id;
        $pdf = new \App\exercisepdf;
        $pdf->generate($request);
    }
}
