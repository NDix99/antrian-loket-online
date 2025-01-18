<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class Antrian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->database('default');
        $this->load->library('session');
        $this->load->model('M_crud');
        $this->load->model('Pasien_model');
        $this->load->model('Antrian_model');

        // $this->input->set_cookie('csrf_cookie_name', $this->security->get_csrf_hash(), $this->config->item('csrf_expire'), $this->config->item('cookie_path'), $this->config->item('cookie_domain'), $this->config->item('cookie_secure'), $this->config->item('cookie_httponly'));
    }

    public function index($norm = NULL)
    {
        if ($norm === NULL) {
            // If 'norm' is not provided in the URL, handle the error or redirect to an error page.
            $this->session->set_flashdata('alert_message', 'Pastikan nomor RM Anda benar.');
            redirect('home/');
        } else {
            // 'norm' value is available here, and you can use it as needed.
            // For example, you can pass it to a view or use it for database queries.

            // Load your 'antrian' view and pass the 'norm' value to it.
            $data['title'] = 'Antrian Loket Online';
            $data['norm'] = $norm;
            $this->load->view('templates/header', $data);
            $this->load->view('antrian/index', $data);
            $this->load->view('templates/footer');
        }
    }

    public function successPage()
    {
        // Message to prevent form submission
        $data['message'] = "Form submitted successfully.";
        $this->load->view('notification', $data);
    }

    public function getTotalAntrian()
    {
        // Get the date_visit from the POST request
        $date_visit = $this->input->post('date_visit_show');
        $date_visit = date('d F Y', strtotime($date_visit));

        if (empty($date_visit)) {
            // Set a flash message to indicate an error
            $this->session->set_flashdata('error_message', 'Tanggal kunjungan belum dipilih.');
        } else {
            // Query to get the number of entries for the given date
            $this->db->select('COUNT(*) AS jumlah_antrian');
            $this->db->where('date_visit', $date_visit);
            $query = $this->db->get('online_service.antrian_loket');

            // $data['totalAntrian'] = '';

            if ($query->num_rows() > 0) {
                $row = $query->row();
                $jumlah_antrian = $row->jumlah_antrian;
                $this->session->set_flashdata('check_success_msg', "Jumlah antrian pada tanggal <br> $date_visit : $jumlah_antrian");
            } else {
                $this->session->set_flashdata('check_error_msg', "Belum ada data antrian untuk tanggal kunjungan $date_visit");
            }
        }
        redirect('dashboard/data_antrian');
    }

    public function cekRm()
    {
        $this->form_validation->set_rules('nik', 'NIK', 'trim|integer|required|exact_length[8]', [
            'integer' => 'Isikan NIK Anda dengan benar',
            'required' => 'Isikan NIK Anda',
            'exact_length' => 'Nomor NIK tidak sesuai'
        ]);
        if ($this->form_validation->run() == false) {
            // Handle form validation errors here if needed.
            $data['title'] = 'Cek No RM';
        } else {
            $this->load->model('Pasien_model'); // Memuat model
            $nik = $this->input->post('nik'); // Ambil nomor RM dari input form
            $pasien = $this->Pasien_model->getPasienByNik($nik);
            $data['no_rm'] = $pasien['px_norm'];
            $data['nama'] = $pasien['px_name'];
        }
        $this->load->view('templates/header', $data);
        $this->load->view('home/cek_rm', $data);
        $this->load->view('templates/footer');
    }

    // Insert data + dapatkan nomor antrian 
    public function nomorAntrian()
    {
        $instansi = $this->M_crud->show('admin.profil', 'hsp_code')->row();

        $this->form_validation->set_rules('norm', 'No RM', 'trim|integer|required|exact_length[8]', [
            'integer' => 'Isikan Nomor Rekam Medis Anda dengan benar',
            'required' => 'Isikan Nomor Rekam Medis Anda',
            'exact_length' => 'Nomor Rekam Medis tidak sesuai'
        ]);
        $this->form_validation->set_rules('date_visit', 'Date Visit', 'required', [
            'required' => 'Pilih tanggal kunjungan Anda'
        ]);

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('alert_message', 'No RM dan Tanggal Kunjungan harus diisi');
            redirect('home/index/');
        } else {
            $norm = $this->input->post('norm', TRUE);

            if (empty($norm)) {
                $this->session->set_flashdata('alert_message', 'No RM tidak ditemukan');
                redirect('home/index/');
            } else {
                $pasien = $this->Pasien_model->getPasienByNorm($norm);

                if ($pasien !== null) {
                    // Get relevant data from the model
                    $norm = $pasien['px_norm'];
                    $name = $pasien['px_name'];

                    // Check the current time
                    $current_time = date('H:i:s');
                    $date_input = $this->input->post('date_visit');

                    if ($current_time > '14:00:00') {
                        // Set 'date_visit' to the next day
                        $date_input = date('Y-m-d', strtotime('+1 day', strtotime($date_input)));
                    }
                    $date_visit = date('d F Y', strtotime($date_input));
                    $phone = $this->input->post('phone');
                }

                // Proceed with checking the last 'no_antrian' for the specified 'date_visit'
                $result = $this->db->select_max('no_antrian')
                    ->where('date_visit', $date_visit)
                    ->get('online_service.antrian_loket')
                    ->row();

                $max_no_antrian = $result ? $result->no_antrian : 0;

                $date_estimate = "";
                if ($max_no_antrian === null) {
                    $no_antrian = 1;
                    $date_estimate = "$date_visit 06:30:00"; // Set the initial time
                } else {
                    $no_antrian = $max_no_antrian + 1;
                    $date_estimate = date("Y-m-d H:i:s", strtotime($date_estimate . " +1 hour"));
                }

                // Calculate 'waktu_estimasi' and 'waktu_pelayanan'
                $current_no_antrian = $no_antrian;
                $kelipatan = floor($current_no_antrian / 110);
                $waktu_awal = strtotime("$date_input 06:30:00");
                $waktu_estimasi_awal = date("H:i", strtotime("+{$kelipatan} hours", $waktu_awal));
                $waktu_estimasi_akhir = date("H:i", strtotime("$waktu_estimasi_awal + 1 hour"));
                $waktu_estimasi = $waktu_estimasi_awal . " - " . $waktu_estimasi_akhir;
                $waktu_pelayanan = $date_visit . " " . $waktu_estimasi_awal . "-" . $waktu_estimasi_akhir;

                // Prepare data for insertion
                $data = array(
                    'no_rm' => $norm,
                    'name' => $name,
                    'date_visit' => $date_visit,
                    'no_antrian' => $no_antrian,
                    'phone' => $phone,
                 // 'created_at' => date('Y-m-d H:i:s'),
                    'status_antrian' => 0
                );

                // Check if the data already exists
                // $this->db->where('name', $data['name']);
                // $this->db->where('no_rm', $data['no_rm']);
                // $this->db->where('date_visit', $data['date_visit']);
                // $this->db->where('no_antrian', $data['no_antrian']);
                $antrian = $this->load->model('Antrian_model');

                if ($antrian->num_rows() > 0) {
                    // Data already exists, fetch the existing data
                    $existing_data = $antrian->row_array();
                    // Data already exists, set a flash message
                    $exist_message = "Anda sudah memiliki tiket nomor antrian " . $existing_data['no_antrian'] . "<br> Untuk tanggal kunjungan: " . $existing_data['date_visit'];
                    $this->session->set_flashdata('exist_message', $exist_message);

                    var_dump($exist_message);
                    die;
                    // Load the 'nomor antrian' view and pass data
                    $data['title'] = 'Nomor Antrian';
                    $data['instansi'] = $instansi;
                    $data['exist_message'] = $exist_message;
                    $data['tickets'] = $existing_data;
                    $data['waktu_pelayanan'] = $waktu_estimasi;
                    $this->load->view('templates/header', $data);
                    $this->load->view('home/nomor_antrian', $data);
                    $this->load->view('templates/footer');
                    // You can return or use the existing data as needed
                } else {
                    // Data doesn't exist, insert it into the table (online_service.antrian_loket)
                    if ($this->db->insert('online_service.antrian_loket', $data)) {
                        // Successfully inserted, pass data to 'nomor_antrian' view
                        $last_insert_id = $this->db->insert_id();
                        $success_message = "Anda berhasil mendapatkan tiket nomor antrian : " . $data['no_antrian'] . "<br> Untuk tanggal kunjungan : " . $data['date_visit'];
                        $this->session->set_flashdata('success_message', $success_message);
                        $this->session->set_flashdata('last_insert_id', $last_insert_id);

                        // Load the 'nomor_antrian' view and pass data
                        $data['title'] = 'Nomor Antrian';
                        $data['instansi'] = $instansi;
                        $data['success_message'] = $success_message;
                        $data['tickets'] = $data;
                        $data['waktu_pelayanan'] = $waktu_estimasi;

                        // var_dump($data);
                        // die;
                        $this->load->view('templates/header', $data);
                        $this->load->view('home/nomor_antrian', $data);
                        $this->load->view('templates/footer');
                    } else {
                        // If insert fails, redirect back to the 'antrian/index'
                        redirect('home/cek_rm');
                    }
                }
            }
            // Prevent form resubmission
            // redirect('antrian/successForm');
        }
    }

    public function insertAntrian2()
    {
        $this->load->model('Antrian_model');
        $instansi = $this->M_crud->show('admin.profil', 'hsp_code')->row();

        $this->form_validation->set_rules('norm', 'No RM', 'trim|integer|required|exact_length[8]', [
            'integer' => 'Isikan Nomor Rekam Medis Anda dengan benar',
            'required' => 'Nomor Rekam Medis harus diisi',
            'exact_length' => 'Nomor Rekam Medis tidak sesuai'
        ]);
        $this->form_validation->set_rules('date_visit', 'Date Visit', 'required', [
            'required' => 'Tanggal kunjungan harus diisi'
        ]);

        if ($this->form_validation->run() === false) {
            $alert_message = validation_errors();
            $this->session->set_flashdata('alert_message', $alert_message);
            redirect('home/index');
        }

        $norm = $this->input->post('norm');

        if (empty($norm)) {
            $this->session->set_flashdata('empty_message', 'No RM tidak ditemukan');
            redirect('home/cek_rm');
        }

        $pasien = $this->Pasien_model->getPasienByNorm($norm);

        if ($pasien === null) {
            $this->session->set_flashdata('error_message', 'Data pasien tidak ditemukan');
            redirect('home/cek_rm');
        }

        // Get relevant data from the model
        $norm = $pasien['px_norm'];
        $name = $pasien['px_name'];

        // Check the current time
        $current_time = date('H:i:s');
        $date_input = $this->input->post('date_visit');

        // Check if today is equal to date_visit and current time > 12:00
        if (date('Y-m-d') == $date_input && $current_time > '12:00:00') {
            // Set 'date_visit' to the next day
            $date_input = date('Y-m-d', strtotime('+1 day', strtotime($date_input)));
        }

        $date_visit = date('d F Y', strtotime($date_input));
        $phone = $this->input->post('phone');

        // Proceed with checking the last 'no_antrian' for the specified 'date_visit'
        $result = $this->db->select_max('no_antrian')
            ->where('date_visit', $date_visit)
            ->get('online_service.antrian_loket')
            ->row();

        $max_no_antrian = $result ? $result->no_antrian : 0;
        $date_estimate = "";
        $date_estimate = ($max_no_antrian === null) ? "$date_visit 07:00:00" : date("Y-m-d H:i:s", strtotime($date_estimate . " +1 hour"));
        $no_antrian = ($max_no_antrian === null) ? 1 : $max_no_antrian + 1;

        // Calculate 'waktu_estimasi' and 'waktu_pelayanan'
        $current_no_antrian = $no_antrian;
        $kelipatan = floor($current_no_antrian / 70);
        $waktu_awal = strtotime("$date_input 07:00:00");
        $waktu_estimasi_awal = date("H:i", strtotime("+{$kelipatan} hours", $waktu_awal));
        $waktu_estimasi_akhir = date("H:i", strtotime("$waktu_estimasi_awal + 1 hour"));
        $waktu_estimasi = $waktu_estimasi_awal . " - " . $waktu_estimasi_akhir;
        $waktu_pelayanan = $date_visit . " " . $waktu_estimasi_awal . "-" . $waktu_estimasi_akhir;

        // Prepare data for insertion
        $data = array(
            'no_rm' => $norm,
            'name' => $name,
            'date_visit' => $date_visit,
            'no_antrian' => $no_antrian,
            'phone' => $phone,
            // 'created_at' => date('Y-m-d H:i:s'),
            'status_antrian' => 0
        );

        // Check if the data already exists
        $antrian = $this->Antrian_model->existAntrian($data);

        if ($antrian->num_rows() > 0) {
            // Data already exists, fetch the existing data
            $existing_data = $antrian->row_array();

            // Check if the existing data is for the same visit
            if ($existing_data['date_visit'] == $data['date_visit']) {
                // Data already exists for the same visit, set a flash message
                $exist_message = "Anda sudah memiliki tiket nomor antrian " . $existing_data['no_antrian'] . "<br> Untuk tanggal kunjungan: " . $existing_data['date_visit'];
                $this->session->set_flashdata('exist_message', $exist_message);

                // Load the 'nomor_antrian' view and pass data
                $this->loadNomorAntrian($data, $instansi, $exist_message, $existing_data, $waktu_estimasi);
                return;
            }
        }

        // Data doesn't exist or is for a different visit, insert it into the table (online_service.antrian_loket)
        if ($this->Antrian_model->insertAntrian($data)) {
            // Successfully inserted, pass data to 'nomor_antrian' view
            $last_insert_id = $this->db->insert_id();
            $success_message = "Anda berhasil mendapatkan tiket nomor antrian : " . $data['no_antrian'] . "<br> Untuk tanggal kunjungan : " . $data['date_visit'];
            $this->session->set_flashdata('success_message', $success_message);
            $this->session->set_flashdata('last_insert_id', $last_insert_id);

            // Load the 'nomor_antrian' view and pass data
            $this->loadNomorAntrian($data, $instansi, $success_message, $data, $waktu_estimasi);
        } else {
            // If insert fails, redirect back to the 'antrian/index'
            redirect('home/cek_rm');
        }
    }

    private function loadNomorAntrian($data, $instansi, $message, $tickets, $waktu_pelayanan)
    {
        $data = array(
            'title' => 'Nomor Antrian',
            'instansi' => $instansi,
            'message' => $message,
            'tickets' => $data,
            'waktu_pelayanan' => $waktu_pelayanan
        );

        $this->load->view('templates/header', $data);
        $this->load->view('home/nomor_antrian', $data);
    }


    public function nomor_antrian()
    {
        $instansi = $this->M_crud->show('admin.profil', 'hsp_code')->row();
        $estimasi_pel = $this->M_crud->estimasi_pelayanan();

        $this->form_validation->set_rules('norm', 'No RM', 'trim|integer|required|exact_length[8]', [
            'integer' => 'Isikan Nomor Rekam Medis Anda dengan benar',
            'required' => 'Isikan Nomor Rekam Medis Anda',
            'exact_length' => 'Nomor Rekam Medis tidak sesuai'
        ]);
        $this->form_validation->set_rules('date_visit', 'Date Visit', 'required', [
            'required' => 'Pilih tanggal kunjungan Anda'
        ]);

        if ($this->form_validation->run() === false) {
            $alert_message = validation_errors();
            $this->session->set_flashdata('alert_message', $alert_message);
            redirect('home/');
        } else {
            $norm = $this->input->post('norm');
            

            if (empty($norm)) {
                $this->session->set_flashdata('error_message', 'Nomor RM tidak ditemukan');
                redirect('home/cek_rm');
            } else {
                $pasien = $this->Pasien_model->getPasienByNorm($norm);

                if ($pasien === null) {
                    $this->session->set_flashdata('error_message', 'Nomor RM tidak ditemukan');
                    redirect('home/cek_rm');
                }
                  // Cek apakah antrian sudah penuh (maksimal 250 antrian per hari)
        $date_visit = $this->input->post('date_visit');
        $total_antrian = $this->db->where('date_visit', $date_visit)
                                 ->from('online_service.antrian_loket')
                                 ->count_all_results();
                                 
        if ($total_antrian >= 200) {
            $this->session->set_flashdata('alert_message', 
                'Mohon maaf, antrian untuk tanggal ' . $date_visit . ' sudah penuh (maksimal 200 antrian). 
                Silahkan pilih tanggal kunjungan lain. Mohon baca PENGUMUMAN');
            redirect('home/');
            return;
        }


                // Ambil data dari Pasien_model
                $norm = $pasien['px_norm'];
                $name = $pasien['px_name'];

                // Cek waktu saat ini
                $current_time = date('H:i:s');
                $date_input = $this->input->post('date_visit');

                // Cek jika hari ini = input tanggal kunjungan dan waktu saat ini > 12:00
                if (date('Y-m-d') == $date_input && $current_time > '13:00:00') {
                    // Set tanggal kunjungan untuk hari berikutnya
                    $date_input = date('Y-m-d', strtotime('+1 day', strtotime($date_input)));
                }

                $date_visit = date('d F Y', strtotime($date_input));
                $phone = $this->input->post('phone');

                // Proses cek nomor antrian terakhir untuk tanggal kunjungan
                $result = $this->db->select_max('no_antrian')
                    ->where('date_visit', $date_visit)
                    ->get('online_service.antrian_loket')
                    ->row();

                $max_no_antrian = $result ? $result->no_antrian : 0;

                $date_estimate = "";
                if ($max_no_antrian === null) {
                    $no_antrian = 1;
                    $date_estimate = "$date_visit 06:30:00"; // Set waktu awal
                } else {
                    // Check if the maximum no_antrian value already exists
                    // $no_antrian = $max_no_antrian !== null ? $max_no_antrian + 1 : 1;
                    $no_antrian = $max_no_antrian + 1;
                    $date_estimate = date("Y-m-d H:i:s", strtotime($date_estimate . " +1 hour"));
                }

                // Prevent duplicate number
                // Check if the maximum no_antrian value already exists
                if ($max_no_antrian !== null) {
                    $latest_antrian_datetime = $this->db->select('date_visit')
                        ->where('no_antrian', $max_no_antrian)
                        ->get('online_service.antrian_loket')
                        ->row()->date_visit;

                    // Convert $latest_antrian_datetime to a DateTime object
                    $latest_datetime = new DateTime($latest_antrian_datetime);
                    // Convert $date_visit to a DateTime object
                    $new_datetime = new DateTime($date_visit);
                    // Check if the date is the same
                    if ($latest_datetime->format('Y-m-d H:i:s') === $new_datetime->format('Y-m-d H:i:s')) {
                        // Redirect with alert
                        echo "<script>alert('Gagal mendapatkan Nomor Antrian, silakan ulangi');</script>";
                        redirect('home/');
                    }
                }
                // Proceed with generating the new no_antrian and date_estimate
                $no_antrian = $max_no_antrian !== null ? $max_no_antrian + 1 : 1;
                $date_estimate = "$date_visit 06:30:00"; // Set waktu awal

                // Kalkulasi estimasi waktu dan waktu pelayanan
                // $no_antrian = '219'; // nomor testing
                $current_no_antrian = $no_antrian;
                $kelipatan = floor($current_no_antrian / $estimasi_pel->ticket_estimasi_pelayanan); // default 70 // 85 // 110
                $waktu_awal = strtotime("$estimasi_pel->ticket_waktupel_start");
                $waktu_terakhir = "11:30"; // bug input friday auto next day
                $waktu_estimasi_awal = date("H:i", strtotime("+{$kelipatan} hours", $waktu_awal));
                // die(var_dump($waktu_estimasi_awal));
                $waktu_estimasi_akhir = date("H:i", strtotime("$waktu_estimasi_awal + 1 hour"));

                $day_of_week = date("l", strtotime($date_visit)); // Get the day of the week

                if ($day_of_week == "Friday") {
                    $waktu_estimasi = "06:30" . " - " . $waktu_terakhir;
                } elseif ($waktu_estimasi_awal >= $waktu_terakhir) {
                    $waktu_estimasi = $waktu_terakhir . " - Selesai";
                } else {
                    $waktu_estimasi = $waktu_estimasi_awal . " - " . $waktu_estimasi_akhir;
                }
                // var_dump($waktu_estimasi);

                // Menyiapkan data untuk insert
                $data = array(
                    'no_rm' => $norm,
                    'name' => $name,
                    'date_visit' => $date_visit,
                    'no_antrian' => $no_antrian,
                    'phone' => $phone,
                 //   'created_at' => date('Y-m-d H:i:s'),
                    'status_antrian' => 0
                );
                // die(print_r($data));

                // Check existing data
                $existing_record = $this->Antrian_model->existAntrian($data);
                // die(var_export($existing_record));

                if (!$existing_record) {
                    // Jika data nomor antrian tidak ditemukan, tambahkan data nomor antrian baru
                    if ($this->db->insert('online_service.antrian_loket', $data)) {
                        // Data sukses ditambahkan, kirim data untuk tampilan tiket nomor antrian
                        $last_insert_id = $this->db->insert_id();
                        $success_message = "Anda berhasil mendapatkan nomor antrian: <b>" . $data['no_antrian'] . "</b>";
                        $this->session->set_flashdata('success_message', $success_message);
                        $this->session->set_flashdata('last_insert_id', $last_insert_id);

                        // Tampilkan data nomor antrian
                        $antrian_data = [
                            'title' => 'Nomor Antrian',
                            'instansi' => $instansi,
                            'success_message' => $success_message,
                            'tickets' => $data, // Variabel data tiket antrian
                            'waktu_pelayanan' => $waktu_estimasi,
                        ];
                        $this->load->view('templates/header', $antrian_data);
                        $this->load->view('home/nomor_antrian_new', $antrian_data);
                        $this->load->view('templates/footer');
                        return;
                    }
                } else {
                    // Jika data nomor antrian ditemukan, tampilkan nomor antrian tersebut
                    $no_exist = $existing_record->no_antrian;
                    $no_kelipatan = floor($no_exist / $estimasi_pel->ticket_estimasi_pelayanan); // default 70
                    $waktu_awal = strtotime("$date_input 06:30:00");
                    $waktu_terakhir = "11:30";
                    $waktu_estimasi_awal = date("H:i", strtotime("+{$no_kelipatan} hours", $waktu_awal));
                    $waktu_estimasi_akhir = date("H:i", strtotime("$waktu_estimasi_awal + 1 hour"));
                    $day_of_week = date("l", strtotime($date_visit)); // Get the day of the week

                    if ($day_of_week == "Friday") {
                        $waktu_estimasi = "06:30" . " - " . $waktu_terakhir;
                    } elseif ($waktu_estimasi_awal > $waktu_terakhir) {
                        $waktu_estimasi = $waktu_terakhir . " - Selesai";
                    } else {
                        $waktu_estimasi = $waktu_estimasi_awal . " - " . $waktu_estimasi_akhir;
                    }

                    $exist_data = [
                        'title' => 'Nomor Antrian',
                        'instansi' => $instansi,
                        'exist_message' => "Anda sudah memiliki nomor antrian: <b>" . $no_exist . "</b>",
                        'tickets' => [$existing_record], // Variabel data tiket antrian
                        'waktu_pelayanan' => $waktu_estimasi,
                    ];

                    $this->load->view('templates/header', $exist_data);
                    $this->load->view('home/nomor_antrian', $exist_data);
                    $this->load->view('templates/footer');
                    return;
                }
            }
        }
    }



    public function get_antrian()
    {
        $instansi = $this->M_crud->show('admin.profil', 'hsp_code')->row();

        $this->form_validation->set_rules('norm', 'No RM', 'trim|integer|required|exact_length[8]', [
            'integer' => 'Isikan Nomor Rekam Medis Anda dengan benar',
            'required' => 'Isikan Nomor Rekam Medis Anda',
            'exact_length' => 'Nomor Rekam Medis tidak sesuai'
        ]);
        $this->form_validation->set_rules('date_visit', 'Date Visit', 'required', [
            'required' => 'Pilih tanggal kunjungan Anda'
        ]);

        if ($this->form_validation->run() === false) {
            $alert_message = validation_errors();
            $this->session->set_flashdata('alert_message', $alert_message);
            redirect('home/');
        } else {
            $norm = $this->input->post('norm');

            if (empty($norm)) {
                $this->session->set_flashdata('error_message', 'No RM tidak ditemukan');
                redirect('home/cek_rm');
            } else {
                $pasien = $this->Pasien_model->getPasienByNorm($norm);

                if ($pasien !== null) {
                    // Get relevant data from the model
                    $norm = $pasien['px_norm'];
                    $name = $pasien['px_name'];

                    // Check the current time
                    $current_time = date('H:i:s');
                    $date_input = $this->input->post('date_visit');

                    // Check if today is equal to date_visit and current time > 12:00
                    if (date('Y-m-d') == $date_input && $current_time > '12:00:00') {
                        // Set 'date_visit' to the next day
                        $date_input = date('Y-m-d', strtotime('+1 day', strtotime($date_input)));
                    }

                    $date_visit = date('d F Y', strtotime($date_input));
                    $phone = $this->input->post('phone');
                }

                // Proceed with checking the last 'no_antrian' for the specified 'date_visit'
                $result = $this->db->select_max('no_antrian')
                    ->where('date_visit', $date_visit)
                    ->get('online_service.antrian_loket')
                    ->row();

                $max_no_antrian = $result ? $result->no_antrian : 0;

                $date_estimate = "";
                if ($max_no_antrian === null) {
                    $no_antrian = 1;
                    $date_estimate = "$date_visit 07:00:00"; // Set the initial time
                } else {
                    $no_antrian = $max_no_antrian + 1;
                    $date_estimate = date("Y-m-d H:i:s", strtotime($date_estimate . " +1 hour"));
                }

                // Calculate 'waktu_estimasi' and 'waktu_pelayanan'
                $current_no_antrian = $no_antrian;
                $kelipatan = floor($current_no_antrian / 70);
                $waktu_awal = strtotime("$date_input 07:00:00");
                $waktu_estimasi_awal = date("H:i", strtotime("+{$kelipatan} hours", $waktu_awal));
                $waktu_estimasi_akhir = date("H:i", strtotime("$waktu_estimasi_awal + 1 hour"));
                $waktu_estimasi = $waktu_estimasi_awal . " - " . $waktu_estimasi_akhir;
                // $waktu_pelayanan = $date_visit . " " . $waktu_estimasi_awal . "-" . $waktu_estimasi_akhir;

                // Prepare data for insertion
                $data = array(
                    'no_rm' => $norm,
                    'name' => $name,
                    'date_visit' => $date_visit,
                    'no_antrian' => $no_antrian,
                    'phone' => $phone,
                 //  'created_at' => date('Y-m-d H:i:s'),
                    'status_antrian' => 0
                );

                // Check if the data already exists
                $this->db->where('name', $data['name']);
                $this->db->where('no_rm', $data['no_rm']);
                $this->db->where('date_visit', $data['date_visit']);
                $this->db->where('no_antrian', $data['no_antrian']);
                // $antrian = $this->db->get('online_service.antrian_loket');
                $antrian = $this->Antrian_model->existAntrian($data);

                if ($antrian->num_rows() > 0) {
                    // Data already exists, fetch the existing data
                    $existing_data = $antrian->row_array();

                    // Check if existing data, same date_visit
                    if ($existing_data['no_rm'] == $data['no_rm']) {
                        // Data already exists for the same visit, set a flash message
                        $exist_message = "Anda sudah memiliki tiket nomor antrian " . $existing_data['no_antrian'] . "<br> Untuk tanggal kunjungan: " . $existing_data['date_visit'];
                        $this->session->set_flashdata('exist_message', $exist_message);

                        // Load the 'nomor_antrian' view and pass data
                        $exist_data = [
                            'title' => 'Nomor Antrian',
                            'intansi' => $instansi,
                            'exist_message' => $exist_message,
                            'tickets' => $existing_data,
                            'waktu_pelayanan' => $waktu_estimasi,
                        ];
                        // var_dump($existing_data);
                        // die;
                        $this->load->view('templates/header', $exist_data);
                        $this->load->view('home/nomor_antrian', $exist_data);
                        $this->load->view('templates/footer');
                        // You can return or use the existing data as needed
                        // return $exist_data;
                    } else {
                        // Data doesn't exist, insert it into the table (online_service.antrian_loket)
                        if ($this->db->insert('online_service.antrian_loket', $data)) {
                            // Successfully inserted, pass data to 'nomor_antrian' view
                            $last_insert_id = $this->db->insert_id();
                            var_dump($last_insert_id);
                            die;
                            $success_message = "Anda berhasil mendapatkan tiket nomor antrian : " . $data['no_antrian'] . "<br> Untuk tanggal kunjungan : " . $data['date_visit'];
                            $this->session->set_flashdata('success_message', $success_message);
                            $this->session->set_flashdata('last_insert_id', $last_insert_id);

                            // Load the 'nomor_antrian' view and pass data
                            $data['title'] = 'Nomor Antrian';
                            $data['instansi'] = $instansi;
                            $data['success_message'] = $success_message;
                            $data['tickets'] = $data;
                            $data['waktu_pelayanan'] = $waktu_estimasi;
                            // redirect('home/viewNomor', $data);

                            $this->load->view('templates/header', $data);
                            $this->load->view('home/nomor_antrian', $data);
                            $this->load->view('templates/footer');
                        }
                    }
                    // If insert fails, redirect back to the 'antrian/index'
                    redirect('home/cek_rm');
                }
                // Prevent form resubmission
                // redirect('antrian/successForm');
            }
        }
    }

    public function antrian_onsite()
    {
        $instansi = $this->M_crud->show('admin.profil', 'hsp_code')->row();
        $today = date('d F Y');

        // Proceed with checking the last 'no_antrian' for the specified 'date_visit'
        $result = $this->db->select_max('no_antrian')
            ->where('date_visit', $today)
            ->get('online_service.antrian_loket')
            ->row();

        $max_no_antrian = $result ? $result->no_antrian : 0;

        $date_estimate = "";
        if ($max_no_antrian === null) {
            $no_antrian = 1;
            $date_estimate = "$today 06:30:00"; // Set the initial time
        } else {
            $no_antrian = $max_no_antrian + 1;
            $date_estimate = date("Y-m-d H:i:s", strtotime($date_estimate . " +1 hour"));
        }

        // Calculate 'waktu_estimasi' and 'waktu_pelayanan'
        $current_no_antrian = $no_antrian;
        $kelipatan = floor($current_no_antrian / 70);
        $waktu_awal = strtotime("$today 06:30:00");
        $waktu_estimasi_awal = date("H:i", strtotime("+{$kelipatan} hours", $waktu_awal));
        $waktu_estimasi_akhir = date("H:i", strtotime("$waktu_estimasi_awal + 1 hour"));
        $waktu_estimasi = $waktu_estimasi_awal . " - " . $waktu_estimasi_akhir;

        $page = array(
            'title' => 'Nomor Antrian',
            'instansi' => $instansi,
            'waktu_pelayanan' => $waktu_estimasi
        );
        $data = array(
            'no_rm' => '-',
            'name' => 'Antrian Loket',
            'date_visit' => $today,
            'no_antrian' => $no_antrian,
        );

        // Assuming you want to insert the generated data into the database
        $insert_success = $this->db->insert('online_service.antrian_loket', $data);

        // You can handle the success or failure accordingly
        if ($insert_success) {
            // Data insertion succeeded
            $data_page = array_merge($page, $data);
            $this->load->view('templates/header', $data_page);
            $this->load->view('home/print_nomor', $data_page);
            $this->load->view('templates/footer');
            // redirect('antrian/viewNomor', $data_page);
            // Trigger print directly
            // echo '<script>
            //     // window.onload = function() {
            //     //         printJS();
            //     //     };

            //     //     // Listen for the afterprint event
            //     //     window.addEventListener("afterprint", function() {
            //     //         window.location.href = "' . site_url('dashboard') . '"; // Redirect to dashboard
            //     //     });
            // </script>';
        } else {
            echo "Nomor Antrian Gagal Dicetak";
        }
    }


    public function viewNomor($data_page)
    {
        $this->load->view('templates/header', $data_page);
        $this->load->view('home/print_nomor', $data_page);
        $this->load->view('templates/footer');
        redirect('dashboard');
    }

    public function updateData()
    {
    }

    public function updateStatusAntrian()
    {
        // Load the StatusAntrian_model
        $this->load->model('Antrian_model');

        // Call the method to update the status_antrian to true
        $this->Antrian_model->updateStatusAntrian();

        // Optionally, you can redirect the user to another page or display a success message
        redirect('dashboard');
    }
}