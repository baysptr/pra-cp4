<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pra CP - 4 | suhu</title>
    <link href="code/css/bootstrap.min.css" rel="stylesheet">
    <link href="code/css/switch.bootstrap.css" rel="stylesheet">
</head>
<body>
<br/>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div id="kelembapan" style="min-width: 310px; max-width: 400px; height: 300px; margin: 0 auto"></div>
        </div>
        <div class="col-md-4">
            <div id="suhu" style="min-width: 310px; max-width: 400px; height: 300px; margin: 0 auto"></div>
        </div>
        <div class="col-md-4">
            <h4>Status Saklar :</h4>
            <button type="button" id="saklar" class="btn btn-lg btn-toggle active" data-toggle="button" aria-pressed="false" autocomplete="off" disabled>
                <div class="handle"></div>
            </button>
        </div>
    </div>
</div>

<script src="code/jquery.js"></script>
<script src="code/highcharts.js"></script>
<script src="code/highcharts-more.js"></script>
<script src="code/modules/exporting.js"></script>
<script src="code/modules/export-data.js"></script>
<script src="code/js/bootstrap.min.js"></script>

<script type="text/javascript">

    Highcharts.chart('kelembapan', {

            chart: {
                type: 'gauge',
                plotBackgroundColor: null,
                plotBackgroundImage: null,
                plotBorderWidth: 0,
                plotShadow: false
            },

            title: {
                text: 'Kelembapan'
            },

            pane: {
                startAngle: -150,
                endAngle: 150,
                background: [{
                    backgroundColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                        stops: [
                            [0, '#FFF'],
                            [1, '#333']
                        ]
                    },
                    borderWidth: 0,
                    outerRadius: '109%'
                }, {
                    backgroundColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                        stops: [
                            [0, '#333'],
                            [1, '#FFF']
                        ]
                    },
                    borderWidth: 1,
                    outerRadius: '107%'
                }, {
                    // default background
                }, {
                    backgroundColor: '#DDD',
                    borderWidth: 0,
                    outerRadius: '105%',
                    innerRadius: '103%'
                }]
            },

            // the value axis
            yAxis: {
                min: 0,
                max: 100,

                minorTickInterval: 'auto',
                minorTickWidth: 1,
                minorTickLength: 10,
                minorTickPosition: 'inside',
                minorTickColor: '#666',

                tickPixelInterval: 30,
                tickWidth: 2,
                tickPosition: 'inside',
                tickLength: 10,
                tickColor: '#666',
                labels: {
                    step: 2,
                    rotation: 'auto'
                },
                title: {
                    text: 'Humidity'
                },
                plotBands: [{
                    from: 0,
                    to: 40,
                    color: '#55BF3B' // green
                }, {
                    from: 40,
                    to: 75,
                    color: '#DDDF0D' // yellow
                }, {
                    from: 75,
                    to: 100,
                    color: '#DF5353' // red
                }]
            },

            series: [{
                name: 'Kelembapan ',
                data: [0],
                tooltip: {
                    valueSuffix: '%'
                }
            }]

        },
        // Add some life
        function (chart) {
            if (!chart.renderer.forExport) {
                setInterval(function () {
                    var point = chart.series[0].points[0];
                    //     newVal;
                    //
                    // newVal = generateRandomNumber(point.y + 3, point.y - 3);
                    $.getJSON("http://localhost/suhu/get_data.php", function (data) {
                        point.update(Math.floor(data.kelembapan));
                    });

                    // point.update(Math.floor(newVal));

                }, 3000);
            }
        });


    Highcharts.chart('suhu', {

            chart: {
                type: 'gauge',
                plotBackgroundColor: null,
                plotBackgroundImage: null,
                plotBorderWidth: 0,
                plotShadow: false
            },

            title: {
                text: 'Suhu'
            },

            pane: {
                startAngle: -150,
                endAngle: 150,
                background: [{
                    backgroundColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                        stops: [
                            [0, '#FFF'],
                            [1, '#333']
                        ]
                    },
                    borderWidth: 0,
                    outerRadius: '109%'
                }, {
                    backgroundColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                        stops: [
                            [0, '#333'],
                            [1, '#FFF']
                        ]
                    },
                    borderWidth: 1,
                    outerRadius: '107%'
                }, {
                    // default background
                }, {
                    backgroundColor: '#DDD',
                    borderWidth: 0,
                    outerRadius: '105%',
                    innerRadius: '103%'
                }]
            },

            // the value axis
            yAxis: {
                min: 0,
                max: 100,

                minorTickInterval: 'auto',
                minorTickWidth: 1,
                minorTickLength: 10,
                minorTickPosition: 'inside',
                minorTickColor: '#666',

                tickPixelInterval: 30,
                tickWidth: 2,
                tickPosition: 'inside',
                tickLength: 10,
                tickColor: '#666',
                labels: {
                    step: 2,
                    rotation: 'auto'
                },
                title: {
                    text: 'Suhu (C)'
                },
                plotBands: [{
                    from: 0,
                    to: 40,
                    color: '#55BF3B' // green
                }, {
                    from: 40,
                    to: 75,
                    color: '#DDDF0D' // yellow
                }, {
                    from: 75,
                    to: 100,
                    color: '#DF5353' // red
                }]
            },

            series: [{
                name: 'Suhu ',
                data: [0],
                tooltip: {
                    valueSuffix: 'c'
                }
            }]

        },
        // Add some life
        function (chart) {
            if (!chart.renderer.forExport) {
                setInterval(function () {
                    var point = chart.series[0].points[0];
                    //     newVal;
                    //
                    // newVal = generateRandomNumber(point.y + 3, point.y - 3);
                    $.getJSON("http://localhost/suhu/get_data.php", function (data) {
                        point.update(Math.floor(data.celsius));
                        var tempData = document.getElementById('saklar');
                        if(data.status === "0"){
                            if($("#saklar").hasClass("active")){
                                tempData.classList.remove("active");
                            }
                        }else if(data.status === "1"){
                            tempData.classList.add("active");
                        }
                    });



                }, 3000);
            }
        });
</script>
</body>
</html>