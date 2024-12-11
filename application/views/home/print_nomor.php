<div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Print Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- <div class="row mx-2"> -->
                <!-- Print -->
                <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 p-4 bg-light"> -->
                <div class="card">
                    <div id="cetakAntrian" class="mx-auto">
                        <div class="d-flex justify-content-center text-center m-4 bg-light">
                            <div id="printContent" name="printContent" class="col-8 py-1 border border-2 border-dark ticket-print" style="width: 280px; height: 360px;">
                                <div class="text-center m-2">
                                    <small class="fw-bold text-muted" style="font-size: 10px;">- LOKET PENDAFTARAN RSUD CARUBAN -</small>
                                    <h4 class="fw-bold">NOMOR ANTRIAN</h4>
                                    <label style="font: bold 80px arial, sans-serif">
                                        <?= $no_antrian ?>
                                    </label>
                                </div>
                                <div class="mx-auto p-2" style="font-size: 14px;">
                                    <div class="row px-1">
                                        <div class="col-5" align="left">Nomor RM :</div>
                                        <div class="col-7" align="right"><?= $no_rm ?></div>
                                    </div>
                                    <div class="row px-1">
                                        <div class="col-4" align="left">Nama :</div>
                                        <div class="col-8" align="right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <?= $name ?></div>
                                    </div>
                                    <div class="row px-1">
                                        <div class="col-6" align="left">Waktu Pelayanan :</div>
                                        <div class="col-6 fw-bold" align="right">
                                            <?= $waktu_pelayanan; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row px-4">
                                    <div class="border border-dark border-1">
                                        <div class="fw-bold text-center" style="font-size: 10px;">Tanggal Kunjungan</div>
                                        <h6 class="text-center fw-bold" style="font-size: 18px;">
                                            <!-- <?= $tickets[0]->date_visit ?> -->
                                            <?= $date_visit ?>
                                        </h6>
                                    </div>
                                    <div class="text-center py-2">
                                        <p class="fst-italic" style="font-size: 10px;">Wajib hadir sesuai jam layanan yang tertera. <br>Apabila nomor anda terlewatkan, <br>dimohon menunggu 3 nomor berikutnya</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mx-4 rounded float-end mb-4">
                            <a href="<?= base_url('dashboard/') ?>" class="btn btn-lg btn-secondary"><i class="bi bi-chevron-left pe-2"></i>Dashboard</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="<?= base_url('dashboard/') ?>" class="btn btn-primary"><i class="bi bi-chevron-left pe-2"></i>Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="col-12">
        <small id="countdown" class="fst-italic text-warning ps-2"></small>
    </div> -->
<!-- <div class="bg-dark m-4" style="height: 2px; width: 100%"></div> -->
</div>
<!-- End Cetak Antrian v2 -->

<!-- Download Jpg -->
<script type="text/javascript">
    // Use setTimeout to delay the redirect
    setTimeout(function() {
        window.location.href = "<?= site_url('dashboard/'); ?>";
    }, 1000); // 3000 milliseconds = 3 seconds

    // Trigger print when the page loads
    // window.onload = function() {
    //     printTicket();
    // };

    // function printTicket() {
    //     var printContent = document.getElementById("printContent").outerHTML;
    //     var printWindow = window.open('');

    //     printWindow.document.open();
    //     printWindow.document.write('<html><head><title>Print Antrian</title>');

    //     // Copy the styles to the print window
    //     var styles = document.getElementsByTagName('style');
    //     for (var i = 0; i < styles.length; i++) {
    //         printWindow.document.write(styles[i].outerHTML);
    //     }

    //     // Include external stylesheets
    //     var links = document.getElementsByTagName('link');
    //     for (var i = 0; i < links.length; i++) {
    //         if (links[i].rel === 'stylesheet') {
    //             printWindow.document.write('<link rel="stylesheet" type="text/css" href="' + links[i].href + '">');
    //         }
    //     }

    //     printWindow.document.write('</head><body>');
    //     printWindow.document.write(printContent);
    //     printWindow.document.write('</body></html>');
    //     printWindow.document.close();

    //     printWindow.print();
    // }

    // Auto Print
    // Trigger print when the page loads
    window.onload = function() {
        printTicket();
    };

    function printTicket() {
        var printContent = document.getElementById("printContent").outerHTML;

        // Create a hidden iframe
        var iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        document.body.appendChild(iframe);

        // Copy the content to the iframe
        iframe.contentDocument.open();
        iframe.contentDocument.write('<html><head><title>Print Antrian</title>');

        // Copy the styles to the iframe
        var styles = document.getElementsByTagName('style');
        for (var i = 0; i < styles.length; i++) {
            iframe.contentDocument.write(styles[i].outerHTML);
        }

        // Include external stylesheets
        var links = document.getElementsByTagName('link');
        for (var i = 0; i < links.length; i++) {
            if (links[i].rel === 'stylesheet') {
                iframe.contentDocument.write('<link rel="stylesheet" type="text/css" href="' + links[i].href + '">');
            }
        }

        iframe.contentDocument.write('</head><body>');
        iframe.contentDocument.write(printContent);
        iframe.contentDocument.write('</body></html>');
        iframe.contentDocument.close();

        // Print the content in the iframe
        iframe.contentWindow.print();

        // Remove the iframe after printing
        document.body.removeChild(iframe);
    }

    function printHtmlToPdf() {
        var element = document.getElementById("printContent"); // Replace with the ID of the HTML content you want to print

        html2pdf(element);
    }

    document.getElementById('antrianForm').addEventListener('submit', function(event) {
        // Prevent the form from navigating to a new page
        event.preventDefault();

        // Submit the form
        this.submit();

        // Trigger print
        window.print();

        // Redirect to the dashboard (adjust the URL as needed)
        window.location.href = '<?= site_url('dashboard') ?>';
    });

    // Redirect Home
    setTimeout(function() {
        window.location.href = "<?= base_url('dashboard/') ?>"; // Redirect to 'home' after 15 seconds
    }, 5000); // 15000 milliseconds = 15 seconds

    // Countdown
    var countdown = 5; // Countdown in seconds
    var countdownElement = document.getElementById("countdown");

    function updateCountdown() {
        if (countdown > 0) {
            countdownElement.textContent = "Kembali ke Dashboard Loket" + countdown + " detik";
            countdown--;
            setTimeout(updateCountdown, 1000); // Update every 1 second
        } else {
            window.location.href = "<?= base_url('dashboard/') ?>"; // Redirect to 'home' after the countdown
        }
    }

    // Start the countdown
    updateCountdown();

    // function autoPrint() {
    // // Generate your print content
    // var printContent = document.getElementById("printContent").outerHTML;

    // // Open a new print window
    // var printWindow = window.open('', '_blank');

    // // Write the HTML content to the print window
    // printWindow.document.open();
    // printWindow.document.write('<html>
    // printWindow.document.close();

    // // Trigger the print function after a short delay to ensure content is loaded
    // setTimeout(function() {
    // printWindow.print();
    // printWindow.onafterprint = function() {
    // // Close the print window after printing
    // printWindow.close();
    // };
    // }, 500);
    // }
</script>

</body>

</html>