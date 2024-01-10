<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>{{ $title->name }} | Edit Setting</title>
</head>

<body>
    @extends('componen.layout')

    @section('content')
        <div class="container mt-5">
            <div class="card">
                <h1 class="text-center fs-2 mt-4">EDIT SETTING</h1>
                <div class="card-body">
                    <a href="{{ route('setting.index') }}" class="btn btn-dark float-end">Back</a><br>
                    <form action="{{ route('setting.update', $setting->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ $setting->name }}"
                                id="name">
                            @error('name')
                                <div class="invalid-feedback text-start">
                                    <b>{{ $message }}</b>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">History</label>
                            <textarea name="history" type="text"
                                class="form-control @error('history') is-invalid @enderror">{{ old('history', $setting->history) }}</textarea>
                            @error('history')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <input value="{{ old('location', $setting->location) }}" name="location" type="text"
                                class="form-control @error('location') is-invalid @enderror">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo</label>
                            <img style="max-width:200px;max-height:200px;"
                                src="{{ asset('logo/' . $setting->logo) }}">
                            <input type="file" name="logo"
                                class="form-control bg-light @error('logo') is-invalid @enderror"
                                value="{{ old('logo', $setting->logo) }}">
                            @error('logo')
                                <div class="invalid-feedback text-start">
                                    <b>{{ $message }}</b>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Slogan</label>
                            <textarea name="slogan" type="text"
                                class="form-control @error('slogan') is-invalid @enderror">{{ old('slogan', $setting->slogan) }}</textarea>
                            @error('slogan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="desc" type="text"
                                class="form-control @error('desc') is-invalid @enderror">{{ old('desc', $setting->desc) }}</textarea>
                            @error('desc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <textarea name="phone" type="number"
                                class="form-control @error('phone') is-invalid @enderror">{{ old('phone', $setting->phone) }}</textarea>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <textarea name="email" type="text"
                                class="form-control @error('email') is-invalid @enderror">{{ old('email', $setting->email) }}</textarea>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">WhatsApp Sender</label>
                            <textarea name="sender" type="text"
                                class="form-control @error('sender') is-invalid @enderror">{{ old('sender', $setting->sender) }}</textarea>
                            @error('sender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">WhatsApp End Point</label>
                            <textarea name="endpoint" type="text"
                                class="form-control @error('endpoint') is-invalid @enderror">{{ old('endpoint', $setting->endpoint) }}</textarea>
                            @error('endpoint')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">WhatsApp API</label>
                            <textarea name="api_key" type="text"
                                class="form-control @error('api_key') is-invalid @enderror">{{ old('api_key', $setting->api_key) }}</textarea>
                            @error('api_key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <center>
                            <button type="submit" class="btn btn-dark" style="width: 200px; border-radius: 25px;">Update
                                Data</button>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    @endsection

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

</body>

</html>
