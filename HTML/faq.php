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
                    <h2>faq</h2>
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





    <!-- ===== Start of FAQ Section ===== -->
    <section class="ptb80" id="faq-page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <!-- Start of First Row -->
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3 class="uppercase">Frequently Asked Questions</h3>
                            <input type="text" class="live-search-box form-control mt20" placeholder="Search your Questions here.">
                        </div>
                    </div>
                    <!-- End of First Row -->



                    <!-- Start of Second Row -->
                    <div class="row mt40">

                        <!-- Start of Topic 1 -->
                        <div class="col-md-12 topic">
                            <!-- Question -->
                            <div class="open">
                                <h6 class="question" data-search-term="1. how does cloudify work?">1. How does ETWW work?</h6>
                                <i class="fa fa-angle-down hidden-xs"></i>
                            </div>

                            <!-- Answer -->
                            <p class="answer" style="display: none;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        </div>
                        <!-- End of Topic 1 -->

                        <!-- Start of Topic 2 -->
                        <div class="col-md-12 topic">
                            <!-- Question -->
                            <div class="open">
                                <h6 class="question" data-search-term="2. does it work on all devices?">2. How can I register?</h6>
                                <i class="fa fa-angle-down hidden-xs"></i>
                            </div>

                            <!-- Answer -->
                            <p class="answer" style="display: none;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        </div>
                        <!-- End of Topic 2 -->

                        <!-- Start of Topic 3 -->
                        <div class="col-md-12 topic">
                            <!-- Question -->
                            <div class="open">
                                <h6 class="question" data-search-term="3. where can i buy cloudify?">3. How can I submit my Resume?</h6>
                                <i class="fa fa-angle-down hidden-xs"></i>
                            </div>

                            <!-- Answer -->
                            <p class="answer" style="display: none;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        </div>
                        <!-- End of Topic 3 -->

                        <!-- Start of Topic 4 -->
                        <div class="col-md-12 topic">
                            <!-- Question -->
                            <div class="open">
                                <h6 class="question" data-search-term="4. how can i host my website on cloudify?">4. How can I post a Job?</h6>
                                <i class="fa fa-angle-down hidden-xs"></i>
                            </div>

                            <!-- Answer -->
                            <p class="answer" style="display: none;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        </div>
                        <!-- End of Topic 4 -->

  
                    </div>
                    <!-- End of Second Row -->

                </div>
            </div>
        </div>
    </section>
    <!-- ===== End of FAQ Section ===== -->





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

</body>

</html>
