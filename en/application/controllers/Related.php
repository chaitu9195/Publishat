<?php

require APPPATH . '/libraries/REST_Controller.php';
class Related extends REST_Controller
{
    protected $user_id;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Common/Common_model');
        $this->load->library('session');
        $this->load->library('mongo_db', ['activate' => 'newdb'], 'mongodb');
        $this->user_id = $this->session->userdata('user_id');
    }

    public function editrecord_post()
    {
        $params = $this->sanitize($this->input->post());
        $record_type_id = $params['page_refer_id'];
        $parent_record_type_id = $params['p_type_id'];
        $module = $params['module'];
        $record_id = $params['rid'];
        $tableName = $this->Common_model->get_table($parent_record_type_id);
        $tabName = $this->Common_model->get_tabName($record_type_id);
        $moduleName = $this->Common_model->get_moduleName($record_type_id);
        $this->load->model('Getallfields_model');
        $fields = $this->Getallfields_model->get_allfields($parent_record_type_id, $this->user_id, 1);
        if (!empty($tableName) && $tableName != 'failed') {
            $result = $this->Common_model->get_editrecord_data($record_id, $record_type_id);
            $folder_files = $this->Common_model->folderfiles($parent_record_type_id);
            $this->load->view('edit-related', [
                'data' => $result['data'][0],
                'files' => $result['files'],
                'folder' => $folder_files['folder'],
                'fields' => $fields,
                'tabName' => $tabName,
                'moduleName' => $moduleName,
                'recTypeId' => $record_type_id,
                'parentRecTypeId' => $parent_record_type_id,
            ]);
        } else {
            $this->load->view('edit-related', ['data' => 'No Data']);
        }
    }

    public function attachfiles_post()
    {
        $params = $this->sanitize($this->input->post());
        $record_id = $params['RecordId'];
        $module = $params['module'];
        $record_type_id = $params['record_type_id'];
        $parent_record_type_id = $params['parent_record_type_id'];
        if (count($_FILES ?? []) > 0) {
            $this->load->model('Common/Uploadfile_model');
            $result1 = $this->Uploadfile_model->upload_file($params);
            if ($result1['data'] == 'Success') {
                $tableName = $this->Common_model->get_table($parent_record_type_id);
                $tabName = $this->Common_model->get_tabName($record_type_id);
                $moduleName = $this->Common_model->get_moduleName($record_type_id);
                $this->load->model('Getallfields_model');
                $fields = $this->Getallfields_model->get_allfields($parent_record_type_id, $this->user_id, 1);
                if (!empty($tableName) && $tableName != 'failed') {
                    $result = $this->Common_model->get_editrecord_data($record_id, $record_type_id);
                    $this->load->view('edit-related', [
                        'data' => $result['data'][0],
                        'files' => $result['files'],
                        'fields' => $fields,
                        'tabName' => $tabName,
                        'moduleName' => $moduleName,
                        'recTypeId' => $record_type_id,
                        'parentRecTypeId' => $parent_record_type_id,
                    ]);
                }
            } else {
                echo 'Failed';
            }
        } else {
            echo 'No File Selected';
        }
    }

    public function deleteattachment_post()
    {
        $params = $this->sanitize($this->input->post());
        $record_type_id = $params['page_refer_id'];
        $parent_record_type_id = $params['main_page_id'];
        $record_id = $params['rid'];
        $module = $params['module'];
        $tabName = $this->Common_model->get_tabName($record_type_id);
        $moduleName = $this->Common_model->get_moduleName($record_type_id);
        $this->load->model('Getallfields_model');
        $fields = $this->Getallfields_model->get_allfields($parent_record_type_id, $this->user_id, 1);
        if (count($params ?? [])) {
            $this->load->model('Common/Common_model');
            $del_status = $this->Common_model->delete_single_rec($params);
            if ($del_status['status'] == 'Success') {
                $tableName = $this->Common_model->get_table($parent_record_type_id);
                if (!empty($tableName) && $tableName != 'failed') {
                    $result = $this->Common_model->get_editrecord_data($record_id, $record_type_id);
                    $this->load->view('edit-related', [
                        'data' => $result['data'][0],
                        'files' => $result['files'],
                        'fields' => $fields,
                        'tabName' => $tabName,
                        'moduleName' => $moduleName,
                        'recTypeId' => $record_type_id,
                        'parentRecTypeId' => $parent_record_type_id,
                    ]);
                }
            } else {
                echo $del_status['status'];
            }
        }
    }
}
