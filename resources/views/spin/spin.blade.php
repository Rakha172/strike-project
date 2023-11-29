<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="viewport" content="width=device-width" />
        <!-- Required library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <!-- Bootstrap theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="spin.css">
        <title>gagachaan</title>
      </head>
      <body>
        <div class="container">
            <h4 align="center">Mendapatkan Nomor Lapak</h4>
            <div class="row">
                <div class="col-xs-12" align="center">
                    <div id="wheel">
                        <canvas id="canvas" width="260" height="260"></canvas>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6" align="center">
                    <button type="button" class="btn btn-success" onclick="spin()">Spin Now!</button>
                </div>
                <div class="col-xs-6" align="center">
                    <button type="button" id="stop" class="btn btn-info" onclick="stops()">Stop Now!</button>
                </div>
            </div>

        <script src="js/spin.js">


        </script>
    </body>
</html>
