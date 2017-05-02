@extends('app')

@include('plugins.datepicker')

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="box box-primary">
      <div class="box-header box-body">
        <h4>Edit Image</h4>
      </div>
      <div class="box box-primary">
      <div class="box-header with-border">

        <form data-parsley-validate class="form-horizontal form-label-left" method="post" action="/image/{{$images->id}}">
          {{ method_field('PUT') }}
          {{csrf_field()}}
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">ID Image <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="id_image" required="required" class="form-control col-md-7" value="{{$images->id_image}}">
            </div>
          </div>
        
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-md-offset-3">
              <a href="{{url('image')}}" class="btn btn-default">Cancel</a>
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection