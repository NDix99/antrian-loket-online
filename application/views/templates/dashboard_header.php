<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Antrian</title>
    <link rel="icon" href="<?= base_url('assets/img/list-ol.svg') ?>">
    <!-- <script src="<?= base_url('assets/js/main.js') ?>"></script> -->
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Datepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Datatables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <!-- Html to -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.3/html2canvas.min.js"></script>
    <!-- <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script> -->
    <!-- Print JS -->
    <script src="https://printjs.crabbly.com/print.js"></script>
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

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
                    <a href="<?= site_url('dashboard/index') ?>" class="text-white text-decoration-none">
                        <i class="bi bi-house-door-fill pe-2"></i>
                        <span class="">
                            Dashboard Loket Pendaftaran
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