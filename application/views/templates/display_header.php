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

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->

    <!-- <script src="<?= base_url('assets/js/main.js') ?>"></script> -->
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Datepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.3/html2canvas.min.js"></script> -->
    <!-- <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script> -->
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
    <!-- Responsivevoice -->
    <!-- Get API Key -> https://responsivevoice.org/ -->
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=jQZ2zcdq"></script>
    <!-- Print JS -->
    <script src="https://printjs.crabbly.com/print.js"></script>


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
                    <!-- Time -->
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <div class="d-flex justify-content-center" style="z-index: 999;">
                            <div class="bg-light p-1 px-2 border border-success rounded-1">
                                <i class="bi bi-clock pe-2"></i>
                                <small class="align-items-center" id="waktu-wib">
                                    <?php
                                    date_default_timezone_set('Asia/Jakarta'); // Set zona waktu ke WIB
                                    ?>
                                </small>
                            </div>
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