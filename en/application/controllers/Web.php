<?php
require (APPPATH . '/libraries/REST_Controller.php');
class Web extends REST_Controller {

      /*
      Constructor
      --------------------------------*/
      public function __construct()
	{
	  parent::__construct();
            $this->load->database();
            $this -> load -> model('Common/Common_model');
            $this->load->library('session');
            $this->load->library('mongo_db', array('activate'=>'newdb'),'mongodb');
			$userIdFromCookie = $this->input->cookie('user_id',TRUE);
			if($userIdFromCookie){
				$userarray = array('user_id' => $userIdFromCookie);
				$this->session->set_userdata("user_id",$userIdFromCookie);
			}
			$user_id = $this->session->userdata('user_id');

	}

	function login_post() {
            $params = $this->sanitize($this->input->post());
	    	$this -> load -> model('Login_model');
	    	$result = $this -> Login_model -> login_check($params);
	    	//$this->response($result,200);
	    	if($result['status']=="success"){
	    		$userarray = array(
	    			'user_id' => $result['data']['UserId'],
	    			'name' => $result['data']['Name'],
	    			'email' => $result['data']['Email'],
					'Upgraded' => $result['data']['Upgraded']
	    		);
				$this->session->set_userdata( $userarray );
              $user_id = trim($this->session->userdata('user_id'));
               if(!empty($user_id) || $user_id != ""){
					$this->load->view('template');
               } else {  $this->load->view('index'); }

	    	}
	    	else{
	    		$this->load->view('index',array("failed"=>1,"data"=>$result['data']));
	    	 }
	    }



        function index_get() {
			//die;
			$user_id = $this->session->userdata('user_id');
			  $user_id = $user_id ? $user_id : $this->input->cookie('user_id',TRUE);
			  if($user_id){
				  $this->load->model("Login_model");
				  $Upgraded = $this->Login_model->upgradeStatus($user_id);
				  $this->session->set_userdata(array("Upgraded"=>$Upgraded));
			  }
			  //echo $user_id; die;
			  //print_r($this->session->userdata());die;
              if(empty(trim((string)$user_id)) || $user_id === "" ){
				$this->load->view('index');
              } else { $this->load->view('template'); }
       }


       /*
       Index
       -------------------------------*/
      function records_get () {
		   $rid = $this->input->get('page_id');
              $module = $this->input->get('module');
              $user_id = trim($this->session->userdata('user_id'));
			  if(!empty($user_id) || $user_id != ""){
					$this->load->view('template',  array("module"=>$module, "rid"=>$rid));
               } else {  $this->load->view('index'); }
       }

       function recordsCount1_post(){
                   //  $rec_type_id = $this->sanitize($this->input->post('rid'));
                   //log_message("info","testme".json_encode($rec_type_id));

       }
      /*
      Header Navigation Menu
      ----------------------------*/
      function header_post() {
		$this -> load -> model('Global/Navheader_model');
        $result = $this -> Navheader_model -> get_headerdata();
		$data["data"]		= $result['module'];
		$data["submod"]		= $result['submod'];
		$data["typeIds"]	= $result['typeIds'];
		$data["rec_count"]	= $result['rec_count'];
        $this->load->view('includes/header', $data);
      }

      /*
      No of Records Count for header level
      ----------------------------------------
      function recordsCount_post() {
              $rec_type_id = $this->sanitize($this->input->post('rid'));
              $result = $this -> Common_model-> rec_count($rec_type_id);
              if($result['status'] == 'success'){
                 echo '('.$result['count'].')';
              } else { echo "(0)"; }
      }*/
      /*
      Global records page data
      -----------------------------------------*/
      function moduledata_post() {
			  $params = $this->sanitize($this->input->post());
			  $module = $params['module'];
              $recTypeId = $params['mod_id'];
              $res = $this -> Common_model->collaboration_rec($recTypeId);
              $result = $this -> Common_model-> get_records($params);
			  $tabName = $this -> Common_model-> get_tabName($recTypeId);
			  $moduleName = $this -> Common_model-> get_moduleName($recTypeId);
			  $tableName = $this -> Common_model-> get_table($recTypeId);
              if($result['status'] == 'success'){
              //$file_name = $module.'/'.strtolower($result['table']).'/records';
			  $file_name = "allrecords";
			  $data["data"] 			= $result['data'];
			  $data["count"]			= $result['count'];
			  $data["shared_result"] 	= $res['shared_data'];
			  $data["col_file_cnt"]		= $res['col_files_count'];
			  $data["tabName"]			= $tabName;
			  $data["moduleName"]		= $moduleName;
			  $data["tableName"]		= $tableName;
			  $data["recTypeId"]		= $recTypeId;
              $this->load->view($file_name, $data);
              } else  {  echo $result['status']; }
      }
	  function moduledata_get() {
			  $params = $this->sanitize($this->input->get());
              $module = $params['module'];
              $recTypeId = $params['mod_id'];
			  $page = $params['page'];
              $res = $this -> Common_model->collaboration_rec($recTypeId);
              $result = $this -> Common_model-> get_records($params);
			  $tabName = $this -> Common_model-> get_tabName($recTypeId);
			  $moduleName = $this -> Common_model-> get_moduleName($recTypeId);
			  $tableName = $this -> Common_model-> get_table($recTypeId);
				if($result['status'] == 'success'){
					$file_name = "allrecords";
					echo  mongo_json_encode($result["data"]);
				} else  {  echo $result['status']; }
      }

      /*
      Create mode pageview
      -----------------------------------------*/
      function addnew_post() {
              $params = $this->sanitize($this->input->post());
              $module = $params['module'];
              $recTypeId = $this->sanitize($this->input->post('mod_id'));
			  $tabName = $this -> Common_model-> get_tabName($recTypeId);
			  $moduleName = $this -> Common_model-> get_moduleName($recTypeId);
			  $this -> load -> model('Getallfields_model');
		      $fields = $this -> Getallfields_model -> get_allfields($recTypeId, $user_id, 0);
              $file_name = 'create';
			  $folder_files = $this -> Common_model-> folderfiles($recTypeId);
			  $fileURL = $this->input->post("fileURL");
			  $fileURL = $fileURL ? $fileURL : "";
				if($fileURL){
					$ocrDataResult = $this->OcrReader($fileURL);
				    $decodedData =  $this->object_2_array(json_decode($ocrDataResult));
					$string = $decodedData["ParsedResults"][0]['ParsedText'];
					$string = str_replace(" ,", "", $string);
					$wordData = explode(" ", $string);
					$ocrData['FromDate']     =  $wordData[0];
					for($i = 1; $i < (count($wordData ?? array())-2); $i++){
						$ocrData['ReceiverName'] .= $wordData[$i]." ";
					}
					$ocrData['Amount']  =  $wordData[count($wordData ?? array())-2];
					$ocrData['Notes']	=  $string;
				}
				$data["files"] 		= $folder_files["folder"];
				$data["fileids"] 	= $params["ids"];
				$data["fields"] 	= $fields;
				$data["tabName"] 	= $tabName;
				$data["moduleName"] = $moduleName;
				$data["data"]		= $params["data"];
				$data["ocrData"] 	= $ocrData;
				$this->load->view($file_name, $data);
      }
      /*
      add related Page view
      -----------------------------------------*/
      function addrelated_post() {
              $params = $this->sanitize($this->input->post());
              $module = $params['module'];
              $recTypeId = $params['mod_id'];
              $record_id = $params['r_id'];
              $result = $this -> Common_model-> get_table($recTypeId);
			  $tabName = $this -> Common_model-> get_tabName($recTypeId);
			  $moduleName = $this -> Common_model-> get_moduleName($recTypeId);
			  $this -> load -> model('Getallfields_model');
		      $fields = $this -> Getallfields_model -> get_allfields($recTypeId, $user_id, 1);
			  //$file_name = $module.'/'.strtolower($result).'/addrelated';
			  $file_name = 'addrelated';
              $folder_files = $this -> Common_model-> folderfiles($recTypeId);
			  $data["recordId"]		= $record_id;
			  $data["files"]		= $folder_files["folder"];
			  $data["fileids"]		= $params["ids"];
			  $data["fields"]		= $fields;
			  $data["tabName"]		= $tabName;
			  $data["moduleName"]	=$moduleName;
			  $data["addrelated"] 	= 1;
			  $this->load->view($file_name,$data);
      }
           /*
     Add Sub(related) Record into DB
     ------------------------------------------*/
      function addSubRecord_post() {
            $params = $this->sanitize($this->input->post());
	    $this -> load -> model('Common/Addrecord_model');
	    $result = $this -> Addrecord_model -> add_sub_record($params);
	    if($result['status']=='success'){
	      echo $result['rid'];
	    } else{
              echo $result['status'];
            }
      }
      /*
      View single subrecord
      --------------------------------------------*/
      function relatedview_post(){
              $params = $this->sanitize($this->input->post());
              $module = $this->sanitize($params['module']);
              $mainRecTypeId = $params['main_modid'];
              $folder = $this -> Common_model-> get_table($mainRecTypeId);
			  $result = $this -> Common_model-> viewrecord_data($params);
			  $recTypeId = $params["modid"];
              $tabName = $this -> Common_model-> get_tabName($recTypeId);
			  $moduleName = $this -> Common_model-> get_moduleName($recTypeId);
			  $tableName = $this -> Common_model-> get_table($recTypeId);
      	      if($result['status'] == 'success'){
					$file_name = 'view-related';
					$data["data"] 			= $result['data'][0];
					$data["files"] 			= $result['files'];
					$data["tabName"]		= $tabName;
					$data["moduleName"]		= $moduleName;
					$data["tableName"]		= $tableName;
					$data["recTypeId"]		= $recTypeId;
					$data["mainRecTypeId"] 	= $mainRecTypeId;
					$this->load->view($file_name, $data);
              } else  {  echo $result['status']; }
      }
      /*
      Delete single sub record
      -------------------------------------------*/
      function deleteSubRecord_post(){
       	  $params = $this->sanitize($this->input->post());
          $module = $params['module'];
          $result = $this -> Common_model-> deleteSubRecord($params);
          echo $result;
      }

     /*
     Add New Record into DB
     ------------------------------------------*/
      function schoolnew_post() {
        $params = $this->sanitize($this->input->post());
		$this -> load -> model('Common/Addrecord_model');
		//print_r($params); die;
		$result = $this -> Addrecord_model -> add_record($params);
	    if($result['status']=='success'){
	       echo $result['rid'];
	    } else{
              echo $result['status'];
        }
      }
     /*
      View Record
      ------------------------------------------*/
      function displayView_post(){
              $params = $this->sanitize($this->input->post());
			  $module = $this->sanitize($params['module']);
              $result = $this -> Common_model-> viewrecord_data($params);
              $this -> load -> model('User_model');
              $emaildata = $this->User_model->useremail();
              $email = json_encode($emaildata['Email']);
			  $recTypeId = $params["modid"];
			  $tabName = $this -> Common_model-> get_tabName($recTypeId);
			  $moduleName = $this -> Common_model-> get_moduleName($recTypeId);
			  $tableName = $this -> Common_model-> get_table($recTypeId);
        if($result['status'] == 'success'){
	       if( isset($params['rel_type_id'])){
                $sub_result = $this -> Common_model-> get_subRecords($params);
                if($sub_result['status'] == 'success'){
                $sub_data = $sub_result['data'];
                $sub_file_count = $sub_result['file_count'];
                $sub_files = $sub_result['subfiles'];
                $sub_rec_id = $sub_result['sub_recordid'];
                }
	      } else { $sub_data = "failed"; }
              $file_name = "view-record";
			  $data["data"]					= $result['data'][0];
			  $data["files"]				= $result['files'];
			  $data["sub_data"]				= $sub_data;
			  $data["file_count"] 			= $sub_file_count;
			  $data["sub_files"]			= $sub_files;
			  $data["sub_rec"]				= $sub_rec_id;
			  $data["email"]				= $email;
			  $data["tabName"]				= $tabName;
			  $data["moduleName"]			= $moduleName;
			  $data["tableName"]			= $tableName;
			  $data["recTypeId"]			= $recTypeId;
			  $data["relatedRecTypeId"] 	= $params['rel_type_id'];

              $this->load->view($file_name, $data);
              } else  {  echo $result['status']; }
      }
      /*
      Download File
      -------------------------------------------*/
      function downloadfile_get() {
        $path =  $this->sanitize($this->input->get('rid'));
        $this -> load -> model('Common/Downloadfile_model');
	  $result = $this -> Downloadfile_model -> download($path);
      }
      function downloadfiles_get() {
        $path =  $this->sanitize($this->input->get('rid'));
        $recordid =  $this->sanitize($this->input->get('id'));
        $this -> load -> model('Common/Downloadfile_model');
        $result = $this -> Downloadfile_model -> download_file($path,$recordid);
      }

	  /*Download File Mongo DB
	  --------------------------------------------*/
	  function viewfile_get(){
		$file_id =  $this->input->get('fid');
		$this -> load -> model('Common/Downloadfile_model');
	    $result = $this -> Downloadfile_model -> mongodownload($file_id);
	  }
      /*
      get Edit record view page
      -------------------------------------------*/
      function editrecord_post() {
        $params = $this->sanitize($this->input->post());
        $record_type_id = $params['page_refer_id'];
        $module = $params['module'];
        $record_id = $params['rid'];
		$tableName = $this -> Common_model-> get_table($record_type_id);
		$tabName = $this -> Common_model-> get_tabName($record_type_id);
		$moduleName = $this -> Common_model-> get_moduleName($record_type_id);
		$this -> load -> model('Getallfields_model');
		$fields = $this -> Getallfields_model -> get_allfields($record_type_id, $user_id, 0);
        if(!empty($tableName) && $tableName != 'failed' ) {
			  $result = $this -> Common_model-> get_editrecord_data($record_id,$record_type_id);
			  $folder_files = $this -> Common_model-> folderfiles($record_type_id);
			  $data["data"]			= $result['data'][0];
			  $data["files"]		= $result['files'];
			  $data["folder"]		= $folder_files['folder'];
			  $data["fields"]		= $fields;
			  $data["tabName"]		= $tabName;
			  $data["moduleName"]	= $moduleName;
			  $data["recTypeId"]	= $record_type_id;
			  $this->load->view('edit-record', $data);
        } else {
        $this->load->view('edit-record', array('data'=> 'No Data'));
        }
      }
      /*
      Update DB with Posted data
      -----------------------------------------*/
      function updatedata_post() {
        $params = $this->sanitize($this->input->post());
		$this -> load -> model('Common/Editrecord_model');
	    $result = $this -> Editrecord_model -> update_record($params);
       echo mongo_json_encode($result);
      }
      /*
      Upload attachments(to be uploaded from edit mode)
      ----------------------------------------------------------*/
      function attachfiles_post(){
		  
            $params = $this->sanitize($this->input->post());
            $record_id = $params['RecordId'];
            $module = $params['module'];
            $record_type_id = $params['record_type_id'];
          if(count($_FILES ?? array())>0) {
			$this -> load -> model('Common/Uploadfile_model');
			$result1 = $this -> Uploadfile_model -> upload_file($params);
            if($result1['data'] == "Success") {
				$tableName = $this -> Common_model-> get_table($record_type_id);
				$tabName = $this -> Common_model-> get_tabName($record_type_id);
				$moduleName = $this -> Common_model-> get_moduleName($record_type_id);
				$this -> load -> model('Getallfields_model');
				$fields = $this -> Getallfields_model -> get_allfields($record_type_id, $user_id, 0);
             if(!empty($tableName) && $tableName != 'failed' ) {
					$result = $this -> Common_model-> get_editrecord_data($record_id,$record_type_id);
					$data["data"]		= $result['data'][0];
					$data["files"]		= $result['files'];
					$data["fields"]		= $fields;
					$data["tabName"]	= $tabName;
					$data["moduleName"]	= $moduleName;
					$data["recTypeId"]	= $record_type_id;
				$this->load->view('edit-record', $data);
             }
           }else  { echo "Failed"; }
         } else { echo "No File Selected"; }
      }
      /*
      Delete single attchment(from Edit mode)
      ------------------------------------------------------*/
      function deleteattachment_post(){
        $params = $this->sanitize($this->input->post());
        $record_type_id = $params['page_refer_id'];
        $record_id = $params['rid'];
        $module = $params['module'];
       if(count($params ?? array())){
        $del_status = $this -> Common_model-> delete_single_rec($params);
          if($del_status['status'] == "Success") {
			$tableName = $this -> Common_model-> get_table($record_type_id);
			$tabName = $this -> Common_model-> get_tabName($record_type_id);
			$moduleName = $this -> Common_model-> get_moduleName($record_type_id);
			$this -> load -> model('Getallfields_model');
			$fields = $this -> Getallfields_model -> get_allfields($record_type_id, $user_id, 0);
             if(!empty($tableName) && $tableName != 'failed' ) {
               $result = $this -> Common_model-> get_editrecord_data($record_id,$record_type_id);
			   $data["data"]		= $result['data'][0];
			   $data["files"]		= $result['files'];
			   $data["fields"]		= $fields;
			   $data["tabName"]		= $tabName;
			   $data["moduleName"]	= $moduleName;
			   $date["recTypeId"]	= $record_type_id;
               $this->load->view('edit-record', $data);
             }
           }else  { echo $del_status['status']; }
       }
      }
      /*
      Delete Entire record with attachments
      --------------------------------------------------*/
      function deleteRecord_post(){
        $cpatcha = $this->session->userdata('captcha');
        $params = $this->sanitize($this->input->post());
        $module = $params['module'];
        if(!empty($params['captcha']) &&  $params['captcha'] == $cpatcha ) {
         $this->session->unset_userdata('captcha');
         $this -> load -> model('Common/Deleterecord_model');
         $result = $this-> Deleterecord_model -> delete_record($params);
          echo "success";
        } else { echo "failed"; }

      }
      /*
      Send Mails
      -----------------------------------------*/
      function mailRecord_post(){
        $params = $this->sanitize($this->input->post());
        $module = $params['module'];
        if(count($params ?? array())){
         $this -> load -> model('Common/Mailrecord_model');
         $result = $this-> Mailrecord_model -> mail_record($params);
         if($result['status'] == 'success') {
           echo $result['status'];
         } else if($result['status'] == 'failed') {
           echo $result['data'];
         }
       } else { echo "No data"; }
      }

      /*
      get Edit record view page
      -------------------------------------------*/
      function getKart_post() {
        $params = $this->sanitize($this->input->post());
        $record_type_id = $params['page_refer_id'];
        $module = $params['module'];
        $record_id = $params['rid'];

		$tableName = $this -> Common_model-> get_table($record_type_id);
        if(!empty($tableName) && $tableName != 'failed' ) {
          $this -> load -> model('Common/Cart_model');
          $result = $this -> Cart_model -> getkart_data($record_id,$record_type_id);
		  $tabName = $this -> Common_model-> get_tabName($record_type_id);
		  $moduleName = $this -> Common_model-> get_moduleName($record_type_id);
		  if($params["rel_type_id"]){
			  $sub_result = $this -> Common_model-> get_subRecords($params);
                if($sub_result['status'] == 'success'){
					$sub_data = $sub_result['data'];
					$sub_file_count = $sub_result['file_count'];
					$sub_files = $sub_result['subfiles'];
					$sub_rec_id = $sub_result['sub_recordid'];
                }
		  }
			$data["names"]		= $result['kartNames'];
			$data["files"]		= $result['files'];
			$data["tabName"]	= $tabName;
			$data["moduleName"]	= $moduleName;
			$data["recTypeId"]	= $record_type_id;
			$data["sub_files"]	= $sub_files;
		  $this->load->view('addkart', $data);
        } else {
        $this->load->view('addkart', array('data'=> 'No Data'));
        }
      }
      /*
      Add to cart
      -------------------------------------------*/
      function saveToCart_post(){
		     $params = $this->sanitize($this->input->post());
              $this -> load -> model('Common/Cart_model');
     	      $result = $this-> Cart_model-> savetocart($params);
              echo $result['status'];
      }
      /*
      Dcart page
      ---------------------------------------*/
      function dKart_post(){
             $this -> load -> model('Common/Cart_model');
             $this -> load -> model('User_model');
              $emaildata = $this->User_model->useremail();
              $email = json_encode($emaildata['Email']);
			  $result = $this-> Cart_model-> dcart_data();
			  $data["names"]	= $result['cart_names'];
			  $data["cdata"]	= $result['data'];
			  $data["email"]	= $email;
             $this->load->view('dcart', $data);
      }

      /*
      Get data based on cartname
      ------------------------------------------*/
      function cartdata_post(){
	      $cartName = $this->sanitize($this->post('cName'));
              $this -> load -> model('Common/Cart_model');
     	      $result = $this-> Cart_model-> cname_data($cartName);
			  $data["cdata"]	= $result['data'];
              $this->load->view('includes/include_cart_content', $data);
      }
      /*
      Send Mails from Cart
      -----------------------------------------*/
      function mailCartRecord_post(){
        $params = $this->sanitize($this->input->post());
        $module = $params['module'];
        if(count($params ?? array())){
         $this -> load -> model('Common/Mailcartitems_model');
         $result = $this-> Mailcartitems_model-> mail_from_cart($params);
         if($result['status'] == 'success') {
           echo $result['status'];
         } else if($result['status'] == 'failed') {
           echo $result['data'];
         }
       } else { echo "No data"; }
      }
      /*
      Delete Cart files
      ------------------------------------------*/
        function deleteCartRecord_post(){
        $cpatcha = $this->session->userdata('cart_captcha');
        $params = $this->sanitize($this->input->post());
        if(!empty($params['captcha']) &&  $params['captcha'] == $cpatcha ) {
         $this->session->unset_userdata('captcha');
         $this -> load -> model('Common/Cart_model');
         $result = $this-> Cart_model-> delete_record($params);
          echo $result;
        } else { echo "failed"; }

      }
	   /*
      Delete Cart folder
      ------------------------------------------*/
        function deleteCartdata_post(){
             $params = $this->sanitize($this->input->post());
             $this -> load -> model('Common/Cart_model');
             $result = $this-> Cart_model-> delete_cart_record($params);
             echo $result;
      }
      /*
      Account Settings page
      ----------------------------------*/
     function settings_post(){
             $params = $this->sanitize($this->input->post());
				$module = $params['module'];
                $this -> load -> model('Global/Settings_model');
                $result = $this-> Settings_model -> get_settings_data($module);
				$data["settings"]	= $result['data'];
				$data["module"]		= $module;
			$this->load->view('settings', $data);

      }
	  /*
	  bookjmarks
	  --------------------------------*/
	  function bookmarks_post(){
	          $params= $this->sanitize($this->input->post());
		      $this -> load -> model('Global/Folder_model');
              $result = $this-> Folder_model -> folder_data($params);
              $bookmarkresult = $this-> Folder_model -> bookmark_data($params);
			  $data["param"]	= $params;
			  $data["bookmark"]	= $bookmarkresult['bookmarksdata'];
			$this->load->view("includes/bookmark", $data);
	  }
      /*
      Fetch Settings data based on module selection
      -----------------------------------------------*/
      function getsettings_data_post(){
			$params = $this->sanitize($this->input->post());
				$module = $params['module'];
                $this -> load -> model('Global/Settings_model');
                $result = $this-> Settings_model -> get_settings_data($module);
				$data["settings"]	= $result['data'];
				$data["module"]		= $module;
			$this->load->view('includes/include_settings', $data);
		}

      /*
      Save Settings
      --------------------------------------------------*/
      function updateSettings_post(){
            $params = $this->sanitize($this->input->post());
                 $this -> load -> model('Global/Settings_model');
                 echo $result = $this-> Settings_model -> updateSettings($params);
      }

      /*
      Get Folder Page
      ---------------------------------------------------*/
      function getFolder_post(){
			$params= $this->sanitize($this->input->post());
			$this -> load -> model('Global/Folder_model');
			$this -> load -> model('User_model');
			$emaildata = $this->User_model->useremail();
			$email = json_encode($emaildata['Email']);
			$result = $this-> Folder_model -> folder_data($params);
			$bookmarkresult = $this-> Folder_model -> bookmark_data($params);
			$data["param"]		= $params;
			$data["files"]		= $result['files'];
			$data["bookmark"]	= $bookmarkresult['bookmarksdata'];
			$data["email"]		= $email;
			$this->load->view("includes/folder", $data);
      }
      /*
      uploadfolderfiles
      --------------------------------------------------*/
      function uploadfolderfiles_post(){
	      $params= $this->sanitize($this->input->post());
		  //echo "<pre>";print_r($params); die;
		  $folder_id = $params['foldid'];
		  $type_id = $params['typeId'];
		  $module = $params['module'];
          $this -> load -> model('Global/Folder_model');
          $result = $this-> Folder_model -> uploadfile($params);
		  $this -> load -> model('Global/Folder_model');
		  $data = $this->Folder_model->getfolderfilesdata($folder_id,$type_id,$module);
		  $filesData["files"]		= $data['ff'];
		  $filesData["fpath"]		= $data['fdetails'];
		  $filesData["param"]		= $data;
		  $filesData["module"]		= $module;
		  $filesData["status"]		= $result['status'];
		  $filesData["folid"]		= $folder_id;
		  if($params["isFromExternal"]){
			  echo "success";
		  }else{
			$this->load->view('includes/folder', $filesData);
		  }
      }
      /*
      Delete Files from Folder
      -----------------------------------------------*/
      function deleteFolderFile_post(){
           $cpatcha = $this->session->userdata('folder_captcha');
           $params = $this->sanitize($this->input->post());
           if(!empty($params['captcha']) &&  $params['captcha'] == $cpatcha ) {
			 $this->session->unset_userdata('captcha');
	         $this -> load -> model('Global/Folder_model');
	         $result = $this-> Folder_model -> delete_file($params);
	          echo $result;
	    } else { echo "failed"; }
      }
	  function deletebookmarks_post(){
           $cpatcha = $this->session->userdata('folder_captcha');
           $params = $this->sanitize($this->input->post());
           if(!empty($params['captcha']) &&  $params['captcha'] == $cpatcha ) {
	         $this->session->unset_userdata('captcha');
	         $this -> load -> model('Global/Folder_model');
	         $result = $this-> Folder_model -> delete_bookmark($params);
	          echo $result;
	    } else { echo "failed"; }
      }

      /*
      Send Mails from Folder
      -----------------------------------------*/
      function mailFolderRecord_post(){
        $params = $this->sanitize($this->input->post());
       if(count($params ?? array())){
         $this -> load -> model('Global/Mailfolderfiles_model');
         $result = $this-> Mailfolderfiles_model -> mail_from_folder($params);
         if($result['status'] == 'success') {
           echo $result['status'];
         } else if($result['status'] == 'failed') {
           echo $result['data'];
         }
       } else { echo "No data"; }
      }
	        /*
      Send Mails from bookmarks
      -----------------------------------------*/
      function mailbookmarkRecord_post(){
        $params = $this->sanitize($this->input->post());
       if(count($params ?? array())){
         $this -> load -> model('Global/Mailfolderfiles_model');
         $result = $this-> Mailfolderfiles_model -> mail_from_bookmarks($params);
         if($result['status'] == 'success') {
           echo $result['status'];
         } else if($result['status'] == 'failed') {
           echo $result['data'];
         }
       } else { echo "No data"; }
      }
      /*
       Log Page
      ----------------------------------------*/
         function getlog_post(){
            $params = $this->input->post();
            $this -> load -> model('Global/Log_model');
            $result = $this-> Log_model -> log_data($params);
			$data["data"]		= $result['log'];
			$data["e_name"]		= $result['e_name'];
            $this->load->view('includes/log', $data);
         }
		 function getlog_get(){
            $params = $this->input->get();
            $this -> load -> model('Global/Log_model');
            $result = $this-> Log_model -> log_data($params);
				$result["data"] = $result['e_name'];
              $result["data"] = $result['log'];
			  echo $response = mongo_json_encode($result["data"]);

         }
       /*
        Account Summary
       ---------------------------------------------- */
       function accSummary_post() {
           $this->load->model('Global/Summary_model');
           $result = $this->Summary_model->getuserinfo();
           $data["data"]	= $result;
           $this->load->view("includes/acc_summary", $data);

       }
       function updateuserinfo_post(){
           $params = $this->input->post();
           $this->load->model('Global/Summary_model');
           $this->Summary_model->user_info_update($params);
           $result = $this->Summary_model->getuserinfo();
		   $data["data"]	= $result;
           $this->load->view("includes/acc_summary", $data);
       }
        /***
        Logout
        ***/
        public function logout_get() {
                $data = array('user_id', 'email');
                $this->session->unset_userdata($data);
                session_destroy();
    		//log_message('info','logged out');
                $this->load->view('index');
       	}



        function screenshot_post(){
          $params = $this->input->post();
          $this->load->model("Login_model");
          $result = $this->Login_model->screenshot($params);
          echo $result["path"];
        }
        function article_get(){
			$this->load->model('Global/Articles_view_model');
			$result = $this->Articles_view_model->getarticleinfo();
			$data["data"] = $result;
            $this->load->view("includes/article", $data);
		}
        function article_edit_get(){
			$params = $this->input->get('id');
			$this->load->model('Global/Articles_view_model');
			$result = $this->Articles_view_model->getarticleinfoedit($params);
			$data["data"]	= $result['articleinfo'];
            $this->load->view("includes/article_edit", $data);
         }
        function articleimage_post(){
           $this->load->model('Global/Articles_images_model');
           $result = $this->Articles_images_model->articleimage();
           $path = $result["path"];
           echo $path;
        }
        function article_update_post(){
			$params = $this->input->post();
			$this->load->model('Global/Articles_view_model');
			$this->Articles_view_model->articleupdate($params);
			$result = $this->Articles_view_model->getarticleinfo();
			$data["data"]	= $result;
			$this->load->view("includes/article", $data);
         }
        function article_post(){
           $params = $this->input->post();
           $this->load->model('Global/Articles_model');
           $this->Articles_model->articles_info_data($params);
           $result = $this->Articles_model->getuserinfo();
		   $data["data"]	= $result;
           $this->load->view("includes/article", $data);
        }
        function extension_get(){
           $user_id = $this->input->get('uid');
           $user_id = $user_id/7897987;
           $this->session->set_userdata( array("user_id"=>$user_id));
           $module = $this->sanitize($this->input->get('module'));
           $recTypeId = $this->sanitize($this->input->get('rid'));
		   $this->load->view("template", array("module"=>$module, "rid"=>$recTypeId));
		}


	    function createfolder_post(){
			$params = $this->input->post();
			$folder_name = $params["folder_name"];
			$folder_id = $params["folder_id"];
			$type_id = $params["typeId"];
			$module = $params["module"];
			$this -> load -> model('Global/Folder_model');
			$result = $this->Folder_model->createfolder($params);
			$data = $this->Folder_model->getfolderfilesdata($folder_id,$type_id,$module);
			$folderData["files"]	= $data['ff'];
			$folderData["fpath"]	= $data['fdetails'];
			$folderData["param"]	= $data;
			$folderData["folid"]	= $folder_id;
			$this->load->view('includes/folder', $folderData);
	    }
		function createdfolder_get(){
			$folder_id = $this->input->get('id');
			$type_id = $this->input->get('typeId');
			$module = $this->input->get('module');
			$this -> load -> model('Global/Folder_model');
			$data = $this->Folder_model->getfolderfilesdata($folder_id,$type_id,$module);
			$folderData["files"]	= $data['ff'];
			$folderData["fpath"]	= $data['fdetails'];
			$folderData["param"]	= $data;
			$folderData["folid"]	= $flder_id;
			$this->load->view('includes/folder', $folderData);

		}

		/* Print Preview */
		function previewdata_get() {
			$id = $this->input->get('id');
			$path = $this->input->get('path');
			$filetype = $this->input->get('filetype');
			$params = $this->input->get();
			$filename = $this->input->get('filename');
            $this -> load -> model('Global/Folder_model');
            $data = $this->Folder_model->getmapsdata();
			$printData["id"]		= $id;
			$printData["path"]		= $path;
			$printData["filetype"]	= $filetype;
			$printData["data"]		= $data;
			$printData["filename"]	= $filename;
			$this->load->view("includes/Preview", $printData);
		}

        function confirmationprint_post() {
            $params = $this->input->post();
			$this -> load -> model('Global/Folder_model');
			$data = $this->Folder_model->pageinfo($params);
			$printData["params"]	= $params;
			$printData["OrderId"]	= $data['OrderId'];
			$printData["Cost"]		= $data['cost'];
			$this->load->view("includes/paymentconfirmationpage", $printData);
        }

		function confirmationprint_get() {
			$params = $this->input->get();
			$color = $this->input->get('color');
			$this -> load -> model('Global/Folder_model');
			$data = $this->Folder_model->colorselection($params);
			echo $data['cost'];
        }

		/*** Location Search in Maps ****/
		function locationsearch_post() {
			$params = $this->input->post();
			$this -> load -> model('Global/Folder_model');
			$data = $this->Folder_model->locationsearchdata($params);
			$location = $data['location'];
			$locationData["data"]		= $data['data'];
			$locationData["location"]	= $location;
			$this->load->view("includes/map", $locationData);
		}

    function collaboraterecord_post(){
      $params = $this->input->post();
      $this -> load -> model('Common/Common_model');
      $data = $this->Common_model->collaboration($params);
      if($data['status'] == 'success') {
           echo $data['status'];
         } else if($data['status'] == 'failed') {
           echo $data['data'];
         }
        else { echo "No data"; }
    }
    function articleinfo_get(){
      $params = $this->input->get();
      $id = $params['id'];
      $this->load->view("article",$id);
    }

	/* Confirmation Page(Check Out) */
	function printcheckoutpage_post(){
	    $params = $this->input->post();
		$this->session->set_userdata($params);
		$this -> load -> model('Global/Folder_model');
		$cost = $this->Folder_model->pageinfo($params);
		$data["cost"]		= $cost;
		$data["filename"]	= $params["filename"];
		$data["description"]= $params["description"];
		$data["print_type"]	= $params["print_type"];
		$data["ProjectPageNos"] = $params["ProjectPageNos"];
		$this->load->view("includes/paymentconfirmationpage", $data);
	}

	function docviewer_get(){
		$fid = $this->input->get('fid');
		$type = $this->input->get('type');
		$filename = $this->input->get('filename');
		$typeId = $this->input->get('typeId');
		$module = $this->input->get('module');
		$uid = $this->input->get('uid');
		$name = $this->input->get('name');
		$isPrint = $this->input->get('isPrint');
		if($name){
			$this->session->set_userdata("name",$name);
		}
		if($uid){
			$this->session->set_userdata("user_id",$uid);
		}
		$data["fid"]		= $fid;
		$data["type"]		= $type;
		$data["filename"]	= $filename;
		$data["typeId"]		= $typeId;
		$data["module"]		= $module;
		$data["isPrint"]    = $isPrint;
		$this->load->view("includes/docviewer", $data);
	}
  function fileviewer_get(){
    $fid = $this->input->get('fid');
    $type = $this->input->get('type');
    $filename = $this->input->get('filename');
    $typeId = $this->input->get('typeId');
    $module = $this->input->get('module');
    $uid = $this->input->get('uid');
    $name = $this->input->get('name');
    $isPrint = $this->input->get('isPrint');
    if($name){
      $this->session->set_userdata("name",$name);
    }
    if($uid){
      $this->session->set_userdata("user_id",$uid);
    }
    $data["fid"]		= $fid;
    $data["type"]		= $type;
    $data["filename"]	= $filename;
    $data["typeId"]		= $typeId;
    $data["module"]		= $module;
    $data["isPrint"]    = $isPrint;
    $this->load->view("includes/fileviewer", $data);
  }

	function ReadFileWithOCR_get(){
			$user_id = $this->input->cookie('user_id',TRUE);
			$recTypeId = $this->input->cookie('screenshort_record_id',TRUE);
			$fileURL = $this->input->get("fileURL");
			$this -> load -> model('Common_model');
			$tabName = $this -> Common_model-> get_tabName($recTypeId);
			$moduleName = $this -> Common_model-> get_moduleName($recTypeId);
			$this -> load -> model('Getallfields_model');
		    $fields = $this -> Getallfields_model -> get_allfields($recTypeId, $user_id, 0);
			$file_name = 'create';
			//echo "<pre>";print_r($data); die;
			$this->load->view('template',array("module"=>$moduleName, "rid"=>$recTypeId));
	}

	function OcrReader($fileURL){
		    $fileURL = "https://".$_SERVER['HTTP_HOST']."/".$fileURL;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://api.ocr.space/Parse/Image");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "isOverlayRequired=true&url=$fileURL&language=eng");
			curl_setopt($ch, CURLOPT_POST, 1);
            $headers = array();
			$headers[] = "Apikey: a75232244b88957";
			$headers[] = "Content-Type: application/x-www-form-urlencoded";
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$result = curl_exec($ch);
			if (curl_errno($ch)) {
				echo 'Error:' . curl_error($ch);
			}
			curl_close ($ch);
			return $result;

	}
	function object_2_array($result){
			$array = array();
			foreach ($result as $key=>$value)
			{
			   # if $value is an array then
				if (is_array($value))
				{
					#you are feeding an array to object_2_array function it could potentially be a perpetual loop.
					$array[$key]=$this->object_2_array($value);
				}

			   # if $value is not an array then (it also includes objects)
				else
				{
				   # if $value is an object then
					if (is_object($value)){
						$array[$key]=$this->object_2_array($value);
					} else {
						$array[$key]=$value;
					}
				}
			}
			return $array;
	}

	function getPrintHistory_get(){
		$user_id = trim($this->session->userdata('user_id'));
		$this -> load -> model('Global/Folder_model');
		$data["PrintHistory"] = $this->Folder_model->getPrintHistory($user_id);
		//echo "<pre>";print_r($printHistory); die;
		$this->load->view("print_history_view", $data);
	}
	function aboutus_get(){
		$this->load->view("about_us_view");
	}
	function privacy_get(){
		$this->load->view("privacy_view");
	}
	function terms_get(){
		$this->load->view("terms_view");
	}
	function cancellation_get(){
		$this->load->view("cancellation_policy_view");
	}
	function contactus_get(){
		$this->load->view("contact_us_view");
	}
	function mailtest_get(){
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
			
			$this->email->to('chaithanyakondragunta@gmail.com');
			if($cc){
				$this->email->cc($cc);
			}
			$this->email->from('admin@publishat.com');
			$this->email->subject("$subject");
			$this->email->message($message);

			//Send email
			if($this->email->send()){
			
			}else{
			   //Email Failed To Send
			   echo "<pre>"; print_r($this->email->print_debugger()); die;;
			}
		
	}
}

/* End of file Web.php */
/* Location: ./application/controllers/Web.php */
