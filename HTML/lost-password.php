<?php
session_start();
ini_set('display_errors','0');
include_once('include/loader.php');

if($userobj->getVariable('email')!="" ){
    $query = "select * from tbl_resume where email='".$userobj->getVariable('email')."' and is_deleted=0";
    $retval=$sqlobj->getdatalistfromquery($query);

    if(count($retval) == 0){
        echo '<script type="text/javascript">window.location.href="lost-password.php?mode=error"</script>';
        die;
    }

    $data=array();
    $data["reset_request"]= '1';
    $data["reset_id"]= md5($userobj->getVariable('email'));
    $where = " email = '".$userobj->getVariable('email')."' ";
    $res =$sqlobj->save("tbl_resume",$data,$where);

    $message2 = "<p><b> Hi ".$retval[0]['first_name']."</b></p>";
    $message2 = "<p>Pleae click the below link to reset your account password.</p>";
    $message2 .="<p><a href='https://etwwstaffing.com/reset-password.php?track_id=".md5($userobj->getvariable("email"))."'>https://etwwstaffing.com/reset_password.php?track_id=".md5($userobj->getvariable("email"))."</a></p>";

    $message2=stripslashes($message2);

    $mail->From = $from_email;
    $mail->FromName = $from_name;
    $mail->addAddress($userobj->getvariable("email"));
    $mail->Subject = "ETWW- Request to reset Password";
    $mail->Body = $message2;
    $mail->Priority = 1;
    $mail->send();

    echo '<script type="text/javascript">window.location.href="lost-password.php?mode=success"</script>';
    die;
}

include_once('header.php');
?>




    <!-- =============== Start of Page Header 1 Section =============== -->
    <section class="page-header">
        <div class="container">

            <!-- Start of Page Title -->
            <div class="row">
                <div class="col-md-12">
                    <h2>lost password</h2>
                </div>
            </div>
            <!-- End of Page Title -->

            <!-- Start of Breadcrumb -->
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="#">home</a></li>
                        <li class="active">pages</li>
                    </ul>
                </div>
            </div>
            <!-- End of Breadcrumb -->

        </div>
    </section>
    <!-- =============== End of Page Header 1 Section =============== -->





    <!-- ===== Start of Login - Register Section ===== -->
    <section class="ptb80" id="login">
        <div class="container">
            <div class="col-md-6 col-md-offset-3 col-xs-12">

                <!-- Start of Login Box -->
                <div class="login-box">

                    <div class="login-title">
                        <h4>lost password</h4>
                    </div>

                    <!-- Start of Login Form -->
                    <!-- <form action="#"> -->
                    <form action="" name="frm_forgot_password" id="frm_forgot_password" method="post" onSubmit="return validate();" enctype="multipart/form-data">

                      <?php if($_GET['mode'] =="success"){ ?>
                          <p style="color:green;" class="text-center">We have sent an email to you with detailed information to reset your password.</p>
                      <?php } ?>

                      <?php if($_GET['mode'] =="error"){ ?>
                          <p style="color:red;" class="text-center">Entered Email ID is not exist in our database.</p>
                      <?php } ?>
                        <!-- Form Group -->
                        <div class="form-group">
                            <label>Enter Your Email</label>
                            <input type="email" class="form-control" placeholder="Email" name="email" id="email">
                        </div>

                        <!-- Form Group -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-blue btn-effect" name="cmd_submit">send email</button>
                            <a href="login.php" class="btn btn-blue btn-effect">login</a>
                        </div>

                    </form>
                    <!-- End of Login Form -->
                </div>
                <!-- End of Login Box -->

            </div>
        </div>
    </section>
    <!-- ===== End of Login - Register Section ===== -->




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

    <!--Light box-->
  <script type="text/javascript" charset="utf-8">
  function validate() {
      var frm=document.frm_forgot_password;
      var str="";


      if(frm.email.value==""){
          str+="Email Id.\n";
      } else if(document.frm_forgot_password.email.value!=''){
        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if(!(document.frm_forgot_password.email.value.match(mailformat)))
        {
          alert("You have entered an invalid email address!");
          document.frm_forgot_password.email.focus();
          return false;
        }
      }

      var msg="Please Enter the below details:\n...............................................................\n";
      if(str!="")  {
          alert(msg+str);
          return false;
      } else {
          frm.submit();
      }
  }
   </script>
  	<!--Light box-->

</body>

</html>
