<?php

require APPPATH . '/libraries/REST_Controller.php';
class Thirdparty extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Common/Common_model');
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        $this->load->library('mongo_db', ['activate' => 'newdb'], 'mongodb');
    }

    public function gcontacts_get()
    {
        $accesstoken = '';
        $client_id = '298801891056-boiv3nlutpsqfdurfidvd9aktsiaditb.apps.googleusercontent.com';
        $client_secret = 'qkc-OnA6UrBTiyGSDuo6_J2E';
        $redirect_uri = 'https://www.publishat.com/digital/en/Thirdparty/gcontacts';

        $max_results = 10000;
        $auth_code = $_GET['code'];

        $fields = [
            'code' => urlencode($auth_code),
            'client_id' => urlencode($client_id),
            'client_secret' => urlencode($client_secret),
            'redirect_uri' => urlencode($redirect_uri),
            'grant_type' => urlencode('authorization_code'),
        ];
        $post = '';
        foreach ($fields as $key => $value) {
            $post .= $key . '=' . $value . '&';
        }
        $post = rtrim($post, '&');

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
        curl_setopt($curl, CURLOPT_POST, 5);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $result = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($result);
        if (isset($response->access_token)) {
            $accesstoken = $response->access_token;
            $_SESSION['access_token'] = $response->access_token;
        }

        if (isset($_GET['code'])) {
            $accesstoken = $_SESSION['access_token'];
        }

        if (isset($_REQUEST['logout'])) {
            unset($_SESSION['access_token']);
        }

        $url =
            'https://www.google.com/m8/feeds/contacts/default/full?max-results=' .
            $max_results .
            '&alt=json&v=3.0&oauth_token=' .
            $accesstoken;
        $xmlresponse = $this->curl_file_get_contents($url);

        $contacts = json_decode($xmlresponse, true);

        $return = [];
        if (!empty($contacts['feed']['entry'])) {
            foreach ($contacts['feed']['entry'] as $contact) {
                $return[] = [
                    'name' => $contact['title']['$t'],
                    'email' => $contact['gd$email'][0]['address'],
                ];
            }
        }

        $google_contacts = $return;

        unset($_SESSION['google_code']);
        foreach ($google_contacts as $contact) {
            $name = $contact['name'];
            $email = $contact['email'];
            if ($name == '') {
                $name_arr = explode('@', $email);
                $name = $name_arr[0];
            }

            $this->load->model('Global/Thirdpartylogin_model');
            $result = $this->Thirdpartylogin_model->google_contacts($name, $email);
        }

        header('Location: https://www.publishat.com/digital/en/web/records?page_id=14&module=professional');
    }

    public function gpicker_post()
    {
        $params = $this->input->post();
        $folder_id = $params['foldid'];
        $type_id = $params['recordtypeid'];
        $module = $params['module'];
        $this->load->model('Global/Thirdpartylogin_model');
        $result = $this->Thirdpartylogin_model->gpicker($params);
        $this->load->model('Global/Folder_model');
        $data = $this->Folder_model->getfolderfilesdata($folder_id, $type_id, $module);
        $this->load->view('includes/folder', [
            'files' => $data['ff'],
            'fpath' => $data['fdetails'],
            'param' => $data,
            'status' => 'success',
            'folid' => $folder_id,
        ]);
    }
    public function curl_file_get_contents($url)
    {
        $curl = curl_init();
        $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $contents = curl_exec($curl);
        curl_close($curl);
        return $contents;
    }
}
