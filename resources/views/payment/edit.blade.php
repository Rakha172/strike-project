<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>{{ $title->name }} | Edit Payment Types</title>
</head>

<body>
    @extends('componen.layout')

    @section('content')
        <div class="container mt-5">
            <form action="{{ route('paytypeupdate', $paymenttypes->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input value="{{ old('name', $paymenttypes->name) }}" name="name" type="text"
                        class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Owner</label>
                    <input value="{{ old('owner', $paymenttypes->owner) }}" name="owner" type="text"
                        class="form-control @error('owner') is-invalid @enderror">
                    @error('owner')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Account Number</label>
                    <input value="{{ old('account_number', $paymenttypes->account_number) }}" name="account_number"
                        type="number" class="form-control @error('account_number') is-invalid @enderror">
                    @error('account_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input value="{{ old('username', $paymenttypes->username) }}" name="username" type="text"
                        class="form-control @error('username') is-invalid @enderror">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        @if ($paymenttypes->status == 1)
                            <option value="1">Aktif</option>
                            <option value="2">Tidak Aktif</option>
                        @else
                            <option value="2">Tidak Aktif</option>
                            <option value="1">Aktif</option>
                        @endif
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-dark">Submit</button>
            </form>
        </div>
    @endsection
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>
