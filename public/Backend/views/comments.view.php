<div class="container-fluid" style="margin-top: 15px;">
<div class="row">
<div class="col-md-10">

<h3 class="title-pages">Comments</h3>


<script type="text/javascript">
    $(document).ready( function () {
    $('#table_id').dataTable( {
  "pageLength": 50
} );

} );
</script>
<style type="text/css">
	label{font-size: 13px;}
	th{border-bottom-width: 1px !important;}
	.view-button{border: 1px solid; border-radius: 4px; padding: 1px 7px; cursor: pointer; width: 100%; display: inline; text-align: center; border-color: #000000; color: #000000; font-size: 11px;}
	.view-button:hover{color: #000000; border-color: #000000;}

</style>

<div class="panel-body" style="padding: 1px 10px 1px 1px;font-size: 13px;">
<table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%" style="border-radius: 5px;">
    <thead>
            <tr>
            	<th>Id</th>
                <th>User</th>
                <th>Post</th>
                <th>Comment</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
            	<th>Id</th>
                <th>User</th>
                <th>Post</th>
                <th>Comment</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </tfoot>

        <tbody>
        <?php foreach($comments as $comment): ?>
            <tr>
            	<td><?php echo $comment['comment_id']; ?></td>
                <td><?php echo $comment['name']; ?></td>
                <td><?php echo "<a href='../controller/edit_post.php?id=".$comment['comment_post']."'>"; ?><?php echo $comment['comment_post']; ?></td>
                <td><?php echo $comment['comment_content']; ?></td>
                <td><?php echo time_ago($comment['comment_date']); ?></td>
                <td>
                <?php $status = $comment['comment_verified']; if ($status == '1') {
                  echo "<span class='true'></span>";
                }else{ echo "<span class='false'></span>"; } ?></td>
              
                <td>

                
                <a onclick="alertdelete_<?php echo $comment['comment_id']; ?>();" style="cursor: pointer;font-size: 14px;color: #000000;"><i class="fa fa-trash-o"></i></a>
                    <script type="text/javascript">
  function alertdelete_<?php echo $comment['comment_id']; ?>() {
  swal({ title: "Are you sure?", text: "You will not be able to recover this item!", type: "warning",cancelButtonClass: "btn-default btn-sm", showCancelButton: true, confirmButtonClass: "btn-danger btn-sm", confirmButtonText: "Yes, delete it!", closeOnConfirm: false }, function(){window.location.href = "<?php echo SITE_URL ?>/controller/delete_comment.php?id=<?php echo $comment['comment_id']; ?>" });}
  </script>
  
                <?php
                $approve = "<a style='font-size: 14px;color: #2ecc71;' href='../controller/approve_comment.php?id=".$comment['comment_id']."'><i class='fa fa-check'></i></a>";
                ?>

                <?php $status = $comment['comment_verified']; if ($status == '0') {
                  echo $approve;
                } ?>

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


</div>