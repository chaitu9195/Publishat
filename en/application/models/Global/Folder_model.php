<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Folder_model extends CI_Model {
        /*
        Get Folder Data
        ----------------------------------------*/    
	function folder_data($params){
               $user_id = $this->session->userdata('user_id');
               $typeId = $params["typeId"];
			   $this->mongodb->order_by(array('TS' => "DESC"));
			   $this->mongodb->where(array("UserId"=>mongo_id($user_id), "RecordTypeId"=>$typeId, "ParentId"=>'', "UploadedFrom"=>'Folder'));
			   $qry = $this->mongodb->get('fs.files');
			   if(count($qry ?? array()) >0 ){
	                foreach($qry as $file){ 
					    $files[] = $file;
					}
               } else { $files = 'No Files'; } 
			   
			   $files = $this->msort($files, array('Type', 'TS'));
			   log_message("info",json_encode($files));
        return array("files"=>$files);
	}	        /*
        Get BookMark Data
        ----------------------------------------*/    
	function bookmark_data($params){
               $user_id = $this->session->userdata('user_id');
               $typeId = $params["typeId"]; 
			   $this->mongodb->order_by(array("Date"=>"DESC"));
			   $this->mongodb->where(array("UserId"=>mongo_id($user_id), "RecordTypeId"=>$typeId));
               $qry = $this->mongodb->get("Bookmarks");
               if(count($qry ?? array()) >0 ){
	               foreach($qry as $data){
	               		$bookmarkdata[] = $data;
	               }
               } else { $bookmarkdata = 'No Files'; } 
        return array("bookmarksdata"=>$bookmarkdata);
	}
	/*
	Upload files
	------------------------------------------------------*/
        function uploadfile($params){
               $user_id = $this->session->userdata('user_id') ? mongo_id($this->session->userdata('user_id')) : mongo_id($params["UserId"]);
               $record_type_id = $params['typeId'];
               $folder_id = $params["foldid"];
			   if($folder_id){
				   $folder_id = mongo_id($folder_id);
			   }
               $this->mongodb->where(array("RecordTypeId"=>$record_type_id));			   
               $qry = $this->mongodb->get("Folders");
               $rec = $qry;
               $folder_name = $rec[0]["FolderName"];
               $date = date("Y-m-d H:i:s");			   
               if(count($_FILES['uploadedfile']['name']) > 0){
                	$mongo_connection = new MongoClient();
					$gridfs = $mongo_connection->selectDB('publisha_dbase')->getGridFS();
					$gridfs->storeUpload('uploadedfile', array("UserId"=>$user_id, "RecordTypeId"=>$record_type_id, "FolderName"=>$folder_name, "ParentId"=>$folder_id,"Type"=>'File', "TS"=>$date, "UploadedFrom"=>'Folder'));
	         $status = "success";  
	      } else { $status = "failed";  }
	      return array("status"=>$status);  
        }
              
			  
        /*
        Delete Folder Attachment
        -------------------------------------------*/
        function delete_file($params){
                $user_id = $this->session->userdata('user_id'); 
		        $document_ids = explode(",",$params['del_doc_id']); 
                $typeId = $params['typeId'];
                 if(count($document_ids ?? array())>0) {
                    foreach($document_ids as $id){ 
					$this->mongodb->where(array("_id"=>mongo_id($id), "RecordTypeId"=>$typeId));
                    $qry = $this->mongodb->get('fs.files');
                    if(count($qry ?? array()) > 0){
                    $rec = $qry;
					$filetype = $rec[0]["Type"];
					if($filetype == "Folder"){
						 $this->mongodb->where(array("RecordTypeId"=>$typeId,"UserId"=>mongo_id($user_id),"ParentId"=>mongo_id($id)));
						 $qry = $this->mongodb->get('fs.files');
								if(count($qry ?? array())>0){
									$status = "FolderData";
								}
								else{
									$m = new MongoClient();
									$con = $m->SelectDB('publisha_dbase')->getGridFS();
									$qry = $con->remove(array("_id"=>mongo_id($id), "RecordTypeId"=>$typeId));
									if($qry){
									$status = "success"; 
									}
								}
					 }
					 else if($filetype == "File"){
                         $doc_path = "../../".$rec[0]['FilePath'];
                         if (file_exists($doc_path)) { 
                            unlink($doc_path);
                         }
							$m = new MongoClient();
							$con = $m->SelectDB('publisha_dbase')->getGridFS();
							$qry = $con->remove(array("_id"=>mongo_id($id), "RecordTypeId"=>$typeId));
                       if($qry) {
                          $status = "success"; 
                        } else { $status = "failed"; }
					}
                   } else { $status="failed"; }
                  } 
               }  else { $status = "failed"; }
             return $status;
     }
	 
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
		function createfolder($params){ 
		    $folder_name = $params["folder_name"]; 
			$folder_id = $params["folder_id"];
			$record_type_id = $params["typeId"];
			$module = $params["module"];
			$user_id = $this->session->userdata('user_id');
			$date = TimeStamp;
			if($folder_id){
				$folder_id = mongo_id($folder_id);
			}
			$this->mongodb->where(array("FolderName"=>$folder_name, "ParentId"=>$folder_id, "UserId"=>mongo_id($user_id), "Type"=>'Folder', "RecordTypeId"=>$record_type_id));
			$qry = $this->mongodb->get('fs.files');
			if(count($qry ?? array()) == 0){
				$folder_data = array("UserId"=>mongo_id($user_id), "RecordTypeId"=>$record_type_id, "FolderName"=>$folder_name, "Type"=>"Folder", "ParentId"=>$folder_id,
				"UploadedFrom"=>"Folder", "TS"=>$date);
				$res = $this->mongodb->insert('fs.files', $folder_data);
				return array("status"=>"success" , "typeId"=>$record_type_id);
			}
			else{
					return array("status"=>"failure");
			}
		}
		
		function getfolderfilesdata($fid,$type_id,$module){ 
			$user_id = $this->session->userdata('user_id');
			$this->mongodb->order_by(array("TS"=>"DESC"));
			if($fid != ''){
				$fid = mongo_id($fid);
			}
			$this->mongodb->order_by(array('TS' => "DESC"));
			$this->mongodb->where(array("UserId"=>mongo_id($user_id), "ParentId"=>$fid, "RecordTypeId"=>$type_id, "UploadedFrom"=>"Folder"));
			$qry = $this->mongodb->get('fs.files');
				foreach($qry as $folderfile){
				   $ff[] = $folderfile;
				}

				$i = $fid;
				    while($i != ''){
					   $this->mongodb->where(array("UserId"=>mongo_id($user_id), "_id"=>mongo_id($i)));
					   $qury = $this->mongodb->get('fs.files');
					   $result = $qury;
					   foreach($qury as $row){
						  $data[] = $row;
					   }
					   $f_id = $result[0]["ParentId"];
					   $i = $f_id;
					}
					$ff = $this->msort($ff, array('Type', 'TS'));
					$data = $this->msort($data, array('Type', 'TS'), SORT_REGULAR, SORT_ASC);
			return array("ff"=>$ff, "fdetails"=>$data,"typeId"=>$type_id,"module"=>$module);
	}
	function getmapsdata(){
		$m = new MongoClient();
		$db = $m->jobs;
   		$collection = $db->printers;
   		$query = $collection->find();
         return $query;
	}
	function pageinfo($params){ 
		$user_id = $this->session->userdata('user_id');
		$filename = $params['filename']; 
		$color = $params['colorselection']; 
		$print_type = $params['print_type'];
		$code = $params['code']; 
		$copies = $params['copies'];
		$pages_count = $params['pagescount'];
		$date = date("YmdhisA");
		$m = new MongoClient();
		$db = $m->jobs;
		$collection = $db->printRates;
		$query = $collection->findOne(array('printercode' => $code));
		$printercode=$query['printercode'];
		 $pbw=$query['pbw'];
		 $pco=$query['pco'];
		 $lbw=$query['lbw'];
		 $lco=$query['lco'];
		 $lor=$query['lor'];
	 if($print_type=='Portriate' && $color == 'Black and White')
	 {
	 	$cost = $pbw;
	 }
	 elseif($print_type=='Portriate' && $color == 'Color')
	 {
	 	$cost = $pco;
	 }
	 elseif($print_type=='Landscape' && $color == 'Black and White')
	 {
	 	$cost =  $lbw;
	 }
	 elseif($print_type=='Landscape' && $color == 'Color')
	 {
	 	$cost = $lco;
	 } 
	 
	 else if(($print_type=='Portriate' ||  $print_type=='Landscape') && $color == 'LOR')
	 {
	 	$cost = $lor;
	 }
	 
	 else if($color == 'Black and White' && $print_type=='Project'){
		 $cost = $pbw;
	 }
    	
	 $totalcost = $cost*$pages_count*$copies; 
	 if($print_type=='Project'){
		 $ProjectPageNos = $params["ProjectPageNos"];
		 $ProjectColorPagesCount = count(array_filter($ProjectPageNos));
		 $costForProjectColorPrint =  $ProjectColorPagesCount*$pco*$copies;
		 $totalcost = $totalcost+$costForProjectColorPrint;
	 }
		
		return $totalcost; 
	} 
	function colorselection($params){
		$color = $params['color'];
		$copies = $params['copies'];
		$pagescount = $params['pagescount'];
		$user_id = $this->session->userdata('user_id');
		$qury = $this->db->query("SELECT * FROM PrintProperties WHERE  Color = '$color'");
		$result = $qury->row_array();
		$cost = $result['Cost']; 
		$totalcost = $cost*$copies*$pagescount;
		return array("cost"=>$totalcost);
	}
	function locationsearchdata($params){ 
		$location = $params['location'];
		$regex = new MongoRegex("/$location/i"); 
		$where = array('$or' => array(array("address" => $regex),array("name" => new MongoRegex("/$location/i"))));
		//$cursor = $collection->find($where)
		// $this->mongodb->like(array("LocationName" => new MongoRegex('/'.$location.'/i')));
		/* $qury = $this->mongodb->get("Maps");
		log_message("info",json_encode($qury)); */
		$m = new MongoClient();
		$db = $m->jobs;
   		$collection = $db->printers;
   		$query = $collection->find($where);
		
		//$qury = $this->db->query("SELECT * FROM Maps WHERE LocationName LIKE '" . $location . "%'");
		foreach($query as $result){
			//print_r($result);die;
			   $data[] = $result;
			   $loc[] = $result['name']; 
			}
		return array("data"=>$data,"location"=>$loc);
	}
	/*
        Validate document
	---------------------------------------*/ 
	function document_validation($user_id){ 
		$docs = array();
		if(!empty($_FILES['uploadImage']['name'])){
			//log_message('info',$_FILES['uploadImage']['name']);
		
			/* $file_extension = $this->get_file_extension();
			if(!$file_extension){
		      return array("status"=>"failed","data"=>"Invalid File Type. Only PDF, DOC, DOCX, JPEG, JPG, GIF & PNG formats are allowed");
			} */
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
	function msort($array, $key, $sort_flags = SORT_REGULAR, $order = SORT_DESC) {
    if (is_array($array) && count($array ?? array()) > 0) {
        if (!empty($key)) {
            $mapping = array();
            foreach ($array as $k => $v) {
                $sort_key = '';
                if (!is_array($key)) {
                    $sort_key = $v[$key];
                } else {
                    // @TODO This should be fixed, now it will be sorted as string
                    foreach ($key as $key_key) {
                        $sort_key .= $v[$key_key];
                    }
                    $sort_flags = SORT_STRING;
                }
                $mapping[$k] = $sort_key;
            }
            switch ($order) {
				case SORT_ASC:
				asort($mapping, $sort_flags);
				break;
				case SORT_DESC:
				arsort($mapping, $sort_flags);
				break;
				}
            $sorted = array();
            foreach ($mapping as $k => $v) {
                $sorted[] = $array[$k];
            }
            return $sorted;
        }
    }
    return $array;
}
	function getPrintHistory($idUser){
		$m = new MongoClient();
		$db = $m->jobs;
   		$collection = $db->job;
		$where = array("idUser"=>$idUser);
   		$result = $collection->find($where)->sort(array('datetime'=>-1));
		foreach($result as $rowData){
			$data[] = $rowData;
		}
		//echo "<pre>";print_r($data); die;
		return $data;
	}
}
/* End of file Folder_model.php */
/* Location: ./application/models/Global/Folder_model.php */