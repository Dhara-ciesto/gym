<div class="container-fluid" style="margin-top: 15px;">
<div class="row">
<div class="col-md-10" style="margin-top: 17px;">            
<h3 class="title-pages">Edit Recipe<span class="label label-default" style="font-size: 11px; float: right; right: 10px;">ID <?php echo $diet['diet_id']; ?></span></h3>

<form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

<div class="form-group" style="padding: 0px 10px 0px 0px;">

<input type="hidden" value="<?php echo $diet['diet_id']; ?>" name="diet_id">

   <label class="control-label">Title</label>
   <input type="text" value="<?php echo $diet['diet_title']; ?>" placeholder="Title" name="diet_title" class="form-control" required="">

   <label class="control-label">Description</label>
   <textarea value="" name="diet_description" class="form-control" id="description" required=""><?php echo $diet['diet_description']; ?></textarea>

   <label class="control-label">Ingredients</label>
   <textarea value="" name="diet_ingredients" class="form-control" id="ingredients" required=""><?php echo $diet['diet_ingredients']; ?></textarea>

   <label class="control-label">Directions</label>
   <textarea value="" name="diet_directions" class="form-control" id="directions" required=""><?php echo $diet['diet_directions']; ?></textarea>

   <label class="control-label">Category</label>
   <select class="form-control" name="diet_category" required>
   <option value="<?php echo $diet['diet_category']; ?>" selected><?php echo $diet['category_title']; ?></option>
    <?php foreach($categories_lists as $categories_list): ?>
   <option value="<?php echo $categories_list['category_id']; ?>"><?php echo $categories_list['category_title']; ?></option>
    <?php endforeach; ?>
   </select>

   <label class="control-label">Calories</label>
   <input type="text" value="<?php echo $diet['diet_calories']; ?>" placeholder="Calories" name="diet_calories" class="form-control" required="">

   <label class="control-label">Carbs</label>
   <input type="text" value="<?php echo $diet['diet_carbs']; ?>" placeholder="Carbs (Grams)" name="diet_carbs" class="form-control" required="">

   <label class="control-label">Protein</label>
   <input type="text" value="<?php echo $diet['diet_protein']; ?>" placeholder="Protein (Grams)" name="diet_protein" class="form-control" required="">

   <label class="control-label">Fat</label>
   <input type="text" value="<?php echo $diet['diet_fat']; ?>" placeholder="Fat (Grams)" name="diet_fat" class="form-control" required="">

      <label class="control-label">Servings</label>
   <input type="text" value="<?php echo $diet['diet_servings']; ?>" placeholder="Servings" name="diet_servings" class="form-control" required="">

      <label class="control-label">Total Time</label>
   <input type="text" value="<?php echo $diet['diet_time']; ?>" placeholder="Total Time (Minutes)" name="diet_time" class="form-control" required="">

<label class="control-label">Featured</label>
   
   <div class="row">
                        <div class="col-sm-1">

                        <?php 


$in = '1';

if (strpos($in, $diet['diet_featured']) !== false) {
    echo '<div class="radio radio-success"> <input type="radio" name="diet_featured" id="radio3" value="'. $diet['diet_featured'] .'" checked=""> <label for="radio3"> Yes </label> </div>';
}else{
  echo '<div class="radio radio-success"> <input type="radio" name="diet_featured" id="radio3" value="' . $in .'"> <label for="radio3"> Yes </label> </div>';
}
                         ?>
                        </div>

                        <div class="col-sm-1">

                        <?php 


$out = '0';

if (strpos($out, $diet['diet_featured']) !== false) {
    echo '<div class="radio radio-danger"> <input type="radio" name="diet_featured" id="radio4" value="0" checked=""> <label for="radio4"> No </label> </div>';
}else{
  echo '<div class="radio radio-danger"> <input type="radio" name="diet_featured" id="radio4" value="'. $out .'"> <label for="radio4"> No </label> </div>';
}
                         ?>
                        </div>

                    </div>

<label class="control-label">Status</label>
   
   <div class="row">
                        <div class="col-sm-1">

                        <?php 


$true = '1';

if (strpos($true, $diet['diet_status']) !== false) {
    echo '<div class="radio radio-success"> <input type="radio" name="diet_status" id="radio5" value="'. $diet['diet_status'] .'" checked=""> <label for="radio5"> Publish </label> </div>';
}else{
  echo '<div class="radio radio-success"> <input type="radio" name="diet_status" id="radio5" value="' . $true .'"> <label for="radio5"> Publish </label> </div>';
}
                         ?>
                        </div>

                        <div class="col-sm-1">

                        <?php 


$false = '0';

if (strpos($false, $diet['diet_status']) !== false) {
    echo '<div class="radio radio-danger"> <input type="radio" name="diet_status" id="radio6" value="0" checked=""> <label for="radio6"> Draft </label> </div>';
}else{
  echo '<div class="radio radio-danger"> <input type="radio" name="diet_status" id="radio6" value="'. $false .'"> <label for="radio6"> Draft </label> </div>';
}
                         ?>
                        </div>

                    </div>

   <label class="control-label">Image: <a href="<?php echo SITE_URL ?>/images/<?php echo $diet['diet_image']; ?>" data-lightbox="image-1"><?php echo $diet['diet_image']; ?></a></label>
   <input name="diet_image" class="input-file" type="file">
   <input type="hidden" value="<?php echo $diet['diet_image']; ?>" name="diet_image_save">
   <span class="text-danger">Recommended size: <b>650 x 350 Pixels</b> </span>

   <div class="action-button">
   <input type="submit" name="update" value="Update" class="btn btn-embossed btn-primary">
   <a onclick="alertdelete();">
   <input name="trash" value="Delete" class="btn btn-embossed btn-danger" style="width: 80px;"></a>
    <script type="text/javascript">
   function alertdelete() {
   swal({ title: "Are you sure?", text: "You will not be able to recover this item!", type: "warning",cancelButtonClass: "btn-default btn-sm", showCancelButton: true, confirmButtonClass: "btn-danger btn-sm", confirmButtonText: "Yes, delete it!", closeOnConfirm: false }, function(){window.location.href = "<?php echo SITE_URL ?>/controller/delete_diet.php?id=<?php echo $diet['diet_id']; ?>" });}
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

<script type="text/javascript"> CKEDITOR.replace( 'description' ); </script>
<script type="text/javascript"> CKEDITOR.replace( 'ingredients' ); </script>
<script type="text/javascript"> CKEDITOR.replace( 'directions' ); </script>
