
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
	echo '<script type="text/javascript">window.location.href="joblist.php"</script>';die;
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

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="ETWW Staffing Admin">
    <meta name="author" content="ITAG">
    <link rel="shortcut icon" type="image/x-icon" href="../images/etwwblue-fav.png">

    <title>ETWW Staffing Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!--Responsive-->
    <link rel="stylesheet" type="text/css" href="css/responsive.css">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">


    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" href="dashboard.php" ><img src="images/Etww-white.png"></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
  <!--                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
  -->              <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                    </ul>
                </li>
          <!--      <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Admin <b class="caret"></b></a>
                    <ul class="dropdown-menu">
        -->            <!--    <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                       <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                         <li class="divider"></li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                  -->  </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active">
                        <a href="joblist.php"><i class="fa fa-fw fa-table"></i> Job Posts</a>
                    </li>
                    <li>
                        <a href="users.php"><i class="fa fa-fw fa-users"></i> Candidates</a>
                    </li>
                    <!-- <li>
                        <a href="jobleads.php"><i class="fa fa-fw fa-user"></i> Job Leads</a>
                    </li> -->
                    <li>
                        <!-- <a href="charts.html"><i class="fa fa-fw fa-edit"></i> Applied Jobs</a> -->
                        <a href="appliedjob.php"><i class="fa fa-fw fa-edit"></i> Applied Jobs</a>
                    </li>
                    <li>

                        <a href="index.php?mode=logout"><i class="fa fa-sign-out"></i> Logout</a>
                    </li>
                <!--    <li>
                        <a href="tables.html"><i class="fa fa-fw fa-table"></i> Tables</a>
                    </li>
                    <li>
                        <a href="forms.html"><i class="fa fa-fw fa-edit"></i> Forms</a>
                    </li>
                    <li>
                        <a href="bootstrap-elements.html"><i class="fa fa-fw fa-desktop"></i> Bootstrap Elements</a>
                    </li>
                    <li>
                        <a href="bootstrap-grid.html"><i class="fa fa-fw fa-wrench"></i> Bootstrap Grid</a>
                    </li>
                   <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-wrench"></i> Admin Settings <i class=""></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="#">Page Settings</a>
                            </li>
                            <li>
                                <a href="#">Banner Settings</a>
                            </li>
                            <li>
                                <a href="#">Admin Settings</a>
                            </li>
                        </ul>
                    </li>
  -->       <!--            <li>
                        <a href="blank-page.html"><i class="fa fa-fw fa-file"></i> Blank Page</a>
                    </li>
                    <li>
                        <a href="index-rtl.html"><i class="fa fa-fw fa-dashboard"></i> RTL Dashboard</a>
                    </li>
          -->      </ul>
            </div>
            <!-- /.navbar-collapse -->



        </nav>






<div class="clearfix">
	<?php
	// include_once('../admin/leftnavi.php');
	?>
	<script src='https://cloud.tinymce.com/stable/tinymce.min.js?apikey=6owzlt6qcvsdovxtla07gf9uaef78vzyi639kncpo2z0jca5'></script>
	<script>
	tinymce.init({
		selector: '#txt_job_detail'

	});
	</script>

	<div id="page-wrapper">

			<div class="container-fluid">

					<!-- Page Heading -->
					<div class="row">
							<div class="col-lg-12">

		<section class="content clearfix">
			<h3 class="title">
				<?php if($userobj->getVariable('job_id')=="") {?>
					Add New Job
					<?php }else{ ?>
						Edit a Job
					<?php	} ?>
				</h3>
			<form name="add_update_job" id="add_update_job" action="#" method="post" enctype="multipart/form-data">
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
						<div class="col-md-3">
							<label class="label-font">City</label>
							<input class="form-control" type="text" name="txt_city" id="txt_city" value="<?php echo ($edit[0] ['city']);?>" placeholder="City">
							<p class="error-text" id="err_city">This field is required.</p>
						</div>

						<div class="col-md-3">
							<label class="label-font">State</label>
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
							<script language="javascript" type="text/javascript">populateSelectbox(document.add_update_job.sel_state,'<?php echo $edit[0] ["state"] ;?>');</script>
							<p class="error-text" id="err_state">This field is required.</p>
						</div>
					</div>

				<div class="form-group">
					<div class="col-md-3">
						<label class="label-font">Status </label>
						<select class="form-control" id="sel_status" name="sel_status">
							<option value="">- Select -</option>
							<option value="1">Active</option>
							<option value="0">In Active</option>
						</select>
						<script language="javascript" type="text/javascript">populateSelectbox(document.add_update_job.sel_status,'<?php echo $edit[0] ["is_active"] ;?>');</script>
						<p class="error-text" id="err_status">This field is required.</p>
					</div>
</div>

					<!-- Start of category input -->
					<div class="col-md-3">
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
						<script language="javascript" type="text/javascript">populateSelectbox(document.add_update_job.category,'<?php echo $edit[0] ["category"] ;?>');</script>
						<p class="error-text" id="err_category">This field is required.</p>
					</div>

				</div>
				<div class="col-md-12 text-center add-button">
					<button type="submit" class="btn btn-default btn-add" name="cmt_sbmit" id="cmt_sbmit" ><?php echo ($_GET['job_id']=="")?"Add":"Update";?></button>
					<button type="button" class="btn btn-default" name="cmt_cancel" id="cmt_cancel" onclick="javascript:window.location.href='joblist.php';">Cancel</button>
				</div>

			</form>
		</section>
	</div>
</div>
</div>
</div>



<div style="height:1%;padding-bottom:60px;"> </div>
