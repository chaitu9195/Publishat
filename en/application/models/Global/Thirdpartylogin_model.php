<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Thirdpartylogin_model extends CI_Model {
   function google_oauth($email, $name, $gender){ 
		$ipaddress = $_SERVER["REMOTE_ADDR"];
		$joined_on = date("Y-m-d H:i:s");
        if($gender == "male" || $gender == "Male"){
            $gender = "Male";
        }
        else if($gender == "female" || $gender == "Female"){
            $gender = "Female";
        }
		$this->mongodb->where(array("Email"=>$email));
        $query = $this->mongodb->get(TBL_USER);
			if (count($query ?? array()) > 0){
				$user_id = $query[0]["UserId"]; 
				$name = $query[0]["Name"];
				$email = $query[0]["Email"];
				$address  = $query[0]["Address"];
				$Upgraded  = $query[0]["Upgraded"];
				$this->mongodb->where(array("UserId"=>mongo_id($user_id)));
				$data = $this->mongodb->get("UserLoginHistory");
				if(count($data ?? array())>0){
				$this->mongodb->where(array("UserId"=>mongo_id($user_id)));
				$this->mongodb->set(array("PrevLoginTime"=>$joined_on,"PrevIP"=>$ipaddress,"LatestLoginTime"=>$joined_on,"LatestIP"=>$ipaddress));
				$this->mongodb->update("UserLoginHistory");
				$date = date('Y-m-d');
				$this -> mongodb->where(array("Date"=>$date));
				$login = $this -> mongodb->get("login");
				$cnt = count($login ?? array());
				
					if(count($login ?? array()) == 0){
					$this -> mongodb->insert("login",array("Date"=>$date));
					}
				}
				else{
					$this -> mongodb->insert("UserLoginHistory",array("UserId"=>mongo_id($user_id),"PrevLoginTime"=>$joined_on, "InitialIP"=>$ipaddress, "PrevIP"=>$ipaddress, "LatestLoginTime"=>$joined_on,"LatestIP"=>$ipaddress));
				}
				$result = array("UserId"=>$user_id, "Name"=>$name, "Email"=>$email, "Address"=>$address, "Upgraded"=>$Upgraded);
				return array("status"=>"success","data"=>$result);
            }
            else{
                    $joined_on = date("Y-m-d H:i:s");
					$user_id = mongo_id();
					$user_details = array("_id" => $user_id,
													"UserId" => $user_id,
													"Name" => $name,
													"Email" => $email,
													"Gender" => $gender,
													"EmailVerified" => 'Y',
													"Status" => 'Active',
													"JoinedOn" => $joined_on,
													"UserLoginType" => '2',
													"FirstLogin" => '0',
													"Password" => '',
													"PhotoPath" => ''
													
									 );
									 
					$this->mongodb->insert(TBL_USER, $user_details);
                    $this->initialise_user_settings($user_id);
                    $result = array("UserId"=>$user_id, "Name"=>$name, "Email"=>$email);
					$this -> mongodb->insert("UserLoginHistory",array("UserId"=>mongo_id($user_id),"PrevLoginTime"=>$joined_on, "InitialIP"=>$ipaddress, "PrevIP"=>$ipaddress, "LatestLoginTime"=>$joined_on,"LatestIP"=>$ipaddress));
                    return array("status"=>"oauth","data"=>$result);
					
            } 
   }

function google_contacts($name, $email){
          $user_id = $this->session->userdata('user_id'); 
          $name =  str_replace("'","",$name);
		  $this->mongodb->where(array("UserId"=>mongo_id($user_id),"PersonalEmail"=>$email));
		  $qry = $this->mongodb->get(TBL_CONTACTS);
          if (count($qry ?? array()) == 0){
			  $mid = mongo_id();
			  $contacts = array(
						"UserId"=> mongo_id($user_id),
						"ContactName"=> $name,
						"ContactType"=> 'Google Contacts',
						"PersonalEmail"=> $email,
						"TS"=>TimeStamp,
						"RecordId"=>$mid
			  );
			 $this->mongodb->insert(TBL_CONTACTS,$contacts); 
          }
      
} 


function gpicker($params){
   $user_id = $this->session->userdata('user_id'); 
   $fileId = $params['file_id'];
   $oAuthToken = $params['token'];
   $file_name = $params['file_name'];
   $getUrl = 'https://www.googleapis.com/drive/v2/files/' . $fileId . '?alt=media';
   $authHeader = 'Authorization: Bearer ' . $oAuthToken ;


   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $getUrl);
   curl_setopt($ch, CURLOPT_HTTPHEADER, [
    $authHeader ,
  ]);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
  $data = curl_exec($ch);
  $error = curl_error($ch);
  curl_close($ch);

  $record_type_id = $params['recordtypeid'];
  $file_size = $params["file_size"];
  $fold_id = $params["foldid"];
  if(empty($fold_id)){
	  $fold_id = $params["foldid"];
  }
  else{
	  $fold_id = mongo_id($params["foldid"]);
  }
  $this->mongodb->where(array("id"=>$record_type_id));
  $qry = $this->mongodb->get("Folders");
  //$qry = $this->db->query("SELECT * FROM Folders Where id = '$record_type_id'");
  $rec = $qry[0];
   $folder_name = $rec["FolderName"];
     $document_folder = "../../fileupload/" . $user_id."/".$folder_name;
     $this->create_folder($document_folder);

          $target_file_name = $document_folder . "/" . date("YmdHis")."-".$file_name;
	  $file_extension = pathinfo($file_name,PATHINFO_EXTENSION);
          $file_extension = strtolower($file_extension);
          $db_document_filename = str_replace("../../", "", $target_file_name);
          $date = date("Y-m-d H:i:s");
  
   if(file_put_contents($target_file_name, $data)){
	   $file = array(
						"UserId"=> mongo_id($user_id),
						"RecordTypeId" => $record_type_id,
						"DocumentPath" => $db_document_filename,
						"FileType" => $file_extension,
						"length" => $file_size,
						"Type" => "File",
						"UploadedFrom" => "Folder",
						"ParentId" => $fold_id,
						"TS" => $date
			  );
			  $query = $this->mongodb->insert("fs.files",$file);
    
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
function initialise_user_settings($user_id){
	$this->mongodb->where(array("UserId"=>$user_id));
    $qry = TBL_ACCOUNTSETTINGS;
	$res = $this->mongodb->get($qry);
	
	if (count($res ?? array()) == 0){
		
		$sett = $this->mongodb->order_by(array('_id'=>'ASC'))->get('Settings');
		//$sett = $this->mongodb;
		
		foreach($sett as $setting){
		   $setting_id = $setting["SettingId"];
           $setting_value = $setting["InitialValue"];
           $payment_status = $setting["PaymentStatus"];
		   $module = $setting["Module"];
		   $setting_name = $setting["Setting"];
		   $record_type_id = $setting["RecordTypeId"];
		   $display_sequence = $setting["DisplaySequence"];
		   $ts = TimeStamp;
		   $mongo_id = mongo_id();
		   
 		   $acc_setting = array("_id"=>$mongo_id,
								"AccountSettingId"=>$mongo_id,
								"UserId"=>$user_id,
								"SettingId"=>$setting_id,
								"Setting"=>$setting_name,
								"SettingValue"=>$setting_value,
								"PaymentStatus"=>$payment_status,
								"Module"=>$module,
								"RecordTypeId"=>$record_type_id,
								"DisplaySequence"=>$display_sequence,
								"TS"=>$ts
		   );
		   $this->mongodb->insert(TBL_ACCOUNTSETTINGS, $acc_setting);
		}
		
	}
}
}