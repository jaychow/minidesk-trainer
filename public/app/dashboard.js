var drag;

anychart.onDocumentReady(function(){

    $("#id_currency").select2();


    var generateChart = function(id_currency, currency){
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:site_url+"/trend/saveToJsonFile",
            type:"POST",
            data:{
                id_currency: id_currency,
                currency: currency,
            },
            dataType:"json",
            success:function(response){
                anychart.data.loadJsonFile(site_url+'/files/'+response.filename, function(data) {
                // create data table on loaded data
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
                chart.title(response.title);

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
                series.name(currency);
                series.legendItem().iconType('rising-falling');


                // create scroller series with mapped data
                chart.scroller().candlestick(mapping);

                // set chart selected date/time range
                chart.selectRange(response.minDate, response.maxDate);

                $('#candlestickchart').html("");
                // set container id for the chart
                chart.container('candlestickchart');
                // initiate chart drawing
                chart.draw();

                // load all saved annotations

                var annotations = function(){
                    $.ajax({
                        url:site_url+"/trend/getTrendLines",
                        type:"GET",
                        data:{
                            id_currency:$("#id_currency").val()
                        },
                        dataType:"json",
                        success:function(data){
                            //console.log(data);
                            chart.plot().annotations().fromJson(data);
                            // get the number of annotations
                            var annotationsCount = plot.annotations().getAnnotationsCount();
                            for(var i = 0; i < annotationsCount; i++){
                                plot.annotations().getAnnotationAt(i).allowEdit(false);
                            }
                        }
                    });
                };

                annotations();

                // create range picker
                var rangePicker = anychart.ui.rangePicker();
                // init range picker
                rangePicker.render(chart);

                // create range selector
                var rangeSelector = anychart.ui.rangeSelector();
                // init range selector
                rangeSelector.render(chart);


                });
            }
        });
    }

    generateChart("", "");

    $('#id_currency').change(function(){
        generateChart(this.value, $(this).find('option:selected').text());
    });

});
