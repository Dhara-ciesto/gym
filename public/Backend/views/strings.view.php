<div class="container-fluid" style="margin-top: 15px;">
<div class="row">
<div class="col-md-10" style="padding-left: 15px;">            

<h3 class="title-pages">Strings</h3>

<style type="text/css">
  #settings input{
    margin-bottom: 5px; margin-top: 5px;
  }
</style>

<form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

  <div class="panel-body" style="padding: 1px 10px 1px 1px;font-size: 13px;">

   <label class="control-label">Privacy Policy</label>
   <textarea type="text" class="form-control" name="st_privacypolicy" id="textarea1"><?php echo $strings['st_privacypolicy']; ?></textarea>
<br>
   <label class="control-label">Terms of Service</label>
   <textarea type="text" class="form-control" name="st_termsofservice" id="textarea2"><?php echo $strings['st_termsofservice']; ?></textarea>
<br>
      <label class="control-label">About Us</label>
   <textarea type="text" class="form-control" name="st_aboutus" id="textarea3"><?php echo $strings['st_aboutus']; ?></textarea>

</div>

<div class="action-button">
   <input type="submit" name="save" value="Save Changes" class="btn btn-embossed btn-primary">
   </div>

</form>  
</div>
<div class="col-md-2 page-sidebar"> 
<?php require'sidebar.view.php'; ?>  
</div>
</div>
</div>

<script> CKEDITOR.replace( 'textarea1' ); </script>
<script> CKEDITOR.replace( 'textarea2' ); </script>
<script> CKEDITOR.replace( 'textarea3' ); </script>
