<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('css/regisevent.css') }}" rel="stylesheet">

    <title>{{ $title->name }} | Registration Event</title>
</head>

<body>
    <div class="overlay"></div>
    <form action="{{ route('event_registration.store') }}" method="post" class="box">
        @csrf
        <div class="header">
            <h4>Pendaftaran Acara</h4>
            <p>Silakan isi formulir pendaftaran acara</p>
        </div>
        <br>

        @if (session('success'))
            <div class="alert alert-primary">
                Berhasil Dibuat
                {{ session('success') }}
            </div>
        @endif

        <div class="login area">
            <p>Username
                @if (auth()->check())
                    <input type="text" class="form-control" value="{{ auth()->user()->name }}"
                        style="background: #0d6efd" readonly>
                    <input name="user_id" type="hidden" class="form-control" placeholder="Masukkan Username Anda"
                        value="{{ auth()->user()->id }}">
                @endif
            </p>

            <p>Event
                <select name="event_id" id="event_id" class="form-control">
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}">{{ $event->name }}</option>
                    @endforeach
                </select>
            </p>

            <p>Select Booth
                <select name="booth" class="form-control">
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </p>

            <div class="form-group">
                <form action="{{ url('/dashboard') }}">
                    <button type="submit" class="btn btn-success btn-block">Daftar</button>
                </form>
            </div>
        </div>
    </form>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        <script>
            alert("{{ session('error') }}");
        </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script>
        @if (session('error'))
            alert("{{ session('error') }}");
        @endif
    </script>

</body>

</html>
