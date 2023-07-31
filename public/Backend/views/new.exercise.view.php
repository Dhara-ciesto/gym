<div class="container-fluid" style="margin-top: 15px;">
<div class="row">
<div class="col-md-10" style="margin-top: 17px;">            

<h3 class="title-pages">Exercise</h3>

<form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

<div class="form-group" style="padding: 0px 10px 0px 0px;">

 <label class="control-label">Title</label>
   <input type="text" value="" maxlength="80" placeholder="Title" name="exercise_title" class="form-control" required="">

   <label class="control-label">Bodypart</label>
   <select multiple="multiple" class="my-select form-control" name="bodypart_id[]" required="">
    <?php foreach($bodyparts_lists as $bodyparts_list): ?>
   <option data-img-src="<?php echo SITE_URL ?>/images/<?php echo $bodyparts_list['bodypart_image']; ?>" value="<?php echo $bodyparts_list['bodypart_id']; ?>"><?php echo $bodyparts_list['bodypart_title']; ?></option>
    <?php endforeach; ?>
   </select>

   <label class="control-label">Equipment</label>
   <select class="form-control" name="exercise_equipment" required="">
    <?php foreach($equipments_lists as $equipments_list): ?>
   <option value="<?php echo $equipments_list['equipment_id']; ?>"><?php echo $equipments_list['equipment_title']; ?></option>
    <?php endforeach; ?>
   </select>

   <label class="control-label">Level</label>
   <select class="form-control" name="exercise_level" required="">
    <?php foreach($levels_lists as $levels_list): ?>
   <option value="<?php echo $levels_list['level_id']; ?>"><?php echo $levels_list['level_title']; ?></option>
    <?php endforeach; ?>
   </select>

   <label class="control-label">Rest</label>
   <input type="text" value="" placeholder="Rest" name="exercise_rest" class="form-control" required="">

   <label class="control-label">Sets</label>
   <input type="text" value="" placeholder="Sets" name="exercise_sets" class="form-control" required="">

   <label class="control-label">Reps</label>
   <input type="text" value="" placeholder="Reps" name="exercise_reps" class="form-control" required="">

   <label class="control-label">Video Url (MP4)</label>
   <input type="text" value="" placeholder="Video Url (MP4)" name="exercise_video" class="form-control" required="">

   <label class="control-label">Instructions</label>
   <textarea value="" name="exercise_instructions" class="form-control" id="instructions" required=""></textarea>

   <label class="control-label">Tips</label>
   <textarea value="" name="exercise_tips" class="form-control" id="tips" required=""></textarea>

   <label class="control-label">Image</label>
   <input name="exercise_image" class="input-file" type="file" required="">
   <span class="text-danger">Recommended size: <b>550 x 300 Pixels</b> </span>

   <div class="action-button">
   <input type="submit" name="save" value="Upload" class="btn btn-embossed btn-primary">
   <input type="reset" name="reset" value="Reset" class="btn btn-embossed btn-danger">
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
