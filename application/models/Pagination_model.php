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

    public function get_user_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('users')->row();
    }

    public function username_exists($username, $exclude_id = null)
    {
        $this->db->where('username', $username);

        if ($exclude_id !== null) {
            $this->db->where('id !=', $exclude_id);
        }

        return $this->db->count_all_results('users') > 0;
    }

    public function insert_user($data)
    {
        return $this->db->insert('users', $data);
    }

    public function update_user($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function delete_user($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }
}
