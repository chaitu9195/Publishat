<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup_model extends CI_Model {

   function signup($params){
       $name = $params["fullname"];
       $email = $params["email"];
       $conf_email = $params["conf_email"];
       $password = $params["password"];
       $password = md5($password);
       $dob = $params["dob"];
       $gender = $params["gender"];
       $joined_on = date("Y-m-d H:i:s");
       $admin_from_email = "no-reply@publishat.com";
       $prime_multiplier = 379;
       $qry = $this->db->query("SELECT * FROM ".TBL_USER." WHERE Email = '$email'");
       if ($qry->num_rows() == 0){
         $this->db->query("INSERT INTO ".TBL_USER." (Name, Email, Password, Gender, DateOfBirth, EmailVerified, Status, JoinedOn,UserLoginType) VALUES ('$name', '$email', '$password', '$gender', '$dob', 'N', 'Inactive', '$joined_on','1')");

           $user_id = $this->db->insert_id();
         
                        $email_template = "../../templates/account-verification-template.html";	
                        $to_email = $email;
			$from_email = $admin_from_email;
			$subject = "Publishat.com Account Verification";
						
			$email_body = $this->read_file($email_template);
			$vc = ($user_id * $prime_multiplier) . "!" . $password; 
			$email_body = str_replace("##name##", $fullname, $email_body);	
			$email_body = str_replace("##vc##", $vc, $email_body);
           	        $this->phpmail_nocc($from_email, $to_email, $subject, $email_body, "html");	
                 return array("status"=>"success");
       }
       else{
              return array("status"=>"failure");
         
       }
   }

function updateuserinfo($params){
    $dob = $params["dob"];
    $fbid = $params["fbid"];
    $country_code = $params["country_code"];
    $phone = $params["phone"];
    $user_id = $this->session->userdata('user_id');
    $qry = $this->db->query("UPDATE ".TBL_USER." SET DateOfBirth = '$dob', Fbid = '$fbid', Country = '$country_code', Phone = '$phone' WHERE UserId = '$user_id'");
    if($qry){ 
        return array("status"=>"success");
    }
}

function read_file($filename){
    if (file_exists($filename)) {
    $handle = fopen($filename, "r");
    $contents = fread($handle, filesize($filename));
    fclose($handle);
    return $contents;
  }
  else{
    return "";
  }
}

function phpmail_nocc($from_email, $to_email, $subject, $message, $type="html"){

    if ($type == "html"){   //html email
	 $mailheaders  = "From:$from_email\r\n".
		               "MIME-Version:1.0\r\n".
		               "Content-type:text/html\r\n".
					   "Content-Transfer-Encoding:7bit\n".
                       "Reply-To: $from_email\n";
	}
	else{     // text email
		$mailheaders  = "From:$from_email\r\nMIME-Version: 1.0\r\nContent-type:".
                       "text/plain\r\nContent-Transfer-".
                       "Encoding: 7bit\n".
					   "Reply-To: $from_email\n";		
	}
	mail ( $to_email, $subject, $message, $mailheaders );
}



}