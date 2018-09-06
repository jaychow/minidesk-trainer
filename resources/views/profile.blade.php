@extends('layouts.app')
@section('content')
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
               <!-- Row -->
               <div class="row">
                <!-- Column -->
                <div class="col-lg-4 col-xlg-3 col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <center class="m-t-30"> <img src="{{ asset('assets/images/user.png') }}" class="rounded-circle" width="150" />
                                <h4 class="card-title m-t-10" id="d-name"></h4>
                            </center>
                        </div>
                        <div>
                            <hr> </div>
                        <div class="card-body"> <small class="text-muted">Email address </small>
                            <h6 id="d-email"></h6>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-8 col-xlg-9 col-md-7">
                    <div class="card">
                        <!-- Tabs -->
                        <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false">Setting</a>
                            </li>
                        </ul>
                        <!-- Tabs -->
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
                                <div class="card-body">
                                    <form class="form-horizontal form-material" id="form1">
                                        <div class="form-group">
                                            <label class="col-md-12">Full Name</label>
                                            <div class="col-md-12">
                                                <input type="text" name="name" id="name" placeholder="Enter your name" class="form-control form-control-line">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-email" class="col-md-12">Email</label>
                                            <div class="col-md-12">
                                                <input type="email" placeholder="example@email.com" class="form-control form-control-line" name="email" id="email">
                                            </div>
                                        </div>
                                    </form>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button class="btn btn-success" id="updateBtn1">Update Profile</button>
                                            </div>
                                        </div>
                                </div>

                                <div class="card-body">
                                    <form class="form-horizontal form-material" id="form2">
                                        <div class="form-group">
                                            <label class="col-md-12">New Password</label>
                                            <div class="col-md-12">
                                                <input type="password" id="password" name="password" class="form-control form-control-line">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-email" class="col-md-12">Confirm New Password</label>
                                            <div class="col-md-12">
                                                <input type="password" id="confirm_password" name="confirm_password" class="form-control form-control-line">
                                            </div>
                                        </div>
                                    </form>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button class="btn btn-success" id="updateBtn2">Change Password</button>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
            </div>
            <!-- Row -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
@endsection
