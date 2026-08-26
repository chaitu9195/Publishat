<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Folder_model extends CI_Model
{
    public function folder_data($params)
    {
        $user_id = $this->session->userdata('user_id');
        $typeId = $params['typeId'];
        $qry = $this->db->query("SELECT FilePath, FileType, FileSize, TS FROM UploadFile WHERE UserId = '$user_id' AND RecordTypeId = '$typeId' ORDER BY TS DESC");
        if ($qry->num_rows() > 0) {
            foreach ($qry->result_array() as $file) {
                $files[] = $file;
            }
        } else {
            $files = 'No Files';
        }
        return ['files' => $files];
    }
    /*
    Upload files
    ------------------------------------------------------*/
    public function uploadfile($params)
    {
        $user_id = $this->session->userdata('user_id');
        $typeId = $params['typeId'];
        $module = $params['module'];
        $uploaded_filename = '';
        $file_extension = '';
        for ($i = 0;$i < count($_FILES['uploadImage']['name']);$i++) {

            if (!empty($_FILES['uploadImage']['name'])) {
                $file_size = $_FILES['uploadImage']['size'];
                $file_extension = $this->get_file_extension($_FILES['uploadImage']['name']);
                if ($file_extension == '') {
                    return ['status' => 'failed','data' => 'Invalid File Type. Only PDF, DOC, DOCX, JPEG, JPG, GIF & PNG formats are allowed'];
                }
                $uploaded_filename = $this->upload_thumbnail($params);
                if ($uploaded_filename == '') {
                    return ['status' => 'failed','data' => 'File size is too high. Document should not be more than ' . max_document_file_size_text];
                }
            }
            if (strlen($uploaded_filename) > 0) {
                $qry = $this->db->query("INSERT INTO UploadFile (RecordTypeId,UserId,FolderName,FileType,FilePath,FileSize)	
						VALUES($typeId ,$user_id,'$module','$file_extension','$uploaded_filename','$file_size')");
                if ($qry) {
                    return ['status' => 'success'];
                } else {
                    return ['status' => 'failed','data' => 'Please upload your Document'];
                }
            } else {
                return ['status' => 'failed','data' => 'Please upload your Document'];
            }

        }
    }

    /*
    Get the file extension
        -----------------------------------------*/
    public function get_file_extension($document)
    {
        $dot_index = strrpos($document, '.');
        $file_type = substr($document, $dot_index + 1);
        /*if($file_type == "pdf" || $file_type == "doc" || $file_type == "ppt" || $file_type == "xls" || $file_type == "txt" || $file_type == "pptx" || $file_type == "xlsx" || $file_type == "docx" || $file_type == "jpg" || $file_type == "JPG" || $file_type == "jpeg" || $file_type == "JPEG" || $file_type == "gif" || $file_type == "png" || $file_type == "" || $file_type == "PNG")
        {
            return $file_type;
        }
        else{
            return '';
        }
        //log_message('info','file type is');
        //log_message('info',$file_type);
        */
        return $file_type;
    }

    /* Upload file into folder*/
    public function upload_thumbnail($params)
    {
        $document = $_FILES['uploadImage'];
        $user_id = $this->session->userdata('user_id');
        if ($document['size'] > max_document_file_size) {
            return '';
        } else {
            $fileName = $_FILES['uploadImage']['name'];
            $tmp_path = $_FILES['uploadImage']['tmp_name'];
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);

            /*folder creation*/
            $document_folder = '../../fileupload/' . $user_id;
            $createFolder = $this->create_folder($document_folder);
            $document_filename = date('YmdHis') . '-' . str_replace(' ', '-', $fileName);
            $target_file_name = $document_folder . '/' . $document_filename;
            $db_document_filename = str_replace('../..', '', $target_file_name);
            /*end*/
            /*$fileName = uniqid() . ".".$ext;
            $upload_file_path = "uploads/".$fileName;*/
            $moveResult = move_uploaded_file($tmp_path, $target_file_name);
            // Evaluate the value returned from the function if needed
            if ($moveResult == true) {
                return $db_document_filename;
            } else {
                return '';
            }
        }
    }
    /* Create folder if not available */
    public function create_folder($path)
    {
        $folder_name = strtolower($path);

        if (!is_dir($folder_name)) {   //if this folder doesn't exist
            if (!mkdir($folder_name, 0755, true)) {
                die('Failed to create folder...' . $folder_name);
                return false;
            } else {
                return true;
            }
        }
    }

}
/* End of file Folder_model.php */
/* Location: ./application/models/Global/Folder_model.php */
