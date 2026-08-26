<?php
$Upgraded = $this->session->userdata('Upgraded');
$record_type_id = $fields['data'][0]['RecordTypeId'];
$moduleName = strtolower($moduleName);
$modName = $moduleName;
if($moduleName == 'medical'){
	$moduleName = 'health';
}

?>
<div class="row">
   <div class="left-heading col-md-6">
    <span class="hidden-xs pull-left">
      <i class="fa fa-graduation-cap fa-2x" aria-hidden="true"></i>
      <span class="h3">Edit <?=$tabName;?> Record</span>
    </span>
    <span class="visible-xs pull-left">
         <i class="fa fa-graduation-cap fa-2x" aria-hidden="true"></i>
               <span class="h4">Edit <?=$tabName;?> Record</span>
      </span>
  </div>
    <div class="right-heading col-md-6">
           <a class="pull-right" href="#" onclick = "getVal('<?=$record_type_id;?>','<?=$modName;?>')"> Back </a>
        </div>
    </div>
<form class="form-horizontal" id="documentForm" name="documentForm" method="post" action=""  enctype="multipart/form-data">
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
 <input type="hidden" name="record_type_id" value="<?=$record_type_id;?>">
 <input type="hidden" name="RecordId" value="<?=$data['RecordId'];?>">
 <input type="hidden" name = 'module' value="<?=strtolower($moduleName);?>" >
<?php
foreach($fields['data'] as $field){
	//echo json_encode($field);
	$fieldType = $field['FieldType'];
	$isFeildMandatoty = $field['isFeildMandatoty'];
	$typeId = $field['RecordTypeId'];
	$fieldId = $field['Id'];
	$fieldName = $field['RequestParamenter'];
	if($isFeildMandatoty == 1){
		$isMandatory = 'required';
	}
	else{
		$isMandatory = '';
	}
	if($fieldType == 3 && $fieldId != '558'){ ?>
		<div class="col-md-6 field">
			<label class="col-sm-4 hidden-xs noheight"><?=$field['FieldLable'];?>
			   <?php if($isFeildMandatoty == '1'){ ?><i class="fa fa-asterisk star" aria-hidden="true"></i><?php } ?>
			</label>
			<select class="col-sm-8 col-xs-12 <?=$isMandatory;?>" name="<?=$fieldName;?>" id ="<?=$fieldName;?>">
				    <option value="">Select <?=$field['FieldLable'];?></option>
					<?php foreach($field['dropDownValues'] as $option){ ?>
						<option value='<?=$option['DropdownValues'];?>' <?=($option['DropdownValues'] == $data[$fieldName]) ? 'selected=selected' : '' ?>>
						   <?=$option['DropdownValues'];?>
						</option>
					<?php } ?>
				
			</select>
		</div>
	<?php }
	if($fieldType == 2 && $fieldId != '560'){ ?>
		<div class="col-md-6 field">
			<label class="col-sm-4 hidden-xs noheight">
			   <?=$field['FieldLable'];?>
			   <?php if($isFeildMandatoty == '1'){ ?><i class="fa fa-asterisk star" aria-hidden="true"></i><?php } ?>
			</label>
			<input type="text" class="col-sm-8 col-xs-12 <?=$isMandatory;?>" placeholder="Enter <?=$field['FieldLable'];?>" name="<?=$fieldName;?>" id ="<?=$fieldName;?>" value="<?=$data[$fieldName];?>">
		</div>
    <?php }
	if($fieldType == 5 || $fieldType == 11){ ?>
		<div class="col-md-6 field">
			<label class="col-sm-4 hidden-xs noheight">
			   <?=$field['FieldLable'];?>
			   <?php if($isFeildMandatoty == '1'){ ?><i class="fa fa-asterisk star" aria-hidden="true"></i><?php } ?>
			</label>
			<input type="text" class="col-sm-8 col-xs-12 timepicker <?=$isMandatory;?>" name="<?=$fieldName;?>" placeholder="YYYY-MM-DD"  id="<?=$fieldName;?>" onclick="pickCalender('<?=$fieldName;?>')" value="<?=$data[$fieldName];?>">
		</div>
    	
	<?php }
	if($fieldType == 8){ ?>
	    <div class="col-md-6 field">
			<label class="col-sm-4 hidden-xs noheight">
			   <?=$field['FieldLable'];?>
			   <?php if($isFeildMandatoty == '1'){ ?><i class="fa fa-asterisk star" aria-hidden="true"></i><?php } ?>
			</label>
			<select name="<?=$fieldName;?>" class="col-sm-8 col-xs-12 <?=$isMandatory;?>" id ="<?=$fieldName;?>">
                  <option value="">Select Year</option>
                  <?php for($d = date('Y');$d >= 1970;$d--){ ?>
                  <option <?=($d == $data[$fieldName]) ? 'selected=selected' : '' ?>><?=$d;?> </option>
                  <?php } ?>
            </select>
			
		</div>
	<?php }
    if($fieldType == 6){ ?>
	    
	        <div class='col-sm-6 field'>
				<label class="col-sm-4 hidden-xs"><?=$field['FieldLable'];?></label>
				<textarea class="col-sm-8 col-xs-12 <?=$isMandatory;?>" name="<?=$fieldName;?>" placeholder="Enter <?=$field['FieldLable'];?>" id ="<?=$fieldName;?>"><?=$data[$fieldName];?></textarea>
			</div>
    <?php }
	if($fieldType == 7){ ?>
		<div class='col-sm-6 field'>
		    <label class="col-sm-5 col-xs-12" style="padding-right: 0px"><a href="#" id ="addrelaetd"> <i class="fa fa-file"></i> <?=str_replace('#', '',$field['FieldLable']);?></a></label>
            <span class="col-sm-7 col-xs-12"> Related Records not yet added.</span>
		</div>
	
    <?php }
	}

?>
	<div class="row">
	        <span class="col-sm-6 col-xs-12 text-center pull-right">
				<button class="btn btn-success" type="submit" id="save"> <span id="sub">Submit</span> <span class="" id="load"></span></button> &nbsp; &nbsp;
				<input class="btn btn-danger" type="button" value="Cancel" id="reset" onclick='getVal("<?=$recTypeId;?>","<?=$moduleName;?>")'> 
            </span>
    </div>
</form>
	<div class="row attachments" >
               <div class="attach_left col-xs-12">
                <div class='attach_title'>  <span class="">Upload / Add New Document</span></div>
               <form class="form-horizontal attach_from" id="attachmentForm" name="attachmentForm" method="post" action=""  enctype="multipart/form-data">
                <input type="hidden" name="record_type_id" value="<?=$recTypeId;?>">
                <input type="hidden" name="RecordId" value="<?=$data['RecordId'];?>">
                <input type="hidden" name = 'module' value="<?=strtolower($moduleName);?>" >
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
                <?php if(count($files ?? [])) {
               for($i = 0;$i <= count($files ?? []) - 1; $i++){
                $doc_id = $files[$i]['DocumentId'];
                $label = $files[$i]['Notes'];
                $label = substr_replace($label ,'',-7);
                $path = $files[$i]['DocumentPath'];
                $filename = $files[$i]['filename'];
                if(empty($filename)){
                    $filename = basename($path);
					$filename = substr($filename, strpos($filename, '-') + 1);
                }
              $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
			  $f_name = basename($filename, $ext);
			  $file_name = substr($f_name, 0, 5);
			  ?>
           <div class="col-sm-8 col-xs-12 file_wrapper">
              
            <div class="col-sm-4 col-xs-4 ext_type"> 
              <?=get_icon($ext);?>
            </div>
            <div class='col-sm-8 col-xs-8 filename'> 
			<input type="hidden" name="fileids[]" id="fname" value="<?=$filename;?>">
             <span class="hidden-xs">
              <?=(!empty($file_name)) ? $file_name . '.' . $ext : ucfirst($file_name . '.' . $ext); ?>
             </span>                 
            </div> 
             <a href="./docviewer?fid=<?=$doc_id;?>&type=<?=strtolower($ext);?>&filename=<?=$f_name;?>&module=<?=$modName;?>&typeId=<?=$record_type_id;?>" target="_blank" class="downloadpop " ><i class="fa fa-download" ></i> </a>

             <a href="#/delete?module=&id=" class="downloadpop" onclick= "deleterecord('<?=$recTypeId;?>','<?=strtolower($moduleName);?>','<?=$files[$i]['RecordId']?>','<?=$files[$i]['DocumentId']?>')"><i class="fa fa-remove" ></i>          </a>
             </div> 
             <?php
               }//for close
             } else {  echo "<div class='file_nt_fnd'>Files not found</div>"; }
           ?>
              
                </div>
             </div>
  </div> 
  <div class="row"> &nbsp;
        <div id="progress-bar"></div>
    </div>
    <div class="row">
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
              <form name="folderForm" id="folderForm" method="POST" action"#">
				 <tbody id="searchable_data">
				<?php foreach((array) $folder as $file){
					 $doc_id = $file['_id'];
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
						if(in_array($type, $images ?? [])){
							if($path){
								$view_file = "<img src='https://publishat.com/$path' alt='$filename;' width='30px' height='30px'>";
							}
							else{
								$filesrc = base_url() . 'web/viewfile?fid=' . $id;
								$ch = curl_init();
								$timeout = 5;
								curl_setopt($ch, CURLOPT_URL, $filesrc);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
								$src = curl_exec($ch);
								curl_close($ch);
								$view_file = "<img src='data:image/jpg;base64," . base64_encode($src) . "' alt='$filename;' width='30px'>";
							}
						}
						else { $view_file = '<img src="../../../' . $not_image . '" id="img" class="img-responsive img imag" width="30px" height="30px" >'; }


					 $size = filesize_formatted($file['length']);
					 $date = date('d-M-Y', strtotime($file['TS']));

					 if(empty($filename)){
						//$filename = ucfirst(strtolower(substr(strstr(pathinfo($file['DocumentPath'], PATHINFO_FILENAME),"-"),1,20)));
						$doc_path = $file['DocumentPath'];
						$filename = basename($doc_path);
						$filename = end(explode('-',$filename));
					 }
					 $ext = pathinfo($filename, PATHINFO_EXTENSION);
					 $path = base_url() . 'web/viewfile?fid=' . $id;
					 ?>
					
					   <tr onClick="viewfile('docviewer?fid=<?=$file['_id'];?>&type=<?=strtolower($ext);?>')">
					<td>
					<input type="checkbox" name="fileids[]" class="doc_id" value="<?=$doc_id;?>" <? if(in_array($doc_id, $fileids ?? [])) { echo 'checked'; } ?>>
					<input type="hidden" name="filename[]" id="fname" value="<?=$filename;?>">
					
					</td>
						<td><?=$view_file?></td>
						<td><?php if($fol_type == 'File'){
								echo $filename;
							} else{
								echo $fol_name;
						}?></td>
						<td><?php if($fol_type == 'File'){ echo $type; } else{ echo '-'; }?></td>
						<td><?php if($fol_type == 'File'){ echo $size; } else{ echo '-'; }?></td>
						<td><?=$date?></td>
					</tr>
					
				<?php } ?>
				</tbody>
			</form>	      
	</table>
    </div>
	

<script type="text/javascript" src="../assets/js/form.min.js"></script>
   

<?php
   include('updatejs.php');
   include('UpgradeAccount.php');
?>

<style>
div.folder_img{
    height: 158px;
    padding: 7px;
	cursor:pointer;
    text-align: center;
	margin-top: 36px;
}
div.folder_img_border{
	border: 3px solid #9ca7c1;
	background-color: rgba(224, 221, 221, 0.47);
	cursor:pointer;
	padding: 13px;
}
.imag_icon{
	margin: 18px 0px 5px 121px;
}
.dialog_box{
    margin: 19% 10% 2% 30% !important;
	width: 31%;
}
.main_content{
	text-align:center;
}
.imag_icon {
    width: 75px;
}
</style>

<?php
function get_icon($ext){
               switch ($ext) {
                       case 'jpeg':
                             echo '<i class="fa fa-file-image-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case 'png':
                             echo '<i class="fa fa-file-image-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case 'jpg':
                             echo '<i class="fa fa-file-image-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case 'doc':
                             echo '<i class="fa fa-file-word-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case 'docx':
                             echo '<i class="fa fa-file-word-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case 'pdf':
                             echo '<i class="fa fa-file-pdf-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case 'xls':
                             echo '<i class="fa fa-file-excel-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case 'xlsx':
                             echo '<i class="fa fa-file-excel-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case 'ppt':
                             echo '<i class="fa fa-file-powerpoint-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case 'pptx':
                             echo '<i class="fa fa-file-powerpoint-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case 'txt':
                             echo '<i class="fa fa-file-text-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case 'zip':
                             echo '<i class="fa fa-file-archive-o fa-3x" aria-hidden="true"></i>';
                             break;
                       case 'rar':
                             echo '<i class="fa fa-file-archive-o fa-3x" aria-hidden="true"></i>';
                             break;
                      default:
                              echo '<i class="fa fa-file-file-o fa-3x" aria-hidden="true"></i>';
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
function get_file_extension($file_name){
		$dot_index = strrpos($file_name, '.');
		$file_type = substr($file_name, $dot_index + 1);
		return $file_type;
	}
function filesize_formatted($bytes)
{
    //$bytes = filesize($file);

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
?>

