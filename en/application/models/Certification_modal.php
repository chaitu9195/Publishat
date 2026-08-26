<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certification_modal extends CI_Model {

	function uploadcertificate($params){
		$this->load->database();
		$user_id=$params['UserId'];
		$record_id = 0;
		$ValidFrom = date("Y-m-d");
		$tempdate = new DateTime($ValidFrom);
		$interval = new DateInterval('P1Y');
		$tempdate->add($interval);
		$ValidTo = $tempdate->format("Y-m-d"); // calculated date
		$CertificateNumber = uniqid();
		$inesrtqrycert = $this->db->query("INSERT INTO ".TBL_CERTIFICATION." (UserId,CertificationType,CertificateName,CertificateNumber,OrganisationName,Result,Grade,PercentageGrade,ChapterName,Address,Url,Username,Password,Notes,ValidFrom,ValidTo,DocumentType,CertificationStatus) VALUES('$params[UserId]','Health','NTR Blood Donation','$CertificateNumber','','','','','','','','','','','$ValidFrom','$ValidTo','Service','Active') ");
		if($inesrtqrycert){
			$record_id=$this->db->insert_id();
		}
		if($record_id==0){
			return array("status"=>"failed","data"=>"Something went wrong");
		}
		$label="";
		if(isset($params['upload_label'])){
			$label = $params['upload_label'];
		}
		$record_type_id = 5;
		$uploaded_filename='';
		$file_extension='';
		$validUser = $this->db->query("SELECT * FROM ".TBL_USER." WHERE UserId = $user_id");
		if($validUser->num_rows() > 0)
		{
			if(!empty($_FILES['uploadImage']['name']))
			{
				$file_extension = $this->get_file_extension();
				if($file_extension==''){
						return array("status"=>"failed","data"=>"Invalid File Type. Only PDF, DOC, DOCX, JPEG, JPG, GIF & PNG formats are allowed");
				}
				$uploaded_filename=$this->upload_thumbnail($params);
				if($uploaded_filename==''){
						return array("status"=>"failed","data"=>"File size is too high. Document should not be more than " .max_document_file_size_text);
				}
			}
			if(strlen($uploaded_filename) > 0)
			{
			$qry = $this->db->query("INSERT INTO ".TBL_DOCUMENTS." (RecordTypeId,RecordId,UserId,FileType,DocumentPath,Notes)	
					VALUES($record_type_id,$record_id,$user_id,'$file_extension','$uploaded_filename','$label')");
				if($qry)
				{
					return array("status"=>"success","data"=>'Document have been saved');
				}
				else{
					return array("status"=>"failed","data"=>'Please upload your Document');
				}
			}
			else{
				return array("status"=>"failed","data"=>"Please upload your Document");
			}
		}
		else{
			return array("status"=>"failed","data"=>"invalid user and record combination");
		}
	}

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
  		return $file_type;		
	}
	function upload_thumbnail($params) {
		$document = $_FILES["uploadImage"];
		$user_id = $params["UserId"];
		if($document["size"] > max_document_file_size)
		{
			return '';
		}
		else{
			$fileName = $_FILES["uploadImage"]["name"];
			$tmp_path = $_FILES['uploadImage']['tmp_name'];
			$ext = pathinfo($fileName, PATHINFO_EXTENSION);
			$document_folder = FCPATH."pwdocs/" . $user_id;		
			$createFolder = $this->create_folder($document_folder);
			$document_filename = date("YmdHis") . "-" .  str_replace(" ", "-", $fileName);
			$target_file_name = $document_folder . "/" . $document_filename;
			$db_document_filename = str_replace("../../..", "", $target_file_name);
			$moveResult = move_uploaded_file($tmp_path, $target_file_name);
			if ($moveResult == true) {
				return $db_document_filename;
			}
			else 
			{
				return '';
			}
		}
	}

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

/* End of file Certification_modal.php */
/* Location: ./application/models/Certification_modal.php */