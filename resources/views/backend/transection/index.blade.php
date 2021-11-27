@extends('layouts.backend')

@section('content')

<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Transections </li>
        </ol>
    </nav>

</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Transections</h6>
                <p class="card-description">All the funds are Transections here.</p>
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Type
                                </th>
                                <th>
                                    Balance
                                </th>
                                <th>
                                    Confirm
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($transactions as $item)
                          <tr>
                            <td>
                                {{$loop->iteration}}
                            </td>
                            <td>
                                {{$item->type}}
                            </td>
                            <td>
                             {{$item->amount/100}}
                         </td>   
                         <td>
                             {{$item->confirmed}}
                         </td>
                         <td>
                             {{$item->created_at}}
                         </td>
                         <td>
                             {{$item->updated_at}}
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