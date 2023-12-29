<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>{{$title->name}} | PaymentTypes</title>
  </head>
  <body>
    @extends('componen.layout')

@section('content')

        <div class="container">
            <div class="card" style="background-color:#F5F7F8;">
                    <h1 class="text-center fs-2 mt-4">Payment Types</h1>
                <div class="card-body" >
            @if ($pesan = session('berhasil'))
            <div class="alert alert-primary" role="alert">
            {{ $pesan }}
            </div>
            @endif
            <a href="{{ route('paytype.create') }}" class="btn btn-primary">Create</a>
            <table class="table">
                <br><br>
                <thead>
                <tr>
                    <th scope="col">NO</th>
                    <th scope="col">Name</th>
                    <th scope="col">Owner</th>
                    <th scope="col">Account Number</th>
                    <th scope="col">Username</th>
                    <th scope="col">Status</th>
                    <th scope="col">Opsi</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($paymenttypes as $key => $item)
                <tr>
                    <th scope="row">{{ $key + 1}}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->owner }}</td>
                    <td>{{ $item->account_number }}</td>
                    <td>{{ $item->username }}</td>
                    <td>
                        @if ($item->status== 1)
                            Aktif
                        @else
                        Tidak Aktif
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('paytype.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('paytype.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-dark" onclick="return confirm('yakin mau di hapus?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
