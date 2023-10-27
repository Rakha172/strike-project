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
.alert.alert-primary {
    margin-bottom: 20px;
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
.table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}
.table tbody tr:hover {
    background-color: #dcdcdc;
}

    </style>
<div class="container">
    <div class="card">
        <h1 class="text-center fs-2 mt-4">DATA EVENTREGIST</h1>
        <div class="card-body">
            @if ($pesan = session('Berhasil'))
                <div class="alert alert-primary" role="alert">
                    {{ $pesan }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">User Name</th>
                            <th scope="col">Event Name</th>
                            <th scope="col">Payment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event_registration as $key => $item)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->event->name }}</td>
                                <td>{{ $item->payment_status }}</td>
                                <td class="d-flex">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
