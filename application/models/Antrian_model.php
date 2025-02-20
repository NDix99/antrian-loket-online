<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class Antrian_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->currentDate = date('Y-m-d');
    }

    public function getDataAntrian($inputDate, $search)
    {
        // Check if a search term is provided
        if (!empty($search)) {
            $this->db->like('no_rm', $search);
            $this->db->or_like('name', $search);
            // Add more fields to search as needed
        }
        $this->db->select('no_antrian, no_rm, name, date_visit');
        $this->db->from('online_service.antrian_loket');
        $this->db->where('date_visit', $inputDate);
        $this->db->where('status_antrian', 0);
        $this->db->order_by('no_antrian', 'ASC');
        // $this->db->where('status_antrian', 0);
        // $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function countTotalAntrian($inputDate)
    {
        return $this->db->where('date_visit', $inputDate)->count_all_results('online_service.antrian_loket');
        // $this->db->where('date_visit', $inputDate);
        // $this->db->where('status_antrian', 0); // Add this line to filter by status_antrian = 0
        // $count = $this->db->count_all_results('online_service.antrian_loket');
        // return $count;
    }

    public function insertAntrian($data)
    {
        return $this->db->insert('online_service.antrian_loket', $data);
    }

    public function existAntrian($data)
    {
        $this->db->where([
            'name' => $data['name'],
            'no_rm' => $data['no_rm'],
            'date_visit' => $data['date_visit'],
            // 'no_antrian' => $data['no_antrian'],
            // 'date_antrian' => $data['date_antrian']
        ]);

        return $this->db->get('online_service.antrian_loket')->row();
    }
    public function getDataResult($search, $inputDate)
    {
        $this->db->select('no_antrian, no_rm, name');
        $this->db->where('date_visit', $inputDate);
        $this->db->from('online_service.antrian_loket');

        // Check if a search term is provided
        if (!empty($search)) {
            $this->db->like('no_rm', $search);
            $this->db->or_like('name', $search);
            // Add more fields to search as needed
        }

        $this->db->order_by('no_antrian', 'ASC');
        // $this->db->limit($limit, $start);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function searchAntrian($search, $inputDate)
    {
        $this->db->select('no_antrian, no_rm, name');
        $this->db->where('date_visit', $inputDate);
        $this->db->from('online_service.antrian_loket');

        // Check if a search term is provided
        if (!empty($search)) {
            $this->db->like('no_rm', $search);
            $this->db->or_like('name', $search);
            // Add more fields to search as needed
        }

        $this->db->order_by('no_antrian', 'ASC');
        // $this->db->limit($limit, $start);

        $query = $this->db->get();
        return $query->result_array();
    }





    public function countTotalAntrianToday()
    {
        $currentDate = date('Y-m-d');
        return $this->db->where('date_visit', $currentDate)->count_all_results('online_service.antrian_loket');
    }
    public function countTotalAntrianDone()
    {
        $currentDate = date('Y-m-d');
        $this->db->where('date_visit', $currentDate);
        $this->db->where('status_antrian', 1);
        return $this->db->count_all_results('online_service.antrian_loket');
    }
    public function countTotalAntrianQueue()
    {
        $currentDate = date('Y-m-d');
        $this->db->where('date_visit', $currentDate);
        $this->db->where('status_antrian', 0);
        return $this->db->count_all_results('online_service.antrian_loket');
    }
    public function countAntrianNow()
    {
        $currentDate = date('Y-m-d');
        $this->db->select('no_antrian');
        $this->db->where('date_visit', $currentDate);
        $this->db->where('status_antrian', 0);
        $this->db->order_by('no_antrian', 'ASC');
        // $this->db->limit(1);
        $query = $this->db->get('online_service.antrian_loket');
        $result = $query->row();
        // return $result;
        if ($result) {
            return $result->no_antrian;
        } else {
            return 0; // Return 0 when there are no matching records
        }
    }
    public function countNextAntrian()
    {
        $currentDate = date('Y-m-d');
        $this->db->select('no_antrian');
        $this->db->where('date_visit', $currentDate);
        $this->db->where('status_antrian', 0);
        $this->db->order_by('no_antrian', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get('online_service.antrian_loket');

        if ($query->num_rows() > 0) {
            $result = $query->row();
            $next = $result->no_antrian;
            return $next + 1;
        } else {
            return ''; // If no matching records, start with 1 as the next no_antrian
        }
    }

    public function getFirstAntrian()
    {
        $DB1 = $this->load->database('default', TRUE);
        $currentDate = date('Y-m-d');
        $DB1->select('id_antrian, no_antrian, no_rm, name, phone, date_visit, status_antrian, id_loket');
        $DB1->from('online_service.antrian_loket');
        $DB1->where('date_visit', $currentDate);
        $DB1->where('status_antrian', 0);
        $DB1->order_by('no_antrian', 'ASC');
        $DB1->limit(1);
        $query = $DB1->get();
        // $query = $this->db->get();
        return $query->row();
    }
    public function editStatusAntrian()
    {
        $DB1 = $this->load->database('default', TRUE);
        // $DB2 = $this->load->database('secondary', TRUE);
        $DB1->set('status_antrian', true);
        $DB1->update('online_service.antrian_loket');
    }


    public function getTodayAntrianList($currentDate)
    {
        $this->db->select('id_antrian, no_antrian, no_rm, name, phone, date_visit, status_antrian');
        $this->db->from('online_service.antrian_loket');
        $this->db->where('date_visit', $currentDate);
        $this->db->where('status_antrian', 0);
        $this->db->order_by('no_antrian', 'ASC');
        // $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();

        // return $this->db->get('online_service.antrian_loket')->result_array();
    }
    public function getAntrianList($currentDate)
    {
        $this->db->select('no_antrian, no_rm, name, date_visit, status_antrian');
        $this->db->from('online_service.antrian_loket');
        $this->db->where('date_visit', $currentDate);
        $this->db->where('status_antrian', 0);
        $this->db->order_by('no_antrian', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getNext($id_loket)
    {
        $this->load->database('default', TRUE);
        $currentDate = date('Y-m-d');
        // Select the next available antrian
        $this->db->select('id_antrian, no_antrian, no_rm, name, phone, date_visit, status_antrian, id_loket');
        $this->db->from('online_service.antrian_loket');
        $this->db->where('date_visit', $currentDate);
        $this->db->where('status_antrian', 0);
        // $this->db->where('id_loket', 0);
        $this->db->order_by('no_antrian', 'ASC');
        $this->db->limit(1);  // Limit to one record
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            // Get the first row (next antrian)
            $result = $query->row_array();
            // var_dump($result);
            // die;
            // Update the status_antrian to 1 for the selected row
            $this->db->where('id_antrian', $result['id_antrian']);
            $this->db->update('online_service.antrian_loket', array('status_antrian' => 1, 'id_loket' => $id_loket));

            return $result;
        } else {
            // If no rows are found, return an empty array or handle as needed
            return array();
        }
    }
    public function getPrev($id_loket)
    {
        $this->load->database('default', TRUE);
        $currentDate = date('Y-m-d');
        // Select the next available antrian
        $this->db->select('id_antrian, no_antrian, no_rm, name, phone, date_visit, status_antrian, id_loket');
        $this->db->from('online_service.antrian_loket');
        $this->db->where('date_visit', $currentDate);
        $this->db->where('status_antrian', 1);
        // $this->db->where('id_loket', 0);
        $this->db->order_by('no_antrian', 'DESC');
        $this->db->limit(1);  // Limit to one record
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            // Get the first row (next antrian)
            $result = $query->row_array();
            // var_dump($result);
            // die;
            // Update the status_antrian to 1 for the selected row
            $this->db->where('id_antrian', $result['id_antrian']);
            $this->db->update('online_service.antrian_loket', array('status_antrian' => 0, 'id_loket' => $id_loket));

            return $result;
        } else {
            // If no rows are found, return an empty array or handle as needed
            return array();
        }
    }

    public function getLastLoket($id)
    {
        $currentDate = date('Y-m-d');

        $this->db->select('no_antrian');
        $this->db->where('date_visit', $currentDate);
        $this->db->where('status_antrian', 1);
        $this->db->where('id_loket', $id);
        $this->db->order_by('no_antrian', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('online_service.antrian_loket');

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    public function getNoAntrianLoket($id_loket)
    {
        $currentDate = date('Y-m-d');
        $this->db->select('no_antrian')
            ->from('online_service.antrian_loket')
            ->where('id_loket', $id_loket)
            ->where('date_visit', $currentDate)
            ->order_by('no_antrian', 'ASC')
            ->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->no_antrian;
        } else {
            return null;
        }
    }



    public function getTodayTotalAntrian()
    {
        $currentDate = date('Y-m-d');

        $this->db->select('no_antrian'); // Calculate the sum of 'no_antrian' values
        $this->db->where('date_visit', $currentDate); // Filter by today's date
        $query = $this->db->get('online_service.antrian_loket'); // Execute the query

        if ($query->num_rows() > 0) {
            $result = $query->result_array(); // Get the results as an array
            $noAntrianArray = array_column($result, 'no_antrian'); // Extract 'no_antrian' values

            return $noAntrianArray; // Return an array of 'no_antrian' values for today
        } else {
            return array(); // Return an empty array if no results found
        }
    }

    public function getTodayAntrian($currentDate)
    {
        $this->db->where('date_visit', $currentDate); // Filter by the provided date
        $query = $this->db->get('online_service.antrian_loket'); // Get the records

        if ($query->num_rows() > 0) {
            return $query->result_array(); // Return the result as an array
        } else {
            return array(); // Return an empty array if no records are found
        }
    }

    public function getAntrianById($id)
    {
        return $this->db->get_where('online_service.antrian_loket', $id)->result_array();
    }

    public function getAntrianByDate($currentDate)
    {

        return $this->db->get_where('online_service.antrian_loket', $currentDate)->result_array();
    }

    public function getOngoingAntrian($currentDate, $loket)
    {
        $this->db->where('date_visit', $currentDate);
        // $this->db->where('status', 1); // Assuming there is a column 'is_ongoing' to indicate ongoing status
        return $this->db->count_all_results('online_service.antrian_loket');

        // Initialize an array to store the ongoing queue for each counter
        $ongoingAntrian = array();

        // Iterate through each counter
        foreach ($loket as $counter) {
            $this->db->where('date_visit', $currentDate);
            $this->db->where('id_loket', $counter); // Assuming 'counter_id' is the column that identifies each counter
            $this->db->where('status', 1); // Assuming there is a column 'is_ongoing' to indicate ongoing status
            $ongoingAntrian[$counter] = $this->db->count_all_results('online_service.antrian_loket');
        }

        return $ongoingAntrian;
    }

    public function ambilNomorAntrian($nomor = null)
    {
        if ($nomor !== null) {
            // Tambahkan nomor antrian baru ke tabel
            $data = array(
                'nomor_antrian' => $nomor,
                'tanggal' => date('Y-m-d')
            );

            $this->db->insert('online_service.antrian_loket', $data);
            return $nomor;
        } else {
            // Ambil nomor antrian terakhir dari database
            $this->db->select('MAX(nomor_antrian) as max_nomor_antrian');
            $query = $this->db->get('online_service.antrian_loket');
            $result = $query->row();
            $nomor_antrian = $result->max_nomor_antrian + 1;

            return $nomor_antrian;
        }
    }

    public function countCallAntrian()
    {
        // False = belum dipanggil
        $today = date('Y-m-d');
        $this->db->where('date_visit', $today);
        $this->db->where("(status_antrian IS NULL OR status_antrian = false)");
        $count = $this->db->count_all_results('online_service.antrian_loket');
        return $count;
    }

    public function getNextAntrian()
    {
        // Implement your logic here to retrieve and update the next antrian.

        // Example:
        $this->db->trans_start(); // Start a database transaction

        // Query to get the next available antrian with status_antrian = false
        $this->db->select('no_antrian');
        $this->db->where('status_antrian', 0);
        $this->db->order_by('no_antrian', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get('online_service.antrian_loket');
        $result = $query->row();
        return $result ? $result->no_antrian : 0;

        // if ($query->num_rows() > 0) {
        //     $row = $query->row();
        //     $nextAntrian = $row->no_antrian;

        //     // Update the status_antrian to true for the retrieved antrian
        //     $this->db->where('no_antrian', $nextAntrian);
        //     $this->db->update('antrian', ['status_antrian' => true]);

        //     $this->db->trans_complete(); // Complete the transaction

        //     return $nextAntrian;
        // } else {
        //     $this->db->trans_complete(); // Complete the transaction

        //     return null; // No available antrian found
        // }
    }

    public function antrianDone()
    {
        $today = date('Y-m-d');
        $this->db->where('date_visit', $today);
        $this->db->where("(status_antrian IS NULL OR status_antrian = false)");
        $this->db->where("(status_antrian IS NULL OR status_antrian = false)");
        $this->db->order_by('no_antrian', 'ASC');
        $this->db->limit(1);
        $this->db->set('status_antrian', true);
        $this->db->update('online_service.antrian_loket');
    }
    public function next()
    {
        $currentDate = date('Y-m-d');

        // Select the first row where status_antrian is false
        $this->db->select('no_antrian');
        $this->db->from('online_service.antrian_loket');
        $this->db->where('date_visit', $currentDate);
        $this->db->where('status_antrian', 0);
        $this->db->order_by('no_antrian', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get();

        // Check if there's a row to process
        if ($query->num_rows() > 0) {
            // Get the first row
            $result = $query->row_array();

            // Update the status_antrian to true for the selected row
            $this->db->where('no_antrian', $result['no_antrian']);
            $this->db->update('online_service.antrian_loket', array('status_antrian' => 1));

            // Return the result
            return $result;
        } else {
            // If no rows are found, return an empty array or handle as needed
            return array();
        }
    }

    public function getAllLoket($currentDate)
    {
        $this->db->select('id_loket, MAX(no_antrian) as latest_no_antrian');
        $this->db->where('date_visit', $currentDate);
        $this->db->where('status_antrian', 1);
        $this->db->group_by('id_loket');
        $this->db->order_by('latest_no_antrian', 'DESC');
        // $this->db->limit(1);
        $query = $this->db->get('online_service.antrian_loket');
        return $query->row();
    }

    public function getLatestAntrian($currentDate)
    {
        $this->db->select('id_loket, MIN(no_antrian) as latest_no_antrian');
        $this->db->where('date_visit', $currentDate);
        $this->db->where('status_antrian', 0);
        $this->db->group_by('id_loket');
        $this->db->order_by('latest_no_antrian', 'ASC');
        // $this->db->limit(1);
        $query = $this->db->get('online_service.antrian_loket');
        return $query->row();
    }

    public function getLatestLoket($currentDate)
    {
        $this->db->select('id_loket, MAX(id_antrian) as latest_loket');
        $this->db->where('date_visit', $currentDate);
        $this->db->where('status_antrian', 1);
        $this->db->group_by('id_loket');
        $this->db->order_by('latest_loket', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('online_service.antrian_loket');
        return $query->row();
    }
    public function ant()
    {
        $currentDate = date('Y-m-d');
        $this->db->select('no_antrian');
        $this->db->where('date_visit', $currentDate);
        $this->db->where('status_antrian', 0);
        $this->db->order_by('no_antrian', 'ASC');
        // $this->db->limit(1);
        $query = $this->db->get('online_service.antrian_loket');
        $result = $query->row();
        // return $result;
        if ($result) {
            return $result->no_antrian;
        } else {
            return 0; // Return 0 when there are no matching records
        }
    }
    public function isQueueFull($date_visit)
    {
        $total_antrian = $this->db->where('date_visit', $date_visit)
            ->count_all_results('online_service.antrian_loket');
        
        return $total_antrian >= 150;
    }
    
}


