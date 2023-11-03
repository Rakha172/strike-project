@extends('componen.layout')

@section('content')

<a href="{{ route('events.chart-result', $event)}}" class="btn btn-primary"><span>Result</span></a>
&nbsp; &nbsp;
<a href="{{ route('events.chart-total', $event) }}" class="btn btn-primary"><span>Total</span></a>
&nbsp; &nbsp;
<a href="{{ route('events.chart-combined', $event)}}" class="btn btn-primary"><span>Combined</span></a>

<div style="display: flex; justify-content: flex-start;">
    <div style="flex: 1;">
        <canvas id="myChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var labels = @json($labels);
    var data = @json($data);

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Ikan Specials',
                data: data,
                backgroundColor: '#000080', // Navy
                borderColor: '#000080',
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
