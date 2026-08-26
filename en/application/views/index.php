<?php
$authUrl = google_login_url();
$user_id = $this->session->userdata('user_id');
if (!empty(trim((string) $user_id))) {
    header('Location:' . base_url() . 'en/web/records');
}
?>
<!doctype html>
<html class="no-js" lang="zxx">

    <head>
        <meta charset="utf-8">
        <meta name="author" content="Sumon Rahman">
        <meta name="description" content="">
        <meta name="keywords" content="HTML,CSS,XML,JavaScript">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Title -->
        <title>Ntotalworld</title>
        <!-- Place favicon.ico in the root directory -->
        <link rel="shortcut icon" type="image/ico" href="<?php echo base_url(); ?>images/publishat1.png" />
        <!-- Plugin-CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="<?php echo base_url(); ?>styles/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>styles/linearicons.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>styles/magnific-popup.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>styles/animate.css">
        <!-- Main-Stylesheets -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>styles/normalize.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>styles/style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>styles/responsive.css">
        <script src="<?php echo base_url(); ?>js/vendor/modernizr-2.8.3.min.js"></script>
        <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
        <style>
            .feature-area {
                background: #66b3ea !important;
            }
        </style>
    </head>

    <body data-spy="scroll" data-target=".mainmenu-area">
        <!-- Preloader-content -->
        <div class="preloader">
            <span><i class="lnr lnr-sun"></i></span>
        </div>
        <!-- MainMenu-Area -->
        <nav class="mainmenu-area" data-spy="affix" data-offset-top="200">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#primary_menu">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a href="<?php echo base_url(); ?>" class="navbar-brand">
                    <h2>NTOTALWORLD</h2>
                </a>
                <a href="https://itunes.apple.com/in/app/publishat/id1067625164?mt=8"><img style="border-radius:5px;" src="<?php echo base_url(); ?>images/appstore5.jpg" alt="apple icon"> </a>
                <a href="https://play.google.com/store/apps/details?id=com.nadboy.publishat"><img src="<?php echo base_url(); ?>images/google2.png" alt="Play Store Icon"></a>
            </div>
            <div class="collapse navbar-collapse" id="primary_menu">
                <ul class="nav navbar-nav mainmenu">
                    <li class="active"><a href="<?php echo base_url(); ?>web">Home</a></li>
                    <li><a href="#features_page">About</a></li>
                    <!-- <li><a href="#gallery_page">Gallery</a></li>-->
                    <li><a href="#download_page">Products</a></li>
                    <li><a href="#price_page">Pricing</a></li>
                    <li><a href="#blogs_page">Blog</a></li>
                    <li><a href="#contact_page">Contact</a></li>
                </ul>
            </div>
        </nav>
        <!-- MainMenu-Area-End -->
        <!-- Home-Area -->
        <header class="home-area overlay" id="home_page">
            <div class="container">
                <div class="col-xs-12 hidden-sm col-md-2">
                    <figure class="mobile-image wow fadeInUp" data-wow-delay="0.2s">
                        <!-- <img src="<?php echo base_url(); ?>images/phone1.png" alt="">-->
                    </figure>
                </div>
                <div class="col-xs-12 col-md-8">
                    <div class="space-80 hidden-xs"></div>
                    <h3 class="wow fadeInUp" data-wow-delay="0.4s">Digitize your PERSONAL data for Lifetime and beyond.</h3>
                    <h3 class="wow fadeInUp" data-wow-delay="0.4s">We encrypt your data and create a personal blockchain for you.</h3>
                    <div class="space-20"></div>
                    <a href="<?php echo $authUrl; ?>" class="bttn-white wow fadeInUp" data-wow-delay="0.8s"><i class="right-button hidden-xs"></i>sign in with google</a>
                </div>
            </div>
        </header>
        <!-- Home-Area-End -->

        <!-- Feature-Area -->
        <section class="feature-area over" id="features_page">
            <div class="container">

                <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                    <div class="page-title text-center">
                        <h3 class="title">About</h3>
                        <div class="space-10"></div>
                        <h4>Powerful Features As Always</h4>
                        <div class="space-60"></div>
                    </div>
                </div>


                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="service-box wow fadeInUp" data-wow-delay="0.2s">
                        <div class="box-icon">
                            <i class="lnr lnr-user"></i>
                        </div>

                        <h4>Consolidate your personal data.</h4>

                    </div>
                    <div class="space-60"></div>
                    <div class="service-box wow fadeInUp" data-wow-delay="0.4s">
                        <div class="box-icon">
                            <i class="lnr lnr-earth"></i>
                        </div>
                        <h4>Access your Data anywhere anytime across globe.</h4>

                    </div>
                    <div class="space-60"></div>
                    <div class="service-box wow fadeInUp" data-wow-delay="0.6s">
                        <div class="box-icon">
                            <i class="lnr lnr-database"></i>
                        </div>
                        <h4>Prevent Data loss.</h4>

                    </div>
                    <div class="space-60"></div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="service-box wow fadeInUp" data-wow-delay="0.2s">
                        <div class="box-icon">
                            <i class="lnr lnr-users"></i>
                        </div>
                        <h4>Pass on Critical information to next generations.</h4>

                    </div>
                    <div class="space-60"></div>
                    <div class="service-box wow fadeInUp" data-wow-delay="0.4s">
                        <div class="box-icon">
                            <i class="lnr lnr-map-marker"></i>
                        </div>
                        <h4>Easy to track all your assets at one place.</h4>

                    </div>
                    <div class="space-60"></div>
                    <div class="service-box wow fadeInUp" data-wow-delay="0.6s">
                        <div class="box-icon">
                            <i class="lnr lnr-plus-circle"></i>
                        </div>
                        <h4>Easy to claim your insurance.</h4>

                    </div>
                    <div class="space-60"></div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="service-box wow fadeInUp" data-wow-delay="0.2s">
                        <div class="box-icon">
                            <i class="lnr lnr-thumbs-up"></i>
                        </div>
                        <h4>Digitize your personal data for Lifetime and beyond..</h4>

                    </div>
                    <div class="space-60"></div>
                    <div class="service-box wow fadeInUp" data-wow-delay="0.4s">
                        <div class="box-icon">
                            <i class="lnr lnr-code"></i>
                        </div>
                        <h4>Encrypt your data and create a personal blockchain.</h4>

                    </div>
                    <div class="space-60"></div>
                    <div class="service-box wow fadeInUp" data-wow-delay="0.6s">
                        <div class="box-icon">
                            <i class="lnr lnr-hand"></i>
                        </div>
                        <h4>Prevent document theft.</h4>

                    </div>
                    <div class="space-60"></div>
                </div>
            </div>
        </section>
        <!-- Feature-Area-End -->

        <!-- Gallery-Area -->
        <section class="gallery-area gallery" id="gallery_page">
            <!--
        <div class="container-fluid">
                <div class="col-xs-12 col-sm-3 gallery-slider">
                     <div class="gallery-slide">
					    <div class="item"><img src="<?php echo base_url(); ?>images/1.jpeg" alt=""></div>
                        <div class="item"><img src="<?php echo base_url(); ?>images/2.jpeg" alt=""></div>
                        <div class="item"><img src="<?php echo base_url(); ?>images/3.jpeg" alt=""></div>
                        <div class="item"><img src="<?php echo base_url(); ?>images/4.jpeg" alt=""></div>
						 <div class="item"><img src="<?php echo base_url(); ?>images/5.jpeg" alt=""></div>
                        <div class="item"><img src="<?php echo base_url(); ?>images/6.jpeg" alt=""></div>
                        <div class="item"><img src="<?php echo base_url(); ?>images/7.jpeg" alt=""></div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-3">
                    <div class="page-title">
					<div class="space-100"></div>
                        <h5 class="title">NTOTALWORLD</h5>
                    </div>
                    <div class="space-20"></div>
                    <div class="desc wow fadeInUp" data-wow-delay="0.6s">
                        <p>Consolidate your personal data,Access your Data anywhere anytime across globe,Prevent Data loss,Pass on critical information to next generations,Easy to claim your insurance,Easy to track all your assets at one place,Prevent document theft.</p>
                    </div>
                </div>
        </div>-->
        </section>
        <!-- Gallery-Area-End -->

        <!-- Download-Area -->
        <div class="download-area download" id="download_page">
            <div class="container">
                <div class="col-xs-12 col-sm-6 hidden-sm">
                    <div class="page-title">
                        <div class="space-100"></div>
                        <h5 class="title">NTOTALWORLD</h5>
                    </div>
                    <div class="space-20"></div>
                    <div class="desc wow fadeInUp" data-wow-delay="0.6s">
                        <p>Consolidate your personal data,Access your Data anywhere anytime across globe,Prevent Data loss,Pass on critical information to next generations,Easy to claim your insurance,Easy to track all your assets at one place,Prevent document theft.</p>
                    </div>
                    <!-- <figure class="mobile-image">
                        <img src="<?php echo base_url(); ?>images/phone1.png" alt="">
                    </figure> -->
                </div>
                <div class="col-xs-12 col-md-6 section-padding">
                    <h3 class="white-color">Products</h3>
                    <div class="space-10"></div>
                    <p>Downlaod APP now.</p>
                    <div class="space-20"></div>
                    <a href="https://itunes.apple.com/in/app/publishat/id1067625164?mt=8"><img style="border-radius:5px;" src="<?php echo base_url(); ?>images/appstore5.jpg" alt="apple icon"> </a>
                    <a href="https://play.google.com/store/apps/details?id=com.nadboy.publishat"><img src="<?php echo base_url(); ?>images/google2.png" alt="Play Store Icon"></a><br>
                    <div class="space-60"></div>
                    <p>You have to make your websites with love this days.</p>
                    <div class="space-10"></div>
                    <a href="https://chrome.google.com/webstore/detail/publishat/lddlembbffkdjgeicgpioflneapddjho"><span style="color: white;border: 1px solid white;padding: 9px;border-radius: 8px;font-weight: bold;"><i class="fa fa-puzzle-piece extension" aria-hidden="true"></i>&nbsp;Browser Extension</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Download-Area-End -->
        <!--Price-Area -->
        <div class=" price-area pricing" id="price_page">
            <div class="container">
                <div class="col-xs-12">
                    <div class="page-title text-center">
                        <div class="space-90"></div>
                        <h3 class="textprop">Pricing Plan</h3>
                    </div>
                </div>
                <div class="row menuclass pricing">
                    <div class="col-md-offset-2 col-md-8 col-md-offset-2 col-xs-12" style="margin-top:3%">
                        <p class="textprop">Why to pay for the unused data and we support on demand data storage.
                            Just Compare features and pay for the used data only.</p>
                        <p class="textprop"> Here is Price comparison.</p>
                        <table class="table  table-responsive textprop" style="">
                            <thead>
                                <tr class="tablehead">
                                    <td>Feature</td>
                                    <td align="center">Ntotalworld</td>
                                    <td align="center">Google Drive</td>
                                    <td align="center">Drop Box</td>
                                    <td align="center">Box</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Desktop App</td>
                                    <td align="center"><span class="glyphicon glyphicon-ok wrongprop"></td>
                                    <td align="center"><span class="glyphicon glyphicon-ok correctprop"></td>
                                    <td align="center"><span class="glyphicon glyphicon-ok correctprop"></td>
                                    <td align="center"><span class="glyphicon glyphicon-remove wrongprop"></td>
                                </tr>
                                <tr>
                                    <td>Screen Capture</td>
                                    <td align="center"><span class="glyphicon glyphicon-ok correctprop"></td>
                                    <td align="center"><span class="glyphicon glyphicon-ok correctprop"></td>
                                    <td align="center"><span class="glyphicon glyphicon-remove wrongprop"></td>
                                    <td align="center"><span class="glyphicon glyphicon-remove wrongprop"></td>
                                </tr>
                                <tr>
                                    <td>Pre Defined Folder Structure</td>
                                    <td align="center"><span class="glyphicon glyphicon-ok correctprop"></td>
                                    <td align="center"><span class="glyphicon glyphicon-remove wrongprop"></td>
                                    <td align="center"><span class="glyphicon glyphicon-remove wrongprop"></td>
                                    <td align="center"><span class="glyphicon glyphicon-remove wrongprop"></td>
                                </tr>
                                <tr>
                                    <td>Encryption</td>
                                    <td align="center"><span class="glyphicon glyphicon-ok correctprop"></td>
                                    <td align="center"><span class="glyphicon glyphicon-remove wrongprop"></td>
                                    <td align="center"><span class="glyphicon glyphicon-remove wrongprop"></td>
                                    <td align="center"><span class="glyphicon glyphicon-remove wrongprop"></td>
                                </tr>
                                <tr>
                                    <td>Data Storage</td>
                                    <td align="center">10GB</td>
                                    <td align="center">30GB</td>
                                    <td align="center">1TB</td>
                                    <td align="center">100GB</td>
                                </tr>
                                <tr>
                                    <td>Price $Per User Per Month</td>
                                    <td align="center">2</td>
                                    <td align="center">5</td>
                                    <td align="center">12.5</td>
                                    <td align="center">5</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--Price-Area-End -->

        <!--blog-Area-->

        <div class="blogs" id="blogs_page">
            <div class="container">
                <div class="col-xs-12">
                    <div class="page-title text-center">
                        <div class="space-90"></div>
                        <h3 class="textprop">BLOGS</h3>
                    </div>
                </div>
                <div class="row menuclass blogs">
                    <?php
                    $query = $this->mongodb->get('Articles');
                    if (count($query ?? []) > 0) {
                        foreach ($query as $data) {

                            $id = $data['_id'];
                            $heading = $data['articleheading'];
                            $articledes = $data['ArticleDescription'];
                            $string = strip_tags($articledes);
                            if (strlen($string) > 500) {
                                $stringCut = substr($string, 0, 500);
                                $string = substr(
                                    $stringCut,
                                    0,
                                    strrpos($stringCut, ' '),
                                );
                            }
                            $user_id = $data['UserId'];
                            $date = $data['Date'];
                            $this->mongodb->where(['UserId' => $user_id]);
                            $res = $this->mongodb->get('User');
                            if (count($res ?? []) > 0) {
                                foreach ($res as $data) {
                                    $name = $data['Name'];
                                }
                            }
                            ?>
                    <div class="col-md-12" style="border-bottom:1px solid #ddd;">
                        <h2><a href="<?php echo base_url(); ?>web/articleinfo?id=<?= $id ?>"><?= $heading ?></a></h2>
                        <span class="col-md-12">POSTED ON <b><?= $date ?></b> BY <b><?= $name ?></b></span>
                        <div class="col-md-10 desc" style="color:black;"><?= $string ?>
                        </div>
                        <div class="col-md-12">
                            <a href="<?php echo base_url(); ?>web/articleinfo?id=<?= $id ?>">ReadMore..</a>
                        </div>
                    </div>
                    <?php
                        }
                    }
                    ?>
                </div>


            </div>
        </div>

        <!--blog-Area-End-->

        <!-- Footer-Area -->
        <footer class="footer-area" id="contact_page">
            <div class="section-padding">
                <div class="container">

                    <div class="col-xs-12">
                        <div class="page-title text-center">
                            <h5 class="title">Contact US</h5>
                            <h3 class="dark-color">Find Us By Bellow Details</h3>
                            <div class="space-60"></div>
                            <!-- <div class="map_directions col-md-12 col-xs-12"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15217.84129121841!2d78.3530287!3d17.5332572!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xa521ff3a9d738a2c!2sPublishat!5e0!3m2!1sen!2sin!4v1454661310993" width="100%" height="140" frameborder="0" style="border:0" allowfullscreen></iframe></div>-->

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
                            <div class="footer-box">
                                <div class="box-icon">
                                    <span class="lnr lnr-map-marker"></span>
                                </div>
                                <p>
                                    <!-- iPublish Advanced Technology Solutions
								<br /> House #: 8-5/739, Plot #: 739,
								<br /> Bachupally village, 
								<br /> Quthbullapur mandal, 
								<br /> Ranga Reddy district,
								<br /> Hyderabad, 
								<br /> PIN: 500090,
								<br />Telangana, India -->
                                    Singular Analysts Inc,
                                    <br /> 17440 dallas pkwy dallas tx 75287
                                </p>
                            </div>
                            <div class="space-30 hidden visible-xs"></div>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <div class="footer-box">
                                <div class="box-icon">
                                    <span class="lnr lnr-phone-handset"></span>
                                </div>
                                <p style="padding-left:130px;">+1 614 371 4388<br /> +1 469 300 6363</p>
                            </div>
                            <div class="space-30 hidden visible-xs"></div>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <div class="footer-box">
                                <div class="box-icon">
                                    <span class="lnr lnr-envelope"></span>
                                </div>
                                <p style="padding-left:110px;">contact@ntotalworld.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer-Bootom -->
            <div class="footer-bottom">
                <div class="container">

                    <div class="col-xs-12 col-md-6">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        <span>Copyright &copy;<script>
                                document.write(new Date().getFullYear());
                            </script> iPublish Advanced Technology Solutions Pvt Ltd </span>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        <div class="space-30 hidden visible-xs"></div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="footer-menu">
                            <ul>
                                <li><a href="<?php echo base_url(); ?>web/aboutus">About</a></li>
                                <li><a href="<?php echo base_url(); ?>web/terms">Terms</a></li>
                                <li><a href="<?php echo base_url(); ?>web/privacy">Privacy</a></li>
                                <li><a href="<?php echo base_url(); ?>web/cancellation">Cancellation Policy</a></li>

                                <!-- <li><a href="#price_page">Pricing</a></li>
                                <li><a href="#features_page">Features</a></li>-->

                                <li><a href="<?php echo base_url(); ?>web/contactus">Contact</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Footer-Bootom-End -->
        </footer>
        <!-- Footer-Area-End -->
        <!--Vendor-JS-->
        <script src="<?php echo base_url(); ?>js/vendor/jquery-1.12.4.min.js"></script>
        <script src="<?php echo base_url(); ?>js/vendor/jquery-ui.js"></script>
        <script src="<?php echo base_url(); ?>js/vendor/bootstrap.min.js"></script>
        <!--Plugin-JS-->
        <script src="<?php echo base_url(); ?>js/owl.carousel.min.js"></script>
        <script src="<?php echo base_url(); ?>js/contact-form.js"></script>
        <script src="<?php echo base_url(); ?>js/ajaxchimp.js"></script>
        <script src="<?php echo base_url(); ?>js/scrollUp.min.js"></script>
        <script src="<?php echo base_url(); ?>js/magnific-popup.min.js"></script>
        <script src="<?php echo base_url(); ?>js/wow.min.js"></script>
        <!--Main-active-JS-->
        <script src="<?php echo base_url(); ?>js/main.js"></script>
    </body>

</html>