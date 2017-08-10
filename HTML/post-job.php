<?php
include_once('include/loader.php');
include_once('header.php');

 ?>

    <!-- =============== Start of Page Header 1 Section =============== -->
    <section class="page-header">
        <div class="container">

            <!-- Start of Page Title -->
            <div class="row">
                <div class="col-md-12">
                    <h2>post a job</h2>
                </div>
            </div>
            <!-- End of Page Title -->

            <!-- Start of Breadcrumb -->
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="#">home</a></li>
                        <li class="active">for employers</li>
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

            <h3 class="uppercase text-blue">have an account?</h3>

            <!-- Start of Account Question -->
            <div class="row account-question">
                <div class="col-md-10 nopadding">
                    <p class="nomargin">If you don’t have an account you can create one on the form below by entering your email address. Your account details will be confirmed via email.</p>
                </div>

                <div class="col-md-2 text-right nopadding">
                    <a href="login.html" class="btn btn-blue btn-effect mt5">signin</a>
                </div>
            </div>
            <!-- End of Account Question -->




            <!-- Start of Post Job Form -->
            <form action="#" class="post-job-resume mt50">

                <!-- Start of Job Details -->
                <div class="row">
                    <div class="col-md-12">

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>your email</label>
                            <input class="form-control" type="text" required>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>job title</label>
                            <input class="form-control" type="text" required>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>location <span>(optional)</span></label>
                            <input class="form-control" type="text" placeholder='e.g. "Paris, France"'>
                            <span class="form-msg">Leave this blank if the Location is not important.</span>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>job type</label>
                            <select name="job-type" class="selectpicker" data-size="5" data-container="body" required>
                                <option value="">Choose Type</option>
                                <option value="1">Full Time</option>
                                <option value="2">Part Time</option>
                                <option value="3">Freelance</option>
                                <option value="4">Internship</option>
                                <option value="5">Temporary</option>
                            </select>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>job category</label>
                            <select name="job-type" class="selectpicker" data-size="5" data-container="body" required>
                                <option value="">Choose Category</option>
                                <option value="1">Accountance</option>
                                <option value="2">Banking</option>
                                <option value="3">Design & Art</option>
                                <option value="4">Developement</option>
                                <option value="5">Insurance</option>
                                <option value="6">IT Engineer</option>
                                <option value="7">Healthcare</option>
                                <option value="8">Marketing</option>
                                <option value="9">Management</option>
                            </select>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>job tags <span>(optional)</span></label>
                            <input class="form-control" type="text" placeholder='e.g. Wordpress Developer, Android Developer'>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>job description <span>(optional)</span></label>
                            <textarea class="tinymce"></textarea>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>application email or website</label>
                            <input class="form-control" type="text" placeholder='Enter your email address or a website URL' required>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>minimum rate per hour ($) <span>(optional)</span></label>
                            <input class="form-control" type="text" placeholder='e.g. 10$'>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>maximum rate per hour ($) <span>(optional)</span></label>
                            <input class="form-control" type="text" placeholder='e.g. 10$'>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>minimum salary ($) <span>(optional)</span></label>
                            <input class="form-control" type="text" placeholder='e.g. 1000$'>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>maximum salary ($) <span>(optional)</span></label>
                            <input class="form-control" type="text" placeholder='e.g. 5000$'>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>external link <span>(optional)</span></label>
                            <input class="form-control" type="text" placeholder='http://apply-for-job.com'>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>header image <span>(optional)</span></label>

                            <!-- Upload Button -->
                            <div class="upload-file-btn">
                                <span><i class="fa fa-upload"></i> Upload</span>
                                <input class="form-control" type="file" name="application_attachment" accept=".jpg,.png,.gif">
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End of Job Details -->




                <!-- Start of Company Details -->
                <div class="row mt30">
                    <div class="col-md-12">
                        <h3 class="capitalize pb20">company details</h3>

                        <!-- Form Group -->
                        <div class="form-group mt30">
                            <label>external link <span>(optional)</span></label>
                            <input class="form-control" type="text" placeholder='http://apply-for-job.com'>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>company name</label>
                            <input class="form-control" type="text" placeholder='Enter the name of your Company' required>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>website <span>(optional)</span></label>
                            <input class="form-control" type="text" placeholder='http://your-company-website.com'>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>tagline <span>(optional)</span></label>
                            <input class="form-control" type="text" placeholder='Briefly describe your Company'>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>Video <span>(optional)</span></label>
                            <input class="form-control" type="text" placeholder='e.g. youtube.com'>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>Twitter username <span>(optional)</span></label>
                            <input class="form-control" type="text" placeholder='@yourcompany'>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group">
                            <label>company logo <span>(optional)</span></label>

                            <!-- Upload Button -->
                            <div class="upload-file-btn">
                                <span><i class="fa fa-upload"></i> Upload</span>
                                <input type="file" name="application_attachment" accept=".jpg,.png,.gif">
                            </div>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group pt30 nomargin" id="last">
                            <button class="btn btn-blue btn-effect">submit</button>
                        </div>


                    </div>
                </div>
                <!-- End of Company Details -->


            </form>
            <!-- End of Post Job Form -->

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

</body>

</html>
