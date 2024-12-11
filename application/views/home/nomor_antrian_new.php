<?php
$months = [
    'January' => 'Januari',
    'February' => 'Februari',
    'March' => 'Maret',
    'April' => 'April',
    'May' => 'Mei',
    'June' => 'Juni',
    'July' => 'Juli',
    'August' => 'Agustus',
    'September' => 'September',
    'October' => 'Oktober',
    'November' => 'November',
    'December' => 'Desember'
];
$date_visit_en = date('d F Y', strtotime($tickets['date_visit']));
$date_visit = str_replace(array_keys($months), array_values($months), $date_visit_en);
?>

<div class="row mx-2">
    <!-- Download -->
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 p-2 bg-light mx-auto">
        <!-- Notification Nomor Antrian -->
        <div class="p-2">
            <!-- if $data contain $message then show each one -->
            <!-- <p><?= $ticket_message ?></p> -->
            <?php if (isset($success_message)) : ?>
                <div class="toast align-items-center text-bg-primary border-0 mx-auto" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <?= $success_message ?><br>Untuk tanggal kunjungan: <b><?= $date_visit ?></b>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
                <script>
                    var toast = new bootstrap.Toast(document.querySelector('.toast'));
                    // Auto close after 15000 milliseconds (15 seconds)
                    setTimeout(function() {
                        toast.hide();
                    }, 15000);
                    // Show the toast
                    toast.show();
                </script>
            <?php elseif (isset($exist_message)) : ?>
                <div class="toast align-items-center text-bg-warning border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <?= $exist_message ?>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
                <script>
                    var toast = new bootstrap.Toast(document.querySelector('.toast'));
                    // Auto close after 15000 milliseconds (15 seconds)
                    setTimeout(function() {
                        toast.hide();
                    }, 15000);
                    // Show the toast
                    toast.show();
                </script>
            <?php endif; ?>
        </div>
        <!-- Nomor Layout -->
        <div class="card p-2 col-12">
            <div class="rounded mx-auto pt-2">
                <a id="download" class="btn btn-lg btn-success">Simpan Nomor Antrian<i class="bi bi-download ps-3"></i></a>
            </div>
            <div class="d-flex justify-content-center text-center m-2">
                <div id="htmlContent" name="htmlContent" class="p-2">
                    <div class="ticket border border-2 border-dark" style="width: 280px; height: 360px;">
                        <div class="">
                            <div class="text-center">
                                <small class="fw-bold text-muted" style="font-size: 10px;">- LOKET PENDAFTARAN RSUD CARUBAN -</small>
                                <h4 class="fw-bold">NOMOR ANTRIAN</h4>
                            </div>
                            <label style="font: bold 100px arial, sans-serif">
                                <?= $tickets['no_antrian'] ?>
                            </label>
                            <div class="container mb-2">
                                <div class="row">
                                    <div class="col-5" align="left">Nomor RM :</div>
                                    <div class="col-7" align="right"><?= $tickets['no_rm'] ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-3" align="left">Nama :</div>
                                    <div class="col-9" align="right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <?= $tickets['name'] ?></div>
                                </div>
                                <div class="row">
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
                                <small class="fw-bold pt-1" style="font-size: 10px;">Tanggal Kunjungan</small>
                                <h6 class="text-center fw-bold" style="font-size: 18px;">
                                    <?= $date_visit ?>
                                </h6>
                                <div class="bg-dark" style="height: 2px; width: 80%"></div>
                                <div class="text-center my-2 px-auto">
                                    <p class="fst-italic" style="font-size: 12px;">Wajib hadir sesuai jam layanan yang tertera.</p>
                                    <!-- <p><br>Apabila nomor anda terlewatkan, <br>dimohon menunggu 3 nomor berikutnya</p> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded mx-auto pt-2">
                <a href="<?= base_url() ?>" class="btn btn-secondary"><i class="bi bi-chevron-left pe-2"></i>Halaman Utama</a>
            </div>
            <div class="col-12 m-2">
                <!-- <div class="p-3 rounded">
                    <a href="javascript:void(0)" id="print" class="btn btn-lg btn-dark text-light" onclick="printDiv('htmlContent')">Cetak Nomor Antrian<i class="bi bi-printer ps-2"></i></a></div> -->
            </div>
        </div>
    </div>
</div>


<!-- Download Jpg -->
<script type="text/javascript">
    // Download Output
    // Function to capture content and trigger download
    function autoDownload() {
        html2canvas(document.getElementById('htmlContent')).then(function(canvas) {
            var imgData = canvas.toDataURL('image/jpeg');
            var link = document.createElement('a');
            link.href = imgData;
            link.download = 'nomor_antrian_rsudcaruban.jpeg';
            link.click();
        });
    }
    // Call the function when the page is loaded
    window.onload = autoDownload;

    // Redirect Home
    // setTimeout(function() {
    //     window.location.href = "<?= base_url() ?>"; // Redirect to 'home' after 15 seconds
    // }, 150000); // 15000 milliseconds = 15 seconds

    // Countdown
    // var countdown = 15; // Countdown in seconds
    // var countdownElement = document.getElementById("countdown");

    // function updateCountdown() {
    //     if (countdown > 0) {
    //         countdownElement.textContent = "Kembali ke Halaman Utama dalam " + countdown + " detik";
    //         countdown--;
    //         setTimeout(updateCountdown, 1000); // Update every 1 second
    //     } else {
    //         window.location.href = "<?= base_url() ?>"; // Redirect to 'home' after the countdown
    //     }
    // }
    // // Call the function when the page is loaded
    // window.onload = autoDownload;

    // // Start the countdown
    // updateCountdown();
</script>