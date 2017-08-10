<?php

session_start();
include_once('include/loader.php');
if ($_SESSION['profile_id']=='') {
	  // echo "<script>window.location='news_updates.php'</script>";die;
		echo "<script>window.location='login.php'</script>";die;
}
// $sql = "select * from tbl_resume where resume_id='".$_SESSION['profile_id']."' ";
$sql="SELECT a.applied_date, b.*, c.* FROM `tbl_job_applied` as a INNER JOIN tbl_resume as b INNER JOIN tbl_job_list as c on a.job_id=c.job_id and a.user_id=b.resume_id and b.resume_id = ".$_SESSION['profile_id']." order by a.applied_date desc" ;

$res=$sqlobj->query($sql);
$limitstr = NULL;
if($sqlobj->rsCount($res)>0) {
	$pageobj->setPagesize(10);
	$pageobj->setForm('manage_det');
	$PageNo = ($userobj->getVariable('PageNo')!="")?$userobj->getVariable('PageNo'):"1";
	$limitstr = $pageobj->getLimit($PageNo,$sqlobj->rsCount($res));
}
$subquery =$sql.$limitstr;
$retval=$sqlobj->getdatalistfromquery($subquery);

$qry_job = "select job_id,job_title from tbl_job_list where is_deleted=0";
$retval_job=$sqlobj->getdatalistfromquery($qry_job);

include_once('header.php');
?>



<!-- =============== Start of Page Header 1 Section =============== -->
<section class="page-header">
  <div class="container">

    <!-- Start of Page Title -->
    <div class="row">
      <div class="col-md-12">
        <h2>Applied Job History</h2>
      </div>
    </div>
    <!-- End of Page Title -->

    <!-- Start of Breadcrumb -->
    <div class="row">
      <div class="col-md-12">
        <ul class="breadcrumb">
<!--          <li><a href="#">home</a></li>
          <li class="active">pages</li>
    -->    </ul>
      </div>
    </div>
    <!-- End of Breadcrumb -->

  </div>
</section>
<!-- =============== End of Page Header 1 Section =============== -->



    <!-- ===== Start of Main Wrapper Section ===== -->
    <section class="search-jobs ptb80">
        <div class="container">



            <!-- Start of Row -->
            <div class="row mt60">

                <!-- Start of Job Post Main -->
                <div class="col-md-12 job-post-main">
                    <!-- <h4>We found 234 matches.</h4> -->

                    <!-- Start of Job Post Wrapper -->
                    <div class="job-post-wrapper mt20">

                        <!-- ===== Start of Single Job Post 1 ===== -->
                        <?php
              					if(count($retval) > 0) {
              						$i=1;
              						if($userobj->getVariable('page')!=''){
              							if($i!=$userobj->getVariable('page')){
              								$i=($userobj->getVariable('page')-1)*20;
              								$i=$i+1;
              							}
              						}
              						foreach($retval as $key => $val){
              							  							?>
                        <div class="single-job-post row nomargin">
                            <!-- Job Company -->


                            <!-- Job Title & Info -->
                            <div class="col-md-8 col-xs-6 ptb20">
                                <div class="job-title">
                                    <!-- <a href="job-page.html">php senior developer</a> -->
                                   <?php if($val['is_active'] == 1){ ?>
                                    <a href="job-page.php?job_id=<?php echo $val['job_id']; ?>"><?php echo  strtoupper($val['job_title']); ?></a>
																		<?php }else{ ?>
																			<a><?php echo  strtoupper($val['job_title']); ?></a>
																				<?php } ?>
                                </div>

                                <div class="job-info">
                                    <!-- <span class="company"><i class="fa fa-building-o"></i>envato</span> -->
                                    <!-- <span class="location"><i class="fa fa-map-marker"></i>Melbourn, Australia</span> -->

                                    <span class="location"><i class="fa fa-calendar"></i><?php echo ucfirst($val['city']); ?>, <?php echo ucfirst($val['state']); ?></span>
                                </div>
                            </div>

                            <!-- Job Category -->
                            <div class="col-md-4 col-xs-3 ptb30">
                                <div class="job-category">
                                    <!-- <a href="javascript:void(0)" class="btn btn-green btn-small btn-effect">full time</a> -->
                                   <?php if($val['is_active'] == 1){ ?>
                                    <a href="job-page.php?job_id=<?php echo $val['job_id']; ?>" class="btn btn-blue btn-small btn-effect">ACTIVE</a>
																		<?php }else{ ?>
																			<a href="" class="btn btn-blue btn-small btn-effect" disabled>INACTIVE</a>
																			<?PHP } ?>
																</div>
                            </div>
                        </div>

                        <!-- ===== End of Single Job Post 1 ===== -->

                        <?php $i++;}?>
                        <!-- <div style="color:#181818;"> -->
                          <div class="col-md-12 mt10 text-center">
														<?php echo $pageobj->showPageing()?>
													</div>
                        <!-- </div> -->
                        <!-- Start of Pagination -->
                      <!--  <div class="col-md-12 mt10">
                          <ul class="pagination list-inline text-center">
                            <li class="active"><a href="javascript:void(0)">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">Next</a></li>
                          </ul>
                        </div>
                      -->  <!-- End of Pagination -->
                        <?php } else {?>
                          <div style="background-color:#ffffff;color:red;">
                            <div style="padding:100px;margin-top:-63px;"colspan="8" class="text-center">No Data Available.</div>
                          </div>
                          <?php } ?>


                    </div>
                    <!-- End of Job Post Wrapper -->

                    <!-- Start of Pagination -->
                  <!--  <div class="col-md-12 mt10">
                        <ul class="pagination list-inline text-center">
                            <li class="active"><a href="javascript:void(0)">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">Next</a></li>
                        </ul>
                    </div>
                  -->  <!-- End of Pagination -->

                </div>
                <!-- End of Job Post Main -->

            </div>
            <!-- End of Row -->

        </div>
    </section>
    <!-- ===== End of Main Wrapper Section ===== -->


  <?php
  include_once('footer.php');
  ?>




  <!-- ===== Start of Back to Top Button ===== -->
  <a href="#" class="back-top"><i class="fa fa-chevron-up"></i></a>
  <!-- ===== End of Back to Top Button ===== -->








  <!-- ===== All Javascript at the bottom of the page for faster page loading ===== -->
  <script src="js/jquery-3.1.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap-select.min.js"></script>
  <script src="js/swiper.min.js"></script>
  <script src="js/jquery.ajaxchimp.js"></script>
  <script src="js/jquery.countTo.js"></script>
  <script src="js/jquery.inview.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/jquery.easypiechart.min.js"></script>
  <script src="js/jquery-ui.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/tinymce/tinymce.min.js"></script>
  <script src="js/countdown.js"></script>
  <script src="js/isotope.min.js"></script>
  <script src="js/custom.js"></script>
  <script type="text/javascript">
  function login_validate() {
    var err=1;
    if(document.frm_login.txt_email.value=="")
    {
      alert("Please enter Email id.");
      document.frm_login.txt_email.focus();
      return false;
    } else if(document.frm_login.txt_email.value!=''){
      var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      if(!(document.frm_login.txt_email.value.match(mailformat)))
      {
        alert("You have entered an invalid email address!");
        document.frm_login.txt_email.focus();
        return false;
      }
    }
    if(document.frm_login.txt_pwd.value=="")
    {
      alert("Please enter Password.");
      document.frm_login.txt_pwd.focus();
      return false;
    }  else {
      document.frm_login.submit();
    }
  }
  </script>
</body>

</html>
