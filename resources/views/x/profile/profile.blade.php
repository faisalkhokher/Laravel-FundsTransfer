@extends('layouts.backend')

@section('content')
<!-- Main content -->
    <section >

        <div class="row">
            <div class="col-3">
              <div class="list-group" id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Update Profile</a>

               
      <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">Settings</a> 
            </div>
            </div>
            <div class="col-9">
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                    <div class="col-md-9">
                        <div class="nav-tabs-custom">
                    
                
                          <ul class="nav nav-tabs">
                            <li class="active"><a href="#settings" data-toggle="tab">Update Profile</a></li>
                          </ul>
                          <div class="tab-content">
              
                            <div class="tab-pane active" id="settings">
                              <form role="form" method="post" action="{{ route('x.edit.profile') }}">
                                @csrf
                                <div class="row">
              
                                  <div class="col-md-4">
                                    <div class="box-body">
                                      <div class="form-group">
                                        <label for="exampleInputEmail1">Name<label class="text-danger">*</label></label>
                                        <input type="text" class="form-control" id="" placeholder="Enter Name" name="name" value="{{$user->name}}">
                                      </div>
                                      <div class="form-group">
                                        <label for="exampleInputPassword1">Phone</label>
                                        <input type="text" class="form-control" placeholder="phone" name="phone" value="{{$user->phone}}">
                                      </div>
                                      
                                    
                                    </div>
                                  </div>
              
                                  <div class="col-md-4">
                                    <div class="box-body">
                                      <div class="form-group">
                                        <label for="exampleInputEmail1">Email<label class="text-danger">*</label></label>
                                        <input disabled type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter Email" name="email" value="{{$user->email}}">
                                      </div>
                                  </div>
                                    <div class="form-group">
                                      <label for="exampleInputPassword1">Social Code</label>
                                      <input disabled type="text" class="form-control" placeholder="Social Code" name="social_code" value="{{$user->social_code}}">
                                    </div>
                                  </div>
                                  <div class="col-md-8">
                                    
                                    @role('lyndrx')
                                    <div class="form-group">
                                      <label for="exampleInputPassword1">Company Name</label>
                                      <input type="text" class="form-control" placeholder="company name" name="company_name" value="{{$user->company_name}}">
                                    </div>
                                    @endrole
                                  </div>
                                </div>
              
                              
                               <br>
                                <div class="box-footer">
                                  <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                              </form>
                            </div>
                            <!-- /.tab-pane -->
                          </div>
                          <!-- /.tab-content -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                      </div>
                </div>
                <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">...</div>
               
                <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
                <form role="form" method="post" action="{{ route('x.edit.password') }}">
                    @csrf
                <div class="col-md-8">
                  <div class="form-group">
                    <label class="">Old Password</label class="text-danger">*</label></label>
                    <input type="password" class="form-control pull-right"  placeholder="Current Password" name="old_password">
                   <!-- /.input group -->
                  </div>
                  <div class="form-group" style="
                  margin-top: 54px;">
                    <label>Confrm Password</label class="text-danger">*</label></label>
                    <input type="password" class="form-control pull-right"  placeholder="Current Password" name="confirm-password">
                   <!-- /.input group -->
                  </div>
                  <div class="form-group" style="
                  margin-top: 54px;">
                    <label for="exampleInputPassword1">New Password</label>
                    <input type="password" class="form-control" placeholder="Password" name="password">
                  </div>
                </div>
                
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                  </form>
                </div>
              </div>
            </div>
              
            <!-- /.box-body -->
          </div>
      <!-- /.box -->
     </div>
        <!-- /.col -->


       
        <!-- /.col -->
     
      </div>
      <!-- /.row -->
    
  

    </section>
    <!-- /.content -->

@endsection