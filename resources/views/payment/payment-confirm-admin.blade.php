<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>{{$title->name}} | Payment Confirm</title>
  </head>
  <body>
    @extends('componen.layout')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


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
                <th scope="col">Booth</th>
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
                    <td>{{ $payed->booth }}</td>
                    <td>{{ $payed->payment_status }}</td>
                    <td>
                        <form action="{{ route('payment.update', $payed->id) }}" method="POST"
                            onsubmit="return confirm('Konfirmasi pesanan?')">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-primary" title="Konfirmasi Pesanan">
                                <i class="fa fa-solid fa fa-check"></i>
                            </button>
                        </form>
                        <form action="{{ route('payment.cancel', $payed->id) }}" method="POST"
                            onsubmit="return confirm('Batalkan pesanan?')">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger" title="Batalkan Pesanan">
                                <i class="fa fa-solid fa fa-times"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $eventStatusPayed->withQueryString()->links() }}
</div>
</div>
</div>
@endsection


