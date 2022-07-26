<?php
class Admin_model extends CI_Model {

    public function getByUsername($username)
    {
        $this->db->where('username', $username);
        $admin = $this->db->get('admins')->row_array(); // SELECT * FROM admins WHERE username = {}
        return $admin;

    }
}
?>