<div class="container-fluid" style="margin-top: 15px;">
<div class="row">
<div class="col-md-10" style="margin-top: 17px;">            
<h3 class="title-pages">Edit Bodypart<span class="label label-default" style="font-size: 11px; float: right; right: 10px;">ID <?php echo $bodypart['bodypart_id']; ?></span></h3>

<form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

<div class="form-group" style="padding: 0px 10px 0px 0px;">

   <input type="hidden" value="<?php echo $bodypart['bodypart_id']; ?>" name="bodypart_id">
   <label class="control-label">Title</label>
   <input type="text" value="<?php echo $bodypart['bodypart_title']; ?>" placeholder="" name="bodypart_title" class="form-control" required="">

   <label class="control-label">Image: <a href="<?php echo SITE_URL ?>/images/<?php echo $bodypart['bodypart_image']; ?>" data-lightbox="image-1"><?php echo $bodypart['bodypart_image']; ?></a></label>
   <input name="bodypart_image" class="input-file" type="file">
   <input type="hidden" value="<?php echo $bodypart['bodypart_image']; ?>" name="bodypart_image_save">
   <span class="text-danger">Recommended size: <b>250 x 250 Pixels</b> </span>

   <div class="action-button">
   <input type="submit" name="update" value="Update" class="btn btn-embossed btn-primary">
   <a onclick="alertdelete();">
   <input name="trash" value="Delete" class="btn btn-embossed btn-danger" style="width: 80px;"></a>
    <script type="text/javascript">
   function alertdelete() {
   swal({ title: "Are you sure?", text: "You will not be able to recover this item!", type: "warning",cancelButtonClass: "btn-default btn-sm", showCancelButton: true, confirmButtonClass: "btn-danger btn-sm", confirmButtonText: "Yes, delete it!", closeOnConfirm: false }, function(){window.location.href = "<?php echo SITE_URL ?>/controller/delete_bodypart.php?id=<?php echo $bodypart['bodypart_id']; ?>" });}
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
