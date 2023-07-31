<?php
namespace App;


use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;

class exercisepdf
{ 
	protected $pdf;
    
    public function __construct() {
        $this->pdf = new Dompdf;
    }
     public function generate($request) {
     	$member=Member::where('memberid',$request->memid)->get()->first();
     	 $exe= MemberExercise::with('Workout','Exercise')->where('memberid',$request->memid)->orderBy('memberexercise.exerciseday', 'asc')->orderBy('memberexercise.memberexercisetime', 'asc')->where('status',1)->get()->all();
     	$exe1= MemberExercise::with('Workout','Exercise')->where('memberid',$request->memid)->where('status',1)->get()->first();
        // $memberdiet=MemberExercise::with('DietPlanname','MealMaster')->where('memberid',$request->memid)->where('status',1)->get()->all();
      	$workoutname='';
         if($exe1){
         	$workoutname =$exe1->Workout->workoutname;
         }
     // dd($exe);
     // dd($items);
      // exit;
      
          // dd($itemnames);
        // $dietitems=DietItem::whereIn('dietitemid',1)->get()->all();
           $admin_id = session()->get('admin_id');
          $taken_by = Admin::where('adminid', $admin_id)->get()->first();
      if(!empty($taken_by)){
        $emp_id = $taken_by->employeeid;
        $emp_data = Employee::where('employeeid', $emp_id)->first();
        
        if(!empty($emp_data)){
          $assignby = ucfirst($emp_data->first_name).' '.ucfirst($emp_data->last_name);

        }
      }
       
     	$data['firstname']=ucfirst($member->firstname);
     	$data['lastname']=ucfirst($member->lastname);
        $data['mobileno']=$member->mobileno;
        // $data['fromdate']=$fromdate;
        // $data['todate']=$todate;
        $data['workoutname']=$workoutname;

     $this->pdf->loadHtml(
        View::make('admin.exercise.exercisepdf')->with(['data'=>$data,'exe'=>$exe,'assignby'=>$assignby])->render());
    $this->pdf->render();
      
    $this->pdf->stream(''.$data['firstname'].' '.$data['lastname'].'.pdf');
}
}
