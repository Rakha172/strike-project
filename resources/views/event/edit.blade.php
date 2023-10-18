<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Edit Event</title>
  </head>
  <body>
    <div class="container mt-5">
        <form action="{{ route("event.update", $event->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input value="{{ old('name', $event->name) }}" name="name" type="text" class="form-control @error('name') is-invalid @enderror">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>
            <div class="mb-3">
                <label class="form-label">Event Date</label>
                <input value="{{ old('event_date', $event->event_date) }}" name="event_date" type="date" class="form-control @error('event_date') is-invalid @enderror">
                  @error('event_date')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror

              </div>
              <div class="mb-3">
                <label class="form-label">Location</label>
                <input value="{{ old('location', $event->location) }}" name="location" type="text" class="form-control @error('location') is-invalid @enderror">
                  @error('location')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror

              </div>
              <div class="mb-3">
                <label class="form-label">Description</label>
                <input value="{{ old('description', $event->description) }}" name="description" type="text" class="form-control @error('description') is-invalid @enderror">
                  @error('description')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror

              </div>
              <div class="mb-3">
                <label class="form-label">Category</label>
                <input value="{{ old('category', $event->category) }}" name="category" type="text" class="form-control @error('category') is-invalid @enderror">
                  @error('category')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror

              </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  </body>
</html>

