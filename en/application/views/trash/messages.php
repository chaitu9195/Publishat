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

  

  .mandatory{

      color: red;

      font-size: 19px;

  }



  .mandatory:hover{

      color: black;

  }



  </style>



  <script type="text/javascript">

  if(history.replaceState) history.replaceState({}, "", "getmessages");



  $(document).ready(function($) {

    $("#organisationdiv").hide();

    $("#groupdiv").hide();



    <?php if (isset($status)) { ?>

      var status = <?php echo json_encode($status); ?>;

    <?php } ?>

    //alert(status["status"]);

    if(status["status"] == "success"){

      $('#successdata').html("Successfully Sent");

      $('#successModal').modal('show');

    }

    if(status["status"] == "failed"){

      $('#failuredata').html("Something went wrong");

      $('#failureModal').modal('show');

    }



      $("#contacttype").change(function(event) {

        var contact = this.value;

        if(contact=='Organisation'){

          $("#organisationdiv").show();

          $("#groupdiv").hide();

        }

        else if(contact=='Group'){

          $("#groupdiv").show();

          $("#organisationdiv").hide();

        }

        else{

          $("#organisationdiv").hide();

          $("#groupdiv").hide();

        }

      });



      $(".usercount").click(function(event) {

        /* Act on the event */

        window.location.href="getcertificates";

      });

  });



  </script>
<script  type="text/javascript">
function showUser(str) {

    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        }
	xmlhttp.open("GET","getuser?q="+str,true);
        xmlhttp.send();
    }
}
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

            <li>

              <a href="getdashboard">Home</a>

            </li>

            <li>

              <a href="getcontacts">Contacts</a>

            </li>

            <li>

              <a href="getcertificates">Certificates</a>

            </li>

            <li class="active">

              <a href="getmessages">Events & messages</a>

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



<!-- <div style="margin-top: 10%;margin-left: 32%;padding: 0;">

</div> -->

  <br />

  <div class="container">

    <div class="col-md-offset-1 col-md-10">

      <form class="form-horizontal" method="post" enctype="multipart/form-data" action="addmessages">

        <div class="form-group">

          <label for="Type" class="col-sm-2 control-label">Event Type<span class="mandatory">*</span></label>

          <div class="col-md-4">

            <input type="text" class="form-control" id="Name" name="Eventtype" placeholder="Event Type" required>

          </div>

        </div>

        <input type="text" name="Category" value="Health" hidden="true">

        <div class="form-group">

          <label for="Name" class="col-sm-2 control-label">Event Name<span class="mandatory">*</span></label>
         <div class="col-md-4"> 

              <input type="text" class="form-control" id="PersonalEmail" name="Eventname" placeholder="Event Name" required>

           <!--  </div> -->

          </div>

        </div>
 <div class="form-group">

          <label for="message" class="col-sm-2 control-label">Messages<span class="mandatory">*</span></label>

          <div class="col-sm-4">

            <textarea name="Message" class="form-control" id="" placeholder="Write a message" required></textarea>

          </div>

        </div>

       <div class="form-group">

          <label for="group" class="col-sm-2 control-label">Select Group</label>

          <div class="col-sm-4">

            <select name="Group" class="form-control" id="contacttype" onchange="showUser(this.value)">
               <option value="">Select</option>
    <?php 
            foreach($group_names as $group_name)
                {
                  $g_names = $group_name["GroupName"];

      ?>
              <option value="<?= $g_names ?>"><?php echo $g_names ?></option>
    <?php
                 }
      ?>
           </select>

          </div>

        </div>

        

        
        <div class="form-group">

          <label for="mailto" class="col-sm-2 control-label">Mail to<span class="mandatory">*</span></label>

          <div class="col-sm-4">

            <textarea name="Mailto" class="form-control" id="txtHint" style="height:200px;" placeholder="Please enter by comma" required></textarea>

          </div>

        </div>

        <!-- <div class="form-group">

          <label for="inputEmail3" class="col-sm-2 control-label">Label / Upload File</label>

          <div class="col-sm-10">

            <div class="col-md-3">

              <input type="text" class="form-control" id="inputEmail3" placeholder="Label">

            </div>

            <div class="col-md-4">

              <input type="file" name="uploadImage" class="form-control" value="" placeholder="">

            </div>

          </div>

        </div> -->

        

        <div class="form-group">

          <div class="col-sm-offset-2 col-sm-10">

            <button type="submit" class="btn btn-success">Send</button>

          </div>

        </div>

      </form>

    </div>

    <div class="col-md-1">

      <div class="icon">

        <i class="glyphicon glyphicon-user usercount" style="font-size: -webkit-xxx-large;cursor: -webkit-grab;"></i><br>

        <span class="usercount" style="font-size: large;color: red;font-weight: 700;cursor: -webkit-grab;"><?php echo $usercount['count(*)']; ?></span>

      </div>

    </div>

  </div>

  



  <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="successModal">

    <div class="modal-dialog modal-sm">

      <div class="modal-content alert alert-success" role="alert">

        <center><h4>

        <i class="glyphicon glyphicon-thumbs-up"></i>&nbsp;&nbsp; <span id="successdata"></span>

        </h4></center>

      </div>

    </div>

  </div>

  <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="failureModal">

    <div class="modal-dialog modal-sm">

      <div class="modal-content alert alert-warning" role="alert">

        <center><h4>

        <i class="glyphicon glyphicon-thumbs-down"></i>&nbsp;&nbsp; <span id="failuredata"></span>

        </h4></center>

      </div>

    </div>
<?php
$result['data']
?>
  </div>

</body>

</html>