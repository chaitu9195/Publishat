<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Summary_model extends CI_Model
{
    public function getuserinfo()
    {
        $user_id = $this->session->userdata('user_id');
        $this->mongodb->where(['UserId' => mongo_id($user_id)]);
        $query = $this->mongodb->get('User');
        if (count($query ?? []) > 0) {
            foreach ($query as $data) {
                $user_data[] = $data;
            }
        }
        return ['userinfo' => $user_data];
    }
    public function user_info_update($params)
    {
        $user_id = $this->session->userdata('user_id');
        $this->mongodb->where(['UserId' => mongo_id($user_id)]);
        $qry = $this->mongodb->get('User');
        foreach ($qry as $res) {
            $photo_path = $res['PhotoPath'];
        }
        $uploaded_filename = '';
        $file_extension = '';
        if (!empty($_FILES['UpdProfilePhoto']['name'])) {
            $uploaded_filename = $this->upload_thumbnail($params);
            unlink('../..' . $photo_path);
        } else {
            $uploaded_filename = $photo_path;
        }
        $name = $params['name'];
        $email = $params['email'];
        $uid = $params['uid'];
        $gender = $params['gender'];
        $dob = $params['dob'];
        $phone = $params['phone'];
        $address = $params['address'];
        $stat = $params['state'];
        $weight = $params['weight'];
        $height = $params['height'];
        $height_measurement = $params['height_measurement'];
        $blood_group = $params['blood_group'];
        $bmi = $params['bmi'];
        $bloodpressure = $params['bloodpressure'];
        $user_details_arr = ['Name' => $name,
                                  'UID' => $uid,
                                  'Gender' => $gender,
                                  'DateOfBirth' => $dob,
                                  'Phone' => $phone,
                                  'Address' => $address,
                                  'State' => $stat,
                                  'Weight' => $weight,
                                  'Height' => $height,
                                  'HeightMeasure' => $height_measurement,
                                  'BloodGroup' => $blood_group,
                                  'BMI' => $bmi,
                                  'BloodPressure' => $bloodpressure,
                                  'PhotoPath' => $uploaded_filename,
                              ];

        $this->mongodb->where(['UserId' => mongo_id($user_id)]);
        $this->mongodb->set($user_details_arr);
        $this->mongodb->update('User');
    }

    public function get_file_extension()
    {
        $document = $_FILES['UpdProfilePhoto']['name'];
        $dot_index = strrpos($document, '.');
        $file_type = substr($document, $dot_index + 1);
        if ($file_type == 'pdf' || $file_type == 'doc' || $file_type == 'ppt' || $file_type == 'xls' || $file_type == 'txt' || $file_type == 'pptx' || $file_type == 'xlsx' || $file_type == 'docx' || $file_type == 'jpg' || $file_type == 'JPG' || $file_type == 'jpeg' || $file_type == 'JPEG' || $file_type == 'gif' || $file_type == 'png' || $file_type == '' || $file_type == 'PNG') {
            return $file_type;
        } else {
            return '';
        }

        return $file_type;
    }

    public function upload_thumbnail($params)
    {
        $document = $_FILES['UpdProfilePhoto'];
        $user_id = $this->session->userdata('user_id');
        if ($document['size'] > max_document_file_size) {
            return '';
        } else {
            $fileName = $_FILES['UpdProfilePhoto']['name'];
            $tmp_path = $_FILES['UpdProfilePhoto']['tmp_name'];
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);

            $document_folder = '../../profile/' . $user_id;
            $createFolder = $this->create_folder($document_folder);
            $document_filename = date('YmdHis') . '-' . str_replace(' ', '-', $fileName);
            $target_file_name = $document_folder . '/' . $document_filename;
            $db_document_filename = str_replace('../..', '', $target_file_name);

            $moveResult = move_uploaded_file($tmp_path, $target_file_name);

            if ($moveResult == true) {
                return $db_document_filename;
            } else {
                return '';
            }
        }
    }

    public function create_folder($path)
    {
        $folder_name = strtolower($path);

        if (!is_dir($folder_name)) {
            if (!mkdir($folder_name, 0755, true)) {
                die('Failed to create folder...' . $folder_name);
                return false;
            } else {
                return true;
            }
        }
    }
}
