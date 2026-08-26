<?php
require (APPPATH . '/libraries/REST_Controller.php');
class AdminController extends REST_Controller {
/*functions for login module*/
	
		public function __construct()
		{
			parent::__construct();
			$this->load->database();

		}
	 
	    function login_get() {
	    	$this->load->view('adminhome');
	    }
	 
	    function login_post() {
	    	$this -> load -> model('Login_model');
	    	$result = $this -> Login_model -> login_check($this->post());
	    	//$this->response($result,200);
	    	if($result['status']=="success"){
	    		$userarray = array(
	    			'user_id' => $result['data']['UserId'],
	    			'name' => $result['data']['Name'],
	    			'email' => $result['data']['Email'],
	    		);
	    		$this->session->set_userdata( $userarray );
	    		
	    		$users = $this->db->query("SELECT count(*) FROM ".TBL_USER." ");
	    		$usercount = $users->row_array();
	    		$this->load->view('dashboard',array("data"=>"status","usercount"=>$usercount));
	    	}
	    	else{
	    		$this->load->view('adminhome',array("failed"=>1));
	    	}
	    }

	    function getdashboard_get(){
			if ($this->session->userdata('user_id')=='') {
				redirect('AdminController/login');
			}

			$users = $this->db->query("SELECT count(*) FROM ".TBL_USER." ");
			$usercount = $users->row_array();
			
			$this->load->view('dashboard',array("data"=>"status","usercount"=>$usercount));
	    }

	    function getcontacts_get(){
	    	if ($this->session->userdata('user_id')=='') {
	    		redirect('AdminController/login');
	    	}
	    	$users = $this->db->query("SELECT count(*) FROM ".TBL_USER_VENDOR." WHERE VendorId = '2' ");
	    	$usercount = $users->row_array();
	    	$this->load->view('contacts',array("usercount"=>$usercount));
	    }
            function getmessages_get(){
	    	if ($this->session->userdata('user_id')=='') {
	    		redirect('AdminController/login');
	    	}
	    	$users = $this->db->query("SELECT count(*) FROM ".TBL_USER_VENDOR." WHERE VendorId = '2' ");
	    	$usercount = $users->row_array();
                $user_id = $this->session->userdata('user_id');
                $groupname= $this->db->query("SELECT * FROM ".TBL_GROUPNAMES." WHERE UserId ='$user_id' AND GroupName != ''");
	    	$group_names= $groupname->result_array();
                 $this->load->view('messages',array("usercount"=>$usercount,"group_names"=>$group_names));
                   
                
	    }

	    function addcontact_post(){
	    	if ($this->session->userdata('user_id')=='') {
	    		redirect('AdminController/login');
	    	}
	    	$result;
	    	$params = $this->post();
	    	$params['UserLoginType'] = 4;
	    	$this -> load -> model('Login_model');
    		$emailCheck = $this-> Login_model -> check_email_id_exist($params);
    		if($emailCheck['status']=="failed"){
				$this -> load -> model('Signup_model');
				$emailCheck = $this -> Signup_model -> sign_up($params);
				if($emailCheck['status']=='failed'){
					$result = "failed";
				}
			}
			$params['UserId'] = $emailCheck['data'];
			if(!empty($params['UserId'])){

				$this-> load -> model('User_model');
				$userrelation = $this -> User_model -> checkuservendorrelation($params['UserId']);

				$this-> load -> model('Addcontact_model');
				$result = $this -> Addcontact_model -> addnewcontact($params);
			}
			else{
				$result = "failed";
			}
			
			$users = $this->db->query("SELECT count(*) FROM ".TBL_USER_VENDOR." WHERE VendorId = '2' ");
			$usercount = $users->row_array();
			
			$this->load->view('contacts',array("status"=>$result,"usercount"=>$usercount));	    	
	    }

/*------------------------------function to get emaillist based on dropdown selection in messages view------------*/
            function getuser_get(){
                 $q = $_GET['q'];
                 $user_id = $this->session->userdata('user_id');
             	 $wish_email = $this->db->query("SELECT * FROM ".TBL_CONTACTS." WHERE GroupName = '$q' AND (PersonalEmail != '' || OfficeEmail != '') AND UserId = '$user_id' ");
                 $user_count = $wish_email->result_array();
                 $i = 1;
                 $cnt = $wish_email->num_rows();
                 $cnt1 = $cnt - 1;
                 if($wish_email->num_rows()>0){ 
                 foreach($user_count as $user1){
                    $pe = $user1['PersonalEmail'];
                    $oe = $user1['OfficeEmail']; 
                   if($i <= $cnt1){
                                     if(!empty($pe)){ echo $user1['PersonalEmail'].",";  }
                                     else {  echo $user1['OfficeEmail'].","; }
                     }
                   else { 
                                     if(!empty($pe)){   echo $user1['PersonalEmail'];  }
                                     else {    echo $user1['OfficeEmail']; }
                      }
                     $i++;                 
                 }  //end of foreach
            }//end of top if
            else {
                    echo "No emails found"; }//else end
            }//main if(getmessages_get()) end 
            
              function getcertificates_get(){
	    	if ($this->session->userdata('user_id')=='') {
	    		redirect('AdminController/login');
	    	}

	    	$this -> load -> model('User_model');
	    	$result = $this -> User_model -> get_contactsdata();

	    	$this->load->view('certificates',array("result"=>$result));
	    }      
  
	    function UploadCertificate_post(){
	    	if ($this->session->userdata('user_id')=='') {
	    		redirect('AdminController/login');
	    	}
	    	$this -> load -> model('Certification_modal');
	    	$status = $this -> Certification_modal -> uploadcertificate($this->post());
	    	$this -> load -> model('User_model');
	    	$result = $this -> User_model -> get_contactsdata();
	    	$this->load->view('certificates',array("result"=>$result,"status"=>$status));
	    }

	    function uploadandreadExcel_post(){
	    	/*if ($this->session->userdata('user_id')=='') {
	    		redirect('AdminController/login');
	    	}*/
	    	$this -> load -> model('User_model');
	    	$resultArray = $this -> User_model -> readexcel($this->post());
	    	//$this->response($resultArray,200);
	    	foreach ($resultArray as $params) {
	    		# code...
	    		//$this->response($params,200);
		    	$result;
		    	//$params = $this->post();
		    	$params['UserLoginType'] = 4;
		    	$this -> load -> model('Login_model');
	    		$emailCheck = $this-> Login_model -> check_email_id_exist($params);
	    		if($emailCheck['status']=="failed"){
					$this -> load -> model('Signup_model');
					$emailCheck = $this -> Signup_model -> sign_up($params);
					if($emailCheck['status']=='failed'){
						$result = "failed";
					}
				}
				$params['UserId'] = $emailCheck['data'];
				if(!empty($params['UserId'])){

					$this-> load -> model('User_model');
					$userrelation = $this -> User_model -> checkuservendorrelation($params['UserId']);

					$this-> load -> model('Addcontact_model');
					$result = $this -> Addcontact_model -> addnewcontact($params);
				}
				else{
					$result = "failed";
				}
	    	}
	    	$users = $this->db->query("SELECT count(*) FROM ".TBL_USER_VENDOR." WHERE VendorId = '2' ");
	    	$usercount = $users->row_array();
	    	
	    	//$this->load->view('contacts',array("status"=>$result,"usercount"=>$usercount));
	    	$this->response($result,200);
	    }

       	public function logout_get() {
           $data = array('user_id', 'email');
           $this->session->unset_userdata($data);
    		log_message('info','logged out');
           redirect('AdminController/login');
       	}
          


             function addmessages_post(){
	    	if ($this->session->userdata('user_id')=='') {
	    		redirect('AdminController/login');
	    	}
	    	 $result;
	         $params = $this->post();
                 $this -> load -> model('Message_model');
                 $emailCheck = $this-> Message_model-> message_sent($params);
                 $users = $this->db->query("SELECT count(*) FROM ".TBL_USER_VENDOR." WHERE VendorId = '2' ");
		 $usercount = $users->row_array();
                 $this->load->view('messages',array("status"=>$emailCheck,"usercount"=>$usercount));
                  
               }


}

/* End of file AdminController.php */
/* Location: ./application/controllers/AdminController.php */




