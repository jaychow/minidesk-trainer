@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" id="chart-panel">
                <div class="card-header">Candle Stick Chart</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div id="candlestickchart" style="height: 600px"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
