<?php
include_once 'google_oauth/gpConfig.php';
include_once 'google_oauth/User.php';
$authUrl = $gClient->createAuthUrl();
$user_id = $this->session->userdata('user_id'); 
   if(!empty(trim($user_id))){
      header("Location:".base_url()."en/web/records");
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
    <title>Publishat</title>
    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/ico" href="<?php echo base_url(); ?>images/publishat1.png" />
    <!-- Plugin-CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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

                <a href="#home_page" class="navbar-brand"><h2>PUBLISHAT</h2></a>
				<a href="https://itunes.apple.com/in/app/publishat/id1067625164?mt=8"><img src="<?php echo base_url(); ?>images/Apple.png" alt="apple icon"> </a>
				<a href="https://play.google.com/store/apps/details?id=com.nadboy.publishat"><img src="<?php echo base_url(); ?>images/google2.png" alt="Play Store Icon"></a>
            </div>
            <div class="collapse navbar-collapse" id="primary_menu">
                <ul class="nav navbar-nav mainmenu">
                    <li class="active"><a href="#home_page">Home</a></li>
                    <li><a href="#features_page">About</a></li>
                    <li><a href="#gallery_page">Gallery</a></li>
					<li><a href="#download_page">Products</a></li>
					<li><a href="#price_page">Pricing</a></li>
                    <li><a href="#blogs_page">Blog</a></li>
                    <li><a href="#contact_page">Contacts</a></li>
                </ul>
            </div>
    </nav>
    <!-- MainMenu-Area-End -->
    <!-- Home-Area -->
    <header class="home-area overlay" id="home_page">
        <div class="container">
                <div class="col-xs-12 hidden-sm col-md-5">
                    <figure class="mobile-image wow fadeInUp" data-wow-delay="0.2s">
                        <img src="<?php echo base_url(); ?>images/phone1.png" alt="">
                    </figure>
                </div>
                <div class="col-xs-12 col-md-7">
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
        <div class="container-fluid">
                <div class="col-xs-12 col-sm-6 gallery-slider">
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
                <div class="col-xs-12 col-sm-5 col-lg-3">
                    <div class="page-title">
                        <h5 class="white-color title wow fadeInUp" data-wow-delay="0.2s">PUBLISHAT</h5>
                    </div>
                    <div class="space-20"></div>
                    <div class="desc wow fadeInUp" data-wow-delay="0.6s">
                        <p>Consolidate your personal data,Access your Data anywhere anytime across globe,Prevent Data loss,Pass on critical information to next generations,Easy to claim your insurance,
						Easy to track all your assets at one place,Prevent document theft.</p>
                    </div>
                </div>
        </div>
    </section>
    <!-- Gallery-Area-End -->
    
    <!-- Download-Area -->
    <div class="download-area" id="download_page">
        <div class="container">
                <div class="col-xs-12 col-sm-6 hidden-sm">
                    <figure class="mobile-image">
                        <img src="<?php echo base_url(); ?>images/phone1.png" alt="">
                    </figure>
                </div>
                <div class="col-xs-12 col-md-6 section-padding">
                    <h3 class="white-color">Products</h3>
                    <div class="space-10"></div>
                    <p>Downlaod APP now.</p>
                    <div class="space-20"></div>
            	<a href="https://itunes.apple.com/in/app/publishat/id1067625164?mt=8"><img src="<?php echo base_url(); ?>images/Apple.png" alt="apple icon"> </a>
				<a href="https://play.google.com/store/apps/details?id=com.nadboy.publishat"><img src="<?php echo base_url(); ?>images/google2.png" alt="Play Store Icon"></a><br>
					<div class="space-60"></div>
					<p>You have to make your websites with love this days.</p>
					<div class="space-10"></div>
					<a href="https://chrome.google.com/webstore/detail/publishat/lddlembbffkdjgeicgpioflneapddjho"><img style="border-radius:5px;" src="<?php echo base_url(); ?>images/exe.jpg" alt="crome"></a>
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
     Just Compare features and pay for the used data only.</p><p class="textprop"> Here is Price comparison.</p>
		   <table class="table  table-responsive textprop" style="" >
			   <thead>
				   <tr class="tablehead">
					   <td>Feature</td>
					   <td align="center">Publishat</td>
					   <td align="center">Google Drive</td>
					   <td align="center">Drop Box</td>
					   <td align="center">Box</td>
					</tr>
			   </thead>
			   <tbody>
			     <tr>
				 <td >Desktop App</td>
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
                    <div class="blogs page-title text-center">
					<div class="space-90"></div>
                        <h3 class="textprop">BLOGS</h3>
                    </div>
                </div>
			
     			   <div class="col-md-12" style="border-bottom:1px solid #ddd;">
                <h2><a href="http://publishat.com/stage/en/web/articleinfo?id=5a3b3f6f88424afb7e0653f8"class="textprop">Digital India</a></h2>
				<span class="col-md-12 textprop" >POSTED ON <b>December 21st, 2017 </b> BY <b>Chaithanya chowdary</b></span>
		       <div class="col-md-10 desc textprop">Digital Technologies which include Cloud Computing and Mobile Applications have emerged as catalysts for rapid economic growth and citizen empowerment across the globe. Digital technologies are being increasingly used by us in everyday lives from retail stores to government offices. They help us to connect with each other and also to share information on issues and concerns faced by us. In some cases they also enable resolution of those issues in near real time.The objective of the Digital			   </div>
			   <div class="col-md-12 textprop">
			   <a href="http://publishat.com/stage/en/web/articleinfo?id=5a3b3f6f88424afb7e0653f8" class="textprop">ReadMore..</a>
			   </div>
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
							<div class="map_directions col-md-12 col-xs-12"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15217.84129121841!2d78.3530287!3d17.5332572!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xa521ff3a9d738a2c!2sPublishat!5e0!3m2!1sen!2sin!4v1454661310993" width="100%" height="140" frameborder="0" style="border:0" allowfullscreen></iframe></div>

                        </div>
                    </div>
                
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <div class="footer-box">
                            <div class="box-icon">
                                <span class="lnr lnr-map-marker"></span>
                            </div>
                            <p>iPublish Advanced Technology Solutions<br /> HOUSE NO: 8-5/739, PLOT NO: 739<br /> BACHUPALLY (Village)QUTHBULLAPUR (Mandal)RANGA REDDY (DIST)<br /> HYDERABAD - 500090
<br />TELANGANA, INDIA</p>
                        </div>
                        <div class="space-30 hidden visible-xs"></div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="footer-box">
                            <div class="box-icon">
                                <span class="lnr lnr-phone-handset"></span>
                            </div>
                            <p style="padding-left:130px;">+91 8978996785<br /> +91 9912395491</p>
                        </div>
                        <div class="space-30 hidden visible-xs"></div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="footer-box">
                            <div class="box-icon">
                                <span class="lnr lnr-envelope"></span>
                            </div>
                            <p style="padding-left:110px;">contact@publishat.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer-Bootom -->
        <div class="footer-bottom">
            <div class="container">
                
                    <div class="col-xs-12 col-md-5">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            <span>Copyright &copy;<script>document.write(new Date().getFullYear());</script>  iPublish Advanced Technology Solutions Private Limited </span>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        <div class="space-30 hidden visible-xs"></div>
                    </div>
                    <div class="col-xs-12 col-md-7">
                        <div class="footer-menu">
                            <ul>
                                <li><a href="#about_page">About</a></li>
                                <li><a href="#price_page">pricing</a></li>
                                <li><a href="#features_page">Features</a></li>
                                <li><a href="#contact_page">Contacts</a></li>
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



<?php /* doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Sumon Rahman">
    <meta name="description" content="">
    <meta name="keywords" content="HTML,CSS,XML,JavaScript">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title>Publishat</title>
    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/ico" href="images/publishat1.png" />
    <!-- Plugin-CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?><?php
//echo "dafa";
if(isset($failed) && $failed == 1) {  echo "<script>alert('".$data."');</script>";
}
include_once 'google_oauth/gpConfig.php';
include_once 'google_oauth/User.php';
$authUrl = $gClient->createAuthUrl();
$user_id = $this->session->userdata('user_id'); 
   if(!empty(trim($user_id))){
      header("Location:".base_url()."en/web/records");
   }  
?>
<!DOCTYPE html>
<html>
<head>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Publishat</title>
 <script>
   // if(history.replaceState) history.replaceState({}, "", "/");
 </script>
 <style>
	.header{
      border: 2px solid #729fcf;
	  height: 75px;
	  margin-bottom: 8px;
	}
	
	.headerbgcolor{
      background-color: #729fcf;
	}
	.logo h1{
	  font-weight: 700;
	  padding: 0px 3px 0px 30px;
	  font-size: 40px;
	  color: #fff;
	  font-family: inherit;
	  margin-top: 15px;
	}
	.nopad{
	  padding: 0px;
	}
    .store img{
	  width: 100%;
	  height: 40px;
      margin-bottom: 10px;
	  margin-top: 17px
	}
	.rightborder{
	   //border-right: 3px solid white;
	   //height: 75px;
	}
	.storeapp{
	   
	   padding: 1% 0% 0% 10%;
	}
	.storeapp img{
	   width: 80%;
	   height: 55px;
	   margin-top: 2px
	}
	.menu{
	    background: #729fcf;
		height: 40px;
		
	}
	.menu h4{
	   //padding: 5px;
	   text-align: center;
	   font-family: initial;
	   font-weight: bold;
	   cursor: pointer;
	  
	}
	.menu .col-md-2, .menu .col-xs-4{
	   border-right: 2px solid #4b7bb3;
	   background: #729fcf;
	}
	
	.nopad{
	  padding: 0px;
	}
	.footer{
	   height: 40px;
	   background: #729fcf;
	   position: fixed;
	   bottom:0px;
	   width: 100%;
	   z-index:1;
	}
	.footer h4{
	   text-align: center;
	   color: black;
	   font-family: initial
	}
	.wrongprop{color:#ff1a1a !important;}
	.correctprop{color:#00e600 !important;}
	table,td {border:1px solid gray;}
	thead{background-color:#466e90;}
	.copyrightbottom{
		background: #303030;
		padding: 15px 0;
		color: #466e90;
	}
	.tablehead td{
		color: white;
		font-size: 17px;
		font-weight: 600;
	}
	.menuclass ul li{
	    font-size: 17px;
		font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
		padding: 10px 0px 0px 25px ; 
		font-weight: 500;
	}
	body{
	   font-family:"Open Sans","lucida grande","Segoe UI",arial,verdana,"lucida sans unicode", tahoma,sans-serif !important;
	}
	.mainimg{
		margin-bottom: 5%;
	}
	.mainimg img{
		width: 100%;
	}
	.map_directions{
		padding: 0px;
	}
	.fields input,.fields textarea{
		width:100%;
		padding: 10px;
    	margin: 7px;
    	border-radius: 11px;
    	resize: none;
	}
	.btn{
		//width: 24% !important;
	}
	.address{
		font-family: "Open Sans","lucida grande","Segoe UI",arial,verdana,"lucida sans unicode", tahoma,sans-serif !important;
	}
	.contact{
		    border-right: 1px solid #d4cccc;
	}
	.contact h3{
		margin-top: 3px !important;
    	margin-bottom: 13px;
	}
	.fields input, .fields textarea{
		margin: 18px !important;
	}
	.form-group {
    margin: 31px !important;
	}
	@media only screen and (max-width: 768px) {
		.header{
			height: 80px;
		}
		.menu h4{
			font-size: 10px;
			
		}
		.menu .col-xs-4{
			padding: 0px;
			border: 1px solid white;
		}
		.logo h1 {
           font-weight: 700;
           padding: 0px 3px 0px 0px; 
		   font-size: 25px;
		   color: black;
		   font-family: inherit;
        }
		.storeapp img {
			width: 100%;
			height: 24px;
			margin-top: 14px;
		}
		.storeapp{
			padding: 2px;
		}
		.header {
            height: 50px;
        }
		.rightborder {
            border-right: 0px solid white;
            height: auto; 
		}
		.store img {
			width: 100%;
			height: 30px;
			margin-bottom: 10px;
			margin-top: 9px;
		}
		.footer h4 {
            font-size: 12px;
		}
		.menuclass .col-md-12{
			padding-left: 0px;
			
		}
		.menuclass li{
			//text-align: justify;
			padding-left: 0px !important;
		}
		.pricing .col-xs-12{
			margin-bottom: 11%;
		}
		.pricing table td{
			font-size: 12px;
		}
		.mainimg{
			margin-bottom: 7%;
		}
		.address{
		font-family: "Open Sans","lucida grande","Segoe UI",arial,verdana,"lucida sans unicode", tahoma,sans-serif !important;
	}
	.contact{
   		    margin-left: 15px;
   		    height:auto;
	}
	.contact h3{
		margin-top: 0px !important;
    	margin-bottom: 0px;
	}
	.col-xs-12.fields{
		height:auto !important;
	}
	.contactus{
		height:100%;
	}
	.fields input, .fields textarea {
    width: 92%;
	}
	.article_head{
		font-size: 14px;
	}
	.fields input, .fields textarea {
    margin: 18px 14px 12px 0px !important;
    }
    .form-group {
    margin: 14px !important;
	}
	.form-group .btn {
		margin-bottom: 37px !important;
	}
	}
		
</style>
</head>
<body>
<div class="container-fluid">
	<div class="row header headerbgcolor">
		<div class="col-md-3 col-xs-6 rightborder">
		   <span class="logo"><h1>Publishat</h1></span>
		</div> 
		<div class="col-md-5 col-xs-6 nopad">
		    <div class="col-md-6 col-xs-6 store storeapp rightborder">
		    <a href="https://play.google.com/store/apps/details?id=com.nadboy.publishat">
			  	<img src="<?php echo base_url(); ?>images/google.png">
			</a>  	
			</div>
		    <div class="col-md-6 col-xs-6 store storeapp rightborder">
		    <a href="https://itunes.apple.com/in/app/publishat/id1067625164?mt=8">
			   <img src="<?php echo base_url(); ?>images/app_store.png" class="img img-responsive">
			</a>   
			</div>
		</div>
		
		<div class="col-md-4  nopad col-xs-12 store">
		   <div class="col-md-6 col-md-offset-4 col-xs-6">
		    <a class="login" href="<?= $authUrl ?>">
		       <img src="<?php echo base_url(); ?>images/googleplussignin.png" class="img img-responsive">
			 </a>
		   </div>
		   <!--<div class="col-md-6  col-xs-6 store">
		      <img src="https://www.publishat.com/images/fb.png">
		   </div>-->
		</div>
		
	</div>
    <div class="row menu">
	   <div class="col-md-2 col-xs-4" id="whoarewe">
	     <h4>WHO ARE WE</h4>
	   </div>
	   <div class="col-md-2 col-xs-4" id="whatwedo">
	     <h4>WHAT WE DO</h4>
	   </div>
	   <div class="col-md-2 col-xs-4" id="whydouneed">
	      <h4>WHY DO YOU NEED</h4>
	   </div>
	   <div class="col-md-2 col-xs-4" id="pricing">
	      <h4>PRICING</h4>
	   </div>
	   <div class="col-md-2 col-xs-4" id="blogs">
	      <h4>BLOGS</h4>
	   </div>
	   <div class="col-md-2 col-xs-4" id="contactus">
	      <h4>CONTACT US</h4>
	   </div>
	</div>
	
	<div class="row">
		<div class="col-xs-12 mainimg whoarewe">
			<div class="container">
				<img src="<?php echo base_url(); ?>images/1.jpg">
			</div>
		</div>
	</div>
	
	<div class="row menuclass whatwedo">
	    <div class="col-md-12">
	        <ul>
		        <li>We help you to digitize your personal data for Lifetime and beyond.</li>
		        <li>We encrypt your data and create a personal blockchain for you.</li>
		    </ul>
	    </div>
	</div>
	<div class="row menuclass whydouneed">
	    <div class="col-md-12">
	        <ul>
		        <li>Consolidate your personal data.</li>
		        <li>Access your Data anywhere anytime across globe.</li>
				<li>Prevent Data loss.</li>
		        <li>Pass on critical information to next generations.</li>
				<li>Easy to claim your insurance.</li>
		        <li>Easy to track all your assets at one place.</li>
				<li>Prevent document theft.</li>
		    </ul>
	    </div>
	</div>
	<div class="row menuclass pricing">
	   <div class="col-md-offset-2 col-md-8 col-md-offset-2 col-xs-12" style="margin-top:3%">
   <p class="textprop">Why to pay for the unused data and we support on demand data storage.
     Just Compare features and pay for the used data only.</p><p class="textprop"> Here is Price comparison.</p>
		   <table class="table  table-responsive textprop" style="" >
			   <thead>
				   <tr class="tablehead">
					   <td>Feature</td>
					   <td align="center">Publishat</td>
					   <td align="center">Google Drive</td>
					   <td align="center">Drop Box</td>
					   <td align="center">Box</td>
					</tr>
			   </thead>
			   <tbody>
			     <tr>
				 <td >Desktop App</td>
				 <td align="center"><span class="glyphicon glyphicon-remove wrongprop"></td>
				 <td align="center"><span class="glyphicon glyphicon-ok correctprop"></td>
				 <td align="center"><span class="glyphicon glyphicon-ok correctprop"></td>
				 <td align="center"><span class="glyphicon glyphicon-remove wrongprop"></span></td>
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
	 <div class="pull-right signupbtn" style="margin-bottom: 5%;">
	    <a href="<?= $authUrl ?>" class="btn btn-primary" style="color:white;">SignUp With Us</a>
	 </div>

 	   
   </div>
	</div>
	<div class="row menuclass blogs">
     <?php
     	$query = $this->mongodb->get("Articles");
            if(count($query ) > 0){
            foreach ($query as $data){
				  $id = $data['_id'];
                  $heading = $data['articleheading'];
                  $articledes= $data['ArticleDescription'];
                  $string = strip_tags($articledes);
					if (strlen($string) > 500) {
						$stringCut = substr($string, 0, 500);
						$string = substr($stringCut, 0, strrpos($stringCut, ' ')); 
					}
				  $user_id = $data['UserId'];
                  $date = $data['Date'];
                  $this->mongodb->where(array("UserId"=>$user_id));
                  $res = $this->mongodb->get("User");
                  if(count($res ) > 0){
                  foreach ($res as $data) {
                    $name = $data['Name'];
                    }
                }
             ?>
			   <div class="col-md-12" style="border-bottom:1px solid #ddd;">
                <h2><a href="<?php echo base_url(); ?>web/articleinfo?id=<?=$id;?>"><?=$heading?></a></h2>
				<span class="col-md-12">POSTED ON <b><?=$date?></b> BY <b><?=$name;?></b></span>
		       <div class="col-md-10 desc"><?=$string;?>
			   </div>
			   <div class="col-md-12">
			   <a href="<?php echo base_url(); ?>web/articleinfo?id=<?=$id;?>">ReadMore..</a>
			   </div>
			   </div>	 
 <?php   } } ?>
	</div>
	<div class="row menuclass contactus">
	   <div class="map_directions col-md-12 col-xs-12"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15217.84129121841!2d78.3530287!3d17.5332572!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xa521ff3a9d738a2c!2sPublishat!5e0!3m2!1sen!2sin!4v1454661310993" width="100%" height="140" frameborder="0" style="border:0" allowfullscreen></iframe></div>
	  <div class="col-md-12 col-xs-12 info">
	  		<div class="col-md-6 col-xs-12 contact">
	  			<h3>Contact Us</h3>
	  			<hr class="hidden-xs">
	  			<span class="col-md-12 address">
				<h6><b>Please contact at the following address for any of your queries:</b></h6>
				iPublish Advanced Technology Solutions</br>
				HOUSE NO: 8-5/739, PLOT NO: 739</br>
				BACHUPALLY (Village)</br>
				QUTHBULLAPUR (Mandal)</br>
				RANGA REDDY (DIST)</br>
				HYDERABAD - 500090</br>
				TELANGANA, INDIA</br>
				Mobile: +91 8978996785 and +91 9912395491</br>
				Email:contact@publishat.com</br>
	  			</span>
	  		</div>
	  		<div class="col-md-5 col-md-offset-1 col-xs-12 form-group fields" >
	  		<input type="text" class="form-control" name="name" placeholder="Name">
	  		<input type="text" class="form-control" name="mobile_number" placeholder="Mobile Number">
	  		<input type="text" class="form-control" name="email" placeholder="Email">
	  		<textarea class="form-control" placeholder="Message"></textarea>
	  		<input type="button" name="send" class="btn btn-primary" value="Send">
	  		</div>
	  </div>
	</div>
	<div class="row footer">
	    <h4>&copy;<?php echo date(Y);?> iPublish Advanced Technology Solutions Private Limited</h4>
	</div>
</div>

</body>

<script>
$(document).ready(function(){
  $(".menuclass").hide();
  $(".menu div").on('click touchstart', function(){
       $(".menuclass").hide();
	   $(".mainimg").hide();
       var id = this.id;
	   $("."+id).show();
  });  
});

</script>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/linearicons.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/magnific-popup.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.css">
    <!-- Main-Stylesheets -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.css">
    <script src="<?php echo base_url(); ?>assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
                <a class="navbar-brand"><h2>PUBLISHAT</h2></a>
				<a href="https://itunes.apple.com/in/app/publishat/id1067625164?mt=8" class="bttn-white sq"><img src="images/apple-icon.png" alt="apple icon"> Apple Store</a>
				<a href="https://play.google.com/store/apps/details?id=com.nadboy.publishat" class="bttn-white sq"><img src="images/play-store-icon.png" alt="Play Store Icon"> Play Store</a>
            </div>
            <div class="collapse navbar-collapse" id="primary_menu">
                <ul class="nav navbar-nav mainmenu">
                    <li class="active"><a href="#home_page">Home</a></li>
                    <li><a href="#features_page">About</a></li>
                    <li><a href="#gallery_page">Gallery</a></li>
					<li><a href="#download_page">Products</a></li>
					<li><a href="#price_page">Pricing</a></li>
                    <li><a href="#blogs_page">Blog</a></li>
                    <li><a href="#contact_page">Contacts</a></li>
                </ul>
            </div>
    </nav>
    <!-- MainMenu-Area-End -->
    <!-- Home-Area -->
    <header class="home-area overlay" id="home_page">
        <div class="container">
                <div class="col-xs-12 hidden-sm col-md-5">
                    <figure class="mobile-image wow fadeInUp" data-wow-delay="0.2s">
                        <img src="images/phone1.png" alt="">
                    </figure>
                </div>
                <div class="col-xs-12 col-md-7">
                    <div class="space-80 hidden-xs"></div>
                    <h3 class="wow fadeInUp" data-wow-delay="0.4s">Digitize your PERSONAL data for Lifetime and beyond.</h3>
                    <h3 class="wow fadeInUp" data-wow-delay="0.4s">We encrypt your data and create a personal blockchain for you.</h3>
                    <div class="space-20"></div>
                    <a href="https://accounts.google.com/o/oauth2/auth?response_type=code&redirect_uri=https%3A%2F%2Fwww.publishat.com%2Fdigital%2Fen%2Flogin%2Fgoogleoauth&client_id=123515224621-r29edfj1vr2n8k0dptmpf2gdsa13dbah.apps.googleusercontent.com&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email&access_type=offline&approval_prompt=force" class="bttn-white wow fadeInUp" data-wow-delay="0.8s"><i class="right-button hidden-xs"></i>sign in with google</a>
                </div>
        </div>
    </header>
    <!-- Home-Area-End -->
   
    <!-- Feature-Area -->	
    <section class="feature-area section-padding-top" id="features_page">
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
    <section class="gallery-area section-padding" id="gallery_page">
        <div class="container-fluid">
                <div class="col-xs-12 col-sm-6 gallery-slider">
                    <div class="gallery-slide">
					    <div class="item"><img src="<?php echo base_url(); ?>assets/images/publishatlog.png" alt=""></div>
                        <div class="item"><img src="<?php echo base_url(); ?>assets/images/documents.png" alt=""></div>
                        <div class="item"><img src="<?php echo base_url(); ?>assets/images/app.png" alt=""></div>
                        <div class="item"><img src="<?php echo base_url(); ?>assets/images/documents2.png" alt=""></div>
						 <div class="item"><img src="<?php echo base_url(); ?>assets/images/publishatlog.png" alt=""></div>
                        <div class="item"><img src="<?php echo base_url(); ?>assets/images/documents.png" alt=""></div>
                        <div class="item"><img src="<?php echo base_url(); ?>assets/images/app.png" alt=""></div>                       
                        <div class="item"><img src="<?php echo base_url(); ?>assets/images/documents2.png" alt=""></div>
						<div class="item"><img src="<?php echo base_url(); ?>assets/images/publishatlog.png" alt=""></div>
                        <div class="item"><img src="<?php echo base_url(); ?>assets/images/documents.png" alt=""></div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-5 col-lg-3">
                    <div class="page-title">
                        <h5 class="white-color title wow fadeInUp" data-wow-delay="0.2s">PUBLISHAT</h5>
                    </div>
                    <div class="space-20"></div>
                    <div class="desc wow fadeInUp" data-wow-delay="0.6s">
                        <p>Consolidate your personal data,Access your Data anywhere anytime across globe,Prevent Data loss,Pass on critical information to next generations,Easy to claim your insurance,
						Easy to track all your assets at one place,Prevent document theft.</p>
                    </div>
                </div>
        </div>
    </section>
    <!-- Gallery-Area-End -->
    
    <!-- Download-Area -->
    <div class="download-area overlay" id="download_page">
        <div class="container">
                <div class="col-xs-12 col-sm-6 hidden-sm">
                    <figure class="mobile-image">
                        <img src="<?php echo base_url(); ?>assets/images/phone1.png" alt="">
                    </figure>
                </div>
                <div class="col-xs-12 col-md-6 section-padding">
                    <h3 class="white-color">Products</h3>
                    <div class="space-10"></div>
                    <p>Downlaod APP now.</p>
                    <div class="space-20"></div>
                    <a href="https://itunes.apple.com/in/app/publishat/id1067625164?mt=8" class="bttn-white sq"><img src="<?php echo base_url(); ?>assets/images/apple-icon.png" alt="apple icon"> Apple Store</a>
                    <a href="https://play.google.com/store/apps/details?id=com.nadboy.publishat" class="bttn-white sq"><img src="<?php echo base_url(); ?>assets/images/play-store-icon.png" alt="Play Store Icon"> Play Store</a><br>
					<div class="space-60"></div>
					<p>You have to make your websites with love this days.</p>
					<div class="space-10"></div>
					<a style="padding:12px 6px 12px 6px;" href="https://chrome.google.com/webstore/detail/publishat/lddlembbffkdjgeicgpioflneapddjho" class="bttn-white sq"><img src="<?php echo base_url(); ?>assets/images/exe.png" alt="crome">Browser Extensions</a>
				</div>
        </div>
    </div>
    <!-- Download-Area-End -->
    <!--Price-Area -->
    <section class="section-padding price-area" id="price_page">
        <div class="container">
            
                <div class="col-xs-12">
                    <div class="page-title text-center">
                        <h5 class="title">Pricing Plan</h5>
                        <div class="space-60"></div>
                    </div>
                </div>
           <div class="row menuclass pricing">
	   <div class="col-md-offset-2 col-md-8 col-md-offset-2 col-xs-12" style="margin-top:3%">
   <p class="textprop">Why to pay for the unused data and we support on demand data storage.
     Just Compare features and pay for the used data only.</p><p class="textprop"> Here is Price comparison.</p>
		   <table class="table  table-responsive textprop" style="" >
			   <thead>
				   <tr class="tablehead">
					   <td>Feature</td>
					   <td align="center">Publishat</td>
					   <td align="center">Google Drive</td>
					   <td align="center">Drop Box</td>
					   <td align="center">Box</td>
					</tr>
			   </thead>
			   <tbody>
			     <tr>
				 <td >Desktop App</td>
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
    </section>
    <!--Price-Area-End -->
	
	<!--blog-Area-->
	
	<div class="row menuclass blogs" id="blogs_page">
                <div class="col-xs-12">
                    <div class="page-title text-center">
                        <h5 class="title">Blogs</h5>
                        <div class="space-60"></div>
                    </div>
                </div>
			
     			   <div class="col-md-12" style="border-bottom:1px solid #ddd;">
                <h2><a href="http://publishat.com/stage/en/web/articleinfo?id=5a3b3f6f88424afb7e0653f8">Digital India</a></h2>
				<span class="col-md-12">POSTED ON <b>December 21st, 2017 </b> BY <b>Chaithanya chowdary</b></span>
		       <div class="col-md-10 desc">Digital Technologies which include Cloud Computing and Mobile Applications have emerged as catalysts for rapid economic growth and citizen empowerment across the globe. Digital technologies are being increasingly used by us in everyday lives from retail stores to government offices. They help us to connect with each other and also to share information on issues and concerns faced by us. In some cases they also enable resolution of those issues in near real time.The objective of the Digital			   </div>
			   <div class="col-md-12">
			   <a href="http://publishat.com/stage/en/web/articleinfo?id=5a3b3f6f88424afb7e0653f8">ReadMore..</a>
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
							<div class="map_directions col-md-12 col-xs-12"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15217.84129121841!2d78.3530287!3d17.5332572!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xa521ff3a9d738a2c!2sPublishat!5e0!3m2!1sen!2sin!4v1454661310993" width="100%" height="140" frameborder="0" style="border:0" allowfullscreen></iframe></div>

                        </div>
                    </div>
                
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <div class="footer-box">
                            <div class="box-icon">
                                <span class="lnr lnr-map-marker"></span>
                            </div>
                            <p>iPublish Advanced Technology Solutions<br /> HOUSE NO: 8-5/739, PLOT NO: 739<br /> BACHUPALLY (Village)QUTHBULLAPUR (Mandal)RANGA REDDY (DIST)<br /> HYDERABAD - 500090
<br />TELANGANA, INDIA</p>
                        </div>
                        <div class="space-30 hidden visible-xs"></div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="footer-box">
                            <div class="box-icon">
                                <span class="lnr lnr-phone-handset"></span>
                            </div>
                            <p style="padding-left:130px;">+91 8978996785<br /> +91 9912395491</p>
                        </div>
                        <div class="space-30 hidden visible-xs"></div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="footer-box">
                            <div class="box-icon">
                                <span class="lnr lnr-envelope"></span>
                            </div>
                            <p style="padding-left:110px;">contact@publishat.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer-Bootom -->
        <div class="footer-bottom">
            <div class="container">
                
                    <div class="col-xs-12 col-md-5">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            <span>Copyright &copy;<script>document.write(new Date().getFullYear());</script>  iPublish Advanced Technology Solutions Private Limited </span>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        <div class="space-30 hidden visible-xs"></div>
                    </div>
                    <div class="col-xs-12 col-md-7">
                        <div class="footer-menu">
                            <ul>
                                <li><a href="#about_page">About</a></li>
                                <li><a href="#price_page">pricing</a></li>
                                <li><a href="#features_page">Features</a></li>
                                <li><a href="#contact_page">Contacts</a></li>
                            </ul>
                        </div>
                    </div>
               
            </div>
        </div>
        <!-- Footer-Bootom-End -->
    </footer>
    <!-- Footer-Area-End -->
    <!--Vendor-JS-->
    <script src="<?php echo base_url(); ?>assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/vendor/jquery-ui.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/vendor/bootstrap.min.js"></script>
    <!--Plugin-JS-->
    <script src="<?php echo base_url(); ?>assets/js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/contact-form.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/ajaxchimp.js"></script>
    <script src="<?php echo base_url(); ?>assets//scrollUp.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/magnific-popup.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/wow.min.js"></script>
    <!--Main-active-JS-->
    <script src="<?php echo base_url(); ?>assets/js/main.js"></script>
</body>

</html>