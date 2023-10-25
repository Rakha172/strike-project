<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Confirm</title>
  </head>
  <body>
    @extends('componen.layout')

    @section('content')


    <div class="container">
        <div class="card">
                <h1 class="text-center fs-2 mt-4">Payment Confirm</h1>
            <div class="card-body">
<div class="table-responsive">
    @if ($pesan = session('success'))
    <div class="alert alert-success" role="alert">
        {{ $pesan }}
    </div>
    @endif
    <table class="table table-striped table-hover table-bordered" id="example2">
        <thead class="text-center">
            <tr>
                <th scope="col">User Name</th>
                <th scope="col">Event Name</th>
                <th scope="col">Payment Status</th>
                <th scope="col">Confirm</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($eventStatusPayed as $index => $payed)
                <tr>
                    {{-- <td>{{ $payed->id }}</td> --}}
                    <td>{{ $payed->user->name }}</td>
                    <td>{{ $payed->event->name }} <i class="fa fa-solid fa fa-arrow-right"></i></td>
                    <td>{{ $payed->payment_status }}</td>
                    <td>
                        <form action="{{ route('payment.update', $payed->id) }}" method="POST" onsubmit="return confirm('Konfirmasi pesanan?')">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-primary" title="Konfirmasi Pesanan"><i class="fa fa-solid fa fa-check"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $eventStatusPayed->withQueryString()->links() }}
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>

