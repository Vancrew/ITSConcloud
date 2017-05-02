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
          <h4>Detail Penjualan</h4>
          <hr>
          <div class="form-horizontal">
            <div class="form-group">
              <label class="col-sm-3 control-label">Konsumen</label>
              <div class="col-sm-8 content-label">
              {{$konsumen->nama}}
              <input type="hidden" name="konsumen" value="{{$konsumen->id}}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Tanggal</label>
              <div class="col-sm-8">
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control datepicker" placeholder="" value="{{date('Y-m-d')}}">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @verbatim
  <div class="box box-primary" ng-controller="penjualan">
    <div class="box-body">
      <div class="row">
        <div class="col-lg-6 col-md-10">
          <h4>Tambah barang</h4>
          <hr>
          <div class="form-horizontal">
            <div class="form-group">
              <label class="col-md-3 control-label">Inventory</label>
              <div class="col-md-9">
                <select id="pilihinventory" ng-model="pilihinventory" placeholder="Pilih inventory"></select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Jumlah</label>
              <div class="col-md-9">
                <input type="number" class="form-control" ng-model="jumlahinventory" placeholder="Jumlah inventory">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Harga Satuan</label>
              <div class="col-md-9">
                <input class="form-control input-accounting" id="hargainventory" ng-model="hargainventory" disabled>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-offset-3 col-md-9">
                <button type="button" class="btn btn-primary" ng-click="tambahinventory()">Tambahkan</button>
              </div>
            </div>
          </div>
          <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>Inventory</th>
                <th class="text-right">Jumlah</th>
                <th class="text-right">Harga</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr ng-if="table_inventory.length <= 0">
                <td colspan="5"><span class="text-muted">Tidak ada barang</span></td>
              </tr>
              <tr ng-repeat="row in table_inventory">
                <td class="hidden">
                  <input name="inventory[{{$index}}][inventory_id]" value="{{row.id}}">
                  <input name="inventory[{{$index}}][inventory_jenis]" value="{{row.jenis_id}}">
                  <input name="inventory[{{$index}}][jumlah]" value="{{row.jumlah_terpilih}}">
                  <input name="inventory[{{$index}}][modal]" value="{{row.harga_beli * row.jumlah_terpilih}}">
                  <input name="inventory[{{$index}}][biaya]" value="{{row.harga}}">
                </td>
                <td class="text-center">{{$index + 1}}</td>
                <td>{{row.nama}} {{row.merek}}</td>
                <td class="text-right">{{row.jumlah_terpilih}}</td>
                <td class="text-right">{{accounting(row.harga_terpilih_total)}}</td>
                <td class="text-center"><a class="text-danger" ng-click="hapusBarang(row)"><i class="fa fa-close"></i></a></td>
              </tr>
            </tbody>
          </table>
          </div>
          <hr class="hidden-lg">
        </div>
        <div class="col-lg-6 col-md-10">
          <h4>Tambah operasional</h4>
          <hr>
          <div class="form-horizontal">
            <div class="form-group">
              <label class="col-md-3 control-label">Operasional</label>
              <div class="col-md-9">
                <select id="pilihoperasional" placeholder="Pilih operasional"></select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Biaya</label>
              <div class="col-md-9">
                <input type="text" class="form-control input-accounting" ng-model="hargaoperasional" placeholder="Biaya operasional">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-offset-3 col-md-9">
                <button type="button" class="btn btn-primary" ng-click="tambahoperasional()">Tambahkan</button>
              </div>
            </div>
          </div>
          <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>Operasional</th>
                <th class="text-right">Harga</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr ng-if="table_operasional.length <= 0">
                <td colspan="4"><span class="text-muted">Tidak ada operasional</span></td>
              </tr>
              <tr ng-repeat="row in table_operasional">
                <td class="hidden">
                  <input name="operasional[{{$index}}][jenis_operasional_id]" value="{{row.id}}">
                  <input name="operasional[{{$index}}][biaya]" value="{{row.harga_terpilih}}">
                </td>
                <td class="text-center">{{$index + 1}}</td>
                <td>{{row.nama}}</td>
                <td class="text-right">{{accounting(row.harga_terpilih)}}</td>
                <td class="text-center"><a class="text-danger" ng-click="hapusOperasional(row)"><i class="fa fa-close"></i></a></td>
              </tr>
            </tbody>
          </table>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <hr>
        <div class="text-right">
          <h4>Total = {{accounting(total)}}</h4>
          <input type="hidden" name="total" value="{{total}}">
          <input type="hidden" name="total_operasional" value="{{total_operasional}}">
          <button class="btn btn-success">Submit</button>
        </div>
      </div>
    </div>
  </div>
  @endverbatim
</form>
@endsection

@section('js')
<script>
app.controller("penjualan", function($scope) {
  $scope.accounting = accounting
  $scope.total = 0;
  $scope.total_operasional = 0;

  /* All about inventory */
  var inventory = null;
  $scope.table_inventory = [];
  var selected_inventory = [];
  $scope.tambahinventory = function() {
    if (inventory.items.length == 0) {
      return swal('Error', 'Barang harus dipilih', 'warning');
    }
    var index = inventory.items[0];
    if (selected_inventory.indexOf(index) >= 0) {
      return swal('Error', 'Barang yang sudah dipilih tidak dapat dipilih lagi', 'warning');
    }
    var selected = inventory.options[index];
    if (!($scope.jumlahinventory > 0 && $scope.jumlahinventory <= selected.jumlah_aktual)) {
      return swal('Error', 'Jumlah harus sesuai dengan stok yang ada', 'warning');
    }
    selected.jumlah_terpilih = $scope.jumlahinventory;
    selected.harga_terpilih_total = selected.harga * $scope.jumlahinventory;
    $scope.table_inventory.push(selected);
    selected_inventory.push(index);
    $scope.total += selected.harga_terpilih_total;
  }
  $scope.hapusBarang = function(row) {
    $scope.total -= row.harga_terpilih_total;
    index = $scope.table_inventory.indexOf(row);
    $scope.table_inventory.splice(index, 1);
    index = selected_inventory.indexOf(index);
    selected_inventory.splice(index, 1);
  }

  /* All about operasional */
  var operasional = null;
  $scope.table_operasional = [];
  var selected_operasional = [];
  $scope.tambahoperasional = function() {
    if (operasional.items.length == 0) {
      return swal('Error', 'Jenis operasional harus dipilih', 'warning');
    }
    var index = operasional.items[0];
    if (selected_operasional.indexOf(index) >= 0) {
      return swal('Error', 'Jenis operasional yang sudah dipilih tidak dapat dipilih lagi', 'warning');
    }
    var selected = operasional.options[index];

    selected.harga_terpilih = unaccounting($scope.hargaoperasional);
    $scope.table_operasional.push(selected);
    selected_operasional.push(index);
    $scope.total_operasional += selected.harga_terpilih;

    $scope.hargaoperasional = 0;
  }
  $scope.hapusOperasional = function(row) {
    $scope.total_operasional -= row.harga_terpilih;
    index = $scope.table_operasional.indexOf(row);
    $scope.table_operasional.splice(index, 1);
    index = selected_operasional.indexOf(index);
    selected_operasional.splice(index, 1);
  }

  /* Initialize Selectize */
  $(function() {
    inventory = $("#pilihinventory").selectize({
      valueField: 'id',
      labelField: 'nama',
      searchField: ['nama', 'merek'],
      create: false,
      @if (count($dotinvent) > 0)
      options: {!!json_encode($dotinvent)!!},
      @else
      options: null,
      @endif
      render: {
        option: function(item, escape) {
          return '<div>' +
            '<strong>' + escape(item.nama) + '</strong>' +
            '<div class="row small">' +
              '<div class="col-sm-6">' +
                '<span><strong>Merek: </strong>' + escape(item.merek) + '</span><br>' +
                '<span><strong>Stok: </strong>' + escape(item.jumlah_aktual) + '</span>' +
              '</div>' +
              '<div class="col-sm-6">' +
                '<span><strong>Tanggal Beli: </strong>' + escape(item.tanggal_masuk) + '</span><br>' +
                '<span><strong>Kadaluarsa: </strong>' + escape(item.tanggal_kadaluarsa) + '</span>' +
              '</div>' +
            '</div>' +
          '</div>';
        }
      },
    })[0].selectize;
    operasional = $("#pilihoperasional").selectize({
      valueField: 'id',
      labelField: 'nama',
      searchField: 'nama',
      create: false,
      options: {!!json_encode($operasional)!!},
    })[0].selectize;

    /* Selectize event listener */
    inventory.on("change", function(value) {
      if (value != "") {
        // console.log(value);
        selected = inventory.options[value]
        // console.log(selected);
        $scope.hargainventory = accounting(selected.harga);
        $scope.jumlahinventory = selected.jumlah_aktual;
        $scope.$apply();
      }
    })
  })
});
@if (session('tambah_success'))
  swal("Success", "Transaksi berhasil dilakukan", "success");
@endif
@if (session('nota_id'))
  window.open('{{url('laporan/penjualan/excel/'.session('nota_id'))}}')
@endif
</script>
@endsection