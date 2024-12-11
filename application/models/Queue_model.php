<?php

class Queue_model extends CI_Model
{
    var $table = 'online_service.antrian_loket';
    var $column_order = array('no_antrian', 'no_rm', 'name', 'date_visit');
    var $order = array('no_antrian', 'no_rm', 'name', 'date_visit');

    public function get_data_query()
    {
        $this->db->from($this->table);
        if (isset($_POST['search']['value'])) {
            $this->db->like('no_antrian', $_POST['search']['value']);
            $this->db->or_like('no_rm', $_POST['search']['value']);
            $this->db->or_like('name', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('no_antrian', 'ASC');
        }
    }

    public function getDataTable()
    {
        $this->get_data_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data()
    {
        $this->get_data_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data()
    {
        $this->get_data_query();
        return $this->db->count_all_results();
    }


    public function addToQueue($no_antrian, $loket_id)
    {
        // Add a new entry to the queue with status 'pending'
        $data = array(
            'no_antrian' => $no_antrian,
            'status_antrian' => 'false',
            'loket_id' => $loket_id
        );
        $this->db->insert('queue', $data);
    }

    public function getNextToCall($loket_id)
    {
        // Get the next number in the queue with status 'pending' for the specified loket
        $this->db->where('loket_id', $loket_id);
        $this->db->where('status_antrian', 'false');
        $this->db->order_by('created_at', 'ASC');
        $query = $this->db->get('online_service.antrian_loket');
        return $query->row();
    }

    public function markAsCalled($id)
    {
        // Update the status of a queue entry to 'called'
        $this->db->where('id', $id);
        $this->db->update('queue', array('status_antrian' => 'true'));
    }
}
