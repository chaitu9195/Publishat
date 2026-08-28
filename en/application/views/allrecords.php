<?php

$data = isset($data) && is_array($data) ? $data : [];
$shared_result =
    isset($shared_result) && is_array($shared_result) ? $shared_result : [];
$constants = get_defined_constants();
$headers = json_decode($constants[$tableName], true);
$key1 = $headers['headers']['key1'];
$key2 = $headers['headers']['key2'];
$key3 = $headers['headers']['key3'];

if (strtolower($moduleName) == 'medical') {
    $modName = 'health';
} else {
    $modName = strtolower($moduleName);
}
if ($recTypeId == 19) {
    $sub_record_type_id = 23;
}
if ($recTypeId == 20) {
    $sub_record_type_id = 24;
}
if ($recTypeId == 21) {
    $sub_record_type_id = 26;
}
if ($recTypeId == 22) {
    $sub_record_type_id = 27;
}
if ($recTypeId == 32) {
    $sub_record_type_id = 41;
}
if ($recTypeId == 35) {
    $sub_record_type_id = 39;
}
if ($recTypeId == 16) {
    $sub_record_type_id = 45;
}
?>
<input type="hidden" name="page" id="page_num" value="1">
<input type="hidden" name="rec_id" id="rec_id" value="<?= $recTypeId ?>">
<input type="hidden" name="mod_name" id="mod_name" value="<?= strtolower(
    $moduleName,
) ?>">
	<div class="row">
	 <div class="left-heading col-md-4 col-xs-6">
		<span class="hidden-xs pull-left">
			<i class="fa fa-graduation-cap fa-2x" aria-hidden="true"></i>
			<span class="h3"><?= $tabName ?> Records</span>
		</span>
		<span class="visible-xs pull-left">
		     <i class="fa fa-graduation-cap fa-2x" aria-hidden="true"></i>
	   		 <span class="h4"><?= $tabName ?> Records</span>
	    </span>
	</div>
	<div class="right-icons col-md-4 col-xs-6" id="right_icons" style="display:block;">
	<?php if ($recTypeId == 14) { ?>
         <div class="pull-left">
			<a href="https://accounts.google.com/o/oauth2/auth?client_id=298801891056-boiv3nlutpsqfdurfidvd9aktsiaditb.apps.googleusercontent.com&redirect_uri=https://www.publishat.com/digital/en/Thirdparty/gcontacts&scope=https://www.google.com/m8/feeds/&response_type=code"><span class="h5 hidden-xs"> Syncronize Google Contacts </span> <img src="../../../images/g+icon.png" alt="" id="signimg" style="width:25px;"/></a>
         </div>
	<?php } ?>
    </div>
    <div class="col-sm-3 col-xs-9"><input type="text" class="form-control pull-right" id="filter_table" placeholder="Filter Here ...."></div>        
	<div class="pull-right">  
	   <button class="btn btn-primary" href="#/newschool" title ="Add new record" onclick="getNew('<?= $recTypeId ?>','<?= $moduleName ?>')"> Add <i class="fa fa-plus-square" aria-hidden="true"></i></button>
    </div>
         
	<div class="right-icons col-md-offset-2 col-md-4 pull-right" id="right_icons" style="display:none;">
	    <i class="fa fa-lock fa-2x" aria-hidden="true"></i>
	    <i class="fa fa-cart-plus fa-2x" aria-hidden="true"></i> | 
	    <i class="fa fa-file-o fa-2x" aria-hidden="true"></i>
	    <i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>
 	    <i class="fa fa-share-alt fa-2x" aria-hidden="true"></i>
 	    <i class="fa fa-trash fa-2x" aria-hidden="true"></i>
	 </div>

	 <table class="table table-responsive table-striped table-hover" id="table_data">
	     <thead>
	 		<th class='col-sm-3'> <?= $key1 ?></th>
	 		<th class='col-sm-3'> <?= $key2 ?></th> 
	 		<th class='col-sm-2'> <?= $key3 ?></th>
	 		<th class='col-sm-1'> File(s)</th>
	 		<th class="hidden-xs col-sm-2">Created / Modified</th>
                        <!--<th  class='col-sm-1 hidden-xs'></th>-->
	     </thead>
	     <tbody id="searchable_data"> 
                 <?php for ($i = 0; $i <= safe_count($data ?? []) - 1; $i++) { ?>
                <tr onclick='displayView("<?= $recTypeId ?>","<?= $data[$i][
    'RecordId'
] ?>","<?= strtolower(
    $moduleName,
) ?>","<?= $sub_record_type_id ?>")' id='<?= $data[$i]['RecordId'] ?>'>
                 <td><?= $data[$i][$key1] ?></td>
                 <td><?= $data[$i][$key2] ?></td>
                 <td><?= $data[$i][$key3] ?></td>
                 <td><?= $count[$i] ?></td>
                 <td class='hidden-xs'><?= $data[$i]['TS'] ?></td>
                 <!--<td><span class="btn btn-info" id="share<?= $data[$i][
                     'RecordId'
                 ] ?>" style="display:none;padding:1px 10px;"> <span class='hidden-xs'>Share</span> <i class="fa fa-share" area-hidden='true' ></i></span></td>-->
                </tr>

	 	<?php } ?>	
	     </tbody>
	 </table>
	 <?php if (safe_count($shared_result ?? []) > 0 && $recTypeId == 16) { ?>
<div class="col-sm-12 collaboration"><span>Collaboration Data</span></div>
	  <table class="table table-responsive table-striped table-hover">
	     <thead>
                  <th class='col-sm-3'> <?= $key1 ?></th>
                  <th class='col-sm-3'> <?= $key2 ?></th>
                  <th class='col-sm-2'> <?= $key3 ?></th>
                  <th class='col-sm-1'> File(s)</th>
                  <th class="hidden-xs col-sm-2">Created / Modified</th>
                  <!--<th  class='col-sm-1 hidden-xs'></th>-->
	    </thead>
	     <tbody id="searchable_data">
                 <?php for (
                     $i = 0;
                     $i <= safe_count($shared_result ?? []) - 1;
                     $i++
                 ) { ?>
				 <tr onclick='displayView("<?= $recTypeId ?>","<?= $shared_result[$i][
    'RecordId'
] ?>","<?= strtolower(
    $moduleName,
) ?>","<?= $sub_record_type_id ?>")' id='<?= $shared_result[$i]['RecordId'] ?>'>
                 <td><?= $shared_result[$i][$key1] ?></td>
                 <td><?= $shared_result[$i][$key2] ?> </td>
                 <td><?= $shared_result[$i][$key3] ?></td>
                 <td><?= $col_file_cnt[$i] ?></td>
                 <td class='hidden-xs'><?= $shared_result[$i]['TS'] ?></td>
                 <!--<td><span class="btn btn-info" id="share<?= $shared_result[
                     $i
                 ][
                     'RecordId'
                 ] ?>" style="display:none;padding:1px 10px;"> <span class='hidden-xs'>Share</span> <i class="fa fa-share" area-hidden='true' ></i></span></td>-->
               </tr>

	 	<?php } ?>	
	     </tbody>
	 </table>
	 <?php } ?>
	</div><!-- row end -->
	<div class="ajax-load text-center" style="display:none">

	<p><img src="../assets/images/loader.gif">Loading More</p>

</div>
<script type="text/javascript">
	$('#personal').removeClass('active');
    $('#academic').removeClass('active');
    $('#professional').removeClass('active');
    $('#health').removeClass('active');
    $('#financial').removeClass('active');
    $('#legal').removeClass('active');
	$('#<?= $modName ?>').addClass('active');
    document.title = "<?= $tabName ?> Records | <?= ucfirst(
     $modName,
 ) ?> | Publishat";

$('tr').hover(function(){
id = $(this).closest('tr').attr('id');
$('#share'+id).show();

});
$("tr").mouseleave(function(){
id = $(this).closest('tr').attr('id');
$('#share'+id).hide();
}); 
$(document).ready(function () {
$("#count1,#mcount1").html("(<?= safe_count($data ?? []) ?>)");
    (function ($) {

        $('#filter_table').keyup(function () {
            var rex = new RegExp($(this).val(), 'i');
            $('#searchable_data tr').hide();
            
            $('#searchable_data tr').filter(function () {
                return rex.test($(this).text());
            }).show();
        });


    }(jQuery));
/*
 $("tr").hover(function(){

$("#right_icons").show();
});
 $("tr").mouseleave(function(){
$("#right_icons").hide();
}); */

});

function getVals(id,mod,page){ 
        if(!parseInt(page)){
			return false;
		}
		var fetchCount = ((page*<?= recordsPerPage ?>)-<?= recordsPerPage ?>);
		var totalRecords = $("#recordTypeId"+id).val();
		if(!(totalRecords > fetchCount)){
			return false;
		}
        $.ajax({
            type: "get",
            data: {module:mod,mod_id:id,page:page},
            url: "../web/moduledata", 
            cache: false, 
            async: false,  
              beforeSend: function() {    
            $('.ajax-load').show();
             },
            success: function(data){ 
	            $('.ajax-load').hide();
              
              //$('#result').append(data);
			  
			  var availableTags =  $.parseJSON(data);
				   $.each(availableTags, function(idx, obj) {
					   var value1 = obj.<?= $key1 ?>;
					   var value2 = obj.<?= $key2 ?>;
					   var value3 = obj.<?= $key3 ?>;
					   if(value3 === undefined) {
						   var value3 = "<td></td>";
					   }
					   else{
						   var value3 = "<td>" + value3 + "</td>";
					   }
					   var value4 = obj.count;
					   var value5 = obj.TS;
					   var value6 = obj.RecordId;
					  $('#table_data tbody').append("<tr id='"+ value6 +"' onclick=displayView('<?= $recTypeId ?>','"+ value6 +"','<?= strtolower(
    $moduleName,
) ?>','<?= $sub_record_type_id ?>')><td>"+ value1 +"</td><td>" + value2 + "</td>" + value3 + "<td>" + value4 + "</td><td>"+ value5 +"</td></tr>"); 
					});
					var qstring = "?page_id="+id+"&module="+mod;
              if(history.replaceState) history.replaceState({}, "", "records"+qstring);
			  
            }
        });
  }
</script>
<style> 
tr:hover { cursor: pointer; font-weight:600;color: #466e90;}
.collaboration{
	text-align: center;
	border: 1px solid #eae7e7;
    padding: 10px;
    font-size: 20px;
    font-weight: 700;
    color: steelblue;
}
</style>