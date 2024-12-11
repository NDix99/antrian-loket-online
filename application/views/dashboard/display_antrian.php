<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="icon" href="<?= base_url('assets/img/list-ol.svg') ?>">
    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= base_url('/assets/css/style.css'); ?>">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->

    <script src="<?= base_url('assets/js/main.js') ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Datepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.3/html2canvas.min.js"></script>

    <style>
        .footer-scroll {
            white-space: nowrap;
            overflow: hidden;
            animation: marquee 30s cubic-bezier(0.5, 0.5, 0.5, 0.5) infinite;
        }

        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        /* Blink Animation */
        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }
        }
    </style>

</head>

<body class="bg-success bg-opacity-10">

    <header class="container-fluid">
        <nav class="navbar d-flex justify-content-center border px-4 bg-success rounded-2">
            <div class="col-md-12 col-sm-12 col-xs-12 text-white text-center">
                <h4 class="fw-bold"><?= $instansi->hsp_name; ?></h4>
                <div class="">
                    <small><?= $instansi->hsp_address . ", " . $instansi->city_name; ?> | </small>
                    <small>Phone: <?= $instansi->hsp_phone; ?> | </small>
                    <small>Email: <?= $instansi->hsp_email; ?></small>
                </div>
            </div>
            <!-- <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="float-end bg-light p-1 border border-success rounded-2 d-flex" style="z-index: 999;">
                    <i class="bi bi-clock pe-2"></i>
                    <small class="align-items-center" id="waktu-wib">
                        <?php
                        date_default_timezone_set('Asia/Jakarta'); // Set zona waktu ke WIB
                        ?>
                    </small>
                </div>
            </div> -->
            <div class="bg-white m-1" style="width: 100%; height: .5px;"></div>
        </nav>
    </header>

    <!-- Loket Views -->
    <div class="container-fluid" id="display"><span id="seconds"></span>
        <div class="row m-2 p-2 rounded-2 bg-success bg-opacity-25">
            <div class="col-xl-8 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <!-- Status Card -->
                    <?php
                    $loketId = (isset($loket) && is_object($loket) && property_exists($loket, 'id_loket')) ? $loket->id_loket : 0;
                    // $loketId = $loket->id_loket;
                    $otherLokets = $this->db
                        ->select('*')
                        ->from('online_service.loket')
                        ->order_by('id_loket', 'ASC')
                        ->get()
                        ->result();

                    foreach ($otherLokets as $otherLoket) :
                        $antrianNo = $this->M_crud->get_max_id('online_service.antrian_loket', 'no_antrian', [
                            'id_loket' => $otherLoket->id_loket,
                            'date_visit' => date('Y-m-d'),
                            'id_loket =' => $loketId
                        ])->row('no_antrian');

                        // Set a default value of 0 if $antrianNo is empty
                        $antrianNo = !empty($antrianNo) ? $antrianNo : 0;
                    ?>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12 pt-2">
                            <div class="card text-center mb-4">
                                <div class="card-header bg-warning bg-opacity-25">
                                    <h4 class="fw-bold">Loket <?php echo $otherLoket->no_loket; ?></h4>
                                </div>
                                <div class="card-body">
                                    <div class="text-center py-4">
                                        <h4 class="fw-bold" id="antrianNo" style="font-size: 72px;"><?php echo $antrianNo; ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <!-- Main Loket -->
                <!-- card  -->
                <div class="card mt-2">
                    <!-- card body  -->
                    <h3 class="card-header p-4 text-center fw-bold bg-warning">Nomor Antrian Saat Ini</h3>
                    <div class="card-body my-auto">
                        <!-- number -->
                        <div class="d-flex justify-content-center bg-opacity-50">
                            <div class="col-8 bg-light text-center rounded-2 border my-2">
                                <h1 class="fw-bold blink" style="font-size: 180px;">
                                    <?= $antrian; ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-warning">
                        <?php if (isset($loket->no_loket)) : ?>
                            <h4 class="fw-bold fs-1 py-4">LOKET <?php echo $loket->no_loket; ?></h4>
                        <?php else : ?>
                            <!-- Handle the case where $loket->no_loket is not set -->
                            <h4 class="fw-bold">Loket belum tersedia</h4>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <div class="row bg-success">
                <div class="py-1" onmouseover="stop();" onmouseout="start()">
                    <marquee class="footer-scroll" onmouseover="stop();" onmouseout="start()">
                        <p class="fs-4 text-white">Nomor antrian loket pendaftaran online bisa diambil mulai H-2 tanggal kunjungan di website <antrianrsudcaruban.com class="fw-bold text-decoration-none">antrianrsudcaruban.com</a></p>
                    </marquee>
                </div>
            </div>
        </footer>
    </div>

    <script type="text/javascript">
        // Blink Text
        var blink = document.querySelector('.blink');
        // setInterval(function() {
        //     blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
        // }, 1000);

        setTimeout(function() {
            location.reload();
        }, 5000);

        // Running Text
        let isScrolling = true;

        function stopScroll() {
            isScrolling = false;
        }

        function startScroll() {
            isScrolling = true;
        }

        function scrollText() {
            const scrollElem = document.querySelector('.footer-scroll');
            const scrollWidth = scrollElem.scrollWidth;
            const containerWidth = scrollElem.clientWidth;

            if (scrollWidth > containerWidth) {
                const animationDuration = (scrollWidth / containerWidth) * 10; // Adjust the speed
                scrollElem.style.animation = `marquee ${animationDuration}s linear infinite`;
            } else {
                // If the text fits, remove the animation
                scrollElem.style.animation = 'none';
            }
        }

        scrollText();

        // function updateAntrian() {
        //     // You can replace the following line with your logic to fetch new content
        //     var noAntrian = <?= $antrianNo ?>;

        //     // Replace the content of the div with the new content
        //     document.getElementById("antrianNo").innerHTML = noAntrian;
        // }

        // // Set interval to refresh the div every second (1000 milliseconds)
        // setInterval(updateAntrian, 1000);

        // Auto Refresh
        // setInterval(function() {
        //     // Use AJAX to fetch the updated value from the server
        //     $.ajax({
        //         url: 'home/display_antrian', // Replace with the actual URL to fetch the updated value
        //         type: 'GET',
        //         dataType: 'json', // Assuming the response is in JSON format
        //         success: function(response) {
        //             // Update the content of the HTML element with the received value
        //             document.getElementById('antrianNo').innerText = response.antrianNo;
        //         },
        //         error: function(xhr, status, error) {
        //             console.error('Error fetching updated value:', error);
        //         }
        //     });
        // }, 5000); // Update every 5000 milliseconds (5 seconds)
    </script>
</body>

</html>
// Audio
// // Check for the audio parameter in the URL
// const urlParams = new URLSearchParams(window.location.search);
// const audioRequested = urlParams.get('audio');

// // If the audio parameter is true, play the audio
// if (audioRequested === 'true') {
// playAudio();
// }

// Auto-play audio when the page loads
// document.addEventListener('DOMContentLoaded', function() {
// var audio = document.getElementById('audioPlayer');
// audio.play();
// });

// Blink Text
var blink = document.querySelector('.blink');
setInterval(function() {
blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
}, 1000);

setTimeout(function() {
location.reload();
}, 5000);

// // Running Text
// let isScrolling = true;

// function stopScroll() {
// isScrolling = false;
// }

// function startScroll() {
// isScrolling = true;
// }

// function scrollText() {
// const scrollElem = document.querySelector('.footer-scroll');
// const scrollWidth = scrollElem.scrollWidth;
// const containerWidth = scrollElem.clientWidth;

// if (scrollWidth > containerWidth) {
// const animationDuration = (scrollWidth / containerWidth) * 10; // Adjust the speed
// scrollElem.style.animation = `marquee ${animationDuration}s linear infinite`;
// } else {
// // If the text fits, remove the animation
// scrollElem.style.animation = 'none';
// }
// }

// scrollText();

// function updateAntrian() {
// // You can replace the following line with your logic to fetch new content
// var noAntrian = <?= $antrianNo ?>;

// // Replace the content of the div with the new content
// document.getElementById("antrianNo").innerHTML = noAntrian;
// }

// // Set interval to refresh the div every second (1000 milliseconds)
// setInterval(updateAntrian, 1000);

// Auto Refresh
// setInterval(function() {
// // Use AJAX to fetch the updated value from the server
// $.ajax({
// url: 'home/display_antrian', // Replace with the actual URL to fetch the updated value
// type: 'GET',
// dataType: 'json', // Assuming the response is in JSON format
// success: function(response) {
// // Update the content of the HTML element with the received value
// document.getElementById('antrianNo').innerText = response.antrianNo;
// },
// error: function(xhr, status, error) {
// console.error('Error fetching updated value:', error);
// }
// });
// }, 5000); // Update every 5000 milliseconds (5 seconds)