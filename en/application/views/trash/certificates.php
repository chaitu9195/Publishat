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

  <!-- data tables -->
  <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
  <script src="http://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>  

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
    $(document).ready(function() {

      <?php if (isset($status)) { ?>
        var status = <?php echo json_encode($status); ?>;
      <?php } ?>
      //alert(status["status"]);
      if(status["status"] == "success"){
        $('#successdata').html(status["data"])
        $('#successModal').modal('show');
      }
      if(status["status"] == "failed"){
        $('#failuredata').html(status["data"])
        $('#failureModal').modal('show');
      }


      $("#contactsTable").DataTable();
      if(history.replaceState) history.replaceState({}, "", "getcertificates");
    });

    function opencertmodal(userid){
      $("#UserId").val(userid);
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
            <li class="active">
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



  <br />

  <div class="container">
   <table class="table table-responsive" id="contactsTable">
     <thead>
       <tr>
         <th>Contact Name</th>
         <th>Contact Type</th>
         <th>Created Date</th>
         <th>Upload</th>
       </tr>
     </thead>
     <tbody>
        <?php for ($i=0; $i < count($result['data'] ?? array()) ; $i++) { ?>
          <tr>
            <td><?php echo $result['data'][$i]['ContactName'] ; ?></td>
            <td><?php echo $result['data'][$i]['ContactType'] ; ?></td>
            <td><?php echo $result['data'][$i]['CreatedDate'] ; ?></td>
            <td><button class="col-md-3 btn btn-default" data-toggle="modal" data-target="#uploadCertificate" onclick="opencertmodal('<?php echo $result['data'][$i]['UserId'] ?>')" ><i class="glyphicon glyphicon-paperclip"></i> </button></td>
          </tr>
        <?php } ?> 
     </tbody>
   </table>
  </div>
  

  <!-- modal for adding certificate -->

  <div class="modal fade bs-example-modal-lg" id="uploadCertificate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h2 class="modal-title" id="myModalLabel"><span id="formHead"></span></h2>
        </div>
        <div class="modal-body">
          <form method="post" action="UploadCertificate" enctype="multipart/form-data">
          <div class="form-group">
              <input type="hidden" name="UserId" value="" id="UserId">
              <label for="exampleInputFile">Upload Certificate</label>
              <input type="file" name="uploadImage" class="form-control">
              <p class="help-block"></p>
          </div>
          <br><center>
          <button type="submit" class="btn btn-danger">Save</button>
          </center>
          </form>
        </div>    
      </div>
    </div>
  </div>

  <!-- status modals -->
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

</body>
</html>