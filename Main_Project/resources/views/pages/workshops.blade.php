@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
{{-- USES USERS TABLE!!!!!!! --}}
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Create workshops'])

    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Create Workshops</p>
                            <button class="btn btn-primary btn-sm ms-auto">Settings</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-uppercase text-sm">Workshop Information</p>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Workshop Name</label>
                                    <input class="form-control" type="text" value="Auto workshop Kuching">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Workshop Location</label>
                                    <textarea class="form-control" rows="4" cols="50" >Friendship Auto Workshop Sdn Bhd, No. 114 - 116, Lot 41, 42 & 28, Sect 21, KTLD, Jalan Tun Abang Haji Openg, 93000 Kuching, Sarawak
                                    </textarea>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Opening Hours</label>
                                    <input class="form-control" type="time" value="11:00">
                                </div>
                            </div>
                            {{-- CLOSING HPURS --}}
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Closing Hours</label>
                                    <input class="form-control" type="time" value="17:00">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Specialization</label>
                                    <input class="form-control" type="text" value="engine repair">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Phone Number</label>
                                    <input class="form-control" type="tel" value="+60192789102">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Choose Workshop Owner</label>
                                    <select name="cars" class="form-control">
                                        {{-- THIS WILL BE IN A LOOP. DATA WILL BE TAKEN FROM USERS TABLE WHERE TYPE== workshop owner --}}
                                        <option value="andy">Andy</option>
                                        <option value="Murtada">Murtada</option>
                                        <option value="Mariny">Hamza</option>
                                        <option value="Mariny">Mariny</option>
                                      </select>
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
