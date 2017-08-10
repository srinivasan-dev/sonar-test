<?php
include_once("../include/loader.php");
if($sesobj->get("username")==""){
	echo '<script language="javascript" type="text/javascript">window.location.href="index.php"</script>';die;
}

if($userobj->getVariable('txt_delete')!=""){
	if ($userobj->getVariable('profile_id_ses_out')!="") {
		unset($_SESSION['profile_id']);
	}
	$delete="UPDATE tbl_resume SET is_deleted=1 WHERE resume_id='".$userobj->getVariable('txt_delete')."';";
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
	$query=" and (first_name like '%".$userobj->getVariable('txt_name')."%' or last_name like '%".$userobj->getVariable('txt_name')."%') ";

if($userobj->getVariable('txt_phone')!="")
	$query.=" and phone like '%".$userobj->getVariable('txt_phone')."%' ";

if($userobj->getVariable('txt_skill')!="")
	$query.=" and primary_skill like '%".$userobj->getVariable('txt_skill')."%' ";

$sql="SELECT * FROM tbl_resume WHERE  is_deleted=0 " .$query." order by resume_id desc" ;

$res=$sqlobj->query($sql);
$limitstr = NULL;
if($sqlobj->rsCount($res)>0){
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
	$count=count($retval);?>
	<div class="col-sm-9 text-center main-contain">
		<section class="content clearfix" >
			<input type="hidden" id="profile_id" value="<?php echo $_SESSION['profile_id'];?>">
      <input type="hidden" name='count' value="<?php echo $count; ?>">
			<h2 class="title text-left">Manage User</h2>
			<aside class="paging_table">
				<form name="manage_vendor" id="manage_vendor" method="post" action="" class="form-inline">
					<input type="hidden" name="txt_delete" id="txt_delete" value=''>
					<input type="hidden" name='count' value="<?php echo $count; ?>">
					<fieldset>
						<div class="form-group">
							<label for="email">Candidate Name:</label>
							<input type="text" class="form-control  form-control-search" id="txt_name" name="txt_name">
						</div>
						 <div class="form-group">
                            <label for="email">Primary Skills </label>
                            <select  name="txt_skill" id="txt_skill" class="form-control">
                              <option value="">--Select Skill --</option>
                              <option value="Firewall/F5">Firewall/F5</option>
                              <option value="ASP.Net">ASP.Net</option>
                              <option value="Business Analysis">Business Analysis</option>
                              <option value="Business Development">Business Development</option>
                              <option value="C#.NET">C#.NET  </option>
                              <option value="C/C++">C/C++ </option>
                              <option value="Financial Analysis">Financial Analysis</option>
                              <option value="Human Resource">Human Resource</option>
                              <option value="Java">Java</option>
                              <option value="linux">linux</option>
                              <option value="Networking">Networking</option>
                              <option value="PHP">PHP</option>
                              <option value="Python">Python</option>
                              <option value="Recruitment">Recruitment</option>
                              <option value="Ruby">Ruby</option>
                              <option value="Sales">Sales </option>
                              <option value="Solution Engineer">Solution Engineer</option>
                              <option value="Technical Recruiter">Technical Recruiter</option>
                              <option value="Technical Support">Technical Support</option>
                              <option value="Demandware">Demandware</option>
                              <option value="Testing">Testing</option>
                              <option value="UI/ UX Desginer">UI/ UX Desginer</option>
                              <option value="Accounts">Accounts</option>
                            </select>
                          </div>
						<div class="form-group phone">
							<label for="email">Phone:</label>
							<input type="text" class="form-control form-control-search" id="txt_phone" name="txt_phone">
						</div>
						<button type="submit" class="btn form-control-search">Search</button>
						<button type="submit" class="btn form-control-search">Show All</button>
						</fieldset>
				</form>

				<div class="table-responsive clearfix">
				<table border="1" cellspacing="1" cellpadding="2" align="center" bgcolor="#29b1fd" width="100%">
						<tr style="background-color:#29b1fd;color:#ffffff; font-weight:bold;height:30px;border-color:#ccc;">
							<td class="text-center">S No</td>
							<td class="text-center">Name</td>
							<td class="text-center">Email</td>
							<!--<td class="text-center">Phone</td>	-->
							<td class="text-center">Phone	</td>
							<td class="text-center">Skill Set</td>
							<td class="text-center">Resume</td>
							<td class="text-center">Preview</td>
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
							<td><?php echo ucfirst($value['first_name']).' '.ucfirst($value['last_name']);?></td>
							<td><?php echo ($value['email']);?></td>
							<td class="text-center"><?php echo ($value['phone']);?></td>
							<td><?php echo (implode(', ', unserialize($value['primary_skill'])));?></td>
							<td class="text-center">
								<a href='../images/resumes/<?php echo $value['document_name'];?>' target="_blank">
								<img src="assets/img/download.png" alt="edit" border="0px" width="30" ></a>
							</td>
							<td class="text-center">
								<a href='https://docs.google.com/viewer?embedded=true&url=http://dev.etwwstaffing.com/images/resumes/<?php echo $value['document_name'];?>' target="_blank">
								<img src="assets/img/preview.png" alt="edit" border="0px" width="30" ></a>
							</td>
							<td class="text-center">
								<a href='#' onclick="javascript:return popup('<?php echo $value['resume_id'];?>');">
								<img src="assets/img/view.gif" alt="edit" border="0px"></a>
							</td>
							<td class="text-center">
								<a href='#' onclick="javascript:return delete_cat('<?php echo $value['resume_id'];?>');">
								<img src="assets/img/delete.gif" alt="delete" border="0px"></a>
							</td>
						</tr>
						<?php $i++;} ?>
						<tr style="color:#181818;">
							<td colspan="8" class="paging text-center"><?php echo $pageobj->showPageing()?></td>
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
		window.open("view_profile.php?resume_id="+url,"","height=550,width=770,top=15,left=15,scrollbars=yes,resizable=no,help=no");
		return false;
	}
</script>
<?php include_once('footer.php'); ?>
