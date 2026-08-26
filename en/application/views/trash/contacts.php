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
  if(history.replaceState) history.replaceState({}, "", "getcontacts");

  $(document).ready(function($) {
    $("#organisationdiv").hide();
    $("#groupdiv").hide();

    <?php if (isset($status)) { ?>
      var status = <?php echo json_encode($status); ?>;
    <?php } ?>
    //alert(status["status"]);
    if(status["status"] == "success"){
      $('#successdata').html("Successfully inserted");
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

  function uploadexcelfilefunc(){
    //alert(image.id)
    //var file_data = document.getElementById(image.id)[0].getAttribute("value");
    //alert(file_data);
    var file_data = $('#ExcelFileId').prop("files")[0];   // Getting the properties of file from file field
    //alert(file_data);
    var form_data = new FormData();                  // Creating object of FormData class
    form_data.append("UploadedExcel", file_data)              // Appending parameter named file with properties of file_field to form_data    
    $.ajax({
      url:'uploadandreadExcel',
      type:'post',
      dataType: 'script',
      cache: false,
      contentType: false,
      processData: false,
      data: form_data, 

      //data:{uploadImage: image, imageId: imageId, surpriseId: surpriseId},
      beforeSend: function()
      {
          $("#uploadExcelFile").modal('hide');
          $("#loadingmodal").modal('show');
      },
      success: function(data){
        $("#loadingmodal").modal('hide');
        $('#successdata').html("Successfully Registered and added contacts.");
        $('#successModal').modal('show');
        setTimeout(
        function() 
        {
          //do something special
          window.location.href = "getcertificates";
        }, 2000);
        
        /*if(data=="success")
        {
          $("#loadingmodal").modal('hide');
          $('#successdata').html("Successfully inserted");
          $('#successModal').modal('show');
          alert(data["data"]);
          window.location.reload(true);          
        }
        if(data=="failed")
        {
          $('#failuredata').html("Something went wrong");
          $('#failureModal').modal('show');
          //alert(data["data"]);
        }*/
      },
      failure: function(data){
        $("#loadingmodal").modal('hide');
        alert(data);
      }
    });
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
            <li class="active">
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

<!-- <div style="margin-top: 10%;margin-left: 32%;padding: 0;">
</div> -->
  <br />
  <div class="container">
    <div class="col-md-7">
      <form class="form-horizontal" method="post" enctype="multipart/form-data" action="addcontact">
        <div class="form-group">
          <label for="Name" class="col-sm-2 control-label">Name<span class="mandatory">*</span></label>
          <div class="col-md-5">
            <input type="text" class="form-control" id="Name" name="ContactName" placeholder="Name" required>
          </div>
        </div>
        <input type="text" name="Category" value="Health" hidden="true">
        <div class="form-group">
          <label for="mobileemail" class="col-sm-2 control-label">Email<span class="mandatory">*</span></label>
          <div class="col-md-5">
            <!-- <div class="col-md-3" style="border-right: 2px solid #C6C2C2;border-right-style: thick;">
              <input type="number" class="form-control" id="MobilePhoneNumber" name="MobilePhoneNumber" placeholder="Number">
            </div>
            <div class="col-md-4"> -->
              <input type="email" class="form-control" id="PersonalEmail" name="PersonalEmail" placeholder="Email" required>
           <!--  </div> -->
          </div>
        </div>
        <div class="form-group">
          <label for="bloodgroup" class="col-sm-2 control-label">Blood Group</label>
          <div class="col-md-5">
            <select name="BloodGroup" class="form-control">
              <option value="">--select--</option>}
              <option value="AB+">AB+</option>
              <option value="A+">A+</option>
              <option value="B+">B+</option>
              <option value="O+">O+</option>
              <option value="O-">O-</option>
              <option value="A-">A-</option>
              <option value="B-">B-</option>
              <option value="AB-">AB-</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="dob" class="col-sm-2 control-label">Date Of Birth</label>
          <div class="col-md-5">
            <input type="date" name="DateOfBirth" class="form-control" value="" placeholder="">
          </div>
        </div>
        <div class="form-group">
          <label for="contacttype" class="col-sm-2 control-label">Contact Type</label>
          <div class="col-md-5">
            <select name="ContactType" class="form-control" id="contacttype">
              <option value="Organisation">Organisation</option>
              <option value="Group">Group</option>
              <option value="Others" selected>Donor</option>
            </select>
          </div>
        </div>
        <div class="form-group" id="organisationdiv">
          <label for="organisationname" class="col-sm-2 control-label">Organisation Name</label>
          <div class="col-md-5">
            <input type="text" name="OrganisationName" class="form-control" value="" placeholder="">
          </div>
        </div>
        <div class="form-group" id="groupdiv">
          <label for="groupname" class="col-sm-2 control-label">Group Name</label>
          <div class="col-md-5">
            <input type="text" name="GroupName" class="form-control" value="" placeholder="">
          </div>
        </div>
        <div class="form-group">
          <label for="address" class="col-sm-2 control-label">Address</label>
          <div class="col-md-5">
            <textarea name="Address" class="form-control"></textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="notes" class="col-sm-2 control-label">Notes</label>
          <div class="col-md-5">
            <textarea name="Notes" class="form-control" id=""></textarea>
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
            <button type="submit" class="btn btn-success">Register</button>
          </div>
        </div>
      </form>
    </div>
    <div class="col-md-5">
      <div>
        <div class="icon">
          <i class="glyphicon glyphicon-user usercount" style="font-size: -webkit-xxx-large;cursor: -webkit-grab;"></i>User Count<br>
          <span class="usercount" style="font-size: large;color: red;font-weight: 700;cursor: -webkit-grab;"><?php echo $usercount['count(*)']; ?></span>
        </div>
      </div>
      <div class="clearfix"></div>
      <div>
        <div class="icon" data-toggle="modal" data-target="#uploadExcelFile">
          <i class="glyphicon glyphicon-cloud-upload" style="font-size: -webkit-xxx-large;cursor: -webkit-grab;"></i>Upload Excel file<br>          
        </div>
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
  </div>
  

  <!-- modal for adding certificate -->

  <div class="modal fade bs-example-modal-lg" id="uploadExcelFile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h2 class="modal-title" id="myModalLabel"><span id="formHead">Upload Excel file</span></h2>
        </div>
        <div class="modal-body">
<!--           <form method="post" action="UploadCertificate" enctype="multipart/form-data"> -->
          <div class="form-group">
              <label for="exampleInputFile"></label>
              <input type="file" name="uploadExcel" class="form-control" id="ExcelFileId">
              <p class="help-block"></p>
          </div>
          <br><center>
          <button type="submit" class="btn btn-primary" onclick="uploadexcelfilefunc()">Save</button>
          </center>
<!--           </form> -->
        </div>    
      </div>
    </div>
  </div>

  <!-- on ajax call show loading -->
  <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="loadingmodal">
    <div class="modal-dialog modal-sm">
      <div class="modal-content alert alert-primary" role="alert">
        <center><h4>
          <img src="../assets/images/processing.gif" alt="">&nbsp;&nbsp; <span id="successdata"></span>
        </h4></center>
      </div>
    </div>
  </div>

</body>
</html>