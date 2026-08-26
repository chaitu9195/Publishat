<?php

require APPPATH . '/libraries/REST_Controller.php';
class Login extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        $this->load->library('mongo_db', ['activate' => 'newdb'], 'mongodb');
    }

    public function index_get()
    {
        $this->load->view('index');
    }

    public function login_post()
    {
        $params = $this->sanitize($this->input->post());
        $this->load->model('Login_model');
        $result = $this->Login_model->login_check($params);

        if ($result['status'] == 'success') {
            $userarray = [
                'user_id' => $result['data']['UserId'],
                'name' => $result['data']['Name'],
                'email' => $result['data']['Email'],
            ];
            $this->session->set_userdata($userarray);

            redirect('web/index');
        } else {
            $this->load->view('index', ['failed' => 1, 'data' => $result['data']]);
        }
    }

    public function googleoauth_get()
    {
        $gClient = google_oauth_client();

        if (!isset($_GET['code'])) {
            header('Location: ' . $gClient->createAuthUrl());
            return;
        }

        $token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
        if (isset($token['error'])) {
            log_message('error', 'Google OAuth: ' . $token['error']);
            $this->load->view('index', ['failed' => 1, 'data' => 'Google sign-in failed.']);
            return;
        }
        $gClient->setAccessToken($token);

        $oauth2 = new \Google\Service\Oauth2($gClient);
        $user = $oauth2->userinfo->get();
        $email = filter_var($user->email, FILTER_SANITIZE_EMAIL);
        $user_name = filter_var($user->name, FILTER_SANITIZE_SPECIAL_CHARS);
        $gender = '';

        $this->load->model('Global/Thirdpartylogin_model');
        $result = $this->Thirdpartylogin_model->google_oauth($email, $user_name, $gender);

        $userarray = [
            'user_id' => $result['data']['UserId'],
            'name' => $result['data']['Name'],
            'email' => $result['data']['Email'],
            'address' => $result['data']['Address'],
            'Upgraded' => $result['data']['Upgraded'],
        ];
        $this->session->set_userdata($userarray);

        if ($result['status'] == 'success' || $result['status'] == 'oauth') {
            header('Location: ' . base_url() . 'web/records');
        }
    }
}
