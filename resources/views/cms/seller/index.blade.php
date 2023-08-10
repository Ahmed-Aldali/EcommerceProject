@extends('cms.parent')

@section('title' , 'Index Seller')

@section('main_title' , 'Index Seller')

@section('sub_title' , 'index of Seller')


@section('styles')

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          {{-- @can('Create-Seller') --}}
          <a href="{{route('sellers.create')}}" type="submit" class="btn btn-info">Add New Seller</a>
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

                @foreach ($sellers as $seller )
                <tr>
                    <td>{{$seller->id  }}</td>
                    <td>
                      <img class="img-circle img-bordered-sm" src="{{asset('storage/images/seller/'.$seller->user->image)}}" width="50" height="50" alt="User Image">
                  </td>
                    <td>{{ $seller->user->first_name ?? ""}}</td>
                    <td>{{ $seller->user->last_name ?? ""}}</td>
                    <td>{{ $seller->email }}</td>
                    <td>{{ $seller->user->gender ?? ""}}</td>
                    <td>{{ $seller->user->status ?? ""}}</td>
                    <td>{{ $seller->user->mobile ?? ""}}</td>
                    {{-- <td>{{ $seller->user ? $Seller->user->mobile : "" }}</td> --}}

                    {{-- <td>{{ $seller->country->name }}</td> --}}
                    <td><span class="badge bg-success"> {{$seller->user->city->name ?? ""}}</span></td>


                    <td>
                        <div class="btn-group">
                          {{-- @can('Edit-Seller') --}}
                          <a href="{{route('sellers.edit' , $seller->id )}}" type="button" class="btn btn-info">edit</a>
                          {{-- @endcan --}}
                          {{-- @can('Delete-Seller') --}}
                          <button type="button" onclick="performDestroy({{$seller->id }} , this)" class="btn btn-danger">delete</button>
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
        {{ $sellers->links() }}
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

        confirmDestroy('/cms/sellers/'+id  ,reference );

    }

    </script>
@endsection
