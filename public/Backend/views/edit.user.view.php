<div class="container-fluid" style="margin-top: 15px;">
<div class="row">

<div class="col-md-10" style="margin-top: 17px;">            
<h3 class="title-pages">Edit User<span class="label label-default" style="font-size: 11px; float: right; right: 10px;">ID <?php echo $user['user_id']; ?></span></h3>

<form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

<div class="form-group" style="padding: 0px 10px 0px 0px;">

   <input type="hidden" value="<?php echo $user['user_id']; ?>" name="user_id">
   <label class="control-label">Name</label>
   <input type="text" value="<?php echo $user['user_name']; ?>" placeholder="" name="user_name" class="form-control" required="">

      <label class="control-label">Goal</label>
   <input type="text" value="<?php echo $user['user_goal']; ?>" placeholder="" name="user_goal" class="form-control" required="">

      <label class="control-label">Weight</label>
   <input type="text" value="<?php echo $user['user_weight']; ?>" placeholder="" name="user_weight" class="form-control" required="">

      <label class="control-label">Age</label>
   <input type="text" value="<?php echo $user['user_age']; ?>" placeholder="" name="user_age" class="form-control" required="">

      <label class="control-label">Gender</label>
   <input type="text" value="<?php echo $user['user_gender']; ?>" placeholder="" name="user_gender" class="form-control" required="">

      <label class="control-label">Height</label>
   <input type="text" value="<?php echo $user['user_height']; ?>" placeholder="" name="user_height" class="form-control" required="">

   <label class="control-label">Email</label>
   <input type="text" value="<?php echo $user['user_email']; ?>" placeholder="" name="user_email" class="form-control" required="">

   <label class="control-label">Password</label>
   <input type="text" value="HIDDEN IN THE DEMO" placeholder="" name="user_password" class="form-control" required="">

<label class="control-label">Status</label>
   
   <div class="row">
                        <div class="col-sm-2">

                        <?php 


$true = '1';

if (strpos($true, $user['user_status']) !== false) {
    echo '<div class="radio radio-success"> <input type="radio" name="user_status" id="radio5" value="'. $user['user_status'] .'" checked=""> <label for="radio5"> Unban User </label> </div>';
}else{
  echo '<div class="radio radio-success"> <input type="radio" name="user_status" id="radio5" value="' . $true .'"> <label for="radio5"> Unban User </label> </div>';
}
                         ?>
                        </div>

                        <div class="col-sm-2">

                        <?php 


$false = '0';

if (strpos($false, $user['user_status']) !== false) {
    echo '<div class="radio radio-danger"> <input type="radio" name="user_status" id="radio6" value="0" checked=""> <label for="radio6"> Ban User </label> </div>';
}else{
  echo '<div class="radio radio-danger"> <input type="radio" name="user_status" id="radio6" value="'. $false .'"> <label for="radio6"> Ban User </label> </div>';
}
                         ?>
                        </div>

                    </div>

   <div class="action-button">
   <input type="submit" name="update" value="Update" class="btn btn-embossed btn-primary">
   <a onclick="alertdelete();">
   <input name="trash" value="Delete" class="btn btn-embossed btn-danger" style="width: 80px;"></a>
    <script type="text/javascript">
   function alertdelete() {
   swal({ title: "Are you sure?", text: "You will not be able to recover this item!", type: "warning",cancelButtonClass: "btn-default btn-sm", showCancelButton: true, confirmButtonClass: "btn-danger btn-sm", confirmButtonText: "Yes, delete it!", closeOnConfirm: false }, function(){window.location.href = "<?php echo SITE_URL ?>/controller/delete_user.php?id=<?php echo $user['user_id']; ?>" });}
   </script>
   </div>


</div>
</form>  
</div>
<div class="col-md-2 page-sidebar">    
<?php require'sidebar.view.php'; ?>  
</div>
</div>
</div>
