<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Log_model extends CI_Model
{
    public function log_data($params)
    {
        $event_name = $params['event'];
        $page = $params['page'];
        if (empty($page)) {
            $page = 1;
        }
        $start = ($page * recordsPerPage) - recordsPerPage;
        $end = recordsPerPage;
        //echo $page; echo $start; echo $end;

        $user_id = $this->session->userdata('user_id');
        if ($event_name == 'All') {
            $this->mongodb->where(['UserId' => mongo_id($user_id)]);
        } else {
            $this->mongodb->where(['UserId' => mongo_id($user_id), 'EventType' => $event_name]);
        }
        $this->mongodb->order_by(['Date' => 'DESC']);
        //$qry = $this->mongodb->limit($start, $perPage)->get("events");
        //$this->mongodb->offset($start);
        $this->mongodb->offset($start);
        $this->mongodb->limit($end);
        $qry = $this->mongodb->get('events');

        if (count($qry ?? []) > 0) {
            foreach ($qry as $log) {
                $user_id = (string)$log['UserId'];
                $id = (string)$log['_id'];
                unset($log['_id']);
                unset($log['UserId']);
                $log['UserId'] = $user_id;
                $log['_id'] = $id;
                $log['ename'] = $event_name;
                $logs[] = $log;

            }

        } else {
            $logs = 'No Log Found';
        }
        return ['log' => $logs, 'e_name' => $event_name];

    }
}
/* End of file Log_model.php */
/* Location: ./application/models/Global/Log_model.php */
