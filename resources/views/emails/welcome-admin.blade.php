@extends('layouts.email')

@section('title')
    Welcome to Tilt.ng
@endsection

@section('content')
    <p style="margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:Montserrat, sans-serif;line-height:24px;color:#333333;font-size:16px"> Hi {{$user->name}},</p>
    <br>
    <p style="margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:Montserrat, sans-serif;line-height:24px;color:#333333;font-size:16px">
        You are a school admin of <strong>{{$schoolName}}</strong>.
    </p>
    <p style="margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:Montserrat, sans-serif;line-height:24px;color:#333333;font-size:16px">
        Login details:
    <ul>
        <li> email: {{$user->email}}</li>
        <li>password: {{$password}}</li>
    </ul>

    </p>

    <p style="margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:Montserrat, sans-serif;line-height:24px;color:#333333;font-size:16px">
        <a href="{{env('APP_URL','https://tilt.ng')}}">Login here</a>
    </p>



@endsection
