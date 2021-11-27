@extends('layouts.backend')

@section('content')

<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Request Fund</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Request Fund</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Request Fund Form</h6>
                <form class="forms-sample" method="POST" action="{{ route('request_loan.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Amount</label>
                        <input type="number"  min="1" max="999" step="0.01" class="form-control" id="name" autocomplete="off" name="amount" required="required">
                    </div>
                    <div class="form-group">
                    <label for="">Interest Rate</label>
                    <select class="form-select" aria-label="" name="duration" required="required">
                        <option selected disabled>Open this select menu</option>
                        <option value="7">7 Days (10%) Interest</option>
                        <option value="14">14 Days (15%) Interest</option> 
                        <option value="30">30 Days (20%) Interest</option>
                        <option value="60">60 Days (30%) Interest</option>
                      </select>
                    </div>
                      
                   <button type="submit" class="btn btn-primary mr-2 delete-confirm">Submit</button>
                   

                    <a href="{{ route('request_loan.index') }}" class="btn btn-light">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
 $('.delete-confirm').click(function(event) {
      var form =  $(this).closest("form");
      var name = $(this).data("name");
      event.preventDefault();
      swal({
          title: `Are you sure you want to Confirm Transaction`,
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
