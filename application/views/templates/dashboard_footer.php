</div>

<script>
    $(function() {
        $("#datepicker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            icons: {
                time: "bi bi-clock-o",
                date: "bi bi-calendar",
                up: "bi bi-arrow-up",
                down: "bi bi-arrow-down",
                previous: "bi bi-chevron-left",
                next: "bi bi-chevron-right",
                today: "bi bi-clock-o",
                clear: "bi bi-trash-o",
            }
        });

        // Initialize the date picker with the current date
        $("#datepicker").datepicker('setDate', new Date());

        $('.datepicker').datepicker({
            format: 'DD/MM/YYYY HH:mm',
            useCurrent: true,
            showTodayButton: true,
            showClear: true,
            toolbarPlacement: 'bottom',
            sideBySide: true,
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                previous: "fa fa-chevron-left",
                next: "fa fa-chevron-right",
                today: "fa fa-clock-o",
                clear: "fa fa-trash-o",
            },
        });
    });


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
<!-- Datatables Js -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>

</html>