<?php
include_once('include/loader.php');
if($_SESSION['profile_id']==""){
  echo "<script>window.location='login.php'</script>";die;
}

$user_qry = "select * from tbl_resume where resume_id='".$_SESSION['profile_id']."' ";
$user=$sqlobj->getdatalistfromquery($user_qry);
if($userobj->getVariable('pwd') !=""){
  if($user[0]["password"]==$userobj->getVariable('cpwd')) {
    $data["password"]         = $userobj->getVariable('pwd');
    $data["updated_date"]       = time();

    $where=" resume_id=".$_SESSION['profile_id'];
    $res =$sqlobj->save("tbl_resume",$data,$where);
    echo "<script>window.location='change-password.php?mode=saved'</script>";die;
  }
  else{
    $error ="Invalid Current Password." ;
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
        <h2>Change Password</h2>
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

    <br/>
    <br/>
    <div class="container">
      <div class="col-md-6 col-md-offset-3 col-xs-12">

        <!-- Start of Login Box -->
        <div class="login-box">

          <div class="login-title">
            <h4>Change Password</h4>
          </div>
          <br />
          <p style="color:red;" class="text-center"><?php echo $error; ?></p>
          <?php if($_GET['mode']=='saved'){ ?>
            <p class="text-center" style="color:green;"> Your account information has been updated successfully.</p>
            <?php } ?>

          <!-- Start of Login Form -->
          <form name="frm_change_pwd" onSubmit="return validate()" action="" method="post">
            <!-- Form Group -->
            <div class="form-group">
              <label>Current Password</label>
              <input type="password" class="form-control" id="cpwd" name="cpwd" placeholder="Current Password" value="" required>

            </div>

            <!-- Form Group -->
            <div class="form-group">
              <label>New Password</label>
              <input type="password" class="form-control" id="pwd" name="pwd" placeholder="New Password" value="" required>
            </div>


                        <!-- Form Group -->
                        <div class="form-group">
                          <label>Confirm Password</label>
                          <input type="password" class="form-control" id="confirm_pwd" name="confirm_pwd" placeholder="Confirm Password" value="" required>
                        </div>


            <!-- Form Group -->
            <div class="form-group text-center">
               <button class="btn btn-blue btn-effect" name="cmd_submit" onclick="login_validate()">Confirm</button>
            <!--  <input type="button"  class="btn btn-blue btn-effect" onclick="login_validate()" value="Login">
              <a href="register.php" class="btn btn-blue btn-effect">signup</a>
          -->  </div>

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
  <script type="text/javascript" charset="utf-8">
  function validate() {
    var frm=document.frm_change_pwd;

    var str="";

    if(frm.cpwd.value==""){
      str+="Current Password.\n";
    }

    if(frm.pwd.value==""){
      str+="Password.\n";
    }
    if((frm.pwd.value.length)<6){
      str+="Password should be minimum 6 character.\n";
    }
    if(frm.confirm_pwd.value==""){
      str+="Confirm Password.\n";
    }

    var msg="Please Enter the below details:\n...............................................................\n";
    if(str!="")  {
      alert(msg+str);
      return false;
    }else if(frm.pwd.value != frm.confirm_pwd.value){
      str+="New password and Confirm password are mismatch.\n";
      alert(str);
      return false;
    } else {
      frm.submit();
    }
  }

  </script>
</body>

</html>
