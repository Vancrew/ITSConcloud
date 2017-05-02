@extends('app')

@include('plugins.accounting')
@include('plugins.datatable')
@include('plugins.datepicker')
@include('plugins.daterangepicker')
@include('plugins.selectize')

@section('css')
<link href="{{url('bower_components/AdminLTE/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4>Konsumen berhutang</h4>
      </div>
      <div class="box-body">
        <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th class="col-md-1 text-center">No</th>
              <th>Nama</th>
              <th>Total Hutang</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($konsumen as $kons)
            <tr>
              <td class="text-center">{{$loop->iteration}}</td>
              <td>{{$kons->nama}}</td>
              <td>{{number_format($kons->total_hutang)}}</td>
              <td>
                @if ($kons->total_hutang > 0)
                <a href="/transaksi/pembayaran/create/konsumen/{{$kons->id}}" class="btn btn-default btn-sm">Bayar</a>
                @endif
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4">Tidak ada konsumen berhutang</td>
            </tr>
            @endforelse
          </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4>Laporan Pembayaran</h4>
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
        <table id="datatable-buttons" class="table datatabel">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">No Nota</th>
              <th>Nama Pemesan</th>
              <th class="text-center">Tanggal Pembayaran</th>
              <th class="text-right">Besar Pembayaran</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            @if (count($pembayaran) <= 0)
            <tr>
              <td colspan="5">Tidak ada data</td>
            </tr>
            @endif
            @foreach($pembayaran as $bayar)
            <tr>
              <td class="text-center">{{$loop->iteration}}</td>
              <td class="text-center">{{$bayar->nota_id}}</td>
              <td>{{$bayar->konsumen->nama}}</td>
              <td class="text-center">{{$bayar->tanggal}}</td>
              <td class="text-right">{{number_format($bayar->biaya)}}</td>
              <td>
                <a class="btn btn-primary fa fa-download" href="/transaksi/pembayaran/kuitansi/{{$bayar->id}}"></a>
                <a class="btn btn-danger fa fa-trash delete-resource" data-id="{{encrypt($bayar->id)}}"></a>
              </td>
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

@section('js')
<script>
$(function(){
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

@if (session('tambah_success'))
  swal("Success", "Data berhasil ditambah", "success");
@endif
@if (session('edit_success'))
  swal("Success", "Data berhasil diubah", "success");
@endif
</script>
@endsection
