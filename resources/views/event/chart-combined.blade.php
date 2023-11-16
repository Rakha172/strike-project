@extends('componen.layout')

@section('content')

<div style="display: flex; justify-content: flex-start;">
    <div style="flex: 1;">
        <canvas id="myChart"></canvas>
        <div id="chart"></div>
    </div>
</div>

<!-- Tambahkan skrip Chart.js dan plugin datalabels -->
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

{{-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script> --}}

<script>
    var labels = @json($labels);
    var dataWeightTotal = @json($dataWeightTotal);
    var dataIkanSpecial = @json($dataIkanSpecial); // Variabel untuk data "jumlah ikan"
    var dataTotalIkan = @json($dataTotalIkan); // Variabel untuk data "ikan special"


    var options = {
    series: [
        {
            name: 'Weight Total',
            data: dataWeightTotal,
        },
        {
            name: 'Ikan Special', // Nama series untuk data "ikan special"
            data: dataIkanSpecial, // Masukkan data "ikan special" ke dalam series
        }
        {
            name: 'Jumlah Ikan', // Nama series untuk data "Jumlah ikan"
            data: dataTotalIkan, // Masukkan data "jumlah ikan" ke dalam series
        }
    ],
          chart: {
          height: 350,
          type: 'bar',
        },
        plotOptions: {
          bar: {
            borderRadius: 10,
            dataLabels: {
              position: 'top', // top, center, bottom
            },
          }
        },
        dataLabels: {
          enabled: true,
          formatter: function (val) {
            return val;
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#304758"]
          }
        },

        xaxis: {
          categories: labels,
          position: 'top',
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
          },
          crosshairs: {
            fill: {
              type: 'gradient',
              gradient: {
                colorFrom: '#D8E3F0',
                colorTo: '#BED1E6',
                stops: [0, 100],
                opacityFrom: 0.4,
                opacityTo: 0.5,
              }
            }
          },
          tooltip: {
            enabled: true,
          }
        },
        yaxis: {
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: false,
            formatter: function (val) {
              return val;
            }
          }

        },
        title: {
          text: '',
          floating: true,
          offsetY: 330,
          align: 'center',
          style: {
            color: '#444'
          }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();

</script>
@endsection
