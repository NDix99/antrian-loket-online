</div>

<script>
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
</body>

</html>