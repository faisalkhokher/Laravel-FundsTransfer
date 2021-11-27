@extends('layouts.app')
@section('content')
    <div class="page-wrapper full-page">
        <div class="page-content d-flex align-items-center justify-content-center">
            <div class="row w-100 mx-0 auth-page">
                <div class="col-12 col-md-5 col-lg-6 col-xl-4 px-lg-6">
                    <div class="card">
                        <div class="row">
                              
                            <div class="col-md-11 pl-md-0" style="
                                margin-left: 21px;">
                                <div class="auth-form-wrapper px-4 py-5">
                                    <img src="{{URL::asset('/images/logo.png')}}" alt="" height="90" width="90" style="
                                    margin-left: 8rem;
                                ">

                                    <form class="tab-content py-6" id="wizardSteps" action="{{ route('signup') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="tab-pane fade show active" id="wizardStepOne" role="tabpanel"
                                            aria-labelledby="wizardTabOne">

                                            <!-- Header -->
                                            <div class="row justify-content-center">
                                                <div class="col-12 col-md-10  text-center">

                                                    <!-- Pretitle -->
                                                    <p class="mb-4 text-uppercase">
                                                        Step 1 of 2
                                                    </p>

                                                    <!-- Title -->
                                                    <h1 class="mb-3" style="
                                    font-size: 1rem;
                                    font-weight: 400 !important;">
                                                        Personal Details
                                                    </h1>

                                                </div>
                                            </div>
                                             {{-- image upload --}}

                                             
                                             <div class="profile-pic">
                                                <label class="-label" for="file" style="
                                                margin-bottom: 1rem;
                                            ">
                                                  <span class="glyphicon glyphicon-camera"></span>
                                                  <span>Change Image</span>
                                                </label>
                                                <input id="file" type="file" name="avatar" onchange="loadFile(event)"/>
                                                <img src="{{URL::asset('/images/user.jpg')}}" id="output" width="200" />
                                              </div>
                                            <div class="row">
                                               
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputUsername1">Name</label>
                                                        <input type="text" required class="form-control " name="name"
                                                            id="exampleInputUsername1" autocomplete="Username"
                                                            placeholder="Username">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputUsername1">Phone Number</label>
                                                        <input type="phone" required class="form-control" name="phone"
                                                            id="exampleInputUsername1" autocomplete="Username"
                                                            placeholder="Phone Number">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Email address</label>
                                                        <input type="email" required class="form-control" name="email"
                                                            id="exampleInputEmail1" placeholder="Email">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Company Name</label>
                                                        <input type="text" required class="form-control" name="company_name"
                                                            id="exampleInputEmail1" placeholder="Company Name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Password</label>
                                                        <input type="password" class="form-control" required name="password" id=""
                                                            placeholder="Password">
                                                    </div>
                                                </div>

                                            </div>
                                            

                                            <hr class="my-3">


                                            <div class="row align-items-center">
                                                <div class="col-auto">


                                                    <button class="btn btn-warning" type="reset">Cancel</button>

                                                </div>
                                                <div class="col text-center">


                                                    <p class="text-uppercase text-muted mb-0">Step 1 of 2</p>

                                                </div>
                                                <div class="col-auto">


                                                    <a class="btn btn-primary" data-toggle="wizard"
                                                        href="#wizardStepTwo">Continue</a>

                                                </div>
                                            </div>

                                        </div>

                                        {{-- Section 2 --}}

                                        <div class="tab-pane fade" id="wizardStepTwo" role="tabpanel"
                                            aria-labelledby="wizardTabTwo">

                                            <!-- Header -->
                                            <div class="row justify-content-center">
                                                <div class="col-12 col-md-10  text-center">

                                                    <!-- Pretitle -->
                                                    <h6 class="mb-4 text-uppercase text-muted">
                                                        Step 2 of 2
                                                    </h6>

                                                    <!-- Title -->
                                                    <h6 class="mb-3">
                                                        legal Details
                                                    </h6>

                                                </div>
                                            </div>




                                            <!-- Team description -->


                                            <div class="row">
                                                <div class="col-md-12">
                                                   <div class="form-group">
                                                     <label for="exampleInputPassword1">Social Security</label>
                                                     <input type="text" class="form-control" name="social_code" placeholder="Social Security">
                                                    </div>
                                                 </div>
                                              
                                              </div>

                                            <div class="row">
                                                
                                                 <div class="col-md-12">
                                                
                                                     <div class="form-group">
                                                         <label for="exampleInputPassword1">License/State ID</label>
                                                         <input type="file" class="form-control" name="license_image">
                                                     </div>
                                                 </div>
                                            </div>
                                       <div class="row">
                                        <div class="form-check">
                                        <input class="form-check-input" type="radio" name="role" id="exampleRadios1" value="3" checked style="
                                        margin-left: 2rem;
                                    ">
                                        <label class="form-check-label" for="exampleRadios1" style="
                                        margin-left: 3rem;
                                    ">
                                         x   
                                        </label>
                                      </div>
                                      <div class="form-check" style="
                                      margin-left: 119px;">
                                        <input class="form-check-input" type="radio" name="role" id="exampleRadios2" value="4" style="
                                        margin-left: 10px;
                                    ">
                                        <label class="form-check-label" for="exampleRadios2">
                                            Lyndr
                                        </label>
                                      </div>
                                    </div>

                                            <hr class="my-5">

                                            <!-- Footer -->
                                            <div class="row align-items-center">
                                                <div class="col-auto">

                                                    <!-- Button -->
                                                    <a class="btn btn-warning" data-toggle="wizard"
                                                        href="#wizardStepOne">Back</a>

                                                </div>
                                                <div class="col text-center">

                                                    <!-- Step -->
                                                    <p class="text-uppercase text-muted mb-0">Step 2 of 2</p>

                                                </div>
                                                <div class="col-auto">

                                                    <!-- Button -->
                                                    <button class="btn btn-primary" type="submit">Submit</button>

                                                </div>
                                            </div>

                                        </div>
                                      
                                        <a href="{{ route('login') }}" class="d-block mt-3 text-muted">Already a user?
                                            Sign in</a>
                                    </form>



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
@endsection
<style>
    .profile-pic {
  color: transparent;
  transition: all 0.3s ease;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
  transition: all 0.3s ease;
}
.profile-pic input {
  display: none;
}
.profile-pic img {
  position: absolute;
  object-fit: cover;
  width: 165px;
  height: 165px;
  box-shadow: 0 0 10px 0 rgba(255, 255, 255, 0.35);
  border-radius: 100px;
  z-index: 0;
}
.profile-pic .-label {
  cursor: pointer;
  height: 165px;
  width: 165px;
}
.profile-pic:hover .-label {
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: rgba(0, 0, 0, 0.8);
  z-index: 10000;
  color: #fafafa;
  transition: background-color 0.2s ease-in-out;
  border-radius: 100px;
  margin-bottom: 0;
}
.profile-pic span {
  display: inline-flex;
  padding: 0.2em;
  height: 2em;
}



</style>
@section('scripts')
    <script>
        $(document).ready(function() {
            var e = document.querySelectorAll('[data-toggle="wizard"]');
            [].forEach.call(e, function(t) {
                t.addEventListener("click", function(e) {
                    e.preventDefault(), $(t).tab("show").removeClass("active")
                })
            });
            
        });
        var loadFile = function(event) {
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
            }; 
    </script>

@endsection
