<?php

// SELECT count(job.job_id), count(user.resume_id), count(lead.lead_id), count(app.id) from tbl_job_list as job, tbl_resume as user, tbl_job_lead as lead, tbl_job_applied as app where user.is_deleted=0 and user.account_status=1;
// select job.count(*),lead.count(*) from tbl_job_list as job, tbl_job_lead as lead;
include_once("../include/loader.php");
if($sesobj->get("username")==""){
	echo '<script language="javascript" type="text/javascript">window.location.href="index.php"</script>';die;
}
// $query = "set sql_mode=''";

//Getting counts from database
$query = "SELECT count(job.job_id) from tbl_job_list as job where is_deleted=0 and is_active=1";
$execount=mysql_query($query);
$jobcount = mysql_fetch_row($execount);

// $rescount=$sqlobj->getdatalistfromquery($query);
// $jobcountnt = mysql_fetch_array($rescount);

$query = "SELECT count(user.resume_id) from tbl_resume as user where is_deleted=0 and account_status=1";
$execount=mysql_query($query);
$usercount = mysql_fetch_row($execount);


$query = "SELECT count(lead.lead_id) from tbl_job_lead as lead where is_deleted=0";
$execount=mysql_query($query);
$leadcount = mysql_fetch_row($execount);

$query = "SELECT count(app.id) FROM `tbl_job_applied` as app INNER JOIN tbl_resume as user INNER JOIN tbl_job_list as job on app.job_id=job.job_id and app.user_id=user.resume_id";
$execount=mysql_query($query);
$appjobcount = mysql_fetch_row($execount);

//Geeting Job titles from database
$query = "SELECT job_title, updated_date from tbl_job_list where is_deleted=0 and is_active=1 order by updated_date desc limit 0,10";
$joblist = $sqlobj->getdatalistfromquery($query);

$query = "SELECT your_job_title, created_date from tbl_job_lead where is_deleted=0 order by created_date desc limit 0,10";
$leadlist = $sqlobj->getdatalistfromquery($query);

$query = "SELECT first_name, email, updated_date from tbl_resume where is_deleted=0 and account_status=1 order by updated_date desc limit 0,10";
$userlist = $sqlobj->getdatalistfromquery($query);

?>

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
                    <li class="active">
                        <a href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
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


        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">
                            Dashboard <small>Statistics Overview</small>
                        </h3>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
<!--
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-info-circle"></i>  <strong>Like SB Admin?</strong> Try out <a href="http://startbootstrap.com/template-overviews/sb-admin-2" class="alert-link">SB Admin 2</a> for additional features!
                        </div>
                    </div>
                </div>
    -->            <!-- /.row -->

                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-fw fa-table fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <!-- <div class="huge">26</div> -->
                                        <?php
                                        // foreach ($rescount as $key => $cou) {
                                          // var_dump($cou['count(job.job_id)']);
                                          // echo $cou['count(job.job_id)'];
                                        // }
                                          // var_dump($jobcount['count(job.job_id)']);
                                          // var_dump($rescount['count(job.job_id)']);
                                          // echo $jobcount[0];

                                         ?>
                                        <div class="huge"><?php echo $jobcount[0]; ?></div>
                                        <div>Job List!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="joblist.php">
                                <div class="panel-footer">
                                    <span style="color:#337ab7" class="pull-left">More Details</span>
                                    <span style="color:#337ab7" class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-fw fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $usercount[0]; ?></div>
                                        <div>Candidates!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">More Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-fw fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                              -->          <!-- <div class="huge">24</div> -->
                                        <!-- <div class="huge"><?php echo $leadcount[0]; ?></div>
                                        <div>Job Leads!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="jobleads.php">
                                <div class="panel-footer">
                                    <span class="pull-left">More Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div> -->
                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-fw fa-edit fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <!-- <div class="huge">130</div> -->
                                        <div class="huge"><?php echo $appjobcount[0]; ?></div>
                                        <div>Applied Jobs!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="appliedjob.php">
                                <div class="panel-footer">
                                    <span class="pull-left">More Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <!-- <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Area Chart</h3>
                            </div>
                            <div class="panel-body">
                                <div id="morris-area-chart"></div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="glyphicon glyphicon-briefcase"></i> Recent Jobs</h3>
                            </div>
                                                    <!--        <div id="morris-donut-chart"></div>
                        -->
                        <div class="panel-body">
                          <div class="list-group">

                            <?php
                            foreach ($joblist as $key => $job): ?>
                                <a class="list-group-item">
                                <span class="badge"><?php echo date("d/M/y",$job['updated_date']); ?></span>
                                <i class="fa fa-fw fa-user"></i> <?php echo $job['job_title']; ?>
                              </a>
                            <?php endforeach; ?>

                          </div>
                            <div class="text-right">
                                <a style="color:#555" href="joblist.php">View All Jobs <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                         <!--
                          <div class="text-right">
                                    <a href="#">More Details <i class="fa fa-arrow-circle-right"></i></a>
                              </div> -->

                       </div>
                    </div>
                    <!-- <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-user fa-fw"></i> Recent Job Leads</h3>
                            </div>
                            <div class="panel-body">
                                <div class="list-group">
                                  <?php
                                  foreach ($leadlist as $key => $lead): ?>
                                  <a class="list-group-item">
                                      <span class="badge"><?php echo date("d/M/y",$lead['created_date']); ?></span>
                                      <i class="glyphicon glyphicon-briefcase"></i> <?php echo $lead['your_job_title'] ?>
                                  </a>
                                  <?php endforeach; ?>
                                </div>
                                <div class="text-right">
                                    <a style="color:#555" href="jobleads.php">View All Recent Job Leads <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-users fa-fw"></i> Recent Candidates</h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>E-mail</th>
                                                <th>Last Updated</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php foreach ($userlist as $key => $user): ?>
                                              <tr>
                                                  <td><?php echo $user['first_name']; ?></td>
                                                  <td><?php echo $user['email']; ?></td>
                                                  <td><?php echo date("d/M/y",$user['updated_date']); ?></td>
                                              </tr>
                                            <?php endforeach; ?>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-right">
                                    <a style="color:#555" href="users.php">View All Candidates <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

</body>

</html>
