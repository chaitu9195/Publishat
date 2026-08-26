<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Common_model extends CI_Model
{
    /*
    Get Records
    --------------------------------------------*/
    public function get_records($params)
    {
        $recordTypeId = $params['mod_id'];
        $page = $params['page'];
        if (empty($page)) {
            $page = 1;
        }
        $start = ($page * recordsPerPage) - recordsPerPage;
        $end = recordsPerPage;
        $table_name = $this->get_table($recordTypeId);
        $user_id = $this->session->userdata('user_id'); //log_message('info',$user_id.','.$table_name);
        $user_id = $user_id ? $user_id : $this->input->cookie('user_id', true);
        //echo $user_id."----".$table_name;
        if (!empty($table_name) && $table_name != 'failed') {
            $this->mongodb->order_by(['TS' => 'DESC']);
            $this->mongodb->where(['UserId' => mongo_id($user_id)]);
            $this->mongodb->offset($start);
            $this->mongodb->limit($end);
            $qry = $this->mongodb->get($table_name);
            foreach ($qry as $key) {
                $user_id = (string)$key['UserId'];
                $id = (string)$key['_id'];
                $recordid = (string)$key['RecordId'];
                unset($key['_id']);
                unset($key['UserId']);
                unset($key['RecordId']);
                $key['UserId'] = $user_id;
                $key['RecordId'] = $recordid;
                $key['_id'] = $id;
                //$data[]  = $key;
                $this->mongodb->where(['UserId' => mongo_id($user_id), 'RecordId' => mongo_id($key['RecordId']), 'RecordTypeId' => $recordTypeId]);
                // Count files server-side instead of fetching all file docs (faster).
                $fcount = $this->mongodb->count('fs.files');
                $file_count[] = $fcount;
                $key['count'] = $fcount;
                $data[] = $key;

            }

            return ['status' => 'success','data' => $data,'count' => $file_count,'table' => $table_name];
        } else {
            return ['status' => 'failed'];
        }

    }

    /*
    Get Header Count
    ----------------------------------------*/
    public function rec_count($recordTypeId)
    {
        $table_name = $this->get_table($recordTypeId);
        $user_id = $this->session->userdata('user_id');
        if (!empty($table_name) && $table_name != 'failed') {
            $this->mongodb->where(['UserId' => $user_id]);
            $qry = $this->mongodb->get($table_name);
            $count = count($qry ?? []);
            return ['status' => 'success','count' => $count];
        } else {
            return ['status' => 'failed'];
        }
    }

    /*
    Get single records data
    -------------------------------------------*/
    public function viewrecord_data($params)
    {
        $recordTypeId = $params['modid'];
        $record_id = $params['rid'];
        $user_id = $this->session->userdata('user_id');
        $table_name = $this->get_table($recordTypeId);
        if (!empty($table_name) && $table_name != 'failed') {
            $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
            $qry = $this->mongodb->get($table_name);
            foreach ($qry as $key) {
                unset($key['TS']);
                $data[] = $key;
            }
            $this->mongodb->where(['RecordId' => mongo_id($record_id), 'RecordTypeId' => $recordTypeId]);
            $qry = $this->mongodb->get('fs.files');
            foreach ($qry as $key) {
                $file_data[] = $key;
            }

            return ['status' => 'success','data' => $data,'files' => $file_data,'table' => $table_name];
        } else {
            return ['status' => 'failed'];
        }
    }

    /*
    Get Add related data
    -------------------------------------------*/
    public function get_subRecords($params)
    {
        $recordTypeId = $params['rel_type_id'];
        $record_id = $params['rid'];
        $user_id = $this->session->userdata('user_id');
        $table_name = $this->get_table($recordTypeId);
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $info = $this->mongodb->get('Projects');
        $collaboration_info = $info[0]['Collaboration'];
        if ($collaboration_info == 'collaborated') {
            $user_id = $info[0]['UserId'];
        }
        if (!empty($table_name) && $table_name != 'failed') {
            $this->mongodb->where(['UserId' => mongo_id($user_id),'ParentRecordId' => mongo_id($record_id)]);
            $qry = $this->mongodb->get($table_name);
            foreach ($qry as $key) {
                $data[] = $key;
                $rec_id = $key['RecordId'];
                $sub_rec_arr[] = $key;
                $this->mongodb->where(['UserId' => mongo_id($user_id),'RecordId' => mongo_id($rec_id), 'RecordTypeId' => $recordTypeId]);
                $qry = $this->mongodb->get('fs.files');
                $file_count[] = count($qry ?? []);
                foreach ($qry as $key) {
                    $file_data[] = $key;
                }
            }
            return ['status' => 'success','data' => $data,'file_count' => $file_count,'subfiles' => $file_data,'sub_recordid' => $sub_rec_arr];
        } else {
            return ['status' => 'failed'];
        }
    }

    /*
    Delete Sub Record
    ------------------------------------------*/
    public function deleteSubRecord($params)
    {
        $record_id = $params['rec_id'];
        $parent_rec_id = $params['p_rid'];
        $rec_type_id = $params['rel_type_id'];
        $user_id = $this->session->userdata('user_id');
        $table_name = $this->get_table($rec_type_id);

        if (!empty($table_name) && $table_name != 'failed') {
            $this->mongodb->where(['UserId' => mongo_id($user_id), 'RecordId' => mongo_id($record_id),'ParentRecordId' => mongo_id($parent_rec_id)]);
            $qresult = $this->mongodb->delete($table_name);
            if ($qresult) {
                $qry1 = $this->db->query('SELECT * FROM ' . TBL_DOCUMENTS . " WHERE  RecordId = '$record_id' AND UserId = '$user_id' AND RecordTypeId = '$rec_type_id' ");
                if ($qry1->num_rows() > 0) {
                    foreach ($qry1->result_array() as $doc) {
                        $document_id = $doc['DocumentId'];
                        $db_document_filename = $doc['DocumentPath'];
                        $doc_path = '../../..' . $db_document_filename;
                        if (file_exists($doc_path)) {
                            unlink($doc_path);
                        }
                        $delqry = $this->db->query('DELETE FROM ' . TBL_DOCUMENTS . " WHERE DocumentId = '$document_id' AND RecordId = '$record_id' AND UserId = '$user_id' AND RecordTypeId = '$rec_type_id' ");
                    }
                }
                return 'success';
            } else {
                return 'failed';
            }
        } else {
            return 'failed';
        }
    }

    /*
    Get Table Name
    -------------------------------------------*/
    public function get_table($RecordTypeId)
    {
        if (!empty($RecordTypeId)) {
            $this->mongodb->where(['RecordTypeId' => $RecordTypeId]);
            $dbtable = TBL_RECORDTYPE;
            $dbresult = $this->mongodb->get($dbtable);
            $RecordDetails = $dbresult;
            return $RecordDetails[0]['DBTable'];
        } else {
            return 'failed';
        }

    }

    public function get_tabName($RecordTypeId)
    {
        if (!empty($RecordTypeId)) {
            $this->mongodb->where(['RecordTypeId' => $RecordTypeId]);
            $dbtable = TBL_RECORDTYPE;
            $dbresult = $this->mongodb->get($dbtable);
            $RecordDetails = $dbresult;
            return $RecordDetails[0]['RecordType'];
        } else {
            return 'failed';
        }

    }
    public function get_moduleName($RecordTypeId)
    {
        if (!empty($RecordTypeId)) {
            $this->mongodb->where(['RecordTypeId' => $RecordTypeId]);
            $dbtable = TBL_RECORDTYPE;
            $dbresult = $this->mongodb->get($dbtable);
            $RecordDetails = $dbresult;
            return $RecordDetails[0]['Module'];
        } else {
            return 'failed';
        }

    }

    /*
    Edit single record data
    ------------------------------------------*/
    public function get_editrecord_data($record_id, $record_type_id)
    {
        $user_id = $this->session->userdata('user_id');
        $tableName = $this->get_table($record_type_id);
        $this->mongodb->where(['RecordId' => mongo_id($record_id), 'UserId' => mongo_id($user_id)]);
        $data_qry = $this->mongodb->get($tableName);
        foreach ($data_qry as $key) {
            $record_data[] = $key;
        }
        $this->mongodb->where(['UserId' => mongo_id($user_id), 'RecordId' => mongo_id($record_id), 'RecordTypeId' => $record_type_id]);
        $file_qry = $this->mongodb->get('fs.files');
        foreach ($file_qry as $key) {
            $file_data[] = $key;
        }

        return ['data' => $record_data,'files' => $file_data];
    }

    /*
    Validate parameters
    ---------------------------------------*/
    public function validation_check($params)
    {
        foreach ($params as $key => $value) {
            if (empty($value)) {
                return false;
            }
        }
        return true;
    }

    /*
    Delete Single attachment(from edit mode)
    ---------------------------------------*/
    public function delete_single_rec($params)
    {
        $document_id = $params['docid'];
        $user_id = $this->session->userdata('user_id');
        $record_id = $params['rid'];
        $record_type_id = $params['page_refer_id'];
        $this->mongodb->where(['DocumentId' => mongo_id($document_id),'UserId' => mongo_id($user_id), 'RecordId' => mongo_id($record_id), 'RecordTypeId' => $record_type_id]);
        $qry = $this->mongodb->get('fs.files');

        if (count($qry ?? []) > 0) {
            /*$doc = $qry1->row_array();
            $db_document_filename=$doc["DocumentPath"];
            $doc_path = "../../.." . $db_document_filename;
            if (file_exists($doc_path)) {
                unlink($doc_path);
            }*/
            $this->mongodb->where(['DocumentId' => mongo_id($document_id),'UserId' => mongo_id($user_id), 'RecordId' => mongo_id($record_id), 'RecordTypeId' => $record_type_id]);
            $qry = $this->mongodb->delete('fs.files');
            return ['status' => 'Success'];

            /*	$delqry = $this->db->query("DELETE FROM ".TBL_DOCUMENTS." WHERE DocumentId = '$document_id' AND RecordId = '$record_id' AND UserId = '$user_id' AND RecordTypeId = '$record_type_id' ");
                if($delqry){
                    $this->db->query("DELETE FROM ".TBL_KART." WHERE DocumentId = '$document_id' AND UserId = $user_id ");
                    return array("status"=>"Success");
                }
                else{
                    return array("status"=>"Failed");
                }*/
        }
    }

    /*
    Folder Files
    ----------------------------------------------*/
    public function folderfiles($rec_type_id)
    {
        $user_id = $this->session->userdata('user_id');
        $this->mongodb->order_by(['TS' => 'DESC']);
        $this->mongodb->where(['RecordTypeId' => $rec_type_id, 'UserId' => mongo_id($user_id), 'Type' => 'File', 'UploadedFrom' => 'Folder']);
        $qry = $this->mongodb->get('fs.files');
        foreach ($qry as $key) {
            $file_data[] = $key;
        }

        return ['folder' => $file_data];
    }
    public function collaboration($params)
    {
        $user_id = $this->session->userdata('user_id');
        $email = $this->session->userdata('email');
        $recordid = $params['record_id'];
        $privileges = $params['privileges'];
        $col_useremail = $params['coloborate_list'];
        $record_type_id = $params['record_type_id'];
        $table_name = $this->get_table($record_type_id);
        $useremail = explode(',', $col_useremail);
        for ($i = 0;$i < count($useremail ?? []);$i++) {
            $user_email = $useremail[$i];
            $this->mongodb->where(['Email' => $user_email]);
            $qry = $this->mongodb->get('User');
            foreach ($qry as $data) {
                $userid = $data['UserId'];
            }
            $this->mongodb->where(['touserid' => mongo_id($userid),'recordid' => mongo_id($recordid)]);
            $qury = $this->mongodb->get('privileges');
            if (count($qury ?? []) > 0) {
                $this->mongodb->where(['touserid' => mongo_id($userid),'recordid' => mongo_id($recordid)]);
                $this->mongodb->set(['editprivileges' => $privileges]);
                $query = $this->mongodb->update('privileges');
                if ($query) {
                    $this->mongodb->where(['UserId' => mongo_id($user_id),'RecordId' => mongo_id($recordid)]);
                    $this->mongodb->set(['Collaboration' => 'collaborated']);
                    $update = $this->mongodb->update($table_name);
                    if ($update) {
                        $this->mongodb->where(['RecordId' => mongo_id($recordid)]);
                        $retrieve = $this->mongodb->get($table_name);
                    }
                }
                $status_code = 1;
            } else {
                if (!empty($userid)) {
                    if ($user_id != $userid) {
                        $qry1 = $this->mongodb->insert('privileges', ['fromuserid' => mongo_id($user_id),'touserid' => mongo_id($userid),'dbname' => $record_type_id,'recordid' => mongo_id($recordid),'editprivileges' => $privileges]);
                        if ($qry1) {
                            $this->mongodb->where(['UserId' => mongo_id($user_id),'RecordId' => mongo_id($recordid)]);
                            $this->mongodb->set(['Collaboration' => 'collaborated']);
                            $update = $this->mongodb->update($table_name);
                            if ($update) {
                                $this->mongodb->where(['RecordId' => mongo_id($recordid)]);
                                $retrieve = $this->mongodb->get($table_name);
                            }
                        }
                        $status_code = 1;

                    }
                }
            }
        }
        if ($status_code == 1) {
            $status_message = 'Emails have been shared with the record details';
            return ['status' => 'success','data' => 'Data has been shared.'];
        } else {
            $status_message = 'Error: No emails have been shared. Please try again. ';
            return ['status' => 'failed','data' => 'No mails shared'];
            //    $status_style = $error_status_style;
        }
    }
    public function collaboration_rec($recordTypeId)
    {
        $table_name = $this->get_table($recordTypeId);
        $user_id = $this->session->userdata('user_id');
        $this->mongodb->where(['touserid' => mongo_id($user_id)]);
        $qry = $this->mongodb->get('privileges');
        foreach ($qry as $key) {
            $colaborate_data[] = $key;
            $record_id = $key['recordid'];
            $userid = $key['fromuserid'];
            $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
            $qury = $this->mongodb->get($table_name);
            foreach ($qury as $result) {
                $colaboration_res[] = $result;
            }
            $this->mongodb->where(['UserId' => mongo_id($userid),'RecordId' => mongo_id($record_id),'RecordTypeId' => $recordTypeId]);
            $file_count[] = $this->mongodb->count('fs.files');
        }
        return ['shared_data' => $colaboration_res,'col_files_count' => $file_count];
    }

} //End of class

/* End of file Common_model.php */
/* Location: ./application/models/Common/Common_model.php */
