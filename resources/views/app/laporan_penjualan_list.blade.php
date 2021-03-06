@extends('app')

@include('plugins.datatable')
@include('plugins.daterangepicker')

@section('content')
<div class="box box-primary">
  <div class="box-header">
    <h4>Laporan Penjualan</h4>
  </div>
  <div class="box-body">
    <div class="form-group">
      <label class="">Date range:</label>
      <div class="input-group col-md-4 ">
        <div class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control" id="daterange">
      </div>
    </div>
    <form id="formrange">
      <input type="hidden" id="rangestart" name="start">
      <input type="hidden" id="rangeend" name="end">
    </form>
    <div class="table-responsive">
    <table id="datatable-buttons" class="table table-hover datatabel">
      <thead>
        <tr>
          <th class="text-center">No</th>
          <th class="text-center">No Nota</th>
          <th>Nama Pemesan</th>
          <th>Jumlah Jenis Item</th>
          <th>Tanggal Pemesanan</th>
          <th class="text-right">Total Biaya</th>
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($nota as $jual)
        <tr>
          <td class="text-center">{{$loop->iteration}}</td>
          <td class="text-center">{{$jual->id}}</td>
          <td>{{$jual->konsumen->nama}}</td>
          <td>{{$jual->item_transaksi->count()}}</td>
          <td>{{$jual->tanggal}}</td>
          <td class="text-right">{{number_format($jual->total_harga)}}</td>
          <td>
            <a href="{{url('laporan/penjualan/'.$jual->id)}}" class="btn btn-primary btn-sm">Detail</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
$(function() {
  $('#daterange').daterangepicker({
    format: 'YYYY-MM-DD',
    locale: {
      format: 'YYYY-MM-DD'
    },
    startDate: '{{$start}}',
    endDate: '{{$end}}'
  }, function(start, end) {
    $('#rangestart').val(start.format('YYYY-MM-DD'));
    $('#rangeend').val(end.format('YYYY-MM-DD'));
    $("#formrange").submit()
  });
})
</script>
@endsection