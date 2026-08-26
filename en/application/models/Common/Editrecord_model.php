<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Editrecord_model extends CI_Model {
 
        /*
        Update records 
        -------------------------------------------*/
	function update_record($params){ 
                        $user_id = $this->session->userdata('user_id');
                        $addrelated = array();
                        $RecordTypeId = $params['record_type_id'];
									
			$label= $params['uploadedfile_tag'];
			$fileids = $params['fileids']; 
			$fileids = explode(",",$fileids);
			$RecordId = $params['RecordId'];
			unset($params['record_type_id']);
			unset($params['module']);
			unset($params['fileids']);
			unset($params['RecordId']);
			unset($params['parent_record_type_id']);
			unset($params['ParentRecordId']);
			$params = array_filter($params);
			//log_message("info", "params".json_encode($params));
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

			$this->mongodb->where(array("RecordTypeId"=>$RecordTypeId));
			$dbresult = $this->mongodb->get(TBL_RECORDTYPE);
			$RecordDetails = $dbresult;
			$params["TS"] = TimeStamp;
//			$this->db->where('RecordId', $RecordId);
            //print_r($params); die;
			$this->mongodb->set($params);
			
			$this->mongodb->where(array("RecordId"=>mongo_id($RecordId)));
			$result = $this->mongodb->update($RecordDetails[0]["DBTable"]);

			if($result){
				
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
							$this->mongodb->set(array("RecordId"=>mongo_id($RecordId), "UploadedFrom"=>"FTR", "DocumentId"=>mongo_id($file_id),"RecordTypeId"=>$RecordTypeId));
							$result = $this->mongodb->update("fs.files");
						}
					  }				 
                  	}				   
				}
				/*------------------------Move file from folder to record End ---------------------*/
				if($RecordTypeId == 14){
					$checkdupgrp = $this->db->query("SELECT * FROM ".TBL_GROUPNAMES." WHERE UserId = '$params[UserId]' AND GroupName = '$params[GroupName]' ");
					if($checkdupgrp->num_rows()==0){
						$insrtgrpname = $this->db->query("INSERT INTO ".TBL_GROUPNAMES." (UserId,GroupName) VALUES('$params[UserId]','$params[GroupName]') ");
					}
				}
				$eventdata = array("UserId"=>$user_id,
									   "EventType"=>'Modified',
									   "Module"=>$RecordDetails[0]['Module'],
									   "RecordName"=>$RecordName,
									   "RecordType"=>$RecordDetails[0]['RecordType'],
									   "DocumentType"=>$params['DocumentType'],
									   "Date"=>TimeStamp
									);
				$qry1 = $this->mongodb->insert(TBL_EVENTS, $eventdata);
				
				if(empty($addrelated)){
					
					return array("status"=>"success","data"=>"record updated successfully");
				}
				else{
					return array("status"=>"success","data"=>"record updated successfully","addrelated"=>"1","record_id"=>$RecordId);
				}
			}
			else{
				return array("data"=>"Updation Failed");
			}
		}//end of update record
		
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

}//end of class

/* End of file Editrecord_model.php.php */
/* Location: ./application/models/Common/Editrecord_model.php.php */