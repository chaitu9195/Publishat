<div class="row">
   <div class="left-heading col-md-6">
    <span class="hidden-xs pull-left">
      <i class="fa fa-graduation-cap fa-2x" aria-hidden="true"></i>
      <span class="h3">New School Record</span>
    </span>
    <span class="visible-xs pull-left">
         <i class="fa fa-graduation-cap fa-2x" aria-hidden="true"></i>
               <span class="h4">New School Record</span>
      </span>
  </div>
   <div class="right-heading col-md-6">
           <a class="pull-right" href="#/school" onclick = "getVal('1','academic')"> Back </a>
         </div>
        </div>

 <hr class="visible-xs">


<form class="form-horizontal" id="documentForm" name="documentForm" method="post" action=""  enctype="multipart/form-data">
<!-- Error Messages -->
    <div class="row">
      <div class="alert alert-danger" id ="error" style="display:none">
       <a class="pull-right" id="hide_error">&times;</a>
       <div id="msg"> </div>  
      </div>
      <div class="alert alert-success" id ="success" style="display:none;text-align:center;">
       <a class="pull-right" id="hide_error">&times;</a>
       <div id="msg1"> </div>  
      </div>
   </div>
  <div class="row" id="row1">
                <input type="hidden" name="record_type_id" value="1">
                <input type="hidden" name="UserId" value="373">
    <label class="col-sm-2 hidden-xs">School level <i class="fa fa-asterisk star" aria-hidden="true"></i></label>
                <select name="Type" class="col-sm-4 col-xs-12" id="level">
                  <option value="">-- Select School Level --</option>
      <option value="Play School">Play School</option>
                  <option value="Pre School">Pre School</option>
                  <option value="Primary School">Primary School</option>
      <option value="Upper Primary School">Upper Primary School</option>
                  <option value="High School">High School</option>
                  <option>X+II / Inter / PUC</option>
      <option>Others</option>
               </select>

    <label class="col-sm-2 hidden-xs">School Name <i class="fa fa-asterisk star" aria-hidden="true"></i>/ Location</label>
    <input class="col-sm-2 col-xs-6 half" type="text" name="SchoolName" id = "school_name" placeholder="Enter School Name">
    <span class="gap">&nbsp &nbsp</span>
                <input class="col-sm-2 col-xs-6 half" type="text" name="Location" placeholder="Enter Location">
  </div>
  <div class="row"  id="row2">
    <label class="col-sm-2 hidden-xs">Class <i class="fa fa-asterisk star" aria-hidden="true"></i></label>
    <select class="col-sm-4 col-xs-12"  name="Class" id="class">
                 <option value="">-- Select Class --</option>
                 <option>Play Group</option>        
                 <option>Nursery</option>
                 <option>LKG</option>
                 <option>UKG</option>
                 <option>Class I</option>
                 <option>Class II</option>
                 <option>Class III</option>
                 <option>Class IV</option>
                 <option>Class V</option>
                 <option>Class VI</option>
                 <option>Class VII</option>
                 <option>Class VIII</option>
     <option>Class IX</option>
                 <option>Class X</option>
                 <option>Class XI (Junior Intermediate)</option>
                 <option>Class XII (Senior Intermediate)</option>
                 <option>Intermediate</option>
     <option>Others</option>
                </select>

    <label class="col-sm-2 hidden-xs">Document Type  <i class="fa fa-asterisk star" aria-hidden="true"></i></label>
                <select name="DocumentType" class="col-sm-4 col-xs-12" id ="document_type">
                  <option value="">Select Document Type</option>
                  <option value="Bonafide Certificate">Bonafide Certificate</option>
      <option value="Conduct Certificate">Conduct Certificate</option>
      <option value="Hall Ticket">Hall Ticket</option>
      <option value="Marks Memo">Marks Memo</option>
                  <option value="Letter of appreciation">Letter of appreciation</option>
      <option value="Study Certificate">Study Certificate</option>
      <option value="Transfer Certificate">Transfer Certificate</option>                                
                  <option value="Scholarship">Scholarship</option>  
                  <option value="ID Card">ID Card</option>                                   
                  <option value="Progress Report">Progress Report</option>
                  <option value="Pass Certificate">Pass Certificate</option>
                  <option value="Others">Others</option>
              </select>
  </div>
        <div class="row"  id="row3">
    <label class="col-sm-2 hidden-xs">Exam Type / Year of Passing</label>
                <select name="ExamType" class="col-sm-2 col-xs-6 half" id ="exam_type">
                 <option value="">Select Exam Type</option>
                 <option>Unit Test</option>
                 <option>Quarterly</option>
                 <option>Half Yearly</option>
                 <option>Annually</option>
                 <option>Grand</option>
                 <option>Not Applicable</option>
                </select>
    <span class="gap">&nbsp &nbsp</span>
                <select name="YearofPassing" class="col-sm-2 col-xs-6 half" id ="exam_type">
                  <option value="">Select Year</option>
                  <?php for($d=date("Y");$d >= 1970;$d--){ ?>
                  <option><?=$d;?> </option>
                  <?php } ?>
                </select>

    <label class="col-sm-2 hidden-xs">Board</label>
    <select name="Board" class="col-sm-4 col-xs-12" >
                 <option value="">Select Board</option>
                 <option>CBSE</option>
                 <option>State</option>
                 <option>ICSE</option>                
                 <option>ISC</option>
                 <option>IB</option>
                 <option>IGCSE</option>
                 <option>Secondary Education</option>
           <option>Board of Intermediate</option>
                 <option>Others</option>
                </select>
  </div>
  <div class="row"  id="row4">
     <span id="subrow1">  <label class="col-sm-2 hidden-xs">Marks / Max. Marks / Grade</label>
                <input class="col-sm-1 col-xs-6 smalli" type="text" name="Marks" placeholder="Enter Marks">
    <span class="gap ">&nbsp &nbsp</span>
                <input class="col-sm-1 col-xs-6 smalli" type="text" name="MaxMarks" placeholder="Enter Max. Marks">
    <span class="gap">&nbsp &nbsp</span>
                <input class="col-sm-1 col-xs-6 smalli" type="text" name="Grade" placeholder="Enter Grade">
           </span>
           <span id="subrow2">
    <label class="col-sm-2 hidden-xs">Roll # / Hall Ticket #</label>
                <input class="col-sm-1 col-xs-6 half" type="text" name="RollNumber" placeholder="Enter Roll No.">
    <span class="gap">&nbsp &nbsp</span>
                <input class="col-sm-1 col-xs-6 half" type="text" name="HallTicketNumber" placeholder="Enter Hall Ticket No.">
           </span>
  </div>
        <div class="row"  id="row5">

    <label class="col-sm-2 hidden-xs">Notes</label>
                <textarea class="col-sm-4 col-xs-12" name="Notes" placeholder="Enter Notes"></textarea>
    
    <label class="col-sm-2 hidden-xs">Label / Upload File </label>
                <input class="col-sm-1 col-xs-6 half" type="text" name="uploadedfile_tag" placeholder="Enter Label">
    <span class="gap">&nbsp &nbsp</span>
                <input class="col-sm-1 col-xs-6 half" type="file" name="uploadImage" id="uploadFile">
  </div>
        <div class="row"> &nbsp;
           <div id="progress-bar"></div>
        </div>
        <div class="row">
    <label class="col-sm-2 hidden-xs"></label>
                <span class="col-sm-4 col-xs-6">
                   <button class="btn btn-primary" type="submit" id="save"> <span id="sub">Submit</span> <span class="" id="load"></span></button> &nbsp; &nbsp;
                   <input class="btn btn-default" type="reset" value="Reset" id="reset"> 
                </span>
                
  </div>

</form>

 <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
       
        <div class="modal-body">
          <p><i class="fa fa-spinner fa-spin fa-4x" style="color:#337AB7;"></i></p>
          <div id="message"></div>
        </div>
        
      </div>
    </div>
  </div>

<script type="text/javascript" src="../assets/js/form.min.js"></script>

<script type="text/javascript">
    $('#academic').addClass('active');
/* Show Hide rows based on document type selection */

$('#document_type').change(function(){
    var docType = $('#document_type').val();  
    if(docType == 'Bonafide Certificate' || docType == 'Conduct Certificate' || docType == 'Letter of appreciation' || docType == 'Study Certificate' || docType == 'Transfer Certificate' || docType == 'Scholarship' || docType == 'Progress Report' || docType == 'Others') {  
      $("#row3").hide();
      $("#row4").hide();
    } else if(docType == '' || docType == 'Marks Memo' || docType == 'Pass Certificate') {
      $("#row3").show();
      $("#row4").show();
      $("#subrow1").show();
      $("#subrow2").show();
    } else if(docType == 'Hall Ticket' || docType == 'ID Card') {
      $("#row3").hide();
      $("#row4").show();
      $("#subrow1").hide();
      $("#subrow2").show();
    }else {
      $("#row3").show();
      $("#row4").show();
    }
});

/* validating file on change*/
$('#uploadFile').change(function(){
        var file = $(this).attr("id");
    fileutils(file);
});

/* upon submitting the form validating all manditory fields */

$("#documentForm").submit(function ( e ) {
        e.preventDefault();
     //validating required form fields
   if($("#level").val() == "") {
       validate("level","Select School Level");
   } else if($("#school_name").val() == ""){  
       validate("school_name","Enter School Name");
   }/* else if($("#school_name").val().length < 6) {
       validate("school_name","School Name should be minimum of 6 chars");
   }*/ else if($("#class").val() == ""){  
       validate("class","Select Class");
   } else if($("#document_type").val() == ""){  
       validate("document_type","Select Document Type");
   } else if($("#uploadFile").val() != "" && fileutils("uploadFile") != "success" ){ 
      fileutils("uploadFile"); 
   }  else {
       $("#error").hide();
       $("input,select").css({"border":"1px solid #ccc","background":"#f9f9f9","box-shadow":"inset 0 1px 1px rgba(0,0,0,.075)","transition":"border-color ease-in-out .15s,box-shadow ease-in-out .15s"});
        $("#sub").hide();
        $("#load").html('Submitting <i class="fa fa-spinner fa-spin"></i>');
     if($("#uploadFile").val()) {   

       $('#loader-icon').show();
        $("#load").html('Uploading <i class="fa fa-spinner fa-spin"></i>');
        $(this).ajaxSubmit({ 
   url: "../web/schoolnew",       
   beforeSubmit: function() {
    $("#progress-bar").width('0%');
   },
   uploadProgress: function (event, position, total, percentComplete){  
    $("#progress-bar").width(percentComplete + '%');
    $("#progress-bar").html('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:100%"> <span id="statusmsg">Uploading '+ $("#uploadFile").val()+ '(' + percentComplete+'%)</span></div></div>');
   },
   success:function (data){
          //$('#loader-icon').hide();
                //document.getElementById("documentForm").reset();
                $("#statusmsg").html(data +" (100%) Uploaded Successfully");
                $("#load").html('Inserted <i class="fa fa-check"></i>');
    $('#msg1').html("Successfully Inserted. Redirecting <i class='fa fa-spinner fa-spin'></i>");
                $("#success").show();
                setTimeout(function(){ getVal('1','academic'); },3000);
   },
   resetForm: true
  }); 
  return false; 
    } else {
     //storing form data into variable
      var data = new FormData(this);
     $.ajax({
        type: 'POST',
        url: '../web/schoolnew',
        data: data,
        processData: false,
        contentType: false, 
        success: function (result) {    
        $("#load").html('Inserted <i class="fa fa-check"></i>');
       // $('#myModal').modal('toggle');
       // $('#message').html(result);
       $("#msg1").html("Successfully Inserted. Redirecting <i class='fa fa-spinner fa-spin'></i>");
       $("#success").show();
       rec_count('1');
       setTimeout(function(){ getVal('1','academic'); },3000);
        }
     });
    }
  }
});

$("#hide_error").click(function(){
       $("#error").hide();
});
/*
$("#reset").click(function(){
       $("#load").hide();
       $("#error").hide();
       $("input,select").css({"border":"1px solid #ccc","background":"#f9f9f9","box-shadow":"inset 0 1px 1px rgba(0,0,0,.075)","transition":"border-color ease-in-out .15s,box-shadow ease-in-out .15s"});
});*/
</script>


