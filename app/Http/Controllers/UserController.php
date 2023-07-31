<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Admin;
use DB;
use Hash;
use App\Employee;
use App\Deviceuser;
use App\Actionlog;
use App\Smssetting;
use Ixudra\Curl\Facades\Curl;
use App\Notificationmsgdetails;
use App\Emailsetting;
use Session;
use App\Notify;
use App\ApiCronJob;
use App\HRApiCronjob;
//use Image;

class UserController extends Controller
{
    public function index(Request $request)
    {

      
        $username=$request->get('username');

        $mobileno=$request->get('mobileno');
        $keyword =$request->get('keyword');
        $status =$request->get('status');
        $roleid =$request->get('roleid');
        $smsmale = '';
        $smsfemale = '';
        $query=[];
       
        $query['mobileno']=$mobileno;
        $query['username']=$username;
        $query['keyword']= $keyword;
        $query['status']= $status;
        $query['roleid']= $roleid;
         $users = Employee::leftjoin('roles', 'roles.roleid', '=', 'employee.roleid')
         ->leftjoin('deviceusers', 'employee.userid', '=', 'deviceusers.userid');
            if ($keyword != ""){
                $users->where ( 'employee.first_name', 'LIKE', '%' . $keyword . '%' )
                ->orWhere ( 'employee.email', 'LIKE', '%' . $keyword . '%' )
                ->orWhere ( 'employee.last_name', 'LIKE', '%' . $keyword . '%' )
                ->orWhere ( 'employee.department', 'LIKE', '%' . $keyword . '%' )
                ->orWhere ( 'employee.city', 'LIKE', '%' . $keyword . '%' );
            }
        
            if ($username != "") {
                     $users->where('employee.userid','=',$username);
             }
            if ($mobileno != "")
            {
                     $users->where('employee.userid','=',$mobileno);
            } 
            if ($status != "")
            {
                     $users->where('employee.status','=',$status);
            } 
            if ($roleid != "")
            {
                     $users->where('employee.roleid','=',$roleid);
            } 
            $users= $users->select('roles.*', 'employee.*', 
            'employee.status as emp_status','deviceusers.enroll')
            ->paginate(10);
            $roles  = Role::get()->all();
            $allusers  = Employee::get()->all();
            
        return view('admin.users', compact('users','allusers','query','roles'));
    }

  public function deactivateuser(Request $request,$id)
    {
            

        $memberdata=Employee::where('employeeid',$id)->get()->first();
        $memberdata->status=2;
        $memberdata->save();
        
                return redirect()->back()->withSuccess('User Deactivated');

    }
    public function create(Request $request)
    {

        $photo = '';

        $method = $request->method();
        $roles = Role::where('status','1')->get()->all();
        if ($request->isMethod('post'))
        {
            if ($file = $request->file('file'))
            {
                $file_name = $file->getClientOriginalName();
                $file_size = $file->getSize();

                $file_name = time() . '_' . $file_name;
                $filename = public_path('/images/' . $file_name);
                                
                if ($file_size > 5000000)
                {
                    /*$img = Image::make($request->file('file')
                        ->getRealPath())
                        ->fit(400, 300)
                        ->save($filename, 80);*/
          
                }
                else
                {
                  echo $file_size;
                    $file->move('images', $file_name);
            
                }
                $photo = $file_name;
            }
          
            $check = '';

            if ($request->hasFile('docs'))
            {
                $allowedfileExtension = ['pdf', 'jpg', 'png', 'docx'];
                $files = $request->file('docs');
                foreach ($files as $file)
                {
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $check = in_array($extension, $allowedfileExtension);
                    $filename = $filename . '_' . $request['username'];
                    $img_path = public_path('/files/' . $filename);

                    if (is_file($img_path))
                    {
                        return redirect()->back()
                            ->withErrors(['Same name image already exist']);
                    }
                }
            }

            $request->validate(['username' => 'required|min:3|max:255',
                'Role_id' => 'required',
                'email' => 'required|max:255',
                'password' => 'required|max:255|min:6',
                'gender' => 'required',
                'mobileno' => 'required|numeric',
                'first_name' => 'required',
                'last_name' => 'required',
                'department' => 'nullable|min:3|max:255',
                'accountNo' => 'nullable|min:3|max:255',
                'accountName' => 'nullable|min:3|max:255',
                'IFSCcode' => 'nullable|min:3|max:255',
                'BankName' => 'nullable|min:3|max:255',
                'BranchName' => 'nullable|min:3|max:255',
                'BranchCode' => 'nullable|min:3|max:255',
                'photo' => 'mimes:jpeg,jpg,png,gif|max:5000',
                'mobileno' => 'required|min:10',
                'salary' => 'nullable',
                'workinghour' => 'required',
                'docs.*' => 'max:5000', ]);

            $usr = Employee::where('username', $request['username'])->get()
                ->all();
            $existuser = User::where('usermobileno', $request['mobileno'])->orwhere('username', $request['username'])->get()
                ->all();

            if ($existuser)
            {
                return redirect('addUser')->withErrors('User Already Exists');
        }

            if ($usr)
            {
                return redirect()->back()
                    ->withErrors('User Already exists');
            }
            $role = lcfirst(Role::find($request['Role_id'])->employeerole);
            $password = Hash::make($request['password']);

            DB::beginTransaction();
            try
            {
                $employee = Employee::create(['username' => $request['username'], 'first_name' => $request['first_name'], 'last_name' => $request['last_name'], 'roleid' => $request['Role_id'], 'email' => $request['email'], 'address' => $request['add'], 'role' => $role, 'city' => $request['city'], 'department' => $request['department'], 'salary' => $request['salary'], 'workinghourfrom1' => $request['working_hour_from_1'], 'workinghourto1' => $request['working_hour_to_1'], 'workinghourfrom2' => $request['working_hour_from_2'], 'workinghourto2' => $request['working_hour_to_2'], 'workinghour' => $request['workinghour'], 'dob' => $request['dob'], 'gender' => $request['gender'], 'mobileno' => $request['mobileno'], 'password' => $request['password'], 'photo' => $photo, 'fitpin' => rand(1000, 9999) , 'accountno' => $request['accountNo'], 'accountname' => $request['accountName'], 'ifsccode' => $request['IFSCcode'], 'bankname' => $request['BankName'], 'branchname' => $request['BranchName'], 'branchcode' => $request['BranchCode'], ]);
                if ($check)
                {
                    foreach ($request->file('docs') as $file)
                    {
                        $name = $file->getClientOriginalName();
                        $name = $name . '_' . time(). '_' .$extension;
                        $file_size = $file->getSize();
                        /******************************** */
                        if ($file_size > 5000000)
                        {
                            /*$img = Image::make($file->getRealPath())
                                ->fit(400, 300)
                                ->save($filename, 80);*/
                            $data[] = $name;
                        }
                        else
                        {
                            $file->move(public_path() . '/files/', $name);
                            $data[] = $name;
                        }
                        /*********************************** */
                    }

                    $employee->files = json_encode($data);
                    $employee->save();
                }
                $user = new Admin();
                $user->employeeid = $employee->employeeid;
                $user->name = $request['username'];
                $user->username = $request['username'];
                $user->address = $request['add'];
                $user->role = $role;

                $user->password = $password;
                $user->mobileno = $request['mobileno'];
                $user->save();

                $deviceuser = User::create(['empid' => $employee->employeeid, 'username' => $request['username'], 'roleid' => $request['Role_id'], 'usermobileno' => $request['mobileno'], 'userpassword' => $request['password'], 'useremail' => $request['email'], 'useractive' => '1', 'userstatus' => 'emp']);

                $employee->userid = $deviceuser->userid;
                $employee->save();

                DB::commit();
                $success = true;
                return redirect('users')->with('message', 'Succesfully added');

            }
            catch(\Exception $e)
            {
                /*************cache code**************************/
                $success = false;
                DB::rollback();

            }
            /*************if try code fails**************************/
            if ($success == false)
            {
                return redirect('dashboard');
            }

        }
        return view('admin.addUser', compact('roles'));

    }
    public function check(Request $request)
    {
        $username = $request->get('username');
        $usermobileno = $request->get('mobileno');
        $row = DB::table('users')->select('username', 'usermobileno')
            ->where('username', '=', $username)->orwhere('usermobileno', '=', $usermobileno)->get();

        if (count($row) <= 0)
        {
            return 202;
        }
        else
        {
            return 201;
        }
    }
    public function edituser($id, Request $request)
    {
        $photo;

        $method = $request->method();
        // $role = new role();
        // $course=User::all()->with('role');
        $roles = Role::where('status','1')->get()->all(); // $phone = User::find($id)->role();
        $user = Employee::findOrFail($id);

        if ($request->isMethod('post'))
        {
          
            $request->validate([

            'first_name' => 'required',
             'last_name' => 'required', 
             'department' => 'nullable|min:3|max:255', 
             'accountNo' => 'nullable|min:3|max:255', 
             'accountName' => 'nullable|min:3|max:255', 
             'IFSCcode' => 'nullable|min:3|max:255', 
             'BankName' => 'nullable|min:3|max:255', 
             'BranchName' => 'nullable|min:3|max:255', 
             'BranchCode' => 'nullable|min:3|max:255', 
             'photo' => 'mimes:jpeg,jpg,png,gif|max:5000', 
             'mobileno' => 'required|min:10',
              'docs.*' =>  'max:5000', 
              'password' => 'nullable|max:255|min:6', 
             'salary' => 'nullable', 
             'workinghour' => 'required', ]);
         
            $role = lcfirst(Role::find($request['Role_id'])->employeerole);
            $check = '';
              
            if ($request->hasFile('docs'))
            {

                $allowedfileExtension = ['pdf', 'jpg','JPG', 'png', 'PNG','docx'];
                $files = $request->file('docs');
                foreach ($files as $file)
                {
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $check = in_array($extension, $allowedfileExtension);
                   
                }
            }
            
            if ($check == true)
            {
             
                // $items= Item::create($request->all());
                foreach ($request->file('docs') as $file)
                {
                    $name = $file->getClientOriginalName();  
                    $extension = $file->getClientOriginalExtension();
                    $file_size = $file->getClientSize();
                    $file_name = $name . '_' . time() . '_' .$extension;

                    /****************** */

                    $filename = public_path('/files/' . $file_name);
                    if ($file_size > 5000000)
                    {
                       /* $img = Image::make($file->getRealPath())
                            ->fit(400, 300)
                            ->save($filename, 80);
                        $data[] = $name;*/
                    }
                    else
                    {
                        $file->move(public_path() . '/files/', $file_name);
                        $data[] = $file_name;

                    }

                    /*********************** */

                }
                //  dd($data);
                // $user->files=json_encode($data);
                if(!empty($user->files)){
                    $my_var = json_decode($user->files, true);
                           // convert it to an array.
                           
                            if(count($my_var)>0){
                                $data = array_merge($data, $my_var);
                            }
                    }
              
                if(!empty($request->alldocs)){
                    $user->files = json_encode($data);
                    $user->save();
                }else{
                    $user->files='';
                    $user->save();
                }
                
            }
            
            // dd($request->alldocs[0]);
           

            if (!$request->photo)
            {
                $photo = old('photo', $user->photo);
            }
            if ($file = $request->file('file'))
            {
                $file_name = $file->getClientOriginalName();
                $file_size = $file->getClientSize();
                $file_name = time() . '_' . $file_name;
                $filename = public_path('/images/' . $file_name);
                if ($file_size > 5000000)
                {
                    $img = Image::make($request->file('file')
                        ->getRealPath())
                        ->fit(400, 300)
                        ->save($filename, 80);

                }
                else
                {
                    $file->move('images', $file_name);

                }
                $photo = $file_name;
            }

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->username = $request->username;
            $user->roleid = $request->Role_id;
            $user->email = $request->email;
            $user->address = $request->add;
            $user->city = $request->city;
            $user->role = $role;
            $user->department = $request->department;
            $user->salary = $request->salary;
            $user->workinghourfrom1 = $request->workinghourfrom1;
            $user->workinghourto1 = $request->workinghourto1;
            $user->workinghourfrom2 = $request->workinghourfrom2;
            $user->workinghourto2 = $request->workinghourto2;
            $user->status = $request->status;
            $user->dob = $request->dob;
            $user->workinghour = $request->workinghour;
            $user->dob = $request->dob;
            $user->gender = $request->gender;
            $user->mobileno = $request->mobileno;

            $user->accountno = $request->accountNo;
            $user->accountname = $request->accountName;
            $user->ifsccode = $request->IFSCcode;
            $user->bankname = $request->BankName;
            $user->branchname = $request->BranchName;
            $user->branchcode = $request->BranchCode;

            if (empty($request->password))
            {
                $user->password = $user->password;
            }
            else
            {
                $user->password = $request->password;
            }

            $password = Hash::make($request['password']);

            if (empty($request->password))
            {
                $admin_password = Hash::make($user->password);
            }
            else
            {
                $admin_password = Hash::make($request->password);
            }

            $user->photo = $photo;
            $user->save();

            $password = Hash::make($request->password);
            $auser = DB::table('admin')->where('employeeid', $user->employeeid)
                ->update(['username' => $request->username, 'name' => $request->username, 'address' => $request->add, 'role' => $role, 'password' => $admin_password, 'mobileno' => $request->mobileno, ]);

            $users = Employee::get()->all();
            return redirect('users')
                ->with('message', 'User Succesfully Edited', compact('users'));
        }

        return view('admin.editUser', compact('user', 'roles'));
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()
            ->back()
            ->with('message', 'Succesfully deleted');
    }
    public function deletedocs(Request $request)
    {
        // dd($request->get('file'));
        $file = $request->get('file');

        if (file_exists(public_path('files/' . $file)))
        {

            unlink(public_path('files/' . $file));
            echo '101';

        }
        else
        {

            echo 'File does not exists.';

        }
    }
    public function employeepinchange($id, Request $request)
    {

        $cn1 = $request->input('cn1');
        $cn2 = $request->input('cn2');
        $cn3 = $request->input('cn3');
        $cn4 = $request->input('cn4');

        $cns = $cn1 . $cn2 . $cn3 . $cn4;

        $change = Employee::findOrFail($id);
        $userid = $change->userid;
        $change->fitpin = $cns;
        $change->save();

        $email = $change->email;

        /**logs for pin change **/
        $last_id = $change->userid;
        $action = new Actionlog();
        $action->user_id = session()
            ->get('admin_id');
        $action->ip = $request->ip();
        $action->action_type = 'update';
        $action->action = 'Employee';
        $action->action_on = $last_id;
        $action->save();
        /**End logs for pin change **/

        $mobileno = $change->mobileno;
        $fname = $change->first_name;
        $lname = $change->last_name;
        $fname = ucfirst($fname);
        $lname = ucfirst($lname);

        $msgformemberpin = DB::table('messages')->where('messagesid', '16')
            ->get()
            ->first();
        $msgformemberpin = $msgformemberpin->message;
        $msgformemberpin = str_replace("[firstname]", $fname, $msgformemberpin);
        $msgformemberpin = str_replace("[lastname]", $lname, $msgformemberpin);
        $msgformemberpin = str_replace("[pin]", $cns, $msgformemberpin);
        $msgformemberpin2 = $msgformemberpin;
        $msgformemberpin = urlencode($msgformemberpin);

        $smssetting = Smssetting::where('status', 1)->where('smsonoff', 'Active')
            ->first();

        if ($smssetting)
        {

            $u = $smssetting->url;
            $url = str_replace('$mobileno', $mobileno, $u);
            $url = str_replace('$msg', $msgformemberpin, $url);

            $otpsend = Curl::to($url)->get();

            $action = new Notificationmsgdetails();
            $action->user_id = session()
                ->get('admin_id');
            $action->mobileno = $mobileno;
            $action->smsmsg = $msgformemberpin2;
            $action->smsrequestid = $otpsend;
            $action->subject = 'Member FitPin Change';
            $action->save();

        }

        $emailsetting = Emailsetting::where('status', 1)->first();

        if ($emailsetting)
        {

            $data = [
            //'data' => 'Rohit',
            'msg' => $msgformemberpin2, 'mail' => $email, 'subject' => $emailsetting->hearder, 'senderemail' => $emailsetting->senderemailid, ];

           // Mail::send('admin.name', ["data1" => $data], function ($message) use ($data)
            //{

              //  $message->from($data['senderemail'], 'Member Pin Change');
               // $message->to($data['mail']);
               // $message->subject($data['subject']);

            //});

            $action = new Emailnotificationdetails();
            $action->user_id = session()
                ->get('admin_id');
            $action->mobileno = $mobileno;
            $action->message = $msgformemberpin2;
            $action->emailform = $data['senderemail'];
            $action->emailto = $data['mail'];
            $action->subject = $data['subject'];
            $action->messagefor = 'Member Pin Change';
            $action->save();

        }

        // $msgformemberpinsend = Curl::to('http://vsms.vr4creativity.com/api/mt/SendSMS?user=feetness5b&password=five@feetb&senderid=FITFIV&channel=Trans&DCS=0&flashsms=0&number='.$mobileno.'&text='.$msgformemberpin.'&route=6')->get();
        // $nmdformemberpin = [
        // 'mobileno' => $mobileno,
        // 'smsmsg' => $msgformemberpin2,
        // 'mailmsg' => '0',
        // 'callnotes' => '0',
        // ];
        // DB::table('notoficationmsgdetails')->insert($nmdformemberpin);
        $loginusername = Session::get('username');
        $actionbyid = Session::get('employeeid');

        $notify = Notify::create(['userid' => $userid, 'details' => '' . $loginusername . ' changed Fit PIN', 'actionby' => $actionbyid,

        ]);
        return redirect()->back()
            ->with('successmsg', 'PIN changed Successfully');
    }
    function extendemployeeexpiry(Request $request)
    {
        $portno_const = config('constants.port');
        $day = explode('-', $request->date);
        $year = $day[0];
        $month = $day[1];
        $date = $day[2];

        $deviceinfo = DB::table('hr_deviceinfo')->where('devicetype', 'independent')
            ->where('portno', $portno_const)->first();

        $url = 'http://' . $deviceinfo->ipaddress . '';
        $username = $deviceinfo->username;
        $password = $deviceinfo->password;

        // dump($url);
        $member_api = 'http://' . $deviceinfo->ipaddress . ':' . $deviceinfo->portno . '/device.cgi/users?action=set&user-id=' . $request->employeeid . '&validity-enable=1&validity-date-dd=' . $date . '&validity-date-mm=' . $month . '&validity-date-yyyy=' . $year . '';

        $cronjob = new HRApiCronjob();
        $cronjob->apiuserid = $request->employeeid;
        $cronjob->apitype = 'Extend Employee Expiry';
        $cronjob->api = $member_api;
        $cronjob->response_code = null;
        $cronjob->status = 0;
        $cronjob->save();

        return 200;

    }
}

