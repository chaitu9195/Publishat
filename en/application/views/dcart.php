<div class="row">
   <div class="left-heading col-md-6 col-xs-8">
	<span class="hidden-xs pull-left">
	   <i class="fa fa-shopping-basket fa-2x" aria-hidden="true"></i>
	   <span class="h3">Document Cart</span>
	</span>
	<span class="visible-xs pull-left">
           <i class="fa fa-shopping-basket fa-2x" aria-hidden="true"></i>
	   <span class="h4">Document Cart</span>
	</span>
      </div>
      <div class="col-md-2 col-md-offset-4 col-xs-3 col-xs-offset-3">
            <a href="#" id= 'share_button'><i class="fa fa-share-alt fa-2x" aria-hidden="true"></i></a>
 	    <a href="#" id= 'delete_button'><i class="fa fa-trash fa-2x" aria-hidden="true"></i> </a>
	 </div>
</div>
<div id="main_content">
  <div class="row">
          <div class="col-md-2 col-xs-6">
           <label> Select Cart Name <span class="pull-right">: </span><label>
          </div>
        <div class="col-md-3 col-xs-6">
		<div class="dropdown cart_dropdown">
           <button class="btn btn-primary dropdown-toggle cart_btn" type="button" data-toggle="dropdown">CART DATA
             <span class="caret pull-right"></span></button>
          <ul class="dropdown-menu" id="cartName">
		        
           <?php
		   foreach($names as $name) {
        ?>
		   <li value="<?=$name?>"><a href="#"><?=$name?><i class="fa fa-remove pull-right" id="deletecart_data" onclick="cartRecDelete('<?=$name?>')"></i></a></li>           
           <?php } ?>
         
             </ul>
           </div> 
        </div>
  </div>
  <div class="row">
  <div class="alert alert-danger alert-dismissable fade in" id="main_error" style="display:none">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <div id="main_msg"> </div>
  </div>
        <table class="table table-responsive table-stripped col-xs-12">
           <thead>
              <tr>
                 <th class="col-xs-1"></th>
                 <th class="col-xs-3"> File Name</th>
                 <th class="col-xs-5"> File</th>
                 <th class="col-xs-3">File Path</th>
              </tr>
            </thead>
          <form class="form-horizontal col-sm-12 pad" name="cartForm" id ='cartForm'>  
            <tbody id="cart_body">            
              <?php foreach($cdata as $data){
               $doc_path = $data['DocumentPath'];
               $label = $data['Notes'];
               $filename = $data['filename'];
               $fid = $data['_id'];
               if(empty($filename)){
					$filename = basename($doc_path);
					$filename = substr($filename, strpos($filename, '-') + 1);
                }
                     $ext = pathinfo($filename, PATHINFO_EXTENSION);
					 $filename = basename($filename, $ext);
					 $filename = substr($filename, 0, 11);
              ?>
                 <tr>
                   <td class="col-xs-1"><input type="checkbox" name="document_id" id="doc_id" class="doc_id" value="<?=$data['DocumentId']?>"></td>
                   <td class="col-xs-4"><?=$filename . '.' . $ext?></td>
                   <td class="col-xs-5"><a href="./docviewer?fid=<?=$data['DocumentId']?>&type=<?=strtolower($ext);?>" target="_blank" title ='View / Download File'><span class="files">
                    <?=get_icon(strtolower($ext));?> &nbsp; <?=$filename . $ext?> </span></a>
                   </td>
                   <td class="col-xs-3"><?=$data['Path']?></td>
                 </tr>
              <?php } ?>
              </tbody>
              </form>
        </table>
 </div>
</div>
        <div class="alert alert-success alert-dismissable fade in err" id="mail_success" style="display:none">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <div id="mail_msg1"> </div>
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
	                <input type="hidden" name = 'module' value="cart" >
					<input type="hidden" name = 'kart' value="<?=$names['KartName']?>" >
	      <label class="control-label col-sm-3 hidden-xs" for="email">Enter Emails:</label>
	      <div class="col-sm-9 col-xs-12">
	            <textarea  class="form-control ta tag-input" name ='email_list'  id="email_list" placeholder="Enter Emails"></textarea>
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
            <span>Enter the Captcha to delete the selected cart documents. </span>
            <button type="button" id="del_close" class="pull-right btn btn-danger btn-xs"><i class="fa fa-remove" aria-hidden="true"></i>   
            </button>
        </div>
          <?php  $code = rand(100000,999999);
             $this->session->set_userdata('cart_captcha', $code);  ?>     
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
                <input type="hidden" name = 'cartname' value="" id="del_c_name" >
                <input type="hidden" name = 'module' value="cart" >
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
<script>
$(document).ready(function(){

var cName = $("#cartName").val();
   $("#del_c_name").val(cName);
});
$("#cartName li").click(function(){
   var cart_name = $(this).attr("value");  
   $("#del_c_name").val(cart_name);
   getcartfiles(cart_name);
});
$("#del_close, #share_close").click(function(){
       $("#main_content").show();
       $("#share_content").hide();
       $("#delete_content").hide();
        //$("#error").hide();
      $('input[type="text"], textarea').val("");
      $("input,textarea").css({"border":"1px solid #ccc","background":"#f9f9f9","box-shadow":"inset 0 1px 1px rgba(0,0,0,.075)","transition":"border-color ease-in-out .15s,box-shadow ease-in-out .15s"});
});
$("#share_button").click(function(){
      if ($('input[name="document_id"]:checked').length==0) {
       $("#main_content").show();
       $("#delete_content").hide();
      $("#share_content").hide();
        $("#main_msg").html('Select atleast one attachment');
        $("#main_error").show();
      } else {
      $("#main_content").hide();
      $("#delete_content").hide();
      $("#share_content").show();
      $("#main_error").hide();
         var ids = [];
         $.each($("input[name='document_id']:checked"), function(){   ids.push($(this).val());  });
       $("#doc_id_arr").val(ids);
       $(".doc_id").prop('checked', false);
      }
});
$("#delete_button").click(function(){
      if ($('input[name="document_id"]:checked').length==0) {
       $("#main_content").show();
      $("#share_content").hide();
       $("#delete_content").hide();
        $("#main_msg").html('Select atleast one attachment');
        $("#main_error").show();
      } else {
      $("#main_content").hide();
      $("#share_content").hide();
      $("#delete_content").show();
      $("#main_error").hide();
         var ids = [];
         $.each($("input[name='document_id']:checked"), function(){   ids.push($(this).val());  });
       $("#del_doc_id").val(ids);
      $(".doc_id").prop('checked', false);
      }
});

/* Email form submit */

$("#emailForm").submit(function ( e ) { //console.log($('#email_list').val());
       e.preventDefault();
   var emaillist = $('#email_list').val();
    if( emaillist == ''){
        validate("email_list","");
        $("#mail_msg").html('Email filed should not be empty');
        $("#mail_error").show();
    } else if(checkemail(emaillist) == 'failed') { 
        console.log('Please enter valid email');
           validate("email_list","");
           $("#mail_msg").html('Please enter valid email');
           $("#mail_error").show();
    } 
   else { 
       $("#mail_error").hide();  
       var data = new FormData(this);
        $.ajax({
            type: "POST",
            url: "../web/mailCartRecord",
            data : data,
            processData: false,
            contentType: false,
            success: function(data){ 
            if(data !='success' )  {                                    
             $('#mail_msg').html(data);
             $('#mail_error').show(); 
              } else if(data == 'success'){ 
                       $("#share_content").hide(); 
	               $('#mail_msg1').html('<i class="fa fa-thumbs-up"></i> Mails sent successfully... <i class="fa fa-spinner fa-spin"></i>');
	               $('#mail_success').show();
	               $('.ta').val("");
	               setTimeout( function() { 
	                   $("#main_content").show();
			   $("#delete_content").hide();
                           $('#mail_success').hide();
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
        $("#del_msg").html('Enter Cpatcha');
        $("#del_error").show();
   } 
   else {
         $("#del_error").hide();
         var data = new FormData(this);
         $.ajax({
            type: "POST",
            url: "../web/deleteCartRecord",
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
              
               setTimeout(function(){ dkart();   },4000);
             } //resetform();
            }
        });
}
});
function cartRecDelete(cartname){
	
	$.ajax({
            type: "POST",
            url: "../web/deleteCartdata",
            data : {cart_name:cartname},
            cache: false, 
            async: false,  
            success: function(data){                                        
               if(data == 'success') {
             $('.form-horizontal').hide();
               $('#main_error').removeClass('alert-danger');
               $('#main_error').addClass('alert-success'); 
               $('#main_msg').html('<i class="fa fa-thumbs-up-o"></i> Record successfully deleted. Redirecting <i class="fa fa-spinner fa-spin"></i>');
               $('#main_error').show(); 
              
               setTimeout(function(){ dkart();   },2000);
               } 
            }
        });
}

</script>
<script>
$(function(){
           // var data1 = [{"Email":"dog"},{"Email":"cat","Email":"fish"},{"Email":"catfish"},{"Email":"dogfish"}]; console.log(data1);
            var data = <?= $email;?>; 
                // Instantiate the Bloodhound suggestion engine
                var tags = new Bloodhound({
                    datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.Email); },
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    local: $.map(data, function(list){
                       return {Email: list};
                    })
                });

                tags.initialize();

                // Set up an on-screen console for the demo
                var screenConsole = $('#console');

                // Write callback data to the screen when tags are added or removed in demo inputs
                var logCallbackDataToConsole = function(added, removed) {
                    screenConsole.append('Tag Data: ' + (this.val() || null) + ', Added: ' + added + ', Removed: ' + removed + '\n');
                };

                // Create typeahead-enabled tag inputs
                $('.tag-input').tagInput({
                  // tags separator
            tagDataSeparator: ',',

                    allowDuplicates: false,
                    typeahead: true,
                    typeaheadOptions: {
                        highlight: true
                    },
                    typeaheadDatasetOptions: {
                        display: function(d) { return d.Email; },
                        source: tags.ttAdapter()
                    },
                    onTagDataChanged: logCallbackDataToConsole
                });

                // Create basic tag inputs with no typeahead
                $('.tag-input-basic').tagInput({
                    onTagDataChanged: logCallbackDataToConsole
                });

                $('#results a[rel="external"]').attr('target', '_blank');

            });

</script>
<style>
.mab-jquery-taginput input{
height: 30.984375px !important;
border: none !important;
width:17em !important;
box-shadow: none !important;
background: white !important;
padding:0px !important;
margin: 0px !important;
}
.tag-input{
height:96px !important;
}
.cart_btn{width:100%}
.btn .caret {margin-top: 7px;}
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


<?php
function get_icon($ext){
               switch ($ext) {
                       case 'jpeg':
                             echo '<i class="fa fa-file-image-o " aria-hidden="true"></i>';
                             break;
                       case 'png':
                             echo '<i class="fa fa-file-image-o " aria-hidden="true"></i>';
                             break;
                       case 'jpg':
                             echo '<i class="fa fa-file-image-o" aria-hidden="true"></i>';
                             break;
                       case 'doc':
                             echo '<i class="fa fa-file-word-o" aria-hidden="true"></i>';
                             break;
                       case 'docx':
                             echo '<i class="fa fa-file-word-o" aria-hidden="true"></i>';
                             break;
                       case 'pdf':
                             echo '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>';
                             break;
                       case 'xls':
                             echo '<i class="fa fa-file-excel-o" aria-hidden="true"></i>';
                             break;
                       case 'xlsx':
                             echo '<i class="fa fa-file-excel-o" aria-hidden="true"></i>';
                             break;
                       case 'ppt':
                             echo '<i class="fa fa-file-powerpoint-o" aria-hidden="true"></i>';
                             break;
                       case 'pptx':
                             echo '<i class="fa fa-file-powerpoint-o" aria-hidden="true"></i>';
                             break;
                       case 'txt':
                             echo '<i class="fa fa-file-text-o" aria-hidden="true"></i>';
                             break;
                       case 'zip':
                             echo '<i class="fa fa-file-archive-o" aria-hidden="true"></i>';
                             break;
                       case 'rar':
                             echo '<i class="fa fa-file-archive-o" aria-hidden="true"></i>';
                             break;
                      default:
                              echo '<i class="fa fa-file-file-o" aria-hidden="true"></i>';
                }
}

?>