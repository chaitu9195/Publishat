<?php
//echo "dafa";
if(isset($failed) && $failed == 1) {  echo "<script>alert('".$data."');</script>";
}
$authUrl = google_login_url();
$user_id = $this->session->userdata('user_id'); 
   if(!empty(trim($user_id))){
      header("Location:".base_url()."/digital/en/web/records");
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
    if(history.replaceState) history.replaceState({}, "", "/");
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
            if(count($query ?? array()) > 0){
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
                  if(count($res ?? array()) > 0){
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
	    <h4>&copy;<?php echo date('Y');?> iPublish Advanced Technology Solutions Private Limited</h4>
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

</script>