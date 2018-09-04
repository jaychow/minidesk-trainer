@extends('layouts.backend')
@section('content')
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Email campaign chart -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h4 class="card-title">Candle Stick Chart</h4>
                                        <h5 class="card-subtitle">Money Exchange</h5>
                                    </div>
                                </div>
                                <div class="row">
                                        <div class="col-md-12">
                                            <select class="select2 form-control custom-select" style="width: 200px; height:36px;" id="id_currency">
                                                    <option value="default" selected disabled>Select Currency</option>
                                                @if (isset($select2))
                                                    $@foreach ($select2 as $option)
                                                    <option value="{{ $option['id'] }}">{{ $option['item'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <select class="col-md-3 custom-select" id="typeSelect">
                                                <option value="default" selected disabled>Annotation Type</option>
                                                <option value="bz-rectangle">Buy Zone</option>
                                                <option value="sz-rectangle">Sell Zone</option>
                                            </select>
                                            <button class="btn btn-primary mb-2" id="cancel">Cancel</button>
                                            <button class="btn btn-primary mb-2" id="clearSel">Clear Selection</button>
                                            <button class="btn btn-primary mb-2" id="removeSel">Remove Selected</button>
                                        </div>
                                </div>
                                <div id="candlestickchart" style="height: 600px"></div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Email campaign chart -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
@endsection
