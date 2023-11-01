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
    var weights = @json($weights);
    var fishTotals = @json($fish_totals);

    // Mencari indeks data dengan jumlah fish_total terbanyak
    var maxFishTotalIndex = fishTotals.indexOf(Math.max(...fishTotals));

    // Mencari indeks data dengan weight terbanyak
    var maxWeightIndex = weights.indexOf(Math.max(...weights));

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Fish Total',
                data: fishTotals,
                backgroundColor: '#17395c', // Navy
                borderColor: '#17395c',
                borderWidth: 1
            }, {
                label: 'Weight',
                data: weights,
                backgroundColor: '#efb758', // Warna kuning
                borderColor: '#efb758',
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
