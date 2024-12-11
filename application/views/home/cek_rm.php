<!-- Cek RM -->
<div class="row mx-2">
    <div class="col-lg-6 col-md-12 col-sm-12 col-12 p-2 bg-light">
        <div class="card p-4">
            <h4 class="mb-3 text-decoration-underline fw-bold">Mohon diperhatikan</h4>
            <ol class=''>
                <li class="mb-2">Pastikan bahwa anda sudah terdaftar dan mempunyai Nomor Rekam Medis di RSUD Caruban.</li>
                <li class="mb-2">Pastikan nomor NIK (KTP) anda sudah sesuai dengan data diri anda.</li>
                <li class="mb-2">Bagi Pasien baru / belum memiliki Nomor Rekam Medis di RSUD Caruban diharapkan melakukan pendaftaran di tempat.</li>
            </ol>
            <div>
                <a href="<?= base_url() ?>" class="btn btn-sm btn-secondary"><i class="bi bi-chevron-left pe-2"></i>Kembali ke Halaman Utama</a>
            </div>
        </div>
    </div>
    <!-- Menu -->
    <div class="col-lg-6 col-md-12 col-sm-12 col-12 p-2 bg-light order-first order-lg-1">
        <div class="d-flex justify-content-center">
            <div class="card p-2 col-12">
                <div class="card-body">
                    <form action="<?= base_url('home/cek_rm'); ?>" method="post">
                        <h4 class="mb-4 fw-bold text-center">Cek Nomor Rekam Medis</h4>

                        <div class="row mx-1 pt-2">
                            <div class="card p-4 col-12">
                                <input type="text" class="form-control form-control-lg" placeholder="Ketikkan NIK Anda" name="nik" id="nik" value="<?= set_value('nik') ?>">
                                <button class="btn btn-lg btn-primary text-center float-end my-2" type="submit" name="cek_rm" id="cek_rm">
                                    <span id="btn-text" class="">Cek RM<i class="bi bi-search ps-2"></i></span>
                                </button>

                                <?= form_error('nik', '<small class="text-danger">', '</small>') ?>
                            </div>
                        </div>
                    </form>

                    <form action="<?= base_url('antrian/nomor_antrian') ?>" method="post" id="antrianForm">
                        <div class="row mx-1 my-4">
                            <!-- Alert -->
                            <?php if ($this->session->flashdata('data_message')) : ?>
                                <div class="alert alert-danger">
                                    <?= $this->session->flashdata('data_message'); ?>
                                    <a href="<?= base_url(); ?>home/registrasi" class="fw-bold fts-italic d-none">DAFTAR PASIEN BARU</a>
                                </div>
                            <?php endif; ?>
                            <!-- Alert -->
                            <?php if ($this->session->flashdata('error_message')) : ?>
                                <div class="alert alert-danger">
                                    <?= $this->session->flashdata('error_message'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="card p-4 col-12">
                                <input class="form-control form-control-lg text-muted fw-bold mb-2 bg-light" type="text" name="norm" id="norm" placeholder="NOMOR RM ANDA" value="<?= isset($norm) ? $norm : ''; ?>" aria-label="Disabled input example" readonly>

                                <input class="form-control form-control-lg text-muted fw-bold mb-2 bg-light" type="text" name="name" id="name" placeholder="NAMA ANDA" value="<?= isset($name) ? $name : ''; ?>" aria-label="Disabled input example" readonly>

                                <input class="form-control form-control-lg text-muted fw-bold" type="date" name="date_visit" id="date_visit" value="<?= date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+2 days')); ?>" required style="display: none;" onfocus="this.showPicker()" disabled>

                                <button type="submit" class="btn btn-success btn-lg text-center my-2" disabled>
                                    Ambil Antrian<i class="bi bi-printer-fill ps-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    // Get references to the "norm" and "name" input fields
    var normInput = document.getElementById('norm');
    // var nameInput = document.getElementById('name');

    // Get a reference to the date input field
    var dateInput = document.getElementById('date_visit');

    // Add event listeners to the "norm" and "name" input fields
    normInput.addEventListener('input', toggleDateInput);
    // nameInput.addEventListener('input', toggleDateInput);

    // Function to show/hide the date input
    function toggleDateInput() {
        // Check if both "norm" and "name" fields are filled
        if (normInput.value.trim() !== '') {
            dateInput.style.display = 'block'; // Show the date input
        } else {
            dateInput.style.display = 'none'; // Hide the date input
        }
    }
    toggleDateInput();

    function submitForm() {
        // Enable disabled/readonly inputs before submitting the form
        document.getElementById('norm').disabled = false;
        document.getElementById('name').disabled = false;

        // Submit the form
        document.getElementById('antrianForm').submit();

        // Optionally, re-disable the inputs after submission
        document.getElementById('norm').disabled = true;
        document.getElementById('name').disabled = true;
    }

    // Disable weekends and holidays
    document.addEventListener('DOMContentLoaded', function() {
        var dateInput = document.getElementById('date_visit');

        // Fetch holidays from the "date.nager.at" API for Indonesia
        fetch('https://date.nager.at/api/v3/PublicHolidays/2023/id')
            .then(response => response.json())
            .then(holidays => {
                // Add event listener to date input on change
                dateInput.addEventListener('change', function() {
                    // Get the selected date
                    var selectedDate = new Date(dateInput.value);

                    // Check if the selected date is a weekend (Saturday or Sunday)
                    if (selectedDate.getDay() === 0 || selectedDate.getDay() === 6) {
                        alert('Pendaftaran pada hari Sabtu dan Minggu ditutup. Pilih hari Senin - Jumat');
                        dateInput.value = ''; // Clear the input value
                        return;
                    }

                    // Check if the selected date is a national holiday
                    var formattedDate = selectedDate.toISOString().split('T')[0];
                    if (holidays.some(holiday => holiday.date === formattedDate)) {
                        alert('Pendaftaran pada hari Libur Nasional ditutup. Silahkan pilih tanggal lainnya');
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
</script>

<!-- End Cek RM -->