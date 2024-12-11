<!-- DataTables -->
<script type="text/javascript" src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<!-- Time -->
<script>
    // Format Angka
    // function updateWaktu() {
    //     const time = document.getElementById("waktu-wib");
    //     const waktuSekarang = new Date().toLocaleString('en-US', {
    //         timeZone: 'Asia/Jakarta'
    //     });
    //     time.textContent = waktuSekarang;
    // }

    // setInterval(updateWaktu, 1000); // Perbarui setiap 1 detik

    // Format Bulan
    function updateWaktu() {
        const time = document.getElementById("waktu-wib");
        const now = new Date();
        const options = {
            year: "numeric",
            month: "long",
            day: "numeric",
            hour: "2-digit",
            minute: "2-digit",
            timeZoneName: "short",
            hour12: false,
        };
        const formatter = new Intl.DateTimeFormat("id-ID", options);
        const formattedDate = formatter.format(now);
        time.textContent = formattedDate;
    }
    setInterval(updateWaktu, 1000); // Perbarui setiap 1 detik
</script>


<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>

</html>