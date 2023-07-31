<div class="container-fluid" style="margin-top: 15px;">
<div class="row">
<div class="col-md-10" style="margin-top: 17px;">            
<h3 class="title-pages">Edit Exercise<span class="label label-default" style="font-size: 11px; float: right; right: 10px;">ID <?php echo $exercise['exercise_id']; ?></span></h3>

<form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

<div class="form-group" style="padding: 0px 10px 0px 0px;">

<input type="hidden" value="<?php echo $exercise['exercise_id']; ?>" name="exercise_id">

   <input type="hidden" value="<?php echo $exercise['exercise_id']; ?>" name="exercise_id">
   <label class="control-label">Title</label>
   <input type="text" maxlength="80" value="<?php echo $exercise['exercise_title']; ?>" name="exercise_title" class="form-control" required>
  
   
   <label class="control-label">Bodypart</label>
   <select multiple="multiple" class="my-select form-control" name="bodypart_id[]" required>

 <?php foreach($bodyparts_selected as $bodypart_selected): ?>

  <option data-img-src="<?php echo SITE_URL ?>/images/<?php echo $bodypart_selected['bodypart_image']; ?>" value="<?php echo $bodypart_selected['bodypart_id']; ?>" selected><?php echo $bodypart_selected['bodypart_title']; ?></option>

<?php endforeach; ?>

<?php foreach($bodyparts_not_selected as $bodypart_not_selected): ?>
<option data-img-src="<?php echo SITE_URL ?>/images/<?php echo $bodypart_not_selected['bodypart_image']; ?>" value="<?php echo $bodypart_not_selected['bodypart_id']; ?>"><?php echo $bodypart_not_selected['bodypart_title']; ?></option>
<?php endforeach; ?>


</select>


   <label class="control-label">Equipment</label>
   <select class="form-control" name="exercise_equipment" required>
   <option value="<?php echo $exercise['exercise_equipment']; ?>" selected><?php echo $exercise['equipment_title']; ?></option>
    <?php foreach($equipments_lists as $equipment_list): ?>
   <option value="<?php echo $equipment_list['equipment_id']; ?>"><?php echo $equipment_list['equipment_title']; ?></option>
    <?php endforeach; ?>
   </select>

      <label class="control-label">Level</label>
   <select class="form-control" name="exercise_level" required>
   <option value="<?php echo $exercise['exercise_level']; ?>" selected><?php echo $exercise['level_title']; ?></option>
    <?php foreach($levels_lists as $level_list): ?>
   <option value="<?php echo $level_list['level_id']; ?>"><?php echo $level_list['level_title']; ?></option>
    <?php endforeach; ?>
   </select>


   <label class="control-label">Rest</label>
   <input value="<?php echo $exercise['exercise_rest']; ?>" placeholder="Rest" name="exercise_rest" class="form-control" required="">

   <label class="control-label">Sets</label>
   <input value="<?php echo $exercise['exercise_sets']; ?>" placeholder="Sets" name="exercise_sets" class="form-control" required="">

   <label class="control-label">Reps</label>
   <input value="<?php echo $exercise['exercise_reps']; ?>" placeholder="Reps" name="exercise_reps" class="form-control" required="">

   <label class="control-label">Video Url (MP4)</label>
   <input type="text" value="www.video-example.com/exercise/<?php echo $exercise['exercise_id']; ?>.mp4" placeholder="Video Url (MP4)" name="exercise_video" class="form-control" required="">

   <label class="control-label">Instructions</label>
   <textarea value="" name="exercise_instructions" class="form-control" id="instructions" required=""><?php echo $exercise['exercise_instructions']; ?></textarea>

   <label class="control-label">Tips</label>
   <textarea value="" name="exercise_tips" class="form-control" id="tips" required=""><?php echo $exercise['exercise_tips']; ?></textarea>

   <label class="control-label">Image: <a href="<?php echo SITE_URL ?>/images/<?php echo $exercise['exercise_image']; ?>" data-lightbox="image-1"><?php echo $exercise['exercise_image']; ?></a></label>
   <input name="exercise_image" class="input-file" type="file">
   <input type="hidden" value="<?php echo $exercise['exercise_image']; ?>" name="exercise_image_save">
   <span class="text-danger">Recommended size: <b>650 x 350 Pixels</b> </span>

   <div class="action-button">
   <input type="submit" name="update" value="Update" class="btn btn-embossed btn-primary">
   <a onclick="alertdelete();">
   <input name="trash" value="Delete" class="btn btn-embossed btn-danger" style="width: 80px;"></a>
    <script type="text/javascript">
   function alertdelete() {
   swal({ title: "Are you sure?", text: "You will not be able to recover this item!", type: "warning",cancelButtonClass: "btn-default btn-sm", showCancelButton: true, confirmButtonClass: "btn-danger btn-sm", confirmButtonText: "Yes, delete it!", closeOnConfirm: false }, function(){window.location.href = "<?php echo SITE_URL ?>/controller/delete_exercise.php?id=<?php echo $exercise['exercise_id']; ?>" });}
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

<script type="text/javascript"> CKEDITOR.replace( 'tips' ); </script>
<script type="text/javascript"> CKEDITOR.replace( 'instructions' ); </script>
