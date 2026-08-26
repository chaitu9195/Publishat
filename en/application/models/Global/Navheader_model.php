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
        // Initialise all accumulators so array functions (in_array/count/array_flip)
        // never receive null when a query returns nothing (fatal on PHP 8).
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
        // Pre-fetch RecordType -> DBTable once (was one Mongo query per section).
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
        /*
         foreach($module_arr as $key){
            $module[] = array("Module"=>$key);
            $mod = $key;


              foreach($subQry as $key){
                $submodule[] = $key;
                $typeids[] = $key['RecordTypeId'];
                $record_type_id = $key['RecordTypeId'];
                $this->mongodb->where(array("RecordTypeId"=>$record_type_id));
                $db_qry = $this->mongodb->get("RecordType");
                $db_table_arr = $db_qry;


                $db_table = $db_table_arr[0]["DBTable"];
                $this->mongodb->where(array("UserId"=>mongo_id($user_id)));
                $count_qry = $this->mongodb->get($db_table);

                $count[] = count($count_qry ?? array());
                $count[] = 0;

              }

         }  */
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

/* End of file Navheader_model.php */
/* Location: ./application/models/Global/Navheader_model.php */
