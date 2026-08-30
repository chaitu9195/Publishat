<?php

require APPPATH . '/libraries/REST_Controller.php';
class Web extends REST_Controller
{
    protected $user_id;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Common/Common_model');
        $this->load->library('session');
        $this->load->library('mongo_db', ['activate' => 'newdb'], 'mongodb');
        $userIdFromCookie = $this->input->cookie('user_id', true);
        if ($userIdFromCookie) {
            $this->session->set_userdata('user_id', $userIdFromCookie);
        }
        $this->user_id = $this->session->userdata('user_id');
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
                'Upgraded' => $result['data']['Upgraded'],
            ];
            $this->session->set_userdata($userarray);
            $user_id = trim($this->session->userdata('user_id'));
            if (!empty($user_id) || $user_id != '') {
                $this->load->view('template');
            } else {
                $this->load->view('index');
            }
        } else {
            $this->load->view('index', [
                'failed' => 1,
                'data' => $result['data'],
            ]);
        }
    }

    public function index_get()
    {
        $user_id = $this->session->userdata('user_id');
        $user_id = $user_id ? $user_id : $this->input->cookie('user_id', true);
        if ($user_id) {
            $this->load->model('Login_model');
            $Upgraded = $this->Login_model->upgradeStatus($user_id);
            $this->session->set_userdata(['Upgraded' => $Upgraded]);
        }

        if (empty(trim((string) $user_id)) || $user_id === '') {
            $this->load->view('index');
        } else {
            $this->load->view('template');
        }
    }

    public function records_get()
    {
        $rid = $this->input->get('page_id');
        $module = $this->input->get('module');
        $user_id = trim($this->session->userdata('user_id'));
        if (!empty($user_id) || $user_id != '') {
            $this->load->view('template', ['module' => $module, 'rid' => $rid]);
        } else {
            $this->load->view('index');
        }
    }

    public function recordsCount1_post() {}

    public function header_post()
    {
        $this->load->model('Global/Navheader_model');
        $result = $this->Navheader_model->get_headerdata();
        $data['data'] = $result['module'];
        $data['submod'] = $result['submod'];
        $data['typeIds'] = $result['typeIds'];
        $data['rec_count'] = $result['rec_count'];
        $this->load->view('includes/header', $data);
    }

    public function moduledata_post()
    {
        $params = $this->sanitize($this->input->post());
        $module = $params['module'];
        $recTypeId = $params['mod_id'];
        $res = $this->Common_model->collaboration_rec($recTypeId);
        $result = $this->Common_model->get_records($params);
        $tabName = $this->Common_model->get_tabName($recTypeId);
        $moduleName = $this->Common_model->get_moduleName($recTypeId);
        $tableName = $this->Common_model->get_table($recTypeId);
        if ($result['status'] == 'success') {
            $file_name = 'allrecords';
            $data['data'] = $result['data'];
            $data['count'] = $result['count'];
            $data['shared_result'] = $res['shared_data'];
            $data['col_file_cnt'] = $res['col_files_count'];
            $data['tabName'] = $tabName;
            $data['moduleName'] = $moduleName;
            $data['tableName'] = $tableName;
            $data['recTypeId'] = $recTypeId;
            $this->load->view($file_name, $data);
        } else {
            echo $result['status'];
        }
    }
    public function moduledata_get()
    {
        $params = $this->sanitize($this->input->get());
        $module = $params['module'];
        $recTypeId = $params['mod_id'];
        $page = $params['page'];
        $res = $this->Common_model->collaboration_rec($recTypeId);
        $result = $this->Common_model->get_records($params);
        $tabName = $this->Common_model->get_tabName($recTypeId);
        $moduleName = $this->Common_model->get_moduleName($recTypeId);
        $tableName = $this->Common_model->get_table($recTypeId);
        if ($result['status'] == 'success') {
            $file_name = 'allrecords';
            echo mongo_json_encode($result['data']);
        } else {
            echo $result['status'];
        }
    }

    public function addnew_post()
    {
        $params = $this->sanitize($this->input->post());
        $module = $params['module'];
        $recTypeId = $this->sanitize($this->input->post('mod_id'));
        $tabName = $this->Common_model->get_tabName($recTypeId);
        $moduleName = $this->Common_model->get_moduleName($recTypeId);
        $this->load->model('Getallfields_model');
        $fields = $this->Getallfields_model->get_allfields(
            $recTypeId,
            $this->user_id,
            0,
        );
        $file_name = 'create';
        $folder_files = $this->Common_model->folderfiles($recTypeId);
        $fileURL = $this->input->post('fileURL');
        $fileURL = $fileURL ? $fileURL : '';
        if ($fileURL) {
            $ocrDataResult = $this->OcrReader($fileURL);
            $decodedData = $this->object_2_array(json_decode($ocrDataResult));
            $string = $decodedData['ParsedResults'][0]['ParsedText'];
            $string = str_replace(' ,', '', $string);
            $wordData = explode(' ', $string);
            $ocrData['FromDate'] = $wordData[0];
            for ($i = 1; $i < safe_count($wordData ?? []) - 2; $i++) {
                $ocrData['ReceiverName'] .= $wordData[$i] . ' ';
            }
            $ocrData['Amount'] = $wordData[safe_count($wordData ?? []) - 2];
            $ocrData['Notes'] = $string;
        }
        $data['files'] = $folder_files['folder'];
        $data['fileids'] = $params['ids'];
        $data['fields'] = $fields;
        $data['recTypeId'] = $recTypeId;
        $data['tabName'] = $tabName;
        $data['moduleName'] = $moduleName;
        $data['data'] = $params['data'];
        $data['ocrData'] = $ocrData;
        $this->load->view($file_name, $data);
    }

    public function addrelated_post()
    {
        $params = $this->sanitize($this->input->post());
        $module = $params['module'];
        $recTypeId = $params['mod_id'];
        $record_id = $params['r_id'];
        $result = $this->Common_model->get_table($recTypeId);
        $tabName = $this->Common_model->get_tabName($recTypeId);
        $moduleName = $this->Common_model->get_moduleName($recTypeId);
        $this->load->model('Getallfields_model');
        $fields = $this->Getallfields_model->get_allfields(
            $recTypeId,
            $this->user_id,
            1,
        );

        $file_name = 'addrelated';
        $folder_files = $this->Common_model->folderfiles($recTypeId);
        $data['recordId'] = $record_id;
        $data['files'] = $folder_files['folder'];
        $data['fileids'] = $params['ids'];
        $data['fields'] = $fields;
        $data['tabName'] = $tabName;
        $data['moduleName'] = $moduleName;
        $data['addrelated'] = 1;
        $this->load->view($file_name, $data);
    }

    public function addSubRecord_post()
    {
        $params = $this->sanitize($this->input->post());
        $this->load->model('Common/Addrecord_model');
        $result = $this->Addrecord_model->add_sub_record($params);
        if ($result['status'] == 'success') {
            echo $result['rid'];
        } else {
            echo $result['status'];
        }
    }

    public function relatedview_post()
    {
        $params = $this->sanitize($this->input->post());
        $module = $this->sanitize($params['module']);
        $mainRecTypeId = $params['main_modid'];
        $folder = $this->Common_model->get_table($mainRecTypeId);
        $result = $this->Common_model->viewrecord_data($params);
        $recTypeId = $params['modid'];
        $tabName = $this->Common_model->get_tabName($recTypeId);
        $moduleName = $this->Common_model->get_moduleName($recTypeId);
        $tableName = $this->Common_model->get_table($recTypeId);
        if ($result['status'] == 'success') {
            $file_name = 'view-related';
            $data['data'] = $result['data'][0];
            $data['files'] = $result['files'];
            $data['tabName'] = $tabName;
            $data['moduleName'] = $moduleName;
            $data['tableName'] = $tableName;
            $data['recTypeId'] = $recTypeId;
            $data['mainRecTypeId'] = $mainRecTypeId;
            $this->load->view($file_name, $data);
        } else {
            echo $result['status'];
        }
    }

    public function deleteSubRecord_post()
    {
        $params = $this->sanitize($this->input->post());
        $module = $params['module'];
        $result = $this->Common_model->deleteSubRecord($params);
        echo $result;
    }

    public function schoolnew_post()
    {
        $params = $this->sanitize($this->input->post());
        $this->load->model('Common/Addrecord_model');

        $result = $this->Addrecord_model->add_record($params);
        if ($result['status'] == 'success') {
            echo $result['rid'];
        } else {
            echo $result['status'];
        }
    }

    public function displayView_post()
    {
        $params = $this->sanitize($this->input->post());
        $module = $this->sanitize($params['module']);
        $result = $this->Common_model->viewrecord_data($params);
        $this->load->model('User_model');
        $emaildata = $this->User_model->useremail();
        $email = json_encode($emaildata['Email']);
        $recTypeId = $params['modid'];
        $tabName = $this->Common_model->get_tabName($recTypeId);
        $moduleName = $this->Common_model->get_moduleName($recTypeId);
        $tableName = $this->Common_model->get_table($recTypeId);
        if ($result['status'] == 'success') {
            if (isset($params['rel_type_id'])) {
                $sub_result = $this->Common_model->get_subRecords($params);
                if ($sub_result['status'] == 'success') {
                    $sub_data = $sub_result['data'];
                    $sub_file_count = $sub_result['file_count'];
                    $sub_files = $sub_result['subfiles'];
                    $sub_rec_id = $sub_result['sub_recordid'];
                }
            } else {
                $sub_data = 'failed';
            }
            $file_name = 'view-record';
            $data['data'] = $result['data'][0];
            $data['files'] = $result['files'];
            $data['sub_data'] = $sub_data;
            $data['file_count'] = $sub_file_count;
            $data['sub_files'] = $sub_files;
            $data['sub_rec'] = $sub_rec_id;
            $data['email'] = $email;
            $data['tabName'] = $tabName;
            $data['moduleName'] = $moduleName;
            $data['tableName'] = $tableName;
            $data['recTypeId'] = $recTypeId;
            $data['relatedRecTypeId'] = $params['rel_type_id'];

            $this->load->view($file_name, $data);
        } else {
            echo $result['status'];
        }
    }

    public function downloadfile_get()
    {
        $path = $this->sanitize($this->input->get('rid'));
        $this->load->model('Common/Downloadfile_model');
        $result = $this->Downloadfile_model->download($path);
    }
    public function downloadfiles_get()
    {
        $path = $this->sanitize($this->input->get('rid'));
        $recordid = $this->sanitize($this->input->get('id'));
        $this->load->model('Common/Downloadfile_model');
        $result = $this->Downloadfile_model->download_file($path, $recordid);
    }

    public function viewfile_get()
    {
        $file_id = $this->input->get('fid');
        $this->load->model('Common/Downloadfile_model');
        $result = $this->Downloadfile_model->mongodownload($file_id);
    }

    public function editrecord_post()
    {
        $params = $this->sanitize($this->input->post());
        $record_type_id = $params['page_refer_id'];
        $module = $params['module'];
        $record_id = $params['rid'];
        $tableName = $this->Common_model->get_table($record_type_id);
        $tabName = $this->Common_model->get_tabName($record_type_id);
        $moduleName = $this->Common_model->get_moduleName($record_type_id);
        $this->load->model('Getallfields_model');
        $fields = $this->Getallfields_model->get_allfields(
            $record_type_id,
            $this->user_id,
            0,
        );
        if (!empty($tableName) && $tableName != 'failed') {
            $result = $this->Common_model->get_editrecord_data(
                $record_id,
                $record_type_id,
            );
            $folder_files = $this->Common_model->folderfiles($record_type_id);
            $data['data'] = $result['data'][0];
            $data['files'] = $result['files'];
            $data['folder'] = $folder_files['folder'];
            $data['fields'] = $fields;
            $data['tabName'] = $tabName;
            $data['moduleName'] = $moduleName;
            $data['recTypeId'] = $record_type_id;
            $this->load->view('edit-record', $data);
        } else {
            $this->load->view('edit-record', ['data' => 'No Data']);
        }
    }

    public function updatedata_post()
    {
        $params = $this->sanitize($this->input->post());
        $this->load->model('Common/Editrecord_model');
        $result = $this->Editrecord_model->update_record($params);
        echo mongo_json_encode($result);
    }

    public function attachfiles_post()
    {
        $params = $this->sanitize($this->input->post());
        $record_id = $params['RecordId'];
        $module = $params['module'];
        $record_type_id = $params['record_type_id'];
        if (safe_count($_FILES ?? []) > 0) {
            $this->load->model('Common/Uploadfile_model');
            $result1 = $this->Uploadfile_model->upload_file($params);
            if ($result1['data'] == 'Success') {
                $tableName = $this->Common_model->get_table($record_type_id);
                $tabName = $this->Common_model->get_tabName($record_type_id);
                $moduleName = $this->Common_model->get_moduleName(
                    $record_type_id,
                );
                $this->load->model('Getallfields_model');
                $fields = $this->Getallfields_model->get_allfields(
                    $record_type_id,
                    $this->user_id,
                    0,
                );
                if (!empty($tableName) && $tableName != 'failed') {
                    $result = $this->Common_model->get_editrecord_data(
                        $record_id,
                        $record_type_id,
                    );
                    $data['data'] = $result['data'][0];
                    $data['files'] = $result['files'];
                    $data['fields'] = $fields;
                    $data['tabName'] = $tabName;
                    $data['moduleName'] = $moduleName;
                    $data['recTypeId'] = $record_type_id;
                    $this->load->view('edit-record', $data);
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
        $record_id = $params['rid'];
        $module = $params['module'];
        if (safe_count($params ?? [])) {
            $del_status = $this->Common_model->delete_single_rec($params);
            if ($del_status['status'] == 'Success') {
                $tableName = $this->Common_model->get_table($record_type_id);
                $tabName = $this->Common_model->get_tabName($record_type_id);
                $moduleName = $this->Common_model->get_moduleName(
                    $record_type_id,
                );
                $this->load->model('Getallfields_model');
                $fields = $this->Getallfields_model->get_allfields(
                    $record_type_id,
                    $this->user_id,
                    0,
                );
                if (!empty($tableName) && $tableName != 'failed') {
                    $result = $this->Common_model->get_editrecord_data(
                        $record_id,
                        $record_type_id,
                    );
                    $data['data'] = $result['data'][0];
                    $data['files'] = $result['files'];
                    $data['fields'] = $fields;
                    $data['tabName'] = $tabName;
                    $data['moduleName'] = $moduleName;
                    $data['recTypeId'] = $record_type_id;
                    $this->load->view('edit-record', $data);
                }
            } else {
                echo $del_status['status'];
            }
        }
    }

    public function deleteRecord_post()
    {
        $cpatcha = $this->session->userdata('captcha');
        $params = $this->sanitize($this->input->post());
        $module = $params['module'];
        if (!empty($params['captcha']) && $params['captcha'] == $cpatcha) {
            $this->session->unset_userdata('captcha');
            $this->load->model('Common/Deleterecord_model');
            $result = $this->Deleterecord_model->delete_record($params);
            if (
                is_array($result) &&
                isset($result['status']) &&
                $result['status'] == 'success'
            ) {
                echo 'success';
            } else {
                echo 'failed';
            }
        } else {
            echo 'failed';
        }
    }

    public function mailRecord_post()
    {
        $params = $this->sanitize($this->input->post());
        $module = $params['module'];
        if (safe_count($params ?? [])) {
            $this->load->model('Common/Mailrecord_model');
            $result = $this->Mailrecord_model->mail_record($params);
            if ($result['status'] == 'success') {
                echo $result['status'];
            } elseif ($result['status'] == 'failed') {
                echo $result['data'];
            }
        } else {
            echo 'No data';
        }
    }

    public function getKart_post()
    {
        $params = $this->sanitize($this->input->post());
        $record_type_id = $params['page_refer_id'];
        $module = $params['module'];
        $record_id = $params['rid'];

        $tableName = $this->Common_model->get_table($record_type_id);
        if (!empty($tableName) && $tableName != 'failed') {
            $this->load->model('Common/Cart_model');
            $result = $this->Cart_model->getkart_data(
                $record_id,
                $record_type_id,
            );
            $tabName = $this->Common_model->get_tabName($record_type_id);
            $moduleName = $this->Common_model->get_moduleName($record_type_id);
            if ($params['rel_type_id']) {
                $sub_result = $this->Common_model->get_subRecords($params);
                if ($sub_result['status'] == 'success') {
                    $sub_data = $sub_result['data'];
                    $sub_file_count = $sub_result['file_count'];
                    $sub_files = $sub_result['subfiles'];
                    $sub_rec_id = $sub_result['sub_recordid'];
                }
            }
            $data['names'] = $result['kartNames'];
            $data['files'] = $result['files'];
            $data['tabName'] = $tabName;
            $data['moduleName'] = $moduleName;
            $data['recTypeId'] = $record_type_id;
            $data['sub_files'] = $sub_files;
            $this->load->view('addkart', $data);
        } else {
            $this->load->view('addkart', ['data' => 'No Data']);
        }
    }

    public function saveToCart_post()
    {
        $params = $this->sanitize($this->input->post());
        $this->load->model('Common/Cart_model');
        $result = $this->Cart_model->savetocart($params);
        echo $result['status'];
    }

    public function dKart_post()
    {
        $this->load->model('Common/Cart_model');
        $this->load->model('User_model');
        $emaildata = $this->User_model->useremail();
        $email = json_encode($emaildata['Email']);
        $result = $this->Cart_model->dcart_data();
        $data['names'] = $result['cart_names'];
        $data['cdata'] = $result['data'];
        $data['email'] = $email;
        $this->load->view('dcart', $data);
    }

    public function cartdata_post()
    {
        $cartName = $this->sanitize($this->post('cName'));
        $this->load->model('Common/Cart_model');
        $result = $this->Cart_model->cname_data($cartName);
        $data['cdata'] = $result['data'];
        $this->load->view('includes/include_cart_content', $data);
    }

    public function mailCartRecord_post()
    {
        $params = $this->sanitize($this->input->post());
        $module = $params['module'];
        if (safe_count($params ?? [])) {
            $this->load->model('Common/Mailcartitems_model');
            $result = $this->Mailcartitems_model->mail_from_cart($params);
            if ($result['status'] == 'success') {
                echo $result['status'];
            } elseif ($result['status'] == 'failed') {
                echo $result['data'];
            }
        } else {
            echo 'No data';
        }
    }

    public function deleteCartRecord_post()
    {
        $cpatcha = $this->session->userdata('cart_captcha');
        $params = $this->sanitize($this->input->post());
        if (!empty($params['captcha']) && $params['captcha'] == $cpatcha) {
            $this->session->unset_userdata('captcha');
            $this->load->model('Common/Cart_model');
            $result = $this->Cart_model->delete_record($params);
            echo $result;
        } else {
            echo 'failed';
        }
    }

    public function deleteCartdata_post()
    {
        $params = $this->sanitize($this->input->post());
        $this->load->model('Common/Cart_model');
        $result = $this->Cart_model->delete_cart_record($params);
        echo $result;
    }

    public function settings_post()
    {
        $params = $this->sanitize($this->input->post());
        $module = $params['module'];
        $this->load->model('Global/Settings_model');
        $result = $this->Settings_model->get_settings_data($module);
        $data['settings'] = $result['data'];
        $data['module'] = $module;
        $this->load->view('settings', $data);
    }

    public function bookmarks_post()
    {
        $params = $this->sanitize($this->input->post());
        $this->load->model('Global/Folder_model');
        $result = $this->Folder_model->folder_data($params);
        $bookmarkresult = $this->Folder_model->bookmark_data($params);
        $data['param'] = $params;
        $data['bookmark'] = $bookmarkresult['bookmarksdata'];
        $this->load->view('includes/bookmark', $data);
    }

    public function getsettings_data_post()
    {
        $params = $this->sanitize($this->input->post());
        $module = $params['module'];
        $this->load->model('Global/Settings_model');
        $result = $this->Settings_model->get_settings_data($module);
        $data['settings'] = $result['data'];
        $data['module'] = $module;
        $this->load->view('includes/include_settings', $data);
    }

    public function updateSettings_post()
    {
        $params = $this->sanitize($this->input->post());
        $this->load->model('Global/Settings_model');
        echo $result = $this->Settings_model->updateSettings($params);
    }

    public function getFolder_post()
    {
        $params = $this->sanitize($this->input->post());
        $this->load->model('Global/Folder_model');
        $this->load->model('User_model');
        $emaildata = $this->User_model->useremail();
        $email = json_encode($emaildata['Email']);
        $result = $this->Folder_model->folder_data($params);
        $bookmarkresult = $this->Folder_model->bookmark_data($params);
        $data['param'] = $params;
        $data['files'] = $result['files'];
        $data['bookmark'] = $bookmarkresult['bookmarksdata'];
        $data['email'] = $email;
        $this->load->view('includes/folder', $data);
    }

    public function uploadfolderfiles_post()
    {
        $params = $this->sanitize($this->input->post());

        $folder_id = $params['foldid'];
        $type_id = $params['typeId'];
        $module = $params['module'];
        $this->load->model('Global/Folder_model');
        $result = $this->Folder_model->uploadfile($params);
        $this->load->model('Global/Folder_model');
        $data = $this->Folder_model->getfolderfilesdata(
            $folder_id,
            $type_id,
            $module,
        );
        $filesData['files'] = $data['ff'];
        $filesData['fpath'] = $data['fdetails'];
        $filesData['param'] = $data;
        $filesData['module'] = $module;
        $filesData['status'] = $result['status'];
        $filesData['folid'] = $folder_id;
        if ($params['isFromExternal']) {
            echo 'success';
        } else {
            $this->load->view('includes/folder', $filesData);
        }
    }

    public function deleteFolderFile_post()
    {
        $cpatcha = $this->session->userdata('folder_captcha');
        $params = $this->sanitize($this->input->post());
        if (!empty($params['captcha']) && $params['captcha'] == $cpatcha) {
            $this->session->unset_userdata('captcha');
            $this->load->model('Global/Folder_model');
            $result = $this->Folder_model->delete_file($params);
            echo $result;
        } else {
            echo 'failed';
        }
    }
    public function deletebookmarks_post()
    {
        $cpatcha = $this->session->userdata('folder_captcha');
        $params = $this->sanitize($this->input->post());
        if (!empty($params['captcha']) && $params['captcha'] == $cpatcha) {
            $this->session->unset_userdata('captcha');
            $this->load->model('Global/Folder_model');
            $result = $this->Folder_model->delete_bookmark($params);
            echo $result;
        } else {
            echo 'failed';
        }
    }

    public function mailFolderRecord_post()
    {
        $params = $this->sanitize($this->input->post());
        if (safe_count($params ?? [])) {
            $this->load->model('Global/Mailfolderfiles_model');
            $result = $this->Mailfolderfiles_model->mail_from_folder($params);
            if ($result['status'] == 'success') {
                echo $result['status'];
            } elseif ($result['status'] == 'failed') {
                echo $result['data'];
            }
        } else {
            echo 'No data';
        }
    }

    public function mailbookmarkRecord_post()
    {
        $params = $this->sanitize($this->input->post());
        if (safe_count($params ?? [])) {
            $this->load->model('Global/Mailfolderfiles_model');
            $result = $this->Mailfolderfiles_model->mail_from_bookmarks(
                $params,
            );
            if ($result['status'] == 'success') {
                echo $result['status'];
            } elseif ($result['status'] == 'failed') {
                echo $result['data'];
            }
        } else {
            echo 'No data';
        }
    }

    public function getlog_post()
    {
        $params = $this->input->post();
        $this->load->model('Global/Log_model');
        $result = $this->Log_model->log_data($params);
        $data['data'] = $result['log'];
        $data['e_name'] = $result['e_name'];
        $this->load->view('includes/log', $data);
    }
    public function getlog_get()
    {
        $params = $this->input->get();
        $this->load->model('Global/Log_model');
        $result = $this->Log_model->log_data($params);
        $result['data'] = $result['e_name'];
        $result['data'] = $result['log'];
        echo $response = mongo_json_encode($result['data']);
    }

    public function accSummary_post()
    {
        $this->load->model('Global/Summary_model');
        $result = $this->Summary_model->getuserinfo();
        $data['data'] = $result;
        $this->load->view('includes/acc_summary', $data);
    }
    public function updateuserinfo_post()
    {
        $params = $this->input->post();
        $this->load->model('Global/Summary_model');
        $this->Summary_model->user_info_update($params);
        $result = $this->Summary_model->getuserinfo();
        $data['data'] = $result;
        $this->load->view('includes/acc_summary', $data);
    }

    public function logout_get()
    {
        $data = ['user_id', 'email'];
        $this->session->unset_userdata($data);
        session_destroy();

        $this->load->view('index');
    }

    public function screenshot_post()
    {
        $params = $this->input->post();
        $this->load->model('Login_model');
        $result = $this->Login_model->screenshot($params);
        echo $result['path'];
    }
    public function article_get()
    {
        $this->load->model('Global/Articles_view_model');
        $result = $this->Articles_view_model->getarticleinfo();
        $data['data'] = $result;
        $this->load->view('includes/article', $data);
    }
    public function article_edit_get()
    {
        $params = $this->input->get('id');
        $this->load->model('Global/Articles_view_model');
        $result = $this->Articles_view_model->getarticleinfoedit($params);
        $data['data'] = $result['articleinfo'];
        $this->load->view('includes/article_edit', $data);
    }
    public function articleimage_post()
    {
        $this->load->model('Global/Articles_images_model');
        $result = $this->Articles_images_model->articleimage();
        $path = $result['path'];
        echo $path;
    }
    public function article_update_post()
    {
        $params = $this->input->post();
        $this->load->model('Global/Articles_view_model');
        $this->Articles_view_model->articleupdate($params);
        $result = $this->Articles_view_model->getarticleinfo();
        $data['data'] = $result;
        $this->load->view('includes/article', $data);
    }
    public function article_post()
    {
        $params = $this->input->post();
        $this->load->model('Global/Articles_model');
        $this->Articles_model->articles_info_data($params);
        $this->load->model('Global/Articles_view_model');
        $result = $this->Articles_view_model->getarticleinfo();
        $data['data'] = $result;
        $this->load->view('includes/article', $data);
    }
    public function extension_get()
    {
        $user_id = $this->input->get('uid');
        $user_id = $user_id / 7897987;
        $this->session->set_userdata(['user_id' => $user_id]);
        $module = $this->sanitize($this->input->get('module'));
        $recTypeId = $this->sanitize($this->input->get('rid'));
        $this->load->view('template', [
            'module' => $module,
            'rid' => $recTypeId,
        ]);
    }

    public function createfolder_post()
    {
        $params = $this->input->post();
        $folder_name = $params['folder_name'];
        $folder_id = $params['folder_id'];
        $type_id = $params['typeId'];
        $module = $params['module'];
        $this->load->model('Global/Folder_model');
        $result = $this->Folder_model->createfolder($params);
        $data = $this->Folder_model->getfolderfilesdata(
            $folder_id,
            $type_id,
            $module,
        );
        $folderData['files'] = $data['ff'];
        $folderData['fpath'] = $data['fdetails'];
        $folderData['param'] = $data;
        $folderData['folid'] = $folder_id;
        $this->load->view('includes/folder', $folderData);
    }
    public function createdfolder_get()
    {
        $folder_id = $this->input->get('id');
        $type_id = $this->input->get('typeId');
        $module = $this->input->get('module');
        $this->load->model('Global/Folder_model');
        $data = $this->Folder_model->getfolderfilesdata(
            $folder_id,
            $type_id,
            $module,
        );
        $folderData['files'] = $data['ff'];
        $folderData['fpath'] = $data['fdetails'];
        $folderData['param'] = $data;
        $folderData['folid'] = $folder_id;
        $this->load->view('includes/folder', $folderData);
    }

    public function previewdata_get()
    {
        $id = $this->input->get('id');
        $path = $this->input->get('path');
        $filetype = $this->input->get('filetype');
        $params = $this->input->get();
        $filename = $this->input->get('filename');
        $this->load->model('Global/Folder_model');
        $data = $this->Folder_model->getmapsdata();
        $printData['id'] = $id;
        $printData['path'] = $path;
        $printData['filetype'] = $filetype;
        $printData['data'] = $data;
        $printData['filename'] = $filename;
        $this->load->view('includes/Preview', $printData);
    }

    public function confirmationprint_post()
    {
        $params = $this->input->post();
        $this->load->model('Global/Folder_model');
        $data = $this->Folder_model->pageinfo($params);
        $printData['params'] = $params;
        $printData['OrderId'] = $data['OrderId'];
        $printData['Cost'] = $data['cost'];
        $this->load->view('includes/paymentconfirmationpage', $printData);
    }

    public function confirmationprint_get()
    {
        $params = $this->input->get();
        $color = $this->input->get('color');
        $this->load->model('Global/Folder_model');
        $data = $this->Folder_model->colorselection($params);
        echo $data['cost'];
    }

    public function locationsearch_post()
    {
        $params = $this->input->post();
        $this->load->model('Global/Folder_model');
        $data = $this->Folder_model->locationsearchdata($params);
        $location = $data['location'];
        $locationData['data'] = $data['data'];
        $locationData['location'] = $location;
        $this->load->view('includes/map', $locationData);
    }

    public function collaboraterecord_post()
    {
        $params = $this->input->post();
        $this->load->model('Common/Common_model');
        $data = $this->Common_model->collaboration($params);
        if ($data['status'] == 'success') {
            echo $data['status'];
        } elseif ($data['status'] == 'failed') {
            echo $data['data'];
        } else {
            echo 'No data';
        }
    }
    public function articleinfo_get()
    {
        $params = $this->input->get();
        $id = $params['id'];
        $this->load->view('article', $id);
    }

    public function printcheckoutpage_post()
    {
        $params = $this->input->post();
        $this->session->set_userdata($params);
        $this->load->model('Global/Folder_model');
        $cost = $this->Folder_model->pageinfo($params);
        $data['cost'] = $cost;
        $data['filename'] = $params['filename'];
        $data['description'] = $params['description'];
        $data['print_type'] = $params['print_type'];
        $data['ProjectPageNos'] = $params['ProjectPageNos'];
        $this->load->view('includes/paymentconfirmationpage', $data);
    }

    public function docviewer_get()
    {
        $fid = $this->input->get('fid');
        $type = $this->input->get('type');
        $filename = $this->input->get('filename');
        $typeId = $this->input->get('typeId');
        $module = $this->input->get('module');
        $uid = $this->input->get('uid');
        $name = $this->input->get('name');
        $isPrint = $this->input->get('isPrint');
        if ($name) {
            $this->session->set_userdata('name', $name);
        }
        if ($uid) {
            $this->session->set_userdata('user_id', $uid);
        }
        $data['fid'] = $fid;
        $data['type'] = $type;
        $data['filename'] = $filename;
        $data['typeId'] = $typeId;
        $data['module'] = $module;
        $data['isPrint'] = $isPrint;
        $this->load->view('includes/docviewer', $data);
    }
    public function fileviewer_get()
    {
        $fid = $this->input->get('fid');
        $type = $this->input->get('type');
        $filename = $this->input->get('filename');
        $typeId = $this->input->get('typeId');
        $module = $this->input->get('module');
        $uid = $this->input->get('uid');
        $name = $this->input->get('name');
        $isPrint = $this->input->get('isPrint');
        if ($name) {
            $this->session->set_userdata('name', $name);
        }
        if ($uid) {
            $this->session->set_userdata('user_id', $uid);
        }
        $data['fid'] = $fid;
        $data['type'] = $type;
        $data['filename'] = $filename;
        $data['typeId'] = $typeId;
        $data['module'] = $module;
        $data['isPrint'] = $isPrint;
        $this->load->view('includes/fileviewer', $data);
    }

    public function ReadFileWithOCR_get()
    {
        $user_id = $this->input->cookie('user_id', true);
        $recTypeId = $this->input->cookie('screenshort_record_id', true);
        $fileURL = $this->input->get('fileURL');
        $this->load->model('Common_model');
        $tabName = $this->Common_model->get_tabName($recTypeId);
        $moduleName = $this->Common_model->get_moduleName($recTypeId);
        $this->load->model('Getallfields_model');
        $fields = $this->Getallfields_model->get_allfields(
            $recTypeId,
            $user_id,
            0,
        );
        $file_name = 'create';

        $this->load->view('template', [
            'module' => $moduleName,
            'rid' => $recTypeId,
        ]);
    }

    public function OcrReader($fileURL)
    {
        $fileURL = 'https://' . $_SERVER['HTTP_HOST'] . '/' . $fileURL;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.ocr.space/Parse/Image');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            "isOverlayRequired=true&url=$fileURL&language=eng",
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        $headers = [];
        $headers[] = 'Apikey: a75232244b88957';
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }
    public function object_2_array($result)
    {
        $array = [];
        foreach ($result as $key => $value) {
            if (is_array($value)) {
                $array[$key] = $this->object_2_array($value);
            } else {
                if (is_object($value)) {
                    $array[$key] = $this->object_2_array($value);
                } else {
                    $array[$key] = $value;
                }
            }
        }
        return $array;
    }

    public function getPrintHistory_get()
    {
        $user_id = trim($this->session->userdata('user_id'));
        $this->load->model('Global/Folder_model');
        $data['PrintHistory'] = $this->Folder_model->getPrintHistory($user_id);

        $this->load->view('print_history_view', $data);
    }
    public function aboutus_get()
    {
        $this->load->view('about_us_view');
    }
    public function privacy_get()
    {
        $this->load->view('privacy_view');
    }
    public function terms_get()
    {
        $this->load->view('terms_view');
    }
    public function cancellation_get()
    {
        $this->load->view('cancellation_policy_view');
    }
    public function contactus_get()
    {
        $this->load->view('contact_us_view');
    }
    public function mailtest_get()
    {
        $this->load->library('email');
        $config = [
            'protocol' => protocol,
            'smtp_host' => smtp_host,
            'smtp_port' => smtp_port,
            'smtp_user' => smtp_user,
            'smtp_pass' => smtp_pass,
            'mailpath' => mailpath,
            'charset' => charset,
            'wordwrap' => wordwrap,
        ];
        $this->email->initialize($config);
        $this->email->set_mailtype('html');
        $this->email->set_newline("\r\n");

        $cc = $this->input->get('cc');
        $subject = $this->input->get('subject') ?: 'Publishat mail test';
        $message =
            $this->input->get('message') ?:
            'This is a test email from Publishat.';

        $this->email->to('chaithanyakondragunta@gmail.com');
        if ($cc) {
            $this->email->cc($cc);
        }
        $this->email->from('admin@publishat.com');
        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
        } else {
            echo '<pre>';
            print_r($this->email->print_debugger());
            die();
        }
    }
}
