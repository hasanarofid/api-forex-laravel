<!-- resources/views/home.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <script src="https://cdn.jsdelivr.net/npm/jquery"></script> <!-- Load jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="myChart" width="400" height="400"></canvas>
    
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route("fetch-and-save-ratios") }}',
                type: 'GET',
                success: function(response) {
                    console.log(response.message); // Tampilkan pesan dari server
                    // Perbarui grafik setelah berhasil mengambil dan menyimpan data
                    updateChart();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Tampilkan pesan error
                }
            });

            function updateChart() {
                var ctx = document.getElementById('myChart').getContext('2d');
                var labels = @json($ratios->pluck('pair'));
                var longData = @json($ratios->pluck('long'));
                var shortData = @json($ratios->pluck('short'));

                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Long',
                            data: longData,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }, {
                            label: 'Short',
                            data: shortData,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
