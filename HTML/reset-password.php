<?php
session_start();
ini_set('display_errors','0');
include_once('include/loader.php');

if($userobj->getVariable('password')!="" && $userobj->getVariable('re_password')!="" && $userobj->getVariable('track_id')!=""){

    $data=array();
    $data["reset_request"]= '0';
    $data["password"]= $userobj->getVariable('password');
    $where = " reset_id = '".$userobj->getVariable('track_id')."' ";
    $res =$sqlobj->save("tbl_resume",$data,$where);

    echo '<script type="text/javascript">window.location.href="reset-password.php?mode=success"</script>';die;
}

if($userobj->getVariable('track_id')!=""){
   $query = "select * from tbl_resume where reset_id='".$userobj->getVariable('track_id')."' and is_deleted=0";
    $retval=$sqlobj->getdatalistfromquery($query);
    if(count($retval) == 0){
        echo '<script type="text/javascript">window.location.href="reset-password.php?mode=error"</script>';die;
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
          <?php if($_GET['mode'] =="success"){ ?>
              <p style="color:green;" class="text-center">Your password has been successfully updated.</p>
          <?php } ?>
            <?php if($_GET['mode'] =="error"){ ?>
                <p style="color:red;" class="text-center">Your Email ID is not exist in our database.</p>
            <?php } ?>

          <!-- Start of Login Form -->
          <form name="frm_change_pwd" onSubmit="return validate()" action="" method="post">

            <!-- Form Group -->
            <div class="form-group">
              <label>New Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="New Password" value="" required>
            </div>


                        <!-- Form Group -->
                        <div class="form-group">
                          <label>Confirm Password</label>
                          <input type="password" class="form-control" id="re_password" name="re_password" placeholder="Confirm Password" value="" required>
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


    if(frm.password.value==""){
      str+="Password.\n";
    }
    if((frm.password.value.length)<6){
      str+="Password should be minimum 6 character.\n";
    }
    if(frm.re_password.value==""){
      str+="Confirm Password.\n";
    }

    var msg="Please Enter the below details:\n...............................................................\n";
    if(str!="")  {
      alert(msg+str);
      return false;
    }else if(frm.password.value != frm.re_password.value){
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
