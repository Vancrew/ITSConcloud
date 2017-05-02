@extends('app')

@include('plugins.datepicker')
@include('plugins.selectize')
@include('plugins.accounting')

@section('content')
<form method="post" action="{{url('transaksi/penjualan')}}">
  {{csrf_field()}}
  <div class="row">
    <div class="col-lg-6 col-sm-10">
      <div class="box box-primary">
        <div class="box-body">
          <h4>Detail penjualan</h4>
          <hr>
          <div class="form-horizontal">
            <div class="form-group">
              <label class="col-sm-3 control-label">Konsumen</label>
              <div class="col-sm-8">
                <select class="" id="konsumen" name="konsumen">
                  @foreach ($konsumen as $kons)
                  <option value="{{ $kons->id }}">{{ $kons->nama }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Tanggal</label>
              <div class="col-sm-8">
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="tanggal" class="form-control datepicker" placeholder="" value="{{date('Y-m-d')}}">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label"></label>
              <div class="col-sm-8">
                <button type="submit" name="pilih_konsumen" class="btn btn-primary" value="1">Lanjutkan</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@section('js')
<script>
$(function() {
  konsumen = $("#konsumen").selectize({})[0].selectize;
})

@if (session('tambah_success'))
  swal("Success", "Transaksi berhasil dilakukan", "success");
@endif
@if (session('nota_id'))
  window.open('{{url('laporan/penjualan/excel/'.session('nota_id'))}}')
@endif
</script>
@endsection