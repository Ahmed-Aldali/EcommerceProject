@extends('cms.parent')

@section('title' , 'Index City')

@section('main_title' , 'Index City')

@section('sub_title' , 'index of City')


@section('styles')

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            {{-- <a href="{{route('countries.create')}}" type="submit" class="btn btn-info">Add New Country</a> --}}
  
            <form action="" method="get" style="margin-bottom:2%;">
              <div class="row">
                  <div class="input-icon col-md-2">
                      <input type="text" class="form-control" placeholder="Search By Name"
                         name='name' @if( request()->name) value={{request()->name}} @endif/>
                        <span>
                            <i class="flaticon2-search-1 text-muted"></i>
                        </span>
                      </div>
  
                      <div class="input-icon col-md-2">
                          <input type="text" class="form-control" placeholder="Search By street"
                             name='street' @if( request()->street) value={{request()->street}} @endif/>
                            <span>
                                <i class="flaticon2-search-1 text-muted"></i>
                            </span>
                          </div>
  
                      <div class="input-icon col-md-2">
                      <input type="date" class="form-control" placeholder="Search By Date"
                         name='created_at' @if( request()->created_at) value={{request()->created_at}} @endif/>
                        <span>
                            <i class="flaticon2-search-1 text-muted"></i>
                        </span>
                      </div>
  
  
              <div class="col-md-4">
                    <button class="btn btn-success btn-md" type="submit"> Filter</button>
                    <a href="{{route('cities.index')}}"  class="btn btn-danger">End Filter</a>
                    {{-- @can('Create-City') --}}
  
                    <a href="{{route('cities.create')}}"><button type="button" class="btn btn-md btn-primary"> Add New city </button></a>
                    {{-- @endcan --}}
              </div>
  
                   </div>
          </form>
          </div>

        <!-- /.card-header -->
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="width: 10px">id</th>
                <th>Name of City</th>
                <th>Street of City</th>
                <th>Country</th>

                <th>Setting</th>

              </tr>
            </thead>
            <tbody>

                @foreach ($cities as $city )
                <tr>
                    <td>{{$city->id  }}</td>
                    <td>{{ $city->name }}</td>
                    <td>{{ $city->street }}</td>
                    {{-- <td>{{ $city->country->name }}</td> --}}
                    <td><span class="badge bg-success"> {{$city->country->name}}</span></td>


                    <td>
                        <div class="btn-group">
                          <a href="{{route('cities.edit' , $city->id )}}" type="button" class="btn btn-info">edit</a>
                          <button type="button" onclick="performDestroy({{$city->id }} , this)" class="btn btn-danger">delete</button>
                          {{-- <button type="button" class="btn btn-success">show</button> --}}
                        </div>
                      </td>
                  </tr>
                @endforeach




            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
        {{ $cities->links() }}
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

        confirmDestroy('/cms/cities/'+id  ,reference );

    }

    </script>
@endsection
