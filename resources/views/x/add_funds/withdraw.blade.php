@extends('layouts.backend')

@section('content')

    <div class="row mb-2">
        <div class="col-6">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">X</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Withdraw Funds</li>
                </ol>
            </nav>
        </div>
        <div class="col-6 text-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#withdraw_fund">Withdraw Funds</button>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Withdrawals</h6>
                    <p class="card-description">All the withdrawals will be shown here.</p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($withdrawls as $withdrawl)
                                <tr>
                                    <th>{{ $withdrawl->uuid }}</th>
                                    <th><span class="badge badge-success">{{ $withdrawl->type }}</span></th>
                                    <td><span class="h5">$ {{ ($withdrawl->amount/100) }}</span></td>
                                    <td>{{ $withdrawl->created_at }}</td>
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

