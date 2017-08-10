<?php
include_once("../include/loader.php");
if($sesobj->get("username")==""){
	echo '<script language="javascript" type="text/javascript">window.location.href="index.php"</script>';die;
}

if($userobj->getVariable('txt_delete')!=""){
	$delete="UPDATE tbl_banners SET is_deleted=1 WHERE banner_id='".$userobj->getVariable('txt_delete')."';";
	mysql_query($delete);
	echo"<script>window.location.href='manage_banner.php'</script>";die;
}

$query="";
if($userobj->getVariable('sel_status')!="")
		$query=" and is_active='".$userobj->getVariable('sel_status')."'";
if($userobj->getVariable('txt_page_name')!="")
	$query.=" and page_url = '".$userobj->getVariable('txt_page_name')."' ";
$sql="SELECT banner_id, banner_name,is_active,created_date,page_url FROM tbl_banners WHERE  is_deleted=0 " .$query." order by banner_id asc" ;

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

$page_query = "select page_id, page_title, page_url from tbl_page_list where is_deleted=0 order by page_title asc";
$page_list=$sqlobj->getdatalistfromquery($page_query);


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
	<?php include_once('leftnavi.php'); ?>
	<div class="col-sm-9 text-center main-contain">
		<section class="content clearfix" >
			<h2 class="title text-left">Manage Banners</h2>
			<aside class="paging_table">
				<form name="manage_vendor" id="manage_vendor" method="post" action="manage_banner.php" class="form-inline">
					<input type="hidden" name="txt_delete" id="txt_delete" value=''>
					<fieldset>
						<div class="form-group">
							<label for="txt_page_name">Page Name:</label>

							<select class="form-control form-control-search" id="txt_page_name" name="txt_page_name">
							<option value="">- Select -</option>
							<?php foreach ($page_list as $key => $value) { ?>
								<option value="<?php echo $value['page_url']; ?>"><?php echo $value['page_title']; ?></option>
							<?php } ?>
						</select>
						</div>
						<div class="form-group">
							<label for="sel_status">Status:</label>
							<select name="sel_status" id="sel_status" class="form-control form-control-search">
								<option value="">--Select--</option>
								<option value="0">Active</option>
								<option value="1">Inactive</option>
							</select>
						</div>
						<button type="submit" class="btn form-control-search">Search</button>
						<button type="submit" class="btn form-control-search">Show All</button>
						</fieldset>
				</form>
				<div class="text-right"><a href="add_banner.php" class="btn form-control-search" style="margin-bottom: 12px;">Add Banner</a></div>
				<div class="table-responsive clearfix">
				<table border="1" cellspacing="1" cellpadding="2" align="center" bgcolor="#6B6973" width="100%">
						<tr style="background-color:#698a35;color:#ffffff; font-weight:bold;height:30px;border-color:#698a35;">
							<td class="text-center">S No</td>
							<td width="50%" class="text-center">Page Name</td>
							<td class="text-center">Banner Image</td>
							<td class="text-center">Status</td>
							<td colspan="2" class="text-center">Action</td>
						</tr>
						<?php
						if(count($retval) > 0) {
							$i=1;
               if($i==$_GET["page"]){$i=1;}else{
								 $i=($_GET["page"])*10;if((($_GET["page"])%2)!=0){
								 $i=$i+11;}else{$i=1+$i;}
							 }
							foreach((array)$retval as $key => $value){
								$page_name_qry = "select page_title from tbl_page_list where is_deleted=0 and page_url='".$value['page_url']."' ";
								$page_name=$sqlobj->getdatalistfromquery($page_name_qry);
						?>
						<tr>

							<td class="text-center"><?php echo $i;?></td>
							<td ><?php echo ucfirst($page_name[0]['page_title']);?></td>
							<td class="text-center"><a href="../images/banner/<?php echo $value['banner_name'];?>" target="_blank"><?php echo $value['banner_name'];?></td>
							<td class="text-center"><?php $stat=$value['is_active']; if($stat==0){ echo 'Active';}else{ echo 'Inactive';}?></td>
							<td class="text-center">
								<a href='add_banner.php?banner_id=<?php echo $value['banner_id'];?>'>
								<img src="assets/img/edit.gif" alt="edit" border="0px"></a>
							</td>
							<td class="text-center">
								<a href='#' onclick="javascript:return delete_cat('<?php echo $value['banner_id'];?>');">
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
