@extends('app')

@include('plugins.datepicker')

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="box box-primary">
      <div class="box-header box-body">
        <h4>Edit Produsen</h4>
      </div>
      <div class="box box-primary">
      <div class="box-header with-border">

        <form data-parsley-validate class="form-horizontal form-label-left" method="post" action="/produsen/{{$produsen->id}}">
          {{ method_field('PUT') }}
          {{csrf_field()}}
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Nama <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="nama" required="required" class="form-control col-md-7" value="{{$produsen->nama}}">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Tanggal lahir <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right datepicker" name="tanggal_lahir" value="{{$produsen->tanggal_lahir}}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Alamat <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="alamat" required="required" class="form-control col-md-7" value="{{$produsen->alamat}}">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Nomor telepon</label>
            <div class="col-md-6 col-sm-6">
              <input class="form-control col-md-7" type="number" name="telepon" value="{{$produsen->telepon}}">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Nomor handphone <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="number" name="hp" required="required" class="form-control col-md-7" value="{{$produsen->hp}}">
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-md-offset-3">
              <a href="{{url('produsen')}}" class="btn btn-default">Cancel</a>
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