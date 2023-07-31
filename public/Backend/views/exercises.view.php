<div class="container-fluid" style="margin-top: 15px;">
<div class="row">
<div class="col-md-10">

<h3 class="title-pages">Exercises</h3>

<script type="text/javascript">
  $(document).ready( function () {
    $('#table_id').DataTable();
} );
</script>
<style type="text/css">
  label{font-size: 13px;}
  th{border-bottom-width: 1px !important;}
</style>

<div class="panel-body" style="padding: 1px 10px 1px 1px;font-size: 13px;">
<table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%" style="border-radius: 5px;">
    <thead>
            <tr>
                <th>Id</th>
                <th>Image</th>
                <th>Title</th>
                <th>Bodyparts</th>
                <th>Equi.</th>
                <th>Level</th>
                <th>Reps</th>
                <th>Rest</th>
                <th>Sets</th>
                <th>Video</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Id</th>
                <th>Image</th>
                <th>Title</th>
                <th>Bodyparts</th>
                <th>Equi.</th>
                <th>Level</th>
                <th>Reps</th>
                <th>Rest</th>
                <th>Sets</th>
                <th>Video</th>
                <th>Actions</th>
            </tr>
        </tfoot>

        <tbody>
        <?php foreach($exercises as $exercise): ?>
            <tr>
              <td><?php echo $exercise['exercise_id']; ?></td>
                <td width="30px" align="center"><img src="../images/<?php echo $exercise['exercise_image']; ?>" style="width: 40px; height: 40px; padding: 2px;"></td>
                <td><div class="ellipsis" style="width: 100px"><?php echo $exercise['exercise_title']; ?></div></td>
                <td><div class="ellipsis" style="width: 80px"><?php echo $exercise['bodypart_title']; ?></div></td>
                <td><div class="ellipsis" style="width: 80px"><?php echo $exercise['equipment_title']; ?></div></td>
                <td><div class="ellipsis" style="width: 60px"><?php echo $exercise['level_title']; ?></div></td>
                <td><?php echo $exercise['exercise_reps']; ?></td>
                <td><?php echo $exercise['exercise_rest']; ?></td>
                <td><?php echo $exercise['exercise_sets']; ?></td>
                <td><div class="ellipsis" style="width: 200px"><?php echo $exercise['exercise_video']; ?></div></td>
                <td>
                <a href="../controller/edit_exercise.php?id=<?php echo $exercise['exercise_id']; ?>" style="font-size: 14px;color: #000000;"><i class="fa fa-cog"></i></a>
          <a onclick="alertdelete_<?php echo $exercise['exercise_id']; ?>();" style="cursor: pointer;font-size: 14px;color: #000000;"><i class="fa fa-trash-o"></i></a>
              <script type="text/javascript">
  function alertdelete_<?php echo $exercise['exercise_id']; ?>() {
  swal({ title: "Are you sure?", text: "You will not be able to recover this item!", type: "warning",cancelButtonClass: "btn-default btn-sm", showCancelButton: true, confirmButtonClass: "btn-danger btn-sm", confirmButtonText: "Yes, delete it!", closeOnConfirm: false }, function(){window.location.href = "<?php echo SITE_URL ?>/controller/delete_exercise.php?id=<?php echo $exercise['exercise_id']; ?>" });}
  </script>
          </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
</table>

</div>
</div>
<div class="col-md-2">   
<?php require'sidebar.view.php'; ?>  
</div>
</div>
</div>