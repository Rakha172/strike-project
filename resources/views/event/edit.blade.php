<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>{{ $title->name }} | Edit Event</title>
</head>

<body>
    @extends('componen.layout')

    @section('content')
        <div class="container mt-5">
            <div class="card">
                <h1 class="text-center fs-2 mt-4">EDIT EVENT</h1>
                <div class="card-body">

                    <form action="{{ route('event.update', $event->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input value="{{ $event->name }}" name="name" type="text"
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
                                <option value="weight_special"
                                    {{ old('qualification') == 'weight_special' ? 'selected' : '' }}>Weight Special</option>
                                <option value="weight_quantity"
                                    {{ old('qualification') == 'weight_quantity' ? 'selected' : '' }}>
                                    Weight Quantity</option>
                                <option value="quantity_special"
                                    {{ old('qualification') == 'quantity_special' ? 'selected' : '' }}>Quantity Special
                                </option>
                            </select>
                            @error('qualification')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="int" class="form-control" name="price" value="{{ $event->price }}">
                            @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- ... (Bagian kode sebelumnya) -->

                        <div class="mb-3">
                            <label class="form-label">Total Booth</label>
                            <input value="{{ old('total_booth', $event->total_booth) }}" name="total_booth" type="text"
                                class="form-control @error('total_booth') is-invalid @enderror">
                            @error('total_booth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Existing Image</label>

                            <!-- Existing image display -->
                            <div class="d-flex align-items-center">
                                <img src="{{ asset($event->image) }}" alt="Event Image" class="img-thumbnail mr-3">

                                <!-- Small preview of the new image (if selected) -->
                                @if (old('image'))
                                    <img src="{{ asset(old('image')) }}" alt="New Image Preview" class="img-thumbnail"
                                        style="width: 50px; height: 50px;">
                                @endif
                            </div>

                            <!-- Input for updating image -->
                            <label class="form-label mt-2">Update Image</label>
                            <input value="{{ old('image') }}" type="file" id="image" name="image"
                                accept="image/*" class="form-control-file @error('image') is-invalid @enderror">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Event Date</label>
                            <input value="{{ old('event_date', $event->event_date) }}" name="event_date" type="date"
                                class="form-control @error('event_date') is-invalid @enderror">
                            @error('event_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Start</label>
                            <input value="{{ old('start', $event->start) }}" name="start" type="time"
                                class="form-control @error('start') is-invalid @enderror">
                            @error('start')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">End</label>
                            <input value="{{ old('end', $event->end) }}" name="end" type="time"
                                class="form-control @error('end') is-invalid @enderror">
                            @error('end')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <textarea name="location" type="text" class="form-control @error('location') is-invalid @enderror">{{ old('location', $event->location) }}</textarea>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" type="text" class="form-control @error('description') is-invalid @enderror">{{ old('description', $event->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- ... (Bagian kode setelahnya) -->

                        <button type="submit" class="btn btn-dark">Update</button>
                    </form>
                </div>
            @endsection
</body>

</html>
