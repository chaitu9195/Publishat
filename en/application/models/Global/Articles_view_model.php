<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Articles_view_model extends CI_Model
{
    public function getarticleinfo()
    {
        $user_id = $this->session->userdata('user_id');
        $query = $this->db->query("SELECT * FROM Articles WHERE UserId = '$user_id'");
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $data) {
                $article_data[] = $data;
            }
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
        $articledes = $params['ArticleDescription'];
        $art_heading = $params['articleheading'];
        $art_url = $params['articleurl'];
        $query = $this->db->query(
            "UPDATE `Articles` SET `ArticleDescription`='$articledes',`ArticleHeading`='$art_heading',`ArticleUrl`='$art_url' WHERE id = '$id'",
        );
    }
}
