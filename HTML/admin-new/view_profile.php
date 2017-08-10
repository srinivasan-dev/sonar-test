<?php
include_once("../include/loader.php");
if($sesobj->get("username")==""){
	echo '<script language="javascript" type="text/javascript">window.location.href="index.php"</script>';die;
}

if($userobj->getVariable('resume_id')!=""){
	$query_prod="SELECT  * FROM tbl_resume where resume_id='".$userobj->getVariable('resume_id')."' ";
	$res_prod=$sqlobj->getdatalistfromquery($query_prod);
	//print_r($res_prod);
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> New Document </title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
<style>
body{
	font-size:14px;
	font-family:sans-serif;
	color:#000000;
}
.totalcontent{
	width:700px;
	margin-left:20px;
	margin-bottom:40px;
	float:left;
}
#full{
	width:400px;
	border-left:1px solid #27a6be;
	border-bottom:1px solid #27a6be;
	border-right:1px solid #27a6be;
	float:left;
	margin-left:95px;
	margin-top:40px;
	padding-bottom:20px;
}
.box1{
	float:left;
	width:180px;
	height:auto;
	padding-top:10px;
	vertical-align:middle;
	text-align:justify;
	margin-left:40px;
	}

	.btn-success {

   font-size: 16px;
font-weight: bold;
font-family: Times New Roman;
width: auto;
left: 5;
//margin-left: 20px;
text-transform: uppercase;
padding: 3px 8px;
}
.dot{
	float:left;
	width:10px;
	padding-top:10px;
	vertical-align:middle;
	}
.search1 {
	float:left;
	padding-top:10px;
	width:270px;
	min-height:20px;
	vertical-align:middle;
	text-align:left;
}
.billing_head{
	font-family:arial, sans-serif;
	background: #29b1fd;
	width:400px;
	height:35px;
	padding-top:10px;
}
.billing_headcart {
	font-family:arial, sans-serif;
	background:#6B6973;
	width:400px;
	height:40px;
	text-align:center;
}
.cart_head{
	font-family:sans-serif;
	color:#ffffff;
	padding-left:155px;
	font-size:15px;
}
.color{
	font-family:sans-serif;
	font-size:20px;
	color:#ffffff;
	padding-left:175px;
}
#close_out{
	padding-top:18px;
	width:55px;
	text-align:center;
	height:40px;
	margin-top: 400px;
	margin-left: -280px;
	color: #fff;
	background: #29b1fd !important;
	border-color: #29b1fd !important;
}
.link{
		font-family:arial, sans-serif;
		font-size:16px;
		color:#083884;
		font-weight:normal;
		text-decoration:none;
	}
a.link:hover{
	text-decoration:underline;
}
#status{
	float:left;
	width:400px;
	padding-top:20px;
	margin-left:150px;
}
.status_box{
	float:left;
	width:100px;
	height:auto;
	padding-top:10px;
	vertical-align:middle;
	text-align:justify;
}
.stat_dot{
	float:left;
	width:10px;
	padding-top:10px;
	vertical-align:middle;
}
.stat_search1{
	float:left;
	padding-top:10px;
	width:130px;
	vertical-align:middle;
	text-align:left;
}
.btn-extra-large1 {
    border-radius: 6px 6px 6px 6px;
    font-size: 20px;
    line-height: 22px;
    padding: 2px 10px;
	cursor:pointer;
}
.pull-left {
	float: left;
	padding-left:4px;
	margin:0px;
	padding:10px 10px 25px 0px;
}
.btn-pink1 {
    color: rgb(255, 255, 255);
    text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.25);
    background-color:#D61839;
    background-image: linear-gradient(to bottom, rgb(231, 43, 69), rgb(196, 5, 55));
    background-repeat: repeat-x;
    border: 0px solid rgb(0, 0, 0);
}
.text { padding: 6px; font-size: 14px; color: rgb(148, 72, 72); border: 1px solid #D6D7D6; font-family: Verdana,Geneva,sans-serif; border-radius: 6px 6px 6px 6px;}
#close_out{padding:10px 0px;}
</style>
<script type="text/javascript" src="js/jquery.js"></script>
<script>
function pop_out(){
	window.close();
	return false;
}
function populate_select(values,id){
	$("#"+id).each(function(){
	$('#'+id+' option[value="'+values+'"]').prop("selected",true);
	});
}
</script>
 </head>
 <body>
	<div class="totalcontent">

		<div id="full" style="width:500px;">
		<form name="user_detail" id="user_detail" action="#" method="post">
			<div class="billing_head" style="width:500px;"><span class="color">Candidate Details</span></div>
			<div class="box1">Name</div>
			<div class="dot">:</div>
			<div class="search1">
				<?php echo ucfirst($res_prod[0]['first_name']);?>
			</div>
      <!-- <div class="box1">Last Name</div>
			<div class="dot">:</div>
			<div class="search1">
				<?php echo NULL;?>
			</div> -->
			<div class="box1">Email Address</div>
			<div class="dot">:</div>
			<div class="search1">
				<?php echo $res_prod[0]['email'];?>
			</div>
			<div class="box1">Profession</div>
			<div class="dot">:</div>
			<div class="search1">
				<?php echo ucfirst($res_prod[0]['profession']);?>
			</div>
			<div class="box1">Phone</div>
			<div class="dot">:</div>
			<div class="search1">
				<?php echo $res_prod[0]['country_code'].$res_prod[0]['phone'];?>
			</div>
			<div class="box1">prefered location</div>
			<div class="dot">:</div>
			<div class="search1">
				<?php echo ucfirst($res_prod[0]['prefered_location']);?>
			</div>
      <?php if($res_prod[0]['content']!='') { ?>
			<div class="box1">Resume Content</div>
			<div class="dot">:</div>
			<div class="search1">
				<?php echo htmlspecialchars_decode($res_prod[0]['content']);?>
			</div>
			<?php } ?>
			<div class="box1">primary skill</div>
			<div class="dot">:</div>
			<div class="search1">
				<?php
				echo (implode("<br />", unserialize($res_prod[0]['primary_skill'])));
				?>
			</div>
			<div class="box1">Education</div>
			<div class="dot">:</div>
			<div class="search1">
				<?php echo ucfirst($res_prod[0]['education']);?>
			</div>
			<div class="box1">Experience</div>
			<div class="dot">:</div>
			<div class="search1">
				<?php echo ucfirst($res_prod[0]['experience']);?>
			</div>
			<div class="box1">status</div>
			<div class="dot">:</div>
			<div class="search1">
				<?php $stat=$res_prod[0]['account_status']; if($stat==0){ echo 'Inactive';}else{ echo 'Active';}?>
			</div>
			</form>
		</div>
		<div >
		  <button id="close_out" onclick="javascript:pop_out('manage_order.php');" type="submit" class="btn form-control-search">Close</button></div>
	</div>

 </body>
</html>
