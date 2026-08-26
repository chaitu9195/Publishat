<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Downloadfile_model extends CI_Model {
 
        /*
        Download File
        -------------------------------------------*/
	function download($params){
                    $label = "";
                    $name = "povendor" ;
                    $user_id = $this->session->userdata('user_id');
                    $filename = FCPATH."pwdocs/".$user_id."/".$params; 
                    $file_extension = strtolower(substr(strrchr($filename,"."),1)); 
                    
					$ctype = $this->get_mime($file_extension); 
					if (file_exists($filename)) 
					{
						/*header("Content-Type: $ctype");
						if($label)
				                {
				                	header("Content-Disposition: attachment; filename='$label.$file_extension'");
				                }
				                else {
				        	        header("Content-Disposition: attachment; filename='$filename'");
				                } 
						header("Content-Length: ".@filesize($filename));
						readfile($filename);		*/
header('Pragma: public');     // required
    header('Expires: 0');         // no cache
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($filename)).' GMT');
    header('Cache-Control: private',false);
    header('Content-Type: '.$ctype);  // Add the mime type from Code igniter.
    header('Content-Disposition: inline; filename="'.basename($filename).'"');  // Add the file name
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: '.filesize($filename)); // provide file size
    header('Connection: close');
    readfile($filename); // push it out
    exit();			
					}
					else{
						return "Sorry attachment not found";
                                                //log_message("info","failed");
					}
				
	}
function download_file($params,$recordid){
                    $label = "";
                    $name = "povendor" ;
                    $user_id = $this->session->userdata('user_id');
                    $qry = $this->db->query("SELECT * FROM Projects where RecordId = '$recordid'");
                    $result = $qry->result_array();
                    foreach ($result as $value) {
                    	$usersid = $value['UserId'];

                    }
                    $userid = $usersid;
                    $filename = FCPATH."pwdocs/".$userid."/".$params; 
                    $file_extension = strtolower(substr(strrchr($filename,"."),1)); 
                    
					$ctype = $this->get_mime($file_extension); 
					if (file_exists($filename)) 
					{
						/*header("Content-Type: $ctype");
						if($label)
				                {
				                	header("Content-Disposition: attachment; filename='$label.$file_extension'");
				                }
				                else {
				        	        header("Content-Disposition: attachment; filename='$filename'");
				                } 
						header("Content-Length: ".@filesize($filename));
						readfile($filename);		*/
header('Pragma: public');     // required
    header('Expires: 0');         // no cache
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($filename)).' GMT');
    header('Cache-Control: private',false);
    header('Content-Type: '.$ctype);  // Add the mime type from Code igniter.
    header('Content-Disposition: inline; filename="'.basename($filename).'"');  // Add the file name
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: '.filesize($filename)); // provide file size
    header('Connection: close');
    readfile($filename); // push it out
    exit();			
					}
					else{
						return "Sorry attachment not found";
                                                //log_message("info","failed");
					}
				
	}


	/*get mime type*/
	function get_mime($file_extension){
	    $file_extension = strtolower($file_extension);
		switch ($file_extension) {
		   case "pdf":  $ctype="application/pdf"; break;
		   case "exe":  $ctype="application/octet-stream"; break;
		   case "zip":  $ctype="application/x-zip-compressed"; break;
		   case "doc":  $ctype="application/msword"; break;
		   case "doc":  $ctype="application/doc"; break;
		   case "xls":  $ctype="application/vnd.ms-excel"; break;
		   case "ppt":  $ctype="application/vnd.ms-powerpoint"; break;
		   case "gif":  $ctype="image/gif"; break;
		   case "png":  $ctype="image/png"; break;
		   case "jpe":  $ctype="image/jpg"; break;
		   case "jpeg": $ctype="image/jpg"; break;
		   case "jpg":  $ctype="image/jpg"; break;	   
		   case "docx": $ctype="application/vnd.openxmlformats-officedocument.wordprocessingml.document"; break;
		   case "xlsx": $ctype="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"; break;
		   case "txt":  $ctype="text/plain"; break;
		   case "xps":  $ctype="application/vnd.ms-xpsdocument"; break;
		   case "rar":  $ctype="application/x-rar-compressed"; break;
		   case "ppt":  $ctype="application/vnd.openxmlformats-officedocument.presentationml.presentation"; break;
	       case "pptx": $ctype="application/vnd.ms-powerpoint"; break;
		   default: $ctype="application/force-download";
		}
		return $ctype;
	}

	/*disposition attachment*/
	function is_disposition_attach($ctype){
		$user_agent = strtoupper($_SERVER['HTTP_USER_AGENT']);
		
		$ctype_arr = array("image/jpg", "image/png", "image/gif");
		$browsers_arr = array("MSIE 6.0", "MSIE 7.0", "MSIE 8.0", "MSIE 9.0");
		
		if (in_array($ctype, $ctype_arr ?? array())){
			/*foreach($browsers_arr as $browser_ver){
				if (strpos($user_agent, $browser_ver) > 0){
					return true;
					break;
				}
			}*/
			return true;
		}
		else{
			return false;
		}
		return false;
	}

	
	function mongodownload($fid){
		$m = new MongoClient();
		$gridfs = $m->selectDB('publisha_dbase')->getGridFS();
		
		  $this->mongodb->where(array("_id"=>mongo_id($fid)));
          $fileinfo = $this->mongodb->get('fs.files');	
          foreach($fileinfo as $filedetails){		  
		     $file_extension =  $filedetails["FileType"];
			 $path = $filedetails["DocumentPath"];
			 $uploadedFrom = $filedetails["UploadedFrom"];
			 // Resolve filesystem-stored docs from an absolute, restore-friendly
			 // path (pwdocs restored under the app root). DocumentPath looks like
			 // /pwdocs/<uid>/<file>, so FCPATH + that path points at en/pwdocs/...
			 $filename = FCPATH . ltrim((string)$path, '/');
			 $ctype = $this->get_mime($file_extension);
		  }
		if(empty($path)){
			  $filename = $filedetails["filename"];
			  $ctype = strtolower($this->get_file_extension($filename));
			  if($ctype == 'pdf'){
				  $ctype = "application/pdf";
			  }
			  $file = $gridfs->findOne(array("_id"=>mongo_id($fid)));
			  header('Content-Description: File Transfer');
			  header('Content-Type: '.$ctype);
			  header('Content-Disposition: inline; filename="'.$filename.'"');  // Add the file name
			  header('Content-Transfer-Encoding: binary');
			  header('Expires: 0');
			  header('Cache-Control: must-revalidate');
			  header('Pragma: public');
			  ob_clean();
			  flush();
			  echo $file->getBytes(); die;
		}
		else{
		 if (file_exists($filename)) 
			{
			  header('Content-Description: File Transfer');
			  header('Content-Type: '.$ctype);
			  header('Content-Disposition: inline; filename="'.basename($filename).'"');  // Add the file name
			  header('Content-Transfer-Encoding: binary');
			  header('Expires: 0');
			  header('Cache-Control: must-revalidate');
			  header('Pragma: public');
			  readfile($filename); 
			  exit();
		}
	  }
	}	
	function get_file_extension($file_name){
		$dot_index = strrpos($file_name, ".");
		$file_type = substr($file_name, $dot_index + 1);
		return $file_type;		
	}
}
/* End of file Downloadfile_model.php */
/* Location: ./application/models/Common/Downloadfile_model.php */