@extends('app')
@section('content')
<div class="row">
  <div class="col-lg-2 col-sm-4">
    <div class="panel panel-default">
      <div class="panel-body">
        <a href="{{url('laporan/penjualan')}}" class="btn btn-primary btn-block">Kembali</a>
      </div>
    </div>
  </div>
  <div class="col-lg-10 col-sm-12">
    <div class="box box-primary">
      <div class="box-header">
        <h4>Detail Penjualan</h4>
      </div>
      <div class="box-body">
        <div class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-4 control-label">Konsumen</label>
            <label class="col-sm-7 content-label">{{$nota->konsumen->nama}}</label>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Tanggal</label>
            <label class="col-sm-7 content-label">{{$nota->tanggal}}</label>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Total Harga</label>
            <label class="col-sm-7 content-label">{{number_format($nota->total_harga)}}</label>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Modal</label>
            <label class="col-sm-7 content-label">{{number_format($nota->total_modal)}}</label>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Keuntungan Bersih</label>
            <label class="col-sm-7 content-label">{{number_format($nota->keuntungan_bersih)}}</label>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Total Pembayaran</label>
            <label class="col-sm-7 content-label">{{number_format($nota->total_pembayaran)}}</label>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Total Operasional</label>
            <label class="col-sm-7 content-label">{{number_format($nota->operasional->sum('harga'))}}</label>
          </div>
        </div>
      </div>
    </div>
    <div class="box box-primary">
      <div class="box-header">
        <h4>Detail Operasional</h4>
      </div>
      <div class="box-body">
        <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th class="text-center col-md-1">No</th>
              <th>Nama</th>
              <th class="text-right">Harga Satuan</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($nota->operasional as $op)
            <tr>
              <td class="text-center">{{$loop->iteration}}</td>
              <td>{{$op->jenis_operasional->nama}}</td>
              <td class="text-right">{{number_format($op->biaya)}}</td>
            </tr>
            @empty
            <tr>
              <td colspan="3" class="text-muted">Tidak ada data</td>
            </tr>
            @endforelse
          </tbody>
        </table>
        </div>
      </div>
    </div>
    <div class="box box-primary">
      <div class="box-header">
        <h4>Detail Barang</h4>
      </div>
      <div class="box-body">
        <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th>Nama</th>
              <th>Merek</th>
              <th class="text-right">Jumlah</th>
              <th class="text-right">Harga Beli</th>
              <th class="text-right">Harga</th>
              <th class="text-right">Total</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($nota->item_transaksi as $item)
            <tr>
              <td class="text-center">{{$loop->iteration}}</td>
              <td>{{$item->jenis->nama}}</td>
              <td>{{$item->inventory->merek}}</td>
              <td class="text-right">{{$item->jumlah}}</td>
              <td class="text-right">{{number_format($item->inventory->harga_beli)}}</td>
              <td class="text-right">{{number_format($item->biaya)}}</td>
              <td class="text-right">{{number_format($item->biaya * $item->jumlah)}}</td>
            </tr>
            @empty
            <tr>
              <td colspan="3" class="text-muted">Tidak ada data</td>
            </tr>
            @endforelse
          </tbody>
        </table>
        </div>
      </div>
    </div>
    <div class="box box-primary">
      <div class="box-header">
        <h4>Detail Pembayaran</h4>
      </div>
      <div class="box-body">
        <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th>Tanggal</th>
              <th class="text-right">Jumlah</th>
              <th class="text-right">Sisa</th>
              <th class="col-md-1">Nota</th>
            </tr>
          </thead>
          <tbody>
            @php $sisa = $nota->total_harga; @endphp
            @forelse ($nota->pembayaran as $bayar)
            @php $sisa -= $bayar->biaya; @endphp
            <tr>
              <td class="text-center">{{$loop->iteration}}</td>
              <td>{{$bayar->tanggal}}</td>
              <td class="text-right">{{number_format($bayar->biaya)}}</td>
              <td class="text-right">{{number_format($sisa)}}</td>
              <td>
                <a class="btn btn-primary fa fa-download" href="/transaksi/pembayaran/kuitansi/{{$bayar->id}}"></a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="3" class="text-muted">Tidak ada data</td>
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

@section('js')
@endsection