<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - nikkiame</title>
</head>
<body>
    <article>
        <h1>{{ $title }}</h1>
        <aside>
            <p>作者: <span>{{ $author->name }}</span></p>
            <p>作成日: <time>{{ $created_at }}</time></p>
            <p>更新日: <time>{{ $updated_at }}</time></p>
        </aside>
        <div>
            {!! $converter->convertToHtml($content) !!}
        </div>
    </article>
</body>
</html>
