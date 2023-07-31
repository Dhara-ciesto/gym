<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExerciseLevel;
use App\MealMaster;
use App\DietItem;
use App\DietTags;
use App\DietNote;
use App\DietPlan;
use App\DietPlanname;
use DB;


class DietPlanController extends Controller
{
 public function planDiet(Request $request){

 	  if ($request->isMethod('post')){
      // dd($request);
     
 	  	    $exe= DietPlanname::where('dietplanname',$request['dietplanname'])->get()->all();
       if($exe){
      
        return redirect('planDiet')->with('message','Diet Plan Is Already Exits');

       }
       $dietplanname = DietPlanname::create([
       'dietplanname'=>$request['dietplanname'],
       ]);

      
          $tags=$request['exerciselevel'];
          $notes=$request['dietnotes'];

          $i=0;
          $count=0;
          for ($i=1; $i <=7 ; $i++) { 

            if($request['tab'.$i.'mycount']>0){
            

              $count=$request['tab'.$i.'mycount'];
               $tags=$request['exerciselevel'];
	
                // foreach ($tags as $j => $value) {
                                  
 				$commaSeparatedtags = implode(',', $tags); 
 				$commaSeparatednotes = implode(',', $notes); 
 				
              for ($k=1; $k <= $count; $k++) {

              	$items=$request['tab'.$i.'items'.$k.''];
              	$commaSeparateditems='';
              	if($items){
              		$commaSeparateditems =  implode(',', $items); 
              	}
              	
 				

                  if($request['tab'.$i.'mealname'.$k.'']){
             $dietplan =    DietPlan::create([
                   'dietplannameid' => $dietplanname->dietplannameid,
                   'compulsary'=>$request['tab'.$i.'iscompulsary'.$k.''] == 1 ? $request['tab'.$i.'iscompulsary'.$k.''] :0 ,
                     'tagsid' => $commaSeparatedtags ,
                       'notesid' => $commaSeparatednotes,
                      'dietday' => $i,
                      'mealid' => $request['tab'.$i.'mealname'.$k.''],
                      'diettime'=> $request['tab'.$i.'time'.$k.''],
                      'dietitemid'=> $commaSeparateditems,
                      'remark'=> $request['tab'.$i.'instruction'.$k.''],
                      'dayremarks'=> $request['daynote'.$i],
                  ]);

              }
              }

            
            }
          }

		          foreach ($tags as $j => $value) {
		        
					DietTags::create([
					'dietid'=>$dietplanname->dietplannameid,
					'tagid'=>$tags[$j],
					]);
		}
	}
 	$tags=ExerciseLevel::get()->all();

 	$meals=MealMaster::where('status',1)->get()->all();
 	$dietitems=DietItem::where('status',1)->get()->all();
 	$dietnotes=DietNote::where('status',1)->get()->all();
 	return view('admin.dietplan.dietPlan',compact('tags','meals','dietitems','dietnotes'));
 
 }
 public function viewDietplan(Request $request){
 		 

    if ($request->isMethod('post')){ 

       $old=  DietPlan::where('dietplannameid',$request['dietplanname'])->get()->all();
              foreach ($old as $key => $oldone) {
                 $oldone->delete();
              }
                $olddata = DietTags::where('dietid',$request['dietplanname'])->get()->all();
            foreach ($olddata as $key => $oldonedata) {
                 $oldonedata->delete();
              }
      
      
          $tags=$request['exerciselevel'];
          $notes=$request['dietnotes'];

          $i=0;
          $count=0;
          for ($i=1; $i <=7 ; $i++) { 

            if($request['tab'.$i.'mycount']>0){
            

              $count=$request['tab'.$i.'mycount'];
               $tags=$request['exerciselevel'];
  
                // foreach ($tags as $j => $value) {
                                  
        $commaSeparatedtags = implode(',', $tags); 
        $commaSeparatednotes = implode(',', $notes); 
        
              for ($k=1; $k <= $count; $k++) {

                $items=$request['tab'.$i.'items'.$k.''];
                $commaSeparateditems='';
                if($items){
                  $commaSeparateditems =  implode(',', $items); 
                }
                

                  if($request['tab'.$i.'mealname'.$k.'']){
              
             $dietplan =    DietPlan::create([
                   'dietplannameid' => $request['dietplanname'],
                   'compulsary'=>$request['tab'.$i.'iscompulsary'.$k.''] == 1 ? $request['tab'.$i.'iscompulsary'.$k.''] :0 ,
                     'tagsid' => $commaSeparatedtags ,
                       'notesid' =>$commaSeparatednotes,
                      'dietday' =>$i,
                      'mealid' =>$request['tab'.$i.'mealname'.$k.''],
                      'diettime'=>$request['tab'.$i.'time'.$k.''],
                      'dietitemid'=>$commaSeparateditems,
                      'remark'=>$request['tab'.$i.'instruction'.$k.''],

                  ]);

              }
              }

            
            }
          }

        
              foreach ($tags as $j => $value) {
            
          DietTags::create([
          'dietid'=>$request['dietplanname'],
          'tagid'=>$tags[$j],
          ]);
    }

    }
	$tags=ExerciseLevel::get()->all();
  $meals=MealMaster::where('status',1)->get()->all();
  $dietitems=DietItem::where('status',1)->get()->all();
  $dietnotes=DietNote::where('status',1)->get()->all();
  $dietplaname = DietPlanname::where('status',1)->get()->all();
  return view('admin.dietplan.viewDietPlan',compact('tags','meals','dietitems','dietnotes','dietplaname'));
 }
  public function dietload(Request $request){
      $dietplanname = $request->get('dietplanname');


  $exercise= DietPlan::where('dietplannameid',$dietplanname)->get()->all();

echo json_encode($exercise);

      
    }
        public function checkdietname(Request $request)
    {
      $dietname=$request->get('dietname');
       $row=DB::table('dietplanname')->select('dietplanname')->where('dietplanname','=',$dietname)->get()->all();

      if(count($row)<=0)
      {
        echo 'unique';
      }
      else
      {
        echo 'not_unique';
      }
    }
    
    public function dietplanpdf($id,Request $request){


  $request->memid=$id;
    $pdf = new \App\DietPdf;
    $pdf->generate($request);

    }

}
 