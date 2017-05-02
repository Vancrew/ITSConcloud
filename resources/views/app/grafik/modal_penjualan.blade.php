@extends('app')

@include('plugins.chartjs')
@include('plugins.daterangepicker')

@section('content')
<div class="box box-primary">
  <div class="box-header">
    <h4>Grafik komposisi penjualan (per satuan terjual)</h4>
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
    <canvas id="komposisiChart" width="400" height="200"></canvas>
    <h3 class="text-right">Total modal = {{$jumlah_modal->sum()}}kg</h3>
    <h3 class="text-right">Total terjual = {{$jumlah->sum()}}kg</h3>
  </div>
</div>
@endsection

@section('js')
<script>
$(function() {
  var ctx = document.getElementById("komposisiChart");

  var data = {
    labels: {!! $jenis !!},
    datasets: [
      {
        label: "Jumlah barang terjual dalam kg",
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1,
        data: {!! $jumlah !!},
      },
      {
        label: "Jumlah barang modal dalam kg",
        backgroundColor: 'rgba(153, 102, 255, 0.2)',
        borderColor: 'rgba(153, 102, 255, 1)',
        borderWidth: 1,
        data: {!! $jumlah_modal !!},
      }
    ]
  };

  @if (count($jenis) > 1)
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero:true
          }
        }]
      }
    }
  });
  @endif

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