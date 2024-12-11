<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Page</title>
    <link rel="icon" href="<?= base_url('assets/img/list-ol.svg') ?>">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap 5 Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Bootstrap 5 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <!-- Datepicker -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
</head>

<body class="bg-success bg-opacity-10">
    <!-- navbar vertical -->
    <!-- @@include('partials/navbar-vertical.html', { "page": "dashboard", }) -->
    <!-- Page content -->
    <!-- @@include("partials/header.html") -->
    <header class="container-fluid">
        <nav class="navbar border px-4 bg-success rounded-2">

            <div class="col-sm-12 col-xs-12 text-center text-white">
                <h4 class="fw-bold"><?= $instansi->hsp_name; ?></h4>
                <div>
                    <small><?= $instansi->hsp_address . ", " . $instansi->city_name; ?> | </small>
                    <small>Phone: <?= $instansi->hsp_phone; ?> | </small>
                    <small>Email: <?= $instansi->hsp_email; ?></small>
                </div>
            </div>

            <div class="bg-white m-1" style="width: 100%; height: .5px;"></div>

            <div class="row w-100 mx-auto">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <a href="<?= site_url('admin') ?>" class="text-white text-decoration-none">
                        <i class="bi bi-house-door-fill pe-2"></i>
                        <span class="">
                            Dashboard Admin
                        </span>
                    </a>
                </div>
                <!-- Time -->
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="d-flex justify-content-between" style="z-index: 999;">

                        <div class="p-1 border border-light text-white rounded-2">
                            <i class="bi bi-clock ps-1 pe-2"></i>
                            <small class="align-items-center text-center pe-1" id="waktu-wib">
                                <?php
                                date_default_timezone_set('Asia/Jakarta'); // Set zona waktu ke WIB
                                ?>
                            </small>
                        </div>


                        <div class="justify-content-end">
                            <?php
                            // Check if the 'username' session variable is set
                            if (isset($_SESSION['username'])) {
                                // User is logged in, display logout button
                                echo '<a href="' . base_url('home/logout') . '" class="btn btn-sm btn-light p-2">Logout<i class="bi bi-box-arrow-right ps-2"></i></a>';
                            } else {
                                // User is not logged in, display login button
                                echo '<a href="' . base_url('home/login') . '" class="btn btn-sm btn-light p-2">Login<i class="bi bi-box-arrow-right ps-2"></i></a>';
                            }
                            ?>
                        </div>

                    </div>
                </div>
            </div>
            </div>
            </div>

        </nav>
    </header>