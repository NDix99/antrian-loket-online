<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_crud extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function show($table, $order)
    {
        $this->db->order_by($order);
        $sql = $this->db->get($table);
        return $sql;
    }
    public function show_limit($table, $limit)
    {
        $sql = $this->db->get($table);
        $this->db->limit($limit);
        return $sql;
    }
    public function get_max_id($table, $field, $where)
    {
        $this->db->select_max($field);
        $this->db->where($where);
        $sql = $this->db->get($table);
        return $sql;
    }
    public function get_group_id($table, $group_by)
    {
        $this->db->group_by($group_by);
        $this->db->order_by($group_by . " DESC");
        $sql = $this->db->get($table);
        return $sql;
    }
    public function add($table, $data)
    {
        $this->db->insert($table, $data);
    }
    public function add1($table, $data)
    {
        $DB1 = $this->load->database('default', TRUE);
        $DB1->insert($table, $data);
    }
    public function del($table, $where)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
    public function edit1($table, $data, $where)
    {
        // $DB1 = $this->load->database('default', TRUE);
        $this->db->where($where);
        $this->db->update($table, $data);
    }
    public function edit($table, $data, $where)
    {
        // $DB1 = $this->load->database('default', TRUE);
        $DB2 = $this->load->database('secondary', TRUE);
        $DB2->where($where);
        $DB2->update($table, $data);
    }
    public function join($table, $join, $on, $order, $az)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->join($join, $on);
        $this->db->order_by($order, $az);
        $sql = $this->db->get();
        return $sql;
    }
    public function join_multiple($table, $join, $pq, $join1, $pq1, $order, $az)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->join($join, $pq);
        $this->db->join($join1, $pq1);
        $this->db->order_by($order, $az);
        $sql = $this->db->get();
        return $sql;
    }
    public function get_id1($table, $where)
    {
        $DB1 = $this->load->database('default', TRUE);
        $DB1->where($where);
        $sql = $DB1->get($table);
        return $sql;
    }
    public function get_id2($table, $where)
    {
        $DB2 = $this->load->database('secondary', TRUE);
        $DB2->where($where);
        $sql = $DB2->get($table);
        return $sql;
    }
    public function fetch_data($table, $field, $num, $offset)
    {
        empty($offset) ? $offset = 0 : $offset;

        $this->db->query("SET @no=" . $offset);
        $this->db->select('*,(@no:=@no+1) AS nomor');
        $this->db->group_by($field);
        $this->db->order_by($field, 'DESC');

        $data = $this->db->get($table, $num, $offset);

        return $data->result();
    }
    public function slide($limit)
    {
        $sql = $this->db->query("SELECT * FROM agenda ORDER BY id_agenda DESC LIMIT $limit");
        return $sql;
    }

    public function showLoket()
    {
        $loket = $this->db->query("SELECT * FROM loket WHERE id_loket LIMIT 0,2");
        return $loket->result();
    }
    public function showUser()
    {
        $DB1 = $this->load->database('default', TRUE);
        $users = $DB1->query("SELECT * FROM online_service.user_loket WHERE name LIMIT 0,2");
        return $users->result();
    }

    public function get_lokets()
    {
        $loket = $this->db->query("SELECT * FROM online_service.loket");
        return $loket->result();
    }

    public function get_users($id = null)
    {
        // Check if id is provided
        if ($id === null) {
            // Query to get all users if id is null
            $query = $this->db->get('online_service.user_loket'); // Adjust the table name if necessary
        } else {
            // Query to get user by id if id is provided
            $query = $this->db->get_where('online_service.user_loket', array('id_user' => $id)); // Adjust the table name and id field if necessary
        }

        // Check if there are any rows returned
        if ($query->num_rows() > 0) {
            // Return the user data as an array
            return $query->result_array();
        } else {
            // Return false if no user data is found
            return false;
        }
    }

    public function deleteUserById($id)
    {
        // Perform deletion query
        $this->db->where('id_user', $id)
            ->delete('online_service.user_loket');

        // Check if any row affected
        return $this->db->affected_rows() > 0;
    }


    public function estimasi_pelayanan()
    {
        $query = $this->db->select('ticket_estimasi_pelayanan, ticket_waktupel_start, ticket_waktupel_end')
            ->where('ticket_waktu_auto', true)
            ->from('online_service.antrian_setting')
            ->get();
        return $query->row();
    }

    public function save_tiket($data)
    {
        $data = array_filter($data);
        if (!empty($data) && $this->db->where('id', 1)->update('online_service.antrian_setting', $data)) {
            return true;
        } else {
            return false;
        }
    }
    public function save_info($data)
    {
        // Set the created_at and deleted_at fields
        $data['info_created_at'] = date('Y-m-d H:i:s');
        // $data['info_deleted_at'] = NULL; // Initially set as NULL

        // Remove empty values from the data array
        $data = array_filter($data);

        // Insert data into 'info' table
        if (!empty($data) && $this->db->insert('online_service.antrian_info', $data)) {
            return true;
        } else {
            return false;
        }
    }
    public function get_info_all()
    {
        // Fetch tgl_libur from the database
        $query = $this->db->select('id_info, info_header')
            ->from('online_service.antrian_info')
            // ->where('tgl_libur >=', date('Y-m-d'))
            ->get();

        return $query->result();
    }
    public function get_libur()
    {
        // Fetch tgl_libur from the database
        $query = $this->db->select('id, tgl_libur, hari_libur')
            ->from('online_service.antrian_libur')
            ->where('tgl_libur >=', date('Y-m-d'))
            ->get();

        return $query->result();
    }

    public function save_libur($data)
    {
        // Set the created_at and deleted_at fields
        $data['inserted_at'] = date('Y-m-d H:i:s');
        // $data['info_deleted_at'] = NULL; // Initially set as NULL

        // Remove empty values from the data array
        $data = array_filter($data);

        // Insert data into 'info' table
        if (!empty($data) && $this->db->insert('online_service.antrian_libur', $data)) {
            return true;
        } else {
            return false;
        }
    }
    public function deleteLiburById($id)
    {
        // Perform deletion query
        $this->db->where('id', $id)
            ->delete('online_service.antrian_libur');

        // Check if any row affected
        return $this->db->affected_rows() > 0;
    }

    public function save_settings($settings)
    {
        $data = array_filter($settings);

        if (!empty($data) && $this->db->where('id', 1)->update('online_service.antrian_setting', $data)) {
            return true;
        } else {
            return false;
        };
    }



    public function get_info()
    {
        $query = $this->db->select('info_title, info_header, info_body, info_notes, info_date')
            ->from('online_service.antrian_info')
            // ->where('is_enabled', true)
            ->order_by('id_info', 'DESC')
            ->limit(1)
            ->get();

        return $query->row();
    }
    public function get_settings()
    {
        // Fetch data from the database with where condition id = 1
        $query = $this->db->select('*')
            ->from('online_service.antrian_setting')
            ->where('id', 1) // Where condition
            ->get();

        return $query->row();
    }

    public function get_data_antrian($date_visit = null)
    {
        $this->db->select('no_antrian, no_rm, name, date_visit');
        $this->db->from('online_service.antrian_loket');
        // If $date_visit is provided, filter by it
        if ($date_visit !== null) {
            $this->db->where('date_visit', $date_visit);
        }
        $this->db->order_by('no_antrian', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
}
