anychart.onDocumentReady(function() {
    // The data used in this sample can be obtained from the CDN
    // https://cdn.anychart.com/csv-data/csco-daily.csv
    //anychart.data.loadCsvFile('https://cdn.anychart.com/csv-data/csco-daily.csv', function(data) {
      // create data table on loaded data
    //   var data = []
    //   var year = 2017;
    //   var month = 7;
    //   var day = 23;
    //   var hour = 0;
    //   var minute = 0;
    //   for(let i = 1; i <= 46; i++){
    //     if(i%23 == 0){
    //         hour = 0;
    //         day++;
    //     }
    //     var item = [Date.UTC(year, month, day, hour, minute), 23.00, 23.50, 23.25, 23.40]
    //     data.push(item);
    //     hour++;
    //   }

    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:site_url+"/trend/getJsonData",
        type:"POST",
        data:{
            test:"Hallo"
        },
        dataType:"json",
        success:function(data){

            var dataTable = anychart.data.table();
            dataTable.addData(data);

            // map loaded data for the ohlc series
            var mapping = dataTable.mapAs({
                'open': 1,
                'high': 2,
                'low': 3,
                'close': 4
            });

            // map loaded data for the scroller
            var scrollerMapping = dataTable.mapAs();
            scrollerMapping.addField('value', 5);

            // create stock chart
            var chart = anychart.stock();

            // create first plot on the chart
            var plot = chart.plot(0);
            // set grid settings
            plot.yGrid(true)
                .xGrid(true)
                .yMinorGrid(true)
                .xMinorGrid(true);

            // create EMA indicators with period 50
            plot.ema(dataTable.mapAs({
                'value': 4
            })).series().stroke('1.5 #455a64');

            var series = plot.candlestick(mapping);
            series.name('EURAUD');
            series.legendItem().iconType('rising-falling');

            // create scroller series with mapped data
            chart.scroller().candlestick(mapping);

            // set chart selected date/time range
            chart.selectRange('2018-08-01 00:00', '2018-08-17 16:58:00');

            // set container id for the chart
            chart.container('candlestickchart');
            // initiate chart drawing
            chart.draw();

            // create range picker
            var rangePicker = anychart.ui.rangePicker();
            // init range picker
            rangePicker.render(chart);

            // create range selector
            var rangeSelector = anychart.ui.rangeSelector();
            // init range selector
            rangeSelector.render(chart);
            //});
        }
    });
  });

// $(function(){
//     $.ajax({
//         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//         url:site_url+"/trend/getJsonData",
//         type:"POST",
//         data:{
//             test:"Hallo"
//         },
//         dataType:"json",
//         success:function(){
//             alert("hallo");
//         }
//     });
// });
