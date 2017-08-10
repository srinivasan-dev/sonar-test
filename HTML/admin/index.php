<?php
include_once("../include/loader.php");
$Err="";
if($userobj->getVariable('txt_username')!="" && $userobj->getVariable('txt_pass')!=""){
	$query="SELECT username,password FROM tbl_admin where username ='".mysql_real_escape_string($userobj->getVariable('txt_username'))."' and password='".mysql_real_escape_string($userobj->getVariable('txt_pass'))."'";
	$user_array=$sqlobj->getdatalistfromquery($query);
	if(count($user_array) > 0) {
		$sesobj->assign('username',$userobj->getVariable('txt_username'));
		$sesobj->assign('user_type',$user_array[0]['user_type']);
		if(!empty($_POST["remember_me"])) {
				setcookie ("admin_login",$_POST["txt_username"],time()+ (10 * 365 * 24 * 60 * 60));
				setcookie ("admin_password",$_POST["txt_pass"],time()+ (10 * 365 * 24 * 60 * 60));
		} else {
				if(isset($_COOKIE["admin_login"])) {
						setcookie ("admin_login","");
				}
				if(isset($_COOKIE["admin_password"])) {
						setcookie ("admin_password","");
				}
		}
		echo '<script>window.location.assign("admindashboard.php");</script>';die;
	} else {
		$Err="Invalid Username / Password.";
	}
}
if($userobj->getVariable('mode')=='logout') {
	$sesobj->unassign('username');
	if($Err=="")
		$Err="<span style='color:green'>You have successfully logged out! </span>";
}
include_once('header.php');
?>
<script>
	function valid() {
		frm = document.frm_login;
		var str="";
		if(frm.txt_username.value=="") {
			str+="Username.\n";
		}
		if(frm.txt_pass.value=="") {
			str+="Password.\n";
		}
		msg="Please enter the following details : \n..........................................................\n";
		if(str!="") {
			msg=msg+str;
			alert(msg);
			return false;
		} else {
			frm.submit();
		}
	}
</script>

		<div class="container">
			<div class="form-container col-md-4 col-md-offset-4 ">
				<h2 class="text-center">Admin Login</h2>
				<?php if($Err!=''){ ?>
					<p class="text-center error_text"><?php echo $Err;?></p>
				<?php } ?>
				<form name="frm_login" method="post">
					<div class="form-group">
						<label for="email">Username:</label>
						<input type="text" name="txt_username" class="form-control" id="email" placeholder="Username" value="<?php if(isset($_COOKIE["admin_login"])) { echo $_COOKIE["admin_login"]; } ?>">
					</div>
					<div class="form-group">
						<label for="pwd">Password:</label>
						<input type="password" name="txt_pass" class="form-control" id="pwd" placeholder="Password" value="<?php if(isset($_COOKIE["admin_password"])) { echo $_COOKIE["admin_password"]; } ?>">
					</div>
					<div class="checkbox">
						<label><input type="checkbox" name="remember_me" value="1" <?php if(isset($_COOKIE["admin_login"])) { ?> checked <?php } ?>> <p>Remember me</p> </label>
					</div>
					<div class="form-group text-center">
						<button type="submit" class="btn btn-default" onclick="javascript: return valid();">Submit</button>
					</div>
				</form>
			</div>
		</div>
