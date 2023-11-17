<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>{{ $title->name }} | Create Events</title>
</head>

<body>
    @extends('componen.layout')

    @section('content')
        <div class="container mt-5">
            <div class="card">
                <h1 class="text-center fs-2 mt-4">DATA EVENTS</h1>
                <div class="card-body">

                    <form action="{{ route('event.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input value="{{ old('name') }}" name="name" type="text"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Qualification</label>
                            <select name="qualification" class="form-control @error('qualification') is-invalid @enderror">
                                <option value="weight" {{ old('qualification') == 'weight' ? 'selected' : '' }}>Weight
                                </option>
                                <option value="quantity" {{ old('qualification') == 'quantity' ? 'selected' : '' }}>Quantity
                                </option>
                                <option value="special" {{ old('qualification') == 'special' ? 'selected' : '' }}>Special
                                </option>
                                <option value="combined" {{ old('qualification') == 'combined' ? 'selected' : '' }}>Combined
                                </option>
                                <option value="weight special"
                                    {{ old('qualification') == 'weight special' ? 'selected' : '' }}>Weight Special</option>
                                <option value="weight quantity" {{ old('qualification') == 'weight quantity' ? 'selected' : '' }}>
                                    Weight Quantity</option>
                                <option value="quantity special"
                                    {{ old('qualification') == 'quantity special' ? 'selected' : '' }}>Quantity Special</option>
                            </select>
                            @error('qualification')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="int" class="form-control" name="price">
                            @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Booth</label>
                            <input value="{{ old('total_booth') }}" name="total_booth" type="text"
                                class="form-control @error('total_booth') is-invalid @enderror">
                            @error('total_booth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <p class="text ps-4">Image</p>
                        <div class="form-group">
                            <input value="{{ old('image') }}" type="file" id="image" name="image"
                                accept="image/*" class="form-control-file @error('image') is-invalid @enderror">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Event Date</label>
                            <input value="{{ old('event_date') }}" name="event_date" type="date"
                                class="form-control @error('event_date') is-invalid @enderror">
                            @error('event_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Start</label>
                            <input value="{{ old('start') }}" name="start" type="time"
                                class="form-control @error('start') is-invalid @enderror">
                            @error('start')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">End</label>
                            <input value="{{ old('end') }}" name="end" type="time"
                                class="form-control @error('end') is-invalid @enderror">
                            @error('end')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <textarea name="location" type="text" class="form-control @error('location') is-invalid @enderror">{{ old('location') }}</textarea>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" type="text" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-dark">Submit</button>
                    </form>
                </div>
            @endsection
</body>

</html>
