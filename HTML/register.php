<?php
include_once('include/loader.php');
include_once('header.php');
if( $userobj->getVariable('email')!=""  ){
    $query = "select * from tbl_resume where email='".$userobj->getVariable('email')."' and is_deleted=0";
    $retval=$sqlobj->getdatalistfromquery($query);
    if(count($retval) ==0){
      if($_FILES['fil_resume']['name']!=""){
        $filename=time().$_FILES['fil_resume']["name"];
        $tmp_name=$_FILES["fil_resume"]['tmp_name'];
        $up_fname='images/resumes/'.$filename;
        $up_fnamelarge=$verylarge_dir.$filename;
        copy($tmp_name,$up_fname);
        chmod($up_fname,0777);
        if(move_uploaded_file($tmp_name,$up_fname)) {
          copy($up_fname);
        }
      }
      $data=array();
      $data["first_name"]= $userobj->getVariable('first_name');
      // $data["last_name"]= $userobj->getVariable('last_name');
      $data["email"]= $userobj->getVariable('email');
      $data["phone"]= $userobj->getVariable('phone');
      $data["profession"]= $userobj->getVariable('profession');
      $data["experience"]= $userobj->getVariable('experience');
      $data["education"]= $userobj->getVariable('education');
      $data["content"]= $userobj->getVariable('content');
      $data["primary_skill "]=serialize($userobj->getVariable('sel_skill'));
      $data["prefered_location"]= $userobj->getVariable('prefered_location');
      $data["track_id"]= md5($userobj->getVariable('email'));
      $data["password"]= $userobj->getVariable('pwd');
      if($_FILES['fil_resume']["name"]!='')
      $data["document_name"]= time().$_FILES['fil_resume']["name"];
      $data["resume_name"]=$_FILES['fil_resume']["name"];
      $data["created_date"]=time();
      $data["updated_date"]=time();
      $res =$sqlobj->save("tbl_resume",$data,$where);
      $track_id = md5($userobj->getvariable("email")); //encrypting email

      $message2 = "<p>Thank you for creating account with us. Please confirm your email by clicking below link.</p>";
      $message2 .="<p><a href='https://etwwstaffing.com/login.php?track_id=".$track_id."'>https://etwwstaffing.com/email_confirmation.php?track_id=".$track_id."</a></p>";

      $message2=stripslashes($message2);

      $mail->From = $from_email;
      $mail->FromName = $from_name;
      $mail->addAddress($userobj->getvariable("email"));
      $mail->Subject="Confirm Your Email with ETWW.Inc";
      $mail->Body=$message2;
      $mail->Priority=1;
      $mail->send();
      echo '<script type="text/javascript">window.location.href="index.php?mode=created"</script>';
      die;
    } else {
      $error = "Email already exist.";
    }
}


?>

<!-- =============== Start of Page Header 1 Section =============== -->
<section class="page-header">
  <div class="container">


    <!-- Start of Page Title -->
    <div class="row">
      <div class="col-md-12">
        <h2>register</h2>
      </div>
    </div>
    <!-- End of Page Title -->

    <!-- Start of Breadcrumb -->
    <div class="row">
      <div class="col-md-12">
        <ul class="breadcrumb">
        <!--  <li><a href="#">home</a></li>
          <li class="active">pages</li>
      -->  </ul>
      </div>
    </div>
    <!-- End of Breadcrumb -->

  </div>
</section>
<!-- =============== End of Page Header 1 Section =============== -->


<!-- ===== Start of Login - Register Section ===== -->
<section class="ptb80" id="register">
  <div class="container">
    <div class="row">
      <div class="col-md-12">

        <!--  Error display start-->
        <?php if($error !=""){ ?>
          <p style="color:red;" class="text-center"><?php echo $error; ?></p>
          <?php } ?>
          <?php if($_GET['mode'] =="created"){ ?>
            <p style="color:green;" class="text-center">Thank you for creating an account with us. We have sent an email to you to confirm your account. If not received please wait for <b>little more</b>.</p>
            <?php } ?>
            <!--  Error display end-->

            <!-- Start of Nav Tabs -->
            <ul class="nav nav-tabs" role="tablist">

              <!-- Personal Account Tab -->
              <li role="presentation" class="active">
                <a href="#personal" aria-controls="personal" role="tab" data-toggle="tab" aria-expanded="true">
                  <h6>Create an Account</h6>
                  <!-- <span>a new account</span> -->
                </a>
              </li>

              <!-- Company Account Tab -->
              <!--      <li role="presentation" class="">
              <a href="#company" aria-controls="company" role="tab" data-toggle="tab" aria-expanded="false">
              <h6>Company Account</h6>
              <span>We are hiring</span>
            </a>
          </li>
        -->                  </ul>
        <!-- End of Nav Tabs -->



        <!-- Start of Tab Content -->
        <div class="tab-content ptb60">

          <!-- Start of Tabpanel for Personal Account -->
          <div role="tabpanel" class="tab-pane active" id="personal">
            <div class="row">
              <div class="col-md-8 col-md-offset-2">

                <!-- Form Group -->
                <form action="" name="frm_create" method="post"  enctype="multipart/form-data">
                  <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" class="form-control" name="first_name" id="name">
                  </div>

                  <!-- Form Group -->
                  <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" class="form-control" name="email" id="email">
                  </div>

                  <!-- Form Group -->
                  <div class="form-group">
                      <label>your phone number</label>
                      <input class="form-control" type="text" name="phone" id="phone" placeholder="Maximum 10 digits" value="<?php echo $user[0]['phone'];?>" maxlength="10" required>
                  </div>

                  <!-- Form Group -->
                  <div class="form-group">
                    <label>Your profession</label>
                    <input class="form-control" name="profession" type="text" placeholder='e.g. "Android App Developer"' required>
                  </div>

                  <!-- Form Group -->
                  <div class="form-group">
                    <label>Location <span>(optional)</span></label>
                    <input class="form-control" name="prefered_location" type="text" placeholder='e.g. "Paris, France"'>
                    <!-- <span class="form-msg">Leave this blank if the Location is not important.</span> -->
                  </div>

                  <!-- Form Group -->
                  <div class="form-group">
                    <label>Upload Your Resume</label>

                    <!-- Upload Button -->

                    <span><i class="fa fa-upload"></i></span>

                    <input type="file" name="fil_resume" id="fil_resume"  accept=".pdf,.doc,.docx">
                    <br/>
                    <p class="hint">(Upload only .doc, .docx, .pdf files. Maximum File Size is 2MB)</p>

                  </div>

                  <!-- Form Group -->
                                      <!-- <div class="form-group">
                                          <label>resume category</label>
                                          <select name="job-type" class="selectpicker" data-size="5" data-container="body" required>
                                              <option value="">Choose Category</option>
                                              <option value="1">.NET Programmer</option>
                                              <option value="2">Database Specialist</option>
                                              <option value="3">Business Intelligence Specialist</option>
                                              <option value="4">Big Data Specialist</option>
                                              <option value="5">Cloud Programmer</option>
                                              <option value="6">Java Programmer</option>
                                              <option value="7">UNIX Programmer</option>
                                              <option value="8">Project Management</option>
                                              <option value="9">Testing Engineer</option>
                                          </select>
                                      </div> -->

                                      <!-- Form Group -->
                                      <div class="form-group">
                                          <label>Resume content</label>
                                          <textarea class="tinymce" name="content" id="content"></textarea>
                                      </div>

                                      <!-- Form Group -->
                                      <!-- <div class="form-group">
                                          <label>Skills</label>
                                          <input class="form-control" type="text" placeholder="Separate each skill with a comma" required>
                                      </div> -->
                                      <div class="form-group">
                                          <label>Primary Skills</label>
                                          <select  multiple="multiple" name="sel_skill[]" id="sel_skill" class="selectpicker" title="Select Multiple Skills" data-size="5" data-container="body" required>
                                            <option value="Accounts">Accounts</option>
                                            <option value="ASP.Net">ASP.Net</option>
                                            <option value="Business Analysis">Business Analysis</option>
                                            <option value="Business Development">Business Development</option>
                                            <option value="C#.NET">C#.NET  </option>
                                            <option value="C/C++">C/C++ </option>
                                            <option value="Demandware">Demandware</option>
                                            <option value="Financial Analysis">Financial Analysis</option>
                                            <option value="Firewall/F5">Firewall/F5</option>
                                            <option value="Human Resource">Human Resource</option>
                                            <option value="Java">Java</option>
                                            <option value="linux">linux</option>
                                            <option value="Networking">Networking</option>
                                            <option value="PHP">PHP</option>
                                            <option value="Python">Python</option>
                                            <option value="Recruitment">Recruitment</option>
                                            <option value="Ruby">Ruby</option>
                                            <option value="Sales">Sales </option>
                                            <option value="Solution Engineer">Solution Engineer</option>
                                            <option value="Technical Recruiter">Technical Recruiter</option>
                                            <option value="Technical Support">Technical Support</option>
                                            <option value="Testing">Testing</option>
                                            <option value="UI/ UX Desginer">UI/UX Desginer</option>
                                        </select>
                                      </div>

                                      <!-- Form Group -->
                                      <div class="form-group">
                                          <label>Education</label>
                                          <textarea class="tinymce" name="education"></textarea>
                                      </div>

                                      <!-- Form Group -->
                                      <div class="form-group">
                                          <label>Experience</label>
                                          <textarea class="tinymce" name="experience"></textarea>
                                      </div>

                  <!-- Form Group -->
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="pwd" id="pwd">
                  </div>

                  <!-- Form Group -->
                  <div class="form-group mb30">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" name="confirm_pwd" id="confirm_pwd">
                  </div>

                  <!-- Form Group captcha -->
                  <div class="g-recaptcha" data-sitekey="6LddXSkUAAAAAGqFAOiAIgibMUrR8MD3duyHU9kQ"></div>
                  <br />
                  <!-- Form Group -->
                  <!-- <div class="form-group text-center">
                  <input type="checkbox" id="agree">

                  <label for="agree">Agree with the <a href="#">Terms and Conditions</a></label>
                </div> -->

                <!-- Form Group -->
                <div class="form-group text-center nomargin">
                  <button type="button" class="btn btn-blue btn-effect" onclick="validate()">create account</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- End of Tabpanel for Personal Account -->

        <!-- Start of Tabpanel for Company Account -->
        <div role="tabpanel" class="tab-pane" id="company">
          <div class="row">

            <!-- Start of the First Column -->
            <div class="col-md-6">

              <!-- Form Group -->
              <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control">
              </div>

              <!-- Form Group -->
              <div class="form-group">
                <label>E-mail</label>
                <input type="email" class="form-control">
              </div>

              <!-- Form Group -->
              <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control">
              </div>

              <!-- Form Group -->
              <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" class="form-control">
              </div>
            </div>
            <!-- End of the First Column -->

            <!-- Start of the Second Column -->
            <div class="col-md-6">

              <!-- Form Group -->
              <div class="form-group">
                <label>Full Name</label>
                <input type="text" class="form-control">
              </div>

              <!-- Form Group -->
              <div class="form-group">
                <label>Company Name</label>
                <input type="text" class="form-control">
              </div>

              <!-- Form Group -->
              <div class="form-group">
                <label>Website</label>
                <input type="text" class="form-control">
              </div>

              <!-- Form Group -->
              <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control">
              </div>
            </div>
            <!-- End of the Second Column -->
          </div>

          <div class="row mt20">
            <div class="col-md-12 text-center">

              <!-- Form Group -->
              <div class="form-group">
                <input type="checkbox" id="agree2">
                <label for="agree2">Agree with the <a href="#">Terms and Conditions</a></label>
              </div>

              <!-- Form Group -->
              <div class="form-group nomargin">
                <button type="submit" class="btn btn-blue btn-effect">create account</button>
              </div>

            </div>
          </div>

        </div>
        <!-- End of Tabpanel for Company Account -->

      </div>
      <!-- End of Tab Content -->

    </div>
  </div>
</div>
</section>
<!-- ===== End of Login - Register Section ===== -->





<!-- ===== Start of Get Started Section ===== -->
<!--<section class="get-started ptb40">
  <div class="container">
    <div class="row ">
-->
      <!-- Column -->
  <!--    <div class="col-md-10 col-sm-9 col-xs-12">
        <h3 class="text-white">20,000+ People trust Cariera! Be one of them today.</h3>
      </div>
-->
      <!-- Column -->
  <!--    <div class="col-md-2 col-sm-3 col-xs-12">
        <a href="#" class="btn btn-blue btn-effect">get start now</a>
      </div>

    </div>
  </div>
</section>
--><!-- ===== End of Get Started Section ===== -->



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
<script type="text/javascript" charset="utf-8">
function validate() {
  var frm=document.frm_create;
  var illegalChars = /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/;
  var basename = frm.fil_resume.value.split(/[\\/]/).pop(),
  pos = basename.lastIndexOf(".");
  var file_ext=basename.slice(pos + 1);
  if(frm.fil_resume.value!='')
  var file_size = $('#fil_resume')[0].files[0].size;
  var str="";

  if(frm.name.value==""){
    str+="Name.\n";
  }else if(!illegalChars.test(frm.name.value)){
    str+="Enter valid name.\n";
  }

  if (((tinymce.EditorManager.get('content').getContent()) == '')&&(frm.fil_resume.value=="")) {
            str+="Upload resume or Enter resume content.\n";
  }


  if(frm.email.value==""){
    str+="Email Id.\n";
  }else if(frm.email.value!=""){
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if(!(frm.email.value.match(mailformat)))
    {
        str+="Please enter a valid email address.\n";
    }
  }



  if(frm.fil_resume.value!=""){
  if(file_ext !="doc" && file_ext !="docx" && file_ext !="pdf"){
    str+="Upload only .doc,.docx, .pdf files.\n";
  } else if(file_size > (1024*1024*2)){
    str+="Maximum file size should be 2MB.\n";
  }
  }

  if((frm.confirm_pwd.value!="")||(frm.pwd.value!='')){

   if(frm.confirm_pwd.value!=frm.pwd.value){
      str+="Password should be same.\n";
    } else if((frm.pwd.value.length)<6){
      str+="Password should be minimum 6 character.\n";
  }
  }
  if (grecaptcha.getResponse() == ""){
    str+="Please verify the reCAPTCHA.\n";
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

</body>

</html>
