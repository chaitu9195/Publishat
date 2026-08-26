<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	function get_contactsdata(){
		$this->load->database();
		$useridsqry = $this->db->query("SELECT UserId FROM ".TBL_USER_VENDOR." WHERE VendorId = '2' ");
		if($useridsqry->num_rows() > 0){
			$tempArr;
			foreach ($useridsqry->result_array() as $singleUserId) {
				$contctsrecqry = $this->db->query("SELECT UserId,ContactName,ContactType,TS as CreatedDate FROM ".TBL_CONTACTS." WHERE UserId = '$singleUserId[UserId]' ");
				if($contctsrecqry->num_rows() > 0){
					foreach ($contctsrecqry->result_array() as $singleContact) {
						$tempArr[] = $singleContact;
					}
				}
                               $user_vendor = $this->session->userdata('user_id');
   $contctsrecqry = $this->db->query("SELECT * FROM ".TBL_CLIENTCONTACTS." WHERE OrgId = '$user_vendor' AND Email !='' AND Email = '$user_table_email'");
				if($contctsrecqry->num_rows() > 0){
					foreach ($contctsrecqry->result_array() as $singleContact1) {
                                                $tempArr1[] = $singleContact1;
					
				}
			    }
			}

			if (count($tempArr ?? array()) > 0) {
				return array("status"=>"success","data"=>$tempArr,"data1"=>$tempArr1);
			}
			else{
				return array("status"=>"failed","data"=>"No data available","data1"=>$tempArr1);
			}
		}else{
			return array("status"=>"failed","data"=>"No users available");
		}		
	}

	function checkuservendorrelation($params){
		$this->load->database();
		$vendorname = VendorName;
		$getvendorqry = $this->db->query("SELECT VendorId FROM ".TBL_VENDORS." WHERE VendorName = '$vendorname' ");
		if($getvendorqry->num_rows() > 0){
			$vendordtls = $getvendorqry->row_array();
			$checkuserrelqry = $this->db->query("SELECT * FROM ".TBL_USER_VENDOR." WHERE UserId = '$params' AND VendorId = '$vendordtls[VendorId]' ");
			if($checkuserrelqry->num_rows() == 0){
				$relateuservendor = $this->db->query("INSERT INTO ".TBL_USER_VENDOR." (UserId,VendorId) VALUES ('$params','$vendordtls[VendorId]') ");
			}
		}
	}

	function readexcel($params){
		//$selectedexcel = $_FILES["UploadExcel"]["tmp_name"];
		$file = $_FILES["UploadedExcel"]["tmp_name"];
		//load the excel library
		$this->load->library('excel');
		//read file from path
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		//get only the Cell Collection (PhpSpreadsheet: getCoordinates() returns the
		//array of coordinate strings that old PHPExcel's getCellCollection() returned)
		$cell_collection = $objPHPExcel->getActiveSheet()->getCoordinates();
		//extract to a PHP readable array format
		foreach ($cell_collection as $cell) {
		    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
		    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
		    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
		    //header will/should be in row 1 only. of course this can be modified to suit your need.
		    if ($row == 1) {
		        $header[$column] = $data_value;
		    } else {
		        $arr_data[$row][$column] = $data_value;
		    }
		}
		//send the data in an array format
		$data['header'] = $header;
		$data['values'] = array_values($arr_data ?? array());
		$finallarr = array();
		foreach ($data['values'] as $singlerow) {
			foreach ($singlerow as $rkey => $rvalue) {
				foreach ($header as $hkey => $hvalue) {
					if (in_array($hkey, array_keys($singlerow))) {
						if($hkey === $rkey){
							$temparr[$hvalue] = $rvalue;
						}
					}else{
						$temparr[$hvalue] = '';
					}
					
				}
			}
			$finallarr[] = $temparr;
			$temparr='';
		}
		return $finallarr;		
	}
	function useremail(){ 
		$user_id = $this->session->userdata('user_id');
		$this->mongodb->where(array("UserId"=>mongo_id($user_id)));
		$qury = $this->mongodb->get("events");
		foreach($qury as $result){
			   $emailadd = $result['Receiver']; 
			   $email_id_arr = explode(",", $emailadd);
			   for($i=0; $i<count($email_id_arr ?? array()); $i++){
			   	  if($email_id_arr[$i] != '' && $email_id_arr[$i] != '\r\n'){
			   	         $email_id = str_replace("\r\n","",strtolower($email_id_arr[$i]));
                         $emailids[] = strtolower(str_replace(" ", "", $email_id));
			   	    }
			   }

			}
			$this->mongodb->where(array("UserId"=>mongo_id($user_id)));
			$qry = $this->mongodb->get(TBL_CONTACTS);
				foreach($qry as $email_data){
					$email[] = strtolower($email_data['PersonalEmail']);
				}
				//log_message("info",json_encode($email));
				$emailid = (array)$email + (array)$emailids;
				$emailids = array_keys(array_flip($emailid ?? array()));
		return array("Email"=>$emailids);
	}
}

/* End of file User_model.php */
/* Location: ./application/controllers/User_model.php */