<?php
$page= basename($_SERVER['PHP_SELF']);
?>
 <div id="jquery-accordion-menu" class="jquery-accordion-menu red col-md-2 col-sm-2">
          <ul id="demo-list">
			<?php //if($_SESSION['SESSION']['user_type'] =='0') {?>
            <li class="<?php echo ($page=='job_list.php')?'active':''; ?>">
				<a href="job_list.php" class="<?php echo ($page=='job_list.php')?'submenu-indicator-minus':''; ?>"><i class="fa fa-files-o"></i>Job List </a>
            </li>
            <li class="<?php echo ($page=='manage_profile.php')?'active':''; ?>"><a href="manage_profile.php" class="<?php echo ($page=='purchase_order.php')?'submenu-indicator-minus':''; ?>"><i class="fa fa-users"></i>Users</a></li>

            <li class="<?php echo ($page=='manage_lead.php')?'active':''; ?>"><a href="manage_lead.php" class="<?php echo ($page=='purchase_order.php')?'submenu-indicator-minus':''; ?>"><i class="fa fa-bookmark"></i>Job Leads</a></li>
            <li class="<?php echo ($page=='manage_applied_job.php')?'active':''; ?>"><a href="manage_applied_job.php" class="<?php echo ($page=='manage_applied_job.php')?'submenu-indicator-minus':''; ?>"><i class="fa fa-envelope-open-o"></i>Applied Jobs</a></li>
            <li><a href="index.php?mode=logout"><i class="fa fa-user-o"></i>Logout</a>

            </li>
          </ul>
        </div>
