var drag;
var selectedMarker;
// var chart;
// var plot;
var anns = [];
var edited;

anychart.onDocumentReady(function(){

    $("#id_currency").select2();

    var generateChart = function(id_currency, currency){
        // if(chart != undefined || chart != null){
        //     console.log('disposed');
        //     chart.dispose();
        //     chart = null;
        //     plot = null;
        //     $('#candlestickchart').html("");
        // }
        var finishedZone = undefined;
        var editedZone = undefined;
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


                chart.listen("annotationSelect", function(e){
                    //console.log("select"+e.annotation.color());
                    var x = e.annotation;
                    $.each(anns.annotationsList, function(k,v){
                        if(v.color == x.color()
                            && v.xAnchor == x.xAnchor()
                            && v.secondXAnchor == x.secondXAnchor()
                            && v.valueAnchor == x.valueAnchor()
                            && v.secondValueAnchor == x.secondValueAnchor()
                            )
                        {
                            edited = v;
                            //console.log("Same "+v.id);
                        }
                    })
                });

                chart.listen("annotationChangeStart", function(e){
                    //console.log("start"+e.annotation.color());
                });

                chart.listen("annotationChange", function(e){
                    //console.log("change"+e.annotation.color());
                });

                chart.listen("annotationChangeFinish", function(e){
                    //console.log("finished"+e.annotation.color());
                });

                chart.listen("annotationUnselect", function(e){
                    //console.log("unselect"+e.annotation.color());
                    var x = e.annotation;
                    if(edited != undefined && edited.color == x.color()
                            && ( edited.xAnchor != x.xAnchor()
                            || edited.secondXAnchor != x.secondXAnchor()
                            || edited.valueAnchor != x.valueAnchor()
                            || edited.secondValueAnchor != x.secondValueAnchor() )
                            )
                        {
                            var id =
                            swal({
                                title: "Do you want to save the change?",
                                icon: "info",
                                buttons: true,
                                dangerMode: false,
                              })
                              .then((willDelete) => {
                                if (willDelete) {
                                    var match = [];
                                    $.each(anns.annotationsList, function(k,v){
                                        if(v.color == edited.color
                                            && v.xAnchor == edited.xAnchor
                                            && v.secondXAnchor == edited.secondXAnchor
                                            && v.valueAnchor == edited.valueAnchor
                                            && v.secondValueAnchor == edited.secondValueAnchor
                                            )
                                        {
                                            v.xAnchor = x.xAnchor();
                                            v.secondXAnchor = x.secondXAnchor();
                                            v.valueAnchor = x.valueAnchor();
                                            v.secondValueAnchor = x.secondValueAnchor();
                                            match = v;
                                            return false;
                                        }
                                    });

                                    $.ajax({
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        url:site_url+"/trend/saveTrendLineChange",
                                        type:"post",
                                        data:{
                                            id:match.id,
                                            xAnchor:match.xAnchor,
                                            secondXAnchor:match.secondXAnchor,
                                            valueAnchor:match.valueAnchor,
                                            secondValueAnchor:match.secondValueAnchor,
                                        },
                                        dataType:"json",
                                        success:function(){
                                            toastr.success('Zone saved.', 'Success!');
                                        }
                                    });

                                }else{
                                    x.xAnchor(edited.xAnchor);
                                    x.secondXAnchor(edited.secondXAnchor);
                                    x.valueAnchor(edited.valueAnchor);
                                    x.secondValueAnchor(edited.secondValueAnchor);
                                }
                              });
                        }
                });

                // reset the select list to the first option
                chart.listen("annotationDrawingFinish", function(){
                    // get the number of annotations
                    var annotationsCount = plot.annotations().getAnnotationsCount();
                    var newAnn = plot.annotations().getAnnotationAt(annotationsCount - 1);

                    swal({
                        title: "Do you want to save this zone?",
                        icon: "info",
                        buttons: true,
                        dangerMode: false,
                      })
                      .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                url:site_url+"/trend/saveTrendLines",
                                type:"POST",
                                data:{
                                    enabled:newAnn.enabled(),
                                    type:newAnn.getType(),
                                    color:newAnn.color(),
                                    xAnchor:newAnn.xAnchor(),
                                    secondXAnchor:newAnn.secondXAnchor(),
                                    valueAnchor:newAnn.valueAnchor(),
                                    secondValueAnchor:newAnn.secondValueAnchor(),
                                    id_currency:$("#id_currency").val()
                                },
                                dataType:"json",
                                success:function(response){
                                    toastr.success('Zone saved.', 'Success!');
                                }
                            });
                        }else{
                            // remove the last annotation
                            plot.annotations().removeAnnotationAt(annotationsCount - 1);
                        }
                      });

                    document.getElementById("typeSelect").value = "default";
                });

                // load all saved annotations
                var annotations = function(){
                    $.ajax({
                        url:site_url+"/trend/getTrendLines",
                        type:"GET",
                        data:{
                            id_currency:id_currency
                        },
                        dataType:"json",
                        success:function(data){
                            //console.log(data);
                            anns = $.parseJSON(data);
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
                    //plot.annotations().startDrawing(this.value);
                    if(this.value == "bz-rectangle"){
                        plot.annotations().startDrawing({type: "rectangle", color: "cadetblue"});
                    }else{
                        plot.annotations().startDrawing({type: "rectangle", color: "red"});
                    }

                });

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

                    swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this marker!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                      })
                      .then((willDelete) => {
                        if (willDelete) {
                            var sa = plot.annotations().getSelectedAnnotation();
                            $.ajax({
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                url:site_url+"/trend/removeTrendLines",
                                type:"POST",
                                data:{
                                    color:sa.color(),
                                    xAnchor:sa.xAnchor(),
                                    secondXAnchor:sa.secondXAnchor(),
                                    id_currency:$("#id_currency").val()
                                },
                                dataType:"json",
                                success:function(response){
                                    var selectedAnnotation = plot.annotations().getSelectedAnnotation();
                                    // remove the selected annotation
                                    plot.annotations().removeAnnotation(selectedAnnotation);
                                    toastr.success('Zone deleted.', 'Success!');
                                }
                            });
                        }
                      });
                });

                });
            }
        });
    }

    generateChart("", "");

    $('#id_currency').change(function(){
        generateChart(this.value, $(this).find('option:selected').text());
    });

});
