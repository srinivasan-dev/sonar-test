<?php
include_once('include/loader.php');
if($_SESSION['profile_id']==""){
  echo "<script>window.location='login.php'</script>";die;
}

$user_qry = "select * from tbl_resume where resume_id='".$_SESSION['profile_id']."' ";
$user=$sqlobj->getdatalistfromquery($user_qry);

$sql_cat="SELECT category from tbl_categories order by category ASC ";
$category=$sqlobj->getdatalistfromquery($sql_cat);

if($userobj->getVariable('first_name') !="" ) {
  $data["first_name"]         = $userobj->getVariable('first_name');
  $_SESSION['user_name']      = $userobj->getVariable('first_name');
  $data["phone"]              = $userobj->getVariable('phone');
  $data["country_code"]       = '+1';
  $data["category"]           = $userobj->getVariable('category');
  $data["experience"]         = $userobj->getVariable('experience');
  $data["document_name"]      = time().$_FILES['fil_resume']["name"];
  $data["resume_name"]        = $_FILES['fil_resume']["name"];
  $data["primary_skill"]      = serialize($userobj->getVariable('sel_skill'));
 $data["prefered_location"]  = $userobj->getVariable('sel_state');
  $data["profile_completion"] = 1;
  $data["updated_date"]       = time();
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

  if($userobj->getVariable('txt_more') !="")
    $data["tel_us_more"]   = $userobj->getVariable('txt_more');

  $where=" resume_id=".$_SESSION['profile_id'];
  $res =$sqlobj->save("tbl_resume",$data,$where);
  echo "<script>window.location='submit-resume.php?mode=saved'</script>";die;
}
include_once('header.php');

 ?>
    <!-- =============== Start of Page Header 1 Section =============== -->
    <section class="page-header">
        <div class="container">

            <!-- Start of Page Title -->
            <div class="row">
                <div class="col-md-12">
                    <h2>submit resume</h2>
                </div>
            </div>
            <!-- End of Page Title -->

            <!-- Start of Breadcrumb -->
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="#">home</a></li>
                        <li class="active">for canditates</li>
                    </ul>
                </div>
            </div>
            <!-- End of Breadcrumb -->

        </div>
    </section>
    <!-- =============== End of Page Header 1 Section =============== -->





    <!-- ===== Start of Main Wrapper Section ===== -->
    <section class="ptb80" id="post-job">
        <div class="container">

            <h3 class="uppercase text-blue">my account</h3>

            <!-- Start of Account Question -->
            <div class="row account-question">
                <div class="col-md-10 nopadding">
                  <?php if($_GET['mode']=='saved'){ ?>
                  <p class="text-center" style="color:green;"> Your account information has been updated successfully.</p>
                  <?php } ?>

                  <?php if($user[0]['phone']=="" || $user[0]['primary_skill']=="" || $user[0]['prefered_location']==""){ ?>
                  <p class="text-center" style="color:red;"> Your profile not yet completed. Please fill the below form to apply job.</p>
                  <?php } ?>
                    <!-- <p class="nomargin">If you don’t have an account you can create one on the form below by entering your email address. Your account details will be confirmed via email.</p> -->
                </div>

                <!-- <div class="col-md-2 text-right nopadding">
                    <a href="register.php" class="btn btn-blue btn-effect mt5">signup</a>
                </div> -->
            </div>
            <!-- End of Account Question -->




            <!-- Start of Post Resume Form -->
            <form  class="post-job-resume mt50" action="" name="frm_create" method="post" onSubmit="return validate();" enctype="multipart/form-data">

                <!-- Start of Resume Details -->
                <div class="row">
                    <div class="col-md-12">

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>your name</label>
                            <input class="form-control" name="first_name" class="" id="first_name"  type="text" value="<?php echo $user[0]['first_name'];?>" required>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>your email</label>
                            <input class="form-control" type="text" name="email" id="email" value="<?php echo $user[0]['email'];?>" disabled>
                        </div>
                        <!--phone no input  -->
                        <div class="form-group">
                            <label>your phone number</label>
                            <input class="form-control" type="text" name="phone" id="phone" placeholder="Maximum 10 digits" value="<?php echo $user[0]['phone'];?>" maxlength="10" required>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>your profession</label>
                            <input class="form-control" type="text" placeholder='e.g. "Android App Developer"' required>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>location</label>
                            <input class="form-control" type="text" placeholder='e.g. "Paris, France"'>
                            <!-- <span class="form-msg">Leave this blank if the Location is not important.</span> -->
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>your resume</label>

                            <!-- Upload Button -->
                            <div class="upload-file-btn">
                                <div id="fil_resume" style="display:<?php echo ($user[0]['resume_id']!="")?"none":"block";?>">
                                <span><i class="fa fa-upload"></i>upload Resume</span>
                                <input type="file" name="fil_resume"  accept=".pdf,.doc,.docx">
                              </div>
                                <div style="display:<?php echo ($user[0]['resume_id']=="")?"none":"block";?>" id="bannerDiv">
                    						<input type="file" id="link_cancel"  class="fa fa-upload" onclick="$('#fil_resume').show();$('#hint').show();$('#bannerDiv').hide();return false;">Change Resume
                                <a style="color: white;" href="../images/resumes/<?php echo ($user[0]['document_name']);?>" target="_blank" > - <?php echo ($user[0]['resume_name']);?></a>
                            </div>
                          </div>
                            <p id="hint" style="display:<?php echo ($user[0]['resume_id']!="")?"none":"block";?>">(Upload only .doc, .docx, .pdf files. Maximum File Size is 2MB)</p>
                          </div>
                        <!-- Form Group -->
                        <!-- <div class="form-group">
                            <label>video <span>(optional)</span></label>
                            <input class="form-control" type="text" placeholder='Link to a Video about yourself'>
                        </div> -->

                        <!-- Form Group -->
                        <div class="form-group">
                          <label>resume content</label>
                          <textarea class="tinymce"></textarea>
                        </div>

                        <!-- Form Group -->
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
                          <label>education</label>
                          <textarea class="tinymce"></textarea>
                        </div>

                        <!--  -->
                        <div class="form-group">
                            <label>Current Location</label>
                          <select name="sel_state" id="sel_state" class="selectpicker" data-size="5" data-container="body" required>
                              <option value="">State</option>
                              <option value="AK">Alaska(AK)</option>
                              <option value="AL">Alabama(AL)</option>
                              <option value="AR">Arkansas(AR)</option>
                              <option value="AZ">Arizona(AZ)</option>
                              <option value="CA">California(CA)</option>
                              <option value="CO">Colorado(CO)</option>
                              <option value="CT">Connecticut(CT)</option>
                              <option value="DC">District of Columbia(DC)</option>
                              <option value="DE">Delaware(DE)</option>
                              <option value="FL">Florida(FL)</option>
                              <option value="GA">Georgia(GA)</option>
                              <option value="HI">Hawaii(HI)</option>
                              <option value="IA">Iowa(IA)</option>
                              <option value="ID">Idaho(ID)</option>
                              <option value="IL">Illinois(IL)</option>
                              <option value="IN">Indiana(IN)</option>
                              <option value="KS">Kansas(KS)</option>
                              <option value="KY">Kentucky(KY)</option>
                              <option value="LA">Louisiana(LA)</option>
                              <option value="MA">Massachusetts(MA)</option>
                              <option value="MD">Maryland(MD)</option>
                              <option value="ME">Maine(ME)</option>
                              <option value="MI">Michigan(MI)</option>
                              <option value="MN">Minnesota(MN)</option>
                              <option value="MO">Missouri(MO)</option>
                              <option value="MS">Mississippi(MS)</option>
                              <option value="MT">Montana(MT)</option>
                              <option value="NC">North Carolina(NC)</option>
                              <option value="ND">North Dakota(ND)</option>
                              <option value="NE">Nebraska(NE)</option>
                              <option value="NH">New Hampshire(NH)</option>
                              <option value="NJ">New Jersey(NJ)</option>
                              <option value="NM">New Mexico(NM)</option>
                              <option value="NV">Nevada(NV)</option>
                              <option value="NY">New York(NY)</option>
                              <option value="OH">Ohio(OH)</option>
                              <option value="OK">Oklahoma(OK)</option>
                              <option value="OR">Oregon(OR)</option>
                              <option value="PA">Pennsylvania(PA)</option>
                              <option value="RI">Rhode Island(RI)</option>
                              <option value="SC">South Carolina(SC)</option>
                              <option value="SD">South Dakota(SD)</option>
                              <option value="TN">Tennessee(TN)</option>
                              <option value="TX">Texas(TX)</option>
                              <option value="UT">Utah(UT)</option>
                              <option value="VA">Virginia(VA)</option>
                              <option value="VT">Vermont(VT)</option>
                              <option value="WA">Washington(WA)</option>
                              <option value="WI">Wisconsin(WI)</option>
                              <option value="WV">West Virginia(WV)</option>
                              <option value="WY">Wyoming(WY)</option>
                              </select>
                        </div>

                        <!--  -->
                        <!-- <div class="form-group">
                            <label>resume category</label>
                            <select name="category" id="category" class="selectpicker" data-size="5" data-container="body" required>
                                <option value="">Choose Category</option> -->
                                <?php
                                // foreach ($category as $key => $cat) { ?>
                                  <!-- <<option value="<?php echo $cat['category']; ?>"><?php echo $cat['category']; ?></option> -->
                                  <?php
                                //  } ?>
                                <!-- <option value=".NET Programmer">.NET Programmer</option>
                                <option value="Database Specialist">Database Specialist</option>
                                <option value="Business Intelligence Specialist">Business Intelligence Specialist</option>
                                <option value="Big Data Specialist">Big Data Specialist</option>
                                <option value="Cloud Programmer">Cloud Programmer</option>
                                <option value="Java Programmer">Java Programmer</option>
                                <option value="UNIX Programmer">UNIX Programmer</option>
                                <option value="Project Management">Project Management</option>
                                <option value="Testing Engineer">Testing Engineer</option> -->
                            <!-- </select>
                        </div> -->


                        <!-- Form Group -->
                        <!-- <div class="form-group">
                            <label>Skills</label>
                            <input class="form-control" type="text" placeholder="Separate each skill with a comma" required>
                        </div> -->


                        <!-- Form Group -->
                        <div class="form-group">
                            <label>experience</label>
                            <input class="form-control" type="text" name="experience" id="experience" placeholder="Enter in Numbers, for example: 3" value="<?php echo $user[0]['experience'];?>" required>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group pt30 nomargin" id="last">
                            <button class="btn btn-blue btn-effect" name="cmd_submit">Update</button>
                        </div>

                    </div>
                </div>
                <!-- End of Resume Details -->

            </form>
            <!-- End of Post Resume Form -->

        </div>
    </section>
    <!-- ===== End of Main Wrapper Section ===== -->





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
          var illegalChars = /^[A-Za-z]{3,100}$/;
          var str="";

          if(frm.first_name.value==""){
              str+="Name.\n";
          }else if(!illegalChars.test(frm.first_name.value)){
            str+="Enter valid name.\n";
          }

          if(frm.phone.value==""){
              str+="Phone.\n";
          }

          if(frm.sel_skill.value==""){
              str+="Primary Skills.\n";
          }

          if(frm.sel_state.value==""){
              str+="Location Preference.\n";
          }
          if((frm.fil_resume.value=="") && $('#fil_resume').css('display')=="block" ){
            $("#fil_resume").show();
            str+='Upload Resume.';
          }

          var msg="Please Enter the below details:\n...............................................................\n";
          if(str!="")  {
              alert(msg+str);
              return false;
          } else {
              frm.submit();
          }
      }

      $('#sel_skill').val(<?php echo json_encode(unserialize($user[0]['primary_skill'])); ?>);
      $('#sel_state').val(<?php echo json_encode(($user[0]['prefered_location'])); ?>);
      $('#category').val(<?php echo json_encode(($user[0]['category'])); ?>);

</script>

</body>

</html>
