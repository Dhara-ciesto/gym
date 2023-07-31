public function smssearch(Request $request){
       // echo "string";exit();
       $rootschemeid = $request->get('rootschemeid');
       $schemeid = $request->get('schemeid');
       $mstatus = $request->get('mstatus');
       $smsmale = $request->get('smsmale');
       $smsfemale = $request->get('smsfemale');
       $smstag = $request->get('smstag');
       $fdate = $request->get('fdate');
       $tdate = $request->get('tdate');
// DB::enableQueryLog();
       $mixmasala = DB::table('member')
               ->leftjoin('memberpackages','member.userid','=','memberpackages.userid')
               ->leftjoin('memberworkout','member.memberid','=','memberworkout.memberid')
               ->leftjoin('workouttags','memberworkout.workoutid','=','workouttags.workoutid')
               ->leftjoin('schemes','memberpackages.schemeid','=','schemes.schemeid')
               ->leftjoin('rootschemes','schemes.rootschemeid','=','rootschemes.rootschemeid')
               ->select('member.firstname','member.mobileno','member.email');
                // ->get()->all();
 // dd($mixmasala);exit;
       if($rootschemeid != ""){
                   $mixmasala->where('rootschemes.rootschemeid','=',$rootschemeid);
       }
       if($schemeid != ""){
                    $mixmasala->where('schemes.schemeid','=',$schemeid);
       }
       if ($fdate != "") {
                   $from = date($fdate);
                   //$to = date($to);
                   if (!empty($tdate)) {
                       $to = date($tdate);
                   }else{
                       $to = date('Y-m-d');
                   }
                   $mixmasala->whereBetween('member.created_at',[$from,$to]);
       }
       if ($tdate != "") {
                   $to = date($tdate);
                   if (!empty($fdate)) {
                       $from = date($fdate);
                   }else{
                       $from = date('Y-m-d');
                   }
                    $mixmasala->whereBetween('member.created_at',[$from,$to]);
       }
       if ($mstatus != "") {
                    $mixmasala->where('member.status',$mstatus);
       }
       if ($smstag != "") {
                    $mixmasala->where('workouttags.tagid',$smstag);
       }
            // dd($smsmale);
       if ($smsmale == "true") {
                    $mixmasala->where('member.gender','Male');
       }
       if ($smsfemale == "true") {
                    $mixmasala->orWhere('member.gender','Female');
       }
           // $mixmasala1->toSql();
        $mixmasala1 =  $mixmasala->get()->all();
         // dd(DB::getQueryLog());
       echo json_encode($mixmasala1);
        // dd($mixmasala1);
   }