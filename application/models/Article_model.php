<?php

class Article_model extends CI_Model {

    public function getArticles() {

    }

    public function getArticle() {
       
    }

    public function addArticle($formArray) {
        $this->db->insert('articles', $formArray);  
        return $this->db->insert_id(); 
    }

    public function updateArticle() {
        
    }

    public function deleteArticles() {
        
    }
}
?>