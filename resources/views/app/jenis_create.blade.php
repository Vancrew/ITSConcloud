@extends('app')

@include('plugins.accounting')
@include('plugins.datatable')

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="box box-primary">
      <div class="box-header">
        <h4>Tambah Jenis Barang</h4>
      </div>
      <div class="box-body">
        <form method="post" class="form-horizontal" action="{{url('crud/jenis')}}">
          {{ csrf_field() }}
          <div class="form-group">
            <label class="col-sm-3 control-label">Nama Barang</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="nama" placeholder="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Harga Barang</label>
            <div class="col-sm-8">
              <input type="text" class="form-control input-accounting" name="harga" placeholder="">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-8 col-sm-offset-3">
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="box box-primary">
      <div class="box-header">
        <h4>List Jenis Barang</h4>
      </div>
      <div class="box-body">
        <div class="table-responsive">
        <table class="table table-hover datatabel">
          <thead>
            <tr>
              <th class="text-center col-sm-2">No</th>
              <th>Nama</th>
              <th class="text-right">Harga Jual (default)</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($jenis as $barang)
            <tr>
              <td class="text-center">{{$loop->iteration}}</td>
              <td>{{$barang->nama}}</td>
              <td class="text-right">{{number_format($barang->harga)}}</td>
              <td class="text-center">
                <a href="/crud/jenis/{{$barang->id}}" class="btn btn-primary fa fa-eye" title="detail"></a>
                @if ($barang->inventory()->count() > 0)
                <a class="btn btn-danger fa fa-trash" disabled title="Barang sudah digunakan pada transaksi."></a>
                @else
                <a class="btn btn-danger fa fa-trash delete-resource" data-id="{{encrypt($barang->id)}}"></a>
                @endif
              </td>
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

@section('js')
<script>
$(function() {
  $(".delete-resource").click(function() {
    id = $(this).data('id');

    swal({
      title: "Apakah anda yakin akan menghapus?",
      text: "Anda tidak dapat mengembalikan data yang terhapus!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Hapus",
      cancelButtonText: "Batal",
      closeOnConfirm: false,
      closeOnCancel: true
    },
    function(isConfirm){
      if (isConfirm) {
        $.ajax({
          url: $('meta[name="base_url"]').attr('content') + '/crud/jenis/' + id,
          method: 'POST',
          data: {
            '_method': 'DELETE'
          },
          success: function(result) {
            console.log('result: ', result)
            swal({
              title:"Deleted!",
              text: "Data berhasil dihapus.",
              type: "success"
            },
            function() {
              window.location = window.location
            });
          },
          error: function(result) {
            swal("Gagal!", "Data gagal dihapus.", "error");
          }
        });
      }
      return isConfirm
    });
  })
})

@if (session('tambah_success'))
  swal("Success", "Data berhasil ditambah", "success");
@endif
</script>
@endsection