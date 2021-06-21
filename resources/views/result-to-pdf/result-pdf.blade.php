<!doctype html>
<?php

$user = (array)$user;

?>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>{{ $user["name"] }}</title>

    <script src="https://kit.fontawesome.com/c8d84f105a.js" crossorigin="anonymous"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Oxygen:wght@300;400;700&display=swap');

        * {
            font-family: 'Oxygen', sans-serif;
            color: #0b4875;
        }

        @media print {
            .page {
                margin: 50px;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }

        @page {
            size: A4;
            margin: 0;
        }

        .details-p {
            margin-bottom: 5px;
            margin-top: 5px;
        }

        .details-p-1 {
            margin: auto;
            width: max-content;
            text-align: center;
            margin-top: 25px;
        }

        .general-result {
            padding: 10px 45px;
            width: max-content;
            margin: auto;
            margin-top: 10px;
            border: 2px solid #f8cd40;
        }

        .summary-text {
            padding: 10px;
            width: 600px;
            margin: auto;
            margin-top: 50px;
            border: 2px solid #f8cd40;
            font-size: 12px;
        }

        .summary-container {
            background-color: #e4f2ff;
            padding: 50px;
            padding-bottom: 0px;
            padding-top: 20px;
        }

        .section-box{
            padding: 50px; padding-bottom: 0px; padding-top: 0px;
        }

        .section-title{
            border-radius: 8px; 
            font-size: 20px; 
            padding: 5px 40px; 
            width: max-content;
            margin: auto;
            margin-top: 0px;
            border: 2px solid;
            background-color: #fff !important
        }
        .section-title.border{
            border: 2px solid !important;
            background-color: #fff !important;
        }

        .section-icon {
            margin-right: 30px;
        }

        .section-item.border{
            border-radius: 8px !important;
            border-width: 2px !important;
        }

        .section-item-head{
            border-radius: 6px 6px 0 0 !important;
            font-size: 13px;
        }
        .footer.border {
            border: 2px dashed #000 !important;
            border-radius: 8px !important;
        }

        .btn.btn-floating{
            position: fixed;
            bottom: 3rem;
            right: 3rem;
            border-radius: 100%;
            color: #fff !important;
            background: #000;
            border-color: #000;
        }

        .btn.btn-floating i {
            color: #fff !important
        }

        html {
        /* -moz-transform: scale(1.2, 1.2); */
        /* zoom: 1.2; */
        /* zoom: 125%; */
        }


    </style>

</head>

<body id="result-summary">

    <!-- SUMMARY CONTAINER STARTS -->
    <div class="container-fluid summary-container">
        <div style="flex-direction: row;display: flex;width: max-content;float: right;">
            <h4>About Study Materials</h4> <img style="width: 50px; height: 50px; margin-left: 100px"
                src="https://cdn.logo.com/hotlink-ok/enterprise/eid_422203f0-477b-492b-9847-689feab1452a/logo-dark-2020.png"
                alt="TILT" />
        </div>
        <div style="margin-top: 80px;">
            <div style="width: 100px;height: 100px;margin: auto;">
                <img src="{{ $user["image_url1"] ?? "https://nanoguard.in/wp-content/uploads/2019/09/pic.jpg"}}"
                    style="width: 100px;height: 100px;border-radius: 100%;border: 2px solid #0b4875;" />
            </div>
            <div class="col-12 details-p-1">
                <p class="details-p"><b>Full names:</b> {{ $user["name"] }} </p>
                <p class="details-p"><b>Sex:</b> {{ $user["sex"] }} </p>
                <p class="details-p"><b>Age:</b> {{ $user["age"] }}Years </p>
                <p class="details-p"><b>School:</b> {{ $user["school"] }} </p>
                <p class="details-p"><b>Class:</b> {{ $user["class"] }} </p>
                <p class="details-p"><b>State/Province:</b> {{ $user["state/provice"] }} </p>
                <p class="details-p"><b>Country:</b> {{ $user["country"] }} </p>
                <h1 style="margin-bottom: 20px;">Here is Outcome of the Assessment</h1>
            </div>
            <!-- <hr style="background-color: #0b4875;"/> -->
            <div style="height: 2px;  background-color: #969ba0; width: 100%;"></div>
            <p class="general-result">General address for the result</p>
            <div style="margin-top: 10px; height: 2px;  background-color: #969ba0; width: 100%;"></div>
        </div>
    </div>
    <div style="max-width: 100%; width: 400px; height: 400px; margin: auto; margin-top: 40px; margin-bottom: 20px;"><canvas
            id="general-chart" width="400" height="400"></canvas></div>
    <p class="summary-text"><b>Description of the generallearning behaviorgraph:</b> Lorem ipsum dolor sit amet,
        consectetuer adipiscing elit. Aenean
        commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur
        ridiculus mus.</p>
    </div>

    <p style="page-break-after: always;">&nbsp;</p>
    <!-- SUMMARY CONTAINER ENDS -->

    <!-- RECOMMENDATIONS STARTS -->

    <div class="container-fluid pt-5">
         <h2 class="text-center">Recommendations</h2> 
    @foreach($recommendations as $recommendation)

    <div class="section-box p-5">
    <div style="margin: auto; width: max-content">
    <div class="section-title border border-{{$recommendation->group_color}}">
    <i class="fas {{ $recommendation->goroup_icon }} text-{{ $recommendation->group_color }}" style="margin-right: 10px"></i>   {{ $recommendation->group_name }}</div>
    </div>
    <div style="width: 400px; height: 400px; margin: auto; margin-top: 40px; margin-bottom: 20px; "><canvas id="{{ $recommendation->group_name }}-chart" width="400" height="400"></canvas></div>
    <p style="padding: 10px; width: 400px;margin: auto;margin-top: 50px;border: 2px solid #f8cd40; font-size: 12px;">
        {{$recommendation->description}}
    </p>
    </div>
    <!-- Summary text -->
    <div class="container">
    <div class="row justify-content-center">
        
        @foreach($recommendation->sections as $section)
            <div class="col-5 mb-4" style="padding: 0 3rem 0 3rem">
                <div class="section-item border border-{{$recommendation->group_color}}">
                <div class="section-item-head w-100 p-2 bg-{{$recommendation->group_color}} text-white text-center" style="text-transform: capitalize">{{ $section->section_name }}</div>
                <div class="w-100 p-2 bg-transparent" style="font-size: 13px">{{ $section->recommendation }}</div>
                </div>
            </div>
        @endforeach
    </div>
    </div>
</div>

    <p style="page-break-after: always;">&nbsp;</p>



    @endforeach
    </div>

    <div class="container-fluid p-5">
        <div class="footer border p-3 m-5 text-center">
            <p>What you do with the tilt.ng result can dramatically transform your learning outcome henceforth.</p>
            <h3 class="text-danger">The Learning Revolutions!</h3>
        </div>

        <div class="text-center" style="margin-top: 700px">
            <p>The Intentional Learning Testing Platform

            <br/>
            <br/>
            ©{{ date("Y") }}. All rights reserved
            </p>
        </div>  
    <div>

    </div>

    </div>

<button id="download-btn" type="button" class="btn btn-primary btn-floating" onclick="makePDF()">
  <i class="fas fa-download"></i>
</button>

    <!-- RECOMMENDATIONS ENDS -->


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0-rc.1/dist/chartjs-plugin-datalabels.min.js" integrity="sha256-Oq8QGQ+hs3Sw1AeP0WhZB7nkjx6F1LxsX6dCAsyAiA4=" crossorigin="anonymous"></script>
    <!-- <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script> -->

    <script>

        const makePDF = () => {
            const downloadBtn = document.getElementById("download-btn")
            downloadBtn.innerHTML = "<i class=\"fas fa-spinner fa-spin\"></i>";
            downloadBtn.disabled = true;
            window.scrollTo(0,0)

       setTimeout(() => {
           var quotes = document.getElementById('result-summary');
       html2canvas(quotes, {
        scale: 1,   
        onrendered: (canvas) => {
           //! MAKE YOUR PDF

            var pdf = new jsPDF('p', 'pt', 'letter');
            // var pdf = new jsPDF({
            //             unit: 'px',
            //             format: 'a4'
            //         });


            const mainWidth = canvas.width;
            const mainHeight =  1200;//canvas.width * 1.29248366013;

            for (var i = 0; i <= quotes.clientHeight/mainHeight; i++) {
                //! This is all just html2canvas stuff
                var srcImg  = canvas;
                var sX      = 0;
                var sY      = mainHeight * i; // start 980 pixels down for every new page
                var sWidth  = mainWidth;
                var sHeight = mainHeight;
                var dX      = 0;
                var dY      = 0;
                var dWidth  = mainWidth;
                var dHeight = mainHeight;

                window.onePageCanvas = document.createElement("canvas");
                onePageCanvas.setAttribute('width', mainWidth);
                onePageCanvas.setAttribute('height', mainHeight);
                var ctx = onePageCanvas.getContext('2d');
                // details on this usage of this function: 
                // https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API/Tutorial/Using_images#Slicing
                ctx.drawImage(srcImg,sX,sY,sWidth,sHeight,dX,dY,dWidth,dHeight);

                // document.body.appendChild(canvas);
                var canvasDataURL = onePageCanvas.toDataURL("image/png", 1.0);

                var width         = onePageCanvas.width;
                var height        = onePageCanvas.clientHeight;

                //! If we're on anything other than the first page,
                // add another page
                if (i > 0) {
                    pdf.addPage(612, 791); //8.5" x 11" in pts (in*72)
                }
                //! now we declare that we're working on that page
                pdf.setPage(i+1);
                //! now we add content to that page!
                pdf.addImage(canvasDataURL, 'PNG', -(width - width * .65)/4, 0, (width*.65), (height*0.65));

            }
            //! after the for loop is finished running, we save the pdf.
            pdf.save('Test.pdf');
            downloadBtn.innerHTML = "<i class=\"fas fa-check\"></i>";

            setTimeout(() => {
                
                downloadBtn.innerHTML = "<i class=\"fas fa-download\"></i>";
                downloadBtn.disabled = false;
                
            }, 3000);
       }})
       }, 1000);
    }

        const  download = () => {

            // html2canvas(document.body,{
            // onrendered:function(canvas){

            // var img=canvas.toDataURL("image/png");
            // var doc = new jsPDF({  
            //          unit: 'px',  
            //          format: 'a4'  
            //      });
            // doc.addImage(img,'JPEG',1,0, 2480/4, 4008/4);
            // doc.addImage(img,'JPEG',1,1, 2480/4, 4008/4);
            // doc.addImage(img,'JPEG',1,2, 2480/4, 4008/4);
            // doc.save('test.pdf');
            
            // }});


            let pdf = new jsPDF();
            let section=document.getElementById("result-summary");

            let page= function() {
                pdf.save("<?php echo str_replace(" ", "-", strtolower($user["name"]))."-".date("Y-m-d-H-i-s"); ?>.pdf");
            };
            
            // pdf.addImage()

            pdf.addHTML(section, page);

            // const doc = new window.jspdf.jsPDF();
            // var source = window.document.getElementsByTagName("html")[0];
            // doc.html(section)
            // doc.output("dataurlnewwindow");
            // doc.save()
        }
        
        // Draw Summary Chart
        <?php
            $labels = [];
            $values = [];
            $colors = ['#138267','#eb8612','#7a14b8','#07557c','#b71b18','#9a6515'];
            foreach ($summary_result as $group) {
                $labels[] = $group->group_name;
                $values[] = $group->score;
            }
            ?>
        var ctx = document.getElementById('general-chart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Score',
                    data:  <?php echo json_encode($values); ?>,
                    backgroundColor: <?php echo json_encode($colors); ?>,
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        labelString: 'Score',
                        title: {
                            display: true,
                            text: 'Score',
                        },
                        grid: {
                            borderWidth: 0,
                            lineWidth: 2,
                            color: "#f0f0f0"
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            autoSkip: false,
                            maxRotation: 90,
                            minRotation: 90
                        }
                    }
                }
            }
        });
    </script>

@foreach($recommendations as $recommendation)





<script>
// STACK BAR

    // Your code to run since DOM is loaded and ready


   <?php
            $labels = [];
            $values = [];
            $colors = ['#138267','#eb8612','#7a14b8','#07557c','#b71b18','#9a6515'];

            $datasets = [];
            $data = [];
            $colors = [];
            $length = 0;

            // Data cleansing

            foreach ($recommendation->sections as $k => $section) {
                $labels[] = $section->section_name;
                foreach ($section->labels as $key => $label) {
                    $data[$k][] = $label->score;
                    $colors[$k][] = $label->color;
                    $length = count($data[$k]) > $length ? count($data[$k]) : $length;
                }
            }

            // Fill up missing spaces with 0 
            foreach ($data as $k => $row) {
                if(count($row) < $length){
                    for ($i=0; $i < $length - count($row); $i++) { 
                        $data[$k][] = 0;
                        $colors[$k][] = "";
                    }
                }
            }
          
            // Data transposition
            $_scores = [];
            $_colors = [];
            foreach ($data as $k => $scores) {
                foreach ($scores as $j => $score) {
                    $_scores[$j][] = $score;
                    $_colors[$j][] = $colors[$k][$j];
                }
            }

            // Generate Dataset Array 
            foreach ($_scores as $k => $score_row) {
                foreach ($score_row as $j => $score) {
                    $datasets[$k]["data"][] = $score;
                    $datasets[$k]["backgroundColor"][] = $_colors[$k][$j];
                }
            }

            // echo "console.log(\"Data Formated\");";
            // echo "console.log(".json_encode($datasets).");";

            ?>

var data = {
  labels: <?php echo json_encode($labels); ?>,
  datasets: <?php echo json_encode($datasets); ?>,
};
var stack = document.getElementById("<?php echo $recommendation->group_name."-chart"; ?>").getContext("2d");
var myChart2 = new Chart(stack, {
  type: "bar",
  data: data,
  options: {
    plugins: {
      title: {
        display: false,
      },
      legend: {
        display: false,
      },
      tooltip: {
        enabled: false
      },
      datalabels: {
          display: true,
          color: "#d1d1d1",
          font: {
              family: "'Oxygen', sans-serif",
              size: 13,
              weight: "bold"
          },
          formatter: (value, context) => {
              return value > 0 ? value + '%' : "";
          }
      }
    },
    responsive: true,
    scales: {
      x: {
        stacked: true,
        ticks: {
          autoSkip: false,
           align: "center",
          font: {
                family: "'Oxygen', sans-serif",
                size: 13,
            }
        },
        grid: {
          display: false,
        },
      },
      y: {
        stacked: true,
        beginAtZero: true,
        max: 100,
        labelString: "Score",
        title: {
            display: true,
            text: "Score",
            font: {
                family: "'Oxygen', sans-serif",
                size: 13,
            }
        },
        grid: {
          borderWidth: 0,
          lineWidth: 2,
          color: "#f0f0f0",
        },
      },
    },
  },
  plugins: [ChartDataLabels],
//   options: {
//       color: "#000"
//   }
});



</script>
@endforeach

</body>

</html>