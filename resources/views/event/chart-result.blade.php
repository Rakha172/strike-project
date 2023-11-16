@extends('componen.layout')

@section('content')

<div style="display: flex; justify-content: flex-start;">
    <div style="flex: 1;">
        <canvas id="myChart"></canvas>
    </div>
</div>

<!-- Tambahkan skrip Chart.js dan plugin datalabels -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>
    var labels = @json($labels);
    var data = @json($data);

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Weight Total',
                data: data,
                backgroundColor: '#FF0000', // Red
                borderColor: '#FF0000',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                datalabels: {
                    color: 'black', // Warna teks label
                    anchor: 'end',
                    align: 'end',
                    font: {
                        weight: 'bold'
                    },
                    formatter: function(value, context) {
                        return value; // Sesuaikan format nilai sesuai kebutuhan Anda
                    }
                }
            }
        }
    });
</script>
@endsection
