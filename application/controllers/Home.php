<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // header('Cache-Control: no-cache, must-revalidate, max-age=0');
        // header('Cache-Control: post-check=0, pre-check=0', false);
        // header('Pragma: no-cache');
        // $this->load->database('db_live');
        $this->load->library('form_validation');
        $this->load->model('M_crud');
        $this->load->model('Antrian_model');
    }
    public function index()
    {
        // Load the form validation library and set validation rules
        $this->form_validation->set_rules('norm', 'NoRM', 'trim|required|min_length[8]|max_length[8]', [
            'required' => 'Isikan nomor rekam medis!',
            'min_length' => 'Nomor RM harus terdiri dari 8 karakter!',
            'max_length' => 'Nomor RM harus terdiri dari 8 karakter!',
        ]);

        $this->form_validation->set_rules('date_visit', 'Date Visit', 'required', [
            'required' => 'Isikan tanggal lahir anda'
        ]);

        $data['title'] = 'Antrian Loket Pendaftaran RSUD Caruban';
        $data['instansi'] = $this->M_crud->show('admin.profil', 'hsp_code')->row();
        $data['info'] = $this->M_crud->get_info();

        // die(var_export($data['info']));

        if ($this->form_validation->run() == false) {
            // Form validation failed
            $this->load->view('templates/header', $data);
            $this->load->view('home/index', $data);
            $this->load->view('templates/footer');
        } else {
            // Form validation passed

            // Get the 'norm' value from the form input
            $norm = $this->input->post('norm');

            // Validate the 'norm' parameter from the URL
            if ($norm === NULL) {
                // If 'norm' is not provided in the URL, handle the error or redirect to an error page.
                $this->session->set_flashdata('alert_message', 'Pastikan nomor RM Anda benar.');
                redirect('home');
                // Consider redirecting to an appropriate error page or showing a message.
            }

            // Continue with processing

            // 'norm' value is available here, and you can use it as needed.
            // For example, you can pass it to a view or use it for database queries.

            $data['norm'] = $norm;
            $data['totalAntrian'] = '';

            // Load your 'antrian' view and pass the 'norm' value to it
            $this->load->view('templates/header', $data);
            $this->load->view('home/index', $data);
            $this->load->view('templates/footer');
        }
    }


    public function loginUser()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required', [
            'required' => 'Username harus diisi',
        ]);
        $this->form_validation->set_rules('password', 'Password', 'trim|required', [
            'required' => 'Password harus diisi',
        ]);
        // jika input form gagal
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Admin';
            $this->load->view('dashboard', $data);
            $this->load->view('templates/footer');
        } else {
            // Validation input success
            $this->login();
        }
    }
    private function _login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $data_user = $this->User_model->getUser($username, $password); // Ambil kata sandi yang dimasukkan oleh pengguna
        // $admin = $this->User_model->get_user_by_username($username);
        // $admin = $this->db->get_where('admin.ms_user', ['user_name' => $username])->row_array(); // Gantilah ini sesuai dengan cara Anda mendapatkan data pengguna
        if (password_verify($password, $data_user['user_password'])) {
            // Kata sandi benar, simpan data ke dalam session
            $data = [
                'username' => $data_user['admin.ms_user.user_name'],
                'person_name' => $data_user['admin.ms_user.person_name']
            ];
            $this->session->set_userdata($data);
            // Arahkan pengguna ke halaman dashboard
            redirect('dashboard');
        } else {
            // Kata sandi salah
            // $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password anda salah</div>');
            redirect('dashboard/login');
        }
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

        // $this->session->sess_destroy();
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
            redirect('home/login/');
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
                        redirect('home/login');
                    }
                }
            } else {
                $this->session->set_flashdata("user_message", "Password tidak sesuai");
                redirect('home/login');
            }
            $this->session->set_flashdata("user_message", "Username tidak ditemukan");
            redirect('home/login');
        }
    }

    public function validasi1()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required', [
            'required' => 'Username harus diisi',
        ]);
        $this->form_validation->set_rules('password', 'Password', 'trim|required', [
            'required' => 'Password harus diisi',
        ]);

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('user_message', validation_errors());
            redirect('home/login/');
            $this->session->sess_destroy();
        } else {
            $user = $this->input->post('username');
            $pass = sha1(md5($this->input->post('password')));
            $cek = $this->M_crud->get_id1('online_service.user_loket', array('user_name' => $user));
            if ($cek->num_rows() > 0) {
                if ($cek->row('user_password') == $pass) {
                    // Cek id_loket user
                    $cek1 = $this->M_crud->get_id1('online_service.loket', array('id_loket' => $cek->row('id_loket')));
                    if ($cek1->row('status') == 1) {
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
                        $this->session->set_flashdata("pesan", "<br><div class='alert alert-success'>
	              		 <p class='text-danger'>Selamat datang <b>" . $this->session->userdata('name') . "</b></p></div>");
                        if ($this->session->userdata('level') == 'admin') {
                            redirect('dashboard/index');
                        } else {
                            $this->M_crud->edit1('online_service.loket', array('status' => 1), array('id_loket' => $cek->row('id_loket')));
                            redirect('dashboard/loket');
                        }
                    }
                } else {
                    $this->session->set_flashdata("pesan", "<div class='alert alert-danger'>
              		 <p class='text-danger'>Password tidak sesuai</p></div>");
                    redirect('home/login');
                }
            } else {
                $this->session->set_flashdata("pesan", "<div class='alert alert-danger'>
               <p class='text-danger'>Username tidak ditemukan</p></div>");
                redirect('home/login');
            }
        }
    }

    public function loginValidation()
    {
        $user = $this->input->post('username');
        $pass = sha1(md5($this->input->post('password')));
        $cek = $this->M_crud->get_id1('online_service.user_loket', array('user_name' => $user));

        if ($cek->num_rows() > 0 && $cek->row('user_password') == $pass) {
            // Check if the session has expired
            if ($this->isSessionExpired()) {
                $this->loginReset($cek->row('id_loket'));
            } else {
                $this->loginSuccess($cek);
            }
        } else {
            $this->session->set_flashdata("pesan", "<div class='alert alert-danger'>
            <p class='text-danger'>Login failed. Please check your username and password.</p></div>");
            redirect('home/login');
        }
    }

    private function isSessionExpired()
    {
        // Set the session expiration time (e.g., 30 minutes)
        $session_expiration_time = 30 * 60; // 30 minutes in seconds

        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_expiration_time)) {
            // Session has expired
            return true;
        } else {
            // Update the last activity time
            $_SESSION['last_activity'] = time();
            return false;
        }
    }

    private function loginReset($loketId)
    {
        // Reset status to default (0)
        $this->M_crud->edit1('online_service.loket', array('status' => 0), array('id_loket' => $loketId));
        $this->session->set_flashdata("pesan", "<div class='alert alert-danger'>
        <p class='text-danger'>Your session has expired. Please log in again.</p></div>");
        redirect('home/login');
    }

    private function loginSuccess($user)
    {
        $cek1 = $this->M_crud->get_id1('online_service.loket', array('id_loket' => $user->row('id_loket')));

        if ($cek1->row('status') == 1) {
            echo "<br><center><h1><div class='alert alert-danger'>
	       <p class='text-danger'>Status loket anda sedang digunakan</b></p></div></h1>
	       <a href='" . site_url('home/login') . "'>Kembali</a>
	       </center>";
        } else {
            $session = array(
                'username' => $user->row('user_name'),
                'nama' => $user->row('name'),
                'level' => $user->row('level'),
                'loket' => $user->row('id_loket')
            );
            $this->session->set_userdata($session);
            $this->session->set_flashdata("pesan", "<div class='alert alert-success'>
            <p class='text-success'>Selamat datang <b>" . $this->session->userdata('nama') . "</b></p></div>");

            if ($this->session->userdata('level') == 'admin') {
                redirect('dashboard/index');
            } else {
                $this->M_crud->edit1('online_service.loket', array('status' => 1), array('id_loket' => $user->row('id_loket')));
                redirect('dashboard/index');
            }
        }
    }

    public function logout1()
    {
        $this->load->model('M_crud');
        if ($this->session->userdata('level') == 'user_loket') {
            $loket_id = $this->session->userdata('id_loket');
            $this->M_crud->edit1('online_service.loket', ['status' => 0], ['id_loket' => $loket_id]);
        }

        $this->session->sess_destroy();
        redirect('home');
    }

    public function logout()
    {
        if ($this->session->userdata('level') == 'user_loket') {

            $this->M_crud->edit1('online_service.loket', array('status' => 0), array('id_loket' => $this->session->userdata('loket')));
        }
        $this->session->sess_destroy();
        redirect('home/login');
    }

    public function cek_rm()
    {
        // Cek Validasi Input
        $data['instansi'] = $this->M_crud->show('admin.profil', 'hsp_code')->row();
        $this->form_validation->set_rules('nik', 'NIK', 'trim|integer|required|min_length[16]|max_length[16]', [
            'integer' => 'Isikan NIK Anda dengan benar',
            'required' => 'Isikan NIK Anda',
            'min_length' => 'Nomor NIK tidak sesuai',
            'max_length' => 'Nomor NIK tidak sesuai'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Cek Nomor RM';
            $this->load->view('templates/header', $data);
            $this->load->view('home/cek_rm', $data);
            $this->load->view('templates/footer');
        } else {
            // Validation Success | Cek Pasien
            $this->load->model('Pasien_model');
            $nik = $this->input->post('nik');
            $pasien = $this->Pasien_model->getPasienByNik($nik);
            if (!empty($pasien)) {
                // Data pasien ditemukan, akses data pasien
                $data['title'] = 'Cek Nomor RM';
                $data['norm'] = $pasien['px_norm'];
                $data['name'] = $pasien['px_name'];
            } else {
                // Data pasien tidak ditemukan
                $this->session->set_flashdata('data_message', 'Data pasien tidak ditemukan atau belum terdaftar.');
                redirect('home/cek_rm');
            }
            $this->load->view('templates/header', $data);
            $this->load->view('home/cek_rm', $data);
            $this->load->view('templates/footer');
        }
    }

    public function registrasi()
    {
        $this->load->model('M_crud');
        // Set up form validation rules
        $nik = $this->input->post('nik');
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|integer|min_length[16]', [
            // $this->form_validation->set_rules('nik', 'NIK', 'required|trim|integer|min_length[16]|matches[px_noktp]', [
            'required' => 'NIK wajib diisi',
            'integer' => 'NIK wajib berisi angka',
            'min_length' => 'NIK tidak sesuai!',
            // 'matches' => " NIK anda sudah terdaftar"
        ]);
        $this->form_validation->set_rules('name', 'Nama', 'required|trim|alpha', [
            'required' => 'Nama wajib diisi',
            'alpha' => 'Isikan nama anda dengan benar'
        ]);
        $this->form_validation->set_rules('phone', 'No Hp', 'required|trim|integer|max_length[13]', [
            'required' => 'Nomor hp wajib diisi',
            'integer' => 'Nomor hp wajib berisi angka',
            'max_length' => 'Masukkan nomor hp yang benar',
        ]);
        $this->form_validation->set_rules('sex', 'Jenis Kelamin', 'required', [
            'required' => 'Pilih jenis kelamin'
        ]);
        $this->form_validation->set_rules('birthdate', 'Tanggal Lahir', 'required', [
            'required' => 'Isikan tanggal lahir anda'
        ]);
        $this->form_validation->set_rules('mother', 'Nama Ibu', 'required', [
            'required' => 'isikan nama ibu kandung anda'
        ]);
        $this->form_validation->set_rules('address', 'Alamat', 'required', [
            'required' => 'Isikan alamat tempat tinggal anda '
        ]);
        $this->form_validation->set_rules('district', 'Kota', 'required', [
            'required' => 'Isikan kode kota anda'
        ]);
        // $this->form_validation->set_rules('reg', 'Registrasi', 'required');

        if ($this->form_validation->run() == false) {
            // Validasi gagal, tampilkan kembali form dengan pesan error
            $data['title'] = 'Pendaftaran Pasien Baru';
            $data['instansi'] = $this->M_crud->show('admin.profil', 'hsp_code')->row();
            $this->load->view('templates/header', $data);
            $this->load->view('home/registrasi');
            $this->load->view('templates/footer');
        } else {
            // Validasi sukses, cek nik = px_noktp
            $this->load->model('Pasien_model');
            $nik = $this->input->post('nik');
            $pasien = $this->Pasien_model->getPasienByNik($nik);

            // Jika pasien ada
            if (!empty($pasien)) {
                // Data pasien ditemukan, akses data pasien
                $data['title'] = 'Pendaftaran Pasien Baru';
                $data['instansi'] = $this->M_crud->show('admin.profil', 'hsp_code')->row();
                $data['no_rm'] = $pasien['px_norm'];
                $data['name'] = $pasien['px_name'];
                $data['birthdate'] = $pasien['px_birthdate'];
                $data['address'] = $pasien['px_address'];
                $registered = "Anda sudah terdaftar dengan Nomor Rekam Medis " . $data['no_rm'];
                $this->session->set_flashdata('registered', $registered);
                $this->load->view('templates/header', $data);
                $this->load->view('home/registrasi', $data);
                $this->load->view('templates/footer');
            } else {
                // Data pasien tidak ditemukan, insert data
                // Validasi sukses, simpan data pasien ke database
                $data = [
                    'px_noktp' => $this->input->post('nik', true),
                    'px_name' => htmlspecialchars($this->input->post('name', true)),
                    'px_birthdate' => $this->input->post('birthdate'),
                    'px_sex' => $this->input->post('sex'),
                    'px_address' => $this->input->post('address'),
                    'px_mother' => $this->input->post('mother'),
                    'px_phone' => $this->input->post('phone', true),
                    'px_district' => $this->input->post('district'),
                    'px_reg' => date('Y-m-d H:i:s')
                ];

                $this->db->insert('yanmed.patient', $data);
                if ($this->db->affected_rows() > 0) {
                    // Insert operation successful, set success flash data
                    $new_px_norm = $this->db->insert_id();
                    $data['new_px_norm'] = $new_px_norm;
                    $data['title'] = 'Pendaftaran Pasien Baru';
                    $data['instansi'] = $this->M_crud->show('admin.profil', 'hsp_code')->row();
                    $this->session->set_flashdata('regis_message', '<div class="alert alert-success" role="alert">Selamat! Anda sudah terdaftar </div>');
                    redirect('home/registrasi', $data);
                } else {
                    // Insert operation failed, set error flash data
                    $this->session->set_flashdata('regis_fail_message', '<div class="alert alert-danger" role="alert">Pendaftaran gagal</div>');
                    redirect('home/registrasi');
                }
            }
        }
    }



    public function call()
    {
        $currentDate = date('Y-m-d');

        // Panggil nomor antrian menggunakan model
        $nomor_antrian = $this->Antrian_model->getLatestAntrian($currentDate);
        $nomor_loket = $this->Antrian_model->getLatestLoket($currentDate);

        // Kirim nomor antrian ke tampilan menggunakan AJAX
        // $data['nomor_antrian'] = $nomor_antrian;
        // $data['nomor_loket'] = $nomor_loket;
        // echo json_encode($data);
        $this->output->set_content_type('application/json')->set_output(json_encode(['nomor_antrian' => $nomor_antrian]));
    }

    public function callAudio()
    {
        $audioId = $this->input->post('audioId');
        $delay = $this->input->post('delay');

        // Logika pemutaran audio sesuai dengan audioId dan delay

        // Misalnya, jika menggunakan JavaScript untuk pemutaran audio di halaman display
        $script = "<script>
                    setTimeout(function() {
                        var audio = document.getElementById('$audioId');
                        audio.pause();
                        audio.currentTime = 0;
                        audio.play();
                    }, $delay);
                   </script>";

        echo $script;
    }
    public function recall()
    {
        // $currentDate = date('Y-m-d');

        // // Ambil nomor antrian dan nomor loket dari model atau sumber data lainnya
        // // $inputAntrian = $this->input->post('input_panggil');
        // $inputAntrian = file_get_contents("php://input");
        // $loket = $this->Antrian_model->getLatestLoket($currentDate);

        // // Tetapkan nilai default jika data kosong
        // // $nomorAntrian = $latestAntrian->latest_no_antrian;
        // $nomorLoket = $loket->id_loket;

        // // Kembalikan data dalam format JSON
        // echo json_encode(['nomor_antrian' => $inputAntrian, 'id_loket' => $nomorLoket]);

        // Get form data
        $inputPanggil = $this->input->post('input_panggil');

        // Set data to session
        $this->session->set_userdata('input_panggil', $inputPanggil);
        // var_dump($inputPanggil);
        // die;

        // Redirect to the update_antrian method in the home controller
        redirect('home/update_display');
    }
    public function update_display()
    {
        $currentDate = date('Y-m-d');
        // var_dump($recallData);
        // die;
        $recallData = $this->session->userdata('input_panggil');
        $loket = $this->Antrian_model->getLatestLoket($currentDate);

        // Check if the data exists
        if ($recallData) {
            $nomorAntrian = $recallData;
            $nomorLoket = $loket->id_loket;

            echo json_encode(['nomor_antrian' => $nomorAntrian, 'id_loket' => $nomorLoket]);
        } else {
            $this->session->unset_userdata('input_panggil');
            $latestAntrian = $this->Antrian_model->getLatestAntrian($currentDate);
            $loket = $this->Antrian_model->getLatestLoket($currentDate);

            $nomorAntrian = $latestAntrian->latest_no_antrian;
            $nomorLoket = $loket->id_loket;

            echo json_encode(['nomor_antrian' => $nomorAntrian, 'id_loket' => $nomorLoket]);
        }

        // Your code here
    }
    public function display()
    {
        $currentDate = date('Y-m-d');
        $instansi = $this->M_crud->show('admin.profil', 'hsp_code')->row();
        $latestAntrian = $this->Antrian_model->getLatestAntrian($currentDate);
        $antrian = isset($_POST['nomor_antrian']) ? $_POST['nomor_antrian'] : '';
        $loket = isset($_POST['id_loket']) ? $_POST['id_loket'] : '';
        $data = [
            'title' => 'Display Nomor Antrian Loket Pendaftaran',
            'instansi' => $instansi,
            'antrian' => $antrian,
            'loket' => $loket
        ];
        // echo json_encode(['antrianNo' => $antrianNow]);

        $this->load->view('templates/display_header', $data);
        $this->load->view('home/display', $data);
        $this->load->view('templates/display_footer');
    }

    public function load_display()
    {
        // Retrieve JSON data from the POST request


        // Access values from the JSON data
        // $nomorAntrian = $data['nomor_antrian'];
        // $idLoket = $data['id_loket'];

        // // Perform any necessary processing with $nomorAntrian and $idLoket

        // // Return a JSON response if needed
        // $response = array(
        //     'status' => 'success',
        //     'message' => 'Data received and processed successfully.',
        // );

        // header('Content-Type: application/json');
        // echo json_encode($response);
    }

    // In your controller or route handler
    public function triggerAudio()
    {
        $currentDate = date('Y-m-d');
        $antrianNow = $this->Antrian_model->countAntrianNow();
        $latestAntrian = $this->Antrian_model->getLatestAntrian($currentDate);
        $latestLoket = $this->Antrian_model->getLatestLoket($currentDate);
        $data = [
            'loket'  => $latestLoket,
            'latestAntrian' => $latestAntrian,
            'antrian' => $antrianNow,
        ];
        // Perform any logic needed to trigger audio for the current user
        // ...

        // Return a response if needed
        echo json_encode(['data_antrian' => $data]);
        exit;
    }

    public function getSettings()
    {
        // Handle preflight requests
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('Access-Control-Allow-Origin: *'); // Allow all origins
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS'); // Allowed methods
            header('Access-Control-Allow-Headers: Content-Type'); // Allowed headers
            exit; // End the request here
        }

        // Set CORS headers for actual request
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        $data = $this->M_crud->get_settings();
        // var_dump($data);
        echo json_encode($data);
    }

    public function getLibur()
    {
        $data = $this->M_crud->get_libur();
        // var_dump($data);
        echo json_encode($data);
    }
}
