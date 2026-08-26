<?php

class Test extends CI_Controller
{
    public function Login($email = 0, $password = 0)
    {
        $email = $_POST['email'] ?? $email;
        $password = $_POST['password'] ?? $password;
        $data['email'] = $email;
        $data['password'] = $password;
        if ($email && $password) {
            $data['status'] = 'success';
            $data['message'] = 'Successfully LoggedIn';
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Email and Password are mandatory';
        }
        echo json_encode($data);
    }
}
