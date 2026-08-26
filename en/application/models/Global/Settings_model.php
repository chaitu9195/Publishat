<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model {

	function get_settings_data($module){
           $user_id = $this->session->userdata('user_id');
		   $this->mongodb->order_by(array("DisplaySequence"=>"ASC"));
		   $this->mongodb->where(array("UserId"=> mongo_id($user_id), "Module"=>$module));
	       $qry = $this-> mongodb->get("AccountSettings");
           foreach($qry as $key){
                $settings[] = $key;
          } 
               return array('module'=> $module,'data'=>$settings);
	}
	
	/*
	Update settings 
	------------------------------------------*/
	function updateSettings($params){
	    $user_id = $this->session->userdata('user_id');
	 	$module = $params['module'];
	 	$account_setting_id_arr = $params["account_setting_id"];
		if (count($account_setting_id_arr ?? array()) > 0){
			$this->mongodb->set(array("SettingValue" => "N"));
			$this->mongodb->where(array("Module"=> $module, "UserId"=>mongo_id($user_id)));
		    $this->mongodb->update('AccountSettings', array('multiple' => true));
			
			for($i = 0; $i<count($account_setting_id_arr ?? array()); $i++){
				$account_setting_id = $account_setting_id_arr[$i];
				$this->mongodb->set(array("SettingValue" => "Y"));
			    $this->mongodb->where(array("AccountSettingId"=>mongo_id($account_setting_id), "Module"=> $module, "UserId"=>mongo_id($user_id)));
				$qry = $this->mongodb->update('AccountSettings');
			}
			if($qry){
				return "success";
			}
			else{
				return "failed";
			}
		} else { return "failed"; }
	
	}
	
}

/* End of file Settings_model.php */
/* Location: ./application/models/Global/Settings_model.php */