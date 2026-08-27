<?php
$Upgraded = $this->session->userdata('Upgraded');
$fid = $_GET['id'];
$id = $_GET['f'];
$viewtype = $this->input->cookie('viewtype',TRUE);
if(!empty($id)){
	$fid = $id;
}
if(empty($fid)){
	$fid = $folid;
}
?>

<div id="content_data">
<div class="row">
   <div class="left-heading col-md-6 col-xs-12">
		<span class="hidden-xs pull-left">
			<i class="fa fa-folder fa-2x" aria-hidden="true"></i>
			<span class="h3">
			<?=$param['module']; ?> Folder</span>
		</span>
		<span class="visible-xs pull-left">
            <i class="fa fa-folder fa-2x" aria-hidden="true"></i>
			<span class="h4"><?=$param['module']?> Folder</span>
		</span>
    </div>
	  <div class="col-md-3 col-xs-5">
			<div class="row attachments">
				<div class="col-md-8 col-xs-9 filter_table">
					<input type="text" class="form-control col-xs-12" id="filter_table" placeholder="Filter Here.." style="">
				</div>
               <div class="col-md-4 col-xs-3">
						<button id="selectoption" class="btn btn-primary">New</button>
						<ul class="fileselection" style="">
							<li id="createfolderoption" class="createoption"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;&nbsp;Create Folder</li>
							<li id="uploadfileoption" class="createoption"><i class="glyphicon glyphicon-file"></i>&nbsp;&nbsp;&nbsp;Upload File</li>
						</ul>
						<!--<div class='attach_title'>  <span class="">Upload Files</span></div>-->
					<form class="form-horizontal attach_from" id="attachmentForm" name="attachmentForm" method="post" action=""  enctype="multipart/form-data">
						<input type="hidden" name="typeId" value="<?=$param['typeId']?>">
						<input type="hidden" name="module" id="module" value="<?=$param['module']?>">
						<input type="hidden" name="foldid" id="foldid" value="<?=$fid;?>">
						<input class=" col-xs-6" type="file" name="uploadedfile[]" id="uploadFile" multiple="multiple" style="display:none">
						<!--<div class="upload_input" style="background:none"> 
						<!--<i class="glyphicon glyphicon-cloud-upload" style="font-size: 35px; cursor: pointer"></i>-->
				    
						<!--<label for='uploadFile'> </label>-->
                 
						<!--<input type="submit" name="saveFile" id="saveFile"> -->
						<!--</div>-->
					</form>
             </div>
		</div>
	 </div>
      <div class="col-md-2  col-xs-6 col-xs-offset-1">
	        <a href="#" class = "" onClick="loadPicker()" style="color:#d8473d;"><i class="fa fa-google fa-2x" aria-hidden="true">&nbsp;|</i></a>   
			<a href="#" id= 'bookmark_button' onclick = "getBookmark('<?=$param['typeId']?>','<?=$param['module']?>','<?=$param['main_module']?>')"><i class="fa fa-thumb-tack fa-2x" aria-hidden="true"></i></a>
			<a href="#" id= 'create_button'><i class="fa fa-plus-circle fa-2x" aria-hidden="true"></i></a>    
			<a href="#" id= 'share_button'><i class="fa fa-share-alt fa-2x" aria-hidden="true"></i></a>
			<a href="#" id= 'delete_button'><i class="fa fa-trash fa-2x" aria-hidden="true"></i> </a>
	 </div>
</div>
<div class="row path">
<?php
$counter = 0;
foreach((array) $fpath as $f_name){ ?>
<a onClick="getfolderfiles('<?=$f_name['ParentId'];?>')" class="folder_path subfolderpath" style="display:none;"><?=$param['module']?><span class="glyphicon glyphicon-chevron-right arrow_ico" style="color: rgba(51, 122, 183, 0.48);"></span></a>
<a onClick="getfolderfiles('<?=$f_name['_id'];?>')" class="folder_path"><?=$f_name['FolderName'];?>
<?php
$counter++;
if ($counter < count(is_array($fpath) ? $fpath : [])) { ?>
<span class="glyphicon glyphicon-chevron-right arrow_ico" style="color: rgba(51, 122, 183, 0.48);"></span>                 
<?php } else { ?>
 <span class="glyphicon glyphicon-triangle-bottom arrow_ico"></span></a>
<?php  } }?>
</div>
<div class="row"> 
   <div class="alert alert-danger alert-dismissable" id="error" style="display:none">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
     <strong id="msg"></strong> 
    </div>
	<?php
	if($status == 'success'){
		?>
		 <div class="alert alert-success alert-dismissable" id="error">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
     <strong id="msg">File(s) successfully uploaded</strong> 
<?php 	} else if($status == 'failed'){?>
		 <div class="alert alert-danger alert-dismissable" id="error">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
     <strong id="msg">No File Selected</strong> 

<?php }
	?>
    <div id="progress-bar"></div>  
</div>
<div id="main_content">

<div class="row attachments">
 <?php if(is_array($files) && count($files) > 0 && $files != 'No Files') { ?>
	<table class="table table-responsive table-stripped" id="fol_data">
		<thead>
			<tr>
				<th><input type="checkbox" name="check_all" id="check_all"> </th>
				<th></th>
				<th>File Name</th>
				<th>Type</th>
				<th>Size</th>
				<th>Date</th>
                <th></th>				
			</tr>
		</thead>
              <form name="folderForm" id="folderForm" method="POST" action="#">
	     <tbody id="searchable_data">
		<?php foreach($files as $file){
             $id = $file['_id'];
		     $path = $file['DocumentPath'];
		     $type = strtolower($file['FileType']);
			 $filename = $file['filename'];
			 if(empty($type)){
				 $type = strtolower(get_file_extension($filename));
			 }
		     $images = ['jpg', 'png', 'jpeg', 'gif', ''];
			 $fileextension = ['zip','rar'];

             $not_image = get_folder_document_icon($type);
			 $fol_type = $file['Type'];
			 $fol_name = $file['FolderName'];

			 if($fol_type == 'Folder'){
				 $view_file = '<i class="glyphicon glyphicon-folder-open" style="font-size:22px;color:#fedd8a"></i>';
			 }
			 else{
				if(in_array($type, $images ?? [])){
					$url = base_url() . "web/viewfile?fid=$id&type=png";
					$view_file = "<img src='$url' alt='$filename;' width='30px' height='30px'>";
				}
		        else { $view_file = '<img src="../../../' . $not_image . '" id="img" class="img-responsive img imag" >'; }
			 }

			 $size = filesize_formatted($file['length']);
			 $date = date('d-M-Y', strtotime($file['TS']));

			 if(empty($filename)){
				$doc_path = $file['DocumentPath'];
		        $filename = basename($doc_path);

				$filename = substr($filename, strrpos($filename, '-') + 1);
				}
			 $ext = pathinfo($filename, PATHINFO_EXTENSION);
			 $path = base_url() . 'web/viewfile?fid=' . $id;
			 ?>
            <?php if($fol_type == 'File'){ ?>
               <tr onClick="viewfile('docviewer?fid=<?=$file['_id'];?>&type=<?=strtolower($ext);?>')">
            <?php  } else { ?>
			   <tr onClick="getfolderfiles('<?=$file['_id'];?>')">
			<?php  } ?>
			<td>
			<input type="checkbox" name="doc_id" value="<?=$file['_id']?>" id="doc_id" class="doc_id"><input type="hidden" id="path<?=$id;?>" value="<?=$path;?>"> 
			<input type="hidden" id="filetype<?=$id;?>" value="<?=$type;?>">
			<input type="hidden" id="filename<?=$id;?>" value="<?=$filename;?>">
			</td>
				<td><?=$view_file?></td>
				<td><?php if($fol_type == 'File'){
						echo $filename;
					} else{
						echo $fol_name;
				}?></td>
				<td><?php if($fol_type == 'File'){ echo $type; } else{ echo '-'; }?></td>
				<td><?php if($fol_type == 'File'){ echo $size; } else{ echo '-'; }?></td>
				<td><?=$date;?></td>
				<td>
				<?php if($fol_type == 'File' && !in_array($type, $fileextension ?? [])){ ?>
				<i class="fa fa-print modal_data" aria-hidden="true" data-toggle="modal" id="<?=$id;?>"  data-target="#myModal<?=$id;?>" title="Print"></i>
				<?php } ?>
				</td>
			</tr>
			<!-- Cotainer Start -->
			<div class="container">
			<!-- Modal Start-->
				<div class="modal fade animated bounceIn" id="myModal<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
					<!-- Modal content Start-->
						<div class="modal-content">
							<div class="modal-body" id="modaldata<?=$id;?>">
          
							</div>
						</div> 
					<!-- Modal content End-->
					</div>
				</div>
				<!-- Modal End-->
			</div>
			<!-- Cotainer End -->
		<?php } ?>
		</tbody>
</form>	      
	</table>
	<?php } else { echo "<div class='no_data'> Attachments Not Found  </div>"; } ?>
	
</div>

<!------------------------------ Create Folder ------------------------->  
<div class="row">
<div class="col-md-4 col-md-offset-4 createfolder">
  <form action="" method="POST" id="createform">
	  <div class="form-group">
		<input type="text" class="form-control" placeholder="Folder Name" id="folder_name">
		<input type="hidden" name="folder_id" value="<?=$fid;?>" id="folder_id">
		<input type="hidden" name="typeId" value="<?=$param['typeId']?>" id="typeId">
	</div>
	  <div class="form-group">
		<button type="submit" class="btn btn-primary">Create</button>
		<button type="button" class="btn btn-danger" id="cancelbtn">Cancel</button>
	  </div>
  </form>
</div>
</div>
<!------------------------------ Create Folder End ---------------------->

</div> <!--<div id="main_content"> -->
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
            <span>Enter the Captcha to delete the selected Folder attachments. </span>
            <button type="button" id="del_close" class="pull-right btn btn-danger btn-xs"><i class="fa fa-remove" aria-hidden="true"></i>   
            </button>
        </div>
          <?php  $code = rand(100000,999999);
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
<div id="folderdata"></div>

</div>
</div>
<script type="text/javascript">
var base_url = '<?php echo base_url();?>';
var modules = ["academic","professional","personal", "medical", "financial","legal"];
$.each(modules, function (index, main_module) {
  if(main_module == '<?=$param['main_module']?>'){
	  //console.log(main_module);
	  if(main_module == "medical"){
		 $('#health').addClass('active');
	 }else{
	 $('#'+main_module).addClass('active');}
  }
  else{
	  if(main_module == "medical"){
		 $('#health').removeClass('active');
	 }else{
	 $('#'+main_module).removeClass('active');}
  }
});
 $(".subfolderpath:nth-of-type(1)").show();
function sheetCount(){
  return SpreadsheetApp.getActive().getSheets().length;
}
jQuery(document).ready(function($) {
	$('.modal_data').one('click',function(e){ 
	e.stopPropagation();
    var id = this.id;  
	var path = $("#path"+id).val(); 
	var filetype = $("#filetype"+id).val(); 
	var filename = $("#filename"+id).val(); 
	var typeId  = '<?=$param['typeId'];?>'; 
	var module = '<?=$param['main_module'];?>';
    $.ajax({
        url: base_url+"web/previewdata",
        data: {id: id,path: path,filetype: filetype, typeId: typeId, module: module, filename: filename},
        type: "get",
        success: function(data){ 
			$('#body_content').html(data);
			var len = sheetCount(); //alert(len);
			
		}  		
	});
});
	
    $(".clickable-row").click(function(e) {
	    if (e.target.type == "checkbox") {
          e.stopPropagation();
        } 
		else {
          window.open($(this).data("href"));
		}
    });
	
	$(".createfolder").hide();
	$(".fileselection").hide();
	$("#selectoption").click('on', function(){
		$(".fileselection").show();
	}); 
	$("#createfolderoption").click(function(){
		$(".createfolder").show();
		$(".fileselection").hide();
	});
	$("#uploadfileoption").click(function(){
		$("#uploadFile").click();
		$(".fileselection").hide();
	});
	$("#cancelbtn").click('on', function(){
		$(".createfolder").hide();	
        $("#selectoption").val("");			
	});
	
	
	$("#createform").submit('on', function(event){ 
		event.preventDefault();
		var folder_name = $("#folder_name").val();			
		var fid = $("#folder_id").val(); 
		var typeId = $("#typeId").val();
		var module = $("#module").val();
		$.ajax({
			type: "POST",
			data: {folder_name: folder_name, folder_id: fid, typeId: typeId,module: module},
			url: base_url+"web/createfolder",
			cache: false, 
			async: false,  
			success: function(data){  
                $(".createfolder").hide();				
			    $("#content_data").html(data);
			}
		});
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
/* validating file on change*/
$('#uploadFile').change(function(){ 
var Upgraded = '<?=$Upgraded;?>'; 
   if($("#uploadFile").val() != "" && fileutils("uploadFile", Upgraded) != "success" ){ 
      fileutils("uploadFile", Upgraded); 
   } else{
 	            $("#msg").html("Uploading Files");
	            $("#error").addClass("alert-success");
	            $("#error").removeClass("alert-danger");
	            $("#error").show();
    var numFiles = $("input:file")[0].files.length; 
	    var foldid = $("#foldid").val();
		var module = $("#module").val();
        var data = new FormData($('#attachmentForm')[0]);
		data.append('foldid',foldid);
		data.append('module',module);
		//alert(base_url);
        $.ajax({
            type: "POST",
            url: base_url+"web/uploadfolderfiles",
            data : data,
            processData: false,
            contentType: false,
            success:function (data){ 
           
				$("#content_data").html(data);
	        }
      });
   }
});

$("#share_button").click(function(){ 
      if ($('input[name="doc_id"]:checked').length==0) {
       $("#main_content").show();
       $("#delete_content").hide();
      $("#share_content").hide();
        $("#msg").html('Select atleast one attachment');
        $("#error").show();
      } else {
      $("#main_content").hide();
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
       $("#main_content").show();
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
       $("#main_content").show();
      $("#share_content").hide();
       $("#delete_content").hide();
        $("#msg").html('Select atleast one attachment');
        $("#error").show();
      } else {
      $("#main_content").hide();
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

$("#emailForm").submit(function ( e ) { //console.log($('#email_list').val());
       e.preventDefault();
      $("#error").removeClass("alert-success");
      $("#error").addClass("alert-danger");
   var emaillist = $('#email_list').val().trim();
    if( emaillist == ''){
        validate("email_list","");
        $("#msg").html('Email filed should not be empty');
        $("#error").show();
    } else if(checkemail(emaillist) == 'failed') { 
           validate("email_list","");
           $("#msg").html('Please enter valid email');
           $("#error").show();
    } 
   else { 
       $("#error").hide();  
       var data = new FormData(this);
        $.ajax({
            type: "POST",
            url: base_url+"web/mailFolderRecord",
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
	                   $("#main_content").show();
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
            url: base_url+"web/deleteFolderFile",
            data : data,
            processData: false,
            contentType: false,
            success: function(data){ 
             if(data =='failed' )  {                                    
             $('#del_msg').html('Invalid Captcha!. Enter Valid Captcha.');
             $('#del_error').show(); 
             }else if(data =='FolderData' )  {                                    
             $('#del_msg').html('Your item cannot be deleted as it contains files.');
             $('#del_error').show(); 
			 setTimeout(function(){ getFolder('<?=$param['typeId']?>','<?=$param['module']?>')   },2000);
             } else if(data == 'success'){
             $('.form-horizontal').hide();
               $('#del_error').removeClass('alert-danger');
               $('#del_error').addClass('alert-success'); 
               $('#del_msg').html('<i class="fa fa-thumbs-up-o"></i> Record successfully deleted. Redirecting <i class="fa fa-spinner fa-spin"></i>');
               $('#del_error').show(); 
              
               setTimeout(function(){ getFolder('<?=$param['typeId']?>','<?=$param['module']?>')   },3000);
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
function getfolderfiles(pid){ 
          var typeId = $("#typeId").val();
		  var module = $("#module").val();
	$.ajax({
			type: "GET",
			data: {id: pid,typeId: typeId,module: module},
			url: base_url+"web/createdfolder",
			cache: false, 
			async: false,  
			success: function(data){
                  //$("#folderdata").html(data);
				  $("#content_data").html(data);
			}
		});
}
$('.doc_id').click(function(e){
	e.stopPropagation();
	
});
   (function ($) {

        $('#filter_table').keyup(function () {
            var rex = new RegExp($(this).val(), 'i');
            $('#searchable_data tr').hide();
            
            $('#searchable_data tr').filter(function () {
                return rex.test($(this).text());
            }).show();
        });


    }(jQuery));
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
.btn.disabled {
    pointer-events: none;
}

* {
  box-sizing: border-box;
}

.modal-dialog{
	margin:0px !important;
}
.modal {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  overflow: hidden;
}

.modal-dialog {
  position: fixed;
  margin: 0;
  width: 100%;
  height: 100%;
  padding: 0;
}

.modal-content {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  //border: 2px solid #3c7dcf;
  border-radius: 0;
  box-shadow: none;
}

.modal-title {
  font-weight: 300;
  font-size: 2em;
  color: #fff;
  line-height: 30px;
}

.modal-body {
  position: absolute;
  width: 100%;
  font-weight: 300;
  overflow: auto;
  paddig:0px !important;
  height:100% !important;
}


/* ::-webkit-scrollbar {
  -webkit-appearance: none;
  width: 10px;
  background: #f1f3f5;
  border-left: 1px solid darken(#f1f3f5, 10%);
}

::-webkit-scrollbar-thumb {
  background: darken(#f1f3f5, 20%);
} */
 .modal_data{color: #286090;font-size:20px;}


 
 .bookmark_ico{
	font-size: 23px;
    font-weight: bold;
 }
 .path{padding-left:14px;}
.folder_path{
	font-size:20px !important;
	font-weight:200;
	color: rgba(51, 122, 183, 0.48);
}
.arrow_ico{
	font-size:15px !important;
	padding:8px;
}
.folder_path:last-of-type {
	font-size:21px;
	font-weight:700;
	color: #337ab7;
	 pointer-events: none;
}
.createfolder{
	height: 150px !important;
	background: lightgray !important;
	padding: 2% !important;
	position: absolute !important;
	top: 200px !important;
        left: 40px!important;
	display: none;
}
.uploadfile{
	height: 150px;
	background: lightgray;
	padding: 2%;
	position: absolute;
	top: 200px;
	display: none;
}
.tabledata{
	margin: 1% 0%;
}
.datatable tr{
	cursor: pointer;
}
.tabledata a{
	text-decoration: none;
	cursor: pointer;
	font-size: 20px;
	font-family: serif;
}
.view{
	padding: 10px;
        border: 1px solid rgba(0, 126, 255, 0.11);
        border-radius: 10px;
	margin:10px;
        cursor:pointer;
}
.properties{
	padding:15px;
}
.folder_path{
	font-size:12px;
	font-weight:200;
	color: rgba(51, 122, 183, 0.48);
}
.arrow_ico{
	font-size:15px;
	padding:8px;
}
.folder_path:last-of-type {
	font-size:21px;
	font-weight:700;
	color: #337ab7;
}
.imag { width:25px; }
.listgrid{
	font-size: 20px;
	cursor:pointer;
			
}
.emptydata {text-align: center;font-size: 20px;}
.hidden {visibility: hidden;over-flow: hidden;width: 0px;height: 0px;}   
.view_gridfold{padding:18px !important;}  
.header{height:70px;background-color:#466e90;padding:0px !important;}    
.logo{color:white;padding-left: 3%;position: absolute;} 
.createoption{padding: 4% !important;font-size: 16px;color: white;cursor: pointer}   
.fileselection{background-color: white;position:absolute;width:200px; z-index: 1000;background: gray;display:none;list-style:none;padding:0px;}  
.imagegrid{height:150px !important;} 
.selectfield_prop{
background-color:rgba(70, 110, 144, 0.21) !important;
} 
.filter_table{padding:0 0 0 5px;}
.bookmark{
  display :none;
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
tr{ 
    cursor: pointer;
}
tr:hover{
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

.dialog_box{
    margin: 13% 10% 2% 30% !important;
	width: 31%;
}
.main_content{
	text-align:center;
}
#paymentModal .modal-dialog{
    right: 25% !important;	
}
</style>

<?php
function filesize_formatted($bytes)
{
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        return $bytes . ' bytes';
    } elseif ($bytes == 1) {
        return '1 byte';
    } else {
        return '0 bytes';
    }
}

function get_folder_document_icon($file_type){
    $file_type = strtolower($file_type);
  switch($file_type){
	case 'jpg': $icon = '/graphics/foldericons/icon-jpg.png'; break;
	case 'png': $icon = '/graphics/foldericons/icon-png.png'; break;
    case 'jpeg': $icon = '/graphics/foldericons/icon-jpeg.png'; break;
    case 'pdf': $icon = '/graphics/foldericons/icon-pdf.jpg'; break;
    case 'doc': $icon = '/graphics/foldericons/icon-word.jpg'; break;
    case 'docx': $icon = '/graphics/foldericons/icon-word.jpg'; break;
    case 'odt': $icon = '/graphics/foldericons/icon-word-odt.png'; break;
    case 'ods': $icon = '/graphics/foldericons/icon-ods.jpg'; break;
    case 'odp': $icon = '/graphics/foldericons/icon-odp.jpg'; break;
    case 'txt': $icon = '/graphics/foldericons/icon-text.png'; break;
    case 'rtf': $icon = '/graphics/foldericons/icon-text.png'; break;
    case 'xls': $icon = '/graphics/foldericons/icon-xls.png'; break;
    case 'xlsx': $icon = '/graphics/foldericons/icon-xls.png'; break;
    case 'xps': $icon = '/graphics/foldericons/icon-xps.png'; break;
    case 'zip': $icon = '/graphics/foldericons/icon-zip.png'; break;
    case 'rar': $icon = '/graphics/foldericons/icon-rar.png'; break;
    case 'mp3': $icon = '/graphics/foldericons/icon-mp3.jpg'; break;
    case 'html': $icon = '/graphics/foldericons/icon-html.png'; break;
    case 'css': $icon = '/graphics/foldericons/icon-html.png'; break;
    case 'htm': $icon = '/graphics/foldericons/icon-html.png'; break;
    case 'js': $icon = '/graphics/foldericons/icon-js.gif'; break;
    case 'xml': $icon = '/graphics/foldericons/icon-xml.png'; break;
    case 'php': $icon = '/graphics/foldericons/icon-php.png'; break;
    case 'ppt': $icon = '/graphics/foldericons/icon-ppt.png'; break;
    case 'pptm': $icon = '/graphics/foldericons/icon-ppt.png'; break;
    case 'pptx': $icon = '/graphics/foldericons/icon-ppt.png'; break;
  default: $icon = '/graphics/icon_pdf.png'; break;
  }
  return $icon;
}

?>

<!--************************************* Google Picker Code START ********************************************************-->
<script type="text/javascript" src="https://apis.google.com/js/api.js"></script>
<script type="text/javascript">

    // The Browser API key obtained from the Google Developers Console.
    // Replace with your own Browser API key, or your own key.
    var developerKey = '700321064212-m4p4ltakaf4v2112fqf59v1uoloolb5q@developer.gserviceaccount.com';

    // The Client ID obtained from the Google Developers Console. Replace with your own Client ID.
    var clientId = "298801891056-j98ls2col6k6hke0pf44mod6q4dbds06.apps.googleusercontent.com"

    // Replace with your own App ID. (Its the first number in your Client ID)
    var appId = "298801891056";

    // Scope to use to access user's Drive items.
    var scope = ['https://www.googleapis.com/auth/drive'];

    var pickerApiLoaded = false;
    var oauthToken;

    // Use the Google API Loader script to load the google.picker script.
    function loadPicker() { console.log("hello");
      gapi.load('auth', {'callback': onAuthApiLoad});
      gapi.load('picker', {'callback': onPickerApiLoad});
    }

    function onAuthApiLoad() {
      window.gapi.auth.authorize(
          {
            'client_id': clientId,
            'scope': scope,
            'immediate': false
          },
          handleAuthResult);
    }

    function onPickerApiLoad() {
      pickerApiLoaded = true;
      createPicker();
    }

    function handleAuthResult(authResult) {
      if (authResult && !authResult.error) {
        oauthToken = authResult.access_token;
        createPicker();
      }
    }

    // Create and render a Picker object for searching images.
    function createPicker() {
      if (pickerApiLoaded && oauthToken) {
        var view = new google.picker.View(google.picker.ViewId.DOCS);
        view.setMimeTypes("image/png,image/jpeg,image/jpg,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,text/plain,application/octet-stream");
        var picker = new google.picker.PickerBuilder()
            .enableFeature(google.picker.Feature.NAV_HIDDEN)
            .enableFeature(google.picker.Feature.MULTISELECT_ENABLED)
            .setAppId(appId)
            .setOAuthToken(oauthToken)
            .addView(view)
            .addView(new google.picker.DocsUploadView())
            .setCallback(pickerCallback)
            .build();
         picker.setVisible(true);
      }
    }

    // A simple callback implementation.
    function pickerCallback(data) {
      if (data.action == google.picker.Action.PICKED) {
        var fileId = data.docs[0].id;
        var name = data.docs[0].name;
        var size = data.docs[0].sizeBytes;
		var foldid = $("#foldid").val();
		var module = $("#module").val();
               $.ajax({
				type: "POST",
				url: "../Thirdparty/gpicker",
				data: { file_id:fileId, token:oauthToken, file_name:name,foldid:foldid,module:module, recordtypeid:<?=$param['typeId'];?>, file_size:size},
				success: function(data)
				{   
				$("#content_data").html(data);
		     
				}
			});
      }
    }

	function viewfile(path){ 
	    window.open(path);
    }
    </script>

<!--************************************* Google Picker Code END ********************************************************-->

<?php
function get_file_extension($file_name){
		$dot_index = strrpos($file_name, '.');
		$file_type = substr($file_name, $dot_index + 1);
		return $file_type;
	}
	?>