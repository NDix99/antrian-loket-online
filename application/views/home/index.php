<div class="row mx-2 bg-light">
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 p-2">
        <!-- S&K -->
        <div class="card p-4 border">
            <h4 class="mb-3 fw-bold text-decoration-underline">Syarat & Ketentuan</h4>
            <ol>
                <li class="mb-2">Nomor pendaftaran online hanya berlaku untuk pasien yang sudah mempunyai Nomor Rekam Medis di RSUD Caruban.</li>
                <!-- <li class="mb-2">Nomor pendaftaran online hanya berlaku untuk pasien yang sudah mempunyai Nomor Rekam Medis di RSUD Caruban, tidak berlaku bagi pasien rawat jalan IGD kecuali pasien umum.</li> -->
                <li class="mb-2">Bagi Pasien yang lupa Nomor Rekam Medis, silahkan melakukan pengecekan dengan <b>NIK</b> melalui menu yang tersedia dan melalui tautan berikut. <a href="<?= site_url(); ?>home/cek_rm" class="fw-bold fts-italic">CEK NOMOR REKAM MEDIS</a></li>
                <li class="mb-2">Bagi pasien baru / belum memiliki Nomor Rekam Medis di RSUD Caruban diharapkan melakukan pendaftaran di tempat.<br><a href="<?= site_url(); ?>home/registrasi" class="fw-bold fts-italic d-none">PENDAFTARAN DATA PASIEN</a></li>
                <li class="mb-2">Pengambilan nomor antrian dibuka setiap hari, selain hari libur mulai dari <b>H-2</b> sebelum tanggal kunjungan.<br></li>
                <!-- <p>Pengambilan nomor antrian pada hari H, diatas pukul <b>12.00 WIB</b> akan mendapatkan nomor antrian untuk hari berikutnya.</p> -->
                <!-- <li class="mb-2">Pengambilan nomor antrian hanya berlaku untuk <b>1 Nomor Rekam Medis</b>, dalam kurun waktu <b>1 Kali Kunjungan</b>.</li> -->
                <!-- <p>ditutup pada hari kunjungan pada pukul <b>12.00 WIB</b>, Jum'at pada pukul <b>11.00 WIB.</b></p>                    -->
                <!-- <li class="mb-2">Apabila nomor antrian sudah dicetak, klik tombol simpan atau gunakan fitur screenshot pada handphone anda sebagai bukti nomor antrian yang berlaku sesuai tanggal kunjungan yang tertera.</li> -->
                <li class="mb-2">Klik tombol simpan atau gunakan fitur screenshot sebagai bukti nomor antrian. <b>1 Nomor</b> hanya berlaku untuk <b>1x</b> sesuai tanggal kunjungan yang tertera.</li>
            </ol>
        </div>
    </div>
    <!-- Menu -->
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 p-2 order-first order-lg-1">
        <div class="d-flex justify-content-center">
            <div class="card col-12 mb-2">
                <div class="card-body">
                    <!-- Disabled -->
                    <!-- <form action="<?= site_url('antrian/getTotalAntrian'); ?>" method="post" id="dateForm">
                                <div class="card p-4 mb-4">
                                    <h4 class="card-title fw-bold mb-3">Cek Jumlah antrian</h4>
                                    <div class="row" id="jumlah_antrian_result">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 pe-2">
                                            <label for="date_visit_show" class="pb-2">Pilih tanggal :</label>
                                            <input type="date" id="date_visit_show" name="date_visit_show" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+2 days')); ?>" value="" class="datepicker form-control form-control-lg text-muted" onfocus="this.showPicker()">
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-sm-2 mt-xs-2">

                                            <?php if ($this->session->flashdata('check_success_msg')) : ?>
                                                <div class="alert alert-success">
                                                    <?= $this->session->flashdata('check_success_msg') ?>
                                                </div>
                                            <?php elseif ($this->session->flashdata('check_error_msg')) : ?>
                                                <div class="alert alert-danger">
                                                    <?= $this->session->flashdata('check_error_msg') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </form> -->
                    <!-- <div class="alert alert-success" role="alert">
                                <?= form_error('success_message', '<small class="text-danger">', '</small>') ?>
                            </div> -->
                    <!-- Input NoRM -->
                    <form action="<?= site_url('antrian/nomor_antrian'); ?>" method="post">
                        <div class="card p-4">
                            <!-- Attention -->
                            <div class="card bg-warning p-4 rounded-2 mb-3" id="info" style="display: none;">
                                <!-- <div class="card bg-warning p-4 rounded-2 mb-3" id="info"> -->
                                <div class="card-header bg-white text-center">
                                    <h6 class="text-muted">Pelayanan Poliklinik Rawat Jalan</h6>
                                    <!-- <h6 class="text-muted"><i>(Judul) </i><?= $info->info_title; ?></h6> -->
                                    <h5 class="fw-bold text-muted">Libur Hari Raya Waisak</h5>
                                    <!-- <h5 class="fw-bold text-muted"><i>(Header) </i><?= $info->info_header ?></h5> -->
                                    -<br>
                                    <p>Tanggal 23 Mei 2024 & 24 Mei 2024</p>
                                    <!-- <p><i>(Isi) </i><?= $info->info_body ?></p> -->
                                </div>
                                <div class="card-body d-none">
                                    Pelayanan Poliklinik Rawat Jalan mulai tanggal 16 April 2024<br>
                                    <?= $info->info_body; ?><br>
                                </div>
                                <div class="card-footer text-center">
                                    <small class="fst-italic">Nomor Antrian dapat diambil kembali mulai tanggal 25 Mei 2024</small>
                                    <!-- <small class="fst-italic"><i>(Catatan) </i><?= $info->info_notes; ?></small> -->
                                </div>
                            </div>

                            <!-- Input Nomor Antrian -->
                            <h4 class="mb-3 fw-bold text-decoration-underline">Ambil Nomor Antrian</h4>
                            <?php
                            $alertMessage = $this->session->flashdata('alert_message');
                            if ($alertMessage !== null) :
                            ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <small class="fst-italic"><?= $alertMessage ?></small>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 pe-2 pt-2">
                                    <label for="norm" class="pb-2">Nomor Rekam Medis :</label>
                                    <input type="text" class="form-control form-control-lg" placeholder="Isikan No. RM Anda" name="norm" id="norm">
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 pt-2">
                                    <label for="norm" class="pb-2">Pilih Tanggal Kunjungan :</label>
                                    <input class="form-control form-control-lg" type="date" name="date_visit" id="date_visit" value="" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+2 days')); ?>" onfocus="this.showPicker()" onchange="disableToday(this)" required>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end my-2">
                                <button class="btn btn-success btn-lg" type="submit" id="btn-cetak">Ambil Antrian<i class="bi bi-printer-fill ps-2"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card p-4 border">
            <h4 class="mb-3 fw-bold text-decoration-underline">PENGUMUMAN</h4>
        <ol>
                <li class="mb-2">Per tanggal 13 Desember 2024 Kuota Pendaftaran Pasien Poliklinik Melalui Antrian Online Berbasis Web hanya akan dilayani maksimal 250 Pasien Per Hari.</li>
                <!-- <li class="mb-2">Nomor pendaftaran online hanya berlaku untuk pasien yang sudah mempunyai Nomor Rekam Medis di RSUD Caruban, tidak berlaku bagi pasien rawat jalan IGD kecuali pasien umum.</li> -->
                <li class="mb-2">Pasien BPJS yang tidak mendapatkan kuota antrian online berbasis web, Mendaftar menggunakan Aplikasi Mobile JKN dengan menghubungi petugas onsite yang ada di RSUD Caruban atau dapat dengan konsultasi terlebih dahulu pada no wa Duta Mobile JKN 085930456064 (Khoirul).</li>
                <li class="mb-2">Pendaftaran melalui Mobile JKN dapat dilakukan maksimal h-30 sebelum pelayanan sampai hari H.</li>
                <li class="mb-2">Pasien diharapkan untuk membawa HandPhone yang telah terinstall aplikasi Mobile JKN untuk mendaftar menggunakan aplikasi MJKN.</li>
                <!-- <p>Pengambilan nomor antrian pada hari H, diatas pukul <b>12.00 WIB</b> akan mendapatkan nomor antrian untuk hari berikutnya.</p> -->
                <!-- <li class="mb-2">Pengambilan nomor antrian hanya berlaku untuk <b>1 Nomor Rekam Medis</b>, dalam kurun waktu <b>1 Kali Kunjungan</b>.</li> -->
                <!-- <p>ditutup pada hari kunjungan pada pukul <b>12.00 WIB</b>, Jum'at pada pukul <b>11.00 WIB.</b></p>                    -->
                <!-- <li class="mb-2">Apabila nomor antrian sudah dicetak, klik tombol simpan atau gunakan fitur screenshot pada handphone anda sebagai bukti nomor antrian yang berlaku sesuai tanggal kunjungan yang tertera.</li> -->
                <li class="mb-2">Pasien umum dan asuransi bila tidak mendapatkan kuota antrian online berbasis web mengambil antrian secara manual pada petugas pendaftaran umum.</li>
            </ol>
        </div>
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
    </div>
</div>

<script>
    // Auto-submit the form when the input date changes
    // document.getElementById('date_visit_show').addEventListener('input', function() {
    //     document.getElementById('dateForm').submit();
    // });

    // const dateInput = document.getElementById("date_visit_show");
    // dateInput.addEventListener("click", function() {
    //     dateInput.click(); // Open the date picker
    // });

    // $(function() {
    //     $("#datepicker").datepicker({
    //         dateFormat: 'dd-mm-yyyy'
    //     });
    // });

    // Disable weekends and holidays
    document.addEventListener('DOMContentLoaded', function() {
        var dateInput = document.getElementById('date_visit');

        // Fetch holidays from the "date.nager.at" API for Indonesia
        fetch('https://date.nager.at/api/v3/PublicHolidays/2024/id')
            .then(response => response.json())
            .then(holidays => {
                // Additional holidays to be added
                const additionalHolidays = [
                    '2024-03-11', '2024-03-12', '2024-03-29', '2024-04-08', '2024-04-09', '2024-04-10', '2024-04-11', '2024-04-12', '2024-04-13', '2024-04-14', '2024-04-15',
                    '2024-05-10', '2024-05-23', '2024-05-24', '2024-06-18', '2024-12-26'
                ];

                // Merge additional holidays with existing holidays
                const allHolidays = holidays.concat(additionalHolidays.map(date => ({
                    date
                })));

                // Add event listener to date input on change
                // console.log(allHolidays);
                dateInput.addEventListener('change', function() {
                    // Get the selected date
                    var selectedDate = new Date(dateInput.value);

                    // Check if the selected date is a weekend (Saturday or Sunday)
                    if (selectedDate.getDay() === 0 || selectedDate.getDay() === 6) {
                        alert('Pendaftaran pada hari Sabtu dan Minggu ditutup. Pilih hari Senin - Jumat');
                        dateInput.value = ''; // Clear the input value
                        return;
                    }

                    // Check if the selected date is a holiday
                    var formattedDate = selectedDate.toISOString().split('T')[0];
                    if (allHolidays.some(holiday => holiday.date === formattedDate)) {
                        alert('Pendaftaran pada hari Libur Nasional ditutup. Silakan pilih tanggal lain');
                        dateInput.value = ''; // Clear the input value
                    }
                    // Mark disabled dates with a CSS class
                    markDisabledDates();
                });
            })
            .catch(error => console.error('Error fetching holidays:', error));


        // Function to mark disabled dates
        function markDisabledDates() {
            var calendarDates = document.querySelectorAll('input[type="date"]');
            var selectedDate = new Date(dateInput.value);

            calendarDates.forEach(function(calendarDate) {
                var date = new Date(calendarDate.value);
                if (date.getDay() === 0 || date.getDay() === 6) {
                    calendarDate.classList.add('disabled-date');
                } else {
                    calendarDate.classList.remove('disabled-date');
                }
            });
        }
    });

    function disableToday(input) {
        var selectedDate = new Date(input.value);
        var currentDate = new Date();
        var currentHour = currentDate.getHours();

        if (selectedDate.toDateString() === currentDate.toDateString() && currentHour >= 14) {
            input.value = ''; // Clear the input value
            alert('Loket pendaftaran hari ini sudah tutup, Silakan pilih tanggal lain');
        }
    }

    // Function to check the value from the database
    // Execute when the document is ready
    function checkHomeSettings() {
        // Make an AJAX call to fetch the value from the database
        $.ajax({
            url: '<?= site_url("home/getSettings"); ?>', // Path to your CI controller method
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // console.log(data);

                // Check if is_datevisit_enabled is false
                if (data.is_rm_enabled === 't') {
                    // Remove 'disabled' property from the #norm input
                    $('#norm').prop('disabled', false);
                } else {
                    // Add 'disabled' property to the #norm input
                    $('#norm').prop('disabled', true);
                }

                // Check if is_datevisit_enabled is false
                if (data.is_datevisit_enabled === 't') {
                    // Remove 'disabled' property from the #date_visit input
                    $('#date_visit').prop('disabled', false);
                } else {
                    // Add 'disabled' property to the #date_visit input
                    $('#date_visit').prop('disabled', true);
                }

                // Check if is_btn_enabled is 't'
                if (data.is_btn_enabled === 't') {
                    // Remove 'disabled' property from the #btn-cetak button
                    $('#btn-cetak').prop('disabled', false);
                } else {
                    // Add 'disabled' property to the #btn-cetak button
                    $('#btn-cetak').prop('disabled', true);
                }

                // Check if is_info_enabled is 't'
                if (data.is_info_enabled === 't') {
                    // Remove 'display' style from the #info
                    $('#info').css('display', 'block');
                } else {
                    // Add 'display' style to the #info
                    $('#info').css('display', 'none');
                }
            },
            error: function(error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    // $(document).ready(function() {
    //     checkHomeSettings();
    // });

    // // Hari Libur
    // $(document).ready(function() {
    //     var dateInput = $('#date_visit');

    //     // Function to fetch holidays from the external API
    //     function fetchPublicHolidays(callback) {
    //         $.ajax({
    //             url: 'https://date.nager.at/api/v3/PublicHolidays/2024/id',
    //             type: 'GET',
    //             dataType: 'json',
    //             success: function(data) {
    //                 callback(null, data);
    //             },
    //             error: function(error) {
    //                 callback(error);
    //             }
    //         });
    //     }

    //     // Function to fetch holidays from controller
    //     function fetchHolidays(endpoint, callback) {
    //         $.ajax({
    //             url: endpoint,
    //             type: 'GET',
    //             dataType: 'json',
    //             success: function(data) {
    //                 callback(null, data);
    //             },
    //             error: function(error) {
    //                 callback(error);
    //             }
    //         });
    //     }

    //     // Fetch holidays from external API
    //     fetchPublicHolidays(function(error, publicHolidays) {
    //         if (error) {
    //             console.error('Error fetching holidays from external API:', error);
    //             return;
    //         }

    //         // Fetch main holidays from the controller
    //         fetchHolidays('/getLibur', function(error, holidays) {
    //             if (error) {
    //                 console.error('Error fetching holidays:', error);
    //                 return;
    //             }

    //             // Normalize holiday formats if needed
    //             const normalizedHolidays = holidays.map(holiday => ({
    //                 tgl_libur: holiday.tgl_libur,
    //                 hari_libur: holiday.hari_libur
    //             }));

    //             // Merge holidays from external API and main holidays
    //             const allHolidays = publicHolidays.concat(normalizedHolidays);
    //             console.log(allHolidays);

    //             // Add event listener to date input on change
    //             dateInput.on('change', function() {
    //                 // Get the selected date
    //                 var selectedDate = new Date(dateInput.val());
    //                 console.log(selectedDate);

    //                 // Check if the selected date is a weekend (Saturday or Sunday)
    //                 if (selectedDate.getDay() === 0 || selectedDate.getDay() === 6) {
    //                     alert('Pendaftaran pada hari Sabtu dan Minggu ditutup. Pilih hari Senin - Jumat');
    //                     dateInput.val(''); // Clear the input value
    //                     return;
    //                 }

    //                 // Check if the selected date is a holiday
    //                 var formattedDate = selectedDate.toISOString().split('T')[0];
    //                 if (allHolidays.some(holiday => holiday.date === formattedDate)) {
    //                     alert('Pendaftaran pada hari Libur Nasional ditutup. Silakan pilih tanggal lain');
    //                     dateInput.val(''); // Clear the input value
    //                 }
    //                 // Mark disabled dates with a CSS class
    //                 markDisabledDates();
    //             });
    //         });
    //     });

    //     // Function to mark disabled dates
    //     function markDisabledDates() {
    //         var calendarDates = $('input[type="date"]');
    //         var selectedDate = new Date(dateInput.val());

    //         calendarDates.each(function() {
    //             var date = new Date($(this).val());
    //             if (date.getDay() === 0 || date.getDay() === 6) {
    //                 $(this).addClass('disabled-date');
    //             } else {
    //                 $(this).removeClass('disabled-date');
    //             }
    //         });
    //     }
    // });
</script>