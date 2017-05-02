@extends('app')

@include('plugins.chartjs')
@include('plugins.daterangepicker')

@section('content')
<div class="box box-primary">
  <div class="box-header">
    <h4>Grafik perbandingan pemasukan dengan pengeluaran</h4>
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
    <canvas id="freshMoneyChart" width="400" height="170"></canvas>
  </div>
</div>
@endsection

@section('js')
<script>
$(function() {
  var ctx = document.getElementById("freshMoneyChart");

  pengeluaran = {!! $pengeluaran !!};
  pemasukan = {!! $pemasukan !!};
  total = pengeluaran + pemasukan;
  pengeluaran$ = pengeluaran / total * 100;
  pemasukan$ = pemasukan / total * 100;
  var areaChartData = {
    labels: ['Pengeluaran ' + Math.round(pemasukan$) + '%', 'Pemasukan ' + Math.round(pengeluaran$) + '%'],
    datasets: [
      {
        data: [pemasukan, pengeluaran],
        backgroundColor: ["#FFCE56", "#36A2EB"]
      }
    ]
  };

  var myChart = new Chart(ctx, {
    type: 'pie',
    data: areaChartData,
  });

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