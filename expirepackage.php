use App\MemberPackages;
use Carbon\Carbon;

public function memberpackage()
    {
     $today=Carbon::today();
       $today = $today->toDateString();
       $enddate= DBMemberPackages::where('status',1)->get()->all();

       foreach ($enddate as $key => $enddate1) {

           if($enddate1->expiredate == $today){
            $enddate1->status=0;
            $enddate1->save();
           }
       }
    }