<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>{{$title->name}} | Users</title>
  </head>
  <body>
    @extends('componen.layout')

@section('content')

        <div class="container">
            <div class="card" style="background-color:#F5F7F8;">
                    <h1 class="text-center fs-2 mt-4">DATA MEMBER</h1>
                <div class="card-body" >
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
                    <th scope="col">Phone Number</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($user as $key => $usr)
                <tr>
                    <th scope="row">{{ $key + 1}}</th>
                    <td>{{ $usr->name }}</td>
                    <td>{{ $usr->phone_number }}</td>
                    <td>{{ $usr->email }}</td>
                    <td>{{ $usr->role }}</td>
                    <td>
                        <a href="{{ route('user.edit', $usr->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('user.destroy', $usr->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-dark">Delete</button>
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

