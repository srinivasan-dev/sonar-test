<?php
include_once('include/loader.php');

$query_job= "select * from tbl_job_list where is_deleted =0 and job_id='".$_GET['job_id']."' ";
 $retval=$sqlobj->getdatalistfromquery($query_job);

 $applied_job= "select * from tbl_job_applied where is_deleted =0 and job_id='".$_GET['job_id']."' and user_id='".$_SESSION['profile_id']."' ";
 $retval_applied=$sqlobj->getdatalistfromquery($applied_job);

 $user_qry= "select profile_completion from tbl_resume where is_deleted =0 and resume_id='".$_SESSION['profile_id']."' ";
 $user_check=$sqlobj->getdatalistfromquery($user_qry);
 if($_POST['job_id']!=""){

     $user= "select * from tbl_resume where is_deleted =0 and  resume_id='".$_SESSION['profile_id']."' ";
     $user_data=$sqlobj->getdatalistfromquery($user);
     //print_r($user_data);die;
     $data=array();
     $data["job_id"]=    $_POST['job_id'];
     $data["user_id"]= $_SESSION['profile_id'];
     $data["applied_date"]= time();

     $res =$sqlobj->save("tbl_job_applied",$data,$where);

     $subject = "You applied for the post of ".$retval[0]['job_title'];

     $message2 = "Dear ".$user_data[0]['first_name']."<br/>";
     $message2 .= "Thank you for applying for the post of <b>".$retval[0]['job_title']."</b>. Our HR Team member will contact you shortly.";
     $message2=stripslashes($message2);

     $mail->From = $from_email;
     $mail->FromName = $from_name;
     $mail->addAddress($user_data[0]['email']);
     $mail->Subject = $subject;
     $mail->Body = $message2;
     $mail->send();

     $admin_message=$user_data[0]['first_name']." has been applied for the post of ".$retval[0]['job_title'];

     $mail->ClearAllRecipients();
     $mail->From = $from_email;
     $mail->FromName = $from_name;
     $mail->addAddress($admin_email);
     $mail->Subject = "Job Applied Notification";
     $mail->Body = $admin_message;
     $mail->send();

     echo '<script type="text/javascript">window.location.href="job-page.php?job_id='.$_POST['job_id'].'&mode=saved"</script>';die;
 }



include_once 'header.php';
?>










    <!-- ===== Start of Main Wrapper Job Section ===== -->
    <section class="ptb80" id="job-page">
        <div class="container">

            <!-- Start of Row -->
            <div class="row">
<?php  foreach($retval as $key => $val){ ?><?php }?>
                <!-- ===== Start of Job Details ===== -->
                <div class="col-md-12 col-xs-12">

                    <!-- Start of Company Info -->
                    <div class="row company-info">



                        <!-- Job Company Info -->
                        <div class="col-md-9">
                            <div class="job-company-info mt30">
                                <h3 class="capitalize"><?php echo strtoupper($val['job_title']); ?></h3>
  <ul class="job-overview nopadding mt40">
                        <span>        <li>
                                    <h5><i class="fa fa-calendar"></i> Date Posted:</h5>
                                    <span><?php echo date('d/m/Y',$val['updated_date']);?></span>
                                </li>

                           <li>
                                    <h5><i class="fa fa-map-marker"></i> Location:</h5>
                                    <span><?php echo ucfirst($val['city']); ?>, <?php echo $val['state']; ?></span>
                                </li></span>
</ul>
                            </div>
                        </div>

                    </div>
                    <!-- End of Company Info -->


                    <!-- Start of Job Details -->
                    <div class="row job-details mt40">
                        <div class="col-md-12">
                          <form name="apply_job" id="apply_job" action="" method="post">
                              <input type="hidden" name="job_id" value="<?php echo $_GET['job_id'];?>">

                            <!-- Div wrapper -->
                            <div class="">

                                <h5>Job Overview</h5>
                                <p class="mt20">  <?php echo htmlspecialchars_decode($val['job_detail']); ?></p>
                                <!-- <p class="mt20">Our development team focuses on unit testing, TDD, CI, design patterns and refactoring. Internal and external training is encouraged through mentoring, guided self-learning, conferences, user groups and training courses. We maintain and improve existing codebases, and create new systems, exposing developers to constant variety.</p>

                                <p>Our team sunderstands the performance implications of serving more than 25,000 page requests per-hour, crafting awesome user experiences. While we leverage existing tech, we also research new technologies to overcome technical and business challenges, to maintain our industry-leading status.</p> -->

                            </div>

                            <!-- Div wrapper -->
                            <!-- <div class="pt40">
                                <h5 class="mt40">Key Requirements</h5> -->

                                <!-- Start of List -->
                                <!-- <ul class="list mt20">
                                    <li>Personally passionate and up to date with current trends and technologies, committed to quality and comfortable working with adult media.</li>

                                    <li>Bachelor or Master degree level educational background.</li>

                                    <li>4 years relevant PHP dev experience.</li>

                                    <li>Troubleshooting, testing and maintaining the core product software and databases.</li>
                                </ul> -->
                                <!-- End of List -->

                            <!-- </div> -->

                            <!-- Div wrapper -->
                            <!-- <div class="pt40">
                                <h5 class="mt40">We Offer</h5> -->

                                <!-- Start of List -->
                                <!-- <ul class="list mt20">
                                    <li>An exciting job where you can assume responsibility and develop professionally.</li>

                                    <li>A dynamic team with friendly, highly-qualified colleagues from all over the world.</li>

                                    <li>Strong, sustainable growth and fresh challenges every day.</li>

                                    <li>Flat hierarchies and short decision paths.</li>
                                </ul> -->
                                <!-- End of List -->

                                <!-- <p class="mt40">If you feel that this is the place where you belong and start your career with a ton of new opportunities, please don't hasitate to apply for the job position.</p>
                            </div> -->


                    <!-- End of Job Details -->
                    <?php if($val['is_active']=='1' && count($retval_applied)==0){ if($_SESSION['profile_id']=='') { $_SESSION['job_id']=$_GET['job_id']; ?>
                      <a href="login.php" class="btn btn-blue btn-effect">Login To Apply</a>
                  <?php } else { ?>
                      <a href="#" class="btn btn-blue btn-effect" onclick="userCheck('<?php echo $user_check[0]["profile_completion"]; ?>');">Apply this job</a>
                  <?php } } ?>

                  <?php if(count($retval_applied) > 0) { ?>
                      <a href="#" class="btn btn-blue btn-effect" onclick="return false;">Applied</a>
                  <?php } ?>
                </div>
              </form>
              </div>
          </div>
                <!-- ===== End of Job Details ===== -->





            </div>
            <!-- End of Row -->



        </div>
    </section>
    <!-- ===== End of Main Wrapper Job Section ===== -->





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
include_once 'footer.php';
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

    <!-- Load Google Map -->
    <script>
        // Asynchronously Load the map API
        jQuery(function ($) {
            var script = document.createElement('script');
            script.src = "http://maps.googleapis.com/maps/api/js?sensor=false&callback=initialize";
            document.body.appendChild(script);
        });
    </script>
    <script type="text/javascript">
        function userCheck(profile_completion){
           if(profile_completion==1){
                document.apply_job.submit();
           } else {
                alert("Your Profile not yet completed. Please complete your profile information to apply this job.");
                window.location.href='submit-resume.php';
           }
        }
    </script>

</body>

</html>
