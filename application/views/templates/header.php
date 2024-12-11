<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="icon" href="<?= base_url('assets/img/list-ol.svg') ?>">
    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- <script src="<?= base_url('assets/js/main.js') ?>"></script> -->
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <!-- Datepicker -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <!-- Html to -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.3/html2canvas.min.js"></script>
    <!-- <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script> -->
    <!-- Print JS -->
    <!-- <script src="https://printjs.crabbly.com/print.js"></script> -->


</head>

<body class="bg-success bg-opacity-10">

    <header class="container-fluid">
        <nav class="navbar d-flex justify-content-between border px-4 bg-success rounded-2">
            <div class="col-sm-12 col-xs-12 text-center text-white">
                <h4 class="fw-bold"><?= $instansi->hsp_name; ?></h4>
                <div class="">
                    <small><?= $instansi->hsp_address . ", " . $instansi->city_name; ?> | </small>
                    <small>Phone: <?= $instansi->hsp_phone; ?> | </small>
                    <small>Email: <?= $instansi->hsp_email; ?></small>
                </div>
            </div>

            <div class="bg-white m-1" style="width: 100%; height: .5px;"></div>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="col-xs-12">
                            <div class="d-flex justify-content-start pb-1">
                                <a href="<?= base_url() ?>" class="text-white text-decoration-none">
                                    <span class="align-middle text-light">
                                        <i class="bi bi-house-door-fill pe-2"></i>Antrian Loket Pendaftaran
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Time -->
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="d-flex justify-content-end" style="z-index: 999;">
                            <div class="col-xs-12">
                                <div class="bg-light p-1 px-2 border border-success rounded-1">
                                    <i class="bi bi-clock pe-2"></i>
                                    <small class="align-items-center text-center" id="waktu-wib">
                                        <?php
                                        date_default_timezone_set('Asia/Jakarta'); // Set zona waktu ke WIB
                                        ?>
                                    </small>
                                </div>
                            </div>
                            <!-- <div class="col-xs-12"> -->
                            <!-- <div class="justify-content-end"> -->
                            <!-- <a href="<?= base_url('home/login') ?>" class="btn btn-sm btn-outline-light p-2">Login<i class="bi bi-box-arrow-right ps-2"></i></a> -->
                            <!-- </div> -->
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </div>
            </div>

        </nav>

        <!-- <div class="col-6 float-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $this->uri->segment(0); ?>">Home</a></li>
                    <li class="breadcrumb-item active"><?php echo ucfirst($this->uri->segment(2)); ?></li>
                </ol>
            </div> -->


    </header>