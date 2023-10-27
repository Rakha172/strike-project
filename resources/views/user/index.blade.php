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

</style>


        <div class="container">
            <div class="card">
                    <h1 class="text-center fs-2 mt-4">DATA MEMBER</h1>
                <div class="card-body">

            @if ($pesan = session('berhasil'))
            <div class="alert alert-primary" role="alert">
            {{ $pesan }}
            </div>
            @endif
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">NO</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($user as $key => $usr)
                <tr>
                    <th scope="row">{{ $key + 1}}</th>
                    <td>{{ $usr->name }}</td>
                    <td>{{ $usr->email }}</td>
                    <td>
                    <td class="d-flex">
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{-- <td colspan="n">
            <div style="text-align: center;"> --}}

        @endsection

