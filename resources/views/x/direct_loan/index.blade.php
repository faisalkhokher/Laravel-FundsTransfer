@extends('layouts.backend')

@section('content')

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Direct Loan</li>
            </ol>
        </nav>
   
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">

            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Direct Loan</h6>
                    <p class="card-description">All the Direct Loan are listed here.</p>
                    <div class="row">
                      @foreach ($users as $user)
                          
                  
                        <div class="col-md-3">
                            <div class="card">
                                @if ($user->avatar == null)
                                <img src="{{asset('profile/user.jpg')}}" class="avatar">
                                 @else
                                <img height="200px" src="{{asset('public/profile/'. $user->avatar)}}" class="avatar avatar-sm rounded">
                                @endif
                                <div class="card-body text-center">
                                  <h5 class="card-title">{{$user->name }}</h5>
                                  <p class="card-text ">{{$user->uuid}}</p>
                                  <p class="card-text ">{{$user->email}}</p>
                                  <a href="{{ route('direct_loan.edit',$user->uuid )}}" class="btn btn-primary mt-2">Direct Request fund</a>
                                </div>
                               
                              </div>
                        </div>
                        @endforeach
                 </div>
                    
                  
                </div>
            </div>
        </div>
    </div>
@endsection
