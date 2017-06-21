@extends('app')


@include('plugins.datepicker')

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="box box-primary">
      <div class="box-header">
        <h4>Image Aplikasi</h4>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table id="datatable-buttons" class="table table-hover datatabel">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>Nama Image</th>
                <th>Status</th>
                <th>Created</th>
                <th>Size</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($images as $ima)
              <tr>
                <td class="text-center">{{$loop->iteration}}</td>
                <td>{{$ima->id_image}}</td>
                <td>{{$ima->Status}}</td>
                <td>{{$ima->Created}}</td>
                <td>{{$ima->Size}} MB</td>
                <td>
                <a class="btn btn-danger fa fa-trash delete-resource" data-id="{{encrypt($ima->id)}}"></a>
                </td>
              </tr>
              @endforeach
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
          url: $('meta[name="base_url"]').attr('content') + '/image/' + id,
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
@if (session('edit_success'))
  swal("Success", "Data berhasil diubah", "success");
@endif
</script>
@endsection