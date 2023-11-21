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
    var dataWeightTotal = @json($dataWeightTotal);
    var dataTotalIkan = @json($dataTotalIkan);

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Weight Total',
                    data: dataWeightTotal,
                    backgroundColor: '#FF0000', // Red
                    borderColor: '#FF0000',
                    borderWidth: 1
                },
                {
                    label: 'Jumlah Ikan',
                    data: dataTotalIkan,
                    backgroundColor: '#008000', // green
                    borderColor: '#008000',
                    borderWidth: 1
                },
            ]
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
