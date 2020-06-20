<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $weather->title }}天气更新提醒</title>
</head>
<body>
<h1>您的{{ $weather->title }}天气状态有更新</h1>

<p>
    点击查看详情：
    <a href="{{ route('weathers.show', $weather->id) }}">
        {{ route('weathers.show', $weather->id) }}
    </a>
</p>

<p>
    如果这不是您本人的操作，请忽略此邮件。
</p>

</body>
</html>
