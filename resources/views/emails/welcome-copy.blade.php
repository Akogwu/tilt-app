<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account Registration</title>
</head>
<body>

<div style="margin: 25px">
    <h1>Welcome to Tilt.ng</h1>
    <p>Hi {{$name}},</p>

    <p>You are a school admin of <strong>{{$schoolName}}</strong>.</p>
    <p>
        <a href="{{env('APP_URL','https://tilt.ng')}}">Login here</a>
    </p>

    Thanks,<br>
    {{ config('app.name') }}
</div>

</body>
</html>
