<style type="text/css">
   @import url(https://fonts.googleapis.com/css?family=Montserrat);
   a {
    color: #131313;
}
</style>
<?php 
   include('..///config/database.php');
   ?>
<aside class="main-sidebar">
   @php $us = session('username');
   $photo ='';
   $user =   DB::table('employee')->where('username',$us)->get()->first();
   if(!empty($user)){
   if($user->photo){
   $photo = $user->photo;
   }else{
   $photo =  'default.png';
   }
   } else {
   $photo =  'default.png';
   }   
   @endphp
   <!-- sidebar: style can be found in sidebar.less -->
   <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
         <div class="pull-left image">
            <img src="{{ asset('images/'.$photo) }}" class="img-circle" alt="User Image" height="150px;" width="150px">
         </div>
         <div class="pull-left info" style="margin-top: -10px;">
            <p>Welcome<br>
               {{session('username')}}
            </p>
         </div>
      </div>
      <!-- search form -->
      <!--   {{-- <form action="#" method="get" class="sidebar-form">
         <div class="input-group">
           <input type="text" name="q" class="form-control" placeholder="Search...">
             <span class="input-group-btn">
               <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                 <i class="fa fa-search"></i>
               </button>
             </span>
           </div>
         </form> --}} -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree" >
      <li class="active treeview menu-open">
      <li>
         <a  href="{{ url('dashboard') }}">
         <i class="fa fa-dashboard"></i>
         <span>
         <b>Dashboard </b>
         </span>
         <span class="pull-right-container"></span>
         </a>
      </li>
      @php $menu ='admin' @endphp 
      <?php $permission = unserialize(session()->get('permission'));
         ?>
      {{-- HR Module Sidebar --}}
         @if(isset($permission["'hr_module'"]) || isset($permission["'hr_device'"]) )
            <li class="treeview">
               <a href="#" id="hrmodulemenuopen">
               <i class="fa fa-users"></i>
               <span>HR Module</span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu">
                  <li class="treeview">
                     <a href="#">

                     <i class="fa fa-hdd-o" ></i> <span>Device</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li class="treeview">
                           <a href="#"><i class="fa fa-shirtsinbulk"></i> Device
                           <span class="pull-right-container">
                           <i class="fa fa-angle-left pull-right"></i>
                           </span>
                           </a>
                           <ul class="treeview-menu">
                              <li><a href="{{ route('hr_adddevice') }}"><i class="fa fa-plus"></i> Add Device</a></li>
                              <li><a href="{{ route('hr_viewdevice') }}"><i class="fa fa-eye"></i> View Device</a></li>
                           </ul>
                        </li>
                        <li><a href="{{ route('enrolldevice') }}"><i class="fa fa-user-plus"></i> Enroll Employee</a></li>
                        <li><a href="{{ route('emplog') }}"><i class="fa fa-search"></i> Employee Log</a></li>
                     </ul>
                  </li>
                  <li class="treeview">
                     <a href="#">
                        <i class="fa fa-user"></i> <span>HR</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li class="treeview">
                           <a href="#"> <i class="fa fa-clock-o"></i> Working Days
                           <span class="pull-right-container">
                           <i class="fa fa-angle-left pull-right"></i>
                           </span>
                           </a>
                           <ul class="treeview-menu">
                              <li><a href="{{ route('workingdays') }}"><i class="fa fa-plus"></i> Add Working Days</a></li>
                              <li><a href="{{ route('viewworkingdays') }}"><i class="fa fa-eye"></i> View Working Days</a></li>
                           </ul>
                        </li>
                        <li class="treeview">
                           <a href="#">  <i class="fa fa-shirtsinbulk"></i> Leave
                           <span class="pull-right-container">
                           <i class="fa fa-angle-left pull-right"></i>
                           </span>
                           </a>
                           <ul class="treeview-menu">
                              <li><a href="{{ route('leave') }}"><i class="fa fa-plus"></i> Add Leave</a></li>
                              <li><a href="{{ route('viewleave') }}"><i class="fa fa-eye"></i> View Leave</a></li>
                           </ul>
                        </li>
                        <li class="treeview">
                           <a href="#">
                           <i class="fa fa-shirtsinbulk"></i>
                           <span>
                           Employee Leave
                           </span>
                           <span class="pull-right-container">
                           <i class="fa fa-angle-left pull-right"></i>
                           </span>
                           </a>
                           <ul class="treeview-menu">
                              <li>
                                 <a href="{{ route('employeeleave') }}">
                                 <i class="fa fa-plus"></i>Employee Leave
                                 </a>
                              </li>
                              <li>
                                 <a href="{{ route('viewemployeeleave') }}">
                                 <i class="fa fa-eye"></i>Employee Leave
                                 </a>
                              </li>
                           </ul>
                        </li>
                        <li class="treeview">
                           <a href="#"> <i class="fa fa-stack-exchange" ></i> Employee Loan
                           <span class="pull-right-container">
                           <i class="fa fa-angle-left pull-right"></i>
                           </span>
                           </a>
                           <ul class="treeview-menu">
                              <li><a href="{{ route('employeeaccount') }}"><i class="fa fa-plus"></i> Add Loan</a></li>
                              <li><a href="{{ route('viewemployeeaccount') }}"><i class="fa fa-eye"></i> View Loan</a></li>
                           </ul>
                        </li>
                        <li class="treeview">
                           <a href="#"><i class="fa fa-table"></i> Employee Log
                           <span class="pull-right-container">
                           <i class="fa fa-angle-left pull-right"></i>
                           </span>
                           </a>
                           <ul class="treeview-menu">
                              <li><a href="{{ route('employeelog') }}"><i class="fa fa-eye"></i> Employee Log</a></li>
                              <li><a href="{{ route('employeelogdaywise') }}"><i class="fa fa-eye"></i> Daywise Log </a></li>
                              <li><a href="{{ route('addemppunch') }}"><i class="fa fa-plus"></i> Add Punch</a></li>
                              <li><a href="{{ route('importpunch') }}"><i class="fa fa-eye"></i> Import Punch</a></li>
                           </ul>
                        </li>
                        <li class="treeview">
                           <a href="#"> <i class="fa fa-money"></i>&nbsp;&nbsp; Employee Salary
                           <span class="pull-right-container">
                           <i class="fa fa-angle-left pull-right"></i>
                           </span>
                           </a>
                           <ul class="treeview-menu">
                              <li><a href="{{ route('salary') }}"><i class="fa fa-plus"></i>Calculate Salary</a></li>
                              <li><a href="{{ route('viewsalary') }}"><i class="fa fa-eye"></i> View Salary</a></li>
                              <li><a href="{{ route('viewlockedsalary') }}"><i class="fa fa-eye"></i> View Locked Salary</a></li>
                           </ul>
                        </li>
                     </ul>
                  </li>
               </ul>
            </li>
         @endif
         {{--End HR Module Sidebar --}}
         @if(isset($permission["'add_registration'"]) || isset($permission["'view_registration'"]) )
      
         <li class="treeview">
         <a href="#" id="registrationmenuopen">
         <img src="{{ asset('images/icon/registration.jpg') }}" style="height: 14px; width: 14px;margin-left: -3px;">&nbsp;&nbsp;
         <span>
         <b>Registration</b>
         </span>
         <span class="pull-right-container">
         <i class="fa fa-angle-left pull-right"></i>
         </span>
         </a>
         <ul class="treeview-menu">
            @if(isset($permission["'add_registration'"]))
            <li>
               <a href="{{ url('registration#tologin') }}">
               <img src="{{ asset('images/icon/regform.png') }}" style="height: 18px; width: 18px;margin-left: -3px;">&nbsp;&nbsp;Registration Form
               </a>
            </li>
            @endif
            @if(isset($permission["'view_registration'"]))
            <li>
               <a href="{{url('registrationdetails')}}">
               <img src="{{ asset('images/icon/view.png') }}" style="height: 18px; width: 18px;margin-left: -3px;">&nbsp;&nbsp;View Registration
               </a>
            </li>
            <li>
               <a href="{{url('deletedregstration')}}">
               <img src="{{ asset('images/icon/delete.png') }}" style="height: 18px; width: 18px;margin-left: -3px;">&nbsp;&nbsp;Deleted Registration
               </a>
            </li>
            <li>
               <a href="{{ url('regpaymenttype') }}">
               <i class="fa fa-book"></i>
               <span>Registration Type</span>
               </a>
            </li>
            @endif
         </ul>
      </li>
      @endif
      @if(isset($permission["'memberform_all'"]) || isset($permission["'add_memberform'"]) || isset($permission["'view_memberform'"])) 
      <li class="treeview">
         <a href="#" id="memberformmenuopen">
         <img src="{{ asset('images/icon/regform.png') }}" style="height: 14px; width: 14px;margin-left: -3px;">&nbsp;&nbsp;
         <span>
         <b>Member Form</b>
         </span>
         <span class="pull-right-container">
         <i class="fa fa-angle-left pull-right"></i>
         </span>
         </a>
         <ul class="treeview-menu">
            <li><a href="{{ url('sendformtonumber') }}"><i class="fa fa-chevron-right"></i>Send Member Form</a></li>
            <li><a href="{{ url('viewrequests')}} "><i class="fa fa-eye"></i>Received Forms</a></li>
            <li><a href="{{ url('viewsentforms')}} "><i class="fa fa-eye"></i>Sent Member Forms</a></li>
         </ul>
      </li>
      @endif
      @if(isset($permission["'add_device_all'"]))
      <!-- ============================= Device ============================== -->
      <li class="treeview">
         <a href="#" id="devicemenuopen">
         <img src="{{ asset('images/icon/device.jpg') }}" style="height: 14px; width: 14px;margin-left: -3px;">&nbsp;&nbsp;
         <span>
         <b>Device</b>
         </span>
         <span class="pull-right-container">
         <i class="fa fa-angle-left pull-right"></i>
         </span>
         </a>
         <ul class="treeview-menu">
            <li>
               <a href="{{ url('enrolldevicecomman') }}">
               <img src="{{ asset('images/icon/regform.png') }}" style="height: 21px; width: 21px;margin-left: -3px;">&nbsp;&nbsp;
               <span>Assign Card</span>
               </a>
            </li>
            <li><a  href="{{ url('cardread') }}"><i class="fa fa-search"></i>Get Card Details</a></li>
            <li><a  href="{{ url('viewfetchlogs') }}"><i class="fa fa-file"></i>All device logs</a></li>
            <li><a  href="{{ url('devicestatus') }}"><i class="fa fa-dashboard"></i>Device Status</a></li>
            <li><a  href="{{ url('apilist') }}"><i class="fa fa-cog"></i>Device Operation</a></li>
            <li><a  href="{{ url('internetstatus') }}"><i class="fa fa-shirtsinbulk"></i>Device On/Off Status</a></li>
            @if(isset($permission["'add_device'"]))
            {{-- <li>
               <a  href="{{ url('adddevice') }}">
               <i class="fa fa-plus"></i>Add Device
               </a>
            </li> --}}
            @endif
            @if(isset($permission["'view_device'"]))
            <li>
               <a  href="{{ url('viewdevice') }}">
               <i class="fa fa-eye"></i>View Device
               </a>
            </li>
            @endif
         </ul>
      </li>
      @endif
      @php $menu ='admin' @endphp 
      <?php $permission = unserialize(session()->get('permission')); ?>
      @if(isset($permission["'add_role'"]) || isset($permission["'view_role'"]) || isset($permission["'add_employee'"]) || isset($permission["'view_role'"]) || isset($permission["'add_employee'"]) || isset($permission["'add_employee'"]) || isset($permission["'add_company'"]) || isset($permission["'view_company'"]) || isset($permission["'add_paymentType'"]) || isset($permission["'view_paymentType'"]) || isset($permission["'add_reason'"]) || isset($permission["'view_reason'"]) || isset($permission["'add_device'"]) || isset($permission["'view_device'"]) || isset($permission["'add_tax'"]) || isset($permission["'view_tax'"]))
      <li class="treeview" >
         <a href="#" id="adminmenuopen">
         <img src="{{ asset('images/icon/admin.png') }}" style="height: 18px; width: 18px;margin-left: -3px;">&nbsp;&nbsp;
         <span>Admin</span>
         <span class="pull-right-container">
         <i class="fa fa-angle-left pull-right"></i>
         </span>
         </a>
         <ul class="treeview-menu">
            @if(isset($permission["'add_role'"]) || isset($permission["'view_role'"]))
            <li class="treeview">
               <a href="#">
               <img src="{{ asset('images/icon/role.png') }}" style="height: 18px; width: 18px;margin-left: -3px;">&nbsp;&nbsp;
               <span>
               <b>Roles</b>
               </span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu ">
                  @if(isset($permission["'add_role'"]))
                  {{-- <li>
                     <a  href="{{ url('addrole') }}">
                     <i class="fa fa-plus"></i> Add Role
                     </a>
                  </li> --}}
                  @endif
                  @if(isset($permission["'view_role'"]))
                  <li>
                     <a href="{{ url('roles') }}">
                     <i class="fa fa-eye"></i> View Roles
                     </a>
                  </li>
                  @endif
               </ul>
            </li>
            @endif
            <!--    @if(isset($permission["'add_device'"]) || isset($permission["'view_device'"]))
               <li class="treeview">
                 <a href="#">
                   <i class="fa fa-dot-circle-o"></i>
                   <span><b>Device Details</b></span>
                   <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                   </span>
                 </a>
                 <ul class="treeview-menu ">
                   <li><a  href="{{ url('cardread') }}"><i class="fa fa-chevron-right"></i>Get Card Details</a></li>
                   <li><a  href="{{ url('viewfetchlogs') }}"><i class="fa fa-chevron-right"></i>All device logs</a></li>
                   <li><a  href="{{ url('devicestatus') }}"><i class="fa fa-chevron-right"></i>device Status</a></li>
                   
                 </ul>
               </li>
               @endif -->
            @if(isset($permission["'add_employee'"]) || isset($permission["'view_employee'"]))
            <li class="treeview">
               <a href="#" id="usersmenuopen">
               <i class="fa fa-users"></i>
               <span>
               <b>Users</b>
               </span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu">
                  @if(isset($permission["'add_employee'"]))
                  <li>
                     <a  href="{{ url('addUser') }}">
                     <i class="fa fa-plus"></i> Add User
                     </a>
                  </li>
                  @endif
                  @if(isset($permission["'view_employee'"]))
                  <li>
                     <a href="{{ url('users') }}">
                     <i class="fa fa-eye"></i>View Users
                     </a>
                  </li>
                  @endif
               </ul>
            </li>
            @endif
            @if(isset($permission["'add_company'"]) || isset($permission["'view_company'"]))
            <li class="treeview">
               <a href="#" id="companymenuopen">
               <i class="fa fa-bank"></i>&nbsp;
               <span>
               <b>Company</b>
               </span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu">
                  @if(isset($permission["'add_company'"]))
                  <li>
                     <a href="{{ url('addCompany') }}">
                     <i class="fa fa-plus"></i>Add Company
                     </a>
                  </li>
                  @endif
                  @if(isset($permission["'view_company'"]))
                  <li>
                     <a href="{{ url('company') }}">
                     <i class="fa fa-eye"></i>View Company
                     </a>
                  </li>
                  @endif
               </ul>
            </li>
            @endif
            @if(isset($permission["'add_paymentType'"]) || isset($permission["'view_paymentType'"]))
            <li class="treeview">
               <a href="#" id="paymenttypesmenuopen">
               <i class="fa fa-inr"></i>
               <span>
               <b>Payment Types</b>
               </span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu">
                  @if(isset($permission["'add_paymentType'"]))
                  <li>
                     <a href="{{ url('addpaymenttype') }}">
                     <i class="fa fa-plus"></i>
                     <span>Add Payment Type</span>
                     </a>
                  </li>
                  @endif
                  @if(isset($permission["'view_paymentType'"]))
                  <li>
                     <a href="{{ url('paymenttypes') }}">
                     <i class="fa fa-eye"></i>View Payment Type
                     </a>
                  </li>
                  @endif
               </ul>
            </li>
            @endif
            @if(isset($permission["'add_reason'"]) || isset($permission["'view_reason'"]))
            <li class="treeview">
               <a href="#" id="reasonmenuopen">
               <img src="{{ asset('images/icon/reason.png') }}" style="height: 14px; width: 14px;margin-left: -3px;">&nbsp;&nbsp;
               <span>
               <b>Reason</b>
               </span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu">
                  @if(isset($permission["'add_reason'"]))
                  <li>
                     <a  href="{{ url('addReason') }}">
                     <i class="fa fa-plus"></i> Add Reason
                     </a>
                  </li>
                  @endif
                  @if(isset($permission["'view_reason'"]))
                  <li>
                     <a href="{{ url('reasons') }}">
                     <i class="fa fa-eye"></i> View Reason
                     </a>
                  </li>
                  @endif
               </ul>
            </li>
            @endif
            @if(isset($permission["'add_tax'"]) || isset($permission["'view_tax'"]))
            <li class="treeview">
               <a href="#" id="settingsmenuopen">
               <i class="fa fa-cog"></i>
               <span>
               <b>Settings</b>
               </span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu">
                  @if(isset($permission["'add_tax'"]) || isset($permission["'view_tax'"]))
                  <li>
                     <a  href="{{ url('settings') }}">
                     <i class="fa fa-chevron-right"></i> Tax Settings
                     </a>
                  </li>
                  @endif
                  <!-- <li>
                     <a  href="{{ url('adddevice') }}">
                       <i class="fa fa-chevron-right"></i>Add Device
                     </a>
                     </li>
                     <li>
                     <a  href="{{ url('viewdevice') }}">
                       <i class="fa fa-chevron-right"></i>View Device
                     </a>
                     </li> -->
               </ul>
            </li>
            <li class="treeview">
               <a href="#" id="reportsmenuopen">
               <i class="fa fa-file"></i>
               <span>Reports</span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu">
                  <li>
                     <a  href="{{ url('expiredmemberreport') }}">
                     <i class="fa fa-users"></i>Expiration Report
                     </a>
                  </li>
                  <li>
                     <a  href="{{ url('memberreport') }}">
                     <i class="fa fa-user"></i> Member Report
                     </a>
                  </li>
                  <li>
                     <a  href="{{ url('activityreport') }}">
                     <i class="fa fa-list"></i> Activity Report
                     </a>
                  </li>
                  <li>
                     <a  href="{{ url('gstreport') }}">
                     <i class="fa fa-stack-exchange"></i>GST Report
                     </a>
                  </li>
                  <li>
                     <a  href="{{ url('paymentreport') }}">
                     <i class="fa fa-money"></i>Payment Report
                     </a>
                  </li>
                  <li>
                     <a  href="{{ url('sessionreportadmin') }}">
                     <i class="fa fa-clock-o"></i>Session Report
                     </a>
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-key"></i>
                     <span>
                     <b>Password</b>
                     </span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li>
                           <a  href="{{ url('addpassword') }}">
                           <i class="fa fa-plus"></i> Add Password
                           </a>
                        </li>
                        <li>
                           <a href="{{ url('viewpassword') }}">
                           <i class="fa fa-eye"></i> View Password
                           </a>
                        </li>
                     </ul>
                  </li>
               </ul>
            </li>
            @endif
         </ul>
      </li>
      @endif
      @if(isset($permission["'add_root_scheme'"]) || isset($permission["'view_root_scheme'"]) || isset($permission["'add_scheme'"]) || isset($permission["'view_scheme'"]) || isset($permission["'add_term'"]) || isset($permission["'view_term'"]))
      <li class="treeview">
         <a href="#" id="schememenuopen">
         <img src="{{ asset('images/icon/scheme.png') }}" style="height: 18px; width: 18px;margin-left: -3px;">&nbsp;&nbsp;
         <span>Scheme</span>
         <span class="pull-right-container">
         <i class="fa fa-angle-left pull-right"></i>
         </span>
         </a>
         <ul class="treeview-menu">
            @if(isset($permission["'add_root_scheme'"]) || isset($permission["'view_root_scheme'"]))
            <li class="treeview {{ $menu ==  'scheme-rootscheme' ? 'active' : ''  }}">
               <a href="#">
               <i class="fa fa-dashboard"></i>
               <span>
               <b>Root Scheme</b>
               </span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu">
                  @if(isset($permission["'add_root_scheme'"]))
                  <li>
                     <a  href="{{ url('addrootscheme') }}">
                     <i class="fa fa-plus"></i> Add Root Scheme
                     </a>
                  </li>
                  @endif
                  @if(isset($permission["'view_root_scheme'"]))
                  <li>
                     <a href="{{ url('rootschemes') }}">
                     <i class="fa fa-eye"></i> View Root Scheme
                     </a>
                  </li>
                  @endif
               </ul>
            </li>
            @endif
            @if(isset($permission["'add_scheme'"]) || isset($permission["'view_scheme'"]))
            <li class="treeview {{ $menu ==  'schemes' ? 'active' : ''  }}">
               <a href="#">
               <i class="fa fa-bookmark"></i>
               <span>
               <b>Schemes</b>
               </span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu margin">
                  @if(isset($permission["'add_scheme'"]))
                  <li>
                     <a href="{{ url('addscheme') }}">
                     <i class="fa fa-plus"></i>
                     <span> Add Scheme</span>
                     </a>
                  </li>
                  @endif
                  @if(isset($permission["'view_scheme'"]))
                  <li>
                     <a href="{{ url('schemes') }}">
                     <i class="fa fa-eye"></i> View Scheme
                     </a>
                  </li>
                  @endif
               </ul>
            </li>
            @endif
            @if(isset($permission["'add_term'"]) || isset($permission["'view_term'"]))
            <li class="treeview {{ $menu ==  'terms' ? 'active' : ''  }}">
               <a href="#">
               <i class="fa fa-book"></i>
               <span>
               <b>Terms</b>
               </span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu">
                  @if(isset($permission["'add_term'"]))
                  <li>
                     <a href="{{ url('addterms') }}">
                     <i class="fa fa-plus"></i>
                     <span> Add Terms</span>
                     </a>
                  </li>
                  @endif
                  @if(isset($permission["'view_term'"]))
                  <li>
                     <a href="{{ url('terms') }}">
                     <i class="fa fa-eye"></i> View Terms
                     </a>
                  </li>
                  @endif
                  @if(isset($permission["'view_term'"]))
                  <li>
                     <a href="{{ url('assignedterms') }}">
                     <i class="fa fa-book"></i> Manage Terms
                     </a>
                  </li>
                  @endif
               </ul>
            </li>
            @endif
         </ul>
      </li>
      @endif
      @if(isset($permission["'add_inquiry'"]) || isset($permission["'view_inquiry'"]) || isset($permission["'add_trial_form_all'"]))
      <li class="treeview {{ $menu ==  'inquiry' ? 'active' : ''  }}">
         <a href="#" id="inquirymenuopen">
         <i class="fa fa-files-o"></i>
         <span>Inquiry</span>
         <span class="pull-right-container">
         <i class="fa fa-angle-left pull-right"></i>
         </span>
         </a>
         <ul class="treeview-menu">
            @if(isset($permission["'add_inquiry'"]))
            <li>
               <a href="{{ url('addinquiry') }}">
               <i class="fa fa-plus"></i> Add Inquiry
               </a>
            </li>
            @endif
            @if(isset($permission["'view_inquiry'"]))
            <li>
               <a href="{{ url('inquiry') }}">
               <i class="fa fa-eye"></i>View Inquiry
               </a>
            </li>
            @endif
            @if(isset($permission["'view_inquiry'"]))
            <li>
               <a href="{{ url('viewclosedinquiry') }}">
               <i class="fa fa-eye"></i>Closed Inquiry
               </a>
            </li>
            @endif
            @if(isset($permission["'view_inquiry'"]))
            <li>
               <a href="{{ url('followup') }}">
               <img src="{{ asset('images/icon/manage.png') }}" style="height: 13px; width: 13px;margin-left: -3px;">&nbsp;&nbsp; Manage followup
               </a>
            </li>
            @endif
            @if(isset($permission["'add_trial_form'"]) || isset($permission["'view_trial_form'"]))
            <li>
               <a href="{{ url('viewtrialform') }}">
               <i class="fa fa-eye"></i>Trial Form Details</a>
            </li>
            @endif
         </ul>
      </li>
      @endif
      @if(isset($permission["'add_member'"]) || isset($permission["'view_member'"]) || isset($permission["'add_member_assessment'"]) || isset($permission["'add_assign_renewal'"]) || isset($permission["'add_freezemembership'"]) || isset($permission["'view_freezemembership'"]) || isset($permission["'add_package_upgrade'"]) || isset($permission["'view_package_upgrade'"]) || isset($permission["'transfer_membership'"]) || isset($permission["'view_transfer_membership'"]))
      <li class="treeview">
         <a href="#" id="membershipmenuopen">
         <i class="fa fa-users"></i>
         <span>Membership</span>
         <span class="pull-right-container">
         <i class="fa fa-angle-left pull-right"></i>
         </span>
         </a>
         <ul class="treeview-menu">
            @if(isset($permission["'add_member'"]) || isset($permission["'view_role'"]))
            <li class="treeview">
               <a href="#">
               <i class="fa fa-user"></i>
               <span>
               <b>Member</b>
               </span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu">
                  @if(isset($permission["'add_member'"]))
                  <li>
                     <a  href="{{ url('addMember') }}">
                     <i class="fa fa-plus"></i>Add Member
                     </a>
                  </li>
                  @endif
                  @if(isset($permission["'view_member'"]))
                  <li>
                     <a href="{{ url('members') }}">
                     <i class="fa fa-eye"></i>View Members
                     </a>
                  </li>
                  @endif
               </ul>
            </li>
            @endif
            @if(isset($permission["'add_assign_renewal'"]))
            <li>
               <a href="{{ url('assignPackageOrRenewalPackage') }}">
               <img src="{{ asset('images/icon/renewpackage.png') }}" style="height: 18px; width: 18px;margin-left: -3px;">&nbsp;&nbsp;
               <span>
               <b>Assign/Renewal Package</b>
               </span>
               </a>
            </li>
            @endif
            @if(isset($permission["'add_package_upgrade'"]) || isset($permission["'view_package_upgrade'"]))
            <li class="treeview">
               <a href="#">
               <img src="{{ asset('images/icon/upgrade.jpg') }}" style="height: 18px; width: 18px;margin-left: -3px;">&nbsp;&nbsp;
               <span>
               <b>Upgrade Package</b>
               </span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu">
                  @if(isset($permission["'add_package_upgrade'"]))
                  <li>
                     <a  href="{{ url('packageupgrade') }}">
                     <i class="fa fa-plus"></i>Upgrade Package
                     </a>
                  </li>
                  @endif
                  @if(isset($permission["'view_package_upgrade'"]))
                  <li>
                     <a href="{{ url('upgradepackagedetails') }}">
                     <i class="fa fa-eye"></i>Upgraded Package
                     </a>
                  </li>
                  @endif
               </ul>
            </li>
            @endif
            @if(isset($permission["'add_freezemembership'"]) || isset($permission["'view_freezemembership'"]))
            <li class="treeview">
               <a href="#">
               <img src="{{ asset('images/icon/freeze.png') }}" style="height: 18px; width: 18px;margin-left: -3px;">&nbsp;&nbsp;
               <span>
               <b>Freeze Membership</b>
               </span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu">
                  @if(isset($permission["'add_freezemembership'"]))
                  <li>
                     <a  href="{{ url('freezemembership') }}">
                     <i class="fa fa-plus"></i>Freeze Membership
                     </a>
                  </li>
                  @endif
                  @if(isset($permission["'view_freezemembership'"]))
                  <li>
                     <a href="{{ url('viewfreezemembeship') }}">
                     <i class="fa fa-eye"></i>Freezed Membership
                     </a>
                  </li>
                  @endif
               </ul>
            </li>
            @endif
            @if(isset($permission["'transfer_membership'"]) || isset($permission["'view_transfer_membership'"]))
            <li class="treeview">
               <a href="#">
               <img src="{{ asset('images/icon/upgrade.jpg') }}" style="height: 18px; width: 18px;margin-left: -3px;">&nbsp;&nbsp;
               <span>
               <b>Transfer Membership</b>
               </span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu">
                  @if(isset($permission["'transfer_membership'"]))
                  <li>
                     <a  href="{{ url('addtransfermembership') }}">
                     <i class="fa fa-plus"></i>Transfer Membership
                     </a>
                  </li>
                  @endif
                  @if(isset($permission["'view_transfer_membership'"]))
                  <li>
                     <a href="{{ url('viewtransfermembership') }}">
                     <i class="fa fa-eye"></i>Transfered Membership
                     </a>
                  </li>
                  @endif
               </ul>
            </li>
            @endif
            @if(isset($permission["'add_assign_renewal'"]))
            <li>
               <a href="{{ url('idpendingreport') }}">
               <i class="fa fa-eye"></i>
               <span>
               <b>Id Pending Report
               </span>
               </b>
               </a>
            </li>
            @endif
         </ul>
      </li>
      @endif
      @if(isset($permission["'add_pt_level'"]) || isset($permission["'add_assign_pt_level'"]) || isset($permission["'add_pt_time'"]) || isset($permission["'add_matp_level'"]) || isset($permission["'add_member_manage'"]) || isset($permission["'add_claim'"]))
      <li class="treeview">
         <a href="#" id="ptmenuopen">
         <img src="{{ asset('images/icon/pt.png') }}" style="height: 18px; width: 18px;margin-left: -3px;">&nbsp;&nbsp;
         <span>Personal Trainer</span>
         <span class="pull-right-container">
         <i class="fa fa-angle-left pull-right"></i>
         </span>
         </a>
         <ul class="treeview-menu">
            @if(isset($permission["'add_pt_level'"]))
            <li>
               <a href="{{route('addptlevel')}}">
               <i class="fa fa-plus"></i> Add PT Level
               </a>
            </li>
            @endif
            @if(isset($permission["'add_assign_pt_level'"]))
            <li>
               <a href="{{route('assignptlevel')}}">
               <i class="fa fa-user-plus"></i> Assign PT Level
               </a>
            </li>
            @endif
            @if(isset($permission["'add_pt_time'"]))
            <li>
               <a href="{{route('addpttime')}}">
               <i class="fa fa-plus"></i> Add PT Time
               </a>
            </li>
            @endif
            @if(isset($permission["'add_matp_level'"]))
            <li>
               <a href="{{route('assignmembertotrainer')}}">
               <i class="fa fa-user-plus"></i> Assign Member To PT
               </a>
            </li>
            @endif
            @if(isset($permission["'add_member_manage'"]))
            <li>
               <a href="{{route('manageassignedmember')}}">
               <i  class="fa fa-users"></i> Manage Member
               </a>
            </li>
            @endif
            @if(isset($permission["'add_claim'"]))
            <li>
               <a href="{{route('claimptsession')}}">
             <i class="fa fa-user"></i> Claim Member
               </a>
            </li>
            @endif
            <li><a href="{{route('sessionreport')}}"><i class="fa fa-list"></i> Session Report</a></li>
         </ul>
      </li>
      @endif
      @if(isset($permission["'add_exercise'"]) || isset($permission["'view_exercise'"]) || isset($permission["'add_exercise_tags'"]) || isset($permission["'view_exercise_tags'"]) || isset($permission["'add_planworkout'"]) || isset($permission["'view_planview'"]) || isset($permission["'view_assign_workout'"]))
      <li class="treeview">
         <a href="#" id="workoutmenuopen">
         <img src="{{ asset('images/icon/exercise.png') }}" style="height: 18px; width: 18px;margin-left: -3px;">&nbsp;&nbsp;
         <span>Workout </span>
         <span class="pull-right-container">
         <i class="fa fa-angle-left pull-right"></i>
         </span>
         </a>
         <ul class="treeview-menu">
            @if(isset($permission["'add_exercise'"]) || isset($permission["'view_exercise'"]))
            <li class="treeview">
               <a href="#">
               <img src="{{ asset('images/icon/workoutmaster.png') }}" style="height: 18px; width: 18px;margin-left: -3px;">&nbsp;&nbsp;
               <span>
               <b>Workout Master</b>
               </span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu">
                  @if(isset($permission["'add_exercise'"]))
                  <li>
                     <a href="{{ url('addExercise') }}">
                     <i class="fa fa-plus"></i>Add Workout
                     </a>
                  </li>
                  @endif
                  @if(isset($permission["'view_exercise'"]))
                  <li>
                     <a href="{{ url('viewExercise') }}">
                     <i class="fa fa-eye"></i>View Workout
                     </a>
                  </li>
                  @endif
               </ul>
            </li>
            @endif
            @if(isset($permission["'add_planworkout'"]) || isset($permission["'view_planview'"]) || isset($permission["'view_assign_workout'"]) )
            <li class="treeview">
               <a href="#">
               <img src="{{ asset('images/icon/exerciseworkout.png') }}" style="height: 18px; width: 18px;margin-left: -3px;">&nbsp;&nbsp;
               <span>
               <b>Exercise Workout </b>
               </span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu">
                  @if(isset($permission["'add_planworkout'"]))
                  <li>
                     <a href="{{ url('planExercise') }}">
                     <i class="fa fa-plus"></i>Plan Workout
                     </a>
                  </li>
                  @endif
                  @if(isset($permission["'view_planview'"]))
                  <li>
                     <a href="{{ url('ExerciseplanView') }}">
                     <i class="fa fa-eye"></i>Workout view
                     </a>
                  </li>
                  @endif
                  @if(isset($permission["'view_assign_workout'"]))
                  <li>
                     <a href="{{ url('assignExercise') }}">
                     <i class="fa fa-table"></i>Assign Workout
                     </a>
                  </li>
                  @endif
               </ul>
            </li>
            @endif
         </ul>
      </li>
      @endif
      @if(isset($permission["'add_measurement'"]) || isset($permission["'view_measurement'"]))
      <li class="treeview">
         <a href="#" id="measurementmenuopen">
         <img src="{{ asset('images/icon/measurement.jpg') }}" style="height: 18px; width: 18px;margin-left: -3px;">&nbsp;&nbsp;
         <span>
         <b>Measurement</b>
         </span>
         <span class="pull-right-container">
         <i class="fa fa-angle-left pull-right"></i>
         </span>
         </a>
         <ul class="treeview-menu">
            @if(isset($permission["'add_measurement'"]))
            <li>
               <a href="{{ url('addMeasurement') }}">
               <i class="fa fa-plus"></i>Add Measurment
               </a>
            </li>
            @endif
            @if(isset($permission["'view_measurement'"]))
            <li>
               <a href="{{ url('viewMeasurement') }}">
               <i class="fa fa-eye"></i>View Measurment
               </a>
            </li>
            @endif
         </ul>
         @if(isset($permission["'add_diet_plan'"]) || isset($permission["'view_diet_plan'"]))
      <li class="treeview" >
         <a href="#" id="dietmenuopen">
         <i class="fa fa-cutlery"></i>
         <span>Diet Plan</span>
         <span class="pull-right-container">
         <i class="fa fa-angle-left pull-right"></i>
         </span>
         </a>
         <ul class="treeview-menu">
            <li class="treeview">
               <a href="#">
               <img src="{{ asset('images/icon/dietmeal.png') }}" style="height: 18px; width: 18px;margin-left: -3px;">&nbsp;&nbsp;
               <span>
               <b>Diet Meal</b>
               </span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu ">
                  <li>
                     <a href="{{ url('addMeal') }}">
                     <i class="fa fa-plus"></i>Add Meal
                     </a>
                  </li>
                  <li>
                     <a href="{{ url('viewMeal') }}">
                     <i class="fa fa-eye"></i>View Meal
                     </a>
                  </li>
               </ul>
            </li>
            <li class="treeview">
               <a href="#">
               <img src="{{ asset('images/icon/dietitem.png') }}" style="height: 18px; width: 18px;margin-left: -3px;">&nbsp;&nbsp;
               <span>
               <b>Diet Items</b>
               </span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu ">
                  <li>
                     <a href="{{ url('addDietitem') }}">
                     <i class="fa fa-plus"></i>Add Item
                     </a>
                  </li>
                  <li>
                     <a href="{{ url('viewDietitem') }}">
                     <i class="fa fa-eye"></i>View Items
                     </a>
                  </li>
               </ul>
            </li>
            <li class="treeview">
               <a href="#">
               <img src="{{ asset('images/icon/dietno.png') }}" style="height: 18px; width: 18px;margin-left: -3px;">&nbsp;&nbsp;
               <span>
               <b>Diet Notes</b>
               </span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu ">
                  <li>
                     <a href="{{ url('addDietnote') }}">
                     <i class="fa fa-plus"></i>Add Note
                     </a>
                  </li>
                  <li>
                     <a href="{{ url('viewDietnote') }}">
                     <i class="fa fa-eye"></i>View Notes
                     </a>
                  </li>
               </ul>
            </li>
            <li class="treeview">
               <a href="#">
               <img src="{{ asset('images/icon/dietnote.png') }}" style="height: 18px; width: 18px;margin-left: -3px;">&nbsp;&nbsp;
               <span>
               <b>Diet Plan</b>
               </span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu">
                  @if(isset($permission["'add_diet_plan'"]))
                  <li>
                     <a href="{{ url('planDiet') }}">
                     <i class="fa fa-plus"></i>Plan Diet
                     </a>
                  </li>
                  @endif
                  @if(isset($permission["'view_diet_plan'"]))
                  <li>
                     <a href="{{ url('editDietplan') }}">
                     <i class="fa fa-eye"></i>View Diet Plan
                     </a>
                  </li>
                  @endif
                  <li>
                     <a href="{{ url('assigndiettomember') }}">
                     <i class="fa fa-table"></i>Assign Diet Plan
                     </a>
                  </li>
               </ul>
            </li>
            </li>
         </ul>
         @endif
         @endif
         @if(isset($permission["'add_anytimeaccess'"]) || isset($permission["'view_anytimeaccess'"]) || isset($permission["'edit_anytimeaccess'"]) || isset($permission["'delete_anytimeaccess'"]))
      <li class="treeview">
         <a href="#" id="anytimeaccessmenuopen">
         <i class="fa fa-dot-circle-o"></i>
         <span>
         <b>AnyTime Access</b>
         </span>
         <span class="pull-right-container">
         <i class="fa fa-angle-left pull-right"></i>
         </span>
         </a>
         <ul class="treeview-menu ">
            <li>
               <a href="{{ url('addanytimeaccesscard') }}">
               <i class="fa fa-plus"></i>Add Access Card
               </a>
            </li>
            <li>
               <a href="{{ url('viewanytimeaccesscard') }}">
               <i class="fa fa-eye"></i>View Access Card
               </a>
            </li>
            <li>
               <a href="{{ url('atacardassigntomember') }}">
               <i class="fa fa-book"></i>Assign Access Card
               </a>
            </li>
            <li>
               <a href="{{ url('anytimeaccesscardreport') }}">
               <i class="fa fa-users"></i>Anytime Access Report
               </a>
            </li>
         </ul>
      </li>
      </li>
      @endif
      @if(isset($permission["'add_bank'"]) || isset($permission["'view_Bank'"]) || isset($permission["'add_categories'"]) || isset($permission["'view_categories'"]) || isset($permission["'add_expenses'"]) || isset($permission["'view_expenses'"]))
      <li class="treeview">
         <a href="#" id="expensemenuopen">
         <i class="fa fa-inr"></i>
         <span>
         <b>Expense Management</b>
         </span>
         <span class="pull-right-container">
         <i class="fa fa-angle-left pull-right"></i>
         </span>
         </a>
         <ul class="treeview-menu">
            <li class="treeview">
               <a href="#">
               <i class="fa fa-bank"></i>&nbsp;&nbsp;
               <span>
               <b>Bank Details</b>
               </span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu ">
                  <li>
                     <a href="{{ url('addbank') }}">
                     <i class="fa fa-plus"></i>Add Bank Details
                     </a>
                  </li>
                  <li>
                     <a href="{{ url('viewbank') }}">
                     <i class="fa fa-eye"></i>View Bank Details
                     </a>
                  </li>
               </ul>
            </li>
            <li class="treeview">
               <a href="#">
               <i class="fa fa-list"></i>&nbsp;&nbsp;
               <span>
               <b>Expense Categories</b>
               </span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu ">
                  <li>
                     <a href="{{ url('addexpense') }}">
                     <i class="fa fa-plus"></i>Add Category
                     </a>
                  </li>
                  <li>
                     <a href="{{ url('viewexpense') }}">
                     <i class="fa fa-eye"></i>View Category
                     </a>
                  </li>
               </ul>
            </li>
            <li class="treeview">
               <a href="#">
               <i class=" fa fa-usd"></i>&nbsp;&nbsp;
               <span>
               <b>Expenses</b>
               </span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu ">
                  <li>
                     <a href="{{ url('addexpenses') }}">
                     <i class="fa fa-plus"></i>Add Expense
                     </a>
                  </li>
                  <li>
                     <a href="{{ url('viewexpenses') }}">
                     <i class="fa fa-eye"></i>View Expense
                     </a>
                  </li>
                  <li> 
                     <a href="{{ url('monthlyreport') }}">
                     <i class="fa fa-line-chart"></i>Monthly Report
                     </a>
                  </li>
               </ul>
            </li>
         </ul>
      </li>
      @endif
      @if(isset($permission["'smsdashboard_all'"]) || isset($permission["'add_smstemplate'"]) || isset($permission["'edit_smstemplate'"]) || isset($permission["'view_smstemplate'"]))
      <li class="treeview">
         <a href="#" id="smsmenuopen">
         <i class="fa fa-envelope"></i>
         <span>
         <b>Sms Dashboard</b>
         </span>
         <span class="pull-right-container">
         <i class="fa fa-angle-left pull-right"></i>
         </span>
         </a>
         <ul class="treeview-menu">
            @if(isset($permission["'add_smstemplate'"]))
            <li>
               <a href="{{ url('addnewtemplate') }}">
               <i class="fa fa-plus"></i>Add SMS Template
               </a>
            </li>
            @endif
            @if(isset($permission["'edit_smstemplate'"]))
            <li>
               <a href="{{ url('editsms') }}">
               <i class="fa fa-edit"></i>Edit SMS Template
               </a>
            </li>
            @endif
            @if(isset($permission["'view_smstemplate'"]))
            <li>
               <a href="{{ url('sendsms') }}">
               <i class="fa fa-user"></i>Send SMS To Member
               </a>
            </li>
            <li>
               <a href="{{ url('sendinquirysms') }}">
               <i class="fa fa-users"></i>Send SMS To Inquiry
               </a>
            </li>
            <li>
               <a href="{{ url('sendregistrationsms') }}">
               <i class="fa fa-user-plus
               "></i>Send SMS To Register User
               </a>
            </li>
            <li>
               <a href="{{ url('directmessage') }}">
               <i class="fa fa-chevron-right"></i>Direct Message
               </a>
            </li>
            <li>
               <a href="{{ url('fetchsmslogs') }}">
               <i class="fa fa-table"></i>Email/SMS Logs
               </a>
            </li>
            <li>
               <a href="{{ url('msgsettings') }}">
               <i class="fa fa-envelope"></i>SMS/Email Settings
               </a>
            </li>
            <li>
               <a href="{{ url('editsmssettings') }}">
               <i class="fa fa-edit"></i>Edit SMS/Email Settings
               </a>
            </li>
            @endif
         </ul>
      </li>
      @endif
      @if(isset($permission["'add_exercise_tags'"]) || isset($permission["'view_exercise_tags'"]) )
      <li class="treeview">
         <a href="#" id="tagsmenuopen">
         <img src="{{ asset('images/icon/tags.png') }}" style="height: 18px; width: 18px;margin-left: -3px;">&nbsp;&nbsp;
         <span>
         <b>Tags</b>
         </span>
         <span class="pull-right-container">
         <i class="fa fa-angle-left pull-right"></i>
         </span>
         </a>
         <ul class="treeview-menu">
            @if(isset($permission["'add_exercise_tags'"]))
            <li>
               <a href="{{ url('addExerciseLevel') }}">
               <i class="fa fa-plus"></i>Add Tag
               </a>
            </li>
            @endif
            @if(isset($permission["'view_exercise_tags'"]))
            <li>
               <a href="{{ url('viewExerciseLevel') }}">
               <i class="fa fa-eye"></i>View Tag
               </a>
            </li>
            @endif
         </ul>
      </li>
      @endif
      <li i class="treeview">
         <a href="#" id="trainermenuopen">
         <i class="fa fa-dot-circle-o"></i>
         <span>
         <b>Trainer Module</b>
         </span>
         <span class="pull-right-container">
         <i class="fa fa-angle-left pull-right"></i>
         </span>
         </a>
         <ul class="treeview-menu">
            <li>
               <a href="{{ url('addtrainerprofile') }}">
               <i class="fa fa-plus"></i>Trainer Profile
               </a>
            </li>
            <li>
               <a href="{{ url('viewtrainers') }}">
               <i class="fa fa-eye"></i> Trainer Profile
               </a>
            </li>
            <li>
               <a href="{{ url('trialform') }}">
               <i class="fa fa-plus"></i>Trial Form Details</a>
            </li>
            <li>
               <a href="{{ url('viewtrialform') }}">
               <i class="fa fa-eye"></i> Trial Form Details</a>
            </li>
         </ul>
      </li>
   </section>
   <!-- /.sidebar -->
</aside>
{{-- <script>
   $('#adminmenuopen').on('click',function(){
      $('#hrmodulemenuopen').hide();
      $('#memberformmenuopen').hide();
      $('#devicemenuopen').hide();
      $('#adminmenuopen').show();
      $('#inquirymenuopen').hide();
      $('#membershipmenuopen').hide();
      $('#ptmenuopen').hide();
      $('#workoutmenuopen').hide(); 
      $('#measurementmenuopen').hide();
      $('#dietmenuopen').hide();
      $('#anytimeaccessmenuopen').hide(); 
      $('#expensemenuopen').hide();
      $('#smsmenuopen').hide();
      $('#schememenuopen').hide();
      $('#trainermenuopen').hide();
      $('#tagsmenuopen').hide(); 
      $('#registrationmenuopen').hide(); 
      
   });
   $('#hrmodulemenuopen').on('click',function(){
      $('#hrmodulemenuopen').show();
      $('#memberformmenuopen').hide();
      $('#devicemenuopen').hide();
      $('#adminmenuopen').hide();
      $('#inquirymenuopen').hide();
      $('#membershipmenuopen').hide();
      $('#ptmenuopen').hide();
      $('#workoutmenuopen').hide(); 
      $('#measurementmenuopen').hide();
      $('#dietmenuopen').hide();
      $('#anytimeaccessmenuopen').hide(); 
      $('#expensemenuopen').hide();
      $('#smsmenuopen').hide();
      $('#schememenuopen').hide();
      $('#trainermenuopen').hide();
      $('#tagsmenuopen').hide(); 
      $('#registrationmenuopen').hide(); 
   });
</script> --}}
<script type="text/javascript">
   var url = window.location;
   // for sidebar menu but not for treeview submenu
   $('ul.sidebar-menu a').filter(function() {
   return this.href == url;
   }).parent().siblings().removeClass('active').end().addClass('active');
   // for treeview which is like a submenu
   $('ul.treeview-menu a').filter(function() {
   return this.href == url;
   }).parentsUntil(".sidebar-menu > .treeview-menu").siblings().removeClass('active menu-open').end().addClass('active menu-open');
</script>