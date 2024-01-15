

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>{{ $title->name }} | Edit User</title>
</head>

<body>
    @extends('componen.layout')

    @section('content')
        <div class="container mt-5">
            <div class="card">
                <h1 class="text-center fs-2 mt-4">EDIT MEMBER</h1>
                <div class="card-body">

                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input value="{{ old('name', $user->name) }}" name="name" type="text"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input value="{{ old('phone_number', $user->phone_number) }}" name="phone_number" type="text"
                                class="form-control @error('phone_number') is-invalid @enderror">
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input value="{{ old('email', $user->email) }}" name="email" type="text"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input value="{{ old('password', $user->password) }}" name="password" type="text"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select id="role" name="role" class="form-control @error('role') is-invalid @enderror" required>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="member" {{ $user->role == 'member' ? 'selected' : '' }}>Member</option>
                                <option value="operator" {{ $user->role == 'operator' ? 'selected' : '' }}>Operator</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- ... (Bagian kode setelahnya) -->

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            @endsection
</body>

</html>
