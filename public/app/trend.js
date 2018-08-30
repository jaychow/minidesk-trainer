anychart.onDocumentReady(function() {
    // The data used in this sample can be obtained from the CDN
    // https://cdn.anychart.com/csv-data/csco-daily.csv
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:site_url+"/trend/saveToJsonFile",
        type:"POST",
        data:{
            test:"Hallo"
        },
        dataType:"json",
        success:function(response){
            anychart.data.loadJsonFile(site_url+'/files/tradingData.json', function(data) {
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

            console.log(chart);

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
            chart.selectRange('2018-08-01 00:00:00', '2018-08-17 16:58:00');

            // set container id for the chart
            chart.container('candlestickchart');
            // initiate chart drawing
            chart.draw();

            // reset the select list to the first option
            chart.listen("annotationDrawingFinish", function(){
               // get the number of annotations
               var annotationsCount = plot.annotations().getAnnotationsCount();
               if(confirm("Do you want to save this marker?") == true){
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url:site_url+"/trend/saveTrendLines",
                        type:"POST",
                        data:{
                            xAnchor:plot.annotations().getAnnotationAt(annotationsCount - 1).xAnchor()
                        },
                        dataType:"json",
                        success:function(response){
                            alert("Saved!");
                        }
                    });
               }else{

                    // remove the last annotation
                    plot.annotations().removeAnnotationAt(annotationsCount - 1);
               }
               document.getElementById("typeSelect").value = "default";
            });

            // load all saved annotations

            var annotations = function(){
                $.ajax({
                    url:site_url+"/trend/getTrendLines",
                    type:"GET",
                    data:{
                        test:"Hallo"
                    },
                    dataType:"json",
                    success:function(data){
                        //console.log(data);
                        chart.plot().annotations().fromJson(data);
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

            // create annotations
            $("#typeSelect").change(function(){
                plot.annotations().startDrawing(this.value);
            });

            // remove all annotations
            // $("#removeAll").click(function(){
            //     plot.annotations().removeAllAnnotations();
            // });

            // cancel drawing
            $("#cancel").click(function(){
                plot.annotations().cancelDrawing();
                document.getElementById("typeSelect").value = "default";
            });

            // cancel drawing
            $("#clearSel").click(function(){
                plot.annotations().unselect();
            });

            //remove selected
            $("#removeSel").click(function(){
                if(confirm("Do you want to delete this marker?") == true){
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url:site_url+"/trend/removeTrendLines",
                        type:"POST",
                        data:{
                            xAnchor:plot.annotations().getSelectedAnnotation().xAnchor()
                        },
                        dataType:"json",
                        success:function(response){
                            var selectedAnnotation = plot.annotations().getSelectedAnnotation();
                            // remove the selected annotation
                            plot.annotations().removeAnnotation(selectedAnnotation);
                            alert("Removed!");
                        }
                    });
                }
            });

            });
        }
    });
  });
