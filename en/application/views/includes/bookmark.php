<div class="row">
   <div class="left-heading col-md-6 col-xs-7">
	<span class="hidden-xs pull-left">
	   <i class="fa fa-folder fa-2x" aria-hidden="true"></i>
	   <span class="h3"><?=$param['module']?> Bookmarks</span>
	</span>
	<span class="visible-xs pull-left">
           <i class="fa fa-folder fa-2x" aria-hidden="true"></i>
	   <span class="h4"><?=$param['module']?> Bookmarks</span>
	</span>
      </div>
      <div class="col-md-2 col-md-offset-4 col-xs-4 col-xs-offset-1"> 
	    <a href="#" id= 'create_button'><i class="fa fa-plus-circle fa-2x" aria-hidden="true"></i></a>    
        <a href="#" id= 'share_button'><i class="fa fa-share-alt fa-2x" aria-hidden="true"></i></a>
 	    <a href="#" id= 'delete_button'><i class="fa fa-trash fa-2x" aria-hidden="true"></i> </a>
	 </div>
</div>
<div class="row" id="bookmarks_data">
	<table class="table table-responsive table-stripped">
		<thead>
			<tr>
				<th><input type="checkbox" name="check_all" id="check_all"> </th>
				<th>Title</th>
				<th>Description</th>
				<th>Notes</th>		
			</tr>
		</thead>
              <form name="folderForm" id="bookmarksForm" method="POST" action"#">
			  <input type="hidden" name="typeId" value="<?=$param['typeId']?>">
                <input type="hidden" name="module" value="<?=$param['module']?>">
		<tbody>
<?php
foreach($bookmark as $data){
	$id = $data['_id'];
	$title = $data['Title'];
	$description = $data['Description'];
	$notes = $data['Notes'];
?>
			<tr class='clickable-row'>
				<td><input type="checkbox" name="doc_id" value="<?=$id?>" id="doc_id" class="doc_id"></td>
			   <td><a href="https://<?=$title?>" target="_blank"><?=$title?></a></td>
               <td><a href="<?=$description?>" target="_blank"><?=$description?></a></td>
               <td><?=$notes?></td> 
			   </tr>
<?php } ?>
		</tbody>
</form>	      
	</table>
	
</div>
<div class="row"> 
   <div class="alert alert-danger alert-dismissable" id="error" style="display:none">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
     <strong id="msg"></strong> 
    </div>
    <div id="progress-bar"></div>  
</div>
<div id="share_content" class="share_content" style="display:none;">

           <div class="top_text">
            <span>Send Seletced Files </span>
            <button type="button" id="share_close" class="pull-right btn btn-danger btn-xs"><i class="fa fa-remove" aria-hidden="true"></i>   
            </button>
            </div>
        <div class="alert alert-danger alert-dismissable fade in err" id="mail_error" style="display:none">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <div id="mail_msg"> </div>
        </div>
	 <form class="form-horizontal col-sm-12 pad" name="emailForm" id ='emailForm'>            
	    <div class="form-group">
	     <span class='attchdocuments files' style="width:98%"> 
	      Please enter the emails separated by a comma (,)
	     </span>
	    </div>
	    <div class="form-group">
	                <input type="hidden" name="doc_ids" value="" id="doc_id_arr" class="doc_id_arr">
                        <input type="hidden" name = 'typeId' value="<?=$param['typeId']?>" >
	      <label class="control-label col-sm-3 hidden-xs" for="email">Enter Emails:</label>
	      <div class="col-sm-9 col-xs-12">
	            <textarea  class="form-control ta" name ='email_list'  id="emailIds" placeholder="Enter Emails"></textarea>
	      </div>
	    </div>
	        <div class="form-group">
	      <label class="control-label col-sm-3 hidden-xs" for="message">Enter Subject:</label>
	      <div class="col-sm-9 col-xs-12">          
	        <input type="text" class="form-control ta" name ='subject'  id="subject" placeholder="Enter Subject">
	      </div>
	    </div>
	    <div class="form-group">
	      <label class="control-label col-sm-3 hidden-xs" for="message">Enter Message:</label>
	      <div class="col-sm-9 col-xs-12">          
	        <textarea  class="form-control ta" name ='addtext'  id="emailBody" placeholder="Enter Email Body"></textarea>
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
<div id="delete_content" class=="delete_content" style="display:none;">
	      <div class="top_text">
            <span>Enter the Captcha to delete the selected Folder attachments. </span>
            <button type="button" id="del_close" class="pull-right btn btn-danger btn-xs"><i class="fa fa-remove" aria-hidden="true"></i>   
            </button>
        </div>
          <?php  $code=rand(100000,999999);
             $this->session->set_userdata('folder_captcha', $code);  ?>     
	  <div class="alert alert-danger alert-dismissable fade in err" id="del_error" style="display:none">
	    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	    <div id="del_msg"> </div>
	  </div>
  <form class="form-horizontal col-sm-8 col-sm-offset-1 pad" name="deleteForm" id ='deleteForm'>
      <div class="form-group">
      &nbsp;
      </div>
    <div class="form-group">
                <input type="hidden" name="del_doc_id" value="" id ="del_doc_id" >
                <input type="hidden" name = 'typeId' value="<?=$param['typeId']?>" id="del_file" >
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

</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
    $(".clickable-row").click(function(e) {
	    if (e.target.type == "checkbox") {
          e.stopPropagation();
        } 
    });
});
/*
$('#bookmark_button').click(function(){
$.ajax({
            type: "POST",
            url: "../web/bookmarks",
            data : data,
            processData: false,
            contentType: false,
            success: function(data){ 
			}
});
*/
$("#check_all").click(function(){
  var chk_length = $('input[name="check_all"]:checked').length;
if(chk_length ==0) {
    $(".doc_id").prop('checked', false);
} else { $(".doc_id").prop('checked', true); }
})

$("#share_button").click(function(){ 
      if ($('input[name="doc_id"]:checked').length==0) {
       $("#bookmarks_data").show();
       $("#delete_content").hide();
      $("#share_content").hide();
        $("#msg").html('Select atleast one attachment');
        $("#error").show();
      } else {
      $("#bookmarks_data").hide();
      $("#delete_content").hide();
      $("#share_content").show();
      $("#error").hide();
         var ids = [];
         $.each($("input[name='doc_id']:checked"), function(){   ids.push($(this).val());  });
       $("#doc_id_arr").val(ids);
       $(".doc_id").prop('checked', false);
      }
});
$("#del_close, #share_close").click(function(){
       $("#bookmarks_data").show();
       $("#share_content").hide();
       $("#delete_content").hide();
        $("#error").hide();
      $('input[type="text"], textarea').val("");
      $("#check_all").prop('checked', false);
      $("input,textarea").css({"border":"1px solid #ccc","background":"#f9f9f9","box-shadow":"inset 0 1px 1px rgba(0,0,0,.075)","transition":"border-color ease-in-out .15s,box-shadow ease-in-out .15s"});
});
$("#delete_button").click(function(){ 
  $("#error").removeClass("alert-success");
   $("#error").addClass("alert-danger");
      if ($('input[name="doc_id"]:checked').length==0) {
       $("#bookmarks_data").show();
      $("#share_content").hide();
       $("#delete_content").hide();
        $("#msg").html('Select atleast one attachment');
        $("#error").show();
      } else {
      $("#bookmarks_data").hide();
      $("#share_content").hide();
      $("#delete_content").show();
      $("#error").hide();
         var ids = [];
         $.each($("input[name='doc_id']:checked"), function(){   ids.push($(this).val());  });
       $("#del_doc_id").val(ids);
      $(".doc_id").prop('checked', false);
      }
});

/* Email form submit */

$("#emailForm").submit(function ( e ) { //console.log($('#emailIds').val());
       e.preventDefault();
      $("#error").removeClass("alert-success");
      $("#error").addClass("alert-danger");
   var emaillist = $('#emailIds').val().trim();
    if( emaillist == ''){
        validate("emailIds","");
        $("#msg").html('Email filed should not be empty');
        $("#error").show();
    } else if(checkemail(emaillist) == 'failed') { 
           validate("emailIds","");
           $("#msg").html('Please enter valid email');
           $("#error").show();
    } 
   else { 
       $("#error").hide();  
       var data = new FormData(this);
        $.ajax({
            type: "POST",
            url: "../web/mailbookmarkRecord",
            data : data,
            processData: false,
            contentType: false,
            success: function(data){ 
            if(data !='success')  {                                    
                    $('#msg').html(data);
                    $("#error").removeClass("alert-success");
	            $("#error").addClass("alert-danger");
	            $("#error").show();
	   }else if(data == 'success'){
                       $("#share_content").hide(); 
	               $("#error").addClass("alert-success");
	               $("#error").removeClass("alert-danger");
	               $('#msg').html('<i class="fa fa-thumbs-up"></i> Mails sent successfully... <i class="fa fa-spinner fa-spin"></i>');
	               $('#error').show(); 
	               $('input[type="text"], textarea').val("");
                       $("input,textarea").css({"border":"1px solid #ccc","background":"#f9f9f9","box-shadow":"inset 0 1px 1px rgba(0,0,0,.075)","transition":"border-color ease-in-out .15s,box-shadow ease-in-out .15s"});
	               setTimeout( function() { 
	                   $("#bookmarks_data").show();
			   $("#delete_content").hide();
                            $('#error').hide();
			   } , 4000);
                        
	    }
               //resetform();
            }
        });
    }
});
/*Delete form submit */
$("#deleteForm").submit(function ( e ) {
        e.preventDefault();
   if($('#captcha').val() == ""){
      validate('captcha','Enter Cpatcha');
        //$("#msg").html('Enter Cpatcha');
        $("#error").show();
   } 
   else {
         $("#error").hide();
         var data = new FormData(this);
         $.ajax({
            type: "POST",
            url: "../web/deletebookmarks",
            data : data,
            processData: false,
            contentType: false,
            success: function(data){  
             if(data =='failed' )  {                                    
             $('#del_msg').html('Invalid Captcha!. Enter Valid Captcha.');
             $('#del_error').show(); 
             } else if(data == 'success'){
             $('.form-horizontal').hide();
               $('#del_error').removeClass('alert-danger');
               $('#del_error').addClass('alert-success'); 
               $('#del_msg').html('<i class="fa fa-thumbs-up-o"></i> Record successfully deleted. Redirecting <i class="fa fa-spinner fa-spin"></i>');
               $('#del_error').show(); 
              
               setTimeout(function(){ getBookmark('<?=$param['typeId']?>','<?=$param['module']?>')   },3000);
             } //resetform();
            }
        });
}
});


/*Create New Record*/
$("#create_button").click(function(){
	if ($('input[name="doc_id"]:checked').length==0) {
        $("#msg").html('Select atleast one attachment');
        $("#error").show();
    }
	else{
		var ids = [];
        $.each($("input[name='doc_id']:checked"), function(){   ids.push($(this).val());  });
		getNewrec('<?=$param['typeId']?>', '<?=$param['main_module']?>', ids);
	}	
});


</script>

<style>
.bookmark{
  text-align:center;
  padding :6px;
}
.bookmark_field{
	width:100%;
	border-radius:4px;
}
.txtfield{
    height: 34px !important;
    resize: none !important;
}
 .no_data{
    font-size: 18px;
    text-align: center;
    border: 1px solid #555;
    padding: 15px 0;
    width: 98%;
    margin-left: 15px;
    background: #f7f7f7;
}
.clickable-row{ 
    cursor: pointer;
}
.clickable-row:hover{
	background: lightgray;
}
.attachments{ margin-top:0px }
.imag { width:25px; }
.gpick { border-radius:0px;width:100%;padding: 15px;font-size: 24px; cursor:pointer; }

.files { float:left;width:40%; background: #18536f; border: 1px solid #fff;    padding: 5px 10px;      color: #fff;}
.files:hover{ border: 1px solid #18536f; background:#fff; color:#18536f; } 
.top_text { float:left; background: skyblue; width:100%; margin-top:0; padding:3px; }
.err { margin:5px 3px; width:98%; float:left; }
.captcha { width: 100%;float: left;padding: 5px;background: #063f73;color: #fff;text-align: center;font-weight: 700;font-size: 30px; }
/* mobile */
@media only screen and (min-width : 240px) and (max-width :359px) {
.files { float:left;width:100%;  background: #18536f; border: 1px solid #fff;    padding: 5px 0 0 10px;     color: #fff;}
}
@media only screen and (min-width : 360px) and (max-width :767px) {
.files { float:left;width:100%; background: #18536f; border: 1px solid #fff;    padding: 5px 0 0 10px;     color: #fff;}
}
</style>

