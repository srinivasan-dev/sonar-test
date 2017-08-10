<?php
	include_once("../include/loader.php");
	if($sesobj->get('username') == '' ) {
		echo '<script>window.location.assign("index.php");</script>';die;
	}
?>

<?php include_once('header.php'); ?>

<!-- navbar side -->
<div class="clearfix dashboard">
	<?php include_once('leftnavi.php'); ?>
	<div class="col-sm-10 col-md-10 text-center welcome-text main-contain">
		<h1 class="welcome">Welcome to Admin Panel</h1>
	</div>
</div>

<?php include_once('footer.php'); ?>
