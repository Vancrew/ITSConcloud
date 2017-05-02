{{-- Belum pernah dipake, harusnya ga boleh --}}
@extends('app')

@include('plugins.datatable')

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="box box-primary">
      <div class="box-header box-body">
        <h4>Tambah Pembayaran</h4>
      </div>
      <div class="box box-primary">
      <div class="box-header with-border">

        <form data-parsley-validate class="form-horizontal form-label-left" method="post" action="{{url('konsumen')}}">
          {{csrf_field()}}
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Nota <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <select class="form-control select2">
                  @foreach ($nota as $not)
                  <option value="{{$not->id}}">{{$not->id}}</option>
                  @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Tanggal Pembayaran <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="date" class="form-control pull-right" name="tanggal">
                </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Jumlah Pembayaran <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="biaya" required="required" class="form-control col-md-7">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Penerima Pembayaran</label>
            <div class="col-md-6 col-sm-6">
              <select class="form-control select2">
              @foreach ($user as $users)
                  <option value="{{$users->id}}">{{$users->nama}}</option>
              @endforeach
                </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-md-offset-3">
              <button type="submit" class="btn btn-primary">Cancel</button>
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