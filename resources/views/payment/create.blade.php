<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>{{ $title->name }} | Add User</title>
</head>

<body>
    @extends('componen.layout')

    @section('content')
        <div class="container mt-5">
            <form action="{{ route('paytype.store') }}" method="post">
                @csrf
                @method('post')
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Owner</label>
                    <input name="owner" type="text" class="form-control @error('owner') is-invalid @enderror">
                    @error('owner')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Account Number</label>
                    <input name="account_number" type="number"
                        class="form-control @error('account_number') is-invalid @enderror">
                    @error('account_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input name="username" type="text" class="form-control @error('username') is-invalid @enderror">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="0">Tidak Aktif</option>
                        <option value="1">Aktif</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    @endsection
</body>

</html>
