@extends('layouts.app')
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
                                <div class="col-md-12">
                                        <select class="select2 form-control custom-select" style="width: 200px; height:36px;" id="id_currency">
                                                <option value="default" selected disabled>Select Currency</option>
                                            @if (isset($select2))
                                                $@foreach ($select2 as $option)
                                                <option value="{{ $option['id'] }}">{{ $option['item'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
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
