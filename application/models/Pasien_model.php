<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pasien_model extends CI_Model
{
    // public function __construct()
    // {
    //     parent::__construct();
    //     $this->load->database('db_live');
    // }
    public function getPasienByNorm($norm)
    {
        // Select data from the 'yanmed.patient' table where 'px_norm' matches $norm
        return $this->db->get_where('yanmed.patient', ['px_norm' => $norm])->row_array();
    }

    public function getPasienByNik($nik)
    {
        // Select data from the 'yanmed.patient' table where 'px_noktp' matches $nik
        return $this->db->get_where('yanmed.patient', ['px_noktp' => $nik])->row_array();
    }

    // public function newPasien($data)
    // {
    //     // Mendapatkan nomor px_norm terakhir
    //     $last_px_norm = $this->db->select('px_norm')
    //         ->order_by('px_norm', 'DESC')
    //         ->limit(1)
    //         ->get('yanmed.patient')
    //         ->row();

    //     // Menghitung nomor px_norm baru
    //     $new_px_norm = $last_px_norm ? ($last_px_norm->px_norm + 1) : 1;

    //     // Menambahkan nomor px_norm baru ke data registrasi
    //     $data['px_norm'] = $new_px_norm;

    //     // Simpan data registrasi pasien ke tabel pasien
    //     $this->db->insert('yanmed.patient', $data);

    //     // Mengembalikan no RM pasien yang baru saja diregistrasi
    //     return $new_px_norm();
    // }
}
