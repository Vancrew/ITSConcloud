@extends('app')

@include('plugins.datepicker')
@include('plugins.selectize')
@include('plugins.accounting')

@section('content')
<form id="form-pembelian" method="post" action="{{url('transaksi/pembelian')}}">
  {{ csrf_field() }}
  <div class="row" ng-controller="pembelian">
    <div class="col-lg-6 col-md-8 col-sm-10">
      <div class="box box-primary">
        <div class="box-header">
          <h4>Detail Pembelian</h4>
        </div>
        <div class="box-body">
          <div class="form-horizontal">
            <div class="form-group">
              <label class="col-sm-3 control-label">Produsen</label>
              <div class="col-sm-8">
                <select id="produsen" name="produsen">
                  @foreach ($produsen as $prod)
                  <option value="{{ $prod->id }}">{{ $prod->nama }}</option>
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
                  <input type="text" class="form-control datepicker" id="tanggal" name="tanggal" value="{{date('Y-m-d')}}" placeholder="YYYY-MM-DD">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-8 col-md-10 col-sm-10">
      <div class="box box-primary">
        <div class="box-header">
          <h4>Transaksi Pembelian</h4>
        </div>
        <div class="box-body">
          <div class="form-horizontal">
            <div class="form-group">
              <label class="col-sm-3 control-label">Jenis Barang</label>
              <div class="col-sm-8">
                <select ng-model="jenis" id="jenis" placeholder="Pilih barang">
                  <option value="">Pilih barang</option>
                  @foreach ($jenis as $barang)
                  <option value="{{ $barang->id }}">{{ $barang->nama }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Merk Barang</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" ng-model="merek" placeholder="Top Brand">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Tanggal Kadaluarsa</label>
              <div class="col-sm-8">
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control datepicker" id="tgl_kadaluarsa" ng-model="tanggal_kadaluarsa" placeholder="YYYY-MM-DD">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Jumlah Barang</label>
              <div class="col-sm-8">
                <input type="number" class="form-control" id="jumlah" ng-model="jumlah" placeholder="20">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Jumlah Karung</label>
              <div class="col-sm-8">
                <input type="number" class="form-control" id="jumlah_karung" ng-model="jumlah_karung" placeholder="1">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Harga Total</label>
              <div class="col-sm-8">
                <input type="text" class="form-control input-accounting" ng-model="harga">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-8 col-sm-offset-3">
                <button type="button" class="btn btn-primary" ng-click="tambah_pembelian()">
                  Tambahkan
                </button>
              </div>
            </div>
          </div>
          @verbatim
          <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>Jenis</th>
                <th>Merek</th>
                <th>Kadaluarsa</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Karung</th>
                <th class="text-right">Harga Total</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr ng-if="rows.length <= 0">
                <td colspan="7"><span class="text-muted">Tidak ada barang</span></td>
              </tr>
              <tr ng-repeat="row in rows">
                <td class="hidden">
                  <input name="pembelian[{{$index}}][jenis_id]" value="{{row.jenis}}">
                  <input name="pembelian[{{$index}}][merek]" value="{{row.merek}}">
                  <input name="pembelian[{{$index}}][jumlah]" value="{{row.jumlah}}">
                  <input name="pembelian[{{$index}}][jumlah_karung]" value="{{row.jumlah_karung}}">
                  <input name="pembelian[{{$index}}][tanggal_kadaluarsa]" value="{{row.tanggal_kadaluarsa}}">
                  <input name="pembelian[{{$index}}][harga]" value="{{row.harga}}">
                </td>
                <td class="text-center">{{$index + 1}}</td>
                <td>{{jenisSelectize.options[row.jenis].text}}</td>
                <td>{{row.merek}}</td>
                <td>{{row.tanggal_kadaluarsa}}</td>
                <td class="text-center">{{row.jumlah}}</td>
                <td class="text-center">{{row.jumlah_karung}}</td>
                <td class="text-right">{{accounting(row.harga)}}</td>
                <td class="text-center"><a class="text-danger" ng-click="hapus(row)"><i class="fa fa-close"></i></a></td>
              </tr>
            </tbody>
          </table>
          </div>
          <div class="text-right">
            <h4>Total = {{accounting(total)}}</h4>
            <input type="hidden" name="total" value="{{total}}">
            <button class="btn btn-success">Submit</button>
          </div>
          @endverbatim
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@section('js')
<script>
(function(){
  app.controller("pembelian", function($scope) {
    $scope.accounting = accounting;
    $scope.total = 0;
    $scope.rows = [];

    reset = function() {
      $scope.merek = '';
      $scope.jumlah = 0;
      $scope.jumlah_karung = 0;
      $scope.harga = 0;
      $scope.tanggal_kadaluarsa = '';
    }
    reset();

    $scope.tambah_pembelian = function() {
      row = {
        jenis: $("#jenis").val(),
        merek: $scope.merek,
        jumlah: $scope.jumlah,
        jumlah_karung: $scope.jumlah_karung,
        harga: unaccounting($scope.harga),
        tanggal_kadaluarsa: $scope.tanggal_kadaluarsa,
      };
      if (row.jenis == undefined || !(row.jumlah > 0) || !(row.harga > 0) || row.tanggal_kadaluarsa == '') {
        swal("Error", "lengkapi isian pembelian.", "warning");
        console.log(row)
        return;
      }
      $scope.total += row.harga;
      $scope.rows.push(row);

      reset();
    }
    $scope.hapus = function(row) {
      $scope.total -= row.harga;
      index = $scope.rows.indexOf(row);
      $scope.rows.splice(index, 1);
    }

    $("#form-pembelian").submit(function() {
      if ($("#tanggal").val() == "") {
        swal("Error", "Mohon isi tanggal transaksi.", "warning");
        return false;
      }
      if ($scope.rows.length <= 0) {
        swal("Error", "Mohon isi barang transaksi.", "warning");
        return false;
      }
    })

    produsen = $("#produsen").selectize({})[0].selectize;
    $scope.jenisSelectize = $("#jenis").selectize({})[0].selectize;
  });
})();
@if (session('tambah_success'))
  swal("Success", "Transaksi berhasil dilakukan", "success");
@endif
</script>
@endsection