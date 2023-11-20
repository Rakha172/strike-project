<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>{{$title->name}} | Event Registration</title>
</head>
  <body>
    @extends('componen.layout')

@section('content')

<div class="container">

    <div class="card" style="background-color:#F5F7F8;">
        <h1 class="text-center fs-2 mt-4">DATA EVENTREGIST</h1>
        <div class="card-body">
            @if ($pesan = session('Berhasil'))
                <div class="alert alert-primary" role="alert">
                    {{ $pesan }}
                </div>
            @endif
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Event Name</th>
                        <th scope="col">QR Code</th>
                        <th scope="col">Booth</th>
                        <th scope="col">Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($event_registration as $key => $item)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->event->name }}</td>
                            <td>
                                <?php
                                $eventRegId = $item->id;
                                $kode = $eventRegId . '/' . 'wayangriders/' . $item->event->password . '';
                                require_once 'qrcode/qrlib.php';
                                $filename = 'wayangriders' . $eventRegId . '.png';
                                $path = public_path('up/qrcode_images/' . $filename);
                                QRcode::png("$kode", $path, 2, 2);
                                ?>
                                <img src="{{ asset('up/qrcode_images/' . $filename) }}" alt="">
                            </td>
                            <td>{{ $item->booth }}</td>
                            <td>{{ $item->payment_status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            </div>
        </div>
    </div>
</div>
@endsection
