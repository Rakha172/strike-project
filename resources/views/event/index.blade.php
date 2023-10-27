@extends('componen.layout')
    @section('content')
    <style>
        .container {
            margin-top: 20px;
            padding: 20px;
        }
        .card h1 {
            text-align: center;
        }
        .btn-dark {
            background-color: #343a40;
            color: #fff;
            border-radius: 10px;
        }
        .btn-warning {
            background-color: #ffc107;
            border-radius: 10px;
            color: #212529;
        }
        .alert.alert-primary {
            margin-bottom: 20px;
            background-color: #007bff;
            color: #fff;
        }
        .table {
            width: 100%;
        }
        .table thead {
            background-color: #007bff;
            color: #fff;
        }
        .table th {
            text-align: center;
        }
        .table td {
            padding: 5px;
        }

        </style>

    <div class="container">
        <div class="card">
                <h1 class="text-center fs-2 mt-4">DATA EVENTS</h1>
            <div class="card-body">

        <a href="{{ route('event.create')}}" class="btn btn-dark">Tambah</a>

        @if ($pesan = session('berhasil'))
        <div class="alert alert-primary" role="alert">
           {{ $pesan }}
        </div>
        @endif
        <table class="table">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">Price</th>
                <th scope="col">Total Booth</th>
                <th scope="col">Event Date</th>
                <th scope="col">Location</th>
                <th scope="col">Description</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($events as $key => $evnt)
              <tr>
                <td>{{ $evnt->name }}</td>
                <td><img src="{{ asset($evnt->image) }}" width="100"></td>
                <td>Rp. {{ number_format($evnt->price, 0, '.', '.')}}</td>
                <td>{{ $evnt->total_booth }}</td>
                <td>{{ $evnt->event_date }}</td>
                <td>{{ $evnt->location }}</td>
                <td>
                    {{ strlen($evnt->description) > 100 ? substr($evnt->description, 0, 100) . '...' : $evnt->description }}
                </td>
                <td>
                <td class="d-flex">
                    {{-- <a href="{{ route('event.edit', $evnt->id) }}" class="btn btn-warning m-1">Edit</a> --}}

                    <form action="{{ route('event.destroy', $evnt->id) }}" method="POST">
                        @csrf
                        @method('delete')

                        <button type="submit" class="btn btn-dark m-1" onclick="return confirm('Apakah Anda yakin ingin menghapus event ini?')">Hapus</button>
			            <a href="{{ route('result.index', $evnt->id) }}" class="btn btn-warning m-1">Result</a>
                    </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
    </div>
    {{-- <td colspan="n">
        <div style="text-align: center;"> --}}

    @endsection
