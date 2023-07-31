<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Recently added</h3></div>
<div class="panel-body">
<ul class="list-group">
<?php foreach($recents as $recent): ?>
	<a href="<?php echo SITE_URL ?>/controller/edit_place.php?id=<?php echo $recent['place_id']; ?>">
  <li class="list-group-item"><i class="glyphicon glyphicon-plus"></i> <?php echo $recent['place_name']; ?> <span>ID <?php echo $recent['place_id']; ?></span></li></a>
<?php endforeach; ?>
</ul></div></div>