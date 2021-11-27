@extends('layouts.backend')

@section('content')

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Funds</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update Funds</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Funds Update Form</h6>
                    <form class="forms-sample" method="POST" action="{{ route('lynloan.update', $Xloan->id) }}">
                        @method('PATCH')
                        @csrf


                        <div class="form-group">
                            <label for="name">X-Users</label>
                            <select class="form-select" aria-label="Default select example" name="user_id">
                             @foreach ($users as $user)
                             <option value="{{ $user->id }}" {{ $user->id == $Xloan->user_id ? ' selected="selected"' : ''}}>{{ $user->name }}</option>
                             @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">Trending Post</label>
                            <select class="form-select" aria-label="Default select example" name="lyn_id">
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $user->id == $Xloan->lyn_id ? ' selected="selected"' : ''}}>{{ $user->name }}</option>
                                @endforeach
                              </select>
                        </div>

     

                        <div class="form-group">
                            <label for="name"> Start Date </label>
                            <input type="text" class="form-control" id="amount" autocomplete="off"
                                   placeholder="Amount" name="start_date" value="{{ $Xloan->start_date }}">
                        </div>

                        <div class="form-group">
                            <label for="name"> End Date  </label>
                            <input type="text" class="form-control" id="amount" autocomplete="off"
                                   placeholder="Amount" name="end_date" value="{{ $Xloan->end_date }}">
                        </div>

                        <div class="form-group">
                            <label for="name"> Amount</label>
                            <input type="text" class="form-control" id="amount" autocomplete="off"
                                   placeholder="Amount" name="amount" value="{{ $Xloan->amount }}">
                        </div>

                        <div class="form-group">
                            <select name="status">
                                <option value="pending"  {{ 'pending' == $Xloan->status ? ' selected="selected"' : ''}}>Pending</option>
                                <option value="accepted"  {{ 'accepted' == $Xloan->status ? ' selected="selected"' : ''}}>Accepted</option>
                              </select>
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="{{ route('users.index') }}" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
