<?php
$today = date('Y-m-d');
$antrian = $antrianNow;
// var_dump($loket->no_loket);
// die;
?>


<!-- Audio Files -->
<div>
    <audio id="suarabel" src="<?php echo base_url('assets/audio/suarabel.wav'); ?>"></audio>
    <audio id="suarabelnomorurut" src="<?php echo base_url('assets/audio/antrian/nomor-urut.wav'); ?>"></audio>
    <audio id="diloket" src="<?php echo base_url('assets/audio/antrian/loket.wav'); ?>"></audio>
    <?php
    if ($antrian > 11 && $antrian < 20) { ?>
        <audio id="antrian" src="<?php echo base_url('assets/audio/antrian/' . substr($antrian, -1, 1) . '.wav'); ?>"></audio>
    <?php } else if ($antrian == 20) { ?>
        <audio id="antrian" src="<?php echo base_url('assets/audio/antrian/' . substr($antrian, 0, 1) . '.wav'); ?>"></audio>
    <?php } else if ($antrian > 20 && $antrian < 100) { ?>
        <audio id="antrian" src="<?php echo base_url('assets/audio/antrian/' . substr($antrian, 0, 1) . '.wav'); ?>"></audio>
        <?php
        $a = substr($antrian, -1, 1);
        if ($a == 0) {
        } else { ?>
            <audio id="antrian1" src="<?php echo base_url('assets/audio/antrian/' . $a . '.wav'); ?>"></audio>
        <?php
        }
    } else if ($antrian > 100 && $antrian < 110) { ?>
        <audio id="antrian" src="<?php echo base_url('assets/audio/antrian/' . substr($antrian, -1, 1) . '.wav'); ?>"></audio>
    <?php
    } else if ($antrian > 111 && $antrian < 120) { ?>
        <audio id="antrian" src="<?php echo base_url('assets/audio/antrian/' . substr($antrian, -1, 1) . '.wav'); ?>"></audio>
    <?php

    } else if ($antrian > 119 && $antrian < 210) { ?>
        <audio id="antrian" src="<?php echo base_url('assets/audio/antrian/' . substr($antrian, 0, 1) . '.wav'); ?>"></audio>
        <?php
        $a = substr($antrian, -1, 1);
        if ($a == 0) {
        } else { ?>
            <audio id="antrian1" src="<?php echo base_url('assets/audio/antrian/' . $a . '.wav'); ?>"></audio>
        <?php
        }
    } else if ($antrian == 210) { ?>
        <audio id="antrian" src="<?php echo base_url('assets/audio/antrian/' . substr($antrian, 0, 1) . '.wav'); ?>"></audio>
    <?php } else if ($antrian == 211) { ?>
        <audio id="antrian" src="<?php echo base_url('assets/audio/antrian/' . substr($antrian, 0, 1) . '.wav'); ?>"></audio>
    <?php } else if ($antrian > 211 && $antrian < 220) { ?>
        <audio id="antrian" src="<?php echo base_url('assets/audio/antrian/' . substr($antrian, 0, 1) . '.wav'); ?>"></audio>
        <audio id="antrian1" src="<?php echo base_url('assets/audio/antrian/' . substr($antrian, -1, 1) . '.wav'); ?>"></audio>
    <?php
    } else if ($antrian > 219 && $antrian < 1000) { ?>
        <audio id="antrian" src="<?php echo base_url('assets/audio/antrian/' . substr($antrian, 0, 1) . '.wav'); ?>"></audio>
    <?php
        $a = substr($antrian, 1, 1);
        $b = substr($antrian, -1, 1);
        echo "<audio id='antrian1' src='" . base_url('assets/audio/antrian/' . $a) . ".wav'></audio>";
        echo "<audio id='antrian2' src='" . base_url('assets/audio/antrian/' . $b) . ".wav'></audio>";
    } else { ?>
        <audio id="antrian" src="<?php echo base_url('assets/audio/antrian/' . $antrian . '.wav'); ?>"></audio>
    <?php } ?>

    <audio id="loket<?php echo $loket->no_loket; ?>" src="<?php echo base_url('assets/audio/antrian/' . $loket->no_loket . '.wav'); ?>"></audio>
    <audio id="sepuluh" src="<?php echo base_url('assets/audio/antrian/sepuluh.wav'); ?>"></audio>
    <audio id="sebelas" src="<?php echo base_url('assets/audio/antrian/sebelas.wav'); ?>"></audio>
    <audio id="seratus" src="<?php echo base_url('assets/audio/antrian/seratus.wav'); ?>"></audio>
    <audio id="belas" src="<?php echo base_url('assets/audio/antrian/belas.wav'); ?>"></audio>
    <audio id="puluh" src="<?php echo base_url('assets/audio/antrian/puluh.wav'); ?>"></audio>
    <audio id="ratus" src="<?php echo base_url('assets/audio/antrian/ratus.wav'); ?>"></audio>
</div>

<!-- Loket Views -->
<!-- Container fluid -->
<div class="container-fluid">
    <!-- <p>Remaining Session Time: <?php echo gmdate("H:i:s", remaining_session_time()); ?></p> -->
    <div class="row m-2 p-2 bg-light rounded-2">
        <div class="col-xl-8 col-lg-8 col-md-12">
            <div class="row">
                <!-- Status Card -->
                <?php
                $loketId = $loket->id_loket;
                $otherLokets = $this->db
                    ->select('*')
                    ->from('online_service.loket')
                    ->where('id_loket !=', $loketId)
                    ->order_by('id_loket', 'ASC')
                    ->limit(5)
                    ->get()
                    ->result();

                foreach ($otherLokets as $otherLoket) :
                    $antrianNo = $this->M_crud->get_max_id('online_service.antrian_loket', 'no_antrian', [
                        'id_loket' => $otherLoket->id_loket,
                        'date_visit' => date('Y-m-d'),
                        'id_loket !=' => $loketId
                    ])->row('no_antrian');

                    // Set a default value of 0 if $antrianNo is empty
                    if (!empty($antrianNo)) {
                        $antrianNo = $antrianNo;
                    } else {
                        $antrianNo = 0;
                    }
                ?>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                <div class="card-header">
                                    <h4>Loket <?php echo $otherLoket->no_loket; ?></h4>
                                </div>
                                <div class="text-center py-4">
                                    <h1 class="fw-bold" style="font-size: 72px;"><?php echo $antrianNo; ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-12">
            <!-- Main Loket -->
            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                <!-- Cetak Nomor -->
                <div class="row mb-2 border border-success p-2">
                    <div class="col-6">
                        <a href="<?= base_url('antrian/antrian_onsite') ?>" class="btn btn-lg bg-primary text-white fw-bold">Cetak Nomor</a>
                    </div>
                </div>
                <!-- card  -->
                <div class="card">
                    <div class="p-4 text-center">
                        <!-- Display nomor loket dinamis sesuai nomor panggil -->
                        <h2 class="card-header fw-bold bg-warning">Loket <?= $loket->no_loket; ?></h2>
                        <!-- <div class="card-title fs-">Nomor Antrian Berikutnya</div> -->
                    </div>
                    <!-- card body  -->
                    <div class="card-body">
                        <!-- number -->
                        <div class="d-flex justify-content-center bg-opacity-50">
                            <div class="col-8 bg-light text-center rounded-2 border">
                                <h1 class="fw-bold" style="font-size: 100px;">
                                    <?= $antrianNow; ?>
                                </h1>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">

                            <div class="col-8 text-center pt-4 mb-4">
                                <button class="btn btn-warning btn-lg p-4 mb-2" onclick="call()" id="call">Panggil Antrian
                                    <i class="bi bi-mic-fill"></i>
                                </button>
                                <!-- <button class="btn btn-info btn-lg p-4 mb-2" onclick="recall()" id="recall" style="display:none;">Panggil Ulang
                                    <i class="bi bi-mic-fill"></i>
                                </button> -->
                                <a href="<?php echo site_url('dashboard/callNext'); ?>" class="btn btn-outline-warning btn-lg selanjutnya" type="submit">
                                    <span class="">Nomor Selanjutnya</span>
                                    <i class="bi bi-caret-right-square-fill ps-2"></i>
                                </a>
                            </div>
                        </div>
                        <!--
                <audio id="audio-element" controls>
                     The source will be generated dynamically with JavaScript
                </audio> -->
                        <!-- <div>
                            <h1 id="a"><?php echo $antrian; ?></h1>
                            <button class="btn panggil" onclick="panggil()"><i class="bi bi-bullhorn"></i> &nbsp;Panggil</button>
                            <a href="<?php echo site_url('penjaga/antrian_selanjutnya') . '/' . $this->session->userdata('username'); ?>" class="btn btn-lg selanjutnya" type="submit"><i class="bi bi-play"></i> &nbsp;Antrian Selanjutnya</a>
                        </div> -->
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="counter-status">
        <!-- <h2>Loket: <?= $counterName ?></h2> -->
        <!-- <p>Nomor Sekarang: <?= $currentAntrian ?></p> -->
        <!-- <button onclick="callNextQueue('<?= $counterName ?>')">Call Next</button> -->
    </div>
</div>





<!-- Audio -->
<script type="text/javascript">
    var callButton = document.getElementById('call');
    var recallButton = document.getElementById('recall');
    var audioElement = document.getElementById('audioElement');

    function playAudio(id, delay) {
        setTimeout(function() {
            var audio = document.getElementById(id);
            audio.pause();
            audio.currentTime = 0;
            audio.play();
        }, delay);
    }

    function call() {
        callButton.disabled = true;

        // Your existing code for panggil() goes here

        playAudio('suarabel', 0);

        // Set initial totalWaktu
        var totalWaktu = document.getElementById('suarabel').duration * 1000;

        playAudio('suarabelnomorurut', totalWaktu);
        totalWaktu += 1000;

        <?php
        if ($antrian < 10) { ?>
            playAudio('antrian', totalWaktu);
            totalWaktu += 1000;
        <?php } elseif ($antrian == 10) { ?>
            playAudio('sepuluh', totalWaktu);
            totalWaktu += 1000;
        <?php } elseif ($antrian == 11) { ?>
            playAudio('sebelas', totalWaktu);
            totalWaktu += 1000;
        <?php } else if ($antrian > 11 && $antrian < 20) { ?>
            playAudio('antrian', totalWaktu);
            totalWaktu += 1000;
            playAudio('belas', totalWaktu);
            totalWaktu += 1000;
        <?php } else if ($antrian == 20) { ?>
            playAudio('antrian', totalWaktu);
            totalWaktu += 800;
            playAudio('puluh', totalWaktu);
            totalWaktu += 1000;
        <?php } else if ($antrian > 20 && $antrian < 100) { ?>
            playAudio('antrian', totalWaktu);
            totalWaktu += 800;
            playAudio('puluh', totalWaktu);
            totalWaktu += 1000;
            playAudio('antrian1', totalWaktu);
            totalWaktu += 800;
        <?php } else if ($antrian == 100) { ?>
            playAudio('seratus', totalWaktu);
            totalWaktu += 800;
        <?php } else if ($antrian > 100 && $antrian < 110) { ?>
            playAudio('seratus', totalWaktu);
            totalWaktu += 800;
            playAudio('antrian', totalWaktu);
            totalWaktu += 800;
        <?php } else if ($antrian == 110) { ?>
            playAudio('seratus', totalWaktu);
            totalWaktu += 800;
            playAudio('sepuluh', totalWaktu);
            totalWaktu += 800;
        <?php } else if ($antrian == 111) { ?>
            playAudio('seratus', totalWaktu);
            totalWaktu += 800;
            playAudio('sebelas', totalWaktu);
            totalWaktu += 800;
        <?php } else if ($antrian > 111 && $antrian < 120) { ?>
            playAudio('seratus', totalWaktu);
            totalWaktu += 800;
            playAudio('antrian', totalWaktu);
            totalWaktu += 800;
            playAudio('belas', totalWaktu);
            totalWaktu += 800;
        <?php } else if ($antrian > 119 && $antrian < 200) { ?>
            playAudio('antrian', totalWaktu);
            totalWaktu += 800;
            playAudio('antrian1', totalWaktu);
            totalWaktu += 800;
            playAudio('puluh', totalWaktu);
            totalWaktu += 800;
            playAudio('antrian1', totalWaktu);
            totalWaktu += 800;
        <?php } else if ($antrian > 199 && $antrian < 210) { ?>
            playAudio('antrian', totalWaktu);
            totalWaktu += 800;
            playAudio('ratus', totalWaktu);
            totalWaktu += 800;
            playAudio('antrian1', totalWaktu);
            totalWaktu += 800;
        <?php } else if ($antrian == 210) { ?>
            playAudio('antrian', totalWaktu);
            totalWaktu += 800;
            playAudio('ratus', totalWaktu);
            totalWaktu += 800;
            playAudio('sepuluh', totalWaktu);
            totalWaktu += 800;
        <?php } else if ($antrian == 211) { ?>
            playAudio('antrian', totalWaktu);
            totalWaktu += 800;
            playAudio('ratus', totalWaktu);
            totalWaktu += 800;
            playAudio('sebelas', totalWaktu);
            totalWaktu += 800;
        <?php } else if ($antrian > 211 && $antrian < 220) { ?>
            playAudio('antrian', totalWaktu);
            totalWaktu += 800;
            playAudio('ratus', totalWaktu);
            totalWaktu += 800;
            playAudio('antrian1', totalWaktu);
            totalWaktu += 800;
            playAudio('belas', totalWaktu);
            totalWaktu += 800;
        <?php } else if ($antrian > 219 && $antrian < 1000) { ?>
            playAudio('antrian', totalWaktu);
            totalWaktu += 800;
            playAudio('ratus', totalWaktu);
            totalWaktu += 800;
            playAudio('antrian1', totalWaktu);
            totalWaktu += 800;
            playAudio('puluh', totalWaktu);
            totalWaktu += 800;
            playAudio('antrian2', totalWaktu);
            totalWaktu += 800;
        <?php } ?>

        totalWaktu += 800;
        playAudio('diloket', totalWaktu);

        totalWaktu += 1800;
        playAudio('loket<?php echo $loket->no_loket; ?>', totalWaktu);

        audioElement.playAudio();

        // Add an event listener to re-enable the call when the audio ends
        audioElement.addEventListener('ended', function() {
            callButton.disabled = false;
            recallButton.style.display = 'inline-block';
        });

        function recall() {
            recallButton.style.display = 'none'; // Hide the "Panggil Ulang" button
            call(); // Call the main function again
        }
    }
</script>