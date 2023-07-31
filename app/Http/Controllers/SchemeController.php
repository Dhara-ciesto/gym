<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Scheme;
use App\RootScheme;
use App\Terms;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Excel;
use App\Company;
use Illuminate\Pagination\LengthAwarePaginator;
use App\AdminMaster;
use Carbon\Carbon;
use App\MemberPackages;
use Illuminate\Validation\Rule;
use App\SchemeRateChange_log;

class SchemeController extends Controller
{ 
  public function index(Request $request)
    {
       
    $rootschemename=$request->get('rootschemename');
    /*for pass to bladefile */
    $query=[];
    
    $query['rootschemename']=$rootschemename;
        $query['status']=$request->status; 

    
        $rootschemes=RootScheme::get()->all();



      if($request->isMethod('post'))
      { 

        $schemes=Scheme::select('schemes.*','rootschemes.*')->leftjoin('rootschemes','schemes.rootschemeid','rootschemes.rootschemeid');

       

        if($rootschemename != "")
        {

              $schemes->where('rootschemes.rootschemeid',$rootschemename);
  
          }
            
 if($query['status'] != ""){
                $schemes->where('schemes.status',$query['status']);
            }
                      $schemes=$schemes->paginate(1000)->appends('query');


                         return view('admin.schemes',compact('schemes','rootschemes','query'));

   }



       else
       {
                     $schemes = Scheme::with('Rootscheme')->get()->all();

      $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $itemCollection = collect($schemes);
            $perPage = 15;
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
            $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
            $paginatedItems->setPath($request->url());
            $schemes =  $paginatedItems;


                       
            return view('admin.schemes',compact('schemes','rootschemes','query'));
    }
  }
    public function check(Request $request)
    {
      $SchemeName=$request->get('SchemeName');
       $row=DB::table('schemes')->select('schemename')->where('validity','>=', Carbon::now())->where('status','1')->where('schemename','=',$SchemeName)->get();

      if(count($row)<=0)
      {
        echo 'unique';
      }
      else
      {
        echo 'not_unique';
      }
    }
     public function create(Request $request)
    {   
              $method = $request->method();

            if ($request->isMethod('post')){

        $request->validate([
          'RootSchemeId' => 'required',
          'SchemeName' => 'required',
          'NumberOfDays' => 'required',
          'ActualPrice' => 'required|min:1',
          'validity'=>'required',
            ]); 
             
      $usr = Scheme::where('schemename', $request['SchemeName'])->where('validity','>=', Carbon::now())->where('status','1')->where('baseprice',$request['BasePrice'])->get()->all();
    
    if($usr){
      return redirect()->back()->withErrors('Scheme Already exists!, Please Enter Differant Price');
    }


 
           $scheme = Scheme::create([     
            'rootschemeid'  => $request['RootSchemeId'],  
            'schemename'  => $request['SchemeName'],  
            'numberofdays' =>$request['NumberOfDays'],
            'baseprice'  => $request['BasePrice'],    
            'tax'  => $request['Tax'],   
            'actualprice'    => $request['ActualPrice'], 
            'workinghourfrom' => Carbon::parse($request['WorkingHourFrom']), 
            'workinghourto' =>Carbon::parse($request['WorkingHourTo']),    
            'status'  => '1',   
            'validity' => $request['validity'],
            'male'   => $request['Male'],
            'female' => $request['Female'],
             
        ]);
            $scheme->male = ($request['Male']) ? 1 :0;
            $scheme->female = ($request['Female']) ? 1 :0;
            $scheme->save();
            $schemes= Scheme::get()->all();
               $terms = Terms::get()->all();

            $SchemeName = $request['SchemeName'];

            return view('admin.assignterms', compact('SchemeName','schemes','terms'));
        // return redirect('addscheme')->with('message','Succesfully added');
        }
        $scheme= RootScheme::get()->all();
        $sgst = AdminMaster::where('title','sgst')->pluck('description')->first();
        $cgst = AdminMaster::where('title','cgst')->pluck('description')->first();
       
        $sgst = (int)$sgst;
         $cgst = (int)$cgst;
        return view('admin.addScheme',compact('scheme','sgst','cgst'));
       
    }
      public function  editscheme($id, Request $request)
  {

    $method = $request->method();
    $scheme=Scheme::findOrFail($id);

    $rootscheme=RootScheme::get()->all();

    if ($request->isMethod('post')){
      $request->validate([
        'RootSchemeId' => 'required',
        'SchemeName' => ['required', Rule::unique('schemes')->ignore($id,'schemeid')],
        'NumberOfDays' => 'required|min:0',
        'ActualPrice' => 'required|min:1'
      ]); 


  DB::beginTransaction();
    try {
      $scheme->rootschemeid=$request->RootSchemeId;
      $scheme->schemename=$request->SchemeName;
      $scheme->numberofdays=$request->NumberOfDays;
      $scheme->baseprice=$request->BasePrice;
      $scheme->tax=$request->Tax;
      $scheme->actualprice=$request->ActualPrice;
      $scheme->workinghourfrom=Carbon::parse($request->WorkingHourFrom);
      $scheme->workinghourto=Carbon::parse($request->WorkingHourTo);;
      $scheme->status=$request->status;
      $scheme->validity=$request->validity;

      $scheme->male = ($request->Male) ? 1 :0;
      $scheme->female = ($request->Female) ? 1 :0;
      $scheme->save();

      $schemelog = new SchemeRateChange_log();
      $schemelog->update_by = session()->get('admin_id');
      $schemelog->schemeid=$id;
      $schemelog->updateon = date('Y-m-d H:i:s');
      $schemelog->oldbaseprice = $request->oldbaseprice;
      $schemelog->oldactualprice = $request->oldactualprice;
      $schemelog->oldtax = $request->oldtax;
      $schemelog->newtax = $request->Tax;
      $schemelog->newbaseprice = $request->BasePrice;
      $schemelog->newactualprice = $request->ActualPrice;
      $schemelog->save();

  

   
      
            DB::commit();
        $success = true;
    return redirect('schemes')->with('message','Scheme is successfully Edited');

    } catch (\Exception $e) {
  /*************cache code**************************/
        $success = false;
        DB::rollback();

    }
  /*************if try code fails**************************/
    if ($success == false) { 
      return redirect('dashboard');
    }

     
    }

    return view('admin.editscheme', compact('scheme','rootscheme'));
  }
 //    public function  editscheme($id, Request $request)
 //    {
       
 //      $method = $request->method();
 //       $scheme=Scheme::findOrFail($id);
        
 //        $rootscheme=RootScheme::get()->all();
   
 //            if ($request->isMethod('post')){
 // $request->validate([
 //          'RootSchemeId' => 'required',
 //          'SchemeName' => 'required',
 //          'NumberOfDays' => 'required|min:0',
 //        'ActualPrice' => 'required|min:1'
 //            ]); 
 //            $scheme->rootschemeid=$request->RootSchemeId;
 //              $scheme->schemename=$request->SchemeName;
 //               $scheme->numberofdays=$request->NumberOfDays;
 //              $scheme->baseprice=$request->BasePrice;
 //               $scheme->tax=$request->Tax;
 //              $scheme->actualprice=$request->ActualPrice;
 //               $scheme->workinghourfrom=Carbon::parse($request->WorkingHourFrom);
 //              $scheme->workinghourto=Carbon::parse($request->WorkingHourTo);;
 //               $scheme->status=$request->status;
 //               $scheme->validity=$request->validity;
    
 //                 $scheme->male = ($request->Male) ? 1 :0;
 //            $scheme->female = ($request->Female) ? 1 :0;
 //            $scheme->save();
            
 //         return redirect('schemes')->with('message','Scheme is successfully Edited');
 //        }

 //        return view('admin.editscheme', compact('scheme','rootscheme'));
 //    }
     public function destroy($id)
    {
        $scheme=Scheme::findOrFail($id);
        $scheme->delete();
         return redirect()->back()->with('message','Succesfully deleted');
    }
    
}
