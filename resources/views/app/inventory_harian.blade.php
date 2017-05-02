@extends('app')

@include('plugins.datatable')
@include('plugins.daterangepicker')

@section('content')
<div class="box box-primary">
  <div class="box-header">
    <h4>List Inventory harian</h4>
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
    <table class="table table-hover">
      <thead>
        <tr>
          <th class="text-center">No</th>
          <th>Nama</th>
          @foreach ($times as $time)
          <th class="text-center">{{date('M d', strtotime($time))}}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @forelse ($jenis as $item)
        <tr>
          <td class="text-center">{{$loop->iteration}}</td>
          <td>{{$item->nama}}</td>
          @foreach ($times as $time)
          <td class="text-center">{{$jumlah[$item->id][$time]}}</td>
          @endforeach
        </tr>
        @empty
        <tr>
          <td colspan="3">Tidak ada data</td>
        </tr>
        @endforelse
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