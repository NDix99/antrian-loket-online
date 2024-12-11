<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function getUserAdmin($username, $password)
    {
        // Implement your database query to fetch user data from the 'ms_user' table
        $this->db->select('user_name', 'user_password');
        $this->db->where('user_name', $username);
        $this->db->where('user_password', $password);
        $query = $this->db->get('admin.ms_user');

        if ($query->num_rows() === 1) {
            return $query->row_array();
        } else {
            return null; // User not found
        }
    }

    public function getUser($username, $password)
    {
        // fetch by username first
        $this->db->where('user_name', $username);
        $query = $this->db->get('admin.ms_user');
        $result = $query->row_array(); // get the row first

        if (!empty($result) && password_verify($password, $result['user_password'])) {
            // if this username exists, and the input password is verified using password_verify
            return $result;
        } else {
            return false;
        }
    }

    public function getLoket()
    {
        $this->db->select('no_loket');
        $this->db->from('online_service.loket');
        $this->db->order_by('no_loket', 'ASC');
        return $this->db->get()->result();
    }
    public function getUserLoket()
    {
        $this->db->select('name');
        $this->db->from('online_service.user_loket');
        $this->db->order_by('name', 'ASC');
        return $this->db->get()->result();
    }
}
