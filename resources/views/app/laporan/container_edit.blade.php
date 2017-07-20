@extends('app')

@include('plugins.datepicker')

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4>Tambah Container</h4>
      </div>
      <div class="box-body">
        <form data-parsley-validate class="form-horizontal form-label-left" method="post" action="/container">
          {{ method_field('PUT') }}
          {{csrf_field()}}
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Nama Image <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="namerepo" value="{{$container->name}}" required="required" class="form-control col-md-7">
            </div>
          </div>

           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Nama Aplikasi <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="namerepo" required="required" class="form-control col-md-7">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Memory<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <select class="form-control col-md-7" required="required" name="memory">
                  <option value="64m"> 64  MB </option>
                  <option value="128m"> 128 MB </option>
                  <option value="256m"> 256 MB </option>
                  <option value="512m"> 512 MB </option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-6 col-sm-6">
              <input type="hidden" class="btn btn-success" value="{{Auth::user()->id}}" name="id">
            </div>
          </div>
 <input type="hidden" class="btn btn-success" value="1" name="cek">
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-md-offset-3">
              <a href="{{url('container')}}" class="btn btn-default">Cancel</a>
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection