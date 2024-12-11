<div class="container-fluid">
    <!-- <div class="alert alert-success">
        <?= $this->session->flashdata('user_message'); ?>
    </div> -->
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-8 col-xs-8">
            <div class="card m-4 border-success shadow-lg">
                <div class="card-header text-center bg-success text-white">
                    <h4 class="fw-bold">Tambah User</h4>
                </div>
                <div class="card-body p-4">
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
                            <button type="submit" class="btn btn-primary pe-2" name="simpan_loket">Simpan</button>
                            <button type="reset" class="btn btn-danger">Reset</button>
                        </div>
                        <hr>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>