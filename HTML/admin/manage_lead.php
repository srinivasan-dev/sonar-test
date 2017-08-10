<?php
include_once("../include/loader.php");
if($sesobj->get("username")==""){
	echo '<script language="javascript" type="text/javascript">window.location.href="index.php"</script>';die;
}
// deleting row in table - durga
if($userobj->getVariable('txt_delete')!=""){
	$delete="UPDATE tbl_job_lead SET is_deleted=1 WHERE lead_id='".$userobj->getVariable('txt_delete')."';";
	mysql_query($delete);
	$con=$_POST['count'];
	$pagename= $_SERVER['PHP_SELF'];
	if(($_GET["page"])!=''){
		if($con!=1){
	echo "<script>window.location.href='$pagename?page=".$_GET["page"]."'</script>";die;
}
	echo "<script>window.location.href='$pagename?page=".($_GET["page"]-1)."'</script>";die;
}
else{
	echo "<script>window.location.href='$pagename'</script>";die;
}
}

$query="";
if($userobj->getVariable('txt_name')!="")
		$query=" and name like '%".$userobj->getVariable('txt_name')."%' ";
if($userobj->getVariable('txt_phone')!="")
	$query=" and phone like '%".$userobj->getVariable('txt_phone')."%' ";
if($userobj->getVariable('txt_email')!="")
	$query=" and email like '%".$userobj->getVariable('txt_email')."%' ";
$sql="SELECT * FROM tbl_job_lead WHERE  is_deleted=0 " .$query." order by lead_id desc" ;

$res=$sqlobj->query($sql);
$limitstr = NULL;

if($sqlobj->rsCount($res)>0) {
	$pageobj->setPagesize(20);
	$pageobj->setForm('manage_det');
	if ((isset($_GET["page"])==''))
  $PageNo = ($userobj->getVariable('page')!="")?"$userobj->getVariable('$PageNo')":"1";
else
  $PageNo = $_GET["page"];
	$limitstr = $pageobj->getLimit($PageNo,$sqlobj->rsCount($res));
}
$subquery =$sql.$limitstr;
$retval=$sqlobj->getdatalistfromquery($subquery);
include_once('header.php');
?>
<script>
$(document).ready(function(){
	$("#search").click(function(){
	var name=$("#txt_cat_name").val();
	var status=$("#sel_status").val();
	if(name=="" && status==""){
		alert("Please enter Category Name or Status.")
		return false;
	} else {
		$("#manage_det").submit();
	}
	});
});
function delete_cat(j) {
	var delete1=confirm("Do you want to delete this?");
	if(delete1==true){

		document.getElementById("txt_delete").value=j;
		document.manage_vendor.submit();
	}else{
		return false;
	}
}
</script>
<div class="clearfix">
	<?php include_once('leftnavi.php');
	$count=count($retval);
	?>
	<div class="col-sm-9 text-center main-contain">
		<section class="content clearfix" >
			<h2 class="title text-left">Manage Job Lead</h2>
			<aside class="paging_table">
				<form name="manage_vendor" id="manage_vendor" method="post" action="" class="form-inline">
					<input type="hidden" name="txt_delete" id="txt_delete" value=''>
					<input type="hidden" name='count' value="<?php echo $count; ?>">
					<fieldset>
						<div class="form-group">
							<label for="txt_name">Name:</label>
							<input type="text" class="form-control form-control-search" id="txt_name" name="txt_name">
						</div>
						<div class="form-group">
							<label for="txt_phone">Phone:</label>
							<input type="text" class="form-control form-control-search" id="txt_phone" name="txt_phone">
						</div>
						<div class="form-group">
							<label for="txt_email">Email:</label>
							<input type="text" class="form-control form-control-search" id="txt_email" name="txt_email">
						</div>
						<div class="form-group">
							<button type="submit" class="btn form-control-search">Search</button>
							<button type="submit" class="btn form-control-search">Show All</button>
						</div>
						</fieldset>
				</form>
				<div class="table-responsive clearfix">
				<table border="1" cellspacing="1" cellpadding="2" align="center" bgcolor="#29b1fd" width="100%">
						<tr style="background-color:#29b1fd;color:#ffffff; font-weight:bold;height:30px;border-color:#ccc;">
							<td class="text-center">S No</td>
							<td class="text-center">Name</td>
							<td class="text-center">Email</td>
							<td class="text-center">Phone</td>
							<td class="text-center">Company</td>
							<td class="text-center">Job Title</td>
							<td colspan="2" class="text-center">Action</td>
						</tr>
						<?php
						if(count($retval) > 0) {
							$i=1;
							if($userobj->getVariable('page')!=''){
							 if($i!=$userobj->getVariable('page')){
								 $i=($userobj->getVariable('page')-1)*20;
								 $i=$i+1;
							 }
						 }
						 foreach((array)$retval as $key => $value){

						?>
						<tr>
							<td class="text-center"><?php echo $i;?></td>
							<td><?php echo ucfirst($value['name']);?></td>
							<td><?php echo ($value['email']);?></td>
							<td class="text-center"><?php echo ($value['phone']);?></td>
							<td><?php echo ucfirst($value['company_name']);?></td>
							<td><?php echo ucfirst($value['your_job_title']);?></td>

							<td class="text-center">
								<a href='#' onclick="javascript:return popup('<?php echo $value['lead_id'];?>');"><img src="assets/img/view.gif" alt="edit" border="0px"></a>
							</td>
							<td class="text-center">
								<a href='#' onclick="javascript:return delete_cat('<?php echo $value['lead_id'];?>');">
								<img src="assets/img/delete.gif" alt="delete" border="0px"></a>
							</td>
						</tr>
						<?php $i++;} ?>
						<tr style="color:#181818;">
							<td colspan="8" class="paging text-center" id="#manage_det" ><?php echo $pageobj->showPageing()?></td>
						</tr>
						<?php } else {?>
						<tr style="background-color:#ffffff;color:red;">
							<td colspan="8" class="text-center">No Data Available.</td>
						</tr>
						<?php } ?>
					</table>
				</div>
			</aside>
		</section>

	</div>
</div>
<script type="text/javascript">
	function popup(url) {
		window.open("view_leads.php?lead_id="+url,"","height=550,width=770,top=15,left=15,scrollbars=yes,resizable=no,help=no");
		return false;
	}

</script>
<?php include_once('footer.php'); ?>
