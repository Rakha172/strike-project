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
    var dataTotalIkan = @json($dataTotalIkan);
    var dataIkanSpecial = @json($dataIkanSpecial);

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Jumlah Ikan',
                    data: dataTotalIkan,
                    backgroundColor: '#008000', // green
                    borderColor: '#008000',
                    borderWidth: 1
                },
                {
                    label: 'Ikan Special',
                    data: dataIkanSpecial,
                    backgroundColor: '#000080', // Navy
                    borderColor: '#000080',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                datalabels: {
                    align: 'center',
                    anchor: 'center',
                    color: 'black',
                    font: {
                        weight: 'bold',
                        size: 12
                    },
                    formatter: function(value, context) {
                        return value; // Menampilkan nilai data di tengah batang
                    }
                }
            }
        }
    });
</script>
@endsection
