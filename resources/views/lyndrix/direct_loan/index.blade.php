@extends('layouts.lyndrix')

@section('content')

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fund Tracker</li>
            </ol>
        </nav>
   
    </div>

  
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">

            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Direct Fund</h6>
                    <p class="card-description">All the Packages are listed here.</p>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
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
                                    Duration
                                </th>
                                <th>
                                    Start Date
                                </th>
                               
                                <th>
                                    End Date
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
                              
                            @foreach($xloans as $key => $xloan)
                               
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center hover-pointer">

                                            @if (Auth()->user()->avatar == NULL)
                                            <img height="30px" src="{{asset('profile/user.jpg')}}" class="avatar">
                                            @else
                                            <img class="img-xs rounded-circle" src="{{ asset('public/profile/') . '/' . $xloan->user->avatar }}" alt="">
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
                                        {{ $xloan->duration }} Days
                                     </td>
                                    
                                    <td>
                                        {{ \Carbon\Carbon::parse($xloan->start_date)->diffForhumans() }}
                                     </td>
                                   
                                    <td>
                                        {{ \Carbon\Carbon::parse($xloan->end_date)->diffForhumans() }}
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
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
 $('.accept-confirm').click(function(event) {
      var form =  $(this).closest("form");
      var name = $(this).data("name");
     
      event.preventDefault();
      swal({
          title: `Are you sure you want to Confirm Accept Fund`,
          text: "If you Transaction this, it will be gone forever.",
          icon: "warning",
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          form.submit();
        }
      });
  });
  $('.decline-confirm').click(function(event) {
      var form =  $(this).closest("form");
      var name = $(this).data("name");
      event.preventDefault();
      swal({
          title: `Are you sure you want to Decline Fund`,
          text: "If you Transaction this, it will be gone forever.",
          icon: "warning",
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          form.submit();
        }
      });
  });
</script>
@endsection
