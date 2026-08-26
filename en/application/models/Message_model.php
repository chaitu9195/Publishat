<?php

date_default_timezone_set('Asia/Kolkata');
class Message_model extends CI_Model
{
    /**
     * Login Check
     */

    public function message_sent($params)
    {
        $this->load->database();

        $eventtype = $params['Eventtype'];
        $eventname = $params['Eventname'];
        $message = $params['Message'];
        $group = $params['Group'];
        $mailto = $params['Mailto'];
        $from_email = 'admin@publishat.com';
        $subject = 'NTR Blood Bank';
        $email_template = 'mailtemplates/message_template.html';
        $email_arr = explode(',', trim($mailto));
        if (count($email_arr ?? []) > 0) {
            foreach ($email_arr as $to_email) {

                $from_email = admin_from_email;
                $subject = 'NTR BLOOD BANK';
                $email_body = $this->read_file($email_template);

                $type = 'html';
                $email_body = str_replace('##Event-Type##', $eventtype, $email_body);
                $email_body = str_replace('##Event-Name##', $eventname, $email_body);
                $email_body = str_replace('##Message##', $message, $email_body);

                $mailStatus = $this->publishmail($from_email, $to_email, $subject, $email_body, $type);

            }
            return ['status' => 'success'];
        }
    }

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
    public function publishmail($from_email, $to_email, $subject, $message, $type)
    {
        $config = [
        //  'protocol' => protocol,
          'smtp_host' => smtp_host,
          'smtp_port' => smtp_port,
          'smtp_user' => smtp_user, // change it to yours
          'smtp_pass' => smtp_pass, // change it to yours
          'mailpath' => mailpath,
          'charset' => charset,
          'wordwrap' => wordwrap,
        ];

        if ($type == 'html') {   //html email

            $mailheaders = 'From:' . admin_from_email . "\r\n" .
                           "MIME-Version:1.0\r\n" .
                           "Content-type:text/html\r\n" .
                           "Content-Transfer-Encoding:7bit\n" .
                           'Reply-To: ' . admin_from_email . "\n";
        } else {     // text email
            $mailheaders = 'From:' . admin_from_email . "\r\nMIME-Version: 1.0\r\nContent-type:" .
                           "text/plain\r\nContent-Transfer-" .
                           "Encoding: 7bit\n" .
                           'Reply-To: ' . admin_from_email . "\n";
        }
        //mail ( $to_email, $subject, $message, $mailheaders );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from(noreply); // change it to yours
        $this->email->to($to_email);// change it to yours
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->set_mailtype('html');
        //$this->email->mailheaders($mailheaders);
        if (mail($to_email, $subject, $message, $mailheaders)) {

            return true;
        } else {
            show_error($this->email->print_debugger());
        }

    }

}
