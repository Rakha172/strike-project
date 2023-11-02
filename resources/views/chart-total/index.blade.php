@extends('componen.layout')

@section('content')
<div style="display: flex; justify-content: flex-start;">
    <div style="flex: 1;">
        <canvas id="myChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var labels = @json($labels);
    var fishTotals = @json($fish_totals);

    // Mencari indeks data dengan jumlah fish_total terbanyak
    var maxFishTotalIndex = fishTotals.indexOf(Math.max(...fishTotals));

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Fish Total',
                data: fishTotals,
                backgroundColor: '#b6410f', // Navy
                borderColor: '#b6410f',
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
</script>
@endsection
