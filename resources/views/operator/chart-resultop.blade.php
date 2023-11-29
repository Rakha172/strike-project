<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Operator</title>
    <link rel="stylesheet" href="{{ asset('css/operator.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<body>
    <div class="containerop">
        <nav class="wrapperop">
            <div class="brandop">
                <div class="firstname">Strike</div>
                <div class="lastname">Project</div>
            </div>
            <center>
                <h2 class="hlop">Halaman Operator</h2>
            </center>
            <ul class="nav">
                <form action="{{ url('/eventsop') }}">
                    <button class="button button1" style="color: white">Kembali</button>
                </form>
            </ul>
        </nav><br><br>

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
            var data = @json($data);

            var options = {
                  series: [{
                  name: 'Weight Quantity',
                  data: data,
                }],
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
                colors: ['#FF0000'], // warna bar
                xaxis: {
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
                  text: 'Weight Total',
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

    </div>
</body>
</html>
