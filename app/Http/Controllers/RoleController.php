<?php

namespace App\Http\Controllers;

use App\Role;
use App\Actionlog;
use DB;
use Flash;use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            $roles = Role::where('status',1)->get()->all();
            return view('admin.roles',compact('roles'));
    }
    
  public function deactiverole(Request $request,$id)
    {
            

        $memberdata=Role::where('roleid',$id)->get()->first();
        $memberdata->status=0;
        $memberdata->save();
        
                return redirect()->back()->withSuccess('Role Deactivated');

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
              $method = $request->method();
            if ($request->isMethod('post')){
                   
                    $request->validate([
                    'EmployeeRole' => 'required|max:255|unique:roles',
                    'description' => 'max:255',
                    ],
                    ['EmployeeRole.unique' => 'Role Name Already exists']
                );
                      $usr = Role::where('employeerole', $request['EmployeeRole'])->get()->all();

        if($usr){
        return redirect()->back()->withErrors('Role Already exists');
        }
        $permission = !empty($request['permission']) ? serialize($request['permission']) : '';
        Role::create([
            'employeerole' => $request['EmployeeRole'],
             'description' => $request['description'],
             'permission' => $permission,
                'portalaccess' => !empty($request['portal_access']) ? $request['portal_access'] : 0
        ]);

          $last_id = DB::getPdo()->lastInsertid();
          $action = new Actionlog();
          $action->user_id = session()->get('admin_id');
          $action->ip = $request->ip();
          $action->action_type = 'insert';
          $action->action = 'role';
          $action->action_on = $last_id;

          $action->save();
         return redirect('roles')->with('message','Role is Succesfully added');
        }
        return view('admin.addrole');
       
    }
        
    public function addrole()
    {
          
         return view('admin.role.addrole');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */

    public function editRole($id, Request $request)
    {
       
      $method = $request->method();
       $role=Role::findOrFail($id);
        $permission = !empty($request->permission) ? serialize($request->permission) : '';
        

            if ($request->isMethod('post')){
                $request->validate([
                    'EmployeeRole' => 'required',
                    'description' => 'max:255',
                    ]);

              $role->employeerole=$request->EmployeeRole;
              $role->description=$request->description;
              $role->permission=$permission;
               $role->portalaccess= !empty($request->portal_access) ? $request->portal_access : 0;

              $role->save();


          $action = new Actionlog();
          $action->user_id = session()->get('admin_id');
          $action->ip = $request->ip();
          $action->action_type = 'update';
          $action->action = 'role';
          $action->action_on = $id;
          $action->save();
               

         return redirect('roles')->with('message','Succesfully Edited');
        }
   
        return view('admin.editRole',compact('role'));
    }
    public function edit(Request $request, $id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role, $id)
    {
        $role=Role::findOrFail($id);
        
        $action = new Actionlog();
        $action->user_id = session()->get('admin_id');
        $action->ip = $request->ip();
        $action->action_type = 'delete';
        $action->action = 'role';
        $action->action_on = $id;
        $action->save();
        
        $role->delete();
         return redirect()->back()->with('message','Succesfully deleted');
    }
}
    //$request->merge([ 
   //      'fitnessgoals' => implode(',', (array) $request->get('fitnessgoals'))
   //   ]); 

            // $my_array2 = $request->all();

            // $my_array2['MemberId'] = $data->id;
                
            // Fitnessgoals::create(
            //     $my_array2
            // );