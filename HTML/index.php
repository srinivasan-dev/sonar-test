<?php
include_once('include/loader.php');
// $query_job = "SELECT * FROM tbl_job_list WHERE  is_deleted=0 and is_active=0 order by updated_date desc limit 0,3 ";
$query_job = "SELECT * FROM tbl_job_list WHERE  is_deleted=0 and is_active=1 order by updated_date desc limit 0,5";
$retval=$sqlobj->getdatalistfromquery($query_job);

// SELECT cat.category,count(job.job_id), job.category from tbl_categories as cat LEFT JOIN tbl_job_list as job on job.category=cat.category

/* Popular category based latest job short_description */
$sql_mode = "SET sql_mode = ''";
$sqlobj->getdatalistfromquery($sql_mode);

/* Categories */
$cat = "SELECT cat.category,count(job.job_id), cat.short_description, cat.redirect_url, cat.favicon from tbl_categories as cat LEFT JOIN tbl_job_list as job on job.category=cat.category and job.is_active=1 group by cat.category order by COUNT(job.job_id) desc, cat.category ASC";
$desc_cat=$sqlobj->getdatalistfromquery($cat);

include_once('header.php');
?>

<!-- ===== Start of Main Search Section ===== -->
<section class="main overlay-black">

  <!-- Start of Wrapper -->
  <div class="container wrapper">
    <h1 class="capitalize text-center text-white">your career starts now</h1>
    <!-- Start of Form -->
    <form class="job-search-form row pt40" action="search-jobs-1.php" method="get">

      <!-- Start of keywords input -->
      <div class="col-md-3 col-sm-12 search-keywords">
        <label for="search-keywords">Keywords</label>
        <input type="text" name="search-keywords" id="search-keywords" placeholder="Keywords">
      </div>

      <!-- Start of category input -->
      <div class="col-md-3 col-sm-12 search-categories">
        <label for="search-categories">Category</label>
        <select name="search-categories" class="selectpicker" id="search-categories" data-live-search="true" title="Any Category" data-size="5" data-container="body">
          <?php foreach ($desc_cat as $key => $category) { ?>
            <<option value="<?php echo $category['category']; ?>"><?php echo $category['category']; ?></option>
            <?php } ?>
          <!-- <option value=".NET Programmer">.NET Programmer</option>
          <option value="Database Specialist">Database Specialist</option>
          <option value="Business Intelligence Specialist">Business Intelligence Specialist</option>
          <option value="Big Data Specialist">Big Data Specialist</option>
          <option value="Cloud Programmer">Cloud Programmer</option>
          <option value="Java Programmer">Java Programmer</option>
          <option value="UNIX Programmer">UNIX Programmer</option>
          <option value="Project Management">Project Management</option>
          <option value="Testing Engineer">Testing Engineer</option> -->
        </select>
      </div>

      <!-- Start of location input -->
      <div class="col-md-4 col-sm-12 search-location">
        <label for="search-location">Location</label>
        <input type="text" name="search-location" id="search-location" placeholder="Location">
      </div>

      <!-- Start of submit input -->
      <div class="col-md-2 col-sm-12 search-submit">
        <button type="submit" class="btn btn-blue btn-effect btn-large"><i class="fa fa-search"></i>search</button>
      </div>

    </form>
    <!-- End of Form -->

    <div class="extra-info pt20">
      <!--  <span class="text-left text-white"><b>36</b> job offers for <b>you.</b></span>
    --><!--                <a href="#" class="capitalize pull-right text-white">advanced search</a>
  -->        </div>

</div>
<!-- End of Wrapper -->

</section>
<!-- ===== End of Main Search Section ===== -->





<!-- ===== Start of Popular Categories Section ===== -->
<section class="ptb80" id="categories">
  <div class="container">

    <div class="section-title">
      <h2>popular categories</h2>
    </div>

    <!-- Loop test starts -->
    <!-- <div class="job-search-form row pt40"> -->
    <?php $row_count = 1;
    $mod_count = 5;
    foreach ($desc_cat as $key => $desc) {
      if($desc['count(job.job_id)']!=0){
        if($row_count%$mod_count == 0 || $row_count==1){ ?>
          <div class="job-search-form row pt40">
            <?php }
            ?>
            <!-- Start of Category div -->
            <div class="col-md-3 col-sm-6 col-xs-12 cat-wrapper">
              <div class="category ptb30">

                <!-- Icon -->
                <div class="category-icon">
                  <i class="<?php echo $desc['favicon'];?>"></i>
                </div>

                <!-- Category Info - Title -->
                <div class="category-info pt30">
                  <a href="search-jobs-1.php?search-categories=<?php echo $desc['category']; ?>"><?php echo $desc['category'] ?></a>
                  <!-- <p>(9 open positions)</p> -->

                  <p> <?php echo $desc['count(job.job_id)']; ?> </p>
                </div>

                <!-- Category Description -->
                <div class="category-descr">
                  <!-- <span>Lorem Ipsum is simply dummy text of the printing industry. Lorem has been the standard dummy text since 1500s.</span> -->

                  <!-- Getting short description from database for categories  -->
                  <span> <?php echo $desc['short_description'] ?>   </span>
                  <!-- Categories category short_description ends -->

                </div>
              </div>
            </div>
            <!-- End of Category div -->
            <?php
            if($row_count%4==0){
              if($row_count>$mod_count)
              $mod_count=$mod_count+4;
              ?>
            </div>
            <?php
          }
          $row_count++;
        }
      } if($row_count%$mod_count!=0 && $row_count!=1){
        ?>
      </div>
      <?php } ?>
      <!-- Loop test ends -->




      <div class="col-md-12 mt60 text-center">
        <a href="search-jobs-1.php" class="btn btn-blue btn-effect nomargin">browse all</a>
      </div>

    </div>
  </section>
  <!-- ===== End of Popular Categories Section ===== -->






  <!-- ===== Start of Job Post Section ===== -->
  <section class="ptb80" id="job-post">
    <div class="container">

      <!-- Start of Job Post Main -->
      <div class="col-md-12 col-sm-12 col-xs-12 job-post-main">
        <h2 class="capitalize"><i class="fa fa-briefcase"></i>latest jobs</h2>

        <!-- Start of Job Post Wrapper -->
        <div class="job-post-wrapper mt60">

          <!-- Start of Single Job Post 1 -->
          <?php foreach($retval as $key => $val) { ?>
            <div class="single-job-post row nomargin">
              <!-- Job Company -->
              <!-- <div class="col-md-2 col-xs-3 nopadding">
              <div class="job-company">
              <a href="company-page-1.html">
              <img src="images/companies/envato.svg" alt="">
            </a>
          </div>
        </div> -->

        <!-- Job Title & Info -->
        <div class="col-md-10 col-xs-9 ptb20">
          <div class="job-title">
            <!-- <a href="job-page.html">php senior developer</a> -->
            <a href="job-page.php?job_id=<?php echo $val['job_id']; ?>"><?php echo strtoupper($val['job_title']); ?></a>
          </div>

          <div class="job-info">
            <!-- <span class="company"><i class="fa fa-building-o"></i>envato</span>
            <span class="location"><i class="fa fa-map-marker"></i>Melbourn, Australia</span> -->

            <span class="company"><i class="fa fa-building-o"></i><?php echo $val['city']; ?></span>
            <span class="location"><i class="fa fa-map-marker"></i><?php echo $val['state']; ?></span>
          </div>
        </div>

        <!-- Job Category -->
        <!-- <div class="col-md-2 col-xs-3 ptb30">
        <div class="job-category">
        <a href="javascript:void(0)" class="btn btn-green btn-small btn-effect">full time</a>
      </div>
    </div> -->
    <div class="col-md-2 col-xs-3 ptb30">
      <div class="job-category">
        <a href="job-page.php?job_id=<?php echo $val['job_id']; ?>" class="btn btn-blue btn-small btn-effect">READ MORE</a>
      </div>
    </div>
  </div>

  <?php } ?>

  <!-- End of Single Job Post 1 -->

  <!-- Start of Single Job Post 2 -->
  <!--            <div class="single-job-post row nomargin">
-->                <!-- Job Company -->
<!--              <div class="col-md-2 col-xs-3 nopadding">
<div class="job-company">
<a href="company-page-1.html">
<img src="images/companies/google.svg" alt="">
</a>
</div>
</div>

-->            <!-- Job Title & Info -->
<!--          <div class="col-md-8 col-xs-6 ptb20">
<div class="job-title">
<a href="job-page.html">department head</a>
</div>

<div class="job-info">
<span class="company"><i class="fa fa-building-o"></i>google</span>
<span class="location"><i class="fa fa-map-marker"></i>berlin, germany</span>
</div>
</div>

-->          <!-- Job Category -->
<!--            <div class="col-md-2 col-xs-3 ptb30">
<div class="job-category">
<a href="javascript:void(0)" class="btn btn-purple btn-small btn-effect">part time</a>
</div>
</div>
</div>
-->        <!-- End of Single Job Post 2 -->

<!-- Start of Single Job Post 3 -->
<!--          <div class="single-job-post row nomargin">
-->            <!-- Job Company -->
<!--            <div class="col-md-2 col-xs-3 nopadding">
<div class="job-company">
<a href="company-page-1.html">
<img src="images/companies/facebook.svg" alt="">
</a>
</div>
</div>

-->          <!-- Job Title & Info -->
<!--            <div class="col-md-8 col-xs-6 ptb20">
<div class="job-title">
<a href="job-page.html">graphic designer</a>
</div>

<div class="job-info">
<span class="company"><i class="fa fa-building-o"></i>facebook</span>
<span class="location"><i class="fa fa-map-marker"></i>london, UK</span>
</div>
</div>

-->        <!-- Job Category -->
<!--            <div class="col-md-2 col-xs-3 ptb30">
<div class="job-category">
<a href="javascript:void(0)" class="btn btn-blue btn-small btn-effect">freelancer</a>
</div>
</div>
</div>
-->      <!-- End of Single Job Post 3 -->

<!-- Start of Single Job Post 4 -->
<!--                <div class="single-job-post row nomargin">
-->                <!-- Job Company -->
<!--                    <div class="col-md-2 col-xs-3 nopadding">
<div class="job-company">
<a href="company-page-1.html">
<img src="images/companies/envato.svg" alt="">
</a>
</div>
</div>

-->                <!-- Job Title & Info -->
<!--              <div class="col-md-8 col-xs-6 ptb20">
<div class="job-title">
<a href="job-page.html">senior UI & UX designer</a>
</div>

<div class="job-info">
<span class="company"><i class="fa fa-building-o"></i>envato</span>
<span class="location"><i class="fa fa-map-marker"></i>Melbourn, Australia</span>
</div>
</div>

-->          <!-- Job Category -->
<!--        <div class="col-md-2 col-xs-3 ptb30">
<div class="job-category">
<a href="javascript:void(0)" class="btn btn-orange btn-small btn-effect">intership</a>
</div>
</div>
</div>
-->    <!-- End of Single Job Post 4 -->

<!-- Start of Single Job Post 5 -->
<!--      <div class="single-job-post row nomargin">
-->        <!-- Job Company -->
<!--            <div class="col-md-2 col-xs-3 nopadding">
<div class="job-company">
<a href="company-page-1.html">
<img src="images/companies/twitter.svg" alt="">
</a>
</div>
</div>

-->        <!-- Job Title & Info -->
<!--          <div class="col-md-8 col-xs-6 ptb20">
<div class="job-title">
<a href="job-page.html">senior health advisor</a>
</div>

<div class="job-info">
<span class="company"><i class="fa fa-building-o"></i>twitter</span>
<span class="location"><i class="fa fa-map-marker"></i>New York, USA</span>
</div>
</div>

-->      <!-- Job Category -->
<!--        <div class="col-md-2 col-xs-3 ptb30">
<div class="job-category">
<a href="javascript:void(0)" class="btn btn-red btn-small btn-effect">temporary</a>
</div>
</div>
</div>
-->    <!-- End of Single Job Post 5 -->

</div>
<!-- End of Job Post Wrapper -->

<!-- Start of Pagination -->
<ul class="pagination list-inline text-center">
  <!--      <li class="active"><a href="javascript:void(0)">1</a></li>
  <li><a href="#">2</a></li>
  <li><a href="#">3</a></li>
  <li><a href="#">4</a></li>
  <li><a href="#">Next</a></li>
-->  <a href="search-jobs-1.php" class="btn btn-blue btn-effect mt10">View All Jobs</a>
</ul>
<!-- End of Pagination -->

</div>
<!-- End of Job Post Main -->


<!-- Start of Job Post Sidebar -->
<!--  <div class="col-md-4 col-xs-12 job-post-sidebar">
<h2 class="capitalize"><i class="fa fa-star"></i>golden jobs</h2>

-->  <!-- Start of Featured Job Widget -->
<!--    <div class="featured-job widget mt60">

-->    <!-- Start of Company Logo -->
<!--      <div class="company">
<img src="images/companies/cloudify.svg" alt="">
</div>
-->    <!-- End of Company Logo -->

<!-- Start of Featured Job Info -->
<!--    <div class="featured-job-info">

-->    <!-- Job Title -->
<!--      <div class="job-title">
<h5 class="uppercase pull-left">ui designer</h5>
-->    <!--  <a href="javascript:void(0)" class="btn btn-green btn-small btn-effect pull-right">full time</a>
--><!--  </div>
-->
<!-- Job Info -->
<!--                      <div class="job-info pt5">
<span id="company"><i class="fa fa-building-o"></i>cloudify</span>
<span id="location"><i class="fa fa-map-marker"></i>london, uk</span>
</div>

<p class="mt20"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
-->
<!-- View Job Button -->
<!--                      <div class="text-center mt20">
<a href="job-page.html" class="btn btn-blue btn-small btn-effect">view job</a>
</div>
</div>
-->              <!-- End of Featured Job Info -->

</div>
<!-- End of Featured Job Widget -->

<!-- Start of Upload Resume Widget -->
<!--      <div class="upload-resume widget mt40 text-center">
<h4 class="capitalize">upload your resume</h4>
<p class="mtb10"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry...</p>

<a href="register.php" class="btn btn-blue btn-effect mt10">upload resume</a>
</div>
-->  <!-- End of Upload Resume Widget -->
</div>
<!-- End of Job Post Sidebar -->

</div>
</section>
<!-- ===== End of Job Post Section ===== -->



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



<!-- ===== Start of CountUp Section ===== -->
<!--    <section class="ptb40" id="countup">
<div class="container">

-->        <!-- 1st Count up item -->
<!--          <div class="col-md-3 col-sm-3 col-xs-12">
<span class="counter" data-from="0" data-to="743"></span>
<h4>members</h4>
</div>
-->
<!-- 2nd Count up item -->
<!--          <div class="col-md-3 col-sm-3 col-xs-12">
<span class="counter" data-from="0" data-to="579"></span>
<h4>jobs</h4>
</div>
-->
<!-- 3rd Count up item -->
<!--          <div class="col-md-3 col-sm-3 col-xs-12">
<span class="counter" data-from="0" data-to="251"></span>
<h4>resumes</h4>
</div>

-->      <!-- 4th Count up item -->
<!--      <div class="col-md-3 col-sm-3 col-xs-12">
<span class="counter" data-from="0" data-to="330"></span>
<h4>companies</h4>
</div>

</div>
</section>
-->  <!-- ===== End of CountUp Section ===== -->





<!-- ===== Start of Testimonial Section ===== -->
<!--    <section class="ptb80" id="testimonials">
<div class="container">

-->        <!-- Section Title -->
<!--        <div class="section-title">
<h2 class="text-white">testimonials</h2>
</div>


-->    <!-- Start of Owl Slider -->
<!--        <div class="owl-carousel testimonial">

-->        <!-- Start of Slide item -->
<!--          <div class="item">
<div class="review">
<blockquote>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy t ext ever since the 1500s.</blockquote>
</div>
<div class="customer">
<img src="images/clients/client1.jpg" alt="">
<h4 class="uppercase pt20">Sophia</h4>
</div>
</div>
-->      <!-- End Slide item -->

<!-- Start of Slide item -->
<!--            <div class="item">
<div class="review">
<blockquote>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy t ext ever since the 1500s.</blockquote>
</div>
<div class="customer">
<img src="images/clients/client2.jpg" alt="">
<h4 class="uppercase pt20">Ethan Hunt</h4>
</div>
</div>
-->        <!-- End Slide item -->

<!-- Start of Slide item -->
<!--        <div class="item">
<div class="review">
<blockquote>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy t ext ever since the 1500s.</blockquote>
</div>
<div class="customer">
<img src="images/clients/client3.jpg" alt="">
<h4 class="uppercase pt20">Isabella</h4>
</div>
</div>
-->    <!-- End Slide item -->

<!-- Start of Slide item -->
<!--      <div class="item">
<div class="review">
<blockquote>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy t ext ever since the 1500s.</blockquote>
</div>
<div class="customer">
<img src="images/clients/client4.jpg" alt="">
<h4 class="uppercase pt20">Emma</h4>
</div>
</div>
-->                <!-- End Slide item -->
<!-- Start of Slide item -->
<!--              <div class="item">
<div class="review">
<blockquote>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy t ext ever since the 1500s.</blockquote>
</div>
<div class="customer">
<img src="images/clients/client5.jpg" alt="">
<h4 class="uppercase pt20">olivia</h4>
</div>
</div>
-->          <!-- End Slide item -->


<!--    </div>
-->    <!-- End of Owl Slider -->
<!---
</div>
</section>
-->    <!-- ===== End of Testimonial Section ===== -->





<!-- ===== Start of Latest News Section ===== -->
<!--    <section class="ptb80" id="latest-news">
<div class="container">

-->        <!-- Section Title -->
<!--      <div class="section-title">
<h2>latest news</h2>
</div>

-->  <!-- Start of Blog Post -->
<!--  <div class="col-md-4 col-xs-12">
<div class="blog-post">
-->      <!-- Blog Post Image -->
<!--    <div class="blog-post-thumbnail">
<a href="blog-post.html" class="hover-link">
<img src="images/blog/apple.jpg" alt="">
</a>
</div>

-->  <!-- Blog Post Info -->
<!--      <div class="post-info">
<a href="blog-post.html">Top 10 tipps for Web Developers</a>

<div class="post-details">
<span class="date"><i class="fa fa-calendar"></i>September 7, 2016</span>
<span class="comments"><i class="fa fa-comment"></i>0 Comments</span>
</div>

<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy t ext ever since the 1500s....</p>

</div>

-->  <!-- Read More Button -->
<!--                    <a href="blog-post.html" class="btn btn-blue btn-small btn-effect">read more</a>

</div>
</div>
-->        <!-- End of Blog Post -->

<!-- Start of Blog Post -->
<!--      <div class="col-md-4 col-xs-12">
<div class="blog-post">
-->          <!-- Blog Post Image -->
<!--        <div class="blog-post-thumbnail">
<a href="blog-post.html" class="hover-link">
<img src="images/blog/interview.jpg" alt="">
</a>
</div>

-->    <!-- Blog Post Info -->
<!--  <div class="post-info">
<a href="blog-post.html">How to prepare for an Interview</a>

<div class="post-details">
<span class="date"><i class="fa fa-calendar"></i>September 7, 2016</span>
<span class="comments"><i class="fa fa-comment"></i>0 Comments</span>
</div>

<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy t ext ever since the 1500s....</p>

</div>

-->  <!-- Read More Button -->
<!--    <a href="blog-post.html" class="btn btn-blue btn-small btn-effect">read more</a>

</div>
</div>
-->        <!-- End of Blog Post -->

<!-- Start of Blog Post -->
<!--      <div class="col-md-4 col-xs-12">
<div class="blog-post">
-->          <!-- Blog Post Image -->
<!--        <div class="blog-post-thumbnail">
<a href="blog-post.html" class="hover-link">
<img src="images/blog/freelance.jpg" alt="">
</a>
</div>

-->    <!-- Blog Post Info -->
<!--  <div class="post-info">
<a href="blog-post.html">Freelancing vs Employment</a>

<div class="post-details">
<span class="date"><i class="fa fa-calendar"></i>September 7, 2016</span>
<span class="comments"><i class="fa fa-comment"></i>0 Comments</span>
</div>

<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy t ext ever since the 1500s....</p>

</div>

-->    <!-- Read More Button -->
<!--  <a href="blog-post.html" class="btn btn-blue btn-small btn-effect">read more</a>

</div>
</div>
-->    <!-- End of Blog Post -->
<!--
<div class="col-md-12 col-xs-12 mt60 text-center">
<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>

<a href="blog-right-sidebar-v1.html" class="btn btn-blue btn-effect mt20">visit blog</a>
</div>

</div>
</section>
-->    <!-- ===== End of Latest News Section ===== -->







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
          <a class="forgot-password" href="lost-password.html">Forgot password?</a>
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
