  <link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="http://www.sheerservices.com/zinisite/styles/mobile.css" >
<style>
.toggle {padding:0; list-style:none;}
.toggle li {position:relative; background:#F9EFEA;cursor:pointer; list-style:none !important; padding-left:0px !important;}
.toggle h3 {margin:0; padding: 10px; color: #000000;  font-family: 'Open Sans', sans-serif; font-weight:600; font-size: 14px;}
.toggle span {position:absolute; top:1px; right:0; width: 43px; background:#2E83C1; color: #fff; font-size: 24px; text-align: center;  line-height: 42px;}
.toggle .panel {display:none; position: relative;  border:1px solid #ccc; padding: 10px 10px 10px 10px; border-radius:0px; background: #fff; margin-bottom:0px; width:100%;  }
.toggle .panel p {padding:0px; margin:0px; font-family: 'Open Sans', sans-serif; }
.toggle .panel div{ width:100%; border-bottom:1px solid #f0f0f0; /*background:#DEE2E5;*/  line-height:24px;  padding-top:5px;}
.toggle .panel div:last-child{ border:0px; padding-bottom:0px; }
.toggle .panel a{ color:#259DAB; font-size:14px;  text-decoration:none; }
.toggle .panel a:hover{ color:#d9534f; text-decoration:underline;}
/*.toggle h3::after {
    content: "";
    font-family: "FontAwesome";
    font-size: 14px;
    position: absolute;
    right: 11px;
    top: 9px;
}*/
</style>
	<div class="header">
	<div class="container1 menu_container">
    <div class="fullbody">
		<div class="logo">
			<a href="<?=SITE_PATH?>"><img src="http://www.sheerservices.com/zinisite/images/top_zinianz_logo.png"> zinianz</a>
		</div>
        <div class="zini_menu_right">
		<div class="zini_menu">
        	<ul>
            	<li><a href="javascript:void(0)">Explore ZINIANZ</a>
					<ul class="level1">
						<li><a href="why-publish.php">Why Publish With Us</a></li>
						<li><a href="about.php">Zinianz Concept</a></li>
						<li><a href="social-biographer.php">Social Biographer </a></li>
						<li><a href="socialnetworking.php">Social Networking </a></li>
						<li><a href="research-medals.php">Reaserch Medals </a></li>
					</ul>
				</li>	
				<li><a href="javascript:void(0)">Journals</a>
                	<ul class="level1">
                        <li><a href="javascript:void(0)">Policies</a>
						<ul class="level2">
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>
						</ul> 
											
						</li>
						<li><a href="editorial-leaders.php">Editorial Leaders</a></li>
                        <li><a href="javascript:void(0)">COI</a>
							 <ul class="level2">
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>

							</ul> 
							  
						</li>
                        <li><a href="indexing.php">Indexing</a></li>
						<li><a href="membership.php">Membership</a></li>
                        <li><a href="faq.php">FAQ</a></li>
                    </ul>
                </li>
				
				
                <li><a href="javascript:void(0)">Authors Section</a>
				<ul class="level1">
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>

							</ul> 
				</li>
                
				<li><a href="javascript:void(0)">Articles</a>
					<ul class="level1">
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>

							</ul> 
						</li>
					    <li> <a href="javascript:void(0)">Multimedia </a>
							<ul class="level1">
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>

							</ul> 
						</li>
										
				<li><a href="associations.php">Associations</a></li>
			</ul>
        </div>
        
        <div class="top_right_s">
                <div class="sm_login_user">
                    <img src="images/<?=$def_prof?>" title="<?=$_SESSION['name']?>" alt="<?=$_SESSION['name']?>">
            <div class="user_down"> 
                <div class="user_down_full">
                    <a href="my-profile.php">My Account</a>
                    <a href="my-submissions.php">My Submissions</a>
                    <a href="logout.php">Logout</a>
                 </div>
            </div>
        </div>
        
        <div class="sm_login" onClick="openPopLogin()"><i class="fa fa-user"></i><span>Login</span></div>

        <div class="top_search"><i class="fa fa-search"></i></div>
		<div class="search_tog"><div class="search_pop">
			<form method="GET" action="search-results.php">
				
                <input type="text" placeholder="Search for..." class="hd_search" value="<?php if(isset($_REQUEST['key'])) {echo $_REQUEST["key"]; } ?>" name="key" id="txtSearch" autocomplete="off" required>
				<input type="submit" class="hd_sub" value="" />			
			</form>
            <div class="gb_jb"></div>
			</div>
		</div>
        <div class="m_icon"><i class="fa fa-bars"></i></div>
		</div>
	</div>
    </div>
</div>
</div>
<div class="side_menu">
    <div class="side_menu_inner">
    <div class="m_close">Close</div>
    <div class="search_mobile">
			<form method="GET" action="search-results.php">
                <input type="text" placeholder="Search for..." class="hd_search" value="<?php if(isset($_REQUEST['key'])) {echo $_REQUEST["key"]; } ?>" name="key" id="txtSearch" autocomplete="off" required>
				<input type="submit" class="hd_sub" value="" />			
			</form>
            <div class="gb_jb"></div>
			</div>
        <ul class="level menul">
        	<li><a href="javascript:void(0)">Explore ZINIANZ</a>
					<ul>
						<li><a href="why-publish.php">Why Publish With Us</a></li>
						<li><a href="about.php">Zinianz Concept</a></li>
						<li><a href="social-biographer.php">Social Biographer </a></li>
						<li><a href="socialnetworking.php">Social Networking </a></li>
						<li><a href="research-medals.php">Reaserch Medals </a></li>
					</ul>
				</li>
				<li><a href="javascript:void(0)">Journals</a>
                	<ul class="level1">
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>

							</ul> 				
						</li>
						<li><a href="editorial-leaders.php">Editorial Leaders</a></li>
                        <li><a href="javascript:void(0)">COI</a>
							 <ul class="level1">
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>

							</ul> 
						</li>
                        <li><a href="indexing.php">Indexing</a></li>
						<li><a href="membership.php">Membership</a></li>
                    </ul>
                </li>
                <li><a href="javascript:void(0)">Authors Section</a>
					<ul class="level1">
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>

							</ul> 
				</li>
                
				<li><a href="javascript:void(0)">Articles</a>
					<ul class="level1">
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>

							</ul> 
						</li>
					    <li> <a href="javascript:void(0)">Multimedia </a>
							<ul class="level1">
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>
							<li><a href="">Ram</a></li>

							</ul> 
				</li>
				<li><a href="associations.php">Associations</a></li>
        </ul>
    </div>
</div>
<div class="menu_overlay"></div>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.m_icon').click(function(){
        $(".side_menu").addClass('fast_menu');
		$(".side_menu_profile").removeClass('fast_pmenu');
		$('.menu_overlay').fadeIn();
    });
	$('.m_close , .menu_overlay').click(function(){
        $(".side_menu").removeClass('fast_menu');
		$('.menu_overlay').fadeOut();
    });
	$('.mp_icon ').click(function(){
        $(".side_menu_profile").toggleClass('fast_pmenu');
		$(this).toggleClass('exit');
		$('.menu_overlay').fadeIn();
    });
	$('.m_close, .menu_overlay').click(function(){
        $(".side_menu_profile").removeClass('fast_pmenu');
		$('.mp_icon').removeClass('exit');
		$('.menu_overlay').fadeOut();
    });
	
 $(".menul li a").each(function() {
  if ($(this).next().length > 0) {
   $(this).addClass("parent");
  };
 })
 var menux = $('.menul li a.parent');
 $( '<div class="plusm"><span><i class="fa fa-angle-down"></i></span></div>' ).insertBefore(menux);
 $('.plusm').click(function(){
   $(this).parent('li').toggleClass('open');
 });
 });
</script>