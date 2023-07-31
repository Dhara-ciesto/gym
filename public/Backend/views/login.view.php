<div class="container-fluid" style="margin-top:25px">
<style type="text/css">
	body{background-color: #000000;text-align: center;}
	.input-group-addon{background-color: #000000; border: 1px solid #000000;}
	.input-group.focus .input-group-addon { background-color: #000000; border-color: #000000; }
	.form-control, .select2-search input[type="text"]{border: 1px solid #ffffff;}
	img{display: block; width: 100%; max-width: 210px; margin-left: auto; margin-right: auto; margin-bottom: 10px;}
	.copyrights{font-size: 12px; color: #ffffff; margin-top: 10px;}
	.copyrights a{color: #ffffff;text-decoration: underline;}
		.title{color: #ffffff;font-size: 22px; font-weight: bold;}
	.title:after{content: '';display: block;height: 2px;width: 50px;margin-left: auto;margin-right: auto;background: #ffffff;margin-top: 6px;}
	.form-control::-webkit-input-placeholder, .select2-search input[type="text"]::-webkit-input-placeholder{color: #777}
</style>
	<div class="row">
	
	
		<div class="col-md-4">
		</div>
		
		
<div class="col-md-4 animated fadeIn"> <!-- BLOCK INPUT  -->

<h4 class="title">Welcome!</h4>

<div style="background: #ffffff; padding: 35px 25px; border-radius: 8px; max-width: 300px; margin-left: auto; margin-right: auto;">		



<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="login">    

   <input type="text" class="form-control" name="username" placeholder="Username" style="margin-bottom: 8px; border: 1px solid #777; border-radius: 5px; padding-left: 20px;">
   <input type="password" class="form-control" name="password" placeholder="Password" style="margin-bottom: 8px; border: 1px solid #777; border-radius: 5px; padding-left: 20px;">  

<button type="submit" class="btn btn-default" onclick="login.submit()" style="width: 100%;background-color: #e82027; border-radius: 5px;">Log In</button>

<?php if( !empty($errors)): ?>

<div class="alert alert-danger animated fadeIn" role="alert" style="margin-top: 20px; margin-bottom: 0;">
    
    <?php echo $errors; ?>
    
</div>
<?php endif; ?>

</form>  

</div>
<div class="copyrights">
Copyrights <a href="https://codecanyon.net/user/wicombit/portfolio" target="_blank">Wicombit</a>
</div>
</div><!-- FINISH BLOCK INPUT  -->
		
		
		<div class="col-md-4">
		</div>
		
		
	</div>
</div>