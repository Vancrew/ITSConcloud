@extends('app')

@include('plugins.datatable')

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="box box-primary">
      <div class="box-header">
        <h4>List Inventory</h4>
      </div>
      <div class="box-body">
        <div class="table-responsive">
        <table class="table table-hover datatabel">
          <thead>
            <tr>
              <th class="text-center col-sm-1">No</th>
              <th>Nama</th>
              <th>Stok</th>
              <th class="text-right">Harga default</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($jenis as $item)
            <tr>
              <td class="text-center">{{$loop->iteration}}</td>
              <td>{{$item->nama}}</td>
              <td>{{$item->jumlah}}</td>
              <td class="text-right">{{number_format($item->harga)}}</td>
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
  </div>
</div>
@endsection