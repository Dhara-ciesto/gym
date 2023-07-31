<?php
namespace App;

// use Dompdf\Dompdf;
use App\PaymentType;
use App\Scheme;
use Illuminate\Support\Facades\View;
use PDF;
/**
 * 
 */
class Printconsentform 
{
	//   protected $pdf;
    // public function __construct() {
    //     $this->pdf = new Dompdf;
    // }
    public function generate12($request) {
      
    //    $this->pdf->loadHtml(
    //     View::make('admin.consentformprint')->with(['request'=>$request])->render());
    // $this->pdf->render();
    $pdf = PDF::loadView('admin.consentformprint',compact('request'));
  
    return $pdf->stream(''.$request->firstname.' '.$request->lastname.'.pdf');
// $request->name= ucfirst($request->firstname)." ".ucfirst($request->lastname);
//  $this->pdf->stream(''.$request->name.'_consentform.pdf');
     }
}
 