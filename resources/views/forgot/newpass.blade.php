<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
</head>
<body>
    <div style="max-width: 300px; margin: 50px auto;">
        <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="text-align: center; margin-bottom: 20px;">
                <h2>Change Password</h2>
            </div>
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <label for="new_password">New Password</label>
                <input type="password" name="new_password" id="new_password" placeholder="New Password" style="padding: 8px;">
            </div>
            <div style="display: flex; flex-direction: column; gap: 15px; margin-top: 15px;">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" style="padding: 8px;">
            </div>
            <div style="text-align: center; margin-top: 20px;">
                <input type="submit" value="Enter" style="padding: 8px 20px; cursor: pointer; background-color: #4CAF50; color: white; border: none; border-radius: 4px;">
            </div>
        </form>
    </div>
</body>
</html>
