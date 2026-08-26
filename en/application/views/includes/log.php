<div class="row">
   <div class="left-heading col-md-6 col-xs-8">
	<span class="hidden-xs pull-left">
	   <i class="fa fa-archive fa-2x" aria-hidden="true"></i>
	   <span class="h3">Activity Log</span>
	</span>
	<span class="visible-xs pull-left">
           <i class="fa fa-archive fa-2x" aria-hidden="true"></i>
	   <span class="h4">Activity Log</span>
	</span>
      </div>
      
</div>
<input type="hidden" name="page" id="page_num" value="1">
<div class="row">
<table  cellpadding="4" cellspacing="0" class="col-xs-12 col-md-10 col-md-offset-1 ">
                <tr>
                  <td><div></div>
                    <!--Tabs more Start-->
                    <ul id="myTab" class="nav nav-tabs">
                      <li id = "s_All" class="m_title active"><a class="h_title" id="All" >All</a></li>
                      <li id = "s_Created" class="m_title"><a class="h_title" id="Created">Created</a></li>
                      <li id = "s_Modified" class="m_title"><a class="h_title" id="Modified">Modified</a></li>
                      <li id = "s_Shared" class="m_title"><a class="h_title" id="Shared" >Shared</a></li>
                      <li id = "s_Deleted" class="m_title"><a class="h_title" id="Deleted">Deleted</a></li>
                    </ul>
                  </td>
                </tr>
              </table>
       </div>
       
<div class="row col-sm-10 col-sm-offset-1 col-xs-12 col-xs-offset-0">
  	<table class="table table-responsive table-stripped" id="log_data">
  		<thead>
  			<tr>
                          <?php  if($e_name != '' && $e_name == "All"){ ?>
  			   <th>Event Type</th>
                          <?php } ?>
  			   <th>Module</th>
			   <th>Record Type</th>	
		     	   <th>Record Name</th>
				    <?php 
					
					if($e_name == "Shared" || $e_name == "All"){?>
				   <th>Email</th>
					<?php } ?>
                           <th>Date</th>
		     	</tr>
  	        </thead>
  	        <tbody>
  	     <?php   foreach($data as $event) {
					$receiver = $event['Receiver'];
					$recid = $event['_id'];
					$rest = substr("$receiver", 0, 10);
					 $name_drivers = str_replace(",", "<br /><br/>", $receiver);
		 ?>
  	       		<tr>
                         <?php  if($e_name != '' && $e_name == "All"){ ?>
  	       		 <td><?=$event['EventType']?> </td>
                         <?php } ?>
  	       		 <td><?=$event['Module']?> </td>
  	       		 <td><?=$event['RecordType']?> </td>
                         <td><?=$event['RecordName']?> </td>
						 <?php 
					if($e_name == "Shared" || $e_name == "All"){?>
				   <td><span style="cursor:pointer;" data-toggle="modal" data-target="#emaillist<?=$recid;?>"><?=$rest;?>
				   <?php if(!empty($receiver)){?>...<?php } ?></span></td>
					<?php } ?>
									   <!-- Modal -->
  <div class="modal fade spacing" id="emaillist<?=$recid;?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <?php
		  echo $name_drivers;
		  ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  	       		 <td><?=$event['Date']?> </td>
  	       	       </tr>

				   
  	       <?php } ?>
  	      </tbody>  	
  	</table>
</div>
<script>
 $(document).ready(function(){
  $(".h_title").click(function(){ 
     var module = $(this).prop("id"); 
     getlog(module);
     $(".m_title").removeClass("active");
     $("#s_"+module).addClass("active"); 
 });

});	
	
function getlog_data(module,page){
   $.ajax({
                 type: 'get',
                 url: '../web/getlog',
                 data : {event:module,page:page},
                 cache: false, 
                 async: false,  
                 success: function(data){ 
				   var availableTags =  $.parseJSON(data);console.log(availableTags);
				   $.each(availableTags, function(idx, obj) {
					   var id = obj._id;
					   var receiver = obj.Receiver;
					   //str = str.replace(/,/gi, "\n").replace(/^,/,"");
					  //var numbers = receiver.replace(/,/g, '<br>'); alert(numbers);
					   var elist = "#emaillist"+id;
					   var epopup = "emaillist"+id;
					   //$('.e_list').attr('data-target',elist);
					   //$('.e_popup').attr('id',epopup);
					   if(obj.ename === "Shared" || obj.ename === "All") {
					var emails = "<td><span style='cursor:pointer;' class='e_list' data-toggle='modal' data-target='#emaillist"+ id +"'>" + obj.Receiver + "</span><div class='modal fade spacing e_popup' id='emaillist"+ id +"' role='dialog'><div class='modal-dialog'><div class='modal-content'><div class='modal-header'><button type='button' class='close' data-dismiss='modal'>&times;</button></div><div class='modal-body'>"+ obj.Receiver +"</div><div class='modal-footer'><button type='button' class='btn btn-default' data-dismiss='modal'>Close</button></div></div></div></div></td>";
						}
						if(obj.ename === "All") {
							var event_type = "<td>" + obj.EventType + "</td>";
						}

					   
							$('#log_data tbody').append("<tr>"+event_type+"<td>" + obj.Module + "</td><td>" + obj.RecordType + "</td><td>" + obj.RecordName + "</td>"+emails+"<td>" + obj.Date + "</td></tr>");
					});
                 }     
     });

}
</script>


<style>
.modal-content{
width: 552px;	
}
.spacing{
	margin: 86px;
    margin-left: 304px;
}
.h_title { width:100%; }
li.m_title { width:19% }
li.m_title:hover{ width:19% }
</style>
