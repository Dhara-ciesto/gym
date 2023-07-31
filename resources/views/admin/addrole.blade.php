@extends('layouts.adminLayout.admin_design')

@push('css')
<style type="text/css">
  .help-block{
    color: red;
  }
  .error{
    color: red;
  }
</style>
@endpush
@section('content')

<!-- left column -->
  <div class="content-wrapper">
   
     
<!--          <section class="content-header"><h2>Add Role</h2></section>
 -->          <!-- general form elements -->
           <section class="content">
          
           <!--    @if ($errors->any())
            <div class="alert alert-danger">
               <button type="button" class="close" data-dismiss="alert">×</button>
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
            </div>
            @endif -->

          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Add Role</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"> <div class="col-lg-12">
              <form role="form" action="{{ url('addrole') }}" method="post" id="role_form">
                 {{ csrf_field() }}
                <!-- text input -->
                <div class="form-group">
                  <label>Role Name<span style="color: red;">*</span></label>
                  <input type="text" class="form-control" id="EmployeeRole" maxlength="191" name="EmployeeRole" value="{{ old('EmployeeRole') }}" required placeholder="Enter role name">
                  @if($errors->has('EmployeeRole'))
                    <span class="help-block">
                      <strong>{{ $errors->first('EmployeeRole') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="form-group">
                  <label>Description<span style="color: red;">*</span></label>
                 <textarea class="form-control" rows="3" maxlength="191" required="" value="" id="description"  name="description" placeholder="Enter Descrription">{{ old('description') }}</textarea>
                 @if($errors->has('description'))
                    <span class="help-block">
                      <strong>{{ $errors->first('description') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="form-group">
                  <label>Portal Access</label>
                   &nbsp;&nbsp;&nbsp;<input type="checkbox" name="portal_access" value="1">
                </div>
                <div class="form-group">
                  <label>Permission</label>
                  <table class="table table-border"> 
                    <thead>
                      <th>#</th>
                      <th>All</th>
                      <th>Add</th>
                      <th>View</th>
                      <th>Edit</th>
                      <th>Delete</th>
                    </thead>
                    <tbody>
                      <tr>
                        <th>HR Module</th>
                        <td><input type="checkbox" class="check addall" name="permission['hr_module_all']" ></td>
                        <td><input type="checkbox" class="check" name="permission['hr_module']" ></td>
                        <td><input type="checkbox" class="check" name="permission['hr_device']"  ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_module']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_module']"  ></td>
                      </tr>
                     <tr>
                        <th>Registration</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_registration_all']"></td>
                        <td><input type="checkbox" class="check" name="permission['add_registration']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_registration']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_registration']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_registration']" ></td>
                      </tr>
                      <tr>
                        <th>Employee</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_employee_all']"></td>
                        <td><input type="checkbox" class="check" name="permission['add_employee']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_employee']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_employee']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_employee']" ></td>
                      </tr>
                      <tr>
                        <th>Role</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_employee_all']"></td>
                        <td><input type="checkbox" class="check" name="permission['add_role']"></td>
                        <td><input type="checkbox" class="check" name="permission['view_role']"></td>
                        <td><input type="checkbox" class="check" name="permission['edit_role']"></td>
                        <td><input type="checkbox" class="check" name="permission['delete_role']"></td>
                      </tr>
                       <tr>
                        <th>Company</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_company_all']"></td>
                        <td><input type="checkbox" class="check" name="permission['add_company']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_company']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_company']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_company']" ></td>
                      </tr>
                      <tr>
                        <th>Payment Type</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_paymentType_all']"></td>
                        <td><input type="checkbox" class="check" name="permission['add_paymentType']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_paymentType']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_paymentType']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_paymentType']" ></td>
                      </tr>
                      <tr>
                        <th>Tax</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_tax_all']"></td>
                        <td><input type="checkbox" class="check" name="permission['add_tax']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_tax']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_tax']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_tax']" ></td>
                      </tr>
                      <tr>
                        <th>Reason</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_reason_all']"></td>
                        <td><input type="checkbox" class="check" name="permission['add_reason']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_reason']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_reason']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_reason']" ></td>
                      </tr>
                      <tr>
                        <th>Device</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_device_all']"></td>
                        <td><input type="checkbox" class="check" name="permission['add_device']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_device']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_device']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_device']" ></td>
                      </tr>
                      <tr>
                        <th>Root Scheme</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_root_all']"></td>
                        <td><input type="checkbox" class="check" name="permission['add_root_scheme']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_root_scheme']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_root_scheme']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_root_scheme']" ></td>
                      </tr>
                      <tr>
                        <th>Scheme</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_scheme_all']" ></td>
                        <td><input type="checkbox" class="check" name="permission['add_scheme']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_scheme']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_scheme']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_scheme']" ></td>
                      </tr>
                      <tr>
                        <th>Terms</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_terms_all']" ></td>
                        <td><input type="checkbox" class="check" name="permission['add_term']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_term']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_term']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_term']" ></td>
                      </tr>
                      <tr>
                        <th>Inquiry</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_inquiry_all']" ></td>
                        <td><input type="checkbox" class="check" name="permission['add_inquiry']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_inquiry']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_inquiry']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_inquiry']" ></td>
                      </tr>
                      <tr>
                        <th>Confirm Inquiry</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_confirminquiry_all']" ></td>
                        <td><input type="checkbox" class="check" name="permission['add_confirminquiry']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_confirminquiry']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_confirminquiry']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_confirminquiry']" ></td>
                      </tr>
                      <tr>
                        <th>PT Trail Form</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_trial_form_all']" ></td>
                        <td><input type="checkbox" class="check" name="permission['add_trial_form']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_trial_form']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_trial_form']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_trial_form']" ></td>
                      </tr>
                       <tr>
                        <th>Member</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_member_all']" ></td>
                        <td><input type="checkbox" class="check" name="permission['add_member']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_member']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_member']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_member']" ></td>
                      </tr>
                      {{--  <tr>
                        <th>Member Assessment</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_memberAssesment_all']" ></td>
                        <td><input type="checkbox" class="check" name="permission['add_member_assessment']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_member_assessment']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_member_assessment']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_member_assessment']" ></td>
                      </tr> --}}
                       <tr>
                        <th>Assign/Renewal</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_assign_all']" class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_assign_renewal']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_assign_renewal']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_assign_renewal']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_assign_renewal']" ></td>
                      </tr>
                      <tr>
                        <th>PT Level</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_PT_level_all']" class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_pt_level']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_pt_level']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_pt_level']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_pt_level']" ></td>
                      </tr>
                      <tr>
                        <th>Assign PT Level</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_assign_PT_all']" class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_assign_pt_level']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_assign_pt_level']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_assign_pt_level']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_assign_pt_level']" ></td>
                      </tr>
                      <tr>
                        <th>PT Time</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_PT_time_all']" class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_pt_time']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_pt_time']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_pt_time']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_pt_time']" ></td>
                      </tr>
                      <tr>
                        <th>Member Assign To PT</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_matp_all']" class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_matp_level']" ></td>
                        <td><input type="checkbox"  name="permission['view_matp_level']" disabled ></td>
                        <td><input type="checkbox"  name="permission['edit_matp_level']" disabled ></td>
                        <td><input type="checkbox"  name="permission['delete_matp_level']" disabled ></td>
                      </tr>
                      <tr>
                        <th>Manage Member </th>
                        <td><input type="checkbox" class="check addall" name="permission['add_member_manage_all']" class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_member_manage']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_member_manage']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_member_manage']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_member_manage']" ></td>
                      </tr>
                      <tr>
                        <th>Claim Member</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_claim_all']" class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_claim']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_claim']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_claim']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_claim']" ></td>
                      </tr>
                      <tr>
                        <th>Exercise</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_exercise_all']" class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_exercise']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_exercise']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_exercise']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_exercise']" ></td>
                      </tr>
                      <tr>
                        <th>Exercise Tags</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_exercise_tags_all']" class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_exercise_tags']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_exercise_tags']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_exercise_tags']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_exercise_tags']" ></td>
                      </tr>
                      <tr>
                        <th>Plan Workout</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_planworkout_all']" class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_planworkout']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_planworkout']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_planworkout']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_planworkout']" ></td>
                      </tr>
                      <tr>
                        <th>Plan View</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_planview_all']" class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_planview']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_planview']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_planview']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_planview']" ></td>
                      </tr>
                      <tr>
                        <th>Assign Workout</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_assign_workout_all']" class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_assign_workout']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_assign_workout']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_assign_workout']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_assign_workout']" ></td>
                      </tr>
                      <tr>
                        <th>Measurement</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_measurement_all']" class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_measurement']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_measurement']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_measurement']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_measurement']" ></td>
                      </tr>
                      <tr>
                        <th>Meal</th>
                        <td><input type="checkbox" class="check addall" name="permission['add_meal_all']" class=""></td>
                        <td><input type="checkbox" class="check" name="permission['add_meal']" ></td>
                        <td><input type="checkbox" class="check" name="permission['view_meal']" ></td>
                        <td><input type="checkbox" class="check" name="permission['edit_meal']" ></td>
                        <td><input type="checkbox" class="check" name="permission['delete_meal']" ></td>
                      </tr>
                      <tr>
                       <th>Package Upgrade</th>
                       <td><input type="checkbox" class="check addall" name="permission['package_upgrade_all']"></td>
                       <td><input type="checkbox" class="check" name="permission['add_package_upgrade']" ></td>
                       <td><input type="checkbox" class="check" name="permission['view_package_upgrade']" ></td>
                       <td><input type="checkbox" class="check" name="permission['edit_package_upgrade']"></td>
                       <td><input type="checkbox" class="check" name="permission['delete_package_upgrade']"></td>
                      </tr>
                      <tr>
                       <th>Anytime Access</th>
                       <td><input type="checkbox" class="check addall" name="permission['anytimeaccess_all']"></td>
                       <td><input type="checkbox" class="check" name="permission['add_anytimeaccess']" ></td>
                       <td><input type="checkbox" class="check" name="permission['view_anytimeaccess']" ></td>
                       <td><input type="checkbox" class="check" name="permission['edit_anytimeaccess']"></td>
                       <td><input type="checkbox" class="check" name="permission['delete_anytimeaccess']"></td>
                      </tr>
                            <tr>
                       <th>Bank Details</th>
                       <td><input type="checkbox" class="check addall" name="permission['Bank_all']" ></td>
                        <td><input type="checkbox" class="check" name="permission['add_bank']"></td>
                       <td><input type="checkbox" class="check" name="permission['view_Bank']" ></td>
                       <td><input type="checkbox" class="check" name="permission['edit_Bank']" ></td>
                       <td><input type="checkbox" class="check" name="permission['delete_Bank']"></td>


                     </tr>
                      <tr>
                       <th>Expense Categories</th>
                       <td><input type="checkbox" class="check addall" name="permission['categories_all']" @if(isset($permission["'categories_all'"])) checked @endif></td>
                        <td><input type="checkbox" class="check" name="permission['add_categories']"></td>
                       <td><input type="checkbox" class="check" name="permission['view_categories']"></td>
                       <td><input type="checkbox" class="check" name="permission['edit_categories']"></td>
                       <td><input type="checkbox" class="check" name="permission['delete_categories']"></td>

                    
                     </tr>
                     <tr><th>Expenses</th>
                      <td><input type="checkbox" class="check addall" name="permission['expenses_all']" @if(isset($permission["'expenses_all'"])) checked @endif></td>
                       <td><input type="checkbox" class="check" name="permission['add_expenses']" ></td>
                       <td><input type="checkbox" class="check" name="permission['view_expenses']" ></td>
                       <td><input type="checkbox" class="check" name="permission['edit_expenses']"></td>
                       <td><input type="checkbox" class="check" name="permission['delete_expenses']"></td>

                      </tr>
                         <tr><th>Member Form</th>
                      <td><input type="checkbox" class="check addall" name="permission['memberform_all']" ></td>
                       <td><input type="checkbox" class="check" name="permission['add_memberform']" ></td>
                       <td><input type="checkbox" class="check" name="permission['view_memberform']" ></td>
                       <td><input type="checkbox" class="check" name="permission['edit_memberform']" ></td>
                       <td><input type="checkbox" class="check" name="permission['delete_memberform']" ></td>

                      </tr>
                         <tr><th>Trainer Profile</th>
                      <td><input type="checkbox" class="addall" name="permission['trainer_profile_all']"></td>

                      </tr>
                      <tr><th>Help Desk</th>
                      <td><input type="checkbox" class="addall" name="permission['helpdesk_all']" ></td>

                      </tr>
                    </tbody>
                  </table>
                </div>

                <div class="form-group">
                  <div class="col-sm-6">
                    <button type="submit" class="btn bg-green btn-block">Save</button>
                  </div>   
                  <div class="col-sm-6"> 
                    <a href="{{ url('roles') }}" class="btn btn-danger btn-block">Cancel</a>
                </div>
              </div>        

              </form></div><div class="col-lg-3"></div>
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
      if(count < 4){
        $(this).closest('tr').find('td:first').find('[type="checkbox"]').prop('checked', false);
      } else {
        $(this).closest('tr').find('td:first').find('[type="checkbox"]').prop('checked', true);

      }
    });
  });
</script>
@endpush