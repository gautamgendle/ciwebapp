<?php

class Article_model extends CI_Model {

    public function getArticle($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('articles');
        $article = $query->row_array();
        return $article;

    }

    public function getArticles($param = array()) {
        if(isset($param['offset']) && isset($param['limit']))
        {
            $this->db->limit($param['offset'],$param['limit']);
        }

        if(isset($param['q']))
        {
            $this->db->or_like('title', trim($param['q']));
            $this->db->or_like('author', trim($param['q']));
        }

       $query = $this->db->get('articles');

      //echo $this->db->last_query();
       $articles = $query->result_array();
       return $articles;

    }

    public function getArticlesCount($param = array()) {

        if(isset($param['q']))
        {
            $this->db->or_like('title', trim($param['q']));
            $this->db->or_like('author', trim($param['q']));
        }

        $count = $this->db->count_all_results('articles');
        return $count;
 
    }

    public function addArticle($formArray) {
        $this->db->insert('articles', $formArray);  
        return $this->db->insert_id(); 
    }

    public function updateArticle($id, $formArray) {
        $this->db->where('id', $id);
        $this->db->update('articles', $formArray);
    }

    public function deleteArticles($id) {
        $this->db->where('id', $id);
        $this->db->delete('articles');
    }

    // front method
    public function getArticlesFront($param = array()) {
        if(isset($param['offset']) && isset($param['limit']))
        {
            $this->db->limit($param['offset'],$param['limit']);
        }

        if(isset($param['q']))
        {
            $this->db->or_like('title', trim($param['q']));
            $this->db->or_like('author', trim($param['q']));
        }

        $this->db->select('articles.* , categories.name as category_name');
        $this->db->order_by('articles.created_at', 'DESC');
        $this->db->where('articles.status', 1);

        $this->db->join('categories' , 'categories.id = articles.category' , 'left');

        $query = $this->db->get('articles');
        //echo $this->db->last_query();
       
        $articles = $query->result_array();
        return $articles;

    }
}
