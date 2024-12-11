<!-- Loket Views -->
<div class="container-fluid" id="display"><span id="seconds"></span>
    <div class="row m-2 rounded-2 bg-light">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 my-auto">
            <!-- Carousel -->
            <div class="row my-4">
                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12" id="ongoingAntrian">
                    <div class="card">
                        <h1 class="card-header py-4 text-center fw-bold bg-warning" style="font-size: 60px;">NOMOR ANTRIAN</h1>
                        <div class="card-body my-4">
                            <!-- number -->
                            <div class="d-flex justify-content-center bg-opacity-50">
                                <div class="col-12 bg-light text-center rounded-2 border my-2">
                                    <h1 class="fw-bold blink" id="nomor_antrian" style="font-size: 300px;"></h1>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h1 class="card-footer py-2 text-center fw-bold bg-warning" style="font-size: 60px;">LOKET</h1>
                        </div>
                        <div class="card-body my-2">
                            <!-- number -->
                            <div class="d-flex justify-content-center bg-opacity-50">
                                <div class="col-10 bg-light text-center rounded-2 border my-2">
                                    <h1 class="fw-bold blink" id="id_loket" style="font-size: 200px;"></h1>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xs-12">
                    <!-- Carousel -->
                    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="<?= base_url('assets/img/dummy-img.jpg') ?>" class="mx-auto" style="max-height: 400px; object-fit:contain" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="<?= base_url('assets/img/dummy-img.jpg') ?>" class="mx-auto" style="max-height: 400px; object-fit:contain" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="<?= base_url('assets/img/dummy-img.jpg') ?>" class="mx-auto" style="max-height: 400px; object-fit:contain" alt="...">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                    <!-- Loket Status Card -->
                    <!-- <div class="row">
                        <?php
                        usort($latestAntrian, function ($a, $b) {
                            return $a->id_loket <=> $b->id_loket;
                        });
                        ?>
                        <?php
                        foreach ($latestAntrian as $record) : ?>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-4 col-xs-6 mt-4">
                                <div class="card text-center">
                                    <div class="card-header bg-warning bg-opacity-25">
                                        <?php if (isset($record->id_loket)) : ?>
                                            <h6 class="fw-bold">Loket <?php echo $record->id_loket; ?></h6>
                                        <?php else : ?> -->
                    <!-- Handle the case where $record->id_loket is not set -->
                    <!-- <h6 class="fw-bold">LOKET 0</h6>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <h4 class="fw-bold text-muted" id="antrianNo" style="font-size: 72px;"><?= $record->latest_no_antrian ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?> -->
                </div>
            </div>
        </div>
    </div>

    <footer class="m-2 mx-auto">
        <div class="row bg-success">
            <div class="py-1 align-middle" onmouseover="stop();" onmouseout="start()">
                <p class="text-center text-white fs-3">Nomor antrian loket pendaftaran online bisa diambil mulai H-2 tanggal kunjungan di website <a href="https://www.antrianrsudcaruban.com" class="text-white fw-bold text-decoration-none">antrianrsudcaruban.com</a></p>
            </div>
        </div>
    </footer>
</div>



<!-- Audio Files -->
<?php
$antrian = '';
$latestLoket = '';
?>
<div>
    <audio id="suarabel" src="<?php echo base_url('assets/audio/antrian/suarabel.wav'); ?>"></audio>
    <audio id="suarabelnomorurut" src="<?php echo base_url('assets/audio/antrian/antrian.wav'); ?>"></audio>
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

    <audio id="loket<?php echo $latestLoket ?>" src="<?php echo base_url('assets/audio/antrian/' . $latestLoket . '.wav'); ?>"></audio>
    <?php if (isset($latestLoket) && $latestLoket !== '') : ?>
        <audio id="loket<?php echo $latestLoket; ?>" src="<?php echo base_url('assets/audio/antrian/' . $latestLoket . '.wav'); ?>"></audio>
    <?php endif; ?>
    <audio id="sepuluh" src="<?php echo base_url('assets/audio/antrian/sepuluh.wav'); ?>"></audio>
    <audio id="sebelas" src="<?php echo base_url('assets/audio/antrian/sebelas.wav'); ?>"></audio>
    <audio id="seratus" src="<?php echo base_url('assets/audio/antrian/seratus.wav'); ?>"></audio>
    <audio id="belas" src="<?php echo base_url('assets/audio/antrian/belas.wav'); ?>"></audio>
    <audio id="puluh" src="<?php echo base_url('assets/audio/antrian/puluh.wav'); ?>"></audio>
    <audio id="ratus" src="<?php echo base_url('assets/audio/antrian/ratus.wav'); ?>"></audio>
</div>

<script type="text/javascript">
    // Ongoing Antrian & Loket
    $(document).ready(function() {
        function updateData() {
            $.ajax({
                url: '<?= base_url('home/update_display'); ?>',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    // Assign values to JavaScript variables
                    var nomorAntrian = data.nomor_antrian;
                    var idLoket = data.id_loket;

                    // Update HTML elements
                    $('#nomor_antrian').text(nomorAntrian);
                    $('#id_loket').text(idLoket);
                }
            });
        }
        setInterval(updateData, 2000);
    });

    $(document).ready(function() {
        // Initialize last known values
        var isFirstTime = true;
        var lastNomorAntrian = $('#nomor_antrian').data('nomorAntrian');
        var lastIdLoket = $('#id_loket').data('idLoket');

        function playAudio(id, delay) {
            setTimeout(function() {
                var audio = document.getElementById(id);
                audio.pause();
                audio.currentTime = 0;
                audio.play();
            }, delay);
        };

        function playAllAudioSequentially(audioIds, index) {
            if (index < audioIds.length) {
                var audioId = audioIds[index];
                var audio = document.getElementById(audioId);

                // Set up an event listener to play the next audio when the current one ends
                audio.onended = function() {
                    playAllAudioSequentially(audioIds, index + 1);
                };

                // Play the current audio
                playAudio(audioId);
            }
        }

        if (isFirstTime) {
            var audioIds = ['suarabel', 'suarabelnomorurut', 'diloket', 'loket' + lastIdLoket];
            playAllAudioSequentially(audioIds, 0);

            isFirstTime = false;
        }
    });
</script>