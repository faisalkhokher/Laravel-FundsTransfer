@extends('layouts.lyndrix')

@section('content')

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Request Tracker</li>
            </ol>
        </nav>
   
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">

            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Request Tracker</h6>
                    <p class="card-description">All the Request Tracker are listed here.</p>
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
                                   Return Date
                                </th>
                               
                                <th>
                                    Status
                                </th>
                             
                               
                            </tr>
                            </thead>
                            <tbody>
                                
                            @foreach($new_transactions as $key => $new_transaction)
                         
                                <tr>
                                    <td>
                                     {{ ++$key }}
                                    </td>
                                    <td>
                                       {{ $new_transaction['transfer']->amount/100 }}
                                    </td>
                                    <td>
                                       {{ $new_transaction['loan_details']->end_date }}
                                    </td>
                                   
                                    <td>
                                        @if ($new_transaction['loan_details']->status == 'accepted')
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
