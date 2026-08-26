<?php
require (APPPATH . '/libraries/REST_Controller.php');
class Signup extends REST_Controller {

      public function __construct()
	{
	  parent::__construct();
            $this->load->database();
			$this->load->library('session');
            $user_id = $this->session->userdata('user_id'); 
        }
        

        function index_get() {
		$this->load->view('index');
 
         }

	function signup_get() {
                $this->load->view('signup');
	}
        function updateuserinfo_get() {
              $this->load->view('updateuserinfo');
	}
        function updateuserinfo_post() {
            $params = $this->sanitize($this->input->post());
            $this -> load -> model('Global/Signup_model');
            $result = $this -> Signup_model -> updateuserinfo($params);
            if($result['status'] == "success"){
                header("Location: https://publishat.com/restapp/en/web/records");
            }
	}
        
        function emailconfirm_get(){
            $this->load->view('emailconfirm');
        } 
        function signup_post(){
          $params = $this->sanitize($this->input->post());
          $this -> load -> model('Global/Signup_model');
          $result = $this -> Signup_model -> signup($params);
          if($result['status'] == "success"){
             $this->load->view("emailconfirm");
          }
          else{
             $this->load->view("signup",array("status"=>"error"));
          }          
        }
       function googleoauth_get(){
             // Modern google/apiclient flow (replaces the retired bundled Google_Client).
             $gClient = google_oauth_client();

             if (!isset($_GET['code'])) {
                 header('Location: ' . $gClient->createAuthUrl());
                 return;
             }

             $token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
             if (isset($token['error'])) {
                 log_message('error', 'Google OAuth: ' . $token['error']);
                 $this->load->view('signup', array("status" => "error"));
                 return;
             }
             $gClient->setAccessToken($token);

             $oauth2 = new \Google\Service\Oauth2($gClient);
             $user   = $oauth2->userinfo->get();
             $email  = filter_var($user->email, FILTER_SANITIZE_EMAIL);

             $this -> load -> model('Global/Thirdpartylogin_model');
             $result = $this -> Thirdpartylogin_model -> google_oauth($email);
             if($result['status']=="success"){
                 $userarray = array(
                     'user_id' => $result['data']['UserId'],
                     'name' => $result['data']['Name'],
                     'email' => $result['data']['Email'],
                 );
                 $this->session->set_userdata( $userarray );
                 header("Location: https://publishat.com/restapp/en/web/records");
             }
       }
}
/* End of file Signup.php */
/* Location: ./application/controllers/Login.php */