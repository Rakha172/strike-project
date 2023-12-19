<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
</head>
<body>
    <div style="max-width: 300px; margin: 50px auto;">
        <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="text-align: center; margin-bottom: 20px;">
                <h2>Enter Your Email</h2>
            </div>
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter Your Email" style="padding: 8px;">
            </div>
            <div style="text-align: center; margin-top: 20px;">
                <input type="submit" value="Enter" style="padding: 8px 20px; cursor: pointer; background-color: #4CAF50; color: white; border: none; border-radius: 4px;">
            </div>
        </form>
    </div>
</body>
</html>
