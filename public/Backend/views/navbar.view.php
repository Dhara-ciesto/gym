<nav class="navbar-inverse navbar-embossed">
<div class="container">
<a class="navbar-brand" href="<?php echo SITE_URL; ?>">GoFit Dashboard</a>
<!--<form name="searching" action="<?php echo SITE_URL; ?>/controller/search.php" method="GET" class="navbar-form navbar-left formulario" role="search">
<div class="form-group">
<div class="input-group">
<input class="form-control" name="searching" id="navbarInput-01" type="search" placeholder="Search...">
<span class="input-group-btn"><button type="submit" class="btn"><span class="fui-search"></span></button>
</span>
</div>
</div>
</form>-->
<div class="navbar-right">
<p class="navbar-text">Signed in as <b><?php echo $_SESSION['username'] ?></b></p>
<a type="button" class="btn btn-embossed btn-default navbar-btn btn-sm" href="<?php echo SITE_URL ?>/controller/logout.php">Sign out</a>
</div>
<div class="navbar-right signout">
<a style="color: #fff; font-size: 13px; height: 53px; padding: 15px 25px; text-align: right; float: right;" href="<?php echo SITE_URL ?>/controller/logout.php">Sign out <span class="glyphicon">&#xe163;</span></a>
</div>
</div>
</nav>
<div class="all-content">

<div class="alert alert-danger" role="alert" style="margin: 12px;color: #ffffff; background-color: #ea2027; border-color: #ea2027;">
	
	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>
  Warning! Enabled demo version mode! The changes you've made will not be saved.
</div>