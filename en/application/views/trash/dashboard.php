<!DOCTYPE html>
<html>
<head>
	<title>Publishat</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" href="https://www.publishat.com/favicon.ico" />
  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

	<style type="text/css">
	#mainHeader{
		background-color: #e9565c !important;
	}
  .active{
    background-color: rgb(233, 233, 233) !important;
  }
  .hero-widget { text-align: center; padding-top: 20px; padding-bottom: 20px; }
  .hero-widget .icon { display: block; font-size: 96px; line-height: 96px; margin-bottom: 10px; text-align: center; color: rgb(227, 42, 50); }
  .hero-widget var { display: block; height: 64px; font-size: 64px; line-height: 64px; font-style: normal; color: rgb(0, 78, 131); }
  .hero-widget label { font-size: 17px; }
  .hero-widget .options { margin-top: 10px; }

  ul.navbar-nav li ul {
      display:none;
  }

  ul.navbar-nav li:hover ul {
      display:block;
      position:absolute;
  }

  .mainmenu>.container>#navbar>ul>li>a{
    color: white;
    font-weight: 700 !important;
  }

  .mainmenu>.container>#navbar>ul>li>a:hover {
    color: black !important;
    font-weight: 700 !important;
    background-color: #297FBA !important;
  }

  .mainmenu>.container>#navbar>ul>li.active>a{
    color: black !important;
    font-weight: 700 !important;
    
  }


	</style>

  <script type="text/javascript">
  if(history.replaceState) history.replaceState({}, "", "getdashboard");
  </script>
  
</head>
<body>
	<nav class="navbar navbar-fixed-top mainmenu" style="background-color: #004E83">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar" style="background-color: rgb(255, 199, 18);">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar" style="background-color: rgb(233, 86, 92);"></span>
            <span class="icon-bar" style="background-color: rgb(233, 86, 92);"></span>
            <span class="icon-bar" style="background-color: rgb(233, 86, 92);"></span>
          </button>
          <a href="getdashboard" class="hidden-xs"><img src="https://www.publishat.com/img/logo.png" alt="" width="70%"></a>
          <a href="getdashboard" class="visible-xs"><img src="https://www.publishat.com/img/logo.png" alt="" width="25%"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active">
              <a href="getdashboard">Home</a>
            </li>
            <li>
              <a href="getcontacts">Contacts</a>
            </li>
            <li>
              <a href="getcertificates">Certificates</a>
            </li>
            <li>
              <a href="getmessages">Events & Messages</a>
            </li>
            
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="logout" style="color: white;"><i class="glyphicon glyphicon-off"></i>&nbsp;logout</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <br>
    
    <br>    
    <br>

<div style="margin-top: 10%;margin-left: 32%;padding: 0;">
<h1>Welcome to Dashboard</h1>

</div>

  <br />

  <div class="container">
    <div class="row">
      <div class="col-sm-3">
            <div class="hero-widget well well-sm">
                  <div class="icon">
                       <i class="glyphicon glyphicon-user"></i>
                  </div>
                  <div class="text">
                      <var><?php echo $usercount['count(*)'] ;?></var>
                      <label class="text-muted">Total Users</label>
                  </div>
                  <div class="options">
                      
                  </div>
              </div>
      </div>
          <div class="col-sm-3">
              <div class="hero-widget well well-sm">
                  <div class="icon">
                       <i class="glyphicon glyphicon-bullhorn"></i>
                  </div>
                  <div class="text">
                      <var>56</var>
                      <label class="text-muted">Camps conducted</label>
                  </div>
                  <div class="options">
                      
                  </div>
              </div>
      </div>
          <div class="col-sm-3">
              <div class="hero-widget well well-sm">
                  <div class="icon">
                       <i class="glyphicon glyphicon-plus"></i>
                  </div>
                  <div class="text">
                      <var>100</var>
                      <label class="text-muted">Blood PINTS Collected</label>
                  </div>
                  <div class="options">
                      
                  </div>
              </div>
        </div>
          <div class="col-sm-3">
              <div class="hero-widget well well-sm">
                  <div class="icon">
                       <i class="glyphicon glyphicon-tint"></i>
                  </div>
                  <div class="text">
                      <var>90</var>
                      <label class="text-muted">Blood Pints Donated</label>
                  </div>
                  <div class="options">
                      
                  </div>
              </div>
      </div>
    </div>
  </div>

</body>
</html>