@extends('layouts.backend')

@section('content')

<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a>Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">X-Loans</li>
        </ol>
    </nav>
    {{-- <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a href="{{ route('funds.create') }}" class="btn btn-primary btn-icon-text">
            <i class="btn-icon-prepend" data-feather="plus"></i>
            Add & Edit fund
        </a>
    </div> --}}
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
                                    X User
                                </th>
                                <th>
                                    Lyndr User
                                </th>

                                <th>
                                   Balance
                                </th>

                                <th>
                                    Amount
                                 </th>
                                 <th>
                                    Action
                                 </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Xloans as $key => $item)
                            <tr>
                                {{-- {{ dd($item) }} --}}
                                <td>{{$key++}}</td>
                                <td>
                                  {{ $item->x_user->name ?? 'User NotAssign Any User'}}
                                </td>
                                <td>
                                    {{ $item->lyn_user->name ?? "X User NotAssign Any User"}}
                                </td>
                                <td>
                                    <span class="badge badge-success">{{ $item->amount }}</span>
                                </td>
                                <td>
                                  @if ($item->status == 'accepted')
                                  <span class="badge badge-primary">{{ $item->status }}</span>
                                  @else
                                  <span class="badge badge-danger">{{ $item->status }}</span>
                                  @endif
                                </td>
                                <td>
                                   <a class="btn btn-warning" href="{{route('lynloan.edit',$item->id) }}">   Edit</a>
                                    <form class="d-inline-block" action="{{ route('lynloan.destroy',$item->id) }}"
                                        method="POST">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="btn btn-danger btn-icon-text" onclick="return confirm('Are you sure you want to delete ?')">
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