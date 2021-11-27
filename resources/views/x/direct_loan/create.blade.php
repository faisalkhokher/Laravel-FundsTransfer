@extends('layouts.backend')

@section('content')

<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Request fund</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Request fund</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Request fund Form</h6>
                <form class="forms-sample" method="POST" action="{{ route('direct_loan.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">ID</label>
                        <input type="text" class="form-control" id="name" autocomplete="off" name="uuid" value="{{$user->uuid}}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" autocomplete="off" name="name" value="{{$user->name}}" disabled>
                    </div>
                  
                    <div class="form-group">
                        <label for="name">Amount</label>
                        <input type="number"  min="1" max="500" step="0.01" class="form-control" id="name" autocomplete="off" name="amount" required>
                    </div>
                    <div class="form-group">
                        <label for="">Interest Rate</label>
                        <select class="form-select" aria-label="" name="duration" required>
                            <option selected>Open this select menu</option>
                            <option value="7">7 Days (10%) Interest</option>
                            <option value="14">14 Days (15%) Interest</option> 
                            <option value="30">30 Days (20%) Interest</option>
                            <option value="60">60 Days (30%) Interest</option>
                          </select>
                        </div>
                    
                    <input type="hidden" value={{$user->id}} name="lyn_id">
                    
                    <button type="submit" class="btn btn-primary mr-2 delete-confirm" data-name="{{ $user->name }}">Submit</button>
                    <a href="{{ route('request_loan.index') }}" class="btn btn-light">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
 $('.delete-confirm').click(function(event) {
      var form =  $(this).closest("form");
      var name = $(this).data("name");
      event.preventDefault();
      swal({
          title: `Confirm Transaction to ${name}?`,
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
