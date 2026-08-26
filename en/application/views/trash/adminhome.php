<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Publishat</title>
	<!-- jquery plugin -->
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="https://publishat.com/BloodDonation/Services/assets/css/login.css">
	
  <style>
    .factstext{
      color: #C03737 !important;
      font-weight: 700 !important;
    }
    .factsdesc{
      color: #949EA7 !important;
      font-family: initial !important;
    }
  </style>
</head>
<body>
  <div class="row" id="pwd-container">
    <div class="col-md-6">
      <img src="https://image.freepik.com/free-vector/blood-donation-vector-art_23-2147495569.jpg" alt="">
    </div>
    
    <div class="col-md-6 pull-right" style="background-color: rgba(255, 255, 255, 1);">
    <?php if ($this->session->userdata('user_id')) { 
    	redirect('AdminController/getdashboard');
    	 }else{ ?>
        <div>
          <form method="post" action="login" role="login" class="form-inline">
            <img src="https://www.publishat.com/img/logo.png" class="img-responsive" alt="" />
            <center>

            <div class="form-group">
                <input type="email" name="email" placeholder="Enter Valid Email" required class="form-control" value="" /><br>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
                <input type="password" class="form-control" id="password" placeholder="Password" required="" name="password" /><br>
            </div>
            <div class="clearfix"></div>          
            <?php if(isset($failed)){ ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               Enter correct details.<strong>!</strong>
            </div>
            <?php } ?>
            
            <!-- <div class="pwstrength_viewport_progress"></div> -->
            
            
            <button type="submit" class="btn btn-md btn-primary">Sign in</button>
            </center>
            
          </form>
        </div>

        <div class="clearfix"><hr></div>
        <div class="col-md-12" style="margin-top:3%">
          <div class="col-md-3" style="border-right: 2px solid #C6C2C2;border-right-style: dotted;">
            <img src="../assets/images/home_fact_2seconds.png" alt="" class="img-responsive">
            <span class="factstext">2 SECONDS</span><br>
            <span class="factsdesc">Every 2 seconds, someone in the India needs blood.</span>
          </div>
          <div class="col-md-3" style="border-right: 2px solid #C6C2C2;border-right-style: dotted;">
            <img src="../assets/images/home_fact_1in7.png" alt="" class="img-responsive">
            <span class="factstext">1:7</span><br>
            <span class="factsdesc">1 in 7 people entering the hospital will use blood.<br></span>
          </div>
          <div class="col-md-3" style="border-right: 2px solid #C6C2C2;border-right-style: dotted;">
            <img src="../assets/images/home_fact_1pint.png" alt="" class="img-responsive">
            <span class="factstext">1 PINT</span><br>
            <span class="factsdesc">Blood cannot be artificially made.<br><br></span>
          </div>
          <div class="col-md-3">
            <img src="../assets/images/home_fact_3lives.png" alt="" class="img-responsive">
            <span class="factstext">3 LIVES</span><br>
            <span class="factsdesc">Every pint of blood can save 3 lives.<br><br></span>
          </div>
          <!-- <div class="col-md-2">
            <img src="../assets/images/home_fact_cookies.png" alt="" class="img-responsive">
            <span class="factstext">COOKIES</span><br>
            <span class="factsdesc">The whole blood donation process takes less than an hour!</span>
          </div> -->
        </div>
        
        
     <?php } ?>  
      </div>
      
 
      

  </div>
	
</body>
</html>