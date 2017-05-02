@extends('app')

@include('plugins.chartjs')
@include('plugins.daterangepicker')

@section('content')
<div class="box box-primary">
  <div class="box-header">
    <h4>Grafik modal aktual</h4>
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
    <canvas id="modalAktualChart" width="400" height="200"></canvas>
  </div>
</div>
@endsection

@section('js')
<script>
$(function() {
  var ctx = document.getElementById("modalAktualChart");

  var green_ = 'rgba(214, 255, 82, 0.2)';
  var green = 'rgba(214,255,82,1)';
  var blue_ = 'rgba(54, 162, 235, 0.2)';
  var blue = 'rgba(54, 162, 235, 1)';

  var areaChartData = {
    labels: {!! $tanggal->toJson() !!},
    datasets: [
      {
        label: "Modal bersih",
        fill: false,
        borderColor: blue,
        data: {!! $modal_bersih->toJson() !!}
      },
      {
        label: "Modal Aktual",
        fill: false,
        borderColor: green,
        data: {!! $modal_aktual->toJson() !!}
      }
    ]
  };

  var myChart = new Chart(ctx, {
    type: 'line',
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