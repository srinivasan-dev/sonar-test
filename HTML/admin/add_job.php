<?php
include_once("../include/loader.php");
if($sesobj->isassign("username")==""){
	echo '<script language="javascript" type="text/javascript">window.location.href="index.php"</script>';die;
}
$where="";
if($userobj->getVariable('txt_job_title')!=""){
	$data=array();
	$data["job_title"]= $userobj->getVariable('txt_job_title');
	$data["job_detail"]= htmlspecialchars($userobj->getVariable('txt_job_detail'));
	$data["short_description"]= htmlspecialchars($userobj->getVariable('txt_short_detail'));
	$data["is_active"]= $userobj->getVariable('sel_status');
	$data["city"]= $userobj->getVariable('txt_city');
	$data["state"]= $userobj->getVariable('sel_state');
	$data["category"]= $userobj->getVariable('category');
	// if($userobj->getVariable('chk_home')!=""){
	// 	$data["is_hot"]= $userobj->getVariable('chk_home');
	// }else {
	// 	$data["is_hot"]='0';
	// }
	if($userobj->getVariable('job_id')==""){
		$data["created_date"]=time();
		$data["updated_date"]=time();
	}
	if($userobj->getVariable('job_id')!="") {
		$data["updated_date"]=time();
		$where=" job_id=".$userobj->getVariable('job_id');
	}
	$res =$sqlobj->save("tbl_job_list",$data,$where);
	echo '<script type="text/javascript">window.location.href="job_list.php"</script>';die;
}
if($userobj->getVariable('job_id')!=""){
	$sql_edit= "SELECT * FROM tbl_job_list where job_id='".$userobj->getVariable('job_id')."'";
	$edit=$sqlobj->getdatalistfromquery($sql_edit);
}
  $sql_cat="SELECT category from tbl_categories order by category ASC ";
	$category=$sqlobj->getdatalistfromquery($sql_cat);
include_once("header.php");
?>
<script>
$(document).ready(function(){
	$("#cmt_sbmit").click(function(){
		var name=$("#txt_job_title").val();
		var short_detail=$("#txt_short_detail").val();
		var job_detail=tinyMCE.get("txt_job_detail").getContent();
		var city=$("#txt_city").val();
		var state=$("#sel_state").val();
		var status=$("#sel_status").val();
		var category=$("#category").val();
		$(".error-text").hide();

		var str="";
		if(name==null || name==""){
			$("#err_vendor_name").show();
			str+='name';
		}

		if(city==null || city==""){
			$("#err_city").show();
			str+='city';
		}
		if(short_detail==null || short_detail==""){
			$("#err_short_detail").show();
			str+='job_detail';
		}

		if(job_detail==null || job_detail==""){
			$("#err_job_detail").show();
			str+='job_detail';
		}
		if(state==null || state==""){
			$("#err_state").show();
			str+='state';
		}

		if(status==null || status==""){
			$("#err_status").show();
			str+='status';
		}

		if(category==null || category==""){
			$("#err_category").show();
			str+='category';
		}


		if(str!='')
		return false;

	});
});
</script>
<div class="clearfix">
	<?php include_once('leftnavi.php'); ?>
	<script src='https://cloud.tinymce.com/stable/tinymce.min.js?apikey=6owzlt6qcvsdovxtla07gf9uaef78vzyi639kncpo2z0jca5'></script>
	<script>
	tinymce.init({
		selector: '#txt_job_detail'

	});
	</script>

	<div class="col-sm-9 main-contain">
		<section class="content clearfix">
			<h3 class="title">Add New Job </h3>
			<form name="frm_category" id="frm_category" action="#" method="post" enctype="multipart/form-data">
				<div class="col-md-6">
					<div class="form-group">
						<label class="label-font">Job  Title</label>
						<input class="form-control" type="text" name="txt_job_title" id="txt_job_title" value="<?php echo ($edit[0] ['job_title']);?>">
						<p class="error-text" id="err_vendor_name">This field is required.</p>
					</div>

				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label class="label-font">Short Description </label>
						<textarea class="form-control" rows="5" name="txt_short_detail" id="txt_short_detail" ><?php echo ($edit[0] ['short_description']);?></textarea>
						<p class="error-text" id="err_short_detail">This field is required.</p>
					</div>

				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label class="label-font">Job Description </label>
						<textarea class="form-control" rows="5" name="txt_job_detail" id="txt_job_detail" ><?php echo ($edit[0] ['job_detail']);?></textarea>
						<p class="error-text" id="err_job_detail">This field is required.</p>
					</div>

				</div>

					<div class="form-group" >
						<div class="col-md-6">
							<label class="label-font">Job Location </label>
							<input class="form-control" type="text" name="txt_city" id="txt_city" value="<?php echo ($edit[0] ['city']);?>" placeholder="City">
							<p class="error-text" id="err_city">This field is required.</p>
						</div>
						<div class="col-md-6 state">
							<select class="form-control" name="sel_state" id="sel_state">
								<option value="">State</option>
								<option value="AK">Alaska(AK)</option>
								<option value="AL">Alabama(AL)</option>
								<option value="AR">Arkansas(AR)</option>
								<option value="AZ">Arizona(AZ)</option>
								<option value="CA">California(CA)</option>
								<option value="CO">Colorado(CO)</option>
								<option value="CT">Connecticut(CT)</option>
								<option value="DC">District of Columbia(DC)</option>
								<option value="DE">Delaware(DE)</option>
								<option value="FL">Florida(FL)</option>
								<option value="GA">Georgia(GA)</option>
								<option value="HI">Hawaii(HI)</option>
								<option value="IA">Iowa(IA)</option>
								<option value="ID">Idaho(ID)</option>
								<option value="IL">Illinois(IL)</option>
								<option value="IN">Indiana(IN)</option>
								<option value="KS">Kansas(KS)</option>
								<option value="KY">Kentucky(KY)</option>
								<option value="LA">Louisiana(LA)</option>
								<option value="MA">Massachusetts(MA)</option>
								<option value="MD">Maryland(MD)</option>
								<option value="ME">Maine(ME)</option>
								<option value="MI">Michigan(MI)</option>
								<option value="MN">Minnesota(MN)</option>
								<option value="MO">Missouri(MO)</option>
								<option value="MS">Mississippi(MS)</option>
								<option value="MT">Montana(MT)</option>
								<option value="NC">North Carolina(NC)</option>
								<option value="ND">North Dakota(ND)</option>
								<option value="NE">Nebraska(NE)</option>
								<option value="NH">New Hampshire(NH)</option>
								<option value="NJ">New Jersey(NJ)</option>
								<option value="NM">New Mexico(NM)</option>
								<option value="NV">Nevada(NV)</option>
								<option value="NY">New York(NY)</option>
								<option value="OH">Ohio(OH)</option>
								<option value="OK">Oklahoma(OK)</option>
								<option value="OR">Oregon(OR)</option>
								<option value="PA">Pennsylvania(PA)</option>
								<option value="RI">Rhode Island(RI)</option>
								<option value="SC">South Carolina(SC)</option>
								<option value="SD">South Dakota(SD)</option>
								<option value="TN">Tennessee(TN)</option>
								<option value="TX">Texas(TX)</option>
								<option value="UT">Utah(UT)</option>
								<option value="VA">Virginia(VA)</option>
								<option value="VT">Vermont(VT)</option>
								<option value="WA">Washington(WA)</option>
								<option value="WI">Wisconsin(WI)</option>
								<option value="WV">West Virginia(WV)</option>
								<option value="WY">Wyoming(WY)</option>
							</select>
							<script language="javascript" type="text/javascript">populateSelectbox(document.frm_category.sel_state,'<?php echo $edit[0] ["state"] ;?>');</script>
							<p class="error-text" id="err_state">This field is required.</p>
						</div>
					</div>

				<div class="form-group">
					<div class="col-md-6">
						<label class="label-font">Status </label>
						<select class="form-control" id="sel_status" name="sel_status">
							<option value="">- Select -</option>
							<option value="1">Active</option>
							<option value="0">In Active</option>
						</select>
						<script language="javascript" type="text/javascript">populateSelectbox(document.frm_category.sel_status,'<?php echo $edit[0] ["is_active"] ;?>');</script>
						<p class="error-text" id="err_status">This field is required.</p>
					</div>

					<!-- Start of category input -->
					<div class="col-md-6">
						<label class="label-font" for="search-categories">Category</label>
						<select name="category" class="selectpicker form-control" id="category" data-live-search="true" title="Any Category" data-size="5" data-container="body">
							<option value=""> - Select Category - </option>
							<?php foreach ($category as $key => $cat) { ?>
		            <<option value="<?php echo $cat['category']; ?>"><?php echo $cat['category']; ?></option>
		            <?php } ?>
							<!-- <option value=".NET Programmer">.NET Programmer</option>
							<option value="Database Specialist">Database Specialist</option>
							<option value="Business Intelligence Specialist">Business Intelligence Specialist</option>
							<option value="Big Data Specialist">Big Data Specialist</option>
							<option value="Cloud Programmer">Cloud Programmer</option>
							<option value="Java Programmer">Java Programmer</option>
							<option value="UNIX Programmer">UNIX Programmer</option>
							<option value="Project Management">Project Management</option>
							<option value="Testing Engineer">Testing Engineer</option> -->
						</select>
						<script language="javascript" type="text/javascript">populateSelectbox(document.frm_category.category,'<?php echo $edit[0] ["category"] ;?>');</script>
						<p class="error-text" id="err_category">This field is required.</p>
					</div>

				</div>
				<div class="col-md-12">
					<button type="submit" class="btn btn-default btn-add" name="cmt_sbmit" id="cmt_sbmit" ><?php echo ($_GET['job_id']=="")?"Add":"Update";?></button>
					<button type="button" class="btn btn-default" name="cmt_cancel" id="cmt_cancel" onclick="javascript:window.location.href='job_list.php';">Cancel</button>
				</div>

			</form>
		</section>
	</div>
</div>



<div style="height:1%;padding-bottom:60px;"> </div>
<?php include_once("footer.php");?>
