@extends('layouts.backend')

<!-- Main content -->
@section('content')
<style>
#candlestickchart {
    width: 100%;
    height: 600px;
    margin: 0;
    padding: 0;
}
</style>
<section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Candle Stick Chart</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
                <select id="typeSelect">
                    <option value="default" selected disabled>Annotation Type</option>
                    <option value="vertical-line">Vertical Line</option>
                </select>
                <button id="cancel">Cancel</button>
                <button id="clearSel">Clear Selection</button>
                <button id="removeSel">Remove Selected</button>
            <div id="candlestickchart"></div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
  @endsection
