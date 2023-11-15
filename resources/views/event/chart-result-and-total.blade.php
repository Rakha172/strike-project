@extends('componen.layout')

@section('content')

<a href="{{ route('events.chart-result', $event) }}" class="btn btn-primary"><span>Result</span></a>
&nbsp; &nbsp;
<a href="{{ route('events.chart-total', $event) }}" class="btn btn-primary"><span>Total</span></a>
&nbsp; &nbsp;
<a href="{{ route('events.chart-special', $event)}}" class="btn btn-primary"><span>Special</span></a>
&nbsp; &nbsp;
<a href="{{ route('events.chart-combined', $event)}}" class="btn btn-primary"><span>Combined</span></a>
&nbsp; &nbsp;
<a href="{{ route('events.chart-result-and-special', $event)}}" class="btn btn-primary"><span>Weight Special</span></a>
&nbsp; &nbsp;
<a href="{{ route('events.chart-result-and-total-special', $event)}}" class="btn btn-primary"><span>Total Special</span></a>

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
