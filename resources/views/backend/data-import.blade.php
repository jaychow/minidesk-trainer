@extends('layouts.backend')

@section('content')
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- basic table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Exchange Data</h4>
                                <button id="openBtn" class="btn btn-primary mb-2"><i class="far fa-file-excel"></i>&nbsp; Import</button>
                                <div class="table-responsive">
                                    <table id="table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Open Bid</th>
                                                <th>High Bid</th>
                                                <th>Low Bid</th>
                                                <th>Close Bid</th>
                                                <th>Volume</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- sample modal content -->
            <div class="modal fade" id="input-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Choose File</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <!-- form start -->
                            <form role="form" id="form">
                                <div class="box-body">
                                <div class="form-group">
                                    <label for="name">Currency Name</label>
                                    <input type="text" class="form-control" name="currency_name" placeholder="Enter currency name">
                                </div>
                                <div class="form-group">
                                    <label for="sample_file">File Input</label>
                                    <input type="file" name="sample_file" class="form-control">
                                </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="closeBtn" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                            <button type="button" id="importBtn" class="btn btn-success waves-effect text-left" >Import</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
@endsection
