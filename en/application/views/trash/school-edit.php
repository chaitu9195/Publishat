  <div class="row">
   <div class="left-heading col-md-6">
    <span class="hidden-xs pull-left">
      <i class="fa fa-graduation-cap fa-2x" aria-hidden="true"></i>
      <span class="h3">Edit School Record</span>
    </span>
    <span class="visible-xs pull-left">
         <i class="fa fa-graduation-cap fa-2x" aria-hidden="true"></i>
               <span class="h4">Edit School Record</span>
      </span>
  </div>
   <div class="right-heading col-md-6">
           <a class="pull-right" href="#/school" onclick = "getVal('1','academic')"> Back </a>
         </div>
        </div>

 <hr class="visible-xs">


<form class="form-horizontal" id="documentForm" name="documentForm" method="post" action="" >
<!-- Error Messages --->
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
        <?php  for($i=0;$i<=count($data ?? array())-1;$i++){
             $level = $data[$i]['Type'];
             $schoolName = $data[$i]['SchoolName'];
             $location = $data[$i]['Location'];
             $class = $data[$i]['Class'];
             $doc_type = $data[$i]['DocumentType'];
             $exam_type = $data[$i]['ExamType'];
             $board = $data[$i]['Board'];
             $yop= $data[$i]['YearofPassing'];
             $marks = $data[$i]['Marks'];
             $maxMarks = $data[$i]['MaxMarks'];
             $grade = $data[$i]['Grade'];
             $rollNumber = $data[$i]['RollNumber'];
             $hallTicketNumber = $data[$i]['HallTicketNumber'];
             $notes = $data[$i]['Notes'];
          ?>

  <div class="row" id="row1">
                <input type="hidden" name="record_type_id" value="1">
                <input type="hidden" name="RecordId" value="<?=$data[$i]['RecordId'];?>">
                <input type="hidden" name = 'module' value="academics" >
    <label class="col-sm-2 hidden-xs">School level <i class="fa fa-asterisk star" aria-hidden="true"></i></label>
                <select name="Type" class="col-sm-4 col-xs-12" id="level">
                  <option value="">-- Select School Level --</option>
      <option <?=($level == "Play School")? 'selected=selected':'' ?> >Play School</option>
                  <option <?=($level == "Pre School")? 'selected=selected':'' ?>>Pre School</option>
                  <option <?=($level == "Primary School")? 'selected=selected':'' ?>>Primary School</option>
      <option <?=($level == "Upper Primary School")? 'selected=selected':'' ?>>Upper Primary School</option>
                  <option <?=($level == "High School")? 'selected=selected':'' ?>>High School</option>
                  <option <?=($level == "X+II / Inter / PUC")? 'selected=selected':'' ?>>X+II / Inter / PUC</option>
      <option <?=($level == "Others")? 'selected=selected':'' ?>>Others</option>
               </select>

    <label class="col-sm-2 hidden-xs">School Name <i class="fa fa-asterisk star" aria-hidden="true"></i>/ Location</label>
    <input class="col-sm-2 col-xs-6 half" type="text" name="SchoolName" value ='<?=$schoolName?>' id = "school_name" placeholder="Enter School Name">
    <span class="gap">&nbsp &nbsp</span>
                <input class="col-sm-2 col-xs-6 half" type="text" name="Location" value='<?=$location?>' placeholder="Enter Location">
  </div>
  <div class="row"  id="row2">
    <label class="col-sm-2 hidden-xs">Class <i class="fa fa-asterisk star" aria-hidden="true"></i></label>
    <select class="col-sm-4 col-xs-12"  name="Class" id="class">
                 <option value="">-- Select Class --</option>
                 <option <?=($class == "Play Group")? 'selected=selected':'' ?>>Play Group</option>       
                 <option <?=($class == "Nursery")? 'selected=selected':'' ?>>Nursery</option>
                 <option <?=($class == "LKG")? 'selected=selected':'' ?>>LKG</option>
                 <option <?=($class == "UKG")? 'selected=selected':'' ?>>UKG</option>
                 <option <?=($class == "Class I")? 'selected=selected':'' ?>>Class I</option>
                 <option <?=($class == "Class II")? 'selected=selected':'' ?>>Class II</option>
                 <option <?=($class == "Class III")? 'selected=selected':'' ?>>Class III</option>
                 <option <?=($class == "Class IV")? 'selected=selected':'' ?>>Class IV</option>
                 <option <?=($class == "Class V")? 'selected=selected':'' ?>>Class V</option>
                 <option <?=($class == "Class VI")? 'selected=selected':'' ?>>Class VI</option>
                 <option <?=($class == "Class VII")? 'selected=selected':'' ?>>Class VII</option>
                 <option <?=($class == "Class VIII")? 'selected=selected':'' ?>>Class VIII</option>
     <option <?=($class == "Class IX")? 'selected=selected':'' ?>>Class IX</option>
                 <option <?=($class == "Class X")? 'selected=selected':'' ?>>Class X</option>
                 <option <?=($class == "Class XI (Junior Intermediate)")? 'selected=selected':'' ?>>Class XI (Junior Intermediate)</option>
                 <option <?=($class == "Class XII (Senior Intermediate)")? 'selected=selected':'' ?>>Class XII (Senior Intermediate)</option>
                 <option <?=($class == "Intermediate")? 'selected=selected':'' ?>>Intermediate</option>
     <option <?=($class == "Others")? 'selected=selected':'' ?>>Others</option>
                </select>

    <label class="col-sm-2 hidden-xs">Document Type  <i class="fa fa-asterisk star" aria-hidden="true"></i></label>
                <select name="DocumentType" class="col-sm-4 col-xs-12" id ="document_type">
                  <option value="">Select Document Type</option>
                  <option <?=($doc_type == 'Bonafide Certificate')? 'selected=selected':'' ?>>Bonafide Certificate</option>
      <option <?=($doc_type == 'Conduct Certificate')? 'selected=selected':'' ?>>Conduct Certificate</option>
      <option <?=($doc_type == 'Hall Ticket')? 'selected=selected':'' ?>>Hall Ticket</option>
      <option <?=($doc_type == 'Marks Memo')? 'selected=selected':'' ?>>Marks Memo</option>
                  <option <?=($doc_type == 'Letter of appreciation')? 'selected=selected':'' ?>>Letter of appreciation</option>
      <option <?=($doc_type == 'Study Certificate')? 'selected=selected':'' ?>>Study Certificate</option>
      <option <?=($doc_type == 'Transfer Certificate')? 'selected=selected':'' ?>>Transfer Certificate</option>                                
                  <option <?=($doc_type == 'Scholarship')? 'selected=selected':'' ?>>Scholarship</option>  
                  <option <?=($doc_type == 'ID Card')? 'selected=selected':'' ?>>ID Card</option>                                   
                  <option <?=($doc_type == 'Progress Report')? 'selected=selected':'' ?>>Progress Report</option>
                  <option <?=($doc_type == 'Pass Certificate')? 'selected=selected':'' ?>>Pass Certificate</option>
                  <option <?=($doc_type == 'Others')? 'selected=selected':'' ?>>Others</option>
              </select>
  </div>
        <div class="row"  id="row3">
    <label class="col-sm-2 hidden-xs">Exam Type / Year of Passing</label>
                <select name="ExamType" class="col-sm-2 col-xs-6 half" id ="exam_type">
                 <option value="">Select Exam Type</option>
                 <option <?=($exam_type == 'Unit Test')? 'selected=selected':'' ?>>Unit Test</option>
                 <option <?=($exam_type == 'Quarterly')? 'selected=selected':'' ?>>Quarterly</option>
                 <option <?=($exam_type == 'Half Yearly')? 'selected=selected':'' ?>>Half Yearly</option>
                 <option <?=($exam_type == 'Annually')? 'selected=selected':'' ?>>Annually</option>
                 <option <?=($exam_type == 'Grand')? 'selected=selected':'' ?>>Grand</option>
                 <option <?=($exam_type == 'Not Applicable')? 'selected=selected':'' ?>>Not Applicable</option>
                </select>
    <span class="gap">&nbsp &nbsp</span>
                <select name="YearofPassing" class="col-sm-2 col-xs-6 half" id ="exam_type">
                  <option value="">Select Year</option>
                  <?php for($d=date("Y");$d >= 1970;$d--){ ?>
                  <option <?=($yop == $d)? 'selected=selected':'' ?>><?=$d;?> </option>
                  <?php } ?>
                </select>

    <label class="col-sm-2 hidden-xs">Board</label>
    <select name="Board" class="col-sm-4 col-xs-12" >
                 <option value="">Select Board</option>
                 <option <?=($board == 'CBSE')? 'selected=selected':'' ?>>CBSE</option>
                 <option <?=($board == 'State')? 'selected=selected':'' ?>>State</option>
                 <option <?=($board == 'ICSE')? 'selected=selected':'' ?>>ICSE</option>                
                 <option <?=($board == 'ISC')? 'selected=selected':'' ?>>ISC</option>
                 <option <?=($board == 'IB')? 'selected=selected':'' ?>>IB</option>
                 <option <?=($board == 'IGCSE')? 'selected=selected':'' ?>>IGCSE</option>
                 <option <?=($board == 'Secondary Education')? 'selected=selected':'' ?>>Secondary Education</option>
           <option <?=($board == 'Board of Intermediate')? 'selected=selected':'' ?>>Board of Intermediate</option>
                 <option <?=($board == 'Others')? 'selected=selected':'' ?>>Others</option>
                </select>
  </div>
  <div class="row"  id="row4">
     <span id="subrow1">  <label class="col-sm-2 hidden-xs">Marks / Max. Marks / Grade</label>
                <input class="col-sm-1 col-xs-6 smalli" type="text" name="Marks" placeholder="Enter Marks" value ='<?=$marks?>'>
    <span class="gap">&nbsp &nbsp</span>
                <input class="col-sm-1 col-xs-6 smalli" type="text" name="MaxMarks" placeholder="Enter Max. Marks" value ='<?=$maxMarks?>'>
    <span class="gap">&nbsp &nbsp</span>
                <input class="col-sm-1 col-xs-6 smalli" type="text" name="Grade" value ='<?=$grade?>' placeholder="Enter Grade">
           </span>
           <span id="subrow2">
    <label class="col-sm-2 hidden-xs">Roll # / Hall Ticket #</label>
                <input class="col-sm-1 col-xs-6 half" type="text" name="RollNumber"  value ='<?=$rollNumber?>' placeholder="Enter Roll No.">
    <span class="gap">&nbsp &nbsp</span>
                <input class="col-sm-1 col-xs-6 half" type="text" name="HallTicketNumber" value ='<?=$hallTicketNumber?>' placeholder="Enter Hall Ticket No.">
           </span>
  </div>
        <div class="row"  id="row5">

    <label class="col-sm-2 hidden-xs">Notes</label>
                <textarea class="col-sm-4 col-xs-12" name="Notes"  placeholder="Enter Notes" ><?=$notes?> </textarea>

                 <span class="col-sm-4 col-xs-6 pull-right">
                   <button class="btn btn-primary" type="submit" id="save"> <span id="sub">Submit</span> 
                     <span class="" id="load"></span></button> &nbsp; &nbsp;
                   <input class="btn btn-default" type="button" value="Cancel" id="reset" onclick='getVal("1","academic")'> 
                </span>   
    
  </div>

<?php } ?>
</form>
        <div class="row"> &nbsp;
           <div id="progress-bar"></div>
        </div>

        <div class="row attachments" >
               <div class="attach_left col-xs-12">
                <div class='attach_title'>  <span class="">Upload / Add New Document</span></div>
               <form class="form-horizontal attach_from" id="attachmentForm" name="attachmentForm" method="post" action=""  enctype="multipart/form-data">
                <input type="hidden" name="record_type_id" value="1">
                <input type="hidden" name="RecordId" value="<?=$data[0]['RecordId'];?>">
                <input type="hidden" name = 'module' value="academics" >
                <div class="upload_input"> 
              
                  <label for='uploadFile'> Select file or Drag & Drop the file here   </label>
                  <input class=" col-xs-6 uploadFile" type="file" name="uploadImage" id="uploadFile" multiple="multiple">
                  <!--<input type="submit" name="saveFile" id="saveFile"> -->
                </div>
             </form>
             </div>
             <div class="attach_left col-xs-12">
                <div class='attach_title'>  <span class="">View / Delete Existing Documents</span></div>
                <div class="upload_input"> 
                <?php if(count($files ?? array())) {
               for($i=0;$i<=count($files ?? array())-1; $i++){ 
                $label = $files[$i]['Notes'];
                $path = '../../..'.$files[$i]['DocumentPath'];
                $filename =  pathinfo($path, PATHINFO_FILENAME);
                 $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION)); ?>
           <div class="col-sm-8 col-xs-12 file_wrapper">
              <?php    if(file_exists($path)){ ?>
            <div class="col-sm-4 col-xs-4 ext_type"> 
              <?=get_icon($ext);?>
            </div>
            <div class='col-sm-8 col-xs-8 filename'> 
             <span class="hidden-xs">
              <?=(!empty($label))? $label : ucfirst(strtolower(substr(strstr(pathinfo($path, PATHINFO_FILENAME),"-"),1,11))); ?>
             </span>                 
            </div> 
             <a href="./downloadfile?rid=<?=$filename.'.'.$ext?>" target="_blank" class="downloadpop " ><i class="fa fa-download" ></i> </a>

             <a href="#/delete?module=&id=" class="downloadpop" onclick= "deleterecord('1','academics','<?=$files[$i]["RecordId"]?>','<?=$files[$i]["DocumentId"]?>')"><i class="fa fa-remove" ></i>          </a>
             </div> 
             <?php } else { echo "no file" ; }
               }//for close
             } else {  echo "Files not found"; }
           ?>
              
                </div>
             </form>
             </div>
  </div> <!--row end -->



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
$(document).ready(function () {
    var docType = "<?=$data[0]['DocumentType']?>" ; 
     show_hide(docType);
});
$('#document_type').change(function(){
    var docType = $('#document_type').val(); 
     show_hide(docType);
});
function show_hide(docType) {
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
}
/* validating file on change*/
$('#uploadFile').change(function(){
     //   var file = $(this).attr("id");
    //fileutils(file);
   if($("#uploadFile").val() != "" && fileutils("uploadFile") != "success" ){ 
      fileutils("uploadFile"); 
   } else {
       $("#error").hide();
       if($("#uploadFile").val()) {   
        $("#attachmentForm").ajaxSubmit({ 
   url: "../web/attachfiles",       
   beforeSubmit: function() {
    $("#progress-bar").width('0%');
   },
   uploadProgress: function (event, position, total, percentComplete){  
    $("#progress-bar").width(percentComplete + '%');
    $("#progress-bar").html('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:100%"> <span id="statusmsg">Uploading '+ $("#uploadFile").val()+ '(' + percentComplete+'%)</span></div></div>');
   },
   success:function (data){  
            if(data != 'Failed'){
            $("#msg1").html("Successfully Uploaded");
            $("#success").show();
             setTimeout(function(){ $("#body_content").html(data); },3000);
         } else if(data == 'Failed') {
           $("#msg").html("Oops! Something went wrong. Please try again ");
           $("#error").show();
          }
   },

  }); 
  return false; 
    }

   }//main else


});

/* upon submitting the form validating all manditory fields */

$("#documentForm").submit(function ( e ) {
        e.preventDefault();
     //validating required form fields
   if($("#level").val() == "") {
       validate("level","Select School Level");
   } else if($("#school_name").val() == ""){  
       validate("school_name","Enter School Name");
   } else if($("#class").val() == ""){  
       validate("class","Select Class");
   } else if($("#document_type").val() == ""){  
       validate("document_type","Select Document Type");
   }  else {
       $("#error").hide();
       $("input,select").css({"border":"1px solid #ccc","background":"#f9f9f9","box-shadow":"inset 0 1px 1px rgba(0,0,0,.075)","transition":"border-color ease-in-out .15s,box-shadow ease-in-out .15s"});
        $("#sub").hide();
        $("#load").html('Updating <i class="fa fa-spinner fa-spin"></i>');

     //storing form data into variable
      var data = new FormData(this);
     $.ajax({
        type: 'POST',
        url: '../web/updatedata',
        data: data,
        processData: false,
        contentType: false, 
        success: function (result) {    
        $("#load").html('Updated <i class="fa fa-check"></i>');
       // $('#myModal').modal('toggle');
       // $('#message').html(result);
       $("#msg1").html("Successfully Updated. Redirecting <i class='fa fa-spinner fa-spin'></i>");
       $("#success").show();
       setTimeout(function(){ getVal('1','academic'); },3000);
        }
     });
    }
  });
function deleterecord(page_id,coming_from,rec_id,doc_id) {
 $.ajax({
        type: 'POST',
        url: '../web/deleteattachment',
        data: {page_refer_id:page_id,module:coming_from,rid:rec_id,docid:doc_id},
        cache: false, 
        async: false,
        success: function (data) {     
       //$('#myModal').modal('toggle');
       // $('#message').html("Successfully Deleted");
       $("#msg1").html("Successfully Deleted. Redirecting <i class='fa fa-spinner fa-spin'></i>");
       $("#success").show();
       setTimeout(function(){ $("#body_content").html(data); },3000);
        }
     });


}

$("#hide_error").click(function(){
       $("#error").hide();
});

$("#reset").click(function(){
       $("#load").hide();
       $("#error").hide();
       $("input,select").css({"border":"1px solid #ccc","background":"#f9f9f9","box-shadow":"inset 0 1px 1px rgba(0,0,0,.075)","transition":"border-color ease-in-out .15s,box-shadow ease-in-out .15s"});
});
</script>



<style type="text/css">
.attach_from { margin:0px !important; }
.attachments{ margin-top:30px; }
.attach_left { width: 48%;
    float: left;
    border: 1px solid #777;
    height: auto;
    padding: 0px !important;
    margin:0 1%;
}
.attach_title { background: #555;
    padding: 5px 15px;
    color: #fff;
    font-weight: 600;
}
.attach_content input { margin-right:5px; width:45%; }



/*file upload */
.upload_input {
  text-align: center;
  position: relative;
  background: #eee;
}
.upload_input label, input#uploadFile + label {
  display: inline-block;
  font-weight: 400 !important;
  font-size: 24px;
  padding: 14px 0 15px 40px;
  position:relative;
  cursor: pointer;
  transition:all .3s;
}
.upload_input label:after {
  content: '\f093';
  width: 16px;
  height: 16px;
  position: absolute;
  top: 18px;
  left: 0;
  font-family: 'FontAwesome';
}
input#uploadFile {
  visibility: hidden;
  position:absolute;
}
input#uploadFile:hover + label, .upload_input label:hover {
  color: #0b5798; transition:all .3s;  }
/*** File attachments **/
.ext_type{ padding:7px; }
.ext_type i { color:#466e90; } 
.filename { padding:0; display:table;}
.filename span { display:table-cell;vertical-align:middle;width:100%;height:58px}
.file_wrapper{ height: 58px;width:23.9%; position:relative;padding:0;border:1px solid #555; background:#f5f5f5; margin:5px 2px;}
a.downloadpop { position: relative;float:left; height:100%; width:50%; top:-58px;left:0; background:#466e90; color:#fff; text-align:center; line-height:50px; font-size:20px;  transition: all 0.3s; display:none;text-decoration:none;}
a.downloadpop i {font-size:20px;padding:8px;border:1px solid #fff; }
.fa-download:hover {background: #009688; }
.fa-remove:hover {background: #d40909; }
.file_wrapper:hover a.downloadpop { display:block; transition: all 0.3s; }
.file_wrapper:hover { background:#f0f0f0; } 


/* mobile */
@media only screen and (min-width : 240px) and (max-width :359px) {
 .attach_from { margin:0px !important; }
.attach_left { width: 100%; float:left; }
}
@media only screen and (min-width : 360px) and (max-width :767px) {
.attach_from { margin:0px !important; }
.attach_left { width: 97.5%; float:left;    border: 1px solid #777; height: auto;    padding: 0px !important;    margin:0 1%; }
}


</style>



<?php 
function get_icon($ext){
               switch ($ext) {
                       case "jpeg":
                             echo '<i class="fa fa-file-image-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case "png":
                             echo '<i class="fa fa-file-image-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case "jpg":
                             echo '<i class="fa fa-file-image-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case "doc":
                             echo '<i class="fa fa-file-word-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case "docx":
                             echo '<i class="fa fa-file-word-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case "pdf":
                             echo '<i class="fa fa-file-pdf-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case "xls":
                             echo '<i class="fa fa-file-excel-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case "xlsx":
                             echo '<i class="fa fa-file-excel-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case "ppt":
                             echo '<i class="fa fa-file-powerpoint-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case "pptx":
                             echo '<i class="fa fa-file-powerpoint-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case "txt":
                             echo '<i class="fa fa-file-text-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case "zip":
                             echo '<i class="fa fa-file-archive-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case "rar":
                             echo '<i class="fa fa-file-archive-o fa-3x" aria-hidden="true"></i>';
                             break;
                      default:
                              echo '<i class="fa fa-file-file-o fa-3x" aria-hidden="true"></i>';
                }

}


?>