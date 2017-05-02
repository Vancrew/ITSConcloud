@extends('app')

@include('plugins.datatable')

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="box box-primary">
      <div class="box-header">
        <h4>Tambah Jenis Operasional</h4>
      </div>
      <div class="box-body">
        <form method="post" class="form-horizontal" action="{{url('crud/jenis_operasional')}}">
          {{ csrf_field() }}
          <div class="form-group">
            <label class="col-sm-3 control-label">Nama Operasional</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="nama" placeholder="">
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
        <h4>List Jenis Operasional</h4>
      </div>
      <div class="box-body">
        <div class="table-responsive">
        <table class="table table-hover datatabel">
          <thead>
            <tr>
              <th class="text-center col-sm-1">No</th>
              <th>Nama</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($jenis as $operasional)
            <tr>
              <td class="text-center">{{$loop->iteration}}</td>
              <td>{{$operasional->nama}}</td>
              <td class="text-center">
                @if ($operasional->pengeluaran_lainnya()->count() > 0 || $operasional->riwayat_operasional()->count() > 0)
                <a class="btn btn-danger fa fa-trash" disabled title="Operasional sudah digunakan pada transaksi."></a>
                @else
                <a class="btn btn-danger fa fa-trash delete-resource" data-id="{{encrypt($operasional->id)}}"></a>
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
          url: $('meta[name="base_url"]').attr('content') + '/crud/jenis_operasional/' + id,
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