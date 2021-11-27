@extends('layouts.backend')
@section('content')


  <div class="container">
    <div class="row">
     @role('admin')
      <div class="col-md-3">
        <div class="card" style="width: 15rem;">
            <div class="card-body text-center">
                <h5 class="card-title">Total Users</h5>
                <p></p>{{ $total_user }}</p>
            </div>
        </div>
    </div> 

    <div class="col-md-3">
        <div class="card" style="width: 15rem;">
            <div class="card-body text-center">
                <h5 class="card-title">Pending Loans</h5>
                <p></p>{{ $loan }}</p>
            </div>
        </div>
    </div>  
    
    <div class="col-md-3">
        <div class="card" style="width: 15rem;">
            <div class="card-body text-center">
                <h5 class="card-title">Accepted Loans</h5>
                <p></p>{{ $loan_accepted }}</p>
            </div>
        </div>
    </div> 

    <div class="col-md-3">
        <div class="card" style="width: 15rem;">
            <div class="card-body text-center">
                <h5 class="card-title">Transactions Amount</h5>
                <p></p>{{ $transactions }}</p>
            </div>
        </div>
    </div> 
    <div class="row mt-4">
        <div class="col-lg-5 col-xl-4 grid-margin grid-margin-xl-0 stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline mb-2">
                <h6 class="card-title mb-0">users</h6>
                <div class="dropdown mb-2">
                  <button class="btn p-0" type="button" id="dropdownMenuButton6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton6">
                    <a class="dropdown-item d-flex align-items-center" href="{{ url('/admin/users') }}"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                    
                  </div>
                </div>
              </div>
              
              <div class="d-flex flex-column">
                  @foreach ($users as $user)
                      
                 
                <a href="#" class="d-flex align-items-center border-bottom pb-3">
                  <div class="mr-3">
                    @if ($user->avatar == NULL)
                    <img height="30px" src="{{asset('profile/user.jpg')}}" class="avatar">
                    @else
                    <img class="img-xs rounded-circle" src="{{ asset('storage/profile/') . '/' . $user->avatar }}" alt="">
                    @endif
                   
                  </div>
                  <div class="w-100">
                    <div class="d-flex justify-content-between">
                      <h6 class="text-body mb-2">{{ $user->name }}</h6>
                      <p class="text-muted tx-12">{{ \Carbon\Carbon::parse($user->created_at)->diffForhumans() }}</p>
                    </div>
                    <p class="text-muted tx-13">{{ $user->email}}</p>
                  </div>
                </a>
               
                @endforeach
            </div>
            {{ $users->links() }}
        </div>

          </div>
        </div>
        <div class="col-lg-7 col-xl-8 stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline mb-2">
                <h6 class="card-title mb-0">Direct Funds</h6>
                <div class="dropdown mb-2">
                  <button class="btn p-0" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton7">
                    <a class="dropdown-item d-flex align-items-center" href="{{ url ('admin/lynloan') }}"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                   
                  </div>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-hover mb-0">
                  <thead>
                    <tr>
                      <th class="pt-0">#</th>
                      <th class="pt-0">X User</th>
                      <th class="pt-0">Lyndr User</th>
                      <th class="pt-0">Balance</th>
                      <th class="pt-0">Amount</th>
                      <th class="pt-0">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($Xloans as $key => $item)
                    <tr>
                        {{-- {{ dd($item) }} --}}
                        <td>{{$key++}}</td>
                        <td>
                          {{ $item->x_user->name ?? 'User NotAssign Any User'}}
                        </td>
                        <td>
                            {{ $item->lyn_user->name ?? "X User NotAssign Any User"}}
                        </td>
                        <td>
                            <span class="badge badge-success">{{ $item->amount }}</span>
                        </td>
                        <td>
                          @if ($item->status == 'accepted')
                          <span class="badge badge-primary">{{ $item->status }}</span>
                          @else
                          <span class="badge badge-danger">{{ $item->status }}</span>
                          @endif
                        </td>
                        <td>
                           <a class="btn btn-warning" href="{{route('lynloan.edit',$item->id) }}">   Edit</a>
                            <form class="d-inline-block" action="{{ route('lynloan.destroy',$item->id) }}"
                                method="POST">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger btn-icon-text" onclick="return confirm('Are you sure you want to delete ?')">
                                  <i class="btn-icon-prepend" data-feather="trash"></i> Delete
                              </button>
                          </form>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              {{ $Xloans->links() }}
            </div>
          </div>
        </div>
      </div>
     @endrole
    @role('x')
 

    <div class="col-md-3">
        <div class="card" style="width: 15rem;">
            <div class="card-body text-center">
                <h5 class="card-title">Loans</h5>
                <p></p>{{ $loan }}</p>
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
                <a class="dropdown-item d-flex align-items-center" href="{{ route('x.funds.index') }}"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
               
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
            <h6 class="card-title mb-0">FUND TRACKER</h6>
            <div class="dropdown mb-2">
              <button class="btn p-0" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton7">
                <a class="dropdown-item d-flex align-items-center" href="{{ url('x/loan') }}"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                
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
                        MONEY OWN
                    </th>
                    <th>
                       FUND DATE
                    </th>
                    <th>
                        RETURN DATE
                    </th>
                     <th>
                        status
                    </th>
                  
                </tr>
              </thead>
              <tbody>   
                @foreach ($loan_trackers as $key => $item)
                              
                       
                            
                <tr>
                    <td>
                      {{ $item->id }}
                    </td>
                    <td>
                       {{ $item->amount }}
                    </td>
                    <td>
                       {{ $item->start_date}}
                    </td>
                    <td>
                        {{ $item->end_date}}
                     </td>
                   
                    <td>
                        @if ($item->status == 'pending')
                        <span class="badge badge-warning">pending</span>
                        @else
                        <span class="badge badge-success">accepted</span>
                        @endif
                         
                    </td>
                    </tr>
  
                @endforeach
                
              </tbody>
            </table>
          </div>
          {{ $loan_trackers->links() }} 
        </div>
      </div>
    </div>
  </div>
  @endrole
 <!-- row -->

 <!-- row -->

  <!-- row -->
</div>
@endsection
