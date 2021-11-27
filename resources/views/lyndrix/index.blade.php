@extends('layouts.lyndrix')
@section('content')
<div class="container">
    <div class="row">
    
     

    <div class="col-md-3">
        <div class="card" style="width: 15rem;">
            <div class="card-body text-center">
                <h5 class="card-title">User Request for loan</h5>
                <p>{{ $xloans }}
                </p>
            </div>
        </div>
    </div>  
    
    <div class="col-md-3">
        <div class="card" style="width: 15rem;">
            <div class="card-body text-center">
                <h5 class="card-title">Loan Tracker</h5>
                <p>{{$transactions}}</p>
            </div>
        </div>
    </div> 

    <div class="col-md-3">
        <div class="card" style="width: 15rem;">
            <div class="card-body text-center">
                <h5 class="card-title">Transactions Amount</h5>
                <p></p>{{Auth::user()->balanceFloat}}</p>
            </div>
        </div>
    </div> 
   
  
  
    </div>


   <!-- row -->
   <div class="row mt-4">
    <div class="col-lg-5 col-xl-4 grid-margin grid-margin-xl-0 stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-baseline mb-2">
            <h6 class="card-title mb-0">Funds</h6>
            <div class="dropdown mb-2">
              <button class="btn p-0" type="button" id="dropdownMenuButton6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton6">
                <a class="dropdown-item d-flex align-items-center" href="{{ url('/lyndrx/funds') }}"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
               
              </div>
            </div>
          </div>
          <div class="d-flex flex-column">
            <a href="#" class="d-flex align-items-center border-bottom pb-3">
            
              <div class="w-100">
                <table class="table">
                    <thead>
                    <tr>
                       
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($deposits as $key => $deposit)
                        <tr>
                           
                            <th><span class="badge badge-success">{{ $deposit->type }}</span></th>
                            <td><span class="h5">$ {{ ($deposit->amount/100) }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($deposit->created_at)->diffForhumans() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
              </div>
            </a>
         
          </div>
          {{ $deposits->links() }} 
        </div>
      </div>
    </div>
    <div class="col-lg-7 col-xl-8 stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-baseline mb-2">
            <h6 class="card-title mb-0">Direct Fund</h6>
            <div class="dropdown mb-2">
              <button class="btn p-0" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton7">
                <a class="dropdown-item d-flex align-items-center" href="{{ url('/lyndrx/direct_loan') }}"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        By
                    </th>
                    <th>
                       Amount
                    </th>
                    <th>
                        Profit
                    </th>
                    
                   
                    <th>
                        status
                    </th>
                    <th>
                        Action
                    </th>
                </tr>
              </thead>
              <tbody>   
                @foreach($direct_loans as $key => $xloan)
                               
                <tr>
                    <td>
                        {{ ++$key }}
                    </td>
                    <td>
                        <div class="d-flex align-items-center hover-pointer">

                            @if (Auth()->user()->avatar == NULL)
                            <img height="30px" src="{{asset('profile/user.jpg')}}" class="avatar">
                            @else
                            <img class="img-xs rounded-circle" src="{{ asset('storage/profile/') . '/' . $xloan->user->avatar }}" alt="">
                            @endif
                           
                            <div class="ml-2">
                                <p>{{  $xloan->user->name }}</p>
                                <p class="tx-11 text-muted">{{ \Carbon\Carbon::parse($xloan->created_at)->diffForhumans() }}</p>
                            </div>
                        </div>
                        
                    </td>
                    <td>
                        {{ $xloan->amount }}
                    </td>
                     <td>
                        {{ $xloan->interest_rate }} %
                     </td>
                    
                   
                    <td>
                      
                       
                        @if ($xloan->status == 'pending')
                        <span class="badge badge-warning">pending</span>
                            
                        @endif
                    </td>
                    <td>
                        @if ($xloan->status == 'pending')
                        
                        <a href="{{ route('explore_page.edit',$xloan->id)}}" class="btn btn-primary">Accept</a>
                      
                        <form class="forms-sample d-inline" method="POST" action="{{ route('lyndrx.decline.fund',$xloan->id)}}">
                            @csrf
                            <button type="submit" class="btn btn-primary decline-confirm">Decline</button>
                        </form> 
                        @endif
                      

                   </td>
                
                   
                </tr>
    
            @endforeach
                
              </tbody>
            </table>
          </div>
          {{ $direct_loans->links() }} 
        </div>
      </div>
    </div>
  </div>

 <!-- row -->
 
 <!-- row -->

  <!-- row -->
</div>
@endsection


