@extends('layouts.backend')
@section('content')
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Info box -->
                <!-- ============================================================== -->
                <div class="card-group">
                    <!-- Card -->
                    <div class="card">
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="d-flex align-items-center">
                                <div class="m-r-10">
                                    <a href="{{ route('manage-admin') }}" class="btn btn-circle btn-lg bg-danger">
                                        <i class="icon-People-onCloud text-white"></i>
                                    </a>
                                </div>
                                <div>
                                    Manage Admin
                                </div>
                                <div class="ml-auto">
                                    <h2 class="m-b-0 font-light"></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card -->
                    <!-- Card -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="m-r-10">
                                    <a href="{{ route('data-import') }}" class="btn btn-circle btn-lg btn-info">
                                        <i class="icon-File-Excel text-white"></i>
                                    </a>
                                </div>
                                <div>
                                    Import Data
                                </div>
                                <div class="ml-auto">
                                    <h2 class="m-b-0 font-light"></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card -->
                    <!-- Card -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="m-r-10">
                                    <a href="{{ route('trend') }}" class="btn btn-circle btn-lg bg-success">
                                        <i class="icon-Bar-Chart5 text-white"></i>
                                    </a>
                                </div>
                                <div>
                                    Trend
                                </div>
                                <div class="ml-auto">
                                    <h2 class="m-b-0 font-light"></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card -->
                    <!-- Card -->
                    <div class="card card-hover">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="m-r-10">
                                    <a href="{{ route('manage-admin') }}" class="btn btn-circle btn-lg bg-warning">
                                        <i class="icon-Gears text-white"></i>
                                    </a>
                                </div>
                                <div>
                                    Settings
                                </div>
                                <div class="ml-auto">
                                    <h2 class="m-b-0 font-light"></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card -->
                    <!-- Column -->


                </div>
                <!-- ============================================================== -->
                <!-- Info box -->
                <!-- ============================================================== -->
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
