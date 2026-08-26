<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Folder_model extends CI_Model
{
    public function folder_data($params)
    {
        $user_id = $this->session->userdata('user_id');
        $typeId = $params['typeId'];
        $this->mongodb->order_by(['TS' => 'DESC']);
        $this->mongodb->where([
            'UserId' => mongo_id($user_id),
            'RecordTypeId' => $typeId,
            'ParentId' => '',
            'UploadedFrom' => 'Folder',
        ]);
        $qry = $this->mongodb->get('fs.files');
        if (count($qry ?? []) > 0) {
            foreach ($qry as $file) {
                $files[] = $file;
            }
        } else {
            $files = 'No Files';
        }

        $files = $this->msort($files, ['Type', 'TS']);
        log_message('info', json_encode($files));
        return ['files' => $files];
    }
    public function bookmark_data($params)
    {
        $user_id = $this->session->userdata('user_id');
        $typeId = $params['typeId'];
        $this->mongodb->order_by(['Date' => 'DESC']);
        $this->mongodb->where([
            'UserId' => mongo_id($user_id),
            'RecordTypeId' => $typeId,
        ]);
        $qry = $this->mongodb->get('Bookmarks');
        if (count($qry ?? []) > 0) {
            foreach ($qry as $data) {
                $bookmarkdata[] = $data;
            }
        } else {
            $bookmarkdata = 'No Files';
        }
        return ['bookmarksdata' => $bookmarkdata];
    }

    public function uploadfile($params)
    {
        $user_id = $this->session->userdata('user_id')
            ? mongo_id($this->session->userdata('user_id'))
            : mongo_id($params['UserId']);
        $record_type_id = $params['typeId'];
        $folder_id = $params['foldid'];
        if ($folder_id) {
            $folder_id = mongo_id($folder_id);
        }
        $this->mongodb->where(['RecordTypeId' => $record_type_id]);
        $qry = $this->mongodb->get('Folders');
        $rec = $qry;
        $folder_name = $rec[0]['FolderName'];
        $date = date('Y-m-d H:i:s');
        if (count($_FILES['uploadedfile']['name']) > 0) {
            $mongo_connection = new MongoClient();
            $gridfs = $mongo_connection
                ->selectDB('publisha_dbase')
                ->getGridFS();
            $gridfs->storeUpload('uploadedfile', [
                'UserId' => $user_id,
                'RecordTypeId' => $record_type_id,
                'FolderName' => $folder_name,
                'ParentId' => $folder_id,
                'Type' => 'File',
                'TS' => $date,
                'UploadedFrom' => 'Folder',
            ]);
            $status = 'success';
        } else {
            $status = 'failed';
        }
        return ['status' => $status];
    }

    public function delete_file($params)
    {
        $user_id = $this->session->userdata('user_id');
        $document_ids = explode(',', $params['del_doc_id']);
        $typeId = $params['typeId'];
        if (count($document_ids ?? []) > 0) {
            foreach ($document_ids as $id) {
                $this->mongodb->where([
                    '_id' => mongo_id($id),
                    'RecordTypeId' => $typeId,
                ]);
                $qry = $this->mongodb->get('fs.files');
                if (count($qry ?? []) > 0) {
                    $rec = $qry;
                    $filetype = $rec[0]['Type'];
                    if ($filetype == 'Folder') {
                        $this->mongodb->where([
                            'RecordTypeId' => $typeId,
                            'UserId' => mongo_id($user_id),
                            'ParentId' => mongo_id($id),
                        ]);
                        $qry = $this->mongodb->get('fs.files');
                        if (count($qry ?? []) > 0) {
                            $status = 'FolderData';
                        } else {
                            $m = new MongoClient();
                            $con = $m->SelectDB('publisha_dbase')->getGridFS();
                            $qry = $con->remove([
                                '_id' => mongo_id($id),
                                'RecordTypeId' => $typeId,
                            ]);
                            if ($qry) {
                                $status = 'success';
                            }
                        }
                    } elseif ($filetype == 'File') {
                        $doc_path = '../../' . $rec[0]['FilePath'];
                        if (file_exists($doc_path)) {
                            unlink($doc_path);
                        }
                        $m = new MongoClient();
                        $con = $m->SelectDB('publisha_dbase')->getGridFS();
                        $qry = $con->remove([
                            '_id' => mongo_id($id),
                            'RecordTypeId' => $typeId,
                        ]);
                        if ($qry) {
                            $status = 'success';
                        } else {
                            $status = 'failed';
                        }
                    }
                } else {
                    $status = 'failed';
                }
            }
        } else {
            $status = 'failed';
        }
        return $status;
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
    public function createfolder($params)
    {
        $folder_name = $params['folder_name'];
        $folder_id = $params['folder_id'];
        $record_type_id = $params['typeId'];
        $module = $params['module'];
        $user_id = $this->session->userdata('user_id');
        $date = TimeStamp;
        if ($folder_id) {
            $folder_id = mongo_id($folder_id);
        }
        $this->mongodb->where([
            'FolderName' => $folder_name,
            'ParentId' => $folder_id,
            'UserId' => mongo_id($user_id),
            'Type' => 'Folder',
            'RecordTypeId' => $record_type_id,
        ]);
        $qry = $this->mongodb->get('fs.files');
        if (count($qry ?? []) == 0) {
            $folder_data = [
                'UserId' => mongo_id($user_id),
                'RecordTypeId' => $record_type_id,
                'FolderName' => $folder_name,
                'Type' => 'Folder',
                'ParentId' => $folder_id,
                'UploadedFrom' => 'Folder',
                'TS' => $date,
            ];
            $res = $this->mongodb->insert('fs.files', $folder_data);
            return ['status' => 'success', 'typeId' => $record_type_id];
        } else {
            return ['status' => 'failure'];
        }
    }

    public function getfolderfilesdata($fid, $type_id, $module)
    {
        $user_id = $this->session->userdata('user_id');
        $this->mongodb->order_by(['TS' => 'DESC']);
        if ($fid != '') {
            $fid = mongo_id($fid);
        }
        $this->mongodb->order_by(['TS' => 'DESC']);
        $this->mongodb->where([
            'UserId' => mongo_id($user_id),
            'ParentId' => $fid,
            'RecordTypeId' => $type_id,
            'UploadedFrom' => 'Folder',
        ]);
        $qry = $this->mongodb->get('fs.files');
        foreach ($qry as $folderfile) {
            $ff[] = $folderfile;
        }

        $i = $fid;
        while ($i != '') {
            $this->mongodb->where([
                'UserId' => mongo_id($user_id),
                '_id' => mongo_id($i),
            ]);
            $qury = $this->mongodb->get('fs.files');
            $result = $qury;
            foreach ($qury as $row) {
                $data[] = $row;
            }
            $f_id = $result[0]['ParentId'];
            $i = $f_id;
        }
        $ff = $this->msort($ff, ['Type', 'TS']);
        $data = $this->msort($data, ['Type', 'TS'], SORT_REGULAR, SORT_ASC);
        return [
            'ff' => $ff,
            'fdetails' => $data,
            'typeId' => $type_id,
            'module' => $module,
        ];
    }
    public function getmapsdata()
    {
        $m = new MongoClient();
        $db = $m->jobs;
        $collection = $db->printers;
        $query = $collection->find();
        return $query;
    }
    public function pageinfo($params)
    {
        $user_id = $this->session->userdata('user_id');
        $filename = $params['filename'];
        $color = $params['colorselection'];
        $print_type = $params['print_type'];
        $code = $params['code'];
        $copies = $params['copies'];
        $pages_count = $params['pagescount'];
        $date = date('YmdhisA');
        $m = new MongoClient();
        $db = $m->jobs;
        $collection = $db->printRates;
        $query = $collection->findOne(['printercode' => $code]);
        $printercode = $query['printercode'];
        $pbw = $query['pbw'];
        $pco = $query['pco'];
        $lbw = $query['lbw'];
        $lco = $query['lco'];
        $lor = $query['lor'];
        if ($print_type == 'Portriate' && $color == 'Black and White') {
            $cost = $pbw;
        } elseif ($print_type == 'Portriate' && $color == 'Color') {
            $cost = $pco;
        } elseif ($print_type == 'Landscape' && $color == 'Black and White') {
            $cost = $lbw;
        } elseif ($print_type == 'Landscape' && $color == 'Color') {
            $cost = $lco;
        } elseif (
            ($print_type == 'Portriate' || $print_type == 'Landscape') &&
            $color == 'LOR'
        ) {
            $cost = $lor;
        } elseif ($color == 'Black and White' && $print_type == 'Project') {
            $cost = $pbw;
        }

        $totalcost = $cost * $pages_count * $copies;
        if ($print_type == 'Project') {
            $ProjectPageNos = $params['ProjectPageNos'];
            $ProjectColorPagesCount = count(array_filter($ProjectPageNos));
            $costForProjectColorPrint =
                $ProjectColorPagesCount * $pco * $copies;
            $totalcost = $totalcost + $costForProjectColorPrint;
        }

        return $totalcost;
    }
    public function colorselection($params)
    {
        $color = $params['color'];
        $copies = $params['copies'];
        $pagescount = $params['pagescount'];
        $user_id = $this->session->userdata('user_id');
        $qury = $this->db->query(
            "SELECT * FROM PrintProperties WHERE  Color = '$color'",
        );
        $result = $qury->row_array();
        $cost = $result['Cost'];
        $totalcost = $cost * $copies * $pagescount;
        return ['cost' => $totalcost];
    }
    public function locationsearchdata($params)
    {
        $location = $params['location'];
        $regex = new MongoRegex("/$location/i");
        $where = [
            '$or' => [
                ['address' => $regex],
                ['name' => new MongoRegex("/$location/i")],
            ],
        ];

        $m = new MongoClient();
        $db = $m->jobs;
        $collection = $db->printers;
        $query = $collection->find($where);

        foreach ($query as $result) {
            $data[] = $result;
            $loc[] = $result['name'];
        }
        return ['data' => $data, 'location' => $loc];
    }

    public function document_validation($user_id)
    {
        $docs = [];
        if (!empty($_FILES['uploadImage']['name'])) {
            $uploaded_filename = $this->upload_thumbnail($user_id);
            if (!$uploaded_filename) {
                return [
                    'status' => 'failed',
                    'data' =>
                        'File size is too high. Document should not be more than ' .
                        max_document_file_size_text,
                ];
            }
            $docs = [
                'ext' => $file_extension,
                'filename' => $uploaded_filename,
            ];
        }
        return $docs;
    }
    public function get_file_extension()
    {
        $document = $_FILES['uploadImage']['name'];
        $dot_index = strrpos($document, '.');
        $file_type = substr($document, $dot_index + 1);
        if (
            $file_type == 'pdf' ||
            $file_type == 'doc' ||
            $file_type == 'ppt' ||
            $file_type == 'xls' ||
            $file_type == 'txt' ||
            $file_type == 'pptx' ||
            $file_type == 'xlsx' ||
            $file_type == 'docx' ||
            $file_type == 'jpg' ||
            $file_type == 'JPG' ||
            $file_type == 'jpeg' ||
            $file_type == 'JPEG' ||
            $file_type == 'gif' ||
            $file_type == 'png' ||
            $file_type == '' ||
            $file_type == 'PNG'
        ) {
            return $file_type;
        } else {
            return false;
        }

        return $file_type;
    }
    public function upload_thumbnail($user_id)
    {
        $document = $_FILES['uploadImage'];
        $Upgraded = $this->session->userdata('Upgraded');
        if ($Upgraded == 'Y') {
            $db_document_filename = $_FILES['uploadImage']['name'];
            $moveResult = true;
            if ($moveResult == true) {
                return $db_document_filename;
            }
        }
        if ($document['size'] > max_document_file_size) {
            return false;
        } else {
            $db_document_filename = $_FILES['uploadImage']['name'];
            $moveResult = true;
            if ($moveResult == true) {
                return $db_document_filename;
            }
        }
    }
    public function msort(
        $array,
        $key,
        $sort_flags = SORT_REGULAR,
        $order = SORT_DESC,
    ) {
        if (is_array($array) && count($array ?? []) > 0) {
            if (!empty($key)) {
                $mapping = [];
                foreach ($array as $k => $v) {
                    $sort_key = '';
                    if (!is_array($key)) {
                        $sort_key = $v[$key];
                    } else {
                        foreach ($key as $key_key) {
                            $sort_key .= $v[$key_key];
                        }
                        $sort_flags = SORT_STRING;
                    }
                    $mapping[$k] = $sort_key;
                }
                switch ($order) {
                    case SORT_ASC:
                        asort($mapping, $sort_flags);
                        break;
                    case SORT_DESC:
                        arsort($mapping, $sort_flags);
                        break;
                }
                $sorted = [];
                foreach ($mapping as $k => $v) {
                    $sorted[] = $array[$k];
                }
                return $sorted;
            }
        }
        return $array;
    }
    public function getPrintHistory($idUser)
    {
        $m = new MongoClient();
        $db = $m->jobs;
        $collection = $db->job;
        $where = ['idUser' => $idUser];
        $result = $collection->find($where)->sort(['datetime' => -1]);
        foreach ($result as $rowData) {
            $data[] = $rowData;
        }

        return $data;
    }
}
