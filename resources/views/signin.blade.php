<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>siginin</title>
</head>
<body>
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="/signin" method="post">
        @csrf
        <div>
        <label for="uid">user id</label>
        <input type="text" name="uid" required>
        </div>
        <div>
        <label for="pass">password</label>
        <input type="password" name="pass" required>
        </div>
        <button type="submit">submit</button>
   </form>
</body>
</html>
