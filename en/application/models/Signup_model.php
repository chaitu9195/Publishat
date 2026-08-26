<?php
//require (APPPATH . '/libraries/email_utils.php');
class Signup_model extends CI_Model {
	function sign_up($params) 
	{
		$this->load->database();
		$user_type = $params['UserLoginType'];
		$validationCheck = $this->validate_parameters($params);
		if($validationCheck)
		{
			$fullname = $params['ContactName'];
			$uemail = $params['PersonalEmail'];
			$unhashpwd = uniqid();
			$pwd = md5($unhashpwd);
			$dob = date("Y-m-d", strtotime($params['DateOfBirth']));
			if(!empty($dob)) $params['DateOfBirth'] = "STR_TO_DATE('$dob', '%Y-%m-%d')";
			$joined_on = date("Y-m-d H:i:s");
			
			
			$userdata['Name'] = $fullname;
			$userdata['Email'] = $uemail;
			$userdata['Password'] = $pwd;
			$userdata['DateOfBirth'] = $dob;
			$userdata['UserLoginType'] = 4;
			$userdata['JoinedOn'] = $joined_on;
			$userdata['EmailVerified'] = "Y";
			$userdata['FirstLogin'] = "1";
			$userdata['Status'] = "Inactive";
			$userdata['JoinedOn'] = $joined_on;
                        $userdata['Role'] = "Guest";
			$userdata['UID'] = '';
			$userdata['Gender'] = '';
			$userdata['Phone'] = '';
			$userdata['Address'] = $params['Address'];
			$userdata['State'] = '';
			$userdata['StateOther'] = '';
			$userdata['Country'] = '';
			$userdata['PhotoPath'] = '';
			$userdata['TempPhotoPath'] = '';
			$userdata['Facebook']='';
                        
			$query = $this->db->insert(TBL_USER,$userdata);
			//log_message('info',$query);
			if ($query){
				$user_id = $this->db->insert_id();	
					$email_template = "mailtemplates/account-verification-template.html";	
					$to_email = $uemail;
					$from_email = admin_from_email;
					$subject = "Publishat.com Account Verification";
					$email_body = $this->read_file($email_template);
					
					$type = "html";
					$email_body = str_replace("##name##", $fullname, $email_body);	
					$email_body = str_replace("##vc##", $unhashpwd, $email_body);				
					$email_body = str_replace("##usermail##", $uemail, $email_body);				
                                        
					$mailStatus = $this->publishmail($from_email, $to_email, $subject, $email_body, $type);
					$this->initialise_user_settings($user_id);							
				return array("status"=>"success","data"=>$user_id);
			}
			else{
				return array("status"=>"failed");
			}
		}
		else{
			return array("status"=>"failed");
		}
	}

	function validate_parameters($params){
		if (!empty($params['DateOfBirth']) && !empty($params['ContactName']) && !empty($params['PersonalEmail']))
		{
			return true;
		}else
		{
			return  false;
		}
	}
	function read_file($filename){
	    if (file_exists($filename)) {
	    	//log_message('info',$filename);
			$handle = fopen($filename, "r");
			$contents = fread($handle, filesize($filename));
			fclose($handle);
			return $contents;
		}
		else{
			return "";
		}
	}
	function publishmail($from_email, $to_email, $subject, $message, $type){
		$config = Array(
		//  'protocol' => protocol,
		  'smtp_host' => smtp_host,
		  'smtp_port' => smtp_port,
		  'smtp_user' => smtp_user, // change it to yours
		  'smtp_pass' => smtp_pass, // change it to yours
		  'mailpath' => mailpath,
		  'charset' => charset,
		  'wordwrap' => wordwrap
		);

	    if ($type == "html"){   //html email
		
			$mailheaders  = "From:".admin_from_email."\r\n".
			               "MIME-Version:1.0\r\n".
			               "Content-type:text/html\r\n".
						   "Content-Transfer-Encoding:7bit\n".
	                       "Reply-To: ".admin_from_email."\n";
		}
		else{     // text email
			$mailheaders  = "From:".admin_from_email."\r\nMIME-Version: 1.0\r\nContent-type:".
	                       "text/plain\r\nContent-Transfer-".
	                       "Encoding: 7bit\n".
						   "Reply-To: ".admin_from_email."\n";		
		}
		//mail ( $to_email, $subject, $message, $mailheaders );
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from(noreply); // change it to yours
		$this->email->to($to_email);// change it to yours
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->set_mailtype('html'); 
		//$this->email->mailheaders($mailheaders);
	    if(mail ( $to_email, $subject, $message, $mailheaders ))
		{
			return true;
		}
		else
	    {
			show_error($this->email->print_debugger());
		}

	}
	/*initialising user settings*/
	function initialise_user_settings($user_id){
    	$qry = $this->db->query("SELECT * FROM ".TBL_ACCOUNTSETTINGS." WHERE UserId = $user_id");
		if ($qry->num_rows() == 0)
		{
			$query = $this->db->query("INSERT INTO ".TBL_ACCOUNTSETTINGS."(UserId, SettingId, SettingValue) 
					(SELECT $user_id, SettingId, InitialValue FROM ".TBL_SETTINGS." ORDER BY SettingId)");
		}
	}
}