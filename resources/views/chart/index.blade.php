<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <canvas id="myChart">Adam</canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');

        var data = {
            labels: ['Adam', 'Rafly', 'Sidiq', 'Keyza', 'Azzam'],
            datasets: [{
                label: 'Leaderboard Weight',
                data: [100, 60, 75, 90, 70],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: data
        });
    </script>
</body>
</html>
