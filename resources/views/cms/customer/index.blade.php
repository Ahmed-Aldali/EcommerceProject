@extends('cms.parent')

@section('title' , 'Index Customer')

@section('main_title' , 'Index Customer')

@section('sub_title' , 'index of Customer')


@section('styles')

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          {{-- @can('Create-Customer') --}}
          <a href="{{route('customers.create')}}" type="submit" class="btn btn-info">Add New Customer</a>
          {{-- @endcan --}}
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="width: 10px">id</th>

                <th>Image</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Status</th>
                <th>mobile</th>
                <th>City Name</th>


                <th>Setting</th>

              </tr>
            </thead>
            <tbody>

                @foreach ($customers as $customer )
                <tr>
                    <td>{{$customer->id  }}</td>
                    <td>
                      <img class="img-circle img-bordered-sm" src="{{asset('storage/images/customer/'.$customer->user->image)}}" width="50" height="50" alt="User Image">
                  </td>
                    <td>{{ $customer->user->first_name ?? ""}}</td>
                    <td>{{ $customer->user->last_name ?? ""}}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->user->gender ?? ""}}</td>
                    <td>{{ $customer->user->status ?? ""}}</td>
                    <td>{{ $customer->user->mobile ?? ""}}</td>
                    {{-- <td>{{ $customer->user ? $customer->user->mobile : "" }}</td> --}}

                    {{-- <td>{{ $customer->country->name }}</td> --}}
                    <td><span class="badge bg-success"> {{$customer->user->city->name ?? ""}}</span></td>


                    <td>
                        <div class="btn-group">
                          {{-- @can('Edit-Customer') --}}
                          <a href="{{route('customers.edit' , $customer->id )}}" type="button" class="btn btn-info">edit</a>
                          {{-- @endcan --}}
                          {{-- @can('Delete-Customer') --}}
                          <button type="button" onclick="performDestroy({{$customer->id }} , this)" class="btn btn-danger">delete</button>
                          {{-- @endcan --}}
                          {{-- <button type="button" class="btn btn-success">show</button> --}}
                        </div>
                      </td>
                  </tr>
                @endforeach




            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
        {{ $customers->links() }}
      </div>
      <!-- /.card -->


      <!-- /.card -->
    </div>
    <!-- /.col -->

    <!-- /.col -->

    @endsection

@section('scripts')

<script>
    function performDestroy(id , reference){

        confirmDestroy('/cms/customers/'+id  ,reference );

    }

    </script>
@endsection
