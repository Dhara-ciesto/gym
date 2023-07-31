<div class="container-fluid" style="margin-top: 15px;">
<div class="row">
<div class="col-md-10" id="home">            
<div class="container-fluid">
<div class="row-top row">

<a href="<?php echo SITE_URL; ?>/controller/equipments.php"><div class="col-md-16 col-sm-3">
<div class="info-box bg-green">
<span class="info-box-icon bg-icon-green"><i class="glyphicon"><img src="<?php echo SITE_URL ?>/files/10.svg"></i></span>
<div class="info-box-content">
<span class="info-box-text">Equipments</span>
<span class="info-box-number"><?php echo $equipments_total; ?></span></div>
</div></div></a>

<a href="<?php echo SITE_URL; ?>/controller/goals.php"><div class="col-md-16 col-sm-3">
<div class="info-box bg-green">
<span class="info-box-icon bg-icon-green"><i class="glyphicon"><img src="<?php echo SITE_URL ?>/files/15.svg"></i></span>
<div class="info-box-content">
<span class="info-box-text">Goals</span>
<span class="info-box-number"><?php echo $goals_total; ?></span></div>
</div></div></a>

<a href="<?php echo SITE_URL; ?>/controller/levels.php"><div class="col-md-16 col-sm-3">
<div class="info-box bg-green">
<span class="info-box-icon bg-icon-green"><i class="glyphicon"><img src="<?php echo SITE_URL ?>/files/16.svg"></i></span>
<div class="info-box-content">
<span class="info-box-text">Levels</span>
<span class="info-box-number"><?php echo $levels_total; ?></span></div>
</div></div></a>

<a href="<?php echo SITE_URL; ?>/controller/categories.php"><div class="col-md-16 col-sm-3">
<div class="info-box bg-green">
<span class="info-box-icon bg-icon-green"><i class="glyphicon"><img src="<?php echo SITE_URL ?>/files/13.svg"></i></span>
<div class="info-box-content">
<span class="info-box-text">Category Diets</span>
<span class="info-box-number"><?php echo $categories_total; ?></span></div>
</div></div></a>

<a href="<?php echo SITE_URL; ?>/controller/bodyparts.php"><div class="col-md-16 col-sm-3">
<div class="info-box bg-green">
<span class="info-box-icon bg-icon-green"><i class="glyphicon"><img src="<?php echo SITE_URL ?>/files/3.svg"></i></span>
<div class="info-box-content">
<span class="info-box-text">Bodyparts</span>
<span class="info-box-number"><?php echo $bodyparts_total; ?></span></div>
</div></div></a>

<a href="<?php echo SITE_URL; ?>/controller/recipes.php"><div class="col-md-16 col-sm-3">
<div class="info-box bg-green">
<span class="info-box-icon bg-icon-green"><i class="glyphicon"><img src="<?php echo SITE_URL ?>/files/6.svg"></i></span>
<div class="info-box-content">
<span class="info-box-text">Recipes</span>
<span class="info-box-number"><?php echo $diets_total; ?></span></div>
</div></div></a>

<a href="<?php echo SITE_URL; ?>/controller/exercises.php"><div class="col-md-16 col-sm-3">
<div class="info-box bg-green">
<span class="info-box-icon bg-icon-green"><i class="glyphicon"><img src="<?php echo SITE_URL ?>/files/1.svg"></i></span>
<div class="info-box-content">
<span class="info-box-text">Exercises</span>
<span class="info-box-number"><?php echo $exercises_total; ?></span></div>
</div></div></a>

<a href="<?php echo SITE_URL; ?>/controller/workouts.php"><div class="col-md-16 col-sm-3">
<div class="info-box bg-green">
<span class="info-box-icon bg-icon-green"><i class="glyphicon"><img src="<?php echo SITE_URL ?>/files/11.svg"></i></span>
<div class="info-box-content">
<span class="info-box-text">Workouts</span>
<span class="info-box-number"><?php echo $workouts_total; ?></span></div>
</div></div></a>

<a href="<?php echo SITE_URL; ?>/controller/tags.php"><div class="col-md-16 col-sm-3">
<div class="info-box bg-green">
<span class="info-box-icon bg-icon-green"><i class="glyphicon"><img src="<?php echo SITE_URL ?>/files/12.svg"></i></span>
<div class="info-box-content">
<span class="info-box-text">Tags</span>
<span class="info-box-number"><?php echo $tags_total; ?></span></div>
</div></div></a>

<a href="<?php echo SITE_URL; ?>/controller/posts.php"><div class="col-md-16 col-sm-3">
<div class="info-box bg-green">
<span class="info-box-icon bg-icon-green"><i class="glyphicon"><img src="<?php echo SITE_URL ?>/files/22.svg"></i></span>
<div class="info-box-content">
<span class="info-box-text">Posts</span>
<span class="info-box-number"><?php echo $posts_total; ?></span></div>
</div></div></a>

<a href="<?php echo SITE_URL; ?>/controller/quotes.php"><div class="col-md-16 col-sm-3">
<div class="info-box bg-green">
<span class="info-box-icon bg-icon-green"><i class="glyphicon"><img src="<?php echo SITE_URL ?>/files/20.svg"></i></span>
<div class="info-box-content">
<span class="info-box-text">Quotes</span>
<span class="info-box-number"><?php echo $quotes_total; ?></span></div>
</div></div></a>

</div>

   <div class="row">
   <div class="col-sm-6" style="padding-left: 5px; padding-right: 5px;margin-bottom: 6px;">

   	<div class="panel panel-default" style="border-color: #f3e9f9;">
  	<div class="panel-heading panel-heading-custom">
  	<i class="fa fa-bars"></i> Exercises
  	<a href="<?php echo SITE_URL; ?>/controller/exercises.php" style="float: right; margin: 7px auto;font-size: 11px;">
  	View All <img class="panel-icon-right" src="../files/right.svg"/>
  	</a>
  	</div>
  	<div class="panel-body">   

  	<div class="list-items">
  	
  	<?php foreach(array_slice($exercises, 0, 5) as $exercise): ?>
  	<div class="list-item">
    <img src="<?php echo SITE_URL ?>/images/<?php echo $exercise['exercise_image']; ?>">
    <h6><?php echo $exercise['exercise_title']; ?></h6>

    <div class="list-item-actions">

    	<a href="<?php echo SITE_URL ?>/controller/edit_exercise.php?id=<?php echo $exercise['exercise_id']; ?>"><i class="fa fa-cog"></i></a>
    	<a onclick="alertdelete_<?php echo $exercise['exercise_id']; ?>();"><i class="fa fa-trash-o"></i></a>

    </div>
    </div>

        <script type="text/javascript">
  function alertdelete_<?php echo $exercise['exercise_id']; ?>() {
  swal({ title: "Are you sure?", text: "You will not be able to recover this item!", type: "warning",cancelButtonClass: "btn-default btn-sm", showCancelButton: true, confirmButtonClass: "btn-danger btn-sm", confirmButtonText: "Yes, delete it!", closeOnConfirm: false }, function(){window.location.href = "<?php echo SITE_URL ?>/controller/delete_exercise.php?id=<?php echo $exercise['exercise_id']; ?>" });}
  </script>
  
    <?php endforeach; ?>
    
    </div>

  	</div>
	</div>

   </div>

<div class="col-sm-6" style="padding-left: 5px; padding-right: 5px;margin-bottom: 6px;">

   	<div class="panel panel-default" style="border-color: #f3e9f9;">
  	<div class="panel-heading panel-heading-custom">
  	<i class="fa fa-bars"></i> Posts
  	<a href="<?php echo SITE_URL; ?>/controller/posts.php" style="float: right; margin: 7px auto;font-size: 11px;">
  	View All <img class="panel-icon-right" src="../files/right.svg"/>
  	</a>
  	</div>
  	<div class="panel-body">   

  	<div class="list-items">
  	
  	<?php foreach(array_slice($posts, 0, 5) as $post): ?>
  	<div class="list-item">
    <img src="<?php echo SITE_URL ?>/images/<?php echo $post['post_image']; ?>">
    <h6><?php echo $post['post_title']; ?></h6>

    <div class="list-item-actions">

    	<a href="<?php echo SITE_URL ?>/controller/edit_post.php?id=<?php echo $post['post_id']; ?>"><i class="fa fa-cog"></i></a>
    	<a onclick="alertdelete_<?php echo $post['post_id']; ?>();"><i class="fa fa-trash-o"></i></a>

    </div>
    </div>

        <script type="text/javascript">
  function alertdelete_<?php echo $post['post_id']; ?>() {
  swal({ title: "Are you sure?", text: "You will not be able to recover this item!", type: "warning",cancelButtonClass: "btn-default btn-sm", showCancelButton: true, confirmButtonClass: "btn-danger btn-sm", confirmButtonText: "Yes, delete it!", closeOnConfirm: false }, function(){window.location.href = "<?php echo SITE_URL ?>/controller/delete_post.php?id=<?php echo $post['post_id']; ?>" });}
  </script>
  
    <?php endforeach; ?>
    
    </div>

  	</div>
	</div>

   </div>

   </div>

<div class="row">
         <div class="col-sm-6" style="padding-left: 5px; padding-right: 5px; margin-bottom: 6px;">

      <div class="panel panel-default" style="border-color: #f3e9f9;">
    <div class="panel-heading panel-heading-custom">
    <i class="fa fa-bars"></i> Workouts
    <a href="<?php echo SITE_URL; ?>/controller/workouts.php" style="float: right; margin: 7px auto;font-size: 11px;">
    View All <img class="panel-icon-right" src="../files/right.svg"/>
    </a>
    </div>
    <div class="panel-body">   

    <div class="list-items">
    
    <?php foreach(array_slice($workouts, 0, 5) as $workout): ?>
    <div class="list-item">
    <img src="<?php echo SITE_URL ?>/images/<?php echo $workout['workout_image']; ?>">
    <h6><?php echo $workout['workout_title']; ?></h6>

    <div class="list-item-actions">

      <a href="<?php echo SITE_URL ?>/controller/edit_workout.php?id=<?php echo $workout['workout_id']; ?>"><i class="fa fa-cog"></i></a>
      <a onclick="alertdelete_<?php echo $workout['workout_id']; ?>();"><i class="fa fa-trash-o"></i></a>

    </div>
    </div>

        <script type="text/javascript">
  function alertdelete_<?php echo $workout['workout_id']; ?>() {
  swal({ title: "Are you sure?", text: "You will not be able to recover this item!", type: "warning",cancelButtonClass: "btn-default btn-sm", showCancelButton: true, confirmButtonClass: "btn-danger btn-sm", confirmButtonText: "Yes, delete it!", closeOnConfirm: false }, function(){window.location.href = "<?php echo SITE_URL ?>/controller/delete_workout.php?id=<?php echo $workout['workout_id']; ?>" });}
  </script>
  
    <?php endforeach; ?>
    
    </div>

    </div>
  </div>

   </div>

   <div class="col-sm-6" style="padding-left: 5px; padding-right: 5px;margin-bottom: 6px;">

   	<div class="panel panel-default" style="border-color: #f3e9f9;">
  	<div class="panel-heading panel-heading-custom">
  	<i class="fa fa-bars"></i> Recipes
  	<a href="<?php echo SITE_URL; ?>/controller/recipes.php" style="float: right; margin: 7px auto;font-size: 11px;">
  	View All <img class="panel-icon-right" src="../files/right.svg"/>
  	</a>
  	</div>
  	<div class="panel-body">   

  	<div class="list-items">
  	
  	<?php foreach(array_slice($diets, 0, 5) as $diet): ?>
  	<div class="list-item">
    <img src="<?php echo SITE_URL ?>/images/<?php echo $diet['diet_image']; ?>">
    <h6><?php echo $diet['diet_title']; ?></h6>

    <div class="list-item-actions">

    	<a href="<?php echo SITE_URL ?>/controller/edit_recipe.php?id=<?php echo $diet['diet_id']; ?>"><i class="fa fa-cog"></i></a>
    	<a onclick="alertdelete_<?php echo $diet['diet_id']; ?>();"><i class="fa fa-trash-o"></i></a>

    </div>
    </div>

        <script type="text/javascript">
  function alertdelete_<?php echo $diet['diet_id']; ?>() {
  swal({ title: "Are you sure?", text: "You will not be able to recover this item!", type: "warning",cancelButtonClass: "btn-default btn-sm", showCancelButton: true, confirmButtonClass: "btn-danger btn-sm", confirmButtonText: "Yes, delete it!", closeOnConfirm: false }, function(){window.location.href = "<?php echo SITE_URL ?>/controller/delete_diet.php?id=<?php echo $diet['diet_id']; ?>" });}
  </script>
  
    <?php endforeach; ?>
    
    </div>

  	</div>
	</div>

   </div>

   </div>

<!--<?php if( !empty($errors)): ?>
<?php echo $errors; ?>    
<?php endif; ?>-->

</div>

<!--<?php require '../controller/pagination.php'; ?>    --> 
      
</div>
<div class="col-md-2">   
<?php require'sidebar.view.php'; ?>  
</div>
</div>
</div>

