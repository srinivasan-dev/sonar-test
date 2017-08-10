<?php
include_once("../include/loader.php");
if($sesobj->isassign("username")==""){
	echo '<script language="javascript" type="text/javascript">window.location.href="index.php"</script>';die;
}
$where="";
if($userobj->getVariable('txt_page_title')!=""){

// var_dump($_FILES['txt_banner']['name']);
	if($_FILES['txt_banner']['name']!=""){
        $filename=time().$_FILES['txt_banner']["name"];
        $tmp_name=$_FILES["txt_banner"]['tmp_name'];
        $up_fname='../images/banner/'.$filename;
        $up_fnamelarge=$verylarge_dir.$filename;
        copy($tmp_name,$up_fname);
        chmod($up_fname,0777);
        if(move_uploaded_file($tmp_name,$up_fname)) {
            copy($up_fname);
        }
    }

	$data=array();

	$data["page_url"]= $userobj->getVariable('txt_page_title');
	if($_FILES['txt_banner']['name']!="")
		$data["banner_name"]= $filename;
	$data["is_active"]= $userobj->getVariable('sel_status');

	if($userobj->getVariable('banner_id')==""){
		$data["created_date"]=time();
	}
	if($userobj->getVariable('banner_id')!="") {
		$data["updated_date"]=time();
		$where=" banner_id=".$userobj->getVariable('banner_id');
	}
	$res =$sqlobj->save("tbl_banners",$data,$where);
	echo '<script type="text/javascript">window.location.href="manage_banner.php"</script>';die;
}
if($userobj->getVariable('banner_id')!=""){
	$sql_edit= "SELECT * FROM tbl_banners where banner_id='".$userobj->getVariable('banner_id')."'";
	$edit=$sqlobj->getdatalistfromquery($sql_edit);
}

$page_query = "select page_id, page_title, page_url from tbl_page_list where is_deleted=0 order by page_title asc";
$page_list=$sqlobj->getdatalistfromquery($page_query);

include_once("header.php");
?>
<script>
$(document).ready(function(){
	$("#cmt_sbmit").click(function(){
		var title=$("#txt_page_title").val();
		var banner=$("#txt_banner").val();
		var status=$("#sel_status").val();
		$(".error-text").hide();

		var str="";
		if(title==null || title==""){
			$("#err_page_title").show();
			str+='name';
		}
		if((banner==null || banner=="") && $('#txt_banner').css('display')=="block" ){
			$("#err_banner").show();
			str+='name';
		}
		if(status==null || status==""){
			$("#err_status").show();
			str+='name';
		}
		if(str!='')
			return false;
	});
});
</script>

<div class="clearfix">
	<?php include_once('leftnavi.php'); ?>


	<div class="col-sm-9 main-contain">
		<section class="content clearfix">
			<h3 class="title">Add Banner </h3>
			<form name="frm_category" id="frm_category" action="#" method="post" enctype="multipart/form-data">
				<input type="hidden" name="edit_row_id" id="edit_row_id" value="<?php echo $_GET['banner_id'];?>">
				<div class="col-md-6">
					<div class="form-group">
						<label>Page Name</label>
						<select class="form-control" id="txt_page_title" name="txt_page_title">
							<option value="">- Select -</option>
							<?php foreach ($page_list as $key => $value) { ?>
								<option value="<?php echo $value['page_url']; ?>"><?php echo $value['page_title']; ?></option>
							<?php } ?>
						</select>
						<script language="javascript" type="text/javascript">populateSelectbox(document.frm_category.txt_page_title,'<?php echo ($edit[0] ['page_url']);?>');</script>
						<p class="error-text" id="err_page_title">This field is required.</p>
					</div>


					<div class="form-group">
						<label>Banner Image</label>
						<input class="form-control" type="file" name="txt_banner" id="txt_banner" value="" style="display:<?php echo ($_GET['banner_id']!="")?"none":"block";?>">
						<div style="display:<?php echo ($_GET['banner_id']=="")?"none":"block";?>" id="bannerDiv">
							<a href="../images/banner/<?php echo ($edit[0] ['banner_name']);?>" target="_blank" > <?php echo ($edit[0] ['banner_name']);?></a> <br/>
							<a href="#" id="link_cancel" class="btn" onclick="$('#txt_banner').show();$('#bannerDiv').hide();return false;" style="font-size: 12px;height: 20px;padding: 2px 10px; margin-top: 10px;">Change Banner</a>
						</div>
						<p class="error-text" id="err_banner">This field is required.</p>
					</div>


					<div class="form-group">
						<label for="pwd">Status</label>
						<select class="form-control" id="sel_status" name="sel_status">
							<option value="">- Select -</option>
							<option value="0">Active</option>
							<option value="1">In Active</option>
						</select>
						<script language="javascript" type="text/javascript">populateSelectbox(document.frm_category.sel_status,'<?php echo $edit[0] ["is_active"] ;?>');</script>
						<p class="error-text" id="err_status">This field is required.</p>
					</div>
				</div>

				<div class="col-md-12">
					<button type="submit" class="btn btn-default" name="cmt_sbmit" id="cmt_sbmit" ><?php echo ($_GET['banner_id']=="")?"Add":"Update";?></button>
					<button type="button" class="btn btn-default" name="cmt_cancel" id="cmt_cancel" onclick="javascript:window.location.href='manage_banner.php';">Cancel</button>
				</div>

			</form>
		</section>
	</div>
</div>

<div style="height:1%;padding-bottom:60px;"> </div>
<?php include_once("footer.php");?>
