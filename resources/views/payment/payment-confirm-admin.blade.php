@extends('componen.layout')
    @section('content')
    <style>
.container {
    margin-top: 20px;
    padding: 20px;
}
.card h1 {
    text-align: center;
    font-size: 1.5rem;
    margin-top: 1rem;
}
.alert.alert-success {
    background-color: #28a745;
    color: #fff;
    margin-bottom: 20px;
    padding: 10px;
}
.table {
    width: 100%;
}
.table thead {
    background-color: #343a40;
    color: #fff;
}
.table th {
    text-align: center;
}
.table td {
    text-align: center;
}
.btn-primary {
    background-color: #007bff;
    border: none;
    color: #fff;
    border-radius: 10px;
}
.btn-primary i {
    font-size: 1rem;
    margin-right: 5px;
}
</style>
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


