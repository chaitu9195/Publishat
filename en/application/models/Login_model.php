<?php

date_default_timezone_set('Asia/Kolkata');
class Login_model extends CI_Model
{
    public function login_check($params)
    {
        $this->load->database();

        $validationCheck = $this->validate_parameters($params);

        if ($validationCheck) {
            $uemail = $params['userlogin'];
            $pwd = md5($params['userpassword']);
            $query = $this->db->query('SELECT * FROM  ' . TBL_USER . " WHERE Email = '$uemail' AND Password = '$pwd' ");
            if ($query->num_rows() > 0) {
                $result = $query->row_array();
                return ['status' => 'success','data' => $result];
            } else {
                return ['status' => 'failed','data' => 'Invalid Credentials'];
            }
        } else {
            return ['status' => 'failed','data' => 'All fields are mandatory'];
        }
    }

    public function validate_parameters($params)
    {
        if (!empty($params['userlogin']) && !empty($params['userpassword'])) {
            return true;
        } else {
            return  false;
        }
    }

    public function check_email_id_exist($params)
    {
        $this->load->database();
        $email_id = $params['PersonalEmail'];
        $sql = 'SELECT * FROM ' . TBL_USER . " WHERE Email = '$email_id' ";
        $res = $this->db->query($sql);
        if ($res->num_rows() > 0) {
            $userdata = $res->row_array();
            return ['status' => 'success','data' => $userdata['UserId']];
        }
        return ['status' => 'failed'];
    }

    public function screenshot($params)
    {
        $img_content = $params['img_content'];
        $file = md5(uniqid()) . '.png';
        $uri = substr($img_content, strpos($img_content, ',') + 1);
        file_put_contents('../../screenshots/' . $file, base64_decode($uri));
        $file_path = 'screenshots/' . $file;
        return ['path' => $file_path];
    }

    public function upgradeStatus($user_id)
    {
        $this->mongodb->where(['UserId' => mongo_id($user_id)]);
        $query = $this->mongodb->get(TBL_USER);
        $Upgraded = $query[0]['Upgraded'];
        return $Upgraded;
    }
}
