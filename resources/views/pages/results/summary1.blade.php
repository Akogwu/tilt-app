<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Summary Result</title>
    <link rel="stylesheet" href="/dist/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/print-custom.css">
    <link rel="stylesheet" href="/css/paper.min.css" media="all">
</head>
<body class="A4">
<section class="section section-lg bg-image bg-soft pt-10 pb-5 data-background=''">
<div class="container">
    <div class="row justify-content-center">
        <img src="/images/result-celebration.svg" alt="Page Heading Image" class="w-50"/>
        <div class="col-10 mx-auto text-center">
            <h1 class="text-primary display-1 font-weight-bold">Congratulation</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit.</p>
        </div>
    </div>
</div>
</section>
<div class="section-header py-0 pt-8 pt-lg-5">
    <div class="container">
        <div class="row mt-n9 summary-grid">
            @if($testResult)
                @foreach($testResult as $result)
                    <div class="pricing-card animate-up-2">
                        <div class="card shadow border-{{$result['color']}} p-0">
                            <header class="card-header bg-white text-center pt-6">
                                    <span>
                                        <i class="fa fa-{{$result['icon']}} fa-5x icon-{{$result['color']}}"> </i>
                                    </span>

                                <h1 class="text-gray-800 mb-3 font-weight-bolder mt-3">{{$result['group_name']}}</h1>
                                <p class="text-{{$result['color']}}" style="padding: 0.5rem; font-weight:bolder">{{$result['description']}}</p>
                            </header>
                            <div class="card-body p-0">
                                <div class="container text-center mb-3">
                                    @foreach($result['sections'] as $section)
                                        <h4>{{$section['recommendation']}}</h4>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            @endif
        </div>
    </div>
</div>
</body>
</html>
