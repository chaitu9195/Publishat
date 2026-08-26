	<div class="row">
	 <div class="left-heading col-md-6">
		<span class="hidden-xs pull-left">
			<i class="fa fa-graduation-cap fa-2x" aria-hidden="true"></i>
			<span class="h3">School +2 Records</span>
		</span>
		<span class="visible-xs pull-left">
		     <i class="fa fa-graduation-cap fa-2x" aria-hidden="true"></i>
	   		 <span class="h4">School +2 Records</span>
	    </span>
	</div>
	<div class="right-icons col-md-offset-1 pull-right" id="right_icons" style="display:block;">
	   <button class="btn btn-primary" href="#/newschool" title ="Add new record" onclick="getNew('1','academic')"> Add <i class="fa fa-plus-square" aria-hidden="true"></i> </button>

         </div>
	<div class="right-icons col-md-offset-2 col-md-4 pull-right" id="right_icons" style="display:none;">
	    <i class="fa fa-lock fa-2x" aria-hidden="true"></i>
	    <i class="fa fa-cart-plus fa-2x" aria-hidden="true"></i> | 
	    <i class="fa fa-file-o fa-2x" aria-hidden="true"></i>
	    <i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>
 	    <i class="fa fa-share-alt fa-2x" aria-hidden="true"></i>
 	    <i class="fa fa-trash fa-2x" aria-hidden="true"></i>
	 </div>

	 <table class="table table-responsive table-striped table-hover">
	     <thead>
	 		<th class='col-sm-3'> Class</th>
	 		<th class='col-sm-3'> School Name</th> 
	 		<th class='col-sm-2'> Document Type</th>
	 		<th class='col-sm-1'> File(s)</th>
	 		<th class="hidden-xs col-sm-2">Created / Modified</th>
                        <th  class='col-sm-1 hidden-xs'></th>
	     </thead>
	     <tbody>
                 <?php  for($i=0;$i<=count($data ?? array())-1;$i++){ ?>
                <tr onclick='displayView("1","<?=$data[$i]['RecordId'];?>","academic")' id='<?=$data[$i]["RecordId"];?>'>
                 <td><?=$data[$i]['Class'];?></td>
                 <td><?=$data[$i]['SchoolName'];?></td>
                 <td><?=$data[$i]['DocumentType']?></td>
                 <td><?=$count[$i]?></td>
                 <td class='hidden-xs'><?=$data[$i]['TS']?></td>
                 <td><span class="btn btn-info" id="share<?=$data[$i]['RecordId'];?>" style="display:none;padding:1px 10px;"> <span class='hidden-xs'>Share</span> <i class="fa fa-share" area-hidden='true' ></i></span></td>
                </tr>

	 	<?php } ?>	
	     </tbody>
	 </table>
	</div><!-- row end -->
<script type="text/javascript">
    $('#academic').addClass('active');
function displayView(mod_id,id,mod){
//alert(id);
$.ajax({
            type: "POST",
            url: "../web/displayView",
            data : {modid:mod_id,rid:id,module:mod},
            cache: false, 
            async: false,  
            success: function(data){                                        
               $('#body_content').html(data);
            }
        });
}
$('tr').hover(function(){
id = $(this).closest('tr').attr('id');
$('#share'+id).show();

});
$("tr").mouseleave(function(){
id = $(this).closest('tr').attr('id');
$('#share'+id).hide();
}); 
$(document).ready(function () {
/*
 $("tr").hover(function(){

$("#right_icons").show();
});
 $("tr").mouseleave(function(){
$("#right_icons").hide();
}); */
});
</script>
<style> 
tr:hover { cursor: pointer; font-weight:600;color: #466e90;}

</style>