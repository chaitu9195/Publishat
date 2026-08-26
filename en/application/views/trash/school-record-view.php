	<div class="center_wrapper">

       <div class="row">
	 <div class="left-heading col-md-8 col-xs-6">
		<span class="hidden-xs pull-left">
			<i class="fa fa-graduation-cap fa-2x" aria-hidden="true"></i>
			<span class="h3">View Record</span>
		</span>
		<span class="visible-xs pull-left">
		     <i class="fa fa-graduation-cap fa-2x" aria-hidden="true"></i>
	   		 <span class="h4">View Record</span>
	    </span>
	</div>

	<div class="right-icons col-md-offset-0 col-md-3 col-xs-4 " id="right_icons" ">
	   <!-- <i class="fa fa-lock fa-2x" aria-hidden="true"></i> -->
	   <!-- <i class="fa fa-cart-plus fa-2x" aria-hidden="true"></i> | -->
	   <!-- <i class="fa fa-file-o fa-2x" aria-hidden="true"></i> -->
	   <a href="#/page=school?mode=edit" onclick="getedit('<?=$data[0]["RecordId"];?>','1','academic')"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
 	  <a href="#/page=school?mode=share" id= 'share_button'><i class="fa fa-share-alt fa-2x" aria-hidden="true"></i></a>
 	    <a href="#/page=school?mode=edit" id= 'delete_button'><i class="fa fa-trash fa-2x" aria-hidden="true"></i> </a>
	 </div>
	<div class="right-icons col-xs-offset-0 col-xs-2 col-md-1 col-md-offset-0 pull-left " id="right_icons" style="display:block;">
	 <button class="btn btn-primary" href="#/school" title ="Add new record" onclick="getVal('1','academic')"> back </button>
         </div>
       </div>
<!-- code to display delete form element -->
     <div class="row delete_rec" id="delete_rec">
        <div class="top_text">
            <span>Enter the Captcha to delete the selected record(s) & related documents. </span>
            <button type="button" id='del_close' class="pull-right btn btn-danger btn-xs"><i class="fa fa-remove" aria-hidden="true"></i>   
            </button>
        </div>
       <div class="delete_body">
          <?php  $code=rand(100000,999999);
             $this->session->set_userdata('captcha', $code);
              ?>     
      <div class="alert alert-danger" id ="error" style="display:none">
       <div id="msg"> </div>  
      </div>
  <form class="form-horizontal col-sm-8 col-sm-offset-1 pad" name="deleteForm" id ='deleteForm'>
    <div class="form-group">
                <input type="hidden" name="record_type_id" value="1">
                <input type="hidden" name="RecordId" value="<?=$data[0]['RecordId'];?>">
                <input type="hidden" name = 'module' value="academics" >
      <label class="control-label col-sm-6 hidden-xs" for="Captcha">Captcha <span style="float:right"> : </span></label>
      <div class="col-sm-6 col-xs-12">
        <span class="captcha"><?=$code ?> </span>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-6 hidden-xs" for="Captcha">Enter Captcha <span style="float:right"> : </span></label>
      <div class="col-sm-6 col-xs-12">          
        <input type="text" class="form-control" name ='captcha'  id="captcha" placeholder="Enter Captcha">
      </div>
    </div>
   
    <div class="form-group">        
      <div class="col-sm-offset-6 col-sm-6">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-default" id="reset">Reset</button>
      </div>
    </div>
   </form>
  </div>
 </div> <!-- end of delete_rec div -->
<!-- code for Email form Element --->
      <div class="row share_rec" id="share_rec">
        <div class="top_text">
            <span>Enter the Captcha to delete the selected record(s) & related documents. </span>
            <button type="button" id='share_close' class="pull-right btn btn-danger btn-xs"><i class="fa fa-remove" aria-hidden="true"></i>   
            </button>
        </div>
       <div class="delete_body">
        <div class="alert alert-danger" id ="error_mail" style="display:none">
           <div id="msg_mail"> </div>  
       </div>
       <form class="form-horizontal col-sm-12 pad" name="emailForm" id ='emailForm'>    
        <div class="form-group">
           <?php if(count($files ?? array())) {
               for($i=0;$i<=count($files ?? array())-1; $i++){ 
                $label = $files[$i]['Notes'];
                $doc_id = $files[$i]['DocumentId'];
                $path = '../../..'.$files[$i]['DocumentPath'];
                $filename =  pathinfo($path, PATHINFO_FILENAME);
                 $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION)); ?> 
                <div class="attchdocuments">
                 <input type="checkbox" name="document_id[]" class='' id="document_id_arr" value="<?=$doc_id;?>">
                 <a href="./downloadfile?rid=<?=$filename.'.'.$ext?>" target="_blank" title ='View / Download File'><span class="files"> <?=(!empty($label))? $label : ucfirst(strtolower(substr(strstr(pathinfo($path, PATHINFO_FILENAME),"-"),1,15))); ?> - <?=$ext?> </span></a>
                </div>
        <?php } } ?>
    </div>
    <div class="form-group">
     <span class='attchdocuments files' style="width:98%"> 
      Please enter the emails separated by a comma (,)
     </span>
    </div>
    <div class="form-group">
                <input type="hidden" name="selective_attach" value="1">
                <input type="hidden" name="record_type_id" value="1">
                <input type="hidden" name="ids" value="<?=$data[0]['RecordId'];?>">
                <input type="hidden" name = 'module' value="academics" >
      <label class="control-label col-sm-3 hidden-xs" for="email">Enter Emails:</label>
      <div class="col-sm-9 col-xs-12">
            <textarea  class="form-control" name ='email_list'  id="emailIds" placeholder="Enter Emails"></textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3 hidden-xs" for="message">Enter Message:</label>
      <div class="col-sm-9 col-xs-12">          
        <textarea  class="form-control" name ='addtext'  id="emailBody" placeholder="Enter Email Body"></textarea>
      </div>
    </div>
   
    <div class="form-group">        
      <div class="col-sm-offset-3 col-sm-6">
        <button type="submit" class="btn btn-primary">Send</button>
        <button type="reset" class="btn btn-default" id="reset">Reset</button>
      </div>
    </div>
  </form>
       </div>
     </div>
<div class='row content'>
         <div class="col-sm-8 col-xs-12 left_wrapper"> 
            <?php  for($i=0;$i<=count($data ?? array())-1;$i++){
             $na = "NA"; ?>
            <div class="col-sm-12 col-xs-12 metadata">
             <span class="col-sm-5 col-xs-5"> <strong>School Level </strong> <span style="float:right"> : </span> </span>
             <span class="col-sm-7 col-xs-7"> <?=(!empty($data[$i]['Type']))? $data[$i]['Type'] : $na;?></span>
            </div>
            <div class="col-sm-12 col-xs-12 metadata">
             <span class="col-sm-5 col-xs-5"> <strong>School Name / Location </strong> <span style="float:right"> : </span> </span>
             <span class="col-sm-7 col-xs-7">
                <?=(!empty($data[$i]['SchoolName']))? $data[$i]['SchoolName'] : $na;?>  /
                <?=(!empty($data[$i]['Location']))? $data[$i]['Location'] : $na;?>
             </span>
            </div>
            <div class="col-sm-12 col-xs-12 metadata">
             <span class="col-sm-5 col-xs-5"> <strong>Class </strong> <span style="float:right"> : </span> </span>
             <span class="col-sm-7 col-xs-7"> <?=(!empty($data[$i]['Class']))? $data[$i]['Class'] : $na;?>  </span>
            </div>
            <div class="col-sm-12 col-xs-12 metadata">
             <span class="col-sm-5 col-xs-5"> <strong>Document Type</strong> <span style="float:right"> : </span> </span>
             <span class="col-sm-7 col-xs-7"> <?=(!empty($data[$i]['DocumentType']))? $data[$i]['DocumentType'] : $na;?> </span>
            </div>
            <div class="col-sm-12 col-xs-12 metadata">
             <span class="col-sm-5 col-xs-5"> <strong>Exam Type / Year of Passing</strong> <span style="float:right"> : </span> </span>
             <span class="col-sm-7 col-xs-7">
              <?=(!empty($data[$i]['ExamType']))? $data[$i]['ExamType'] : $na;?>  / 
              <?=(!empty($data[$i]['YearofPassing']))? $data[$i]['YearofPassing'] : $na;?> 
             </span>
            </div>
            <div class="col-sm-12 col-xs-12 metadata">
             <span class="col-sm-5 col-xs-5"> <strong>Board</strong> <span style="float:right"> : </span> </span>
             <span class="col-sm-7 col-xs-7">
              <?=(!empty($data[$i]['Board']))? $data[$i]['Board'] : $na;?>   
             </span>
            </div>
            <div class="col-sm-12 col-xs-12 metadata">
             <span class="col-sm-5 col-xs-5"> <strong>Marks / Max. Marks / Grade </strong> <span style="float:right"> : </span> </span>
             <span class="col-sm-7 col-xs-7">
              <?=(!empty($data[$i]['Marks']))? $data[$i]['Marks'] : $na;?>  / 
              <?=(!empty($data[$i]['MaxMarks']))? $data[$i]['MaxMarks'] : $na;?> / 
              <?=(!empty($data[$i]['Grade']))? $data[$i]['Grade'] : $na;?>
             </span>
            </div>
            <div class="col-sm-12 col-xs-12 metadata">
             <span class="col-sm-5 col-xs-5"> <strong>Roll # / Hall Ticket # </strong> <span style="float:right"> : </span> </span>
             <span class="col-sm-7 col-xs-7">
              <?=(!empty($data[$i]['RollNumber']))? $data[$i]['RollNumber'] : $na;?>  /
              <?=(!empty($data[$i]['HallTicketNumber']))? $data[$i]['HallTicketNumber'] : $na;?> 
             </span>
            </div>
            <div class="col-sm-12 col-xs-12 metadata">
             <span class="col-sm-5 col-xs-5"> <strong>Notes </strong> <span style="float:right"> : </span> </span>
             <span class="col-sm-7 col-xs-7"> <?=(!empty($data[$i]['Notes']))? $data[$i]['Notes'] : $na;?>  </span>
            </div>
         <?php } ?>
         </div>
          <div class="col-sm-4 col-xs-12">
            <h3> Attachments </h3>
            <?php if(count($files ?? array())) {
               for($i=0;$i<=count($files ?? array())-1; $i++){ 
                $label = $files[$i]['Notes'];
                $path = '../../..'.$files[$i]['DocumentPath'];
                $filename =  pathinfo($path, PATHINFO_FILENAME);
                 $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION)); ?>
           <div class="col-sm-8 col-xs-12 file_wrapper_view">
              <?php    if(file_exists($path)){ ?>
            <div class="col-sm-4 col-xs-4 ext_type"> 
              <?=get_icon($ext);?>
            </div>
            <div class='col-sm-8 col-xs-8 filename'> 
             <span>
              <?=(!empty($label))? $label : ucfirst(strtolower(substr(strstr(pathinfo($path, PATHINFO_FILENAME),"-"),1,11))); ?>
             </span>                 
            </div> 
             <a href="./downloadfile?rid=<?=$filename.'.'.$ext?>" target="_blank" class="downloadpop1"><i class="fa fa-download"></i>
               <?=($ext == 'jpeg' || $ext == 'png' || $ext = 'jpg' || $ext=='pdf' || $ext == 'gif') ?  "View/Download" : "Download"; ?>   </a>
             </div> 
             <?php } else { echo "no file" ; }
               }//for close
             } else {  echo "Files not found"; }
           ?>
                 
         </div>
</div>
</div><!-- row end -->




<script type="text/javascript">
function getedit(id,refer_id,module){
$.ajax({
            type: "POST",
            url: "../web/editrecord",
            data : {rid:id,page_refer_id:refer_id,module:module},
            cache: false, 
            async: false,  
            success: function(data){                                        
             $('#body_content').html(data);
              //alert("file downloded successfully "+data);
            }
        });

}

$("#delete_button").click(function(){
   $(".delete_rec").show();
    $('.content').show(); 
    $(".share_rec").hide();
});
$("#share_button").click(function(){
    $('.content').hide(); 
    $(".share_rec").show();
   $(".delete_rec").hide();
});
$("#deleteForm").submit(function ( e ) {
        e.preventDefault();
   if($('#captcha').val() == ""){
      validate('captcha','Enter Cpatcha');
   } 
   else {
         var data = new FormData(this);
         $.ajax({
            type: "POST",
            url: "../web/deleteRecord",
            data : data,
            processData: false,
            contentType: false,
            success: function(data){  
             if(data =='failed' )  {                                    
             $('#msg').html('Invalid Captcha!. Enter Valid Captcha.');
             $('#error').show(); 
             } else if(data == 'success'){
               $('#error').removeClass('alert-danger');
               $('#error').addClass('alert-success'); 
               $('#msg').html('<i class="fa fa-thumbs-up-o"></i> Record successfully deleted. Redirecting <i class="fa fa-spinner fa-spin"></i>');
               $('#error').show(); 
               $('.content').hide(); 
               setTimeout(function(){  getVal('1','academic'); },4000);
             }
            }
        });
}
});

/* Email form submit */

$("#emailForm").submit(function ( e ) { //console.log($('#emailIds').val());
       e.preventDefault();
   var emaillist = $('#emailIds').val();
    if( emaillist == ''){
        validate("emailIds","");
        $("#msg_mail").html('Email filed should not be empty');
        $("#error_mail").show();
    } else if(checkemail(emaillist) == 'failed') { 
        console.log('Please enter valid email');
           validate("emailIds","");
           $("#msg_mail").html('Please enter valid email');
           $("#error_mail").show();
    } 
   else { 
       $("#error_mail").hide();  
       var data = new FormData(this);
        $.ajax({
            type: "POST",
            url: "../web/mailRecord",
            data : data,
            processData: false,
            contentType: false,
            success: function(data){ 
            if(data !='success' )  {                                    
             $('#msg_mail').html(data);
             $('#error_mail').show(); 
            } else if(data == 'success'){
               $('#error_mail').removeClass('alert-danger');
               $('#error_mail').addClass('alert-success'); 
               $('#msg_mail').html('<i class="fa fa-thumbs-up"></i> Mails sent successfully... <i class="fa fa-spinner fa-spin"></i>');
               $('.form-horizontal').hide();
               $('#error_mail').show();
            setTimeout( function() { $('#share_rec').hide(); $('.content').show();  } , 4000);

         //  setTimeout(function(){  getVal('1','academic1'); },1000);
            }

            }
        });



}



});

$('#academic').addClass('active');
$('#err_close').click(function(){
  $('#error').css({"display":"none"});
});
$('#del_close').click(function(){
    $('#delete_rec').hide();
});
$('#share_close').click(function(){
    $('#share_rec').hide();
    $('.content').show(); 
});
</script>

<style>
.delete_rec, .share_rec { display:none; padding:0px 0 20px 0px; background:#f6f6f6; border:1px solid #eee; margin-top:10px; margin-bottom:20px;width:100%;float:left;}
.delete_rec .top_text, .share_rec .top_text { float:left; background: skyblue; width:100%; margin-top:0; padding:3px; }
.delete_rec .top_text span, .share_rec .top_text span { padding:4px 3px 2px 12px; float:left; width:90%; }
.content { margin-bottom:15px; }
.metadata { margin:20px 10px 10px 30px; }
.left_wrapper { background: #f0f0f0;     padding-bottom: 30px;}
.center_wrapper {  margin-left:2%; width:98%; } 
.ext_type{ padding:10px; }
.ext_type i { color:#466e90; } 
.filename { padding:0; display:table;}
.filename span { display:table-cell;vertical-align:middle;width:100%;height:70px}
.file_wrapper_view{ height: 76px; position:relative;padding:0;border-bottom:1px solid #eee;margin-bottom:5px;}
a.downloadpop1 { position: absolute; height:100%; width:100%; top:0;left:0; background:#466e90; 
    z-index: 5;color:#fff; text-align:center; line-height:70px; font-size:20px;  transition: all 0.3s; display:none;text-decoration:none;}
a.downloadpop1 i {font-size:30px;padding-right:10px;line-height:70px; } .file_wrapper_view:hover a.downloadpop1 { display:block; transition: all 0.3s; }
.fa-download:hover {  background: none;} 
.file_wrapper_view:hover { background:#f0f0f0; } 
.captcha { width: 100%;float: left;padding: 5px;background: #063f73;color: #fff;text-align: center;font-weight: 700;font-size: 30px; }
.err_close { cursor:pointer; text-decoration:none; font-weight:700; }
.delete_body {  padding:15px 30px;float:left; width:100%; }
.modal-footer { border-top: none; }
.pad { padding-top:20px; }
.files {     background: #555;    padding: 5px 10px;    margin: 5px;    color: #fff;}
.attchdocuments { margin:5px; float:left;}
a:hover { text-decoration:none; }
@media only screen and (max-width :767px) { 
.metadata { margin:10px 0px; }
.center_wrapper { background:#fff; margin-left:0px; width:100%; }
.right-icons { padding-left:0px; } 
}
</style>

<?php 
function get_icon($ext){
               switch ($ext) {
                       case "jpeg":
                             echo '<i class="fa fa-file-image-o fa-4x" aria-hidden="true"></i>';
                             break;
                       case "png":
                             echo '<i class="fa fa-file-image-o fa-4x" aria-hidden="true"></i>';
                             break;
                       case "jpg":
                             echo '<i class="fa fa-file-image-o fa-4x" aria-hidden="true"></i>';
                             break;
                       case "doc":
                             echo '<i class="fa fa-file-word-o fa-4x" aria-hidden="true"></i>';
                             break;
                       case "docx":
                             echo '<i class="fa fa-file-word-o fa-4x" aria-hidden="true"></i>';
                             break;
                       case "pdf":
                             echo '<i class="fa fa-file-pdf-o fa-4x" aria-hidden="true"></i>';
                             break;
                       case "xls":
                             echo '<i class="fa fa-file-excel-o fa-4x" aria-hidden="true"></i>';
                             break;
                       case "xlsx":
                             echo '<i class="fa fa-file-excel-o fa-4x" aria-hidden="true"></i>';
                             break;
                       case "ppt":
                             echo '<i class="fa fa-file-powerpoint-o fa-4x" aria-hidden="true"></i>';
                             break;
                       case "pptx":
                             echo '<i class="fa fa-file-powerpoint-o fa-4x" aria-hidden="true"></i>';
                             break;
                       case "txt":
                             echo '<i class="fa fa-file-text-o fa-4x" aria-hidden="true"></i>';
                             break;
                       case "zip":
                             echo '<i class="fa fa-file-archive-o fa-4x" aria-hidden="true"></i>';
                             break;
                       case "rar":
                             echo '<i class="fa fa-file-archive-o fa-4x" aria-hidden="true"></i>';
                             break;
                      default:
                              echo '<i class="fa fa-file-file-o fa-4x" aria-hidden="true"></i>';
                }

}


?>