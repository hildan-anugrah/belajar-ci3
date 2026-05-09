<?php
class Pagination_model extends CI_Model
{
    public function get_users($limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('username', $keyword);
            $this->db->or_like('full_name', $keyword);
        }

        $this->db->limit($limit, $start);
        return $this->db->get('users')->result();
    }

    public function get_count($keyword = null)
    {
        if ($keyword) {
            $this->db->like('username', $keyword);
            $this->db->or_like('full_name', $keyword);
        }

        return $this->db->count_all_results('users');
    }

    public function get_all_users()
    {
        return $this->db->get('users')->result();
    }
}