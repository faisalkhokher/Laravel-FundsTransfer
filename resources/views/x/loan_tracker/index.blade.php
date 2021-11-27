@extends('layouts.backend')

@section('content')

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">fund Tracker</li>
            </ol>
        </nav>
   
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
                </div>
            </div>
        </div>
    </div>

    
@endsection
