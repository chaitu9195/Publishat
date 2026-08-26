<?php

class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function Module()
    {
        $wsData = [];
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $Status = 'SUCCESS';
            $this->load->model('Global/Navheader_model');
            $wsData['Modules'] = $this->Navheader_model->getModules();
        } else {
            $Status = 'ERROR';
            $message = 'Incorrect http request method.';
        }
        $wsData['Status'] = $Status;
        $wsData['Message'] = $message;
        echo mongo_json_encode($wsData);
    }
    public function SubModule()
    {
        $wsData = [];
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $Module = $_GET['Module'];
            if ($Module) {
                $Status = 'SUCCESS';
                $this->load->model('Global/Navheader_model');
                $wsData['SubModules'] = $this->Navheader_model->getSubModules($Module);
            } else {
                $Status = 'ERROR';
                $message = 'Module is Required.';
            }
        } else {
            $Status = 'ERROR';
            $message = 'Incorrect http request method.';
        }
        $wsData['Status'] = $Status;
        $wsData['Message'] = $message;
        echo mongo_json_encode($wsData);
    }
}
