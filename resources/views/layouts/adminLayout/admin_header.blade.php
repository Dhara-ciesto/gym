<?php
  include('..///config/database.php');
?>
<style>
	h1,h2,h3,h4,h5,h5,h6{
 font-family: montserrat, arial, verdana;
}
</style>
  <header  class="main-header" id="header">

 <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Logo -->
    <a  class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>F5</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Fitness 5</b></span>
    </a>
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

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->

          {{-- <li class="dropdown messages-menu">

            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li> -->
                <!-- inner menu: contains the actual data -->
              <!--   <ul class="menu">
                  <li> -->
                    <!-- start message -->
                <!--     <a href="#">
                      <div class="pull-left">
                        <img src="{{ asset('dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li> -->
                  <!-- end message -->
                <!--   <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{ asset('dist/img/user3-128x128.jpg')}}" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        AdminLTE Design Team
                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{ asset('dist/img/user4-128x128.jpg')}}" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Developers
                        <small><i class="fa fa-clock-o"></i> Today</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{ asset('dist/img/user3-128x128.jpg')}}" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Sales Department
                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{ asset('dist/img/user4-128x128.jpg')}}" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Reviewers
                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li> -->
          <!-- Notifications: style can be found in dropdown.less -->
         <!--  <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li> -->
                <!-- inner menu: contains the actual data -->
                <!-- <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li>
                </ul> -->
              <!-- </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li> -->
          <!-- Tasks: style can be found in dropdown.less -->
         <!--  <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>-->
                <!-- inner menu: contains the actual data -->
                <!-- <ul class="menu">-->
                  <!-- <li>--><!-- Task item -->
                   <!--  <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>-->
                  <!-- end task item -->
                <!--   <li>--><!-- Task item -->
                  <!--   <a href="#">
                      <h3>
                        Create a nice theme
                        <small class="pull-right">40%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">40% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li> -->
                  <!-- end task item -->
                  <!-- <li> -->
                    <!-- Task item -->
                    <!-- <a href="#">
                      <h3>
                        Some task I need to do
                        <small class="pull-right">60%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </a> -->
                  <!-- </li> -->
                  <!-- end task item -->
                  <!-- <li> -->
                    <!-- Task item -->
                   <!--  <a href="#">
                      <h3>
                        Make beautiful transitions
                        <small class="pull-right">80%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">80% Complete</span>
                        </div>
                      </div>
                    </a> -->
                  <!-- </li> -->
                  <!-- end task item -->
              <!--  </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>

          </li> --}}

          <!-- User Account: style can be found in dropdown.less -->
            <!-- <li>
            <img src="{{ asset('images/sync.png') }}" id="sync" style="height: 30px;width: 30px;margin-top: 10px;margin-right: 10px;cursor: pointer;">
          </li>
          <li>
            <img src="{{ asset('images/icon/connected.png') }}" id="connected" style="margin-top: 12px;display: none;width: 25px;height: 25px;" title="Connected">
            <img src="{{ asset('images/icon/disconnected.png') }}" id="disconnected" style="margin-top: 12px;display: none;width: 25px;height: 25px;" title="Connected">
           {{--  <button class="btn btn-danger" id="disconnected" style="margin-top: 8px;display: none;">Disconnected</button> --}}
            <img src="{{ asset('images/signal.gif') }}" id="checking" style="margin-top: 12px;width: 25px;height: 25px;">
          </li>-->

          <li class="dropdown user user-menu">


            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                          <img src="{{ asset('images/'.$photo) }}" class="user-image" alt="User Image">
              <span class="hidden-xs"><b>{{ucfirst(session('username'))}}</b></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ asset('images/'.$photo) }}" class="img-circle" alt="User Image">
                <p>
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
                      @php $us = session('username');
                      $role ='';
                      $user1 =   DB::table('employee')->where('username',$us)->get()->first();
                      if(!empty($user1)){
                        if($user1->role){
                          $role = $user1->role;
                        }else{
                          $role =  'Gym Owner';
                        }
                      } else {
                        $role =  'Gym Owner';
                      }
                    @endphp
                  <b>{{session('username')}}</b>
                  <small>{{$role}}</small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">

                   @php $us1 = session('username');
                      if($us1){
                        $user1 =   DB::table('employee')->where('username',$us1)->get()->first();
                      }else{
                        $user1 ='';
                      }
                    @endphp
                    @if($user1)
                  <a href="{{url('edituser/'.$user1->employeeid)}}" class="btn btn-default btn-flat">Profile</a>
                  @endif
                </div>

                <div class="pull-right">
                  <a href="{{url('/logout')}}" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->


      </div>

    </nav>
  </header>
<div oncopy="return false" oncut="return false" onpaste="return false">
{{--<div>--}}
