@extends('app')

@include('plugins.datatable')
@include('plugins.datepicker')
@include('plugins.accounting')
@include('plugins.select2')

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4>Ubah Pengeluaran</h4>
      </div>
      <div class="box-body">
        <form data-parsley-validate class="form-horizontal form-label-left" method="post" action="{{url('transaksi/pengeluaran/'.$pengeluaran->id)}}">
          {{csrf_field()}}
          {{ method_field('PUT') }}
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Jenis Pengeluaran <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <select class="form-control select2" name="jenis" value="{{$pengeluaran->jenis_operasional->nama}}">
                @foreach ($jenis as $jns)
                <option value="{{$jns->id}}">{{$jns->nama}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Uraian <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="uraian" required="required" class="form-control col-md-7" value="{{$pengeluaran->uraian}}">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Tanggal Pengeluaran <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right datepicker" name="tanggal" value="{{$pengeluaran->tanggal}}">
                </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Jumlah Pengeluaran <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="biaya" required class="form-control col-md-7 input-accounting" value="{{$pengeluaran->biaya}}">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Penanggung Jawab <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <select class="form-control select2" name="user_id" value="{{$pengeluaran->user->nama}}">
                @foreach ($user as $users)
                <option value="{{$users->id}}">{{$users->nama}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-md-offset-3">
              <a href="{{url('transaksi/pengeluaran')}}" class="btn btn-default">Cancel</a>
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
