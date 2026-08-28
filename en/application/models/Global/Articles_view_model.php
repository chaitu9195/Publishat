<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Articles_view_model extends CI_Model
{
    public function getarticleinfo()
    {
        $user_id = $this->session->userdata('user_id');
        $this->mongodb->where(['UserId' => $user_id]);
        $query = $this->mongodb->get('Articles');
        $article_data = [];
        foreach ($query as $data) {
            $article_data[] = $data;
        }
        return ['articleinfo' => $article_data];
    }
    public function getarticleinfoedit($params)
    {
        $user_id = $this->session->userdata('user_id');
        $this->mongodb->where(['_id' => $params]);
        $query = $this->mongodb->get('Articles');

        foreach ($query as $info) {
            $article_edit[] = $info;
        }
        return ['articleinfo' => $article_edit];
    }
    public function articleupdate($params)
    {
        $id = $params['id'];
        $this->mongodb->where(['_id' => mongo_id($id)]);
        $this->mongodb->set([
            'ArticleDescription' => $params['ArticleDescription'],
            'articleheading' => $params['articleheading'],
            'articleurl' => $params['articleurl'],
        ]);
        $this->mongodb->update('Articles');
    }
}
