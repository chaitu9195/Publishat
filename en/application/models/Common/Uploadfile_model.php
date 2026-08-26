<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploadfile_model extends CI_Model {
 
        /*
        Upload File (from edit mode )
        -------------------------------------------*/
	function upload_file($params){
            $user_id = $this->session->userdata('user_id');
			$record_id= $params['RecordId'];
			$RecordTypeId = $params['record_type_id']; 
			$label= $params['uploadedfile_tag'];
			$fileids = $params['fileids']; 
			$label="";
			if(isset($params['upload_label'])){
				$label = $params['upload_label'];
			}
			$record_type_id = $params['record_type_id'];

			$uploaded_filename='';
			$file_extension='';
                        if(!empty($_FILES['uploadImage']['name']))
			  {
			   $file_extension = $this->get_file_extension();
			   if($file_extension==''){
			     return array("data"=>"Invalid File Type. Only PDF, DOC, DOCX, JPEG, JPG, GIF & PNG formats are allowed");
			   }
                $uploaded_filename=$this->upload_thumbnail($params);
			   if($uploaded_filename==''){
			     return array("data"=>"File size is too high. Document should not be more than " .max_document_file_size_text);
                           }    
                        } 
                        if(strlen($uploaded_filename) > 0) {
							$mongo_connection = new MongoClient();
							$mid = mongo_id();
							$gridfs = $mongo_connection->selectDB('publisha_dbase')->getGridFS();
							if(strtolower($file_extension) == 'doc' || strtolower($file_extension) == 'docx'){
								$config['upload_path'] = FCPATH."files/temp";
								$config['allowed_types'] = '*';
								$config['file_name'] 	 = $uploaded_filename;
								$this->load->library('upload', $config);
								$this->upload->do_upload('uploadImage');
								$UploadFileInfo = $this->upload->data();
								
								$SourceFileName = $UploadFileInfo['file_name'];
								$TargetFolder 	= FCPATH."files/temp";
								$SourceFolder 	= FCPATH."files/temp";
								$CommandText 	= "libreoffice --headless --convert-to pdf  $SourceFolder/$SourceFileName  --outdir $TargetFolder";
								if(strtolower($file_extension) == 'doc'){
									$TargetFileName = str_replace(".doc", ".pdf", $SourceFileName);
								}
								if(strtolower($file_extension) == 'docx'){
									$TargetFileName = str_replace(".docx", ".pdf", $SourceFileName);
								}
								
								$Res = exec($CommandText, $output, $return_var);
								if(strpos($output[0], 'Error')){
									log_message("debug", "Conversion Error: ".$output[0]);
								} else {
									$file_extension = "pdf";
									$qry = $gridfs->put("$TargetFolder/$TargetFileName", array("_id"=>$mid, "DocumentId"=>$mid, "UserId"=>$user_id, "RecordId"=>mongo_id($record_id), "RecordTypeId"=>$RecordTypeId,"FileType"=>$file_extension, "Notes"=>$label));
									
									$Status = "SUCCESS";
									unlink($SourceFolder."/".$SourceFileName);
									unlink($SourceFolder."/".$TargetFileName);
								}
							} else {
								$qry = $gridfs->storeUpload('uploadImage', array("_id"=>$mid, "DocumentId"=>$mid, "UserId"=>$user_id, "RecordId"=>mongo_id($record_id), "RecordTypeId"=>$RecordTypeId,"FileType"=>$file_extension, "Notes"=>$label));
							}
							return array("data"=>'Success');
				} else{
					return array("data"=>"Please upload your Document");
				}				
                 
	}//end of upload file function

        /*
	Get the file extension
        -----------------------------------------*/
       function get_file_extension(){
		$document = $_FILES["uploadImage"]["name"];
  		$dot_index = strrpos($document, ".");
  		$file_type = substr($document, $dot_index + 1);
  		if($file_type == "pdf" || $file_type == "doc" || $file_type == "ppt" || $file_type == "xls" || $file_type == "txt" || $file_type == "pptx" || $file_type == "xlsx" || $file_type == "docx" || $file_type == "jpg" || $file_type == "JPG" || $file_type == "jpeg" || $file_type == "JPEG" || $file_type == "gif" || $file_type == "png" || $file_type == "" || $file_type == "PNG")
  		{
			return $file_type;
		}
		else{
			return '';
		}
  		//log_message('info','file type is');
  		//log_message('info',$file_type);
  		return $file_type;		
	}
/* Upload file into folder*/
      function upload_thumbnail($params) {
		$document = $_FILES["uploadImage"];
                 $user_id = $this->session->userdata('user_id');
				 $Upgraded = $this->session->userdata("Upgraded");
		if($Upgraded == "Y"){
			$db_document_filename = $_FILES["uploadImage"]["name"];
			$moveResult = true;
			if ($moveResult == true) {
				return $db_document_filename;
			}
		}
		if($document["size"] > max_document_file_size)
		{
			//log_message('info',$document["size"]);
			return '';
		}
		else{
			$db_document_filename = $_FILES["uploadImage"]["name"];
			$moveResult = true;
			if ($moveResult == true) {
				return $db_document_filename;
			}
			else 
			{
				return '';
			}
		}
	}
       /* Create folder if not available */
       function create_folder($path){
		$folder_name = strtolower($path); 
					 
		if (!is_dir($folder_name)) {   //if this folder doesn't exist	
			if (!mkdir($folder_name, 0755, true)) {
				die('Failed to create folder...' . $folder_name);
				return false;			
			}	
			else{
				return true;
			}					 				 	 
		}
	}

}

/* End of file Uploadfile_model.php */
/* Location: ./application/models/Common/Uploadfile_model.php */