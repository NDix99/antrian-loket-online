<div class="container-fluid">
    <div class="row">
        <div class="d-flex justify-content-center">
            <div class="card mt-2">
                <div class="card-header">
                    <h4 class="fw-bold">Form Pendaftaran Pasien Baru</h4>
                </div>
                <div class="card-body">
                    <!-- all error on top -->
                    <?php if ($this->form_validation->run() === TRUE) : ?>
                        <div class="alert alert-warning" role="alert">
                            <?= form_error('registered', '<small class="text-danger">', '</small>') ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('registered')) : ?>
                        <div class="alert alert-warning">
                            <p class="fw-bold"><?= $this->session->flashdata('registered'); ?>
                                <br><a href="<?= base_url('home/cek_rm'); ?>">CEK NOMOR RM</a>
                            </p>
                        </div>
                    <?php endif; ?>

                    <!-- Alert -->
                    <?php if ($this->session->flashdata('regis_message')) : ?>
                        <div class="alert alert-success">
                            <?= $this->session->flashdata('regis_message') ?>
                            <?= $this->session->flashdata('new_px_norm'); ?>
                        </div>
                    <?php elseif ($this->session->flashdata('regis_fail_message')) : ?>
                        <div class="alert alert-danger">
                            <?= $this->session->flashdata('regis_fail_message') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('home/registrasi') ?>" method="post">
                        <div class="form-group pb-2">
                            <label for="nik" class="pb-1">Nomor Induk Kependudukan (NIK)</label>
                            <input type="text" class="form-control" id="nik" name="nik" value="<?= set_value('nik'); ?>">
                            <div class="form-text text-danger"><?= form_error('nik'); ?></div>
                        </div>
                        <div class="form-group pb-2">
                            <label for="name" class="pb-1">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= set_value('name'); ?>">
                            <div class="form-text text-danger"><?= form_error('name'); ?></div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group pb-2">
                                    <label for="birthdate" class="pb-1">Tanggal Lahir</label>
                                    <input type="date" class="form-control datepicker" name="birthdate" placeholder="dd/mm/yy" value="<?= set_value('birthdate'); ?>" onfocus="this.showPicker()">
                                    <div class="form-text text-danger"><?= form_error('birthdate'); ?></div>
                                </div>
                                <div class="form-group pb-2 col-4">
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Bulan</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group pb-2 d-block">
                                    <label for="sex" class="pb-1">Jenis Kelamin</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sex" id="sex1" value="L">
                                        <label class="form-check-label" for="sex1">
                                            Laki - laki
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sex" id="ex2" value="P">
                                        <label class="form-check-label" for="sex2">
                                            Perempuan
                                        </label>
                                    </div>
                                    <div class="form-text text-danger"><?= form_error('sex'); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group pb-2">
                            <label for="mother" class="pb-1">Nama Ibu Kandung</label>
                            <input type="text" class="form-control" id="mother" name="mother" value="<?= set_value('mother'); ?>">
                            <div class="form-text text-danger"><?= form_error('mother'); ?></div>
                        </div>
                        <div class="row">
                            <div class="form-group pb-2 col-8">
                                <label for="address" class="pb-1">Alamat</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?= set_value('address'); ?>">
                                <div class="form-text text-danger"><?= form_error('address'); ?></div>
                            </div>
                            <div class="form-group pb-2 col-4">
                                <label for="district" class="pb-1">Wilayah</label>
                                <input type="select" class="form-control" id="district" name="district" value="<?= set_value('district'); ?>">
                                <div class="form-text text-danger"><?= form_error('district'); ?></div>
                            </div>
                        </div>

                        <div class="form-group pb-2">
                            <label for="phone" class="pb-1">Nomor Handphone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= set_value('phone'); ?>">
                            <div class="form-text text-danger"><?= form_error('phone'); ?></div>
                        </div>
                        <a href="<?= base_url() ?>" name="cancel" class="btn btn-danger btn-md mt-4 float-start">Batal</a>
                        <button type="submit" name="registrasi" class="btn btn-primary btn-md mt-4 float-end">Daftar Sekarang</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>
</div>

<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd', // Set the date format as needed
            todayHighlight: true, // Highlight today's date
            autoclose: true, // Close the date picker when a date is selected
        });
    });
</script>