@extends('app')

@include('plugins.datatable')
@include('plugins.datepicker')

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="box box-primary">
      <div class="box-header">
        <h4>Image</h4>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table id="datatable-buttons" class="table table-hover datatabel">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>Id Image</th>
                <th>Name Image</th>
                <th>Created</th>
                <th>Size</th>
              </tr>
            </thead>
            <tbody>
              @foreach($images as $ima)
              <tr>
                <td class="text-center">{{$loop->iteration}}</td>
                <td>{{$ima->id_image}}</td>
                <td>{{$ima->Repo_tags}}</td>
                <td>{{$ima->Created}}</td>
                <td>{{$ima->Size}} MB</td>
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