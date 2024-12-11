<style>
    .btn-xs {
        padding: 0.25rem 0.5rem;
        /* Adjust padding */
        font-size: 0.75rem;
        /* Adjust font size */
        line-height: 1.5;
        /* Adjust line height */
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        font-size: 12px;
        /* Adjust the font size */
        padding: 3px 6px;
        /* Adjust the padding */
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        font-weight: bold;
        /* Optionally make the current page bold */
    }

    .dataTables_wrapper .dataTables_info {
        font-size: 10px;
        /* Adjust the font size */
    }

    tr {
        font-size: 12px;
    }
</style>
<div class="container-fluid">
    <div class="row justify-content-center bg-white mx-auto mt-2">
        <div class="col-12">
            <!-- Tabs -->
            <nav class="pt-4">
                <div class="nav nav-pills" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-index-tab" data-bs-toggle="tab" data-bs-target="#nav-index" type="button" role="tab" aria-controls="nav-index" aria-selected="true"><i class="bi bi-house pe-2"></i>Index</button>
                    <button class="nav-link" id="nav-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-settings" type="button" role="tab" aria-controls="nav-settings" aria-selected="true"><i class="bi bi-gear pe-2"></i>Settings</button>
                    <button class="nav-link" id="nav-users-tab" data-bs-toggle="tab" data-bs-target="#nav-users" type="button" role="tab" aria-controls="nav-users" aria-selected="true"><i class="bi bi-person pe-2"></i>Users</button>
                    <button class="nav-link" id="nav-data-antrian-tab" data-bs-toggle="tab" data-bs-target="#nav-data-antrian" type="button" role="tab" aria-controls="nav-data-antrian" aria-selected="false">Data Antrian</button>
                    <button class="nav-link" id="nav-display-tab" data-bs-toggle="tab" data-bs-target="#nav-display" type="button" role="tab" aria-controls="nav-display" aria-selected="false" disabled>Display Antrian</button>
                </div>
            </nav>
            <div class="row">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-index" role="tabpanel" aria-labelledby="nav-index-tab">
                        <div class="p-4">
                            <h4 class="fw-bold pb-2">Admin Page</h4>
                            <h6>Welcome, <i><?= $this->session->userdata('nama') ?></i> !</h6>
                            <p class="card-text">Pada halaman ini, admin dapat mengelola berbagai pengaturan dan konfigurasi untuk website Antrian Online RSUD Caruban. Mencakup fitur-fitur seperti : </p>
                            <ul>
                                <li>Mengaktifkan atau menonaktifkan fitur input di halaman utama</li>
                                <li>Menambah atau menghapus hari libur layanan dan informasi terkait</li>
                                <li>Mengubah pengaturan nomor antrian</li>
                                <li>Mengatur hak akses pengguna</li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-settings" role="tabpanel" aria-labelledby="nav-settings-tab">
                        <div class="row p-2">
                            <div class="col-md-6">
                                <fieldset class="border rounded-2 p-4">
                                    <legend>
                                        <h4 class="mb-2">Settings</h4>
                                    </legend>
                                    <!-- Button to trigger modal -->
                                    <button type="button" class="btn btn-sm btn-warning mb-3 me-2" data-bs-toggle="modal" data-bs-target="#editInfoModal">
                                        <i class="bi bi-info-circle pe-2"></i>Edit Info
                                    </button>
                                    <button type="button" class="btn btn-sm btn-warning mb-3 me-2" data-bs-toggle="modal" data-bs-target="#editLiburModal" id="editLiburBtn">
                                        <i class="bi bi-calendar-x-fill pe-2"></i>Edit Tanggal Libur
                                    </button>
                                    <button type="button" class="btn btn-sm btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#settingModal">
                                        <i class="bi bi-toggles pe-2"></i>On/Off Antrian
                                    </button>
                                    <div class="table table-striped table-responsive border border-dark p-2 rounded d-none">
                                        <table id="infoTable" class="" style="width: 100%;">
                                            <thead class="bg-success text-light">
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Header Pengumuman</th>
                                                    <th>Active</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </fieldset>

                                <!-- Modal Info -->
                                <form id="infoForm">
                                    <div class="modal fade" id="editInfoModal" tabindex="-1" aria-labelledby="editInfoModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editInfoModalLabel">Edit Info Homepage</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Form fields -->
                                                    <!-- <img src="<?= base_url('assets/img/info-antrian.png') ?>" alt="info-antrian" class="img-fluid mb-2"> -->

                                                    <div class="card bg-warning p-4 rounded-2 mb-3" id="infoEdit">
                                                        <div class="card-header bg-white text-center">
                                                            <h6 class="text-muted" id="contohTitle">(Judul) </h6>
                                                            <h5 class="fw-bold text-muted" id="contohHeader">(Header) </h5>
                                                            -<br>
                                                            <p id="contohBody">(Isi) </p>
                                                        </div>

                                                        <div class="card-footer text-center">
                                                            <small class="fst-italic" id="contohNotes">(Catatan) </small>
                                                        </div>
                                                    </div>

                                                    <div id="alertModalInfo"></div>
                                                    <div class="mb-2">
                                                        <label for="infoTitle" class="form-label">Judul Pengumuman</label>
                                                        <input type="text" class="form-control" id="infoTitle" name="info_title" value="Pelayanan Poliklinik Rawat Jalan" required>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="infoHeader" class="form-label">Header Pengumuman</label>
                                                        <input type="text" class="form-control" id="infoHeader" name="info_header" value="" required>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="infoBody" class="form-label">Isi Pengumuman</label>
                                                        <textarea class="form-control" id="infoBody" name="info_body" required></textarea>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="infoNotes" class="form-label">Catatan</label>
                                                        <input type="text" class="form-control" id="infoNotes" name="info_notes" value="Nomor Antrian dapat diambil kembali mulai tanggal " required>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="infoDate" class="form-label">Tanggal Dibuat</label>
                                                        <input class="form-control" id="infoDate" name="info_date" value="<?= date('d-m-Y') ?>" disabled></input>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-sm btn-primary" id="saveInfo">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- Modal Libur -->
                                <form id="liburForm">
                                    <div class="modal fade" id="editLiburModal" tabindex="-1" aria-labelledby="editLiburModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editLiburModalLabel">Edit Hari Libur</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="alertModalLibur"></div>
                                                    <div class="mb-3">
                                                        <label for="holidayDate" class="form-label">Tanggal Libur</label>
                                                        <input type="date" class="form-control" id="holidayDate" name="holiday_date" value="">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="holiday" class="form-label">Nama Hari Libur</label>
                                                        <input type="text" class="form-control" id="holiday" name="holiday" value="">
                                                    </div>
                                                    <div class="mb-3 float-end">
                                                        <button type="button" class="btn btn-sm btn-primary" id="saveLibur"><i class="bi bi-plus-square pe-2"></i>Tambah</button>
                                                    </div>
                                                    <div class="table table-striped table-responsive border border-dark p-2 rounded">
                                                        <table id="liburTable" class="" style="width: 100%;">
                                                            <thead class="bg-success text-light">
                                                                <tr>
                                                                    <!-- <th>No.</th> -->
                                                                    <th>Tanggal Libur</th>
                                                                    <th>Hari Libur</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                                <!-- Modal HomeSetting Switch -->
                                <form id="settingForm">
                                    <div class="modal fade" id="settingModal" tabindex="-1" aria-labelledby="settingModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editInfoModalLabel">Homepage Settings</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="alertModalHome"></div>
                                                    <div class="mb-3 form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="info" name="info_homepage">
                                                        <label class="form-check-label" for="info">Info / Pengumuman</label>
                                                    </div>
                                                    <div class="mb-3 form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="inputRm" name="input_norm">
                                                        <label class="form-check-label" for="inputRm">Input No RM</label>
                                                    </div>
                                                    <div class="mb-3 form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="btnDateVisit" name="btn_date_visit">
                                                        <label class="form-check-label" for="btnDateVisit">Tanggal Kunjungan</label>
                                                    </div>
                                                    <div class="mb-3 form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="btnAmbil" name="btn_ambil">
                                                        <label class="form-check-label" for="btnAmbil">Tombol Ambil Antrian</label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-sm btn-primary" id="saveHomeSetting"><i class="bi bi-floppy pe-2"></i>Save Settings</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded-2 p-4">
                                    <div class="d-flex justify-content-center">
                                        <h4 class="pe-4">Layout Nomor Antrian</h4>
                                        <button type="button" class="btn btn-sm btn-warning mb-3 me-2" data-bs-toggle="modal" data-bs-target="#editAntrian">
                                            <i class="bi bi-gear-fill pe-2"></i>Setting
                                        </button>
                                    </div>

                                    <div id="htmlContent" name="htmlContent">
                                        <div class="d-flex justify-content-center text-center">
                                            <div class="border border-2 border-dark col-6">
                                                <div class="text-center">
                                                    <small class="fw-bold text-muted" style="font-size: 8px;">- LOKET PENDAFTARAN RSUD CARUBAN -</small>
                                                    <h6 class="fw-bold">NOMOR ANTRIAN</h6>
                                                    <label style="font: bold 60px arial, sans-serif"><?= $no_antrian; ?></label>
                                                </div>
                                                <div class="container mb-2">
                                                    <div class="row" style="font-size: 10px;">
                                                        <div class="col-5" align="left">Nomor RM :</div>
                                                        <div class="col-7" align="right">12345678</div>
                                                    </div>
                                                    <div class="row" style="font-size: 10px;">
                                                        <div class="col-4" align="left">Nama :</div>
                                                        <div class="col-8" align="right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Nama Pasien</div>
                                                    </div>
                                                    <div class="row" style="font-size: 10px;">
                                                        <div class="col-6" align="left">Waktu Pelayanan :</div>
                                                        <div class="col-6 fw-bold" align="right">
                                                            <!-- 06:30 - 13:00 -->
                                                            <?= $waktu_pelayanan; ?>
                                                            <!-- 07:00 - Selesai -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mx-auto justify-content-center">
                                                    <div class="bg-dark" style="height: 2px; width: 80%"></div>
                                                    <small class="fw-bold pt-1" style="font-size: 8px;">Tanggal Kunjungan</small>
                                                    <h6 class="text-center fw-bold" style="font-size: 12px;"><?= date('d F Y') ?></h6>
                                                    <div class="bg-dark" style="height: 2px; width: 80%"></div>
                                                    <div class="text-center my-1 px-auto">
                                                        <p class="fst-italic" style="font-size: 8px;">Wajib hadir sesuai jam layanan yang tertera. <br>Apabila nomor anda terlewatkan, <br>dimohon menunggu 3 nomor berikutnya</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Edit Nomor Antrian -->
                            <form id="noAntrianForm">
                                <div class="modal fade" id="editAntrian" tabindex="-1" aria-labelledby="editAntrianModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editAntrianLabel">Edit Nomor Antrian</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="alertModalTiket"></div>
                                                <div class="mb-3">
                                                    <div class="col-12">
                                                        <label for="estimateTime" class="form-label">Estimasi Pelayanan Saat Ini : <span id="estimasi" class="fw-bold"><?= $estimasi; ?> / Jam</span></label>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="estimateTimeUpdate" class="form-label">Update Estimasi Waktu :</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="estimateTimeUpdate" name="estimate_time_update" placeholder="" value="">
                                                            <button class="btn btn-sm btn-outline-primary" type="button" id="saveTiket">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3 form-check form-switch d-none">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="estimateAuto" name="estimate_auto">
                                                    <label class="form-check-label" for="estimateAuto">Auto waktu pelayanan</label>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="estimateStart" class="form-label">Waktu Awal Pelayanan</label>
                                                    <input type="time" class="form-control" id="estimateStart" name="estimate_start" value="<?= $waktu_awal; ?>" disabled>
                                                </div>
                                                <div class="mb-3 d-none">
                                                    <label for="estimateEnd" class="form-label">Waktu Akhir Pelayanan</label>
                                                    <input type="time" class="form-control" id="estimateEnd" name="estimate_end" value="">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <!-- <button type="button" class="btn btn-sm btn-primary" id="saveTiket" data-bs-dismiss="modal"><i class="bi bi-floppy pe-2"></i>Save Settings</button> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-users" role="tabpanel" aria-labelledby="nav-users-tab">
                        <div class="row p-4">
                            <h4 class="fw-bold pb-2">User Loket</h4>
                            <div class="col-12">
                                <div class="float-end">
                                    <button type="button" class="btn btn-sm btn-warning mb-2 me-2" data-bs-toggle="modal" data-bs-target="#addLoketModal" disabled><i class="bi bi-person-workspace pe-2"></i>Tambah Loket</button>
                                    <button type="button" class="btn btn-sm btn-warning mb-2" data-bs-toggle="modal" data-bs-target="#addUserModal" disabled><i class="bi bi-person-plus-fill pe-2"></i>Tambah User</button>
                                </div>
                                <div class="table table-striped table-responsive border border-dark p-2 rounded">
                                    <h6 class="fw-bold">Tabel User</h6>
                                    <table id="userTable" class="" style="width: 100%;">
                                        <thead class="bg-success text-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama</th>
                                                <th>Nomor Loket</th>
                                                <th>Action</th>
                                                <!-- Tambahkan kolom lain sesuai kebutuhan -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data dari controller akan dimasukkan di sini oleh JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="">
                                <!-- Loket Table -->
                                <div class="table table-striped table-responsive border border-dark p-2 rounded d-none">
                                    <h6 class="fw-bold">Tabel Loket</h6>
                                    <table id="loketTable" class="" style="width: 100%;">
                                        <thead class="bg-success text-light">
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Loket</th>
                                                <th>Status Aktif</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Modal Loket -->
                            <div class="modal fade" id="addLoketModal" tabindex="-1" aria-labelledby="addLoketModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning text-white">
                                            <h4 class="modal-title fw-bold" id="addLoketModalLabel">Tambah Loket</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="<?= site_url('admin/add_loket'); ?>" enctype="multipart/form-data">
                                                <div class="form-group mb-4">
                                                    <label for="no_loket">Nomor Loket</label>
                                                    <select name="no_loket" id="no_loket" class="form-control">
                                                        <option value="">- Pilih Loket -</option>
                                                        <?php foreach ($lokets as $loket) : ?>
                                                            <option value="<?= $loket->no_loket; ?>"><?= $loket->no_loket; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label for="user_id">User Loket</label>
                                                    <select name="user_id" id="user_id" class="form-control">
                                                        <option value="0">- Pilih User -</option>
                                                        <?php foreach ($users as $user) : ?>
                                                            <option value="<?= $user->name; ?>"><?= $user->name; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-4">
                                                    <div class="form-check form-switch" id="checkboxContainer">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                                        <label class="form-check-label" for="flexSwitchCheckDefault">Status Loket Aktif</label>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center">
                                                    <button type="reset" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Reset</button>
                                                    <button type="submit" class="btn btn-sm btn-primary me-2" name="simpan_loket">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal User New -->
                            <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold" id="userModalLabel"><i class="bi bi-person-add pe-2"></i>Add New User</h5>
                                            <button type="button" class="btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="text" id="userId" disabled>
                                            <div class="mb-3">
                                                <label for="userName" class="form-label">Username</label>
                                                <input type="text" class="form-control form-control-sm" id="userName" name="username" placeholder="Username">
                                            </div>
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nama Lengkap</label>
                                                <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Nama Lengkap">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Password">
                                                <?= form_error('password', '<small class="text-danger">', '</small>') ?>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="password1" class="form-label">Konfirmasi Password</label>
                                                <input type="password" class="form-control form-control-sm" id="password1" name="password1" placeholder="Konfirmasi Password">
                                                <?= form_error('password1', '<small class="text-danger">', '</small>') ?>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="levelUser" class="form-label">User Level </label>
                                                <select name="level" class="form-control form-control-sm" id="levelUser" required>
                                                    <option class="text-muted">- Pilih User Level -</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="user_loket">User Loket</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-3" id="nomorLoket" style="display: none;">
                                                <label for="idLoket" class="form-label">Nomor Loket</label>
                                                <select name="id_loket" class="form-control form-control-sm" id="idLoket">
                                                    <option class="text-muted">- Pilih Nomor Loket -</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm  btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-sm  btn-primary" id="btnSave">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Confirm Modal -->
                            <div class="modal fade" id="confirmDeleteModal" tabindex="100" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete the user <span id="dataToDelete" class="fw-bold"></span>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="button" id="btnConfirmDelete" class="btn btn-danger">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal User -->
                            <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-center bg-success text-white">
                                            <h4 class="modal-title fw-bold" id="addUserModalLabel">Tambah User</h4>
                                        </div>
                                        <div class="modal-body p-4">
                                            <?= $this->session->flashdata('message'); ?>

                                            <form class="user" method="post" action="<?= base_url('admin/add_user'); ?>">
                                                <div class="form-group mb-4">
                                                    <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Nama" value="<?= set_value('name') ?>">
                                                    <?= form_error('name', '<small class="text-danger">', '</small>') ?>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" value="<?= set_value('username') ?>">
                                                    <?= form_error('username', '<small class="text-danger">', '</small>') ?>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                                    <?= form_error('password', '<small class="text-danger">', '</small>') ?>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Password">
                                                    <?= form_error('password1', '<small class="text-danger">', '</small>') ?>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label for="sel1">Level</label>
                                                    <select name="level" class="form-control" required="" onchange="cek1()" id="lev1">
                                                        <option value="">--Pilih Level--</option>
                                                        <option value="admin">Admin</option>
                                                        <option value="user_loket">User Loket</option>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label for="sel1" id="l1">Loket</label>
                                                    <select name="id_loket" class="form-control" id="id_loket1">
                                                        <option value="">--Pilih Loket--</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                    </select>
                                                </div>
                                                <div class="d-flex justify-content-center">
                                                    <button type="reset" class="btn btn-sm btn-danger me-2">Reset</button>
                                                    <button type="submit" class="btn btn-sm btn-primary pe-2" name="simpan_loket">Tambah</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-data-antrian" role="tabpanel" aria-labelledby="nav-data-antrian-tab" tabindex="0">
                        <div class="row p-4">
                            <h4 class="fw-bold pb-2">Data Antrian</h4>
                            <div>
                                <label for="filterDate">Tanggal Kunjungan: </label>
                                <input type="date" id="filterDate" value="">
                            </div>
                            <div class="col-12">
                                <div class="table table-striped table-responsive border border-dark p-2 rounded">
                                    <h6 class="fw-bold">Tabel Data Antrian</h6>
                                    <table id="antrianTable" class="" style="width: 100%;">
                                        <thead class="bg-success text-light">
                                            <tr>
                                                <th>No. Antrian</th>
                                                <th>No. RM</th>
                                                <th>Nama</th>
                                                <th>Tanggal Kunjungan</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-display" role="tabpanel" aria-labelledby="nav-display-tab" tabindex="0">Display Antrian</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#userModal').on('shown.bs.modal', function() {
        checkLevel(); // Call checkLevel() when the modal is shown
    });

    function checkLevel() {
        var levelUser = document.getElementById('levelUser');
        var nomorLoket = document.getElementById('nomorLoket');

        // Check if selected user level is 'user_loket'
        if (levelUser.value === 'user_loket') {
            // $('#nomorLoket').show();
            nomorLoket.style.display = 'block'; // Show nomor loket form group
        } else {
            // $('#nomorLoket').hide();
            nomorLoket.style.display = 'none'; // Hide nomor loket form group
        }
    }

    $(document).ready(function() {
        // Initialize DataTable on document ready
        var liburTable = $('#liburTable').DataTable({
            columns: [
                // {
                //     data: null,
                //     render: function(data, type, row, meta) {
                //         return meta.row + 1; // Display row number starting from 1
                //     }
                // },
                {
                    data: 'tgl_libur'
                },
                {
                    data: 'hari_libur'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // return '<button class="btn btn-xs btn-primary me-2 edit-libur" data-id="' + row.id + '" title="Edit"><i class="bi bi-pencil-square"></i></button>' +
                        return '<button class="btn btn-xs btn-danger delete-libur" data-id="' + row.id + '" title="Delete"><i class="bi bi-trash-fill"></i></button>';
                    }
                }
            ],
            order: [
                [0, 'asc']
            ] // Sort by the first column (tgl_libur) in ascending order
        });

        // Fetch and populate data in the DataTable
        $('#editLiburBtn').click(function() {
            $.ajax({
                url: "<?= base_url('admin/getLibur'); ?>",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    console.log('Response:', response);
                    // Clear existing rows and add new data to DataTable
                    liburTable.clear().rows.add(response).draw();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching user data:', error);
                }
            });
        });

        $('#liburTable').on('click', '.delete-libur', function(event) {
            event.preventDefault(); // Prevent default form submission behavior
            var table = $(this).closest('table').DataTable();
            var tglId = $(this).data("id");
            var tgl = $(this).closest("tr").find("td:eq(0)").text(); // Assuming the user's name is in the second column
            console.log("Delete user with ID:", tglId);

            // Use window.confirm to display a simple confirmation dialog
            var confirmDelete = window.confirm("Are you sure you want to delete tanggal '" + tgl + "'?");

            // If user confirms deletion
            if (confirmDelete) {
                $.ajax({
                    url: "<?= base_url('admin/deleteLibur'); ?>",
                    type: "DELETE",
                    contentType: "application/json",
                    data: JSON.stringify({
                        id: tglId
                    }),
                    success: function(response) {
                        console.log(response.message);
                        showAlert('success', 'Tanggal Libur berhasil dihapus!', 'alertModalLibur');
                        // Optionally, reload the table or update the row if needed
                        // table.ajax.reload();

                    },
                    error: function(xhr, status, error) {
                        console.error("Error deleting user:", error);
                        showAlert('danger', 'Tanggal Libur gagal dihapus!', 'alertModalLibur');
                    }
                });
            }
        });



        // Save Libur button click event
        $('#saveLibur').click(function() {
            // Serialize form data to JSON
            var formData = {
                'holiday_date': $('#holidayDate').val(),
                'holiday': $('#holiday').val(),
            };
            console.log('Form Data:', formData);
            // Send data to server
            $.ajax({
                url: '<?= base_url('admin/saveLibur') ?>',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function(response) {
                    // Handle success
                    console.log('Data saved successfully:', response);
                    showAlert('success', 'Tanggal Libur berhasil ditambahkan!', 'alertModalLibur');
                    // liburTable.ajax.reload();
                    $('#holidayDate').val('');
                    $('#holiday').val('');
                },
                error: function(error) {
                    // Handle error
                    console.error('Error saving data:', error);
                    showAlert('danger', 'Gagal menambahkan Tanggal Libur!', 'alertModalLibur');
                },
                complete: function() {
                    // liburTable.ajax.reload();
                }
            });
        });
    });


    $(document).ready(function() {
        $.ajax({
            url: '<?= base_url('admin/getInfo'); ?>',
            type: 'GET',
            dataType: 'json', // Assuming the response is in JSON format
            success: function(data) {
                $('#contohTitle').append(data.info_title);
                $('#contohHeader').append(data.info_header);
                $('#contohBody').append(data.info_body);
                $('#contohNotes').append(data.info_notes);
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ', status, error);
            }
        });
        $('#saveInfo').click(function() {

            if ($('#infoTitle').val() === '' || $('#infoHeader').val() === '' || $('#infoBody').val() === '' || $('#infoNotes').val() === '') {
                // Display an error message or handle empty fields as needed
                showAlert('danger', 'Isikan semua form pengumuman!', 'alertModalInfo');
                return; // Exit the function without sending the data
            }
            // Serialize form data to JSON
            var formData = {
                'info_title': $('#infoTitle').val(),
                'info_header': $('#infoHeader').val(),
                'info_body': $('#infoBody').val(),
                'info_notes': $('#infoNotes').val(),
                'info_date': $('#infoDate').val(),
            };
            console.log('Form Data:', formData);
            // Send data to server
            $.ajax({
                url: '<?= base_url('admin/saveInfo') ?>',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function(response) {
                    // Handle success
                    console.log('Data saved successfully:', response);
                    showAlert('success', 'Info berhasil ditambahkan!', 'alertModalInfo');
                    // $('#editInfoModal').modal('hide');
                },
                error: function(error) {
                    // Handle error
                    console.error('Error saving data:', error);
                    showAlert('danger', 'Gagal menambahkan Info!', 'alertModalInfo');
                    // $('#editInfoModal').modal('hide');
                },
                complete: function() {
                    // Remove loader or revert any UI changes
                }
            });
        });

        $('#saveTiket').click(function() {
            // Serialize form data to JSON
            // var formData = {
            //     'estimate_time_update': $('#estimateTimeUpdate').val(),
            //     'estimate_start': $('#estimateStart').val(),
            //     'estimate_end': $('#estimateEnd').val(),
            //     'estimate_auto': $('#estimateAuto').val(),
            // };
            // console.log('Form Data:', formData);
            var newEstimasi = $('#estimateTimeUpdate').val();
            // Send data to server
            $.ajax({
                url: '<?= base_url('admin/saveTiket') ?>',
                type: 'POST',
                contentType: 'application/json',
                // data: JSON.stringify(formData),
                data: JSON.stringify({
                    estimate_time_update: newEstimasi
                }),
                success: function(response) {
                    // Handle success
                    $('#estimasi').text(newEstimasi);
                    // console.log('Data saved successfully:', response);
                    showAlert('success', 'Estimasi berhasil diubah!', 'alertModalTiket');
                },
                error: function(error) {
                    // Handle error
                    // console.error('Error saving data:', error);
                    showAlert('danger', 'Gagal mengubah estimasi!', 'alertModalTiket');
                },
                complete: function() {
                    // Remove loader or revert any UI changes
                }
            });
        });
    });

    function showAlert(type, message, alertId) {
        // Create alert element
        var alert = $('<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
            message +
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
            '</div>');
        // Append alert to the alertModal element in the modal body
        $('#' + alertId).empty().append(alert);
        setTimeout(function() {
            alert.alert('close'); // Close the alert
        }, 5000);
    }

    // Home Setting
    $(document).ready(function() {
        // Fetch and update switch values on page load
        $.ajax({
            url: '<?= base_url('home/getSettings'); ?>',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // Update switches based on fetched data
                updateSwitches(data);
            },
            error: function(error) {
                console.error('Error fetching data:', error);
            }
        });

        // Function to update switches and handle save button click
        function updateSwitches(data) {
            // Update switches based on fetched data
            $('#inputRm').prop('checked', data.is_rm_enabled === 't');
            $('#btnDateVisit').prop('checked', data.is_datevisit_enabled === 't');
            $('#btnAmbil').prop('checked', data.is_btn_enabled === 't');
            $('#info').prop('checked', data.is_info_enabled === 't');
        }

        // Save button click handler
        $('#saveHomeSetting').click(function() {
            event.preventDefault();
            var formData = {
                'is_info_enabled': $('#info').prop('checked'),
                'is_rm_enabled': $('#inputRm').prop('checked'),
                'is_datevisit_enabled': $('#btnDateVisit').prop('checked'),
                'is_btn_enabled': $('#btnAmbil').prop('checked')
            };

            console.log('Sending Settings Data:', formData);

            // Send data to server
            $.ajax({
                url: '<?= base_url('admin/saveSettings') ?>',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function(response) {
                    // Handle success
                    console.log('Data saved successfully:', response);
                    showAlert('success', 'Pengaturan Homepage berhasil disimpan!', 'alertModalHome');
                },
                error: function(error) {
                    // Handle error
                    console.error('Error saving data:', error);
                    showAlert('danger', 'Gagal menyimpan Pengaturan Homepage!', 'alertModalHome');
                }
            });
        });
    });

    // Loket Table
    $(document).ready(function() {
        // Fetch data from the server-side endpoint
        $.ajax({
            url: "<?= base_url('admin/getLoket'); ?>",
            type: "GET",
            dataType: "json",
            success: function(response) {
                // Initialize DataTable with fetched data
                $('#loketTable').DataTable({
                    data: response,
                    columns: [{
                            data: "id_loket"
                        },
                        {
                            data: "no_loket"
                        },
                        {
                            data: "status"
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return '<button class="btn btn-sm btn-primary me-2 btn-edit" data-id="' + row.id_loket + '"><i class="bi bi-pencil-square"></i></button>' +
                                    '<button class="btn btn-sm btn-danger btn-delete" data-id="' + row.id_loket + '"><i class="bi bi-trash-fill"></i></button>';
                            }
                        }
                    ]
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching user data:', error);
            }
        });
    });

    // User Table
    $(document).ready(function() {
        // Fetch data from the server-side endpoint
        $.ajax({
            url: "<?= base_url('admin/getUser'); ?>",
            type: "GET",
            dataType: "json",
            success: function(response) {
                // Initialize DataTable with fetched data
                $('#userTable').DataTable({
                    data: response,
                    columns: [{
                            data: null,
                            render: function(data, type, row, meta) {
                                // Use meta.row to get the index of the row in the current page and add 1
                                return meta.row + 1;
                            }
                        },
                        {
                            data: "name"
                        },
                        {
                            data: "id_loket"
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return '<button class="btn btn-sm btn-primary me-2 btn-edit" data-id="' + row.id_user + '" disabled><i class="bi bi-pencil-square"></i></button>' +
                                    '<button class="btn btn-sm btn-danger btn-delete" data-id="' + row.id_user + '" disabled><i class="bi bi-trash-fill"></i></button>';
                            }
                        }
                    ]
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching user data:', error);
            }
        });
    });


    // Edit button click event handler
    $(document).on("click", ".btn-edit", function() {
        var userId = $(this).data("id");
        // var loketId = $(this).data("id");
        var tableId = $(this).closest('table').attr('id');

        // Check which table the button belongs to and open the corresponding modal
        if (tableId === 'userTable') {
            console.log("Edit user with ID:", userId, tableId);
            // $('#userModal').modal('show');

            // AJAX request to fetch user data by ID
            $.ajax({
                url: "<?= base_url('admin/getUser'); ?>/" + userId,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    // Populate modal with user data
                    $('#userId').text(response.id_user);
                    $('#userName').val(response.user_name);
                    $('#name').val(response.name);
                    $('#levelUser').val(response.level);
                    $('#idLoket').val(response.id_loket);

                    // Show edit modal
                    $('#userModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching user data:", error);
                }
            });
        } else if (tableId === 'loketTable') {
            console.log("Edit loket with ID:", loketId);
            $('#addLoketModal').modal('show');

            // AJAX request to fetch loket data by ID
            $.ajax({
                url: "<?= base_url('admin/getLoketById'); ?>/" + loketId,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    // Populate modal with loket data
                    $('#editLoketId').val(response.id_loket);
                    $('#editLoketNo').val(response.no_loket);
                    $('#editLoketStatus').val(response.status);

                    // Show edit modal
                    $('#editLoketModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching loket data:", error);
                }
            });
        }
    });

    // Save changes button click event handler
    $("#btnSaveEdit").on("click", function() {
        var userId = $('#editUserId').val();
        var userName = $('#editUserName').val();
        var userLoket = $('#editUserLoket').val();

        // Perform validation if needed

        // AJAX request to update user data
        $.ajax({
            url: "<?= base_url('admin/updateUser'); ?>",
            type: "POST",
            data: {
                userId: userId,
                userName: userName,
                userLoket: userLoket
            },
            dataType: "json",
            success: function(response) {
                // Handle success response
                console.log("User data updated successfully:", response);
                // Optionally, close the modal
                $('#editUserModal').modal('hide');
                // Reload the table or update the row if needed
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error("Error updating user data:", error);
            }
        });
    });

    // Delete button click event handler
    $(document).on("click", ".btn-delete", function() {
        var table = $(this).closest('table').DataTable();
        var userId = $(this).data("id");
        var name = $(this).closest("tr").find("td:eq(1)").text(); // Assuming the user's name is in the second column
        var tableId = $(this).closest('table').attr('id');
        var url = (tableId === 'userTable') ? '<?= base_url('admin/deleteUser'); ?>' : '<?= base_url('admin/deleteLibur'); ?>';
        // Set the user's name in the modal body
        $("#dataToDelete").text(name);
        // Implement delete functionality, e.g., show confirmation modal
        console.log("Delete user with ID:", userId);
        $('#confirmDeleteModal').modal('show');
        // When confirm delete button is clicked
        $('#btnConfirmDelete').click(function() {
            // Perform AJAX request to delete user
            $.ajax({
                url: url,
                type: "DELETE",
                contentType: "application/json",
                data: JSON.stringify({
                    userId: userId
                }),
                success: function(response) {
                    // Check if deletion was successful
                    if (response.success) {
                        console.log(response.message);
                        // Optionally, reload the table or update the row if needed
                        table.ajax.reload();
                    } else {
                        console.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error deleting user:", error);
                },
                complete: function() {
                    // Hide the confirmation modal regardless of the result
                    $('#confirmDeleteModal').modal('hide');
                }
            });
        });
    });



    // Function to open modal for adding a new user
    function openAddUserModal() {
        $('#userModalLabel').text('Add New User');
        $('#userId').val('');
        $('#userName').val('');
        $('#userLoket').val('');
        $('#userModal').modal('show');
    }

    // Function to open modal for editing an existing user
    function openEditUserModal(userId, userName, userLoket) {
        $('#userModalLabel').text('Edit User');
        $('#userId').val(userId);
        $('#userName').val(userName);
        $('#userLoket').val(userLoket);
        $('#userModal').modal('show');
    }

    // Data Antrian
    $(document).ready(function() {
        // Initialize DataTable without data initially
        var dataTable = $('#antrianTable').DataTable({
            columns: [{
                    data: "no_antrian"
                },
                {
                    data: "no_rm"
                },
                {
                    data: "name"
                },
                {
                    data: "date_visit"
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return '<button class="btn btn-sm btn-primary me-2 btn-edit" data-id="' + row.no_rm + '" disabled><i class="bi bi-pencil-square"></i></button>' +
                            '<button class="btn btn-sm btn-danger btn-delete" data-id="' + row.no_rm + '" disabled><i class="bi bi-trash-fill"></i></button>';
                    }
                }
            ],
            columnDefs: [{
                    targets: [0, 1, 3, 4],
                    className: 'text-center'
                },
                {
                    targets: 0,
                    width: '3%'
                },
                {
                    targets: 1,
                    width: '7%'
                },
                {
                    targets: 2,
                    width: '70%'
                },
                {
                    targets: 3,
                    width: '10%'
                },
                {
                    targets: 4,
                    width: '20%'
                }
            ]
        });

        // Function to fetch data based on the selected date
        function fetchData(date) {
            $.ajax({
                url: "<?= base_url('admin/getDataAntrian'); ?>",
                type: "GET",
                data: {
                    date_visit: date
                },
                dataType: "json",
                success: function(response) {
                    // Clear the DataTable before adding new data
                    dataTable.clear().draw();
                    // Update DataTable with fetched data
                    dataTable.rows.add(response).draw();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching user data:', error);
                }
            });
        }

        // Fetch data for today's date on initial load
        fetchData($('#filterDate').val());

        // Fetch data when the date input changes
        $('#filterDate').on('change', function() {
            fetchData($(this).val());
        });
    });
</script>