<div class="container-fluid" style="margin-top: 15px;">
<div class="row">
<div class="col-md-10" style="margin-top: 17px;">            
<h3 class="title-pages">Edit Post<span class="label label-default" style="font-size: 11px; float: right; right: 10px;">ID <?php echo $post['post_id']; ?></span></h3>

<form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

<div class="form-group" style="padding: 0px 10px 0px 0px;">

<input type="hidden" value="<?php echo $post['post_id']; ?>" name="post_id">

   <label class="control-label">Title</label>
   <input type="text" value="<?php echo $post['post_title']; ?>" placeholder="Title" name="post_title" class="form-control" required="">

   <label class="control-label">Description</label>
   <textarea value="" name="post_description" class="form-control" id="description" required=""><?php echo $post['post_description']; ?></textarea>

   <label class="control-label">Tag</label>
   <select class="form-control" name="post_tag" required>
   <option value="<?php echo $post['post_tag']; ?>" selected><?php echo $post['tag_title']; ?></option>
    <?php foreach($tags_lists as $tags_list): ?>
   <option value="<?php echo $tags_list['tag_id']; ?>"><?php echo $tags_list['tag_title']; ?></option>
    <?php endforeach; ?>
   </select>

   <label class="control-label">Featured</label>
   
   <div class="row">
                        <div class="col-sm-1">

                        <?php 


$in = '1';

if (strpos($in, $post['post_featured']) !== false) {
    echo '<div class="radio radio-success"> <input type="radio" name="post_featured" id="radio3" value="'. $post['post_featured'] .'" checked=""> <label for="radio3"> Yes </label> </div>';
}else{
  echo '<div class="radio radio-success"> <input type="radio" name="post_featured" id="radio3" value="' . $in .'"> <label for="radio3"> Yes </label> </div>';
}
                         ?>
                        </div>

                        <div class="col-sm-1">

                        <?php 


$out = '0';

if (strpos($out, $post['post_featured']) !== false) {
    echo '<div class="radio radio-danger"> <input type="radio" name="post_featured" id="radio4" value="0" checked=""> <label for="radio4"> No </label> </div>';
}else{
  echo '<div class="radio radio-danger"> <input type="radio" name="post_featured" id="radio4" value="'. $out .'"> <label for="radio4"> No </label> </div>';
}
                         ?>
                        </div>

                    </div>

<label class="control-label">Status</label>
   
   <div class="row">
                        <div class="col-sm-1">

                        <?php 


$true = '1';

if (strpos($true, $post['post_status']) !== false) {
    echo '<div class="radio radio-success"> <input type="radio" name="post_status" id="radio5" value="'. $post['post_status'] .'" checked=""> <label for="radio5"> Publish </label> </div>';
}else{
  echo '<div class="radio radio-success"> <input type="radio" name="post_status" id="radio5" value="' . $true .'"> <label for="radio5"> Publish </label> </div>';
}
                         ?>
                        </div>

                        <div class="col-sm-1">

                        <?php 


$false = '0';

if (strpos($false, $post['post_status']) !== false) {
    echo '<div class="radio radio-danger"> <input type="radio" name="post_status" id="radio6" value="0" checked=""> <label for="radio6"> Draft </label> </div>';
}else{
  echo '<div class="radio radio-danger"> <input type="radio" name="post_status" id="radio6" value="'. $false .'"> <label for="radio6"> Draft </label> </div>';
}
                         ?>
                        </div>

                    </div>

   <label class="control-label">Image: <a href="<?php echo SITE_URL ?>/images/<?php echo $post['post_image']; ?>" data-lightbox="image-1"><?php echo $post['post_image']; ?></a></label>
   <input name="post_image" class="input-file" type="file">
   <input type="hidden" value="<?php echo $post['post_image']; ?>" name="post_image_save">
   <span class="text-danger">Recommended size: <b>650 x 350 Pixels</b> </span>

   <div class="action-button">
   <input type="submit" name="update" value="Update" class="btn btn-embossed btn-primary">
   <a onclick="alertdelete();">
   <input name="trash" value="Delete" class="btn btn-embossed btn-danger" style="width: 80px;"></a>
    <script type="text/javascript">
   function alertdelete() {
   swal({ title: "Are you sure?", text: "You will not be able to recover this item!", type: "warning",cancelButtonClass: "btn-default btn-sm", showCancelButton: true, confirmButtonClass: "btn-danger btn-sm", confirmButtonText: "Yes, delete it!", closeOnConfirm: false }, function(){window.location.href = "<?php echo SITE_URL ?>/controller/delete_post.php?id=<?php echo $post['post_id']; ?>" });}
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
