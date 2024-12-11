<?php
$today = date('d F Y');
$dateInput = date('d F Y', strtotime($this->input->post('date_visit_show')));
?>

<!-- Container fluid -->
<div class="container-fluid">
    <div class="row m-2 p-4 bg-light rounded-2">
        <!-- Tabel Antrian -->
        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12 mx-auto">
            <!-- card  -->
            <div class="card mt-2 px-4 border border-success">
                <!-- card header  -->
                <div class="card-header bg-white py-4">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <h4 class="fw-bold">Tabel Data Antrian</h4>
                        </div>
                        <!-- Search Form -->
                        <!-- <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <form method="post" action="<?= base_url('dashboard/data_antrian') ?>">
                                <div class="d-flex input-group">
                                    <input type="text" class="form-control" name="keyword" placeholder="Cari Nomor / Nama / RM" id="search" value="<?= set_value('keyword') ?>" autocomplete="off">
                                    <button type="submit" name="submit" class="btn btn-success" id="button-addon2"><i class="bi bi-search"></i></button>
                                </div>
                            </form>
                        </div> -->
                    </div>
                </div>
                <div class="card-body">
                    <!-- Table  -->
                    <div class="table-responsive">
                        <table id="tabel-antrian" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No. Antrian</th>
                                    <th>No. RM</th>
                                    <th>Nama</th>
                                    <th>Tanggal Kunjungan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($antrianData) && is_array($antrianData)) {
                                    foreach ($antrianData as $antri) : ?>
                                        <tr>
                                            <td><?= $antri['no_antrian'] ?></td>
                                            <td><?= $antri['no_rm'] ?></td>
                                            <td><?= $antri['name'] ?></td>
                                            <td><?= date('d F Y', strtotime($antri['date_visit'])) ?></td>
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
            </div>
            <!-- Pagination links -->
            <!-- <div class="pt-2 mx-auto">
                    <?= $pagination; ?>
                </div> -->
        </div>
        <div class="col-xl-4 col-lg-4 col-lg-4 col-md-12 col-xs-12 mx-auto order-first">
            <div class="row mt-2">
                <!-- Status Card -->
                <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-xs-12">
                    <!-- card -->
                    <div class="card mb-4 border border-success">
                        <!-- card body -->
                        <div class="card-body">
                            <!-- heading -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <h5 class="fw-bold">Jumlah Antrian</h5>
                                </div>
                                <div class="icon-shape icon-md bg-light-primary rounded-2">
                                    <i class="bi bi-people-fill fs-4"></i>
                                </div>
                            </div>
                            <h1 class="fw-bold"><?= $antrianTotal ?></h1>
                            <small>
                                <?= $antrianDate; ?>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-xs-12">
                    <!-- <form action="<?= site_url('antrian/getTotalAntrian'); ?>" method="post" id="dateForm">
                    <div class="card p-4 mt-2">
                        <h4 class="card-title fw-bold mb-3">Cek Jumlah Antrian</h4>
                        <div class="row" id="jumlah_antrian_result">
                            <div class="col-12 pe-2">
                                <label for="date_visit_show" class="pb-2">Pilih tanggal :</label>
                                <input type="date" id="date_visit_show" name="date_visit_show" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+2 days')); ?>" value="" class="datepicker form-control form-control-lg text-muted" onfocus="this.showPicker()">
                            </div>
                            <div class="col-12 mt-sm-2 mt-xs-2">

                            </div>
                        </div>
                    </div>
                </form> -->
                    <form action="<?= site_url('dashboard/data_antrian') ?>" method="post" id="dateForm">
                        <h4 class="fw-bold">Pilih Tanggal</h4>
                        <input type="date" id="date_visit_show" name="date_visit_show" class="datepicker form-control form-control-lg border border-success" min="<?= date('Y-m-d', strtotime('-7 days')); ?>" max="<?= date('Y-m-d', strtotime('+2 days')); ?>" value="<?= set_value('date_visit_show'); ?>" onfocus="this.showPicker()">
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

<script type="text/javascript">
    // Datatables
    // $(document).ready(function() {
    //     $('#tabel-antrian').DataTable({
    //         "paging": true,
    //         "searching": true,
    //         "ajax": {
    //             "url": "",
    //             "type": "POST"
    //         },
    //         "columns": [{
    //                 "data": "no_antrian"
    //             },
    //             {
    //                 "data": "no_rm"
    //             },
    //             {
    //                 "data": "name"
    //             },
    //             {
    //                 "data": "date_visit"
    //             }
    //         ]
    //     })
    // });

    $(document).ready(function() {
        $('#tabel-antrian').DataTable({});
    });
    // "processing": true,
    // "serverSide": true,
    // "order": [],
    // "ajax": {
    //     "url": "<?= base_url('loket/get_data') ?>",
    //     "type": "POST"
    // },
    // 'columnDefs': [{
    //     'target': [-1],
    //     'orderable': false
    // }]
    // });
    // });

    // Search
    $(document).ready(function() {
        // Reference to the table and input field
        var table = $('#data-antrian');
        var searchInput = $('#keyword');

        // Add an event listener to the input field
        searchInput.keyup(function() {
            var searchText = $(this).val().toLowerCase();

            // Iterate through each row in the table
            table.find('tbody tr').each(function() {
                var row = $(this);

                // Check if any cell contains the search text
                var cells = row.find('td');
                var found = false;
                cells.each(function() {
                    var cellText = $(this).text().toLowerCase();
                    if (cellText.indexOf(searchText) !== -1) {
                        found = true;
                        return false; // exit the loop
                    }
                });

                // Show/hide the row based on search result
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
</script>