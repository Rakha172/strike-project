<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <title>{{$title->name}} | Show Events</title>
</head>
<body>
    @extends('componen.layout')
    @section('content')
    <div class="container">
        <div class="card" style="background-color:#F5F7F8;">
            <div class="card-body">
                <a href="{{ route('event.index') }}" class="btn btn-dark float-end">Back</a>
                <h2>{{ $event->name }}</h2>
                <p>{{ $event->description }}</p>
                <h3>Daftar Pengguna yang Terdaftar</h3>
                @if ($users->count() > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Booth Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        @if ($user->event_regist)
                                            {{ $user->event_regist->booth }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Tidak ada pengguna terdaftar untuk event ini.</p>
                @endif
            </div>
        </div>
    </div>
    </body>
    </html>
    @endsection
