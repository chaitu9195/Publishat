<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Articles_model extends CI_Model
{
    public function getuserinfo()
    {
        $user_id = $this->session->userdata('user_id');
        $this->mongodb->where(['UserId' => $user_id]);

        $query = $this->mongodb->get('User');
        if (count($query ?? []) > 0) {
            foreach ($query as $data) {
                $user_data[] = $data;
            }
        }
        return ['userinfo' => $user_data];
    }
    public function articles_info_data($params)
    {
        $user_id = $this->session->userdata('user_id');
        $articles_des = str_replace("'", '', $params['ArticleDescription']);

        $article_heading = $params['articleheading'];

        $article_url = $params['articleurl'];
        $params['Date'] = date('F jS\, Y ');
        $params['UserId'] = $user_id;
        $image = $_FILES['articleimg'];
        $date = date('F jS\, Y ');
        $imageName = $_FILES['articleimg']['name'];
        if (!empty($imageName)) {
            $tmp_path = $_FILES['articleimg']['tmp_name'];
            $article_image_folder = '../../articleImages';
            $image_filename =
                date('YmdHis') . '-' . str_replace(' ', '-', $imageName);
            $target_file_name = $article_image_folder . '/' . $image_filename;
            $image_path = str_replace('../..', '', $target_file_name);
            $moveResult = move_uploaded_file($tmp_path, $target_file_name);
        } else {
            $image_path = '';
        }
        $query = $this->mongodb->insert('Articles', $params);
    }
    public function articleinfo()
    {
        $query = $this->mongodb->get('Articles');
        foreach ($query as $res) {
            $article_data[] = $res;
        }
        return ['article_info' => $article_data];
    }
}
