<?php

class Mailcartitems_model extends CI_Model
{
    public function mail_from_cart($params)
    {

        $user_id = $this->session->userdata('user_id');
        $document_ids = explode(',', $params['doc_ids']);
        $addtext = $params['addtext'];
        $subject = $params['subject'];
        /*raw code start*/
        //		$doc_id_arr = $params["document_id"];
        //		$id_list = $params["document_id"];
        //		$record_id_arr = explode(",", $id_list);
        //		$addtext='';
        $this->mongodb->where(['UserId' => mongo_id($user_id)]);
        $validUser = $this->mongodb->get('User');
        if (count($validUser ?? []) > 0) {
            foreach ($validUser as $userData) {
                $user_email = $userData['Email'];
                $user_fullname = $userData['Name'];
                $user_phone = $userData['Phone'];
                if (count($document_ids ?? []) > 0) {
                    //$email_content = "<html>";
                    $email_content = header_top;
                    $table_bg_color = '#99CCCC';
                    foreach ($document_ids as $document_id) {
                        $table_bg_color = ($table_bg_color == '#CCCC99') ? '#99CCCC' : '#99CCCC';
                        $email_content .= $this->get_record_table_html($document_id, $addtext, $table_bg_color, '#FFFFFF');
                    }
                    $email_content .= header_bottom;
                    $header_title = str_replace('Publishat.com | ', '', $subject);
                    $email_content = str_replace('##HEADER-TITLE##', $header_title, $email_content);
                    $email_content = str_replace('##HEADER-EMAIL##', $user_email, $email_content);
                    $email_content = str_replace('##HEADER-NAME##', $user_fullname, $email_content);
                    $email_content = str_replace('##HEADER-PHONE##', $user_phone, $email_content);
                    $email_content = str_replace('##ADD-TEXT##', $addtext, $email_content);
                    $from_email = $this->session->userdata('email');
                    //$from_email = admin_from_email;
                    $email_list = $params['email_list'];
                    //log_message('info',$email_list);
                    if (!empty($email_list)) {
                        $email_arr = explode(',', trim($email_list));
                        if (count($email_arr ?? []) > 0) {
                            foreach ($email_arr as $out_email) {
                                $mailStatus = $this->sendcartmail($from_email, trim($out_email), $subject, $email_content);
                                $status_code = 1;
                            }
                            $eventdata = ['UserId' => mongo_id($user_id),
                     'EventType' => 'Shared',
                     'Module' => $user_fullname,
                     'Receiver' => $email_list,
                     'Date' => TimeStamp,
                  ];
                            $qry = $this->mongodb->insert(TBL_EVENTS, $eventdata);
                        }
                    }
                    if ($status_code == 1) {
                        $status_message = 'Emails have been sent with the Files';
                        return ['status' => 'success','data' => $status_message];
                    } else {
                        $status_message = 'Error: No emails have been sent. Please try again. ';
                        return ['status' => 'failed','data' => $status_message];
                    }
                }
            }
            /*raw code ends*/
        } else {
            return ['status' => 'failed','data' => 'invalid user'];
        }
    }

    /*all below functions are used for sending mail*/
    public function get_record_table_html($doc_id, $addtext, $table_bg, $tr_bg)
    {
        $email_body = '';
        $this->mongodb->where(['DocumentId' => mongo_id($doc_id)]);
        $qry = $this->mongodb->get('fs.files');
        if (count($qry ?? []) > 0) {
            $email_template = 'mailtemplates/email-showkart.html';
            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $attachments = $this->get_document_email_links2($rec['_id']);
                //log_message('info','final attachment');
                $email_body = str_replace('##ADD-TEXT##', $addtext, $email_body);
                $email_body = str_replace('##ATTACHMENTS##', $attachments, $email_body);
                //$email_body = str_replace("##NOTES##", $notes, $email_body);
                $email_body = str_replace('##TABLE_BGCOLOR##', $table_bg, $email_body);
                $email_body = str_replace('##TR_BGCOLOR##', $tr_bg, $email_body);

            }
        }
        return $email_body;
    }

    public function get_document_email_links2($record_id)
    {
        ob_start();
        //log_message('info',"SELECT * FROM ".TBL_DOCUMENTS." WHERE DocumentId = '$record_id'");
        $this->mongodb->where(['DocumentId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get('fs.files');
        if (count($qry ?? []) > 0) {
            foreach ($qry as $rec) {
                $document_id = $rec['DocumentId'];
                $user_id = $rec['UserId'];
                $file_type = $rec['FileType'];
                $doc_path = $rec['DocumentPath'];
                $filename = $rec['filename'];
                if (empty($filename)) {
                    $filename = basename($doc_path);
                    $filename = substr($filename, strpos($filename, '-') + 1);
                }
                /* if(empty($file_type)){
                 $file_type = $this->get_file_extension($filename);
                } */
                $id = $rec['_id'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                //$file_tag=strtolower(substr(strstr($filename,"-"),1));
                $documenticon = $this->get_document_icon(strtolower($ext));
                $doc_icon = 'https://www.publishat.com/' . $documenticon;
                /* $doc_tag = strtoupper($doc_tag);
                if(empty($doc_tag)){
                $doc_tag = $filename;
                } */
                $doc_link_url = 'https://www.publishat.com/digital/en/web/docviewer?fid=' . $id . '&type=' . strtolower($ext);
                $templink = "<a target='_blank' href='$doc_link_url'><img src='$doc_icon' width='20' height='20' border='0' align='absmiddle' /></a>&nbsp;
	            <a target='_blank' href='$doc_link_url'>$filename</a>";
            }
        } else {
            $templink = '<i>No documents are attached to this record</i>';
        }
        return $templink;
        /*$content = ob_get_contents();
        ob_end_clean();
        return $content;*/
    }

    /*reading file*/
    public function read_file($filename)
    {
        if (file_exists($filename)) {
            //log_message('info',$filename);
            $handle = fopen($filename, 'r');
            $contents = fread($handle, filesize($filename));
            fclose($handle);
            return $contents;
        } else {
            return '';
        }
    }

    /*mail function*/
    public function sendcartmail($from_email, $to_email, $subject, $message, $type = 'html')
    {
        $this->load->library('email');
        $config = [
          'protocol' => protocol,
          'smtp_host' => smtp_host,
          'smtp_port' => smtp_port,
          'smtp_user' => smtp_user, // change it to yours
          'smtp_pass' => smtp_pass, // change it to yours
          'mailpath' => mailpath,
          'charset' => charset,
          'wordwrap' => wordwrap,
        ];
        /* //SMTP & mail configuration
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.zoho.com',
            'smtp_port' => 465,
            'smtp_user' => 'admin@publishat.com',
            'smtp_pass' => 'Vijaya@123',
            'mailtype'  => 'html',
            'charset'   => 'utf-8'
        ); */
        $this->email->initialize($config);
        $this->email->set_mailtype('html');
        $this->email->set_newline("\r\n");

        $this->email->to($to_email);
        if ($cc) {
            $this->email->cc($cc);
        }
        // $this->email->from('from_email','Publishat');
        $this->email->from(smtp_user);
        $this->email->subject("$subject");
        $this->email->message($message);

        //Send email
        if ($this->email->send()) {

        } else {
            //Email Failed To Send
            return $this->email->print_debugger();
        }
    }

    /*get icons*/
    public function get_document_icon($file_type)
    {
        $file_type = strtolower($file_type);
        switch ($file_type) {
            case 'pdf': $icon = 'graphics/icon_pdf.png';
                break;
            case 'doc': $icon = 'graphics/icon_doc.png';
                break;
            case 'docx': $icon = 'graphics/icon_doc.png';
                break;
            case 'jpg': $icon = 'graphics/icon_jpg.png';
                break;
            case 'jpe': $icon = 'graphics/icon_jpg.png';
                break;
            case 'jpeg': $icon = 'graphics/icon_jpg.png';
                break;
            case 'gif': $icon = 'graphics/icon_gif.png';
                break;
            case 'png': $icon = 'graphics/icon_png.png';
                break;
            case 'txt': $icon = 'graphics/icon_txt.png';
                break;
            case 'xls': $icon = 'graphics/icon_xls.png';
                break;
            case 'xlsx': $icon = 'graphics/icon_xls.png';
                break;
            case 'xps': $icon = 'graphics/icon_xps.png';
                break;
            case 'zip': $icon = 'graphics/icon_zip.png';
                break;
            case 'rar': $icon = 'graphics/icon_rar.png';
                break;
            default: $icon = 'graphics/icon_pdf.png';
                break;
        }
        return $icon;
    }

    /*encryption*/
    public function encript($value)
    {
        $skey = 'hserus$#@!^&*()-';
        if (!$value) {
            return false;
        }
        $text = $value;
        // Legacy mcrypt Rijndael-256/ECB replaced by phpseclib (see legacy_crypto_helper).
        $crypttext = rijndael256_ecb_encrypt_raw($skey, $text);
        return trim($this->safe_b64encode($crypttext));
    }

    public function safe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(['+','/','='], ['-','_',''], $data);
        return $data;
    }

}
