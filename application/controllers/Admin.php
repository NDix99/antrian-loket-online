<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_crud');
        $this->load->model('User_model');
        $this->load->library('pagination');
        $this->load->library('upload');
        if ($this->session->userdata('level') !== 'admin') {
            redirect('home/login');
        }
    }
    public function index()
    {
        $id = $this->session->userdata('loket');
        $instansi = $this->M_crud->show('admin.profil', 'hsp_code')->row();
        $estimasi = $this->M_crud->estimasi_pelayanan();
        $loket = $this->User_model->getLoket();
        $user = $this->User_model->getUserLoket();
        // var_dump($estimasi);
        // die;

        // buat pagination
        $data['halaman'] = $this->pagination->create_links();
        // $data['hasil'] = $this->M_crud->fetch_data('transaksi', 'tgl', $config['per_page'], $id);
        $estimasi = $this->M_crud->estimasi_pelayanan();
        $estimasi_pel = $estimasi->ticket_estimasi_pelayanan;
        $date_visit = date('d F Y');
        $no_antrian = 112;
        $kelipatan = floor($no_antrian / $estimasi_pel); // default 70 // 85 // 110
        $waktu_awal = date("H:i", strtotime($estimasi->ticket_waktupel_start));
        // die(var_dump($waktu_awal));
        $waktu_akhir = "11:30"; // bug input friday auto next day
        $waktu_estimasi_awal = date("H:i", strtotime("+$kelipatan hours", strtotime($waktu_awal)));
        // die(var_dump($waktu_estimasi_awal));
        $waktu_estimasi_akhir = date("H:i", strtotime("$waktu_estimasi_awal + 1 hour"));
        $day_of_week = date("l", strtotime($date_visit)); // Get the day of the week

        if ($day_of_week == "Friday") {
            $waktu_estimasi = "06:30" . " - " . $waktu_akhir;
        } elseif ($waktu_estimasi_awal >= $waktu_akhir) {
            $waktu_estimasi = $waktu_akhir . " - Selesai";
        } else {
            $waktu_estimasi = $waktu_estimasi_awal . " - " . $waktu_estimasi_akhir;
        }

        $data = [
            'title' => 'Dashboard Loket Pendaftaran',
            'instansi' => $instansi,
            'no_antrian' => $no_antrian,
            'estimasi' => $estimasi_pel,
            'waktu_pelayanan' => $waktu_estimasi,
            'waktu_awal' => $waktu_awal,
            'lokets' => $loket,
            'users' => $user
        ];

        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/admin_footer');
    }

    public function data_antrian()
    {
        $this->load->library('pagination');
        $this->load->model('Antrian_model');
        $id = $this->session->userdata('loket');
        $loket = $this->M_crud->get_id1('online_service.loket', array('user_id' => $id))->row();
        $instansi = $this->M_crud->show('admin.profil', 'hsp_code')->row();
        $inputDate = $this->input->post('date_visit_show') ?? date('d F Y');
        $antrianDate = date('d F Y', strtotime($inputDate));

        // Pagination config
        $search = $this->input->get('keyword');
        $limit = 10; // Set your pagination limit
        $start = $this->uri->segment(4);

        // $antrianData = $this->Antrian_model->searchAntrian($search, $limit, $start,  $inputDate);
        $antrianData = $this->Antrian_model->getDataResult($search, $inputDate);
        $antrianTotal = $this->Antrian_model->countTotalAntrian($inputDate);
        $config = array(
            'base_url' => site_url('dashboard/data_antrian'),
            'total_rows' => $antrianTotal,
            'per_page' => $limit,
            // 'suffix' => empty($_GET['date_visit']) ? '' : '?date=' . $_GET['date_visit'],
            // 'start' => $start
        );
        // Retrieve data for the current page
        $config['uri_segment'] = 4; // Segmen URI yang digunakan untuk menentukan nomor halaman
        $config['num_links'] = 5; // Number of pagination links to show
        // Pagination Styling
        $config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';

        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['attributes'] = array('class' => 'page-link');
        // Initialize pagination
        $this->pagination->initialize($config);
        $paginationData = $this->pagination->create_links();

        // Load your view and pass the data
        $antrianData = $this->Antrian_model->getDataAntrian($inputDate, $search);
        $antrianTotal = $this->Antrian_model->countTotalAntrian($inputDate);
        // Check if there is data for the given date
        // if (empty($antrianData)) {
        $data = [
            'title' => "Tabel Data Antrian",
            'instansi' => $instansi,
            'antrianDate' => $antrianDate,
            'antrianData' => $antrianData,
            'antrianTotal' => $antrianTotal,
            'error_message' => 'No data available for the selected date.',
            'pagination' => $paginationData
        ];

        $this->load->view('templates/admin_header', $data);
        $this->load->view('dashboard/data_antrian', $data);
        $this->load->view('templates/admin_footer');
    }

    public function agenda($id = null)
    {
        $data['instansi'] = $this->M_crud->show('instansi', 'id_instansi DESC')->row();
        //$data['perhari'] = $this->M_crud->get_group_id('transaksi', 'tgl')->result();
        $data['content'] = 'admin/agenda';
        $data['menu'] = "admin/menu";
        $data['text_jalan'] = $this->M_crud->show('text_jalan', 'id_text DESC')->result();
        $config['base_url']         = site_url('admin/agenda/');
        $config['total_rows']         = $this->M_crud->get_group_id('agenda', 'id_agenda')->num_rows();
        $config['per_page']            = '7';
        $config['num_links']        = 5;
        $config['full_tag_open']    = '<ul class="pagination">';
        $config['full_tag_close']    = '</ul>';
        $config['first_link']        = 'First';
        $config['last_link']        = 'Last';
        $config['first_tag_open']    = '<li>';
        $config['first_tag_close']    = '</li>';
        $config['prev_link']        = '&laquo';
        $config['prev_tag_open']    = '<li class="prev">';
        $config['porev_tag_close']    = '</li>';
        $config['next_link']        = '&raquo';
        $config['next_tag_open']    = '<li>';
        $config['next_tag_close']    = '</li>';
        $config['last_tag_open']    = '<li>';
        $config['last_tag_close']    = '</li>';
        $config['cur_tag_open']        = '<li class="active"><a href="">';
        $config['cur_tag_close']    = '</a></li>';
        $config['num_tag_open']        = '<li>';
        $config['num_tag_close']    = '</li>';

        $this->pagination->initialize($config);

        // buat pagination
        $data['halaman'] = $this->pagination->create_links();
        $data['hasil'] = $this->M_crud->fetch_data('agenda', 'id_agenda', $config['per_page'], $id);

        $this->load->view('layout', $data);
    }

    public function karyawan($id = null)
    {
        $data['instansi'] = $this->M_crud->show('instansi', 'id_instansi DESC')->row();
        $data['loket'] = $this->M_crud->show('loket', 'loket ASC');
        //$data['perhari'] = $this->M_crud->get_group_id('transaksi', 'tgl')->result();
        $data['content'] = 'admin/karyawan';
        $data['menu'] = "admin/menu";
        $data['text_jalan'] = $this->M_crud->show('text_jalan', 'id_text DESC')->result();
        $config['base_url']         = site_url('admin/karyawan');;
        $config['total_rows']         = $this->M_crud->get_group_id('karyawan', 'username')->num_rows();
        $config['per_page']            = '7';
        $config['num_links']        = 5;
        $config['full_tag_open']    = '<ul class="pagination">';
        $config['full_tag_close']    = '</ul>';
        $config['first_link']        = 'First';
        $config['last_link']        = 'Last';
        $config['first_tag_open']    = '<li>';
        $config['first_tag_close']    = '</li>';
        $config['prev_link']        = '&laquo';
        $config['prev_tag_open']    = '<li class="prev">';
        $config['porev_tag_close']    = '</li>';
        $config['next_link']        = '&raquo';
        $config['next_tag_open']    = '<li>';
        $config['next_tag_close']    = '</li>';
        $config['last_tag_open']    = '<li>';
        $config['last_tag_close']    = '</li>';
        $config['cur_tag_open']        = '<li class="active"><a href="">';
        $config['cur_tag_close']    = '</a></li>';
        $config['num_tag_open']        = '<li>';
        $config['num_tag_close']    = '</li>';

        $this->pagination->initialize($config);

        // buat pagination
        $data['halaman'] = $this->pagination->create_links();
        $data['hasil'] = $this->M_crud->fetch_data('karyawan', 'username', $config['per_page'], $id);

        $this->load->view('layout', $data);
    }

    public function loket($id = null)
    {
        $data['instansi'] = $this->M_crud->show('instansi', 'id_instansi DESC')->row();
        //$data['perhari'] = $this->M_crud->get_group_id('transaksi', 'tgl')->result();
        $data['content'] = 'admin/loket';
        $data['menu'] = "admin/menu";
        $data['text_jalan'] = $this->M_crud->show('text_jalan', 'id_text DESC')->result();
        $config['base_url']         = site_url('admin/loket/');;
        $config['total_rows']         = $this->M_crud->get_group_id('loket', 'id_loket')->num_rows();
        $config['per_page']            = '7';
        $config['num_links']        = 5;
        $config['full_tag_open']    = '<ul class="pagination">';
        $config['full_tag_close']    = '</ul>';
        $config['first_link']        = 'First';
        $config['last_link']        = 'Last';
        $config['first_tag_open']    = '<li>';
        $config['first_tag_close']    = '</li>';
        $config['prev_link']        = '&laquo';
        $config['prev_tag_open']    = '<li class="prev">';
        $config['porev_tag_close']    = '</li>';
        $config['next_link']        = '&raquo';
        $config['next_tag_open']    = '<li>';
        $config['next_tag_close']    = '</li>';
        $config['last_tag_open']    = '<li>';
        $config['last_tag_close']    = '</li>';
        $config['cur_tag_open']        = '<li class="active"><a href="">';
        $config['cur_tag_close']    = '</a></li>';
        $config['num_tag_open']        = '<li>';
        $config['num_tag_close']    = '</li>';

        $this->pagination->initialize($config);

        // buat pagination
        $data['halaman'] = $this->pagination->create_links();
        $data['hasil'] = $this->M_crud->fetch_data('loket', 'id_loket', $config['per_page'], $id);

        $this->load->view('layout', $data);
    }

    public function instansi($id = null)
    {
        $data['instansi'] = $this->M_crud->show('instansi', 'id_instansi DESC')->row();
        //$data['perhari'] = $this->M_crud->get_group_id('transaksi', 'tgl')->result();
        $data['content'] = 'admin/instansi';
        $data['menu'] = "admin/menu";
        $data['text_jalan'] = $this->M_crud->show('text_jalan', 'id_text DESC')->result();
        $data['hasil'] = $this->M_crud->show('instansi', 'id_instansi DESC')->result();

        $this->load->view('layout', $data);
    }

    public function text_jalan($id = null)
    {
        $data['instansi'] = $this->M_crud->show('instansi', 'id_instansi DESC')->row();
        //$data['perhari'] = $this->M_crud->get_group_id('transaksi', 'tgl')->result();
        $data['content'] = 'admin/text_jalan';
        $data['menu'] = "admin/menu";
        $data['text_jalan'] = $this->M_crud->show('text_jalan', 'id_text DESC')->result();
        $config['base_url']         = site_url('admin/text_jalan/');
        $config['total_rows']         = $this->M_crud->show('text_jalan', 'id_text DESC')->num_rows();
        $config['per_page']            = '7';
        $config['num_links']        = 5;
        $config['full_tag_open']    = '<ul class="pagination">';
        $config['full_tag_close']    = '</ul>';
        $config['first_link']        = 'First';
        $config['last_link']        = 'Last';
        $config['first_tag_open']    = '<li>';
        $config['first_tag_close']    = '</li>';
        $config['prev_link']        = '&laquo';
        $config['prev_tag_open']    = '<li class="prev">';
        $config['porev_tag_close']    = '</li>';
        $config['next_link']        = '&raquo';
        $config['next_tag_open']    = '<li>';
        $config['next_tag_close']    = '</li>';
        $config['last_tag_open']    = '<li>';
        $config['last_tag_close']    = '</li>';
        $config['cur_tag_open']        = '<li class="active"><a href="">';
        $config['cur_tag_close']    = '</a></li>';
        $config['num_tag_open']        = '<li>';
        $config['num_tag_close']    = '</li>';

        $this->pagination->initialize($config);

        // buat pagination
        $data['halaman'] = $this->pagination->create_links();
        $data['hasil'] = $this->M_crud->fetch_data('text_jalan', 'id_text', $config['per_page'], $id);

        $this->load->view('layout', $data);
    }

    public function edit_karyawan()
    {
        if ($this->input->post('password') == '') {
            $pass = $this->input->post('password_lama');
        } else {
            $pass = sha1(md5($this->input->post('password')));
        }
        $username = $this->input->post('username');
        $nama = $this->input->post('nama');
        $telp = $this->input->post('telp');
        $alamat = $this->input->post('alamat');
        $level = $this->input->post('level');

        $data = array('nama' => $nama, 'telp' => $telp, 'alamat' => $alamat, 'password' => $pass, 'level' => $level);
        $where = array('username' => $username);
        $this->M_crud->edit('karyawan', $data, $where);

        $this->session->set_flashdata("pesan", "<br><div class='alert alert-success'><center>Data berhasil diupdate</center></div>");
        redirect('admin/karyawan/');
    }
    public function del_karyawan($id)
    {
        $where = array('username' => $id);
        $this->M_crud->del('karyawan', $where);
        $this->session->set_flashdata("pesan", "<br><div class='alert alert-success'><center>Data berhasil dihapus</center></div>");
        redirect('admin/karyawan/');
    }
    public function add_agenda()
    {
        $media = $_FILES['media']['name'];
        if ($media != '') {
            list($txt, $ext) = explode(".", $media);
            $media_baru    = "agenda_" . time() . "." . $ext;
            $path            = "./media/agenda/";

            $config['file_name'] = $media_baru;
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
            $config['max_size'] = '10050';
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('media')) {
                // pesan error
                echo $path;
                echo $this->upload->display_errors();
                exit;
            }
        } else {
            $media_baru    = "404.png";
        }
        $agenda = $this->input->post('agenda');

        $data = array('agenda' => $agenda, 'file' => $media_baru);
        $this->M_crud->add('agenda', $data);

        $this->session->set_flashdata("pesan", "<br><div class='alert alert-success'><center>Data berhasil ditambah</center></div>");
        redirect('admin/agenda/');
    }

    public function edit_agenda()
    {
        $id = $this->input->post('id_agenda');
        $where = array('id_agenda' => $id);
        $media = $_FILES['media']['name'];
        if ($media != '') {
            list($txt, $ext) = explode(".", $media);
            $media_baru    = "agenda_" . time() . "." . $ext;
            $path            = "./media/agenda/";

            $config['file_name'] = $media_baru;
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
            $config['max_size'] = '10050';
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('media')) {
                // pesan error
                echo $path;
                echo $this->upload->display_errors();
                exit;
            }
            $cek = $this->M_crud->get_id('agenda', $where);
            if ($cek->row('file') != '404.png') {
                if (file_exists('./media/agenda/' . $cek->row('file'))) {
                    unlink('./media/agenda/' . $cek->row('file'));
                }
            }
        } else {
            $media_baru    = $this->input->post('media_lama');
        }
        $agenda = $this->input->post('agenda');

        $data = array('agenda' => $agenda, 'file' => $media_baru);
        $this->M_crud->edit('agenda', $data, $where);

        $this->session->set_flashdata("pesan", "<br><div class='alert alert-success'><center>Data berhasil diupdate</center></div>");
        redirect('admin/agenda/');
    }

    public function del_agenda($id)
    {
        $where = array('id_agenda' => $id);
        $cek = $this->M_crud->get_id('agenda', $where);
        if (file_exists('./media/agenda/' . $cek->row('file'))) {
            unlink('./media/agenda/' . $cek->row('file'));
        }
        $this->M_crud->del('agenda', $where);
        $this->session->set_flashdata("pesan", "<br><div class='alert alert-success'><center>Data berhasil dihapus</center></div>");
        redirect('admin/agenda/');
    }

    public function add_text()
    {
        $media = $_FILES['img']['name'];
        if ($media != '') {
            list($txt, $ext) = explode(".", $media);
            $media_baru    = "text_" . time() . "." . $ext;
            $path            = "./media/agenda/";

            $config['file_name'] = $media_baru;
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
            $config['max_size'] = '10050';
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('img')) {
                // pesan error
                echo $path;
                echo $this->upload->display_errors();
                exit;
            }
        } else {
            $media_baru    = "404.png";
        }
        $text = $this->input->post('text');

        $data = array('text' => $text, 'img' => $media_baru);
        $this->M_crud->add('text_jalan', $data);

        $this->session->set_flashdata("pesan", "<br><div class='alert alert-success'><center>Data berhasil ditambah</center></div>");
        redirect('admin/text_jalan/');
    }

    public function edit_text()
    {
        $id = $this->input->post('id_text');
        $where = array('id_text' => $id);
        $media = $_FILES['img']['name'];
        if ($media != '') {
            list($txt, $ext) = explode(".", $media);
            $media_baru    = "text_" . time() . "." . $ext;
            $path            = "./media/agenda/";

            $config['file_name'] = $media_baru;
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
            $config['max_size'] = '10050';
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('img')) {
                // pesan error
                echo $path;
                echo $this->upload->display_errors();
                exit;
            }
            $cek = $this->M_crud->get_id('text_jalan', $where);
            if ($cek->row('img') != '404.png') {
                if (file_exists('./media/agenda/' . $cek->row('img'))) {
                    unlink('./media/agenda/' . $cek->row('img'));
                }
            }
        } else {
            $media_baru    = $this->input->post('img_lama');
        }
        $text = $this->input->post('text');

        $data = array('text' => $text, 'img' => $media_baru);
        $this->M_crud->edit('text_jalan', $data, $where);

        $this->session->set_flashdata("pesan", "<br><div class='alert alert-success'><center>Data berhasil diupdate</center></div>");
        redirect('admin/text_jalan/');
    }

    public function del_text($id)
    {
        $where = array('id_text' => $id);
        $cek = $this->M_crud->get_id('text_jalan', $where);
        if (file_exists('./media/agenda/' . $cek->row('img'))) {
            unlink('./media/agenda/' . $cek->row('img'));
        }
        $this->M_crud->del('text_jalan', $where);
        $this->session->set_flashdata("pesan", "<br><div class='alert alert-success'><center>Data berhasil dihapus</center></div>");
        redirect('admin/text_jalan/');
    }

    // Web Antrian

    public function addLoket()
    {
        echo "Controller method called!";
        // die;
        // $instansi = $this->M_crud->show('admin.profil', 'hsp_code')->row();
        $loket = $this->User_model->getLoket();
        $user = $this->User_model->getUserLoket();
        $data = [
            'title' => 'Dashboard Loket Pendaftaran',
            // 'instansi' => $instansi,
            'lokets' => $loket,
            'users' => $user
        ];
        // var_dump($user->name);
        // die;
        // $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/add_loket', $data);
        // $this->load->view('templates/admin_footer');
    }

    public function add_loket()
    {
        // $id_loket = $this->m_crud->get_id1('online_service.user_loket', 'id_loket');
        $users = htmlspecialchars($this->input->post('user_id'));
        $loket = htmlspecialchars($this->input->post('no_loket'));
        $status = htmlspecialchars($this->input->post('status'));

        // Check if the "loket" already exists
        $existingLoket = $this->M_crud->get_id1('online_service.loket', array('no_loket' => $loket));

        if ($existingLoket->num_rows() > 0) {
            $this->session->set_flashdata("loket_message", "<br><div class='alert alert-danger'><center>Loket sudah ada</center></div>");
            redirect('home/login');
        } else {
            $data = array('no_loket' => $loket, 'user_id' => $users, 'status' => $status);
            $this->M_crud->add1('online_service.loket', $data);
            $this->session->set_flashdata("loket_message", "<br><div class='alert alert-success'><center>Loket berhasil ditambah</center></div>");
            $this->session->set_flashdata($data);
            redirect('home/login', $data);
        }
    }
    public function edit_loket($id)
    {
        $loket = htmlspecialchars($this->input->post('loket'));
        $status = htmlspecialchars($this->input->post('status'));
        $where = array('id_loket' => $id);
        $this->M_crud->edit('loket', array('loket' => $loket, 'status' => $status), $where);
        redirect('admin/loket');
    }
    public function del_loket($id)
    {
        $where = array('id_loket' => $id);
        $this->M_crud->del('loket', $where);
        redirect('admin/loket/');
    }
    public function edit_instansi($id)
    {
        $instansi = htmlspecialchars($this->input->post('instansi'));
        $telp = htmlspecialchars($this->input->post('telp'));
        $alamat = htmlspecialchars($this->input->post('alamat'));
        $logo = $_FILES['logo']['name'];
        $where = array('id_instansi' => $id);
        if ($logo != '') {
            $cek = $this->M_crud->get_id('instansi', $where);
            list($txt, $ext) = explode(".", $logo);
            $logo_baru    = "logo_" . time() . "." . $ext;
            $path            = "./media/";

            $config['file_name'] = $logo_baru;
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
            $config['max_size'] = '1050';
            $config['max_width'] = '1024';
            $config['max_height'] = '800';
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('logo')) {
                // pesan error
                echo $path;
                echo $this->upload->display_errors();
                exit;
            } else if (file_exists('./media/' . $cek->row('logo'))) {
                unlink('./media/' . $cek->row('logo'));
            }
        } else {
            $logo_baru    = $this->input->post('logo_lama');
        }
        $data = array('instansi' => $instansi, 'telp' => $telp, 'alamat' => $alamat, 'logo' => $logo_baru);
        $this->M_crud->edit('instansi', $data, $where);
        redirect('admin/instansi');
    }

    public function getLoket()
    {
        $data = $this->M_crud->get_lokets();
        // var_dump($data);
        echo json_encode($data);
    }
    public function getUser($id = null)
    {
        // Check if id is provided
        if ($id === null) {
            // Get all users if id is null
            $data = $this->M_crud->get_users();
        } else {
            // Get user by id if id is provided
            $data = $this->M_crud->get_users($id);
        }

        // Check if user data exists
        if ($data) {
            // Return the user data as JSON response
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        } else {
            // Return an error message if user data is not found
            $this->output
                ->set_status_header(404)
                ->set_content_type('application/json')
                ->set_output(json_encode(array('error' => 'User not found')));
        }
    }
    public function add_user()
    {
        $username = $this->input->post('username');
        $pass = sha1(md5($this->input->post('password')));
        $nama = $this->input->post('name');
        $level = $this->input->post('level');
        $id_loket = $this->input->post('id_loket');

        $cek = $this->M_crud->get_id1('online_service.user_loket', array('user_name' => $username))->num_rows();
        if ($cek > 0) {
            $this->session->set_flashdata("user_message", "<br><div class='alert alert-danger'>
              		 <p class='text-danger'><center>Username Sudah Ada</center></p></div>");
            redirect('admin/addUser');
        } else {
            $data = array('user_name' => $username, 'name' => $nama, 'user_password' => $pass, 'level' => $level, 'id_loket' => $id_loket);
            $this->M_crud->add1('online_service.user_loket',  $data);
            $this->session->set_flashdata("user_message", "<br><div class='alert alert-success'>
              		 <p class='text-danger'><center>User Loket berhasil ditambah</center></p></div>");
            redirect('home/login');
        }
    }
    public function deleteUser($id)
    {

        // Call the model method to delete user by ID
        $result = $this->M_crud->deleteUserById($id);

        // Check if deletion was successful
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'User deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete user']);
        }
    }



    public function getAdditionalHolidays()
    {
        // Fetch additional holidays from the 'holiday' table
        $query = $this->db->select('holiday_date')->get('holiday');

        // Check if query is successful
        if ($query->num_rows() > 0) {
            // Extract dates from the result
            $additionalHolidays = $query->result_array();

            // Extract dates from the result array
            $dates = array_map(function ($holiday) {
                return $holiday['date'];
            }, $additionalHolidays);

            // Send the dates as JSON response
            $this->output->set_content_type('application/json')->set_output(json_encode($dates));
        } else {
            // No additional holidays found
            $this->output->set_content_type('application/json')->set_output(json_encode([]));
        }
    }

    public function saveTiket()
    {
        // Get the raw JSON data from the request body
        $json_data = file_get_contents('php://input');
        // Decode JSON data to PHP array
        $data = json_decode($json_data, true);
        if ($data) {
            // Prepare data for database
            $tiket_data = array(
                'ticket_estimasi_pelayanan' => $data['estimate_time_update'],
                // 'ticket_waktupel_start' => $data['estimate_start'],
                // 'ticket_waktupel_end' => $data['estimate_end'],
                // 'ticket_waktu_auto' => $data['estimate_auto'],
            );

            // Save to database
            if ($this->M_crud->save_tiket($tiket_data)) {
                echo json_encode(array('status' => true, 'message' => 'Tiket saved successfully.'));
            } else {
                echo json_encode(array('status' => false, 'message' => 'Failed to save tiket.'));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => 'Invalid data format.'));
        }
    }

    public function saveInfo()
    {
        // Get the raw JSON data from the request body
        $json_data = file_get_contents('php://input');
        // Decode JSON data to PHP array
        $data = json_decode($json_data, true);
        if ($data) {
            // Prepare data for database
            $info_data = array(
                'info_title' => $data['info_title'],
                'info_header' => $data['info_header'],
                'info_body' => $data['info_body'],
                'info_notes' => $data['info_notes'],
                'info_date' => $data['info_date'],
            );

            // Save to database
            if ($this->M_crud->save_info($info_data)) {
                echo json_encode(array('status' => true, 'message' => 'Info saved successfully.'));
            } else {
                echo json_encode(array('status' => false, 'message' => 'Failed to save info.'));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => 'Invalid data format.'));
        }
    }

    public function getInfo()
    {
        $data = $this->M_crud->get_info();
        // var_dump($data);
        echo json_encode($data);
    }
    public function getLibur()
    {
        $data = $this->M_crud->get_libur();
        // var_dump($data);
        echo json_encode($data);
    }
    public function saveLibur()
    {
        // Get the raw JSON data from the request body
        $json_data = file_get_contents('php://input');
        // Decode JSON data to PHP array
        $data = json_decode($json_data, true);
        // Check if tgl_libur already exists
        if ($data) {
            // Check if tgl_libur already exists
            $tgl_libur = isset($data['holiday_date']) ? $data['holiday_date'] : null;
            if ($tgl_libur && $this->db->where('tgl_libur', $tgl_libur)->get('online_service.antrian_libur')->num_rows() > 0) {
                echo json_encode(array('status' => false, 'message' => 'Tanggal Libur already exists.'));
                return;
            }
            // Prepare data for database
            $info_data = array(
                'tgl_libur' => $data['holiday_date'],
                'hari_libur' => $data['holiday'],
            );

            // Save to database
            if ($this->M_crud->save_libur($info_data)) {
                echo json_encode(array('status' => true, 'message' => 'Tanggal Libur saved successfully.'));
            } else {
                echo json_encode(array('status' => false, 'message' => 'Failed to save tanggal libur.'));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => 'Invalid tanggal libur.'));
        }
    }

    public function deleteLibur()
    {
        // Get the JSON data from the request body
        $json_data = file_get_contents('php://input');

        // Decode JSON data to PHP array
        $data = json_decode($json_data, true);
        // Check if the ID is present in the JSON data
        if (isset($data['id'])) {
            // Extract the ID from the JSON data
            $id = $data['id'];

            // Call the model method to delete the record by ID
            $result = $this->M_crud->deleteLiburById($id);

            // Check if deletion was successful
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Record deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete record']);
            }
        } else {
            // If ID is not provided in the JSON data, return an error response
            echo json_encode(['success' => false, 'message' => 'ID not found in request data']);
        }
    }

    public function saveSettings()
    {
        // Get JSON data from POST request
        $json_data = file_get_contents('php://input');
        $setting_data = json_decode($json_data, true);

        // Check if JSON data is valid
        if ($setting_data) {
            // Prepare data for database
            $settings = array(
                'is_info_enabled' => isset($setting_data['is_info_enabled']) ? ($setting_data['is_info_enabled'] ? 't' : 'f') : 'f',
                'is_rm_enabled' => isset($setting_data['is_rm_enabled']) ? ($setting_data['is_rm_enabled'] ? 't' : 'f') : 'f',
                'is_datevisit_enabled' => isset($setting_data['is_datevisit_enabled']) ? ($setting_data['is_datevisit_enabled'] ? 't' : 'f') : 'f',
                'is_btn_enabled' => isset($setting_data['is_btn_enabled']) ? ($setting_data['is_btn_enabled'] ? 't' : 'f') : 'f'
            );

            // Save to database using model
            $result = $this->M_crud->save_settings($settings);
            // Check if save operation was successful
            if ($result) {
                // Return success response
                echo json_encode(array('status' => true, 'message' => 'Settings saved successfully.'));
            } else {
                // Return error response
                echo json_encode(array('status' => false, 'message' => 'Failed to save settings.'));
            }
        } else {
            // Return error response for invalid JSON data
            echo json_encode(array('status' => false, 'message' => 'Invalid data format.'));
        }
    }
    public function getDataAntrian($date_visit = '')
    {
        if (empty($date_visit)) {
            $date_visit = date('Y-m-d');
        }

        // Log the received date_visit parameter
        error_log('Received date_visit parameter: ' . $date_visit);

        $data = $this->M_crud->get_data_antrian($date_visit);

        // Log the data received from the model
        error_log('Data from the model: ' . json_encode($data));

        echo json_encode($data);
    }
}
