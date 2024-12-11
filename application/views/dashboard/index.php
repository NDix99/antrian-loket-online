<?php
$today = date('Y-m-d');
$antrian = $antrianNow;
?>
<!-- Audio Files -->
<!-- <div>
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

    <audio id="loket<?php echo $loket->no_loket; ?>" src="<?php echo base_url('assets/audio/antrian/' . $loket->no_loket . '.wav'); ?>"></audio>
    <audio id="sepuluh" src="<?php echo base_url('assets/audio/antrian/sepuluh.wav'); ?>"></audio>
    <audio id="sebelas" src="<?php echo base_url('assets/audio/antrian/sebelas.wav'); ?>"></audio>
    <audio id="seratus" src="<?php echo base_url('assets/audio/antrian/seratus.wav'); ?>"></audio>
    <audio id="belas" src="<?php echo base_url('assets/audio/antrian/belas.wav'); ?>"></audio>
    <audio id="puluh" src="<?php echo base_url('assets/audio/antrian/puluh.wav'); ?>"></audio>
    <audio id="ratus" src="<?php echo base_url('assets/audio/antrian/ratus.wav'); ?>"></audio>
</div> -->

<!-- Container fluid -->
<div class="container-fluid">
    <div class="mt-2 pt-2 px-4 bg-light rounded-2">
        <div class="row">
            <!-- Status Card -->
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-3">
                <!-- card -->
                <div class="card mb-2 border border-success">
                    <!-- card body -->
                    <div class="card-body">
                        <!-- heading -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h5 class="mb-0">Jumlah Antrian</h5>
                            </div>
                            <div class="icon-shape icon-md bg-light-primary rounded-2">
                                <i class="bi bi-people-fill fs-4"></i>
                            </div>
                        </div>
                        <!-- number -->
                        <div>
                            <h1 class="fw-bold"><?= $totalAntrian; ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-3">
                <!-- card -->
                <div class="card mb-2 border border-success">
                    <!-- card body -->
                    <div class="card-body">
                        <!-- heading -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h5 class="mb-0">Sisa Antrian</h5>
                            </div>
                            <div class="icon-shape icon-md bg-light-primary rounded-2">
                                <i class="bi bi-hourglass-split fs-4"></i>
                            </div>
                        </div>
                        <!-- number -->
                        <div>
                            <h1 class="fw-bold text-muted"><?= $queueAntrian; ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-3">
                <!-- card -->
                <div class="card mb-2 border border-success">
                    <!-- card body -->
                    <div class="card-body">
                        <!-- heading -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h5 class="mb-0">Antrian Selesai</h5>
                            </div>
                            <div class="icon-shape icon-md bg-light-primary rounded-2">
                                <i class="bi bi-calendar-check-fill fs-4"></i>
                            </div>
                        </div>
                        <!-- number -->
                        <div>
                            <h1 class="fw-bold"><?= $antrianDone; ?></h1>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                <!-- card -->
                <div class="card mb-2 border border-success">
                    <!-- card body -->
                    <div class="card-body">
                        <!-- heading -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h5 class="fw-bold">Antrian Loket</h5>
                            </div>
                            <div class="icon-shape icon-md bg-light-primary rounded-2">
                                <h5 class="fw-bold text-white"><?= $antrianNow; ?></h5>
                            </div>
                        </div>
                        <!-- Cetak Nomor -->
                        <div class="px-2 d-flex justify-content-center">
                            <form action="<?= base_url('antrian/antrian_onsite') ?>" method="post" id="cetakNomor">
                                <button id="printBtn" name="printBtn" type="submit" class="btn btn-lg btn-primary text-white fw-bold" disabled>CETAK NOMOR <i class="bi bi-file-earmark-binary-fill fs-4"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Tabel Antrian  -->
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-4 col-xs-12">
            <div class="card mt-2 p-2">
                <div class="d-flex">
                    <div class="card-body text-center">
                        <a href="<?= base_url('dashboard/data_antrian') ?>" class="btn btn-lg btn-primary fw-bold">Cek Data Antrian<i class="bi bi-journal-bookmark-fill ps-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-7 col-lg-7 col-md-6 col-sm-8 col-xs-12">
            <!-- card  -->
            <div class="card mt-2 px-4">
                <!-- card header  -->
                <div class="card-header bg-white py-4 mb-2">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <h4 class="fw-bold">Tabel Data Antrian</h4>
                        </div>
                        <!-- Search Form -->
                        <!-- <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <form method="post" action="<?= base_url('dashboard/index') ?>">
                                <div class="d-flex input-group">
                                    <input type="text" class="form-control" name="keyword" placeholder="Cari Nomor RM / Nama" id="search" value="" autocomplete="off">
                                    <button type="submit" name="submit" class="btn btn-success" id="button-addon2"><i class="bi bi-search"></i></button>
                                </div>
                            </form>
                        </div> -->
                    </div>
                </div>
                <div class="card-body">
                    <!-- Table  -->
                    <div class="table-responsive">
                        <table id="antrian-list" class="table table-striped text-nowrap mb-2" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No. Antrian</th>
                                    <th>No. RM</th>
                                    <th>Nama Pasien</th>
                                    <th>Tanggal Kunjungan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($antrianList) && is_array($antrianList)) {
                                    foreach ($antrianList as $antri) : ?>
                                        <tr>
                                            <td><?= $antri['no_antrian'] ?></td>
                                            <td><?= $antri['no_rm'] ?></td>
                                            <td><?= $antri['name'] ?></td>
                                            <td><?= $antri['date_visit'] = date('d F Y'); ?></td>
                                        </tr>
                                    <?php
                                    endforeach;
                                } else {
                                    // Handle the case when $antrianList is empty or not set
                                    ?>
                                    <tr>
                                        <td colspan="4" align="center" class="text-muted">Data antrian tidak ditemukan</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Pagination links -->
                <!-- <div class="pt-2 mx-auto">
                    <?= $pagination; ?>
                </div> -->
            </div>
        </div>

        <!-- Panggil Antrian -->
        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-xs-12">
            <!-- card  -->
            <div class="card mt-2 h-80">
                <div class="card-header bg-success p-2">
                    <h4 class="fw-bold text-light text-center">Loket <?= $loket->no_loket; ?></h4>
                </div>
                <!-- Card Call -->
                <div class="card-body">
                    <!-- number -->
                    <div class="d-flex justify-content-center bg-opacity-50">
                        <div class="row">
                            <!-- <div class="col-2">
                                <a href="<?php echo site_url('dashboard/callPrev'); ?>" class="btn btn-lg selanjutnya" type="submit">
                                    <span class=""></span>
                                    <i class="bi bi-arrow-left-square-fill fs-1"></i>
                                </a>
                            </div> -->
                            <div class="col bg-light text-center rounded-2 border mx-4">
                                <h1 class="fw-bold" style="font-size: 100px;">
                                    <?= $antrianNow; ?>
                                </h1>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center pt-4 mb-4">
                        <a href="<?php echo site_url('dashboard/callPrev'); ?>" class="btn btn-lg" type="submit">
                            <i class="bi bi-arrow-left-square-fill fs-1"></i>
                        </a>
                        <button class="btn btn-warning btn-lg mb-2" onclick="callAudio()" id="callButton" disabled>Panggil<i class="bi bi-mic-fill ps-2"></i>
                        </button>
                        <a href="<?php echo site_url('dashboard/callNext'); ?>" class="btn btn-lg" type="submit">
                            <i class="bi bi-arrow-right-square-fill fs-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-footer mb-4">
                    <label for="no_antrian" class="fw-bold pb-2" disabled>Panggil Ulang</label>
                    <form id="recallForm" method="post" action="<?= site_url('home/recall') ?>">
                        <div class="d-flex">
                            <input type="number" id="input_panggil" name="input_panggil" class="form-control form-control-lg me-2" placeholder="Nomor Antrian" min="1" required>
                            <button type="submit" class="btn btn-warning col-3 fs-4" onclick="recall()" id="inputPanggil" disabled><i class="bi bi-mic-fill"></i></button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Add event listener to the button
    document.addEventListener("keydown", function(event) {
        // Check if the pressed key is "1" and prevent default behavior
        if (event.key === "`") {
            event.preventDefault();
            // Trigger the click event for the button
            document.getElementById("printBtn").click();
        }
    });

    // Your existing JavaScript code for autoPrint function
    function autoPrint() {
        printJS(); // This will trigger the print without showing the browser's print settings dialog
    }

    // Add event listener to the button
    document.getElementById("printBtn").addEventListener("click", autoPrint);

    // Call
    // var callButton = document.getElementById('call');
    // var recallButton = document.getElementById('recall');
    // var audioElement = document.getElementById('audioElement');

    // function playAudio(id, delay) {
    //     setTimeout(function() {
    //         var audio = document.getElementById(id);
    //         audio.pause();
    //         audio.currentTime = 0;
    //         audio.play();
    //     }, delay);
    // }

    function call1() {
        callButton.disabled = true;

        // Your existing code for panggil() goes here

        playAudio('suarabel', 0);

        // Set initial totalWaktu
        var totalWaktu = document.getElementById('suarabel').duration * 1000;

        playAudio('suarabelnomorurut', totalWaktu);
        totalWaktu += 1400;

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
            totalWaktu += 1000;
            playAudio('puluh', totalWaktu);
            totalWaktu += 1000;
        <?php } else if ($antrian > 20 && $antrian < 100) { ?>
            playAudio('antrian', totalWaktu);
            totalWaktu += 1000;
            playAudio('puluh', totalWaktu);
            totalWaktu += 1000;
            playAudio('antrian1', totalWaktu);
            totalWaktu += 1000;
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

        totalWaktu += 1400;
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

    $(document).ready(function() {
        // Panggil AJAX untuk mendapatkan nomor antrian dan putar audio
        $('#callButton').on('click', function(e) {
            e.preventDefault();

            $.ajax({
                url: '<?php echo site_url('home/call'); ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Update nomor antrian di halaman dashboard.php
                    $('#nomorAntrianDisplay').html(response.nomor_antrian);

                    // Panggil fungsi playAudio untuk memainkan audio sesuai dengan nomor antrian
                    playAudio('suarabel', 0, function() {
                        // Logika bermain audio nomor antrian sesuai dengan kebutuhan
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        function playAudio(id, delay, callback) {
            // AJAX untuk memicu pemutaran audio di halaman display
            $.ajax({
                url: '<?php echo site_url('home/callAudio'); ?>',
                type: 'POST',
                data: {
                    audioId: id,
                    delay: delay
                },
                success: function(response) {
                    if (typeof callback === 'function') {
                        callback();
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    });

    function recall() {
        // Get form data
        var formData = $('#recallForm').serialize();

        // AJAX request
        $.ajax({
            type: 'POST',
            url: '<?= base_url('home/recall') ?>',
            data: formData,
            success: function(response) {
                // Handle success response here
                console.log(response);
            },
            error: function(error) {
                // Handle error response here
                console.error(error);
            }
        });
    }

    // document.getElementById('antrianForm').addEventListener('submit', function(event) {
    //     // Prevent the form from navigating to a new page
    //     event.preventDefault();

    //     // Submit the form
    //     this.submit();

    //     // Trigger print
    //     void window.print();

    //     // Redirect to the dashboard (adjust the URL as needed)
    //     window.location.href = '<?= site_url('dashboard') ?>';
    // });

    $(document).ready(function() {
        $('#antrian-list').DataTable();
    });

    $(document).ready(function() {
        var table = $('#antrianTable');
        var searchInput = $('#search');
        var originalData = []; // Store a copy of the original data

        // Populate originalData with initial table content
        table.find('tbody tr').each(function() {
            var row = $(this);
            var rowData = [];
            row.find('td').each(function() {
                rowData.push($(this).text().toLowerCase());
            });
            originalData.push(rowData);
        });

        searchInput.keyup(function() {
            var searchText = searchInput.val().toLowerCase();

            table.find('tbody tr').each(function(index) {
                var row = $(this);
                var rowData = originalData[index];
                var found = false;

                rowData.forEach(function(cellText) {
                    if (cellText.indexOf(searchText) !== -1) {
                        found = true;
                        return false; // exit the loop
                    }
                });

                if (found) {
                    row.show();
                } else {
                    row.hide();
                }
            });
        });
    });

    // Auto-submit the form when the input date changes
    document.getElementById('date_visit_show').addEventListener('input', function() {
        document.getElementById('dateForm').submit();
    });

    const dateInput = document.getElementById("date_visit_show");
    dateInput.addEventListener("click", function() {
        dateInput.click(); // Open the date picker
    });

    $(function() {
        $("#datepicker").datepicker({
            dateFormat: 'dd-mm-yyyy'
        });
    });

    // function callAudio() {
    //     // Set the trigger flag
    //     localStorage.setItem('triggerCall', 'true');

    //     // Update content on the current page without a full reload
    //     $.ajax({
    //         type: 'GET',
    //         url: '<?= site_url('home/display_audio') ?>',
    //         success: function(data) {
    //             // Replace the content of a specific element with the retrieved data
    //             $('#display').html(data);
    //         },
    //         error: function(error) {
    //             console.error('Error:', error);
    //         }
    //     });
    // }
    // Using jQuery for simplicity, but you can use native XMLHttpRequest or other libraries
    $("#triggerCall").click(function() {
        // Send an AJAX request to the server
        $.ajax({
            url: "display.php", // Replace with the actual server-side script URL
            method: "POST", // or "GET" depending on your server-side logic
            data: {
                action: "trigger_call"
            }, // You can send additional data if needed
            success: function(response) {
                // Handle the server's response if necessary
                console.log(response);
            },
            error: function(error) {
                console.error("Error:", error);
            }
        });
    });
</script>