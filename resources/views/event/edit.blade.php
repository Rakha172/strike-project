<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>{{$title->name}} | Edit Event</title>
  </head>
  <body>
    <div class="container mt-5">
        <form action="{{ route("event.update", $events->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input value="{{ old('name', $events->name) }}" name="name" type="text" class="form-control @error('name') is-invalid @enderror">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="integer" class="form-control" name="price" value="{{ number_format($item->price, 0, '.', '.') ?? old('price')}}">
                @error('price')
                 <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-3">
                <label class="form-label">Total Booth</label>
                <input value="{{ old('total_booth', $events->total_booth) }}" name="total_booth" type="text" class="form-control @error('total_booth') is-invalid @enderror">
                  @error('total_booth')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror

              </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <img style="max-width:200px;max-height:200px;"src="{{ asset('image/' . $events->image) }}">
                <input type="file" name="image"
                    class="form-control bg-light @error('image') is-invalid @enderror"
                    value="{{ old('image', $events->image) }}">
                @error('image')
                    <div class="invalid-feedback text-start">
                        <b>{{ $message }}</b>
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Event Date</label>
                <input value="{{ old('event_date', $events->event_date) }}" name="event_date" type="date" class="form-control @error('event_date') is-invalid @enderror">
                  @error('event_date')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror

              </div>
              <div class="mb-3">
                <label class="form-label">Location</label>
               <textarea name="location" type="number" class="form-control @error('location') is-invalid @enderror">{{ old('location', $events->location) }}</textarea>
               @error('location')
                   <div class="invalid-feedback">{{ $message }}</div>
               @enderror

              </div>
              <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" type="text" class="form-control @error('description') is-invalid @enderror">{{ old('description', $events->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-dark">Submit</button>
          </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  </body>
</html>

