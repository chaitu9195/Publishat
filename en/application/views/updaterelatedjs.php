<script>
    $('#academic').removeClass('active');
    $('#professional').removeClass('active');
    $('#personal').removeClass('active');
    $('#health').removeClass('active');
    $('#financial').removeClass('active');
    $('#legal').removeClass('active');
	$('#<?=$moduleName;?>').addClass('active');

function pickCalender(id){
	$( "#"+id ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true,}).datepicker("show");
}
$("#documentForm").submit(function ( e ) {
    e.preventDefault();
	var ids = $('.required').map(function() {
        return $(this).attr('id');
    });
	for(var i = 0; i < ids.length; i++){
		var field = ids[i];
		var fieldvalue = $("#"+field).val();
		if(fieldvalue == "" || fieldvalue == undefined){
			$("#"+field).focus();
			$("#"+field).css({"border":"1px red solid","background":"#ffe6e5"});
			$("#error").show();
			var label = $("#"+field).closest("div").find("label").text();
			var fieldtype = $("#"+field).attr('type');
			var msg = label+" should not be blank";
			$("#msg").html(msg);
			return false;
		}
	}
	    $("#error").hide();
		$("input,select").css({"border":"1px solid #ccc","background":"#f9f9f9","box-shadow":"inset 0 1px 1px rgba(0,0,0,.075)","transition":"border-color ease-in-out .15s,box-shadow ease-in-out .15s"});
        $("#sub").hide();
        $("#load").html('Updating <i class="fa fa-spinner fa-spin"></i>');
		var ids = [];
        $.each($("input[name='fileids[]']:checked"), function(){   ids.push($(this).val());  });
		var data = new FormData(this);
		data.append('fileids',ids);
		    $.ajax({
				type: 'POST',
				url: '../web/updatedata',
				data: data,
				processData: false,
				contentType: false, 
				success: function (result) {   
				$("#load").html('Updated <i class="fa fa-check"></i>');
				$("#msg1").html("Successfully Updated. Redirecting <i class='fa fa-spinner fa-spin'></i>");
				$("#success").show();
			      setTimeout(function(){ sub_view('<?=$main_record_type_id;?>','<?=$record_type_id;?>','<?=$data['RecordId']?>','<?=$data['ParentRecordId']?>','<?=strtolower($moduleName);?>') },3000);
			      setTimeout(function(){ sub_view('<?=$main_record_type_id;?>','<?=$record_type_id;?>','<?=$data['RecordId']?>','<?=$data['ParentRecordId']?>','<?=strtolower($moduleName);?>') },3000);
				}
			});
		
});

function deleterecord(page_id,coming_from,rec_id,doc_id,main_page_id) {
 $.ajax({
        type: 'POST',
        url: '../related/deleteattachment',
        data: {page_refer_id:page_id,module:coming_from,rid:rec_id,docid:doc_id,main_page_id:main_page_id},
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


$('#view_file,.folder_img').click(function() {
	   var checkbox = $(this).closest('div').find('input[type=checkbox]');
   checkbox.prop("checked", !checkbox.prop("checked"));
    $(this).closest('div').toggleClass("folder_img_border");
        return false;
    }).dblclick(function() {
        var url = $(this).attr('href');
		window.open(url, '_blank');
        return false;
    });

$('#uploadFile').change(function(){ 
     //   var file = $(this).attr("id");
    //fileutils(file);
	var Upgraded = '<?=$Upgraded;?>';
   if($("#uploadFile").val() != "" && fileutils("uploadFile", Upgraded) != "success" ){ 
      fileutils("uploadFile", Upgraded); 
   } else {
       $("#error").hide();
       if($("#uploadFile").val()) {   
        $("#attachmentForm").ajaxSubmit({ 
   url: "../related/attachfiles",       
   beforeSubmit: function() {
    $("#progress-bar").width('0%');
   },
   uploadProgress: function (event, position, total, percentComplete){  
    $("#progress-bar").width(percentComplete + '%');
    $("#progress-bar").html('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:100%"> <span id="statusmsg">Uploaded Successfully(' + percentComplete+'%)</span></div></div>');
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

$("#hide_error").click(function(){
       $("#error").hide();
});

document.title="New Record | <?=$tabName;?> | <?=ucfirst($moduleName);?> | Publishat";
$('.doc_id').click(function(e){
	e.stopPropagation();
	
});
function viewfile(path){ 
	    window.open(path);
    }
</script>