<?php
include_once("../include/loader.php");
if($sesobj->get("username")==""){
	echo '<script language="javascript" type="text/javascript">window.location.href="index.php"</script>';die;
}

if($userobj->getVariable('txt_delete')!=""){
	$delete="UPDATE tbl_job_list SET is_deleted=1 WHERE job_id='".$userobj->getVariable('txt_delete')."';";
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
if($userobj->getVariable('sel_status')!="")
		$query=" and is_active='".$userobj->getVariable('sel_status')."'";
if($userobj->getVariable('txt_job_title')!="")
	$query.=" and job_title like '%".$userobj->getVariable('txt_job_title')."%' ";
$sql="SELECT job_id, job_title,is_active,created_date,updated_date FROM tbl_job_list WHERE  is_deleted=0 " .$query." order by updated_date desc" ;

$res=$sqlobj->query($sql);
$limitstr = NULL;
if($sqlobj->rsCount($res)>0) {
	$pageobj->setPagesize(20);
	$pageobj->setForm('manage_det');
	if ((isset($_GET["page"])==''))
  $PageNo = ($userobj->getVariable('page')!="")?"$userobj->getVariable('$PageNo')":"1";
else
  $PageNo = $_GET["page"];
	// $PageNo = ($userobj->getVariable('PageNo')!="")?$userobj->getVariable('PageNo'):"1";
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
			<h2 class="title text-left">Job List</h2>
			<aside class="paging_table">
				<form name="manage_vendor" id="manage_vendor" method="post" action="" class="form-inline">
					<input type="hidden" name="txt_delete" id="txt_delete" value=''>
					<input type="hidden" name='count' value="<?php echo $count; ?>">
					<fieldset>
						<div class="form-group add_job">
							<label for="txt_job_title">Job Name:</label>
							<input type="text" class="form-control form-control-search" id="txt_job_title" name="txt_job_title">
						</div>
						<div class="form-group add_job">
							<label for="sel_status">Status:</label>
							<select name="sel_status" id="sel_status" class="form-control form-control-search">
								<option value="">--Select--</option>
								<option value="1">Active</option>
								<option value="0">Inactive</option>
							</select>
						</div>
						<button type="submit" class="btn btn-default form-control-search add-btn">Search</button>
						<button type="submit" class="btn form-control-search add-btn">Show All</button>
						</fieldset>
				</form>
				<div class="text-right"><a href="add_job.php" class="btn form-control-search" style="margin-bottom: 12px;">Add Job</a></div>
				<div class="table-responsive clearfix">
				<table border="1" cellspacing="1" cellpadding="2" align="center" bgcolor="#29b1fd" width="100%">
						<tr style="background-color:#29b1fd;color:#ffffff; font-weight:bold;height:30px;border-color:#ccc;">
							<td class="text-center">S No</td>
							<td width="50%" class="text-center">Job Title</td>
							<td class="text-center">Status</td>
							<td class="text-center">Date</td>
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
							<td><?php echo ucfirst($value['job_title']);?></td>
							<td class="text-center"><?php $stat=$value['is_active']; if($stat==1){ echo 'Active';}else{ echo 'Inactive';}?></td>
							<td class="text-center"><?php
							 if($value['updated_date']==0)
							 	echo date('d/m/Y',$value['created_date']);
							 else
							 	echo date('d/m/Y',$value['updated_date']);
							 ?>
						 </td>
							<td class="text-center">
								<a href='add_job.php?job_id=<?php echo $value['job_id'];?>'>
								<img src="assets/img/edit.gif" alt="edit" border="0px"></a>
							</td>
							<td class="text-center">
								<a href='#' onclick="javascript:return delete_cat('<?php echo $value['job_id'];?>');">
								<img src="assets/img/delete.gif" alt="delete" border="0px"></a>
							</td>
						</tr>
						<?php $i++;} ?>
						<tr style="color:#181818;">
							<td colspan="6" class="paging text-center"><?php echo $pageobj->showPageing()?></td>
						</tr>
						<?php } else {?>
						<tr style="background-color:#ffffff;color:red;">
							<td colspan="6" class="text-center">No Data Available.</td>
						</tr>
						<?php } ?>
					</table>
				</div>
			</aside>
		</section>

	</div>
</div>

<?php include_once('footer.php'); ?>
