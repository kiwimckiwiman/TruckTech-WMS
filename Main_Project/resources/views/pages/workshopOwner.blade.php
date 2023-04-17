@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
{{-- USES USERS TABLE!!!!!!! --}}
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Create workshop owner'])

    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Create Workshop Owner profile</p>
                            <button class="btn btn-primary btn-sm ms-auto">Settings</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-uppercase text-sm">User Information</p>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Username</label>
                                    <input class="form-control" type="text" value="nimra901">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Email address</label>
                                    <input class="form-control" type="email" value="nimra@example.com">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Full Name - AS PER PASSPORT</label>
                                    <input class="form-control" type="text" value="Nimra Khan">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Date of Birth</label>
                                    <input class="form-control" type="date" >
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Enter Password</label>
                                    <input class="form-control" type="password" value="nimra1234">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Re-enter password</label>
                                    <input class="form-control" type="password" value="nimra1234">
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        
                        <button class="btn btn-primary btn-sm ms-auto">Cancel</button>
                        <button class="btn btn-primary btn-sm ms-auto">Submit</button>

                    </div>
                </div>
            </div>
          
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
