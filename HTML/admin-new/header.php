<?php
$page= basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Eastern Technology Staffing</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="../images/etwwblue-fav.png">
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/style.css">
		<link rel="stylesheet" href="assets/css/jquery-accordion-menu.css">
		<link rel="stylesheet" href="assets/css/responsive.css">


		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="assets/js/jquery-accordion-menu.js"></script>
		<script src="assets/js/script.js"></script>
	</head>
	<body>
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="navbar" style="background: #fff;box-shadow: 0 8px 6px -6px #867d7d;">
            <!-- navbar-header -->
            <div class="navbar-header">
				<?php if($page !='index.php') { ?>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				<?php } ?>
               <div class="fleft logo">
                    <a class="navbar-brand" href="index.php"><img src="images/etww13.png" alt="ETWW" title="Eastern Technology World Wide Staffing" width="160"></a>
                </div>
            </div>
        </nav>
