
<div id="sidebar">

<h6>Go to...</h6>

<select class="form-control" onchange="location = this.value;">
   <option selected="">Select...</option>
   <option value="../controller/equipments.php">Equipments</option>
   <option value="../controller/goals.php">Goals</option>
   <option value="../controller/quotes.php">Quotes</option>
   <option value="../controller/categories.php">Categories</option>
   <option value="../controller/bodyparts.php">Bodyparts</option>
   <option value="../controller/exercises.php">Exercises</option>
   <option value="../controller/workouts.php">Workouts</option>
   <option value="../controller/recipes.php">Recipes</option>
</select>

<h6>Add new...</h6>

<a href="<?php echo SITE_URL; ?>/controller/new_equipment.php" type="button" class="btn btn-default btn-block btn-sm" aria-haspopup="true" aria-expanded="false"><i class="flaticon-dumbbell"></i> Equipment </a>

<a href="<?php echo SITE_URL; ?>/controller/new_goal.php" type="button" class="btn btn-default btn-block btn-sm" aria-haspopup="true" aria-expanded="false"><i class="flaticon-medal"></i> Goal </a>

<a href="<?php echo SITE_URL; ?>/controller/new_quote.php" type="button" class="btn btn-default btn-block btn-sm" aria-haspopup="true" aria-expanded="false"><i class="flaticon-scale"></i> Quote </a>

<a href="<?php echo SITE_URL; ?>/controller/new_category.php" type="button" class="btn btn-default btn-block btn-sm" aria-haspopup="true" aria-expanded="false"><i class="flaticon-orange"></i> Category </a>

<a href="<?php echo SITE_URL; ?>/controller/new_bodypart.php" type="button" class="btn btn-default btn-block btn-sm" aria-haspopup="true" aria-expanded="false"><i class="flaticon-medical"></i> Bodypart </a>

<a href="<?php echo SITE_URL; ?>/controller/new_recipe.php" type="button" class="btn btn-default btn-block btn-sm" aria-haspopup="true" aria-expanded="false"><i class="flaticon-fruit"></i> Recipe </a>

<a href="<?php echo SITE_URL; ?>/controller/new_exercise.php" type="button" class="btn btn-default btn-block btn-sm" aria-haspopup="true" aria-expanded="false"><i class="flaticon-time"></i> Exercise </a>

<a href="<?php echo SITE_URL; ?>/controller/new_workout.php" type="button" class="btn btn-default btn-block btn-sm" aria-haspopup="true" aria-expanded="false"><i class="flaticon-calendar"></i> Workout </a>

<a href="<?php echo SITE_URL; ?>/controller/new_tag.php" type="button" class="btn btn-default btn-block btn-sm" aria-haspopup="true" aria-expanded="false"><i class="flaticon-water"></i> Tag </a>

<a href="<?php echo SITE_URL; ?>/controller/new_post.php" type="button" class="btn btn-default btn-block btn-sm" aria-haspopup="true" aria-expanded="false"><i class="flaticon-smartwatch"></i> Post </a>

<a href="<?php echo SITE_URL; ?>/controller/strings.php" type="button" class="btn btn-default btn-block btn-sm" aria-haspopup="true" aria-expanded="false"><i class="fa fa-font"></i> Strings </a>

</div>
