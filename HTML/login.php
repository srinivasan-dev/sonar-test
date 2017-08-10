<?php
include_once('include/loader.php');

if($userobj->getvariable("track_id")!=''){
    $rootqry="select * from tbl_resume where track_id='".$userobj->getVariable('track_id')."' and is_deleted=0";
    $rootname=$sqlobj->getdatalistfromquery($rootqry);
    if(count($rootname) > 0) {
        if($rootname[0]['account_status']==0){
            $data=array();
            $data["account_status"]= 1;
            $where=" track_id='".$userobj->getVariable('track_id')."'";
            $res =$sqlobj->save("tbl_resume",$data,$where);
            if($rootname[0]['password']!='')
            $success = "Your email has been confirmed. Please login below.";
            else
            $success = "Your email has been confirmed. You are not entered your password while register, to set your password please click <a href='lost-password.php'>Forgot Password?</a> and login";
        } else {
            $error = "Your email was already confirmed. Please login below.";
        }
    } else {
        $error = "You email address does not exist in our Database. Please click <a href='register.php'>Here</a> to create an account and confirm your email.";
    }
}

if($userobj->getVariable('txt_email')!="" && $userobj->getVariable('txt_pwd')!="" ){
  $query = "select * from tbl_resume where password='".$userobj->getVariable('txt_pwd')."' and email='".$userobj->getVariable('txt_email')."' and is_deleted=0";
  $retval=$sqlobj->getdatalistfromquery($query);
  if(count($retval) > 0) {

    if($retval[0]['account_status']==1) {
      $_SESSION['profile_id'] = $retval[0]['resume_id'];
      $_SESSION['user_name'] = $retval[0]['first_name'].' '.$retval[0]['last_name'];
      if(!empty($_POST["remember-me2"])) {
        setcookie ("member_login",$_POST["txt_email"],time()+ (10 * 365 * 24 * 60 * 60));
        setcookie ("member_password",$_POST["txt_pwd"],time()+ (10 * 365 * 24 * 60 * 60));
        $_COOKIE["member_login"]=$_POST["txt_email"];
        // echo $_COOKIE["member_login"];
      } else {
        if(isset($_COOKIE["member_login"])) {
          setcookie ("member_login","");
        }
        if(isset($_COOKIE["member_password"])) {
          setcookie ("member_password","");
        }
      }
      if($_SESSION['job_id']==''){
      echo '<script type="text/javascript">window.location.href="index.php"</script>';
      die;}else{
        echo '<script type="text/javascript">window.location.href="job-page.php?job_id='.$_SESSION['job_id'].'"</script>';
      }
    }else {
      $error = "Your email address not yet confirmed. Please confirm your email.";
    }
  } else {
    $error = "Invalid Email or Password.";
  }
}

include_once('header.php');

?>



<!-- =============== Start of Page Header 1 Section =============== -->
<section class="page-header">
  <div class="container">

    <!-- Start of Page Title -->
    <div class="row">
      <div class="col-md-12">
        <h2>login</h2>
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




  <!-- ===== Start of Login - Register Section ===== -->
  <section class="ptb80" id="login">
    <?php if($error !=""){ ?>
      <p style="color:red;" class="text-center"><?php echo $error; ?></p>
    <?php }else if($success !=""){ ?>
      <p style="color:green;" class="text-center"><?php echo $success; ?></p>
    <?php } ?>

    <br/>
    <br/>
    <div class="container">
      <div class="col-md-6 col-md-offset-3 col-xs-12">

        <!-- Start of Login Box -->
        <div class="login-box">

          <div class="login-title">
            <h4>login</h4>
          </div>

          <!-- Start of Login Form -->
          <form name="frm_login" action="" method="post">
            <!-- Form Group -->
            <div class="form-group">
              <label>Email</label>
              <input type="email" class="form-control" name="txt_email" id="txt_email" placeholder="Your Email" value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>">
            </div>

            <!-- Form Group -->
            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" id="txt_pwd" name="txt_pwd" placeholder="Your Password" value="<?php if(isset($_COOKIE["member_password"])) { echo $_COOKIE["member_password"]; } ?>">
            </div>

            <!-- Form Group -->
            <div class="form-group">
              <div class="row">
                <div class="col-xs-6">

                  <input type="checkbox" id="remember-me2" name="remember-me2" value="1" <?php if(isset($_COOKIE["member_login"])) { ?> checked <?php } ?>>
                  <label for="remember-me2">Remember me?</label>

                </div>

                <div class="col-xs-6 text-right">
                  <a href="lost-password.php">Forgot password?</a>
                </div>
              </div>
            </div>

            <!-- Form Group -->
            <div class="form-group text-center">
              <!-- <button class="btn btn-blue btn-effect" onclick="login_validate()">Login</button> -->
              <input type="button"  class="btn btn-blue btn-effect" onclick="login_validate()" value="Login">
              <a href="register.php" class="btn btn-blue btn-effect">signup</a>
            </div>

          </form>
          <!-- End of Login Form -->
        </div>
        <!-- End of Login Box -->

      </div>
    </div>

    <br/>
    <br/>
  </section>
  <!-- ===== End of Login - Register Section ===== -->






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
