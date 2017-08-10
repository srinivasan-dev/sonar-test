<?php
include_once("../include/loader.php");
if($sesobj->isassign("username")==""){
	echo '<script language="javascript" type="text/javascript">window.location.href="index.php"</script>';die;
}
$where="";
if($userobj->getVariable('txt_page_title')!="" && $userobj->getVariable('txt_page_url')){
	$data=array();
	$data["page_title"]= $userobj->getVariable('txt_page_title');
	$data["page_description"]= htmlspecialchars($userobj->getVariable('txt_page_description'));
	$data["page_url"]= $userobj->getVariable('txt_page_url');
	$data["is_active"]= $userobj->getVariable('sel_status');

	if($userobj->getVariable('page_id')==""){
		$data["created_date"]=time();
	}
	if($userobj->getVariable('page_id')!="") {
		$data["updated_date"]=time();
		$where=" page_id=".$userobj->getVariable('page_id');
	}
	$res =$sqlobj->save("tbl_pages",$data,$where);
	echo '<script type="text/javascript">window.location.href="manage_pages.php"</script>';die;
}
if($userobj->getVariable('page_id')!=""){
	$sql_edit= "SELECT * FROM tbl_pages where page_id='".$userobj->getVariable('page_id')."'";
	$edit=$sqlobj->getdatalistfromquery($sql_edit);
}

include_once("header.php");
?>
<script>
$(document).ready(function(){
	$("#cmt_sbmit").click(function(){
		var title=$("#txt_page_title").val();
		var url=$("#txt_page_url").val();
		var description=tinyMCE.get("txt_page_description").getContent();
		var status=$("#sel_status").val();
		$(".error-text").hide();

		var str="";
		if(title==null || title==""){
			$("#err_page_title").show();
			str+='name';
		}
		if(url==null || url==""){
			$("#err_page_url").show();
			str+='name';
		}
		if(description==null || description==""){
			$("#err_page_description").show();
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
<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
<script>
  tinymce.init({
  selector: 'textarea',
  height: 300,
  theme: 'modern',
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
  ],
  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
  ]
 });

  </script>
<div class="clearfix">
	<?php include_once('leftnavi.php'); ?>


	<div class="col-sm-9 main-contain">
		<section class="content clearfix">
			<h3 class="title">Add Page </h3>
			<form name="frm_category" id="frm_category" action="#" method="post" enctype="multipart/form-data">
				<div class="col-md-6">
					<div class="form-group">
						<label>Page  Title</label>
						<input class="form-control" type="text" name="txt_page_title" id="txt_page_title" value="<?php echo ($edit[0] ['page_title']);?>">
						<p class="error-text" id="err_page_title">This field is required.</p>
					</div>

				</div>
				<div class="clearfix"></div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Page  URL</label>
						<input class="form-control" type="text" name="txt_page_url" id="txt_page_url" value="<?php echo ($edit[0] ['page_url']);?>">
						<p class="error-text" id="err_page_url">This field is required.</p>
					</div>

				</div>

				<div class="col-md-12">
					<div class="form-group">
						<label>Page Content </label>
						<textarea class="form-control" rows="5" name="txt_page_description" id="txt_page_description" ><?php echo ($edit[0] ['page_description']);?></textarea>
						<p class="error-text" id="err_page_description">This field is required.</p>
					</div>

				</div>
				<div class="col-md-6">
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
					<button type="submit" class="btn btn-default" name="cmt_sbmit" id="cmt_sbmit" ><?php echo ($_GET['page_id']=="")?"Add":"Update";?></button>
					<button type="button" class="btn btn-default" name="cmt_cancel" id="cmt_cancel" onclick="javascript:window.location.href='manage_pages.php';">Cancel</button>
				</div>

			</form>
		</section>
	</div>
</div>

<div style="height:1%;padding-bottom:60px;"> </div>
<?php include_once("footer.php");?>
