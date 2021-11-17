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
<style>

.page-loader {
	position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 900000;
    background: #fff;
}

.page-loader .holder {
	width: max-content;
	margin: auto;
	margin-top: 350px;
}


</style>

<div id="page-loader" class="page-loader">
        <div class="holder">
                <div class="fas fa-spin fa-spinner"></div>
        </div>
</div>
<div id="result-root"></div>
@endsection