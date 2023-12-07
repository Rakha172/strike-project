<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Scanner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-color: #2D9596;
            color: #fff;

            .container {
                margin-top: 50px;
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                padding: 20px;
            }

            .card {
                background-color: #2D9596;
                color: #fff;
            }

            table {
                background-color: #fff;
            }
    </style>
</head>

<body>
    <div class="container col-lg-4 py-5">
        {{-- Pesan Peringatan --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-danger">
                {{ session('warning') }}
            </div>
        @endif

        <div class="col-auto">
            <form action="{{ url('/eventsop') }}">
                <button type="submit" class="btn btn-dark m-1">Back</button>
            </form>
        </div>
        <div class="card shadow rounded-3 p-3 border-0">
            <p class="text-center mb-3" style="color: #000000;">Scan here</p>
            <video id="preview" playsinline autoplay muted style="width: 100%;"></video>
            <form action="{{ route('operator.scan') }}" method="POST" id="form">
                @csrf
                <input type="hidden" name="event_registration_id" id="event_registration_id">
            </form>
        </div>

    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function() {
    let scanner = new Instascan.Scanner({
        video: document.getElementById('preview')
    });

    Instascan.Camera.getCameras().then(function(cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            console.error('No cameras found.');
        }
    }).catch(function(e) {
        console.error(e);
    });

    scanner.addListener('scan', function(c) {
        // Update the hidden input field with the scanned content
        document.getElementById('event_registration_id').value = c;

        // Submit the form
        document.getElementById('form').submit();
    });
});



    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
