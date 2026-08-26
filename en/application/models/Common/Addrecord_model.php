<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Addrecord_model extends CI_Model {
 
        /*
        Add records 
        -------------------------------------------*/
	function add_record($params){ 
	        //print_r($params);die;
            $user_id = $this->session->userdata('user_id');
            $params['UserId']=$user_id;
            $RecordTypeId = $params['record_type_id']; 
			$label= $params['uploadedfile_tag'];
			$fileids = $params['fileids'];
			            
	        //Removing variables from POST  array
			unset($params['record_type_id']);
			unset($params['uploadedfile_tag']);
			unset($params['fileids']);
			unset($params['filename']);
                      //Checking Files count
					  //log_message("info", "params insert".json_encode($params));
			$docArray = array();
			if(count($_FILES ?? array()) > 0){
				$docArray = $this->document_validation($user_id);
				if(isset($docArray["status"])){
					return $docArray;
				}
			}
            if($RecordTypeId == 1){
				$headers = array("key1" => "Class","key2" => "SchoolName","key3" => "DocumentType");
			}
			if($RecordTypeId == 2){
				$headers = array("key1" => "Degree","key2" => "Term","key3" => "DocumentType");
			}
			if($RecordTypeId == 3){
				$headers = array("key1" => "Degree","key2" => "Term","key3" => "DocumentType");
			}
			if($RecordTypeId == 4){
				$headers = array("key1" => "Degree","key2" => "Term","key3" => "DocumentType");
			}
			if($RecordTypeId == 5){
				$headers = array("key1" => "CertificationType","key2" => "CertificateName","key3" => "ValidFrom");
			}
			if($RecordTypeId == 6){
				$headers = array("key1" => "ExamType","key2" => "ExamName","key3" => "DocumentType");
			}
			if($RecordTypeId == 7){
				$headers = array("key1" => "ProjectType","key2" => "Title","key3" => "DocumentType");
			}
			if($RecordTypeId == 8){
				$headers = array("key1" => "Location","key2" => "Purpose","key3" => "FromDate");
			}
			if($RecordTypeId == 9){
				$headers = array("key1" => "DocumentType","key2" => "IssuedDate","key3" => "ReferenceNo");
			}
			if($RecordTypeId == 10){
				$headers = array("key1" => "Name","key2" => "RelationshipType","key3" => "ContactMode");
			}
			if($RecordTypeId == 11){
				$headers = array("key1" => "SiteName","key2" => "Usage","key3" => "DocumentStatus");
			}
			if($RecordTypeId == 12){
				$headers = array("key1" => "TravelType","key2" => "FromDate","key3" => "ToPlace");
			}
			if($RecordTypeId == 13){
				$headers = array("key1" => "DeviceName","key2" => "Brand","key3" => "ReferenceNumber");
			}
			if($RecordTypeId == 14){
				$headers = array("key1" => "ContactName","key2" => "MobileNumber","key3" => "PersonalEmail");
			}
			if($RecordTypeId == 15){
				$headers = array("key1" => "DocumentType","key2" => "OrganisationName","key3" => "IssuedDate");
			}
			if($RecordTypeId == 16){
				$headers = array("key1" => "ProjectName","key2" => "FromDate","key3" => "ToDate");
			}
			if($RecordTypeId == 17){
				$headers = array("key1" => "SkillType","key2" => "SkillName","key3" => "DocumentType");
			}
			if($RecordTypeId == 18){
				$headers = array("key1" => "AppType","key2" => "AppName","key3" => "PasswordChangeStatus");
			}
			if($RecordTypeId == 38){
				$headers = array("key1" => "ResumeType","key2" => "Name","key3" => "FunctionalArea");
			}
			if($RecordTypeId == 19){
				$addrelated = array("addrelated"=>1);
				$headers = array("key1" => "TestName","key2" => "TestType","key3" => "TestDate");
			}
			if($RecordTypeId == 20){
				$addrelated = array("addrelated"=>1);
				$headers = array("key1" => "PrescriptionType","key2" => "DiseaseName","key3" => "MedicineType");
			}
			if($RecordTypeId == 21){
				$addrelated = array("addrelated"=>1);
				$headers = array("key1" => "DiseaseType","key2" => "TreatmentType","key3" => "FromDate");
			}
			if($RecordTypeId == 22){
				$addrelated = array("addrelated"=>1);
				$headers = array("key1" => "PolicyType","key2" => "PolicyName","key3" => "FromDate");
			}
			if($RecordTypeId == 28){
				$headers = array("key1" => "DisputeType","key2" => "PartyName","key3" => "FromDate");
			}
			if($RecordTypeId == 29){
				$headers = array("key1" => "TransferType","key2" => "AssetName","key3" => "ValidFrom");
			}
			if($RecordTypeId == 30){
				$headers = array("key1" => "AccountType","key2" => "AccountNumber","key3" => "BranchName");
			}
			if($RecordTypeId == 31){
				$headers = array("key1" => "AssetType","key2" => "AssetName","key3" => "ValidFrom");
			}
			if($RecordTypeId == 32){
				$addrelated = array("addrelated"=>1);
				$headers = array("key1" => "RevenueType","key2" => "ItemName","key3" => "Term");
			}
			if($RecordTypeId == 33){
				$headers = array("key1" => "CardType","key2" => "ServiceProviderName","key3" => "CardNumber");
			}
			if($RecordTypeId == 34){
				$headers = array("key1" => "LiabilityType","key2" => "LiabilityName","key3" => "FromDate");
			}
			if($RecordTypeId == 35){
				$addrelated = array("addrelated"=>1);
				$headers = array("key1" => "PaymentType","key2" => "ItemName","key3" => "Term");
			}
			if($RecordTypeId == 36){
				$headers = array("key1" => "TaxDocumentType","key2" => "Date","key3" => "AssessmentYear");
			}
			if($RecordTypeId == 37){
				$headers = array("key1" => "InsuranceType","key2" => "PolicyName","key3" => "FromDate");
			}

			$recordNames = $headers["key1"];
			$RecordName = $params[$recordNames];

            //Getting Table name from table using RecordYypeID
			$this->mongodb->where(array("RecordTypeId"=>$RecordTypeId));
			$dbtable = TBL_RECORDTYPE;
			$dbresult = $this->mongodb->get($dbtable);
			$RecordDetails = $dbresult;
			$mongoid = mongo_id();
            $params["_id"] = $mongoid;
			$params["RecordId"] = $mongoid;
			$params["TS"] = TimeStamp;
			$params = array_filter($params);
            //Inserting data into table
			$result = $this->mongodb->insert($RecordDetails[0]["DBTable"],$params);
		 	if($result){
				$record_id = $mongoid;  //log_message("info",$record_id);
				
				//$user_id = $params['UserId'];
				
				/*
				Move file from folder to record Start
				---------------------------------------------------------------------*/
				if(count($fileids ?? array()) > 0){
				    for($i = 0; $i < count($fileids ?? array()); $i++){
						$file_id = $fileids[$i];
					 if($file_id != ''){
                        $this->mongodb->where(array("_id"=>mongo_id($file_id), "UserId"=>mongo_id($user_id)));						 
						$file_qry = $this->mongodb->get("fs.files");
						if(count($file_qry ?? array())> 0){
						    $this->mongodb->where(array("_id"=>mongo_id($file_id)));
							$this->mongodb->set(array("RecordId"=>mongo_id($record_id), "UploadedFrom"=>"FTR", "DocumentId"=>mongo_id($file_id)));
							$result = $this->mongodb->update("fs.files");
							$this->mongodb->where(array("_id"=>mongo_id($file_id)));
						}
					  }				 
                  	}				   
				}
				/*------------------------Move file from folder to record End ---------------------*/
				if(count($docArray ?? array()) > 0){ 
				    $file_extension = strtolower($docArray['ext']);
					$mongo_connection = new MongoClient();
					$mid = mongo_id();
					$gridfs = $mongo_connection->selectDB('publisha_dbase')->getGridFS();
					$gridfs->storeUpload('uploadImage', array("_id"=>$mid, "DocumentId"=>$mid, "UserId"=>$user_id, "RecordId"=>$record_id, "RecordTypeId"=>$RecordTypeId,"FileType"=>$file_extension, "Notes"=>$label));
				}
                             
                    $eventdata = array("UserId"=>$user_id,
									   "EventType"=>'Created',
									   "Module"=>$RecordDetails[0]['Module'],
									   "RecordName"=>$RecordName,
									   "RecordType"=>$RecordDetails[0]['RecordType'],
									   "DocumentType"=>$params['DocumentType'],
									   "Date"=>TimeStamp
									);
					
					$qry1 = $this->mongodb->insert(TBL_EVENTS, $eventdata);
								
        	   return array("status"=>"success","rid"=>$record_id);                                				
		} 
		else{
			return array("status"=>"failed","data"=>"invalid post parameters");
		}
           
	}
        
        /* 
        add related
        ------------------------------------ */
	function add_sub_record($params){ 
	        $user_id = $this->session->userdata('user_id');
            $params['UserId']=$user_id;
            // storing the hidden variable data into varibles for further use
			$RecordTypeId = $params['record_type_id'];
			$label= $params['uploadedfile_tag'];
			$fileids = $params['fileids'];
			$params["ParentRecordId"] = mongo_id($params["ParentRecordId"]);
	              //Removing variables from POST  array
			unset($params['record_type_id']);
			unset($params['uploadedfile_tag']);
			unset($params['fileids']);
                      //Checking Files count
			$docArray = array();
			if(count($_FILES ?? array()) > 0){
				$docArray = $this->document_validation($user_id);
				if(isset($docArray["status"])){
					return $docArray;
				}
			}

            //Getting Table name from table using RecordYypeID
			$this->mongodb->where(array("RecordTypeId"=>$RecordTypeId));
			$dbtable = TBL_RECORDTYPE;
			$dbresult = $this->mongodb->get($dbtable);
			$RecordDetails = $dbresult;
            $mongoid = mongo_id();
            $params["_id"] = $mongoid;
            $params["RecordId"] = $mongoid; 
			$params["TS"] = TimeStamp;
            $params = array_filter($params);
			//Inserting data into table
			$result = $this->mongodb->insert($RecordDetails[0]["DBTable"],$params);
		 	if($result){
				 $record_id = $mongoid; 
				
				if($RecordTypeId==41){
					$this->mongodb->where(array("RecordId"=>mongo_id($params['ParentRecordId']), "UserId"=> mongo_id($params['UserId'])));
					$totalamntqry = $this->mongodb->get(TBL_FINREVENUE);
					$totalamount = $totalamntqry; 
					$amount = $totalamount[0]["Amount"]; 
					$subamount = $params["Amount"];
					$total = $amount+$subamount; 
					$this->mongodb->where(array("RecordId"=>mongo_id($params['ParentRecordId']), "UserId"=> mongo_id($params['UserId'])));
					$this->mongodb->set(array("Amount"=>$total));
					$this->mongodb->update(TBL_FINREVENUE);
				}
				if($RecordTypeId==39){
					$this->mongodb->where(array("RecordId"=>mongo_id($params['ParentRecordId']), "UserId"=> mongo_id($params['UserId'])));
					$totalamntqry = $this->mongodb->get(TBL_FINPAYMENT);
					$totalamount = $totalamntqry; 
					$amount = $totalamount[0]["Amount"]; 
					$subamount = $params["Amount"];
					$total = $amount+$subamount;
					$this->mongodb->where(array("RecordId"=>mongo_id($params['ParentRecordId']), "UserId"=> mongo_id($params['UserId'])));
					$this->mongodb->set(array("Amount"=>$total));
					$this->mongodb->update(TBL_FINPAYMENT);
				}
                                //log_message("info",$record_id);
				//$user_id = $params['UserId'];
								/*
				Move file from folder to record Start
				---------------------------------------------------------------------*/
				if(count($fileids ?? array()) > 0){
				    for($i = 0; $i < count($fileids ?? array()); $i++){
						$file_id = $fileids[$i];
					  if($file_id != ''){	
						$this->mongodb->where(array("_id"=>mongo_id($file_id), "UserId"=>mongo_id($user_id)));						 
						$file_qry = $this->mongodb->get("fs.files");
						if(count($file_qry ?? array())> 0){
						    $this->mongodb->where(array("_id"=>mongo_id($file_id)));
							$this->mongodb->set(array("RecordId"=>mongo_id($record_id), "UploadedFrom"=>"FTR", "DocumentId"=>mongo_id($file_id),"RecordTypeId"=>$RecordTypeId));
							$result = $this->mongodb->update("fs.files");
						}			 
					  }					 
                  	}				   
				}
				/*------------------------Move file from folder to record End ---------------------*/
				if(count($docArray ?? array()) > 0){
				   $file_extension = strtolower($docArray['ext']);
					$mongo_connection = new MongoClient();
					$mid = mongo_id();
					$gridfs = $mongo_connection->selectDB('publisha_dbase')->getGridFS();
					$gridfs->storeUpload('uploadImage', array("_id"=>$mid, "DocumentId"=>$mid, "UserId"=>$user_id, "RecordId"=>$record_id, "RecordTypeId"=>$RecordTypeId,"FileType"=>$file_extension, "Notes"=>$label));
				}
        	return array("status"=>"success","rid"=>$record_id);                                				
		} 
		else{
			return array("status"=>"failed","data"=>"invalid post parameters");
		}
           
	}
	
	/*
        Validate document
	---------------------------------------*/ 
	function document_validation($user_id){
		$docs = array();
		if(!empty($_FILES['uploadImage']['name'])){
			//log_message('info',$_FILES['uploadImage']['name']);
		
			$file_extension = $this->get_file_extension();
			if(!$file_extension){
		      return array("status"=>"failed","data"=>"Invalid File Type. Only PDF, DOC, DOCX, JPEG, JPG, GIF & PNG formats are allowed");
			}
			$uploaded_filename=$this->upload_thumbnail($user_id);
			if(!$uploaded_filename){
				return array("status"=>"failed","data"=>"File size is too high. Document should not be more than " .max_document_file_size_text);
			}
			$docs = array("ext"=>$file_extension,"filename"=>$uploaded_filename);
		}
		return $docs;
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
			return false;
		}
  		//log_message('info','file type is');
  		//log_message('info',$file_type);
  		return $file_type;		
  	}
	function upload_thumbnail($user_id) {
		$document = $_FILES["uploadImage"];
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
			return false;
		}
		else{
			$db_document_filename = $_FILES["uploadImage"]["name"];
			$moveResult = true;
			if ($moveResult == true) {
				return $db_document_filename;
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

	function validation_check($params){
		foreach ($params as $key => $value) {
			if(empty($value)){
				return false;
			}
		}
		return true;
	}

}

/* End of file Addrecord_model.php */
/* Location: ./application/models/Common/Addrecord_model.php */