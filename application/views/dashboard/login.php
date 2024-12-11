<div class="container-fluid">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-8 col-xs-8">
            <div class="card m-4 border-success shadow-lg">
                <div class="card-header text-center bg-success text-white">
                    <h4 class="fw-bold">Login Admin</h4>
                </div>
                <div class="card-body p-4">
                    <?php
                    $userMessage = $this->session->flashdata('user_message');
                    if (isset($userMessage) && !empty($userMessage)) {
                        echo '<div class="alert alert-danger">' . $userMessage . '</div>';
                    }
                    ?>

                    <div class="p-4">
                        <form class="user" method="post" action="<?= base_url('home/validasi'); ?>">
                            <div class="form-group mb-4">
                                <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" value="<?= set_value('username') ?>">
                                <small class="text-danger">
                                    <?= form_error('username') ?>
                                </small>
                            </div>
                            <div class="form-group mb-4">
                                <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                <small class="text-danger">
                                    <?= form_error('password') ?>
                                </small>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-success btn-user btn-block px-4">
                                    Login<i class="bi bi-arrow-right-circle ps-2"></i>
                                </button>
                            </div>
                            <hr>
                        </form>

                    </div>
                </div>
                <div class="text-center mb-4 d-none">
                    <a href="<?= base_url('home/addUser') ?>" class="p-2">ADD USER</a>
                    <a href="<?= base_url('home/addLoket') ?>" class="p-2">ADD LOKET</a>
                </div>
            </div>

        </div>

    </div>
</div>