@extends('componen.layout')

@section('content')

<a href="{{ route('events.chart-total', $event) }}" class="btn btn-primary"><span>Total</span></a>
&nbsp; &nbsp;
<a href="{{ route('events.chart-special', $event)}}" class="btn btn-primary"><span>Special</span></a>
&nbsp; &nbsp;
<a href="{{ route('events.chart-combined', $event)}}" class="btn btn-primary"><span>Combined</span></a>
&nbsp; &nbsp;
<a href="{{ route('events.chart-result-and-special', $event)}}" class="btn btn-primary"><span>Weight Special</span></a>
&nbsp; &nbsp;
<a href="{{ route('events.chart-result-and-total', $event)}}" class="btn btn-primary"><span>Weight Total</span></a>

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
            }
        }
    });
</script>
@endsection