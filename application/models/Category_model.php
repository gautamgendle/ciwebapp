<?php
    class Category_model extends CI_Model {

        public function create($formArray)
        {
            $this->db->insert('categories', $formArray);
            
        }
        public function getCategories($params=[])
        {
            if(!empty($params['queryString'])){
                $this->db->like('name' ,$params['queryString']);
            }
            $result = $this->db->get('categories')->result_array();
            //echo $this->db->last_query();
            return $result;
        }

        public function getCategory($id) {
            $this->db->where('id', $id);
            $category = $this->db->get('categories')->row_array();
            return $category;
        }

        public function deleteCategory($id)
        {
            $this->db->where('id', $id);
            $this->db->delete('categories');
        }

        public function update($id, $formArray)
        {
            $this->db->where('id', $id);
            $this->db->update('categories',$formArray);
        }



    }
?>