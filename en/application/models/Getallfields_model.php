<?php

class Getallfields_model extends CI_Model
{
    public function get_allfields($recTypeId, $user_id, $addRelated)
    {
        $this->load->database();

        $record_type_id = $recTypeId;
        $condition = ' AND addRelated = 0';
        if ($addRelated) {
            $condition = ' AND addRelated = 1';
        }
        $qry = $this->db->query('SELECT * FROM ' . TBL_DYNAMIC . " WHERE RecordTypeId = '$record_type_id' $condition  ORDER BY FieldSequence ");
        if ($qry->num_rows() > 0) {
            $resultSet = $qry->result_array();
            foreach ($resultSet as $singleRow) {
                $fldId = $singleRow['Id'];
                $groupdropdownarray = [];
                if ($fldId == 558) {
                    $dropdown = $this->db->query('SELECT id as Id,GroupName as DropdownValues FROM ' . TBL_GROUPNAMES . " WHERE UserId = '$user_id' ");
                    $groupdropdownarray[] = ['Id' => '7096','DropdownValues' => 'Add New Group','isdropdownvalue' => '1','ids' => '560','isDepend' => '1'];
                } else {
                    $dropdown = $this->db->query("SELECT df.*,IF (df.ids IS NULL OR df.ids='' ,0,1) AS isdropdownvalue FROM " . TBL_DROPDOWNFIELDS . " as df WHERE df.FieldId = $fldId  ORDER BY Id ASC");
                }

                if ($dropdown->num_rows() > 0) {
                    if (!empty($groupdropdownarray) && count($groupdropdownarray ?? []) > 0) {
                        $groupdropdownarray = array_merge($groupdropdownarray ?? [], $dropdown->result_array());
                    } else {
                        $groupdropdownarray = $dropdown->result_array();
                    }
                    $dropdownarray = ['dropDownValues' => $groupdropdownarray];
                    $completeArray[] = array_merge($singleRow ?? [], $dropdownarray ?? []);
                } else {
                    if (!empty($groupdropdownarray) && count($groupdropdownarray ?? []) > 0) {
                        $dropdownarray = ['dropDownValues' => $groupdropdownarray];
                        $completeArray[] = array_merge($singleRow ?? [], $dropdownarray ?? []);
                    } else {
                        $completeArray[] = $singleRow;
                    }
                }
            }
            return ['status' => 'success','data' => $completeArray];
        } else {
            return ['status' => 'failed','data' => 'No data found'];
        }
    }

    public function get_dropdowndata($params)
    {
        $this->load->database();
        $field_id = $params['field_id'];
        $qry = $this->db->query('SELECT * FROM ' . TBL_DROPDOWNFIELDS . " WHERE FieldId = '$field_id' ORDER BY Id ASC ");
        if ($qry->num_rows() > 0) {
            $resultSet = $qry->result_array();
            return ['status' => 'success','data' => $resultSet];
        } else {
            return ['status' => 'failed','data' => 'No data found'];
        }
    }
}
