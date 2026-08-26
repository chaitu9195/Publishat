<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Navheader_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function get_headerdata()
    {
        $user_id = $this->session->userdata('user_id');
        $user_id = $user_id ? $user_id : $this->input->cookie('user_id', true);

        $moduledb = [];
        $module = [];
        $submodule = [];
        $typeids = [];
        $count = [];
        $qry = $this->mongodb->get('Settings');
        foreach ($qry as $modules) {
            $moduledb[] = $modules['Module'];
        }
        $module_arr = array_keys(array_flip($moduledb));

        $this->mongodb->order_by(['DisplaySequence' => 'ASC']);
        $this->mongodb->where(['UserId' => mongo_id($user_id), 'SettingValue' => 'Y']);
        $subQry = $this->mongodb->get('AccountSettings');

        $rtMap = [];
        foreach ($this->mongodb->get('RecordType') as $rtRow) {
            if (isset($rtRow['RecordTypeId'])) {
                $rtMap[(string)$rtRow['RecordTypeId']] = isset($rtRow['DBTable']) ? $rtRow['DBTable'] : null;
            }
        }
        foreach ($module_arr as $key => $value) {
            $module[] = ['Module' => $value];
            foreach ($subQry as $key) {
                $record_type_id = $key['RecordTypeId'];
                if (!in_array($record_type_id, $typeids ?? [])) {
                    $submodule[] = $key;
                    $typeids[] = $key['RecordTypeId'];

                    $db_table = isset($rtMap[(string)$record_type_id]) ? $rtMap[(string)$record_type_id] : null;
                    if (!empty($db_table)) {
                        $this->mongodb->where(['UserId' => mongo_id($user_id)]);
                        $count[$record_type_id] = $this->mongodb->count($db_table);
                    } else {
                        $count[$record_type_id] = 0;
                    }
                }
            }
        }

        return ['module' => $module,'submod' => $submodule,'typeIds' => $typeids, 'rec_count' => $count];
    }
    public function getModules()
    {
        try {
            $sql = 'select Module from settings group by Module';
            $query = $this->db->query($sql);
            if ($query) {
                if ($query->num_rows() > 0) {
                    $returnData = $query->result_array();
                } else {
                    $returnData = [];
                }
                return $returnData;
            }
        } catch (Exception $e) {
            echo $e;
            die;
        }
    }
    public function getSubModules($Module)
    {
        try {
            $sql = "select RecordTypeId, Setting from settings where Module = '$Module'";
            $query = $this->db->query($sql);
            if ($query) {
                if ($query->num_rows() > 0) {
                    $returnData = $query->result_array();
                } else {
                    $returnData = [];
                }
                return $returnData;
            }
        } catch (Exception $e) {
            echo $e;
            die;
        }
    }
}
