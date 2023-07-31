@extends('layouts.adminLayout.admin_design')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
 <div class="content-wrapper">
        <?php $permission = !empty($role->permission) ? unserialize($role->permission) : '';
        //dd(array_key_exists('add_device',$permission));
        ?>
         <section class="content-header">Edit Role</section>
          <!-- general form elements -->
           <section class="content">
             @if ($errors->any())
            <div class="alert alert-danger">
                 <button type="button" class="close" data-dismiss="alert">×</button>
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
            </div>
            @endif
          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title"></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"><div class="col-lg-12">
              <form role="form" action="{{ url('editrole/'.$role->roleid) }}"  method="post">
                 {{ csrf_field() }}
                <!-- text input -->
                <div class="form-group">
                  <label>Role Name<span style="color: red;">*</span></label>
                  <input type="text" class="form-control" maxlength="191" value="{{$role->employeerole}}" name="EmployeeRole" readonly="" placeholder="Enter role name"  required="">
                </div>
                <div class="form-group">
                  <label>Description</label>
                 <textarea class="form-control" rows="3" maxlength="191"   name="description"placeholder="Enter Descrription" required>{{$role->description}}</textarea>
                </div>
                 <div class="form-group">
                  <label>Portal Access</label>
                   &nbsp;&nbsp;&nbsp;<input type="checkbox" name="portal_access" value="1" @if($role->portalaccess == 1) checked="" @endif>
                </div>
                <div class="form-group">
                  <label>Permission</label>
                  <table class="table table-border">
                    <thead>
                      <th>#</th>
                      <th>All</th>
                      <th>Create</th>
                      <th>View</th>
                      <th>Edit</th>
                      <th>Delete</th>
                    </thead>
                    <tbody>
                       <tbody>
                        <tr>
                          <th>HR Module</th>
                          <td><input type="checkbox" class="check addall" name="permission['hr_module_all']" @if(isset($permission["'hr_module_all'"])) checked @endif></td>
                          <td><input type="checkbox" class="check" name="permission['hr_module']" @if(isset($permission["'hr_module'"])) checked @endif ></td>
                          <td><input type="checkbox" class="check" name="permission['hr_device']" @if(isset($permission["'hr_device'"])) checked @endif ></td>
                          <td><input type="checkbox" class="check" name="permission['edit_hr_module']" @if(isset($permission["'edit_hr_module'"])) checked @endif ></td>
                          <td><input type="checkbox" class="check" name="permission['delete_hr_module']" @if(isset($permission["'delete_hr_module'"])) checked @endif ></td>
                        </tr>
                       <tr>
                        <th>Registration</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_registration_all']" @if(isset($permission["'add_registration_all'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['add_registration']" @if(isset($permission["'add_registration'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['view_registration']" @if(isset($permission["'view_registration'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_registration']" @if(isset($permission["'edit_registration'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_registration']" @if(isset($permission["'delete_registration'"])) checked @endif ></td>
                      </tr>
                      <tr>
                        <th>Employee</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_employee_all']"  @if(isset($permission["'add_employee_all'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['add_employee']" @if(isset($permission["'add_employee'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['view_employee']" @if(isset($permission["'view_employee'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['edit_employee']" @if(isset($permission["'edit_employee'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['delete_employee']" @if(isset($permission["'delete_employee'"])) checked @endif></td>
                      </tr>
                      <tr>
                        <tr>
                            <th>Employee Leave</th>
                            <td><input type="checkbox" class="check addall" name="permission['employee_leave_all']"  @if(isset($permission["'employee_leave_all'"])) checked @endif></td>
                            <td><input type="checkbox" class="check" name="permission['add_employee_leave']" @if(isset($permission["'add_employee_leave'"])) checked @endif></td>
                            <td><input type="checkbox" class="check" name="permission['view_employee_leave']" @if(isset($permission["'view_employee_leave'"])) checked @endif></td>
                            {{-- <td><input type="checkbox" class="check" name="permission['view_employee']" @if(isset($permission["'view_employee'"])) checked @endif></td>
                            <td><input type="checkbox" class="check" name="permission['edit_employee']" @if(isset($permission["'edit_employee'"])) checked @endif></td>
                            <td><input type="checkbox" class="check" name="permission['delete_employee']" @if(isset($permission["'delete_employee'"])) checked @endif></td> --}}
                        </tr>
                        <th>Role</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_role_all']"  @if(isset($permission["'add_employee_all'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['add_role']" @if(isset($permission["'add_role'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['view_role']" @if(isset($permission["'view_role'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['edit_role']" @if(isset($permission["'edit_role'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['delete_role']" @if(isset($permission["'delete_role'"])) checked @endif></td>
                      </tr>
                       <tr>
                        <th>Company</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_company_all']"  @if(isset($permission["'add_company_all'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['add_company']" @if(isset($permission["'add_company'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['view_company']" @if(isset($permission["'view_company'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['edit_company']" @if(isset($permission["'edit_company'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['delete_company']" @if(isset($permission["'delete_company'"])) checked @endif></td>
                      </tr>
                      <tr>
                        <th>Payment Type</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_paymentType_all']"  @if(isset($permission["'add_paymentType_all'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['add_paymentType']" @if(isset($permission["'add_paymentType'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['view_paymentType']" @if(isset($permission["'view_paymentType'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['edit_paymentType']" @if(isset($permission["'edit_paymentType'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['delete_paymentType']" @if(isset($permission["'delete_paymentType'"])) checked @endif></td>
                      </tr>
                       <tr>
                        <th>Tax</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_tax_all']" @if(isset($permission["'add_tax_all'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['add_tax']" @if(isset($permission["'add_tax'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['view_tax']" @if(isset($permission["'view_tax'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_tax']" @if(isset($permission["'edit_tax'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_tax']" @if(isset($permission["'delete_tax'"])) checked @endif ></td>
                      </tr>
                      <tr>
                        <th>Reason</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_reason_all']" @if(isset($permission["'add_reason_all'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['add_reason']" @if(isset($permission["'add_reason'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['view_reason']" @if(isset($permission["'view_reason'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_reason']" @if(isset($permission["'edit_reason'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_reason']" @if(isset($permission["'delete_reason'"])) checked @endif ></td>
                      </tr>
                      <tr>
                        <th>Device</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_device_all']"  @if(isset($permission["'add_device_all'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['add_device']" @if(isset($permission["'add_device'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['view_device']" @if(isset($permission["'view_device'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['edit_device']" @if(isset($permission["'edit_device'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['delete_device']" @if(isset($permission["'delete_device'"])) checked @endif></td>
                      </tr>
                      <tr>
                        <th>Root Scheme</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_root_all']"  @if(isset($permission["'add_root_all'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['add_root_scheme']" @if(isset($permission["'add_root_scheme'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['view_root_scheme']" @if(isset($permission["'view_root_scheme'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['edit_root_scheme']" @if(isset($permission["'edit_root_scheme'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['delete_root_scheme']" @if(isset($permission["'delete_root_scheme'"])) checked @endif></td>
                      </tr>
                      <tr>
                        <th>Scheme</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_scheme_all']"  @if(isset($permission["'add_scheme_all'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['add_scheme']" @if(isset($permission["'add_scheme'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['view_scheme']" @if(isset($permission["'view_scheme'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['edit_scheme']" @if(isset($permission["'edit_scheme'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['delete_scheme']" @if(isset($permission["'delete_scheme'"])) checked @endif></td>
                      </tr>
                      <tr>
                        <th>Terms</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_terms_all']"  @if(isset($permission["'add_terms_all'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['add_term']" @if(isset($permission["'add_term'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['view_term']" @if(isset($permission["'view_term'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['edit_term']" @if(isset($permission["'edit_term'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['delete_term']" @if(isset($permission["'delete_term'"])) checked @endif></td>
                      </tr>
                      <tr>
                        <th>Inquiry</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_inquiry_all']" @if(isset($permission["'add_inquiry_all'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['add_inquiry']" @if(isset($permission["'add_inquiry'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['view_inquiry']" @if(isset($permission["'view_inquiry'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_inquiry']" @if(isset($permission["'edit_inquiry'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_inquiry']" @if(isset($permission["'delete_inquiry'"])) checked @endif ></td>
                      </tr>
                      <tr>
                        <th>Confirm Inquiry</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_confirminquiry_all']" @if(isset($permission["'add_confirminquiry_all'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['add_confirminquiry']" @if(isset($permission["'add_confirminquiry'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['view_confirminquiry']" @if(isset($permission["'view_confirminquiry'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_confirminquiry']" @if(isset($permission["'edit_confirminquiry'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_confirminquiry']" @if(isset($permission["'delete_confirminquiry'"])) checked @endif ></td>
                      </tr>
                      <tr>
                        <th>PT Trial Form</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_trial_form_all']" @if(isset($permission["'add_trial_form_all'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['add_trial_form']" @if(isset($permission["'add_trial_form'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['view_trial_form']" @if(isset($permission["'view_trial_form'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['edit_trial_form']" @if(isset($permission["'edit_trial_form'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['delete_trial_form']" @if(isset($permission["'delete_trial_form'"])) checked @endif></td>
                      </tr>
                       <tr>
                        <th>Member</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_member_all']"  @if(isset($permission["'add_member_all'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['add_member']" @if(isset($permission["'add_member'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['view_member']" @if(isset($permission["'view_member'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['edit_member']" @if(isset($permission["'edit_member'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['delete_member']" @if(isset($permission["'delete_member'"])) checked @endif></td>
                      </tr>
                       <tr>
                        <th>Member Assessment</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_memberAssesment_all']"  @if(isset($permission["'add_memberAssesment_all'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['add_member_assessment']" @if(isset($permission["'add_member_assessment'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['view_member_assessment']" @if(isset($permission["'view_member_assessment'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['edit_member_assessment']" @if(isset($permission["'edit_member_assessment'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['delete_member_assessment']" @if(isset($permission["'delete_member_assessment'"])) checked @endif></td>
                      </tr>
                       <tr>
                        <th>Assign/Renewal</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_assign_all']"  @if(isset($permission["'add_assign_all'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['add_assign_renewal']" @if(isset($permission["'add_assign_renewal'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['view_assign_renewal']" @if(isset($permission["'view_assign_renewal'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['edit_assign_renewal']" @if(isset($permission["'edit_assign_renewal'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['delete_assign_renewal']" @if(isset($permission["'delete_assign_renewal'"])) checked @endif></td>
                      </tr>
                      <tr>
                        <th>PT Level</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_PT_level_all']" @if(isset($permission["'add_PT_level_all'"])) checked @endif class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_pt_level']" @if(isset($permission["'add_pt_level'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['view_pt_level']" @if(isset($permission["'view_pt_level'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_pt_level']" @if(isset($permission["'edit_pt_level'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_pt_level']" @if(isset($permission["'delete_pt_level'"])) checked @endif ></td>
                      </tr>
                      <tr>
                        <th>Assign PT Level</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_assign_PT_all']" @if(isset($permission["'add_assign_PT_all'"])) checked @endif class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_assign_pt_level']" @if(isset($permission["'add_assign_pt_level'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['view_assign_pt_level']" @if(isset($permission["'view_assign_pt_level'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_assign_pt_level']" @if(isset($permission["'edit_assign_pt_level'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_assign_pt_level']" @if(isset($permission["'delete_assign_pt_level'"])) checked @endif ></td>
                      </tr>
                      <tr>
                        <th>PT Time</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_PT_time_all']" @if(isset($permission["'add_PT_time_all'"])) checked @endif class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_pt_time']" @if(isset($permission["'add_pt_time'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['view_pt_time']" @if(isset($permission["'view_pt_time'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_pt_time']" @if(isset($permission["'edit_pt_time'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_pt_time']" @if(isset($permission["'delete_pt_time'"])) checked @endif ></td>
                      </tr>
                      <tr>
                        <th>Member Assign To PT</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_matp_all']" @if(isset($permission["'add_matp_all'"])) checked @endif class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_matp_level']" @if(isset($permission["'add_matp_level'"])) checked @endif ></td>
                        <td><input type="checkbox"  name="permission['view_matp_level']" @if(isset($permission["'view_matp_level'"])) checked @endif disabled ></td>
                        <td><input type="checkbox"  name="permission['edit_matp_level']" @if(isset($permission["'edit_matp_level'"])) checked @endif disabled ></td>
                        <td><input type="checkbox"  name="permission['delete_matp_level']" @if(isset($permission["'delete_matp_level'"])) checked @endif disabled ></td>
                      </tr>
                      <tr>
                        <th>Manage Member </th>
                        <td><input type="checkbox" class="check addall" name="permission['add_member_manage_all']" @if(isset($permission["'add_member_manage_all'"])) checked @endif class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_member_manage']" @if(isset($permission["'add_member_manage'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['view_member_manage']" @if(isset($permission["'view_member_manage'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_member_manage']" @if(isset($permission["'edit_member_manage'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_member_manage']" @if(isset($permission["'delete_member_manage'"])) checked @endif ></td>
                      </tr>
                      <tr>
                        <th>Claim Member</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_claim_all']" @if(isset($permission["'add_claim_all'"])) checked @endif class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_claim']" @if(isset($permission["'add_claim'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['view_claim']" @if(isset($permission["'view_claim'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_claim']" @if(isset($permission["'edit_claim'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_claim']" @if(isset($permission["'delete_claim'"])) checked @endif ></td>
                      </tr>
                      <tr>
                        <th>Exercise</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_exercise_all']"  @if(isset($permission["'add_exercise_all'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['add_exercise']" @if(isset($permission["'add_exercise'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['view_exercise']" @if(isset($permission["'view_exercise'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['edit_exercise']" @if(isset($permission["'edit_exercise'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['delete_exercise']" @if(isset($permission["'delete_exercise'"])) checked @endif></td>
                      </tr>
                      <tr>
                        <th>Exercise Tags</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_exercise_tags_all']" @if(isset($permission["'add_exercise_tags_all'"])) checked @endif class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_exercise_tags']" @if(isset($permission["'add_exercise_tags'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['view_exercise_tags']" @if(isset($permission["'view_exercise_tags'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_exercise_tags']" @if(isset($permission["'edit_exercise_tags'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_exercise_tags']" @if(isset($permission["'delete_exercise_tags'"])) checked @endif ></td>
                      </tr>
                      <tr>
                        <th>Plan Workout</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_planworkout_all']" @if(isset($permission["'add_planworkout_all'"])) checked @endif class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_planworkout']" @if(isset($permission["'add_planworkout'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['view_planworkout']" @if(isset($permission["'view_planworkout'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_planworkout']" @if(isset($permission["'edit_planworkout'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_planworkout']" @if(isset($permission["'delete_planworkout'"])) checked @endif ></td>
                      </tr>
                      <tr>
                        <th>Plan View</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_planview_all']" @if(isset($permission["'add_planview_all'"])) checked @endif class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_planview']" @if(isset($permission["'add_planview'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['view_planview']" @if(isset($permission["'view_planview'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_planview']" @if(isset($permission["'edit_planview'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_planview']" @if(isset($permission["'delete_planview'"])) checked @endif ></td>
                      </tr>
                      <tr>
                        <th>Assign Workout</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_assign_workout_all']" @if(isset($permission["'add_assign_workout_all'"])) checked @endif class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_assign_workout']" @if(isset($permission["'add_assign_workout'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['view_assign_workout']" @if(isset($permission["'view_assign_workout'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_assign_workout']" @if(isset($permission["'edit_assign_workout'"])) checked @endif ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_assign_workout']" @if(isset($permission["'delete_assign_workout'"])) checked @endif ></td>
                      </tr>
                      <tr>
                      <tr>
                        <th>Measurement</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_measurement_all']"  @if(isset($permission["'add_measurement_all'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['add_measurement']" @if(isset($permission["'add_measurement'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['view_measurement']" @if(isset($permission["'view_measurement'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['edit_measurement']" @if(isset($permission["'edit_measurement'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['delete_measurement']" @if(isset($permission["'delete_measurement'"])) checked @endif></td>
                      </tr>
                      <tr>
                        <th>SMS Dashboard</th>
                        <td><input type="checkbox" class="check addall" name="permission['smsdashboard_all']"  @if(isset($permission["'smsdashboard_all'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['add_smstemplate']" @if(isset($permission["'add_smstemplate'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['view_smstemplate']" @if(isset($permission["'view_smstemplate'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['edit_smstemplate']" @if(isset($permission["'edit_smstemplate'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['delete_smstemplate']" @if(isset($permission["'delete_smstemplate'"])) checked @endif></td>
                      </tr>
                        <tr>
                        <th>Diet Plan</th>
                        <td><input type="checkbox" class="check addall" name="permission['diet_plan_all']"  @if(isset($permission["'diet_plan_all'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['add_diet_plan']" @if(isset($permission["'add_diet_plan'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['view_diet_plan']" @if(isset($permission["'view_diet_plan'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['edit_diet_plan']" @if(isset($permission["'edit_diet_plan'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['delete_diet_plan']" @if(isset($permission["'delete_diet_plan'"])) checked @endif></td>
                      </tr>
                      <tr>
                       <th>Package Upgrade</th>
                       <td><input type="checkbox" class="check addall" name="permission['package_upgrade_all']"  @if(isset($permission["'diet_plan_all'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['add_package_upgrade']" @if(isset($permission["'add_package_upgrade'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['view_package_upgrade']" @if(isset($permission["'view_package_upgrade'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['edit_package_upgrade']" @if(isset($permission["'edit_package_upgrade'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['delete_package_upgrade']" @if(isset($permission["'delete_package_upgrade'"])) checked @endif></td>
                     </tr>
                        <tr>
                       <th>Transfer Membership</th>
                       <td><input type="checkbox" class="check addall" name="permission['transfer_membership_all']"  @if(isset($permission["'transfer_membership_all'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['transfer_membership']" @if(isset($permission["'transfer_membership'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['view_transfer_membership']" @if(isset($permission["'view_transfer_membership'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['edit_transfer_membership']" @if(isset($permission["'edit_transfer_membership'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['delete_transfer_membership']" @if(isset($permission["'delete_transfer_membership'"])) checked @endif></td>
                     </tr>
                     <tr>
                       <th>Freeze Membership</th>
                       <td><input type="checkbox" class="check addall" name="permission['freezemembership_all']" @if(isset($permission["'freezemembership_all'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['add_freezemembership']" @if(isset($permission["'add_freezemembership'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['view_freezemembership']" @if(isset($permission["'view_freezemembership'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['edit_freezemembership']" @if(isset($permission["'edit_freezemembership'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['delete_freezemembership']" @if(isset($permission["'delete_freezemembership'"])) checked @endif></td>
                      </tr>
                      <tr>
                       <th>Anytime Access</th>
                       <td><input type="checkbox" class="check addall" name="permission['anytimeaccess_all']" @if(isset($permission["'freezemembership_all'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['add_anytimeaccess']" @if(isset($permission["'freezemembership_all'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['view_anytimeaccess']" @if(isset($permission["'freezemembership_all'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['edit_anytimeaccess']" @if(isset($permission["'freezemembership_all'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['delete_anytimeaccess']" @if(isset($permission["'freezemembership_all'"])) checked @endif></td>
                      </tr>

                        <tr>
                       <th>Bank Details</th>
                       <td><input type="checkbox" class="check addall" name="permission['Bank_all']" @if(isset($permission["'Bank_all'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['add_bank']" @if(isset($permission["'add_bank'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['view_Bank']" @if(isset($permission["'view_Bank'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['edit_Bank']" @if(isset($permission["'edit_Bank'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['delete_Bank']" @if(isset($permission["'delete_Bank'"])) checked @endif></td>


                     </tr>
                      <tr>
                       <th>Expense Categories</th>
                       <td><input type="checkbox" class="check addall" name="permission['categories_all']" @if(isset($permission["'categories_all'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['add_categories']" @if(isset($permission["'add_categories'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['view_categories']" @if(isset($permission["'view_categories'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['edit_categories']" @if(isset($permission["'edit_categories'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['delete_categories']" @if(isset($permission["'delete_categories'"])) checked @endif></td>


                     </tr>
                     <tr><th>Expenses</th>
                      <td><input type="checkbox" class="check addall" name="permission['expenses_all']" @if(isset($permission["'expenses_all'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['add_expenses']" @if(isset($permission["'add_expenses'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['view_expenses']" @if(isset($permission["'view_expenses'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['edit_expenses']" @if(isset($permission["'edit_expenses'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['delete_expenses']" @if(isset($permission["'delete_expenses'"])) checked @endif></td>

                      </tr>
                    <tr><th>Member Form</th>
                      <td><input type="checkbox" class="check addall" name="permission['memberform_all']" @if(isset($permission["'memberform_all'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['add_memberform']" @if(isset($permission["'add_memberform'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['view_memberform']" @if(isset($permission["'view_memberform'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['edit_memberform']" @if(isset($permission["'edit_memberform'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['delete_memberform']" @if(isset($permission["'delete_memberform'"])) checked @endif></td>

                      </tr>
                      <tr><th>Trainer Profile</th>
                      <td><input type="checkbox" class="addall" name="permission['trainer_profile_all']" @if(isset($permission["'trainer_profile_all'"])) checked @endif></td>

                      </tr>
                      <tr><th>Help Desk</th>
                      <td><input type="checkbox" class="addall" name="permission['helpdesk_all']" @if(isset($permission["'helpdesk_all'"])) checked @endif></td>

                      </tr>
                    </tbody>
                  </table>
                </div>

                 <div class="form-group">

                  <div class="col-sm-6">
         <button type="submit" class="btn bg-green btn-block">
         Update</button></div>   <div class="col-sm-6"> <a href="{{ url('roles') }}"class="btn btn-danger btn-block">Cancel</a></div>
                <!-- Select multiple-->


              </form></div>
            </div>
            <!-- /.box-body -->
          </div>

  </section>
</div>
</div>
</div>
@endsection
@push('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('#role_form').validate({
      rules: {
        EmployeeRole : {
          required : true,
          maxlength : 255
        },
        description : {
          required : true,
          maxlength : 255
        }
      }
    });

    $('.addall').click(function(){
      if($(this).is(':checked')){
        $(this).closest('tr').find('[type="checkbox"]').prop('checked', true);
      } else {
        $(this).closest('tr').find('[type="checkbox"]').prop('checked', false);
      }
    });

    $('.check').click(function(){
      var count = $(this).closest('tr').find('input[type="checkbox"]:checked').length;
      //alert(count);
      if(count < 5){
        $(this).closest('tr').find('td:first').find('[type="checkbox"]').prop('checked', false);
      } else {
        $(this).closest('tr').find('td:first').find('[type="checkbox"]').prop('checked', true);

      }
    });
  });
</script>
@endpush
