@extends('layouts.backend')

@section('content')

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Fund</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <a href="{{ route('request_loan.create') }}" class="btn btn-primary btn-icon-text">
                <i class="btn-icon-prepend" data-feather="plus"></i>
                Create Request Fund
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">

            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">fund Tracker</h6>
                    <p class="card-description">All the Packages are listed here.</p>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Money Owe
                                </th>
                                <th>
                                    Amount With Interest
                                </th>
                                <th>
                                    Interest Rate
                                </th>
                                <th>
                                    Duration
                                </th>
                                
                               <th>
                                fund Date
                               </th>
                                <th>
                                   Return Date
                                <th>
                                    Status
                                </th>
                                
                            </tr>
                            </thead>
                            <tbody>
                               
                           @foreach ($data as $key => $item)
                              
                       
                            
                                <tr>
                                    <td>
                                      {{ $item->id }}
                                    </td>
                                    <td>
                                       {{ $item->amount }}
                                    </td>
                                    <td>
                                        {{ $item->amount_with_interest }}
                                     </td>
                                     <td>
                                        {{ $item->interest_rate }} %
                                     </td>
                                     <td>
                                        {{ $item->duration }}
                                     </td>
                                     
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->start_date)->diffForhumans() }}
                                      
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse( $item->end_date)->diffForhumans() }}
                                       
                                     </td>
                                   
                                    <td>
                                        
                                        @if ($item->status == 'pending')
                                        <span class="badge badge-warning">pending</span>
                                        <a href="{{ route('x.fund.transfer') }}" class="btn btn-primary">Transfer</a>
                                        @elseif ($item->status == 'accepted')
                                        <span class="badge badge-success">InProgress</span>
                                        <a href="{{ route('x.fund.transfer') }}" class="btn btn-primary disabled">Transfer</a>
                                        @elseif ($item->status == 'completed')
                                       
                                         <span class="badge badge-warning">completed</span>
                                         <a href="{{ route('x.fund.transfer') }}" class="btn btn-primary disabled">Transfer</a>
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
{{-- @section('scripts')
<script>
    $('.delete-subcategories').click(function() {
      var id = $(this).attr('data-id');
      swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                $.ajax({

                    url: '/admin/delete-subcategory/'+id,

                    type: 'GET',

                    dataType: 'JSON',

                    cache: false,

                    success: function (data) {
                     
                    console.log('fdsa');    

                    },

            error: function (jqXHR, textStatus, errorThrown) {

            }

});
    // swal("Poof! Your imaginary file has been deleted!", {
    //   icon: "success",
    // });
  } else {
    swal("Your imaginary file is safe!");
  }
}); 
});
</script>
@endsection --}}