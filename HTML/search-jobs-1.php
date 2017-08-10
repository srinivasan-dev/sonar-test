<?php
session_start();
include_once('include/loader.php');
$query="";

//category list query
$sql_cat="SELECT category from tbl_categories order by category ASC ";
$category=$sqlobj->getdatalistfromquery($sql_cat);

// search query functions
 if($userobj->getVariable('search-keywords')!=""){
	$query.=" and (job_title like '%".$userobj->getVariable('search-keywords')."%' or job_detail like '%".$userobj->getVariable('search-keywords')."%') " ;
}
if($userobj->getVariable('search-location')!=""){
	$query.=" and (state like '%".$userobj->getVariable('search-location')."%' or city like '%".$userobj->getVariable('search-location')."%' )";
}
if($userobj->getVariable('search-categories')!=""){
		$query.=" and category like '%".$userobj->getVariable('search-categories')."%' ";
	}

$sql="SELECT * FROM tbl_job_list WHERE  is_deleted=0 and is_active=1  ".$query." order by updated_date desc" ;

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
    <!-- =============== Start of Page Header 1 Section =============== -->
    <section class="page-header">
        <div class="container">

            <!-- Start of Page Title -->
            <div class="row">
                <div class="col-md-12">
                    <h2>search jobs</h2>
                </div>
            </div>
            <!-- End of Page Title -->

            <!-- Start of Breadcrumb -->
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <!-- <li><a href="#">home</a></li>
                        <li class="active">for canditates</li> -->
                    </ul>
                </div>
            </div>
            <!-- End of Breadcrumb -->

        </div>
    </section>
    <!-- =============== End of Page Header 1 Section =============== -->





    <!-- ===== Start of Main Wrapper Section ===== -->
    <section class="search-jobs ptb80">
        <div class="container">

            <!-- Start of Form -->
            <form class="job-search-form row" action="" method="get">

                <!-- Start of keywords input -->
                <div class="col-md-3 col-sm-12 search-keywords">
                    <label for="search-keywords">Keywords</label>
                    <input type="text" name="search-keywords" class="form-control" id="search-keywords" placeholder="Keywords" value="<?php echo $userobj->getVariable('search-keywords') ?>">
                </div>

                <!-- Start of category input -->
                <div class="col-md-3 col-sm-12 search-categories">
                    <label for="search-categories">Category</label>
                    <select name="search-categories" class="selectpicker" id="search-categories" data-live-search="true" title="Any Category" data-size="5" data-container="body">
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
                </div>

                <!-- Start of location input -->
                <div class="col-md-4 col-sm-12 search-location">
                    <label for="search-location">Location</label>
                    <input type="text" name="search-location" class="form-control" id="search-location" placeholder="Location" value="<?php echo $userobj->getVariable('search-location') ?>">
                </div>

                <!-- Start of submit input -->
                <div class="col-md-2 col-sm-12 search-submit">
                    <button type="submit" class="btn btn-blue btn-effect"><i class="fa fa-search"></i>search</button>
                </div>

            </form>
            <!-- End of Form -->


            <!-- Start of Row -->
            <div class="row mt20">

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

                                    <a href="job-page.php?job_id=<?php echo $val['job_id']; ?>"><?php echo  strtoupper($val['job_title']); ?></a>
                                </div>

                                <div class="job-info">
                                    <!-- <span class="company"><i class="fa fa-building-o"></i>envato</span> -->
                                    <!-- <span class="location"><i class="fa fa-map-marker"></i>Melbourn, Australia</span> -->

                                    <span class="location"><i class="fa fa-map-marker"></i><?php echo ucfirst($val['city']); ?>, <?php echo ucfirst($val['state']); ?></span>
                                </div>
                            </div>

                            <!-- Job Category -->
                            <div class="col-md-4 col-xs-3 ptb30">
                                <div class="job-category">
                                    <!-- <a href="javascript:void(0)" class="btn btn-green btn-small btn-effect">full time</a> -->

                                    <a href="job-page.php?job_id=<?php echo $val['job_id']; ?>" class="btn btn-blue btn-small btn-effect">READ MORE  </a>
                                </div>
                            </div>
                        </div>

                        <!-- ===== End of Single Job Post 1 ===== -->

                        <?php $i++;}?>
                        <!-- <div style="color:#181818;"> -->
                          <div class="col-md-12 text-center">
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
                            <div colspan="8" class="text-center">No Data Available.</div>
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





    <!-- ===== Start of Get Started Section ===== -->
    <section class="get-started ptb40">
        <div class="container">
            <div class="row ">

                <!-- Column -->
                <div class="col-md-10 col-sm-9 col-xs-12">
                    <h3 class="text-white">People trust ETWW! Join us today.</h3>
                </div>

                <!-- Column -->
                <div class="col-md-2 col-sm-3 col-xs-12">
                    <a href="register.php" class="btn btn-blue btn-effect">get started now</a>
                </div>

            </div>
        </div>
    </section>
    <!-- ===== End of Get Started Section ===== -->






    <?php
    include_once('footer.php');
    ?>





    <!-- ===== Start of Back to Top Button ===== -->
    <a href="#" class="back-top"><i class="fa fa-chevron-up"></i></a>
    <!-- ===== End of Back to Top Button ===== -->





    <!-- ===== Start of Login Pop Up div ===== -->
    <div class="cd-user-modal">
        <!-- this is the entire modal form, including the background -->
        <div class="cd-user-modal-container">
            <!-- this is the container wrapper -->
            <ul class="cd-switcher">
                <li><a href="#0">Sign in</a></li>
                <li><a href="#1">New account</a></li>
            </ul>

            <div id="cd-login">
                <!-- log in form -->
                <form class="cd-form">
                    <p class="fieldset">
                        <label class="image-replace cd-email" for="signin-email">E-mail</label>
                        <input class="full-width has-padding has-border" id="signin-email" type="email" placeholder="E-mail">
                    </p>
                    <p class="fieldset">
                        <label class="image-replace cd-password" for="signin-password">Password</label>
                        <input class="full-width has-padding has-border" id="signin-password" type="password" placeholder="Password">
                    </p>
                    <p class="fieldset">
                        <input type="checkbox" id="remember-me" checked>
                        <label for="remember-me">Remember me</label>
                    </p>
                    <p class="fieldset">
                        <button type="submit" value="Login" class="btn btn-blue btn-effect">Login</button>
                    </p>
                </form>
            </div>
            <!-- cd-login -->

            <div id="cd-signup">
                <!-- sign up form -->
                <form class="cd-form">
                    <p class="fieldset">
                        <label class="image-replace cd-username" for="signup-username">Username</label>
                        <input class="full-width has-padding has-border" id="signup-username" type="text" placeholder="Username">
                    </p>
                    <p class="fieldset">
                        <label class="image-replace cd-email" for="signup-email">E-mail</label>
                        <input class="full-width has-padding has-border" id="signup-email" type="email" placeholder="E-mail">
                    </p>
                    <p class="fieldset">
                        <label class="image-replace cd-password" for="signup-password">Password</label>
                        <input class="full-width has-padding has-border" id="signup-password" type="password" placeholder="Password">
                    </p>
                    <p class="fieldset">
                        <input type="checkbox" id="accept-terms">
                        <label for="accept-terms">I agree to the <a href="#0">Terms</a></label>
                    </p>
                    <p class="fieldset">
                        <button class="btn btn-blue btn-effect" type="submit" value="Create account">Create Account</button>
                    </p>
                </form>
            </div>
            <!-- cd-signup -->
        </div>
        <!-- cd-user-modal-container -->
    </div>
    <!-- cd-user-modal -->
    <!-- ===== End of Login Pop Up div ===== -->





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
		<script>
		$('#search-categories').val(<?php echo json_encode(( $userobj->getVariable('search-categories'))); ?>);
</script>
</body>

</html>
