<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cart_model extends CI_Model
{
    public function getkart_data($record_id, $record_type_id)
    {
        $user_id = $this->session->userdata('user_id');
        $this->mongodb->where([
            'UserId' => mongo_id($user_id),
            'RecordId' => mongo_id($record_id),
            'RecordTypeId' => $record_type_id,
        ]);
        $file_qry = $this->mongodb->get('fs.files');
        if (count($file_qry ?? []) > 0) {
            foreach ($file_qry as $key) {
                $file_data[] = $key;
            }
            $this->mongodb->order_by(['Id' => 'DESC']);
            $this->mongodb->where(['UserId' => mongo_id($user_id)]);
            $qry = $this->mongodb->get('kart');
            foreach ($qry as $name) {
                $kartNames[] = $name['KartName'];
            }

            $kartNames = array_keys(array_flip($kartNames ?? []));
            return ['status' => 'success', 'files' => $file_data, 'kartNames' => $kartNames];
        } else {
            return ['status' => 'failed', 'data' => 'Add files to record before adding to kart'];
        }
    }

    public function savetocart($params)
    {
        $user_id = $this->session->userdata('user_id');
        $document_id = $params['document_id'];
        $record_type_id = $params['record_type_id'];
        $module = ucfirst($params['module']);
        $submod = $params['submod'];
        $path = $module . '/' . $submod;
        $name = $params['kartName'];
        if ($name == 'addnew') {
            $name = $params['newName'];
        }

        $this->mongodb->where(['KartName' => $name, 'UserId' => mongo_id($user_id)]);
        $kartqry = $this->mongodb->get('kartname');
        if (count($kartqry ?? []) == 0) {
            $this->mongodb->insert('kartname', ['UserId' => mongo_id($user_id), 'KartName' => $name]);
        }

        if (count($document_id ?? []) > 0) {
            foreach ($document_id as $id) {
                $this->mongodb->where(['UserId' => mongo_id($user_id), 'DocumentId' => mongo_id($id)]);
                $qry = $this->mongodb->get('fs.files');
                $doc = $qry;
                $doc_id = $doc[0]['DocumentId'];
                $doc_path = $doc[0]['DocumentPath'];
                $filename = $doc[0]['filename'];
                $ext = $doc[0]['FileType'];
                if (empty($ext)) {
                    $ext = $this->get_file_extension($filename);
                }
                $label = $doc[0]['Notes'];
                $label = !empty($label)
                    ? $label
                    : ucfirst(strtolower(substr(strstr(pathinfo($doc_path, PATHINFO_FILENAME), '-'), 1, 15)));
                if ($doc_path) {
                    $kart_data = [
                        'DocumentId' => mongo_id($doc_id),
                        'UserId' => mongo_id($user_id),
                        'KartName' => $name,
                        'DocumentPath' => $doc_path,
                        'FileType' => $ext,
                        'Notes' => $label,
                        'Path' => $path,
                    ];
                } else {
                    $kart_data = [
                        'DocumentId' => mongo_id($doc_id),
                        'UserId' => mongo_id($user_id),
                        'KartName' => $name,
                        'filename' => $filename,
                        'DocumentPath' => '',
                        'FileType' => $ext,
                        'Path' => $path,
                    ];
                }
                $cartqry = $this->mongodb->insert('kart', $kart_data);
                if ($cartqry) {
                    $status = 'success';
                    $data = 'Files added to cart';
                } else {
                    $status = 'failed';
                    $data = 'Something went wrong with query';
                }
            }
        } else {
            $status = 'failed';
            $data = 'No documents Selected';
        }
        return ['status' => $status, 'data' => $data];
    }

    public function dcart_data()
    {
        $user_id = $this->session->userdata('user_id');
        $this->mongodb->order_by(['KartName' => 'ASC']);
        $this->mongodb->where(['UserId' => mongo_id($user_id)]);
        $qry = $this->mongodb->get('kart');
        foreach ($qry as $name) {
            $kartNames[] = $name['KartName'];
        }
        $lastinserted = $kartNames[0];
        $kartNames = array_keys(array_flip($kartNames ?? []));
        $this->mongodb->order_by(['KartName' => 'ASC']);
        $this->mongodb->where(['UserId' => mongo_id($user_id), 'KartName' => $lastinserted]);
        $qry = $this->mongodb->get('kart');
        foreach ($qry as $val) {
            $cartdata[] = $val;
        }
        return ['status' => 'success', 'cart_names' => $kartNames, 'data' => $cartdata];
    }

    public function cname_data($cartName)
    {
        $user_id = $this->session->userdata('user_id');

        $this->mongodb->where(['UserId' => mongo_id($user_id), 'KartName' => $cartName]);
        $qry = $this->mongodb->get('kart');
        foreach ($qry as $val) {
            $cartdata[] = $val;
        }

        return ['status' => 'success', 'data' => $cartdata];
    }

    public function delete_record($params)
    {
        $user_id = $this->session->userdata('user_id');
        $document_ids = explode(',', $params['del_doc_id']);
        $cartname = $params['cartname'];
        if (count($document_ids ?? []) > 0) {
            foreach ($document_ids as $id) {
                if (empty($cartname)) {
                    $this->mongodb->where(['DocumentId' => mongo_id($id)]);
                } else {
                    $this->mongodb->where(['DocumentId' => mongo_id($id), 'KartName' => $cartname]);
                }

                $qry = $this->mongodb->delete('kart');
                if ($qry) {
                    $status = 'success';
                } else {
                    $status = 'failed';
                }
            }
        } else {
            $status = 'failed';
        }
        return $status;
    }

    public function delete_cart_record($params)
    {
        $user_id = $this->session->userdata('user_id');
        $cartname = $params['cart_name'];
        $this->mongodb->where(['UserId' => mongo_id($user_id), 'KartName' => $cartname]);
        $qry = $this->mongodb->delete('kart');
        if ($qry) {
            $status = 'success';
        } else {
            $status = 'failed';
        }
        return $status;
    }

    public function get_file_extension($file_name)
    {
        $dot_index = strrpos($file_name, '.');
        $file_type = substr($file_name, $dot_index + 1);
        return $file_type;
    }
}
