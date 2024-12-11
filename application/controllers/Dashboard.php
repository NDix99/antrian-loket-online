<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->helper('url');
        $this->load->model('User_model');
        $this->load->model('Antrian_model');
        $this->load->model('M_crud');
        // $this->check_session_expiry();
        // var_dump($this->session->all_userdata());
        // die;

        // Check if a user is logged in
        // if (!$this->session->userdata('user_id')) {
        //     // Redirect to login page or perform any other action
        //     redirect('home/login'); // Change 'login' to your actual login page route
        // }

        // Check user level if needed
        if ($this->session->userdata('level') !== 'user_loket') {
            // Redirect to appropriate page
            redirect('home/login'); // Change 'dashboard' to the appropriate route
        }
    }

    public function index()
    {
        $this->load->library('pagination');
        $this->load->model('Antrian_model');
        $currentDate = date('Y-m-d');
        $id = $this->session->userdata('loket');
        $loket = $this->M_crud->get_id1('online_service.loket', array('user_id' => $id))->row();
        // Get the search query from the user input
        // $search = $this->input->post('search');
        // if ($search) {
        //     $keyword = $this->input->post('search');
        // } else {
        //     $keyword = null;
        // }

        // Paginatin config
        $config['base_url'] = base_url('dashboard/index'); // URL halaman yang digunakan untuk pagination
        $config['total_rows'] = $this->Antrian_model->countTotalAntrianToday(); // Jumlah total baris dalam tabel
        // Retrieve data for the current page
        $config['per_page'] = 10; // Jumlah baris per halaman
        $config['uri_segment'] = 3; // Segmen URI yang digunakan untuk menentukan nomor halaman
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
        $pagination = $this->pagination->create_links();
        // Get the offset from the URI segment
        $data['start'] = $this->uri->segment(3);
        // Get the current page
        // $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        // Apply the limit and offset to the query
        // $antrianList = $this->Antrian_model->getTodayAntrianList($currentDate, $config['per_page'], $data['start']);
        $antrianList = $this->Antrian_model->getTodayAntrianList($currentDate);
        // Retrieve search results for the current page
        // $antrianList = $this->Antrian_model->getSearchResults($config['per_page'], $page);

        $totalAntrian = $this->Antrian_model->countTotalAntrianToday();
        $antrianDone = $this->Antrian_model->countTotalAntrianDone();
        $antrianNow = $this->Antrian_model->countAntrianNow();
        $queueAntrian = $totalAntrian - $antrianDone;
        $nextAntrian = $this->Antrian_model->countNextAntrian();
        // $todayAntrian = $this->Antrian_model->getTodayAntrian($currentDate);
        // $remainingAntrian = $totalAntrian - $doneAntrian;
        $instansi = $this->M_crud->show('admin.profil', 'hsp_code')->row();
        // $dateVisit = $this->Antrian_model->getTodayAntrian($currentDate);

        $data = [
            'title' => 'Dashboard Loket Pendaftaran',
            'instansi' => $instansi,
            // 'search' => $search,
            'loket' => $loket,
            'antrianList' => $antrianList,
            // 'dateVisit' => $dateVisit,
            'totalAntrian' => $totalAntrian,
            'queueAntrian' => $queueAntrian,
            'antrianDone' => $antrianDone,
            'antrianNow' => $antrianNow,
            'nextAntrian' => $nextAntrian,
            'pagination' => $pagination
        ];
        $this->load->view('templates/dashboard_header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/dashboard_footer');
    }

    public function login()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required', [
            'required' => 'Username harus diisi',
        ]);
        $this->form_validation->set_rules('password', 'Password', 'trim|required', [
            'required' => 'Password harus diisi',
        ]);
        $user_message = validation_errors();

        $data['title'] = 'Login Admin';
        $data['instansi'] = $this->M_crud->show('admin.profil', 'hsp_code')->row();
        $data['user_message'] = $user_message;
        $data['content'] = 'login';
        $data['menu'] = 'menu';
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/login', $data);
        $this->load->view('templates/footer', $data);

        $this->session->sess_destroy();
    }

    public function validasi()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required', [
            'required' => 'Username harus diisi',
        ]);
        $this->form_validation->set_rules('password', 'Password', 'trim|required', [
            'required' => 'Password harus diisi',
        ]);

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('user_message', validation_errors());
            redirect('dashboard/login/');
            $this->session->sess_destroy();
        } else {
            $user = $this->input->post('username');
            $pass = sha1(md5($this->input->post('password')));
            $cek = $this->M_crud->get_id1('online_service.user_loket', array('user_name' => $user));
            // Check if the session has expired
            // if ($this->session->userdata('last_activity') + $this->config->item('sess_expiration') < time()) {
            //     // Session has expired, set status to 0
            //     $this->M_crud->edit1('online_service.loket', array('status' => 0), array('id_loket' => $cek->row('id_loket')));
            //     $this->session->sess_destroy();
            //     redirect('home/login/');
            // }
            if ($cek->num_rows() > 0 && $cek->row('user_password') == $pass) {
                $id_loket = $cek->row('id_loket');
                // Reset the status to 1 when the user logs in again
                $this->M_crud->edit1('online_service.loket', array('status' => 1), array('id_loket' => $id_loket));
                if ($cek->row('status') == 1) {
                    echo "<br><center><h1><div class='alert alert-danger'>
	              		 <p class='text-danger'>Status loket anda sedang digunakan</b></p></div></h1>
	              		 <a href='" . base_url('home/login') . "'>Kembali</a>
	              		 </center>";
                } else {
                    $session = array(
                        'username' => $cek->row('user_name'),
                        'nama' => $cek->row('name'),
                        'level' => $cek->row('level'),
                        'loket' => $cek->row('id_loket'),
                        'status' => $cek->row('status')
                    );
                    $this->session->set_userdata($session);
                    $this->session->set_flashdata("user_message", "<br><div class='alert alert-success'>
	              		 <p class='text-danger'>Selamat datang <b>" . $this->session->userdata('name') . "</b></p></div>");
                    // var_dump($_SESSION);
                    // die;
                    if ($this->session->userdata('level') == 'user_loket') {
                        redirect('dashboard/');
                    } elseif ($this->session->userdata('level') == 'admin') {
                        redirect('admin');
                    } else {
                        // $this->M_crud->edit1('online_service.loket', array('status' => 1), array('id_loket' => $cek->row('id_loket')));
                        redirect('dashboard/login');
                    }
                }
            } else {
                $this->session->set_flashdata("user_message", "Password tidak sesuai");
                redirect('dashboard/login');
            }
            $this->session->set_flashdata("user_message", "Username tidak ditemukan");
            redirect('dashboard/login');
        }
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

        $this->load->view('templates/dashboard_header', $data);
        $this->load->view('dashboard/data_antrian', $data);
        $this->load->view('templates/dashboard_footer');
        // }
        // } else {
        //     $data = [
        //         'title' => "Tabel Data Antrian",
        //         'instansi' => $instansi,
        //         'antrianData' => $antrianData,
        //         'antrianTotal' => $antrianTotal,
        //         'antrianDate' => $antrianDate,
        //         'pagination' => $paginationData
        //     ];
        //     $this->load->view('templates/dashboard_header', $data);
        //     $this->load->view('dashboard/data_antrian', $data);
        //     $this->load->view('templates/dashboard_footer');
        // }
    }

    public function loket()
    {
        date_default_timezone_set('Asia/Jakarta');
        $currentDate = date('Y-m-d');

        $id = $this->session->userdata('loket');
        $loket = $this->M_crud->get_id1('online_service.loket', array('user_id' => $id))->row();
        $instansi = $this->M_crud->show('admin.profil', 'hsp_code')->row();
        $id_loket = $loket->id_loket;

        $totalAntrian = $this->Antrian_model->countTotalAntrianToday($currentDate);
        // $antrian = $this->Antrian_model->getTodayAntrianList($currentDate);
        // $ongoingAntrian = $this->Antrian_model->getOngoingAntrian($currentDate, $loket);
        $nextAntrian = $this->Antrian_model->countNextAntrian();
        $antrianNow = $this->Antrian_model->countAntrianNow();
        $antriLoket = $this->Antrian_model->getLastLoket($id);

        // $getLoket = $this->M_crud->get_max_id('online_service.antrian_loket', 'no_antrian', [
        //     'id_loket' => $loket->no_loket,
        //     'date_visit' => $currentDate,
        //     'id_loket !=' => $loket->no_loket
        // ])->row('no_antrian');

        // $getLoket = $this->M_crud->get_max_id('online_service.antrian_loket', 'no_antrian', [
        //     'id_loket' => $loket->no_loket,
        //     'date_visit' => date('Y-m-d', strtotime($currentDate)),
        // ])->row('no_antrian');

        // var_dump($antriLoket);
        // die;
        // Use an array to pass data to the view, which is cleaner and easier to read
        $antriLoket = $antriLoket ?? null; // Ensure $antriLoket is not null
        $data = [
            'title' => 'Dashboard Loket Pendaftaran',
            'instansi' => $instansi,
            // 'content' => 'penjaga',
            // 'menu' => 'menu',
            // 'antrian' => $antrian,
            'totalAntrian' => $totalAntrian,
            'antrianNow' => $antrianNow,
            'nextAntrian' => $nextAntrian,
            'loket'  => $loket,
            'antriLoket' => $antriLoket ? $antriLoket->no_antrian : 'N/A',
        ];
        // var_dump($data['antriLoket']);
        // die;

        // Load your view and pass the data
        $this->load->view('templates/dashboard_header', $data);
        $this->load->view('dashboard/loket', $data);
        $this->load->view('templates/dashboard_footer');
    }


    public function viewAdmin()
    {
        $instansi = $this->M_crud->show('admin.profil', 'hsp_code')->row();

        $data = [
            'title' => 'Dashboard Loket Pendaftaran',
            'instansi' => $instansi,
        ];

        $this->load->view('templates/dashboard_header', $data);
        $this->load->view('dashboard/admin', $data);
        $this->load->view('templates/dashboard_footer');
    }

    public function callNext()
    {
        $this->load->model('Antrian_model');
        $id_loket = $this->session->userdata('loket'); // Get the id_loket from the session
        $this->Antrian_model->getNext($id_loket);
        redirect('dashboard');
    }
    public function callPrev()
    {
        $this->load->model('Antrian_model');
        $id_loket = $this->session->userdata('loket'); // Get the id_loket from the session
        $this->Antrian_model->getPrev($id_loket);
        redirect('dashboard');
    }
    public function next()
    {
        $id_loket = $this->session->userdata('loket'); // Get the id_loket from the session
        $this->Antrian_model->next();
        redirect('dashboard/index');
    }

    public function regis()
    {
        $data['title'] = 'Registration Page';
        $this->load->view('dashboard/registration');
        $this->load->view('templates/dashboard_footer');
    }

    public function addUser()
    {
        // name, alias, validation rules
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|matches[password1]', [
            'matches' => 'password doesnt match!',
            'min_length' => 'password too short!',
        ]);
        $this->form_validation->set_rules('password1', 'Password1', 'required|trim|matches[password]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('dashboard/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $data = [
                'username' => htmlspecialchars($this->input->post('username', true)), // trus = untuk menghindari xss (cross site scripting)
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),

            ];

            $this->db->insert('admin.ms_user', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Congratulation! your account has been created. Please Login!</div>');
            redirect('dashboard/loginAdmin');
        }
    }

    public function getNoAntrian()
    {
        $this->load->model('Antrian_model');

        // Mengambil nilai 'loket' dari session
        $id_loket = $this->session->userdata('loket');

        if ($id_loket !== false) {
            $no_antrian = $this->Antrian_model->getAntrianLoket($id_loket);

            if ($no_antrian !== null) {
                $data = array(
                    'id_loket' => $id_loket,
                    'no_antrian' => $no_antrian
                );

                // Load the view and pass the data
                $this->load->view('dashboard/loket', $data);
                // Menghasilkan output seperti "loket X = no_antrian Y"
                // echo "loket " . $id_loket . " = no_antrian " . $no_antrian;
            } else {
                echo "Tidak ada antrian tersedia untuk loket ini hari ini.";
            }
        } else {
            echo "Session 'loket' tidak ditemukan atau kosong.";
        }
    }

    public function noLoket()
    {
        $this->load->model('M_crud');
        $id = $this->session->userdata('loket');
        $data['instansi'] = $this->M_crud->show('admin.profil', 'hsp_code')->row();
        // $data['agenda'] = $this->M_crud->show('agenda', 'id_agenda DESC')->row();
        $data['loket'] = $this->M_crud->get_id1('online_service.loket', array('id_loket' => $id))->row();

        $data['antrian'] = $this->M_crud->get_max_id('online_service.antrian_loket', 'no_antrian', array('id_loket' => $id, 'date_visit' => date('Y-m-d')))->row();
        $where = array('id_loket <' => 1, 'date_visit' => date('Y-m-d'));
        $data['cek'] = $this->M_crud->get_id1('online_service.antrian_loket', $where)->result();
        // $data['content'] = 'penjaga';
        // $data['menu'] = 'menu';
        // $data['text_jalan'] = $this->M_crud->show('text_jalan', 'id_text DESC')->result();
        // var_dump($data);
        // die;
        $this->load->view('dashboard/loket_copy', $data);
    }

    // public function check_session_expiry()
    // {
    //     if ($this->session->userdata('loket') && (time() - $this->session->userdata('status') > $this->config->item('sess_expiration'))) {
    //         // Session has expired
    //         $this->logout();
    //     }
    // }
    // public function logout()
    // {
    //     // Reset user login status
    //     $this->session->unset_userdata('loket');
    //     // Perform any other logout tasks (e.g., destroying the session)
    //     $this->session->sess_destroy();
    //     // Redirect to the login page or any other appropriate page
    //     redirect('home/login');
    // }
}
