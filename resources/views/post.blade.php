<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Post</title>
</head>
<body>
   <h1>New Post</h1>
   @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

<form action="/posts/create" method="post">
        @csrf
        <div>
        <label for="title">Title</label>
        <input type="text" name="title">
        </div>
        <div>
        <label for="content">Content</label>
        <textarea name="content" id="" cols="30" rows="10" required></textarea>
        </div>
        <button type="submit">submit</button>
   </form>

</body>
</html>
