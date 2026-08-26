<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mailfolderfiles_model extends CI_Model {
	function mail_from_folder($params){log_message("info",json_encode($params));

		$user_id = $this->session->userdata('user_id');
		if(empty($user_id)){
			$user_id = $params["UserId"];
		}
		$document_ids = explode(",",$params['doc_ids']); 	
		
		$addtext = $params['addtext'];
		$subject = $params['subject'];
		$user_type = $params['user_type'];
		$group = $params['group'];
		$category = $params['category'];
		$Sub_Category = $params['Sub_Category'];
		$Issue_Status = $params['Issue_Status'];
        $this->mongodb->where(array("UserId"=>mongo_id($user_id)));
		$validUser = $this->mongodb->get(TBL_USER);
		if(count($validUser ?? array()) > 0)
		{
			$userData = $validUser;
			$user_email = $userData[0]["Email"];
			$user_fullname = $userData[0]["Name"];
			$user_phone = $userData[0]["Phone"]; 
			if (count($document_ids ?? array()) > 0){
			    //$email_content = "<html>";	
				if($user_type=='undefined' || $group=='undefined' || $category=='undefined' || $Sub_Category=='undefined' || $Issue_Status=='undefined'){
					$email_content = header_top; 
				}else{	
				$email_content = header_top_user_details;
				}
				$table_bg_color = "#99CCCC";
				foreach($document_ids as $document_id){	
					$table_bg_color = ($table_bg_color == "#CCCC99") ? "#99CCCC" : "#99CCCC";	
					$email_content .= $this->get_record_table_html($document_id,$addtext,$table_bg_color, "#FFFFFF");
				}
				$email_content .= header_bottom;
				$header_title = str_replace("Publishat.com | ", "", $subject);
				$email_content = str_replace("##HEADER-TITLE##", $header_title, $email_content);
				$email_content = str_replace("##HEADER-EMAIL##", $user_email, $email_content);	
				$email_content = str_replace("##HEADER-NAME##", $user_fullname , $email_content);
				$email_content = str_replace("##HEADER-PHONE##", $user_phone , $email_content);
				$email_content = str_replace("##ADD-TEXT##", $addtext ,$email_content);
				$email_content = str_replace("##USERTYPE##", $user_type ,$email_content);
				$email_content = str_replace("##GROUP##", $group ,$email_content);
				$email_content = str_replace("##CATEGORY##", $category ,$email_content);
				$email_content = str_replace("##SUBCATEGORY##", $Sub_Category ,$email_content);
				$email_content = str_replace("##ISSUESSTATUS##", $Issue_Status ,$email_content);
				$from_email = $user_email;			
				$email_list = $params["email_list"];
				//log_message('info',$email_list);
				if (!empty($email_list)){	
				   $email_arr = explode(",", trim($email_list));
				   if (count($email_arr ?? array()) > 0){
				      foreach($email_arr as $out_email){
					$mailStatus = $this->sendcartmail($from_email, trim($out_email), $subject, $email_content);
					$status_code = 1;
			              }
						  $eventdata = array("UserId"=>mongo_id($user_id),
                     "EventType"=>'Shared',
                     "Module"=>$user_fullname,
                     "Receiver"=>$email_list,
                     "Date"=>TimeStamp
                  );
                  $qry = $this->mongodb->insert(TBL_EVENTS, $eventdata);
				   }	   
				}
				if ($status_code == 1){			
					$status_message = "Emails have been sent with the Files";	
					return array("status"=>"success","data"=>$status_message);
				}
				else{
					$status_message = "Error: No emails have been sent. Please try again. ";	
					return array("status"=>"failed","data"=>$status_message);
				}
			}
			/*raw code ends*/
		}
		else{
			return array("status"=>"failed","data"=>"invalid user");
		}
	}



   

	/*all below functions are used for sending mail*/
	function get_record_table_html($doc_id,$addtext,$table_bg, $tr_bg){
		$email_body = "";	
		$this->mongodb->where(array("_id"=>mongo_id($doc_id)));
		$qry = $this->mongodb->get("fs.files");
		if (count($qry ?? array()) > 0){
		    $email_template = "mailtemplates/email-showkart.html";	
			$email_body = $this->read_file($email_template);
			$rec = $qry; 
			$attachments = $this->get_document_email_links2($rec[0]['_id']); 
			//log_message('info','final attachment');
			$email_body=  str_replace("##ADD-TEXT##", $addtext, $email_body);
			$email_body = str_replace("##ATTACHMENTS##", $attachments, $email_body);
			//$email_body = str_replace("##NOTES##", $notes, $email_body);
			$email_body = str_replace("##TABLE_BGCOLOR##", $table_bg, $email_body);
			$email_body = str_replace("##TR_BGCOLOR##", $tr_bg, $email_body);
	        		
		}
					
		return $email_body;
	}
	
	function mail_from_bookmarks($params){

		$user_id = $this->session->userdata('user_id'); 
		$document_ids = explode(",",$params['doc_ids']); 
		$addtext = $params['addtext'];
		$subject = $params['subject'];
		$module = $params['module'];
		$submodule = $params['submodule'];
		$issues = $params['issues'];
        $this->mongodb->where(array("UserId"=>mongo_id($user_id)));
		$validUser = $this->mongodb->get(TBL_USER);
		if(count($validUser ?? array()) > 0)
		{
			$userData = $validUser;
			$user_email = $userData[0]["Email"];
			$user_fullname = $userData[0]["Name"];
			$user_phone = $userData[0]["Phone"]; 
			if (count($document_ids ?? array()) > 0){
			    //$email_content = "<html>";			
				$email_content = header_top;			
				$table_bg_color = "#99CCCC";
				foreach($document_ids as $document_id){	
					$table_bg_color = ($table_bg_color == "#CCCC99") ? "#99CCCC" : "#99CCCC";	
					$email_content .= $this->get_bookmark_data_html($document_id,$addtext,$module,$submodule,$issues, $table_bg_color, "#FFFFFF");
				}
				$email_content .= header_bottom;
				$header_title = str_replace("Publishat.com | ", "", $subject);
				$email_content = str_replace("##HEADER-TITLE##", $header_title, $email_content);
				$email_content = str_replace("##HEADER-EMAIL##", $user_email, $email_content);	
				$email_content = str_replace("##HEADER-NAME##", $user_fullname , $email_content);
				$email_content = str_replace("##HEADER-PHONE##", $user_phone , $email_content);
				$email_content = str_replace("##ADD-TEXT##", $addtext ,$email_content);
				$email_content = str_replace("##MODULE##", $module ,$email_content);
				$email_content = str_replace("##SUBMODULE##", $submodule ,$email_content);
				$email_content = str_replace("##ISSUES##", $issues ,$email_content);
				$from_email = admin_from_email;			
				$email_list = $params["email_list"];
				//log_message('info',$email_list);
				if (!empty($email_list)){	
				   $email_arr = explode(",", trim($email_list));
				   if (count($email_arr ?? array()) > 0){
				      foreach($email_arr as $out_email){
					$mailStatus = $this->sendcartmail($from_email, trim($out_email), $subject, $email_content);
					$status_code = 1;
			              }
				   }	   
				}
				if ($status_code == 1){			
					$status_message = "Emails have been sent with the Files";	
					return array("status"=>"success","data"=>$status_message);
				}
				else{
					$status_message = "Error: No emails have been sent. Please try again. ";	
					return array("status"=>"failed","data"=>$status_message);
				}
			}
			/*raw code ends*/
		}
		else{
			return array("status"=>"failed","data"=>"invalid user");
		}
	}



   

	/*all below functions are used for sending mail*/
	function get_bookmark_data_html($doc_id,$addtext,$table_bg, $tr_bg){
		$email_body = "";	
		$this->mongodb->where(array("_id"=>mongo_id($doc_id)));
		$qry = $this->mongodb->get("Bookmarks");
		if (count($qry ?? array()) > 0){
		    $email_template = "mailtemplates/email_bookmarks.php";	
			$email_body = $this->read_file($email_template);
			$rec = $qry; 
			$title = $rec[0]['Title']; 
			$description = $rec[0]['Description']; 
			$notes = $rec[0]['Notes']; 
			$header_title = "Bookmarks";
			//log_message('info','final attachment');
			$email_body=  str_replace("##ADD-TEXT##", $addtext, $email_body);
			$email_body = str_replace("##TITLE##", $title, $email_body);
			$email_body = str_replace("##HEADER-TITLE##", $header_title, $email_body);
			$email_body = str_replace("##DESCRIPTION##", $description, $email_body);
			$email_body = str_replace("##NOTES##", $notes, $email_body);
			//$email_body = str_replace("##NOTES##", $notes, $email_body);
			$email_body = str_replace("##TABLE_BGCOLOR##", $table_bg, $email_body);
			$email_body = str_replace("##TR_BGCOLOR##", $tr_bg, $email_body);
	        		
		}
					
		return $email_body;
	}

	function get_document_email_links2($record_id){
	ob_start();		
        $this->mongodb->where(array("_id"=>$record_id));
		$qry = $this->mongodb->get("fs.files");
		if (count($qry ?? array()) > 0){
		  	 	$rec = $qry;
                $file_type = $rec[0]["FileType"];
			    $doc_path = $rec[0]["DocumentPath"];
				$filename = $rec[0]["filename"];
				$img_name = $rec[0]["img_name"];
				if(empty($filename)){
				$filename = basename($doc_path);
				$filename = substr($filename, strpos($filename, "-") + 1);
				}
               	if(empty($file_type)){
                     $file_type = $this->get_file_extension($filename);
				}				
				$id = $rec[0]["_id"];	
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				//$file_tag=strtolower(substr(strstr($filename,"-"),1));   
				$documenticon = $this->get_document_icon(strtolower($file_type));
				$doc_icon = "https://www.publishat.com/" . $documenticon;
				/* $doc_tag = strtoupper($file_tag);
				if(empty($doc_tag)){
					$doc_tag = $filename;
				} */
				$doc_link_url = "https://www.publishat.com/digital/en/web/docviewer?fid=".$id."&type=".strtolower($ext); 
				$templink = "<a target='_blank' href='$doc_link_url'><img src='$doc_icon' width='20' height='20' border='0' align='absmiddle' /></a>&nbsp;
	            <a target='_blank' href='$doc_link_url'>$filename</a>";

		}
		else{
			$templink = "<i>No documents are attached to this record</i>";
		}
		return $templink;
		/*$content = ob_get_contents();
		ob_end_clean();
		return $content;*/
	}

	/*reading file*/
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

	/*mail function*/
	function sendcartmail($from_email, $to_email, $subject, $message, $type="html"){
		
			$this->load->library('email');
			$config = Array(
			  'protocol' => protocol,
			  'smtp_host' => smtp_host,
			  'smtp_port' => smtp_port,
			  'smtp_user' => smtp_user, // change it to yours
			  'smtp_pass' => smtp_pass, // change it to yours
			  'mailpath' => mailpath,
			  'charset' => charset,
			  'wordwrap' => wordwrap
			);
			/* //SMTP & mail configuration
			$config = array(
				'protocol'  => 'smtp',
				'smtp_host' => 'smtp.zoho.com',
				'smtp_port' => 465,
				'smtp_user' => 'admin@publishat.com',
				'smtp_pass' => 'Vijaya@123',
				'mailtype'  => 'html',
				'charset'   => 'utf-8'
			); */
			$this->email->initialize($config);
			$this->email->set_mailtype("html");
			$this->email->set_newline("\r\n");
			
			$this->email->to($to_email);
			if($cc){
				$this->email->cc($cc);
			}
			// $this->email->from('from_email','Publishat');
			$this->email->from(smtp_user);
			$this->email->subject("$subject");
			$this->email->message($message);

			//Send email
			if($this->email->send()){
			
			}else{
			   //Email Failed To Send
			   return $this->email->print_debugger();
			}
	}

	/*get icons*/
	function get_document_icon($file_type){	
    $file_type = strtolower($file_type);
		switch($file_type){
			case "pdf": $icon = "graphics/icon_pdf.png"; break;
			case "doc": $icon = "graphics/icon_doc.png"; break;
			case "docx": $icon = "graphics/icon_doc.png"; break;
			case "jpg": $icon = "graphics/icon_jpg.png"; break;
			case "jpe": $icon = "graphics/icon_jpg.png"; break;
			case "jpeg": $icon = "graphics/icon_jpg.png"; break;
			case "gif": $icon = "graphics/icon_gif.png"; break;
			case "png": $icon = "graphics/icon_png.png"; break;		
			case "txt": $icon = "graphics/icon_txt.png"; break;
			case "xls": $icon = "graphics/icon_xls.png"; break;
			case "xlsx": $icon = "graphics/icon_xls.png"; break;
			case "xps": $icon = "graphics/icon_xps.png"; break;
			case "zip": $icon = "graphics/icon_zip.png"; break;
			case "rar": $icon = "graphics/icon_rar.png"; break;
	                default: $icon = "graphics/icon_pdf.png"; break;
		}
		return $icon;
	}


	/*encryption*/
	function encript($value){ 
		$skey = "hserus$#@!^&*()-";
	    if(!$value){return false;}
	    $text = $value;
	    // Legacy mcrypt Rijndael-256/ECB replaced by phpseclib (see legacy_crypto_helper).
	    $crypttext = rijndael256_ecb_encrypt_raw($skey, $text);
	    return trim($this->safe_b64encode($crypttext)); 
	}

	function safe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }
    function get_file_extension($file_name){
		$dot_index = strrpos($file_name, ".");
		$file_type = substr($file_name, $dot_index + 1);
		return $file_type;		
	}
}
/* End of file Mailfolderfiles_model.php */
/* Location: ./application/models/Global/Mailfolderfiles_model.php */