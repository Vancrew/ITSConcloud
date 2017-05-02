@extends('app')

@include('plugins.accounting')
@include('plugins.datatable')

@section('content')
<div class="row">
  <div class="col-lg-2 col-sm-4">
    <div class="panel panel-default">
      <div class="panel-body">
        <a href="{{url('crud/jenis')}}" class="btn btn-primary btn-block">Kembali</a>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-sm-6">
    <div class="box box-primary">
      <div class="box-header">
        <h4>{{$jenis->nama}}</h4>
      </div>
      <div class="box-body">
        <form method="POST" class="form-horizontal" action="/crud/jenis/{{$jenis->id}}">
          {{ csrf_field() }}
          {{ method_field('PUT') }}
          <div class="form-group">
            <label class="col-sm-5 control-label">Ubah harga jual default</label>
            <div class="col-sm-6">
              <input type="text" class="form-control input-accounting" name="harga" placeholder="" value="{{number_format($jenis->harga)}}">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-5 col-sm-offset-5">
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="box box-primary">
      <div class="box-header">
        <h4>Harga Jual Barang per Konsumen</h4>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-hover datatabel">
            <thead>
              <tr>
                <th class="text-center col-sm-2">No</th>
                <th>Konsumen</th>
                <th class="text-right">Harga Jual</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @forelse ($jenis->konsumen as $konsumen)
              <tr>
                <td class="text-center">{{$loop->iteration}}</td>
                <td>{{$konsumen->nama}}</td>
                <td class="text-right">{{number_format($konsumen->pivot->harga)}}</td>
                <td class="text-center">
                  <a href="/crud/jenis/{{$jenis->id}}/konsumen/{{$konsumen->id}}" class="btn btn-primary btn-sm">Edit</a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="4">Tidak ada data</td>
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
<script>
@if (session('edit_success'))
  swal("Success", "Data berhasil diubah", "success");
@endif
</script>
@endsection