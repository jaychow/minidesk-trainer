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
            <h3 class="box-title">Hover Data Table</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
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
