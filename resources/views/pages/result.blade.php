@extends('layouts.client')

@section('content')
<?php

echo "<script>";
echo "window.user = " . json_encode($user) . ";";
echo "window.report = " . json_encode($report) . ";";
echo "window.detailedReport = " . json_encode($detailedReport) . ";";
echo "window.overview = " . json_encode($overview) . ";";
echo "window.dominant_group = " . json_encode($dominant_group) . ";";
echo "</script>";



?>


<div id="page-loader" class="page-loader">
        <div class="holder">
                <div class="fas fa-spin fa-spinner"></div>
        </div>
</div>
<div id="result-root"></div>
@endsection