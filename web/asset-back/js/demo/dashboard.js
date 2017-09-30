
// Dashboard.js
// ====================================================================
// This file should not be included in your project.
// This is just a sample how to initialize plugins or components.
//
//  SARAH ADMIN


$(window).on('load', function() {



    // REALTIME FLOT CHART
    // =================================================================
    // Require Flot Charts
    // -----------------------------------------------------------------
    // http://www.flotcharts.org/
    // =================================================================
    // We use an inline data source in the example, usually data would
    // be fetched from a server

    var data = [],  totalPoints = 100;

    function getRandomData() {
        if (data.length > 0)
            data = data.slice(1);

        // Do a random walk

        while (data.length < totalPoints) {
            var prev = data.length > 0 ? data[data.length - 1] : 50,
                y = prev + Math.random() * 10 - 5;

            if (y < 20) {
                y = 30;
            } else if (y > 100) {
                y = 100;
            }

            data.push(y);
        }

        // Zip the generated y values with the x values
        var res = [];
        for (var i = 0; i < data.length; ++i) {
            res.push([i, data[i]])
        }
        return res;
    }

    // Set up the control widget
    var updateInterval = 750;
    var flotOptions = {
        series: {
            lines: {
                lineWidth: 1,
                show: true,
                fill: true,
                fillColor : "#d8d9d9"
            },
            color: '#cccccc',
            shadowSize: 0	// Drawing is faster without shadows
        },
        yaxis: {
            min: 0,
            max: 110,
            ticks: 30,
            show: false
        },
        xaxis: {
            show: false
        },
        grid: {
            hoverable: true,
            clickable: true,
            borderWidth: 0
        },
        tooltip: false,
        tooltipOpts: {
            defaultTheme: false
        }
    }


    var plot = $.plot("#demo-realtime-chart", [ getRandomData() ], flotOptions);
    function update() {
        plot.setData([getRandomData()]);

        // Since the axes don't change, we don't need to call plot.setupGrid()

        plot.draw();
        setTimeout(update, updateInterval);
    }
    update();


    // LARGE WEATHER WIDGET
    // =================================================================
    // Require sckycons
    // -----------------------------------------------------------------
    // http://darkskyapp.github.io/skycons/
    // =================================================================

    // on Android, a nasty hack is needed: {"resizeClear": true}
    skyconsOptions = {
        "color": "#acb2b7",
        "resizeClear": true
    }


    /* Main Icon */
    var skycons = new Skycons(skyconsOptions);
    skycons.add("demo-weather-lg-icon-1", Skycons.CLEAR_DAY);
    skycons.play();


    skyconsOptions = {
        "color": "#595e62",
        "resizeClear": true
    }

    /* Small Icons*/
    var skycons2 = new Skycons(skyconsOptions);
    skycons2.add("demo-weather-lg-icon-2", Skycons.CLOUDY);


    var skycons3 = new Skycons(skyconsOptions);
    skycons3.add("demo-weather-lg-icon-3", Skycons.PARTLY_CLOUDY_NIGHT);


    var skycons4 = new Skycons(skyconsOptions);
    skycons4.add("demo-weather-lg-icon-4", Skycons.RAIN);


    var skycons5 = new Skycons(skyconsOptions);
    skycons5.add("demo-weather-lg-icon-5", Skycons.PARTLY_CLOUDY_DAY);




    // Network chart ( Morris Line Chart )
    // =================================================================
    // Require MorrisJS Chart
    // -----------------------------------------------------------------
    // http://morrisjs.github.io/morris.js/
    // =================================================================

    var day_data = [
        {"elapsed": "Oct-12", "value": 24, b:2},
        {"elapsed": "Oct-13", "value": 34, b:22},
        {"elapsed": "Oct-14", "value": 33, b:7},
        {"elapsed": "Oct-15", "value": 22, b:6},
        {"elapsed": "Oct-16", "value": 28, b:17},
        {"elapsed": "Oct-17", "value": 60, b:15},
        {"elapsed": "Oct-18", "value": 60, b:17},
        {"elapsed": "Oct-19", "value": 70, b:7},
        {"elapsed": "Oct-20", "value": 67, b:18},
        {"elapsed": "Oct-21", "value": 86, b: 18},
        {"elapsed": "Oct-22", "value": 86, b: 18},
        {"elapsed": "Oct-23", "value": 113, b: 29},
        {"elapsed": "Oct-24", "value": 130, b: 23},
        {"elapsed": "Oct-25", "value": 114, b:10},
        {"elapsed": "Oct-26", "value": 80, b:22},
        {"elapsed": "Oct-27", "value": 109, b:7},
        {"elapsed": "Oct-28", "value": 100, b:6},
        {"elapsed": "Oct-29", "value": 105, b:17},
        {"elapsed": "Oct-30", "value": 110, b:15},
        {"elapsed": "Oct-31", "value": 102, b:17},
        {"elapsed": "Nov-01", "value": 107, b:7},
        {"elapsed": "Nov-02", "value": 60, b:18},
        {"elapsed": "Nov-03", "value": 67, b: 18},
        {"elapsed": "Nov-04", "value": 76, b: 18},
        {"elapsed": "Nov-05", "value": 73, b: 29},
        {"elapsed": "Nov-06", "value": 94, b: 13},
        {"elapsed": "Nov-07", "value": 135, b:2},
        {"elapsed": "Nov-08", "value": 154, b:22},
        {"elapsed": "Nov-09", "value": 120, b:7},
        {"elapsed": "Nov-10", "value": 100, b:6},
        {"elapsed": "Nov-11", "value": 130, b:17},
        {"elapsed": "Nov-12", "value": 100, b:15},
        {"elapsed": "Nov-13", "value": 60, b:17},
        {"elapsed": "Nov-14", "value": 70, b:7},
        {"elapsed": "Nov-15", "value": 67, b:18},
        {"elapsed": "Nov-16", "value": 86, b: 18},
        {"elapsed": "Nov-17", "value": 86, b: 18},
        {"elapsed": "Nov-18", "value": 113, b: 29},
        {"elapsed": "Nov-19", "value": 130, b: 23},
        {"elapsed": "Nov-20", "value": 114, b:10},
        {"elapsed": "Nov-21", "value": 80, b:22},
        {"elapsed": "Nov-22", "value": 109, b:7},
        {"elapsed": "Nov-23", "value": 100, b:6},
        {"elapsed": "Nov-24", "value": 105, b:17},
        {"elapsed": "Nov-25", "value": 110, b:15},
        {"elapsed": "Nov-26", "value": 102, b:17},
        {"elapsed": "Nov-27", "value": 107, b:7},
        {"elapsed": "Nov-28", "value": 60, b:18},
        {"elapsed": "Nov-29", "value": 67, b: 18},
        {"elapsed": "Nov-30", "value": 76, b: 18},
        {"elapsed": "Des-01", "value": 73, b: 29},
        {"elapsed": "Des-02", "value": 94, b: 13},
        {"elapsed": "Des-03", "value": 79, b: 24}
    ];

    var chart = Morris.Area({
        element : 'morris-chart-network',
        data: day_data,
        axes:false,
        xkey: 'elapsed',
        ykeys: ['value', 'b'],
        labels: ['Download Speed', 'Upload Speed'],
        yLabelFormat :function (y) { return y.toString() + ' Mb/s'; },
        gridEnabled: false,
        gridLineColor: 'transparent',
        lineColors: ['#82c4f8','#0d92fc'],
        lineWidth:[0,0],
        pointSize:[0,0],
        fillOpacity: 1,
        gridTextColor:'#999',
        parseTime: false,
        resize:true,
        behaveLikeLine : true,
        hideHover: 'auto'
    });





    // HDD USAGE - SPARKLINE LINE AREA CHART
    // =================================================================
    // Require sparkline
    // -----------------------------------------------------------------
    // http://omnipotent.net/jquery.sparkline/#s-about
    // =================================================================
    var hddSparkline = function() {
        $("#demo-sparkline-area").sparkline([57,69,70,62,73,79,76,77,73,52,57,50,60,55,70,68], {
            type: 'line',
            width: '100%',
            height: '40',
            spotRadius: 5,
            lineWidth: 1.5,
            lineColor:'rgba(255,255,255,.85)',
            fillColor: 'rgba(0,0,0,0.03)',
            spotColor: 'rgba(255,255,255,.5)',
            minSpotColor: 'rgba(255,255,255,.5)',
            maxSpotColor: 'rgba(255,255,255,.5)',
            highlightLineColor : '#ffffff',
            highlightSpotColor: '#ffffff',
            tooltipChartTitle: 'Usage',
            tooltipSuffix:' %'

        });
    }




    // EARNING - SPARKLINE LINE CHART
    // =================================================================
    // Require sparkline
    // -----------------------------------------------------------------
    // http://omnipotent.net/jquery.sparkline/#s-about
    // =================================================================
    var earningSparkline = function(){
        $("#demo-sparkline-line").sparkline([345,404,305,455,378,567,586,685,458,742,565], {
            type: 'line',
            width: '100%',
            height: '40',
            spotRadius: 4,
            lineWidth:1,
            lineColor:'#ffffff',
            fillColor: false,
            minSpotColor :false,
            maxSpotColor : false,
            highlightLineColor : '#ffffff',
            highlightSpotColor: '#ffffff',
            tooltipChartTitle: 'Earning',
            tooltipPrefix :'$ ',
            spotColor:'#ffffff',
            valueSpots : {
                '0:': '#ffffff'
            }
        });
    }



    // SALES - SPARKLINE BAR CHART
    // =================================================================
    // Require sparkline
    // -----------------------------------------------------------------
    // http://omnipotent.net/jquery.sparkline/#s-about
    // =================================================================

    var barEl = $("#demo-sparkline-bar");
    var barValues = [40,32,65,53,62,55,24,67,45,70,45,56,34,67,76,32,65,53,62,55,24,67,45,70,45,56,70,45,56,34,67,76,32,65,53,62,55];
    var barValueCount = barValues.length;
    var barSpacing = 1;
    var salesSparkline = function(){
         barEl.sparkline(barValues, {
            type: 'bar',
            height: 55,
            barWidth: Math.round((barEl.parent().width() - ( barValueCount - 1 ) * barSpacing ) / barValueCount),
            barSpacing: barSpacing,
            zeroAxis: false,
            tooltipChartTitle: 'Daily Sales',
            tooltipSuffix: ' Sales',
            barColor: 'rgba(255,255,255,.7)'
        });
    }


    $(window).on('resizeEnd', function(){
        hddSparkline();
        earningSparkline();
        salesSparkline();
    })
    hddSparkline();
    earningSparkline();
    salesSparkline();





    // PANEL OVERLAY
    // =================================================================
    // Require Sarah js
    // -----------------------------------------------------------------
    // 
    // =================================================================
    $('#demo-panel-network-refresh').sarahOverlay().on('click', function(){
        var $el = $(this), relTime;

        $el.sarahOverlay('show');


        relTime = setInterval(function(){
            $el.sarahOverlay('hide');
            clearInterval(relTime);
        },2000);
    });








    // WELCOME NOTIFICATIONS
    // =================================================================
    // Require Admin Core Javascript
    // =================================================================
    $.sarahNoty({
        type: 'dark',
        title: 'Welcome Administrator.',
        message: 'You will notice that you now have an admin menu<br> that appears on the right hand side.',
        container: 'floating',
        timer: 5000
    });

});
