<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Addcontact_model extends CI_Model {

	function addnewcontact($params){
		$this->load->database();
		unset($params['DateOfBirth']);
		unset($params['UserLoginType']);
		$bloodgroup = $params['BloodGroup'];
		unset($params['BloodGroup']);
		$params['Notes'] .= ". BloodGroup:$bloodgroup";
		$params['Designation'] = '';
		if (empty($params['OrganisationName'])) {
			$params['OrganisationName'] = '';
		}
		if (empty($params['GroupName'])) {
			$params['GroupName'] = '';
		}
		if(!isset($params['Category'])){
			$params['Category'] = '';
		}
		if(!isset($params['MobilePhoneNumber'])){
			$params['MobilePhoneNumber'] = '';
		}
		if(!isset($params['AlternatePhoneNumber'])){
			$params['AlternatePhoneNumber'] = '';
		}
		if(!isset($params['OfficePhoneNumber'])){
			$params['OfficePhoneNumber'] = '';
		}
		if(!isset($params['Location'])){
			$params['Location'] = '';
		}
		if(!isset($params['DocumentType'])){
			$params['DocumentType'] = '';
		}
		if(!isset($params['OfficeEmail'])){
			$params['OfficeEmail'] = '';
		}
		if(!isset($params['ContactStatus'])){
			$params['ContactStatus'] = '';
		}
		if(!isset($params['HomeAddress'])){
			$params['HomeAddress'] = '';
		}
		if(!isset($params['Country'])){
			$params['Country'] = '';
		}
		$insertqry = $this->db->insert(TBL_CONTACTS,$params);
		if($insertqry){
			return "success";
		}else{
			return "failed";
		}
	}

}

/* End of file Addcontact_model.php */
/* Location: ./application/models/Addcontact_model.php */