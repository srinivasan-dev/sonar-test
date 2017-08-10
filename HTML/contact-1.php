<?php
include_once('include/loader.php');
include_once('header.php');
if($userobj->getVariable('email')!="" && $userobj->getvariable("name") !="") {
    $message2 = '
    <table border="0" width="600" cellspacing="0" cellpadding="5" style="font-family: Verdana,Arial;font-size:12px;line-height: 13px;border:1px solid #A5BC26;" align="center">
    <tr>
        <td colspan="3" bgcolor="#A5BC26" align="center"><font color="#FFFFFF" size="2"><strong>Contact Information</strong></font></td>
    </tr>
    <tr>
        <td><b>Name</b></td>
        <td>:</td>
        <td>'.$userobj->getvariable("name").'</td>
    </tr>
    <tr>
        <td><b>Email Address</b></td>
        <td>:</td>
        <td>'.$userobj->getvariable("email").'</td>
    </tr>

    <tr>
        <td width="200"><b>Phone Number</b></td>
        <td>:</td>
        <td>'.$userobj->getvariable("phone").'</td>
    </tr>


    <tr>
        <td width="200"><b>Message</b></td>
        <td>:</td>
        <td>'.$userobj->getvariable("message").'</td>
    </tr>';
        $message2=$message2.'
    </table>';
    $message2=stripslashes($message2);

    $mail->From = $userobj->getvariable("email");
    $mail->FromName = $userobj->getvariable("name");
    $mail->addAddress($admin_email);
    $mail->Subject = "ETS- Contact US Leads";
    $mail->Body = $message2;
    $mail->Priority = 1;
    $mail->send();

    echo '<script type="text/javascript">window.location.href="contact-1.php?mode=send"</script>';
    die;
}

 ?>



    <!-- =============== Start of Page Header 1 Section =============== -->
    <section class="page-header">
        <div class="container">

            <!-- Start of Page Title -->
            <div class="row">
                <div class="col-md-12">
                    <h2>contact us</h2>
                </div>
            </div>
            <!-- End of Page Title -->

            <!-- Start of Breadcrumb -->
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb">
              <!--          <li><a href="#">home</a></li>
                        <li class="active">pages</li>
                  -->  </ul>
                </div>
            </div>
            <!-- End of Breadcrumb -->

        </div>
    </section>
    <!-- =============== End of Page Header 1 Section =============== -->





    <!-- ===== Start of Main Wrapper Section ===== -->
    <section class="ptb80" id="contact">
        <div class="container">
            <div class="row">
              <?php if($_GET['mode'] =="send"){ ?>
                  <p style="color:green;" class="text-center">Thanks for submitting your query. Our Team will contact you shortly.</p>
              <?php } ?>
                <div class="col-md-6 col-md-offset-3 col-xs-12">
                  <h3 class="text-blue">Contact us</h3>
                  <!--  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
-->
                    <!-- Start of Contact Form -->
                    <form class="mt30" name="frm_contact" id="frm_contact" method="post" onsubmit="return validate();">

                        <!-- contact result -->
                        <div id="contact-result"></div>
                        <!-- end of contact result -->

                        <!-- Form Group -->
                        <div class="form-group">
                            <input class="form-control input-box" type="text" name="name" id="name" placeholder="Your Name" autocomplete="off">
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <input class="form-control input-box" type="email" name="email" id="email" placeholder="your-email@youremail.com" autocomplete="off">
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <input class="form-control input-box" type="tel" name="phone"  id="phone" placeholder="Phone Number" autocomplete="off">
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <input class="form-control input-box" type="text" name="subject" id="subject" placeholder="Subject" autocomplete="off">
                        </div>

                        <!-- Form Group -->
                        <div class="form-group mb20">
                            <textarea class="form-control textarea-box" rows="8" name="message" id="message" placeholder="Type your message..."></textarea>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group text-center">
                            <button class="btn btn-blue btn-effect" type="submit" name="cmd_submit">Send message</button>
                        </div>
                    </form>
                    <!-- End of Contact Form -->
                </div>

                <!-- Start of Google Map -->
                <!-- <div class="col-md-6 col-xs-12 gmaps">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3103.5216649880963!2d-77.37463938412002!3d38.93490927956487!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89b64870cb7618d9%3A0x11c9c05e857a794d!2s2415+Andorra+Pl%2C+Reston%2C+VA+20191%2C+USA!5e0!3m2!1sen!2sin!4v1500286563419" width="100%" height="500" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div> -->
                <!-- End of Google Map -->

            </div>
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

    <!-- Load Google Map -->
    <!-- <script>
        // Asynchronously Load the map API
        jQuery(function ($) {
            var script = document.createElement('script');
            script.src = "http://maps.googleapis.com/maps/api/js?sensor=false&callback=initialize";
            document.body.appendChild(script);
        });
    </script> -->
    <script type="text/javascript">
        function validate() {
        var frm=document.frm_contact;
        var illegalChars = /^[A-Za-z]{3,100}$/;

        var str="";
        if(frm.name.value==""){
            str+="Name.\n";
        }else if(!illegalChars.test(frm.name.value)){
          str+="Enter valid name.\n";
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

        if(frm.phone.value==""){
             str+="Phone.\n";
        }
        if(frm.subject.value==""){
             str+="Subject.\n";
        }

        if(frm.message.value==""){
             str+="Message.\n";
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
