<?php

namespace App;


use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;

class DietPdf
{ 
	protected $pdf;
    
    public function __construct() {
        $this->pdf = new Dompdf;
    }
     public function generate($request) {
     	$member=Member::where('memberid',$request->memid)->get()->first();

        $memberdiet=MemberDiet::with('DietPlanname','MealMaster')->orderBy('memberdiet.dietday', 'asc')->orderBy('memberdiet.diettime', 'desc')->where('memberid',$request->memid)->where('status',1)->get()->all();
        if(!$memberdiet){

        }
        $items=array();
        $itemnames=array();
        $fromdate='';
  $todate='';
$planname='';
          // dd($memberdiet);
     	foreach ($memberdiet as $key => $dietitem) {

           array_push($items, explode(',', $dietitem->dietitemid));
           $fromdate=$dietitem->fromdate;
             $todate=$dietitem->todate;
              $planname=$dietitem->DietPlanname->dietplanname;
        }
     // dd($items);
      // exit;
        foreach($items as $key1 =>$item){
         if(!empty($item)){
          $dd=  DietItem::whereIn('dietitemid',$item)->pluck('dietitem')->all();
       array_push($itemnames, $dd);
            // foreach ($item as $key2 => $value) {
            //    array_push($itemnames, $value);
            // }
            
         }

        }
        $admin_id = session()->get('admin_id');
        $taken_by = Admin::where('adminid', $admin_id)->get()->first();
      if(!empty($taken_by)){
        $emp_id = $taken_by->employeeid;
        $emp_data = Employee::where('employeeid', $emp_id)->first();
        
        if(!empty($emp_data)){
          $assignby = ucfirst($emp_data->first_name).' '.ucfirst($emp_data->last_name);

        }
      }
        
          // dd($itemnames);
        // $dietitems=DietItem::whereIn('dietitemid',1)->get()->all();
       
        $data['firstname']=ucfirst($member->firstname);
     	  $data['lastname']=ucfirst($member->lastname);
        $data['mobileno']=$member->mobileno;
        $data['fromdate']=$fromdate;
        $data['todate']=$todate;
        $data['planname']=$planname;

     $this->pdf->loadHtml(
        View::make('admin.dietpdf.dietpdf')->with(['data'=>$data,'memberdiet'=>$memberdiet,'itemnames'=>$itemnames,'assignby'=>$assignby])->render());
    $this->pdf->render();
      
    $this->pdf->stream(''.$data['firstname'].' '.$data['lastname'].'.pdf');
}
}
