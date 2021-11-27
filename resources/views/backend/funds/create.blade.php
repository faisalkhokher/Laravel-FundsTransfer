@extends('layouts.backend')

@section('content')

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('funds.index') }}">Funds</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Funds</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Form</h6>
                    <form class="forms-sample" method="POST" action="{{ route('funds.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">User</label>
                               <select class="form-select" aria-label="Default select example" name="name" required>
                                   <option disabled selected value>List of users</option>
                                   @foreach($users as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                        </div>

                        <div class="form-group">
                            <label for="deposit">Amount De1posit</label>
                            <input type="number" step="0.01" class="form-control" id="deposit" autocomplete="off" placeholder="Enter Amount" name="deposit" required>
                        </div>
                        <div class="form-group">
                            <label for="deposit">Reference Deposit*</label>
                            <input type="text" class="form-control" id="deposit" autocomplete="off" placeholder="" name="reference_id">
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="{{ route('funds.index') }}" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
