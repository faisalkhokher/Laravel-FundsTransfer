@extends('layouts.backend')

@section('content')

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contact us</li>
            </ol>
        </nav>
   
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
{{-- 
            <div class="card">
                <div class="card-body">
                     <div class="col-lg-12 grid-margin stretch-card">
						<div class="card">
							<div class="card-body">
								<h4 class="card-title">Contact us</h4>
								
							
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="col-form-label">Name</label>
									</div>
									<div class="col-lg-8">
										<input class="form-control" maxlength="20" name="defaultconfig-2" id="defaultconfig-2" type="text" placeholder="Enter Name">
									</div>
								</div>
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="col-form-label">Email</label>
									</div>
									<div class="col-lg-8">
										<input class="form-control" maxlength="10" name="defaultconfig-3" id="defaultconfig-3" type="text" placeholder="Enter Email">
									</div>
								</div>
								<div class="form-group mb-0 row">
									<div class="col-lg-3">
										<label class="col-form-label">Message</label>
									</div>
									<div class="col-lg-8">
										<textarea id="maxlength-textarea" class="form-control" maxlength="100" rows="8" placeholder="This textarea has a limit of 100 chars."></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
               
                </div>
            </div> --}}
        </div>
    </div>
@endsection

@section('script')

<!--Start of Tawk.to Script-->
<script>

	var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
	(function(){
	var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
	s1.async=true;
	s1.src='https://embed.tawk.to/60ee83e9d6e7610a49ab2d25/1fahr6io4';
	s1.charset='UTF-8';
	s1.setAttribute('crossorigin','*');
	s0.parentNode.insertBefore(s1,s0);
	})();
	</script>
	<!--End of Tawk.to Script-->
@endsection