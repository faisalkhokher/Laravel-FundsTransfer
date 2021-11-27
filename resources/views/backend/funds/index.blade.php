@extends('layouts.backend')

@section('content')

<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">funds</li>
        </ol>
    </nav>

</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Funds</h6>
                <p class="card-description">All the funds are listed here.</p>
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    User
                                </th>
                                <th>
                                    Balance
                                </th>
                                <th>
                                    Transection
                                </th>
                                <th>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $item)
                            <tr>
                                <td>{{$key++}}</td>
                                <td>{{$item->name}}</td>
                                <td><span class="badge badge-success">{{$item->balanceFloat}}</span>
                                </td>
                                <td>
                                    <a href="{{route('fetch.transections' , $item->id)}}">Transections</a>
                                </td>
                                <td>

                                    <form class="d-inline-block" action="{{ route('funds.destroy',$item->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-icon-text"
                                            onclick="return confirm('Are you sure you want to delete this user wallet ?')">
                                            <i class="btn-icon-prepend" data-feather="trash"></i> Delete
                                        </button>
                                    </form>
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