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
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
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
                          <a href="tables.`html`"><i class="fa fa-fw fa-table"></i> Tables</a>
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
<?php $count=count($retval); ?>
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">
                            Job Posts <!-- <small>Statistics Overview</small> -->
                        </h3>
                        <!-- <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                        </ol> -->
                    </div>
                </div>
                <section class="content clearfix" >
                    <!-- <h2 class="title text-left">Job List</h2> -->
                    <aside class="paging_table">
                        <form name="manage_job" id="manage_job" method="post" action="" class="form-inline">
                            <input type="hidden" name="txt_delete" id="txt_delete" value=''>
                            <input type="hidden" name='count' value="<?php echo $count; ?>">
                        <div class="joblist">
                            <fieldset>
                                <div class="form-group add_job">
                                    <label for="txt_job_title">Job Name:</label>
                                    <input type="text" class="form-control form-control-search form-joblist" id="txt_job_title" name="txt_job_title">
                                </div>
                                <div class="form-group add_job">
                                    <label for="sel_status">Status:</label>
                                    <select name="sel_status" id="sel_status" class="form-control form-control-search form-joblist">
                                        <option value="">--Select--</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-default form-control-search add-btn">Search</button>
                                <button type="submit" class="btn form-control-search add-btn">Show All</button>
												        <a href="add_job.php" class="btn form-control-search add-job">Add Job</a>
                            </fieldset>
                        </div>

                <div class="row">
                    <div class="col-lg-12">
                        <!-- <h2>Bordered Table</h2> -->
                        <div class="table-responsive">
                            <!-- <table class="table table-bordered table-hover"> -->
                        <table border="1" cellspacing="1" cellpadding="2" align="center" bgcolor="#6B6973" width="100%" class="table">
                        <thead>
                            <tr class="table-thead table-bordered table-hover">
                                <td class="text-center">S No</td>
                                <td width="50%" class="text-center">Job Title</td>
                                <td class="text-center">Status</td>
                                <td class="text-center">Date</td>
                                <td colspan="2" class="text-center">Actions</td>
                            </tr>
                        </thead>
                        <tbody class="table-tbody">
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
              								<img src="images/open.png" title="Open" alt="edit" border="0px" height="20" width="20"></a>
              							</td>
              							<td class="text-center">
              								<a href='#' onclick="javascript:return delete_cat('<?php echo $value['job_id'];?>');">
              								<img src="images/delete.png" title="Delete" alt="delete" border="0px" height="20" width="20"></a>
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




                        </tbody>
                            </table>
                        </div>
                    </div>

                   <!--  <div class="row">
                        <div class="col-lg-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="glyphicon glyphicon-briefcase"></i> Hot Jobs</h3>
                                </div> -->
                                                    <!--        <div id="morris-donut-chart"></div>
                                                -->
                                               <!--  <div class="panel-body">
                                                  <div class="list-group">
                                                      <a href="#" class="list-group-item">
                                                          <span class="badge">just now</span>
                                                          <i class="fa fa-fw fa-user"></i> Full Stack Developer
                                                      </a>
                                                      <a href="#" class="list-group-item">
                                                          <span class="badge">4 minutes ago</span>
                                                          <i class="fa fa-fw fa-user"></i> Sr. JAVA Architect
                                                      </a>
                                                      <a href="#" class="list-group-item">
                                                          <span class="badge">23 minutes ago</span>
                                                          <i class="fa fa-fw fa-user"></i> Project Manager
                                                      </a>
                                                      <a href="#" class="list-group-item">
                                                          <span class="badge">46 minutes ago</span>
                                                          <i class="fa fa-fw fa-user"></i> Sr. UI Developer
                                                      </a>
                                                      <a href="#" class="list-group-item">
                                                          <span class="badge">1 hour ago</span>
                                                          <i class="fa fa-fw fa-user"></i> Sr. PHP Developer
                                                      </a>
                                                      <a href="#" class="list-group-item">
                                                          <span class="badge">2 hours ago</span>
                                                          <i class="fa fa-fw fa-user"></i> JAVA "Freshers"
                                                      </a>
                                                      <a href="#" class="list-group-item">
                                                          <span class="badge">yesterday</span>
                                                          <i class="fa fa-fw fa-user"></i> Human Resources
                                                      </a>
                                                      <a href="#" class="list-group-item">
                                                          <span class="badge">two days ago</span>
                                                          <i class="fa fa-fw fa-user"></i> Sr. DevOps Engineer
                                                      </a>
                                                  </div>
                                                  <div class="text-right">
                                                    <a href="#">View All Hot Jobs <i class="fa fa-arrow-circle-right"></i></a>
                                                </div>
                                            </div> -->
                         <!--
                          <div class="text-right">
                                    <a href="#">View Details <i class="fa fa-arrow-circle-right"></i></a>
                                </div> -->

                            <!-- </div> -->
                        <!-- </div> -->
                       <!--  <div class="col-lg-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fa fa-user fa-fw"></i> Latest Job Leads</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="list-group">
                                        <a href="#" class="list-group-item">
                                            <span class="badge">just now</span>
                                            <i class="glyphicon glyphicon-briefcase"></i> Accelio Corp.
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <span class="badge">4 minutes ago</span>
                                            <i class="glyphicon glyphicon-briefcase"></i> Almaden Resource Corp.
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <span class="badge">23 minutes ago</span>
                                            <i class="glyphicon glyphicon-briefcase"></i> LML Payment Systems Inc.
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <span class="badge">46 minutes ago</span>
                                            <i class="glyphicon glyphicon-briefcase"></i> Battery Technologies Inc.
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <span class="badge">1 hour ago</span>
                                            <i class="glyphicon glyphicon-briefcase"></i> Carmanah Technologies Corp.
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <span class="badge">2 hours ago</span>
                                            <i class="glyphicon glyphicon-briefcase"></i> DynaMotive Energy Systems Corp.
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <span class="badge">yesterday</span>
                                            <i class="glyphicon glyphicon-briefcase"></i> Gilat Satellite Networks Ltd.
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <span class="badge">two days ago</span>
                                            <i class="glyphicon glyphicon-briefcase"></i> I-Cable Communications Ltd.
                                        </a>
                                    </div>
                                    <div class="text-right">
                                        <a href="#">View All Activity Of Job Leads <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fa fa-users fa-fw"></i> Recent User History</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Name Of Person</th>
                                                    <th>Ph.no</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>

                                                    <td>10/21/2013</td>
                                                    <td>3:29 PM</td>
                                                    <td>Mr.John Smith</td>
                                                    <td>9828229119</td>
                                                </tr>
                                                <tr>

                                                    <td>10/21/2013</td>
                                                    <td>3:20 PM</td>
                                                    <td>Mrs. Alexa John</td>
                                                    <td>9828228292</td>
                                                </tr>
                                                <tr>

                                                    <td>10/21/2013</td>
                                                    <td>3:03 PM</td>
                                                    <td>Mr. Williams Lee</td>
                                                    <td>8939029012</td>
                                                </tr>
                                                <tr>

                                                    <td>10/21/2013</td>
                                                    <td>3:00 PM</td>
                                                    <td>Mr.Steve Jobs</td>
                                                    <td>9838293829</td>
                                                </tr>
                                                <tr>

                                                    <td>10/21/2013</td>
                                                    <td>2:49 PM</td>
                                                    <td>Mr. Bill Gates</td>
                                                    <td>9383238293</td>
                                                </tr>
                                                <tr>

                                                    <td>10/21/2013</td>
                                                    <td>2:23 PM</td>
                                                    <td>Mr. Sarah Adams</td>
                                                    <td>8473293384</td>
                                                </tr>
                                                <tr>

                                                    <td>10/21/2013</td>
                                                    <td>2:15 PM</td>
                                                    <td>Mr. Daniel Christian</td>
                                                    <td>9837338294</td>
                                                </tr>
                                                <tr>

                                                    <td>10/21/2013</td>
                                                    <td>2:13 PM</td>
                                                    <td>Mrs. Amy Jackson</td>
                                                    <td>7839374843</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-right">
                                        <a href="#">View All Recent History <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- /.row -->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Morris Charts JavaScript -->
        <script src="js/plugins/morris/raphael.min.js"></script>
        <script src="js/plugins/morris/morris.min.js"></script>
        <script src="js/plugins/morris/morris-data.js"></script>
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
        		document.manage_job.submit();
        	}else{
        		return false;
        	}
        }
        </script>

    </body>

    </html>
