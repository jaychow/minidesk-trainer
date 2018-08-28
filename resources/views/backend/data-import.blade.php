@extends('layouts.backend')

<!-- Main content -->
@section('content')
<section class="content">
    <div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Import Data</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
        <form class="form-horizontal" method="POST" action="{{ route('data-import.import-file') }}" enctype="multipart/form-data">
            <div class="box-body">
                <div class="form-group">
                <label for="currency" class="col-sm-2 control-label">Currency</label>

                <div class="col-sm-4">
                    <input type="text" class="form-control" id="currency" name="currency" placeholder="Choose Currency">
                </div>
                </div>
                <div class="form-group">
                    <label for="sample_file" class="col-sm-2 control-label">Input File</label>
                    <div class="col-sm-4">
                        <input class="form-control" type="file" id="sample_file" name="sample_file">
                        <p class="help-block">Select excel file.</p>
                    </div>
                </div>
                @csrf
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="reset" class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-info pull-right">Import</button>
            </div>
            <!-- /.box-footer -->
        </form>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (left) -->
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Hover Data Table</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="table" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>Date</th>
                <th>Open Bid</th>
                <th>High Bid</th>
                <th>Low Bid</th>
                <th>Close Bid</th>
              </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
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
