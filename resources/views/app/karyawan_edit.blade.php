@extends('app')

@include('plugins.datepicker')

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4>Edit Data User</h4>
      </div>
      <div class="box-body">
        <form data-parsley-validate class="form-horizontal form-label-left" method="post" action="/users/{{$user->id}}">
          {{ method_field('PUT') }}
          {{csrf_field()}}
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Nama <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="nama" required="required" class="form-control col-md-7" value="{{$user->nama}}">
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
                <input type="text" class="form-control pull-right datepicker" name="tanggal_lahir" value="{{$user->tanggal_lahir}}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Tempat lahir <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="tempatlahir" required="required" class="form-control col-md-7" value="{{$user->tempat_lahir}}">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Alamat <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="alamat" required="required" class="form-control col-md-7" value="{{$user->alamat}}">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Nomor handphone <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="number" name="hp" required="required" class="form-control col-md-7" value="{{$user->hp}}">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Jabatan <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <select name="jabatan" required="required" class="form-control col-md-7" value="{{$user->jabatan}}">
                @foreach (['admin', 'petugas'] as $jabatan)
                <option value="{{$jabatan}}" {{$user->jabatan == $jabatan ? ' selected' : ''}}>{{$jabatan}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Username <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="username" required="required" class="form-control col-md-7" value="{{$user->username}}">
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-md-offset-3">
              <a href="{{url('users')}}" class="btn btn-default">Cancel</a>
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection