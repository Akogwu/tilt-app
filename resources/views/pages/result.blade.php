@extends('layouts.client')

@section('content')
<?php

echo "<script>";
echo "window.user = ".json_encode($user).";";
echo "window.report = ".json_encode($report).";";
echo "</script>";



?>
        <div id="result-root"></div>
@endsection
