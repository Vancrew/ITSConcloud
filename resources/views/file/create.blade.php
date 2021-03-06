@extends('app')

@section('content')

<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4>Upload</h4>
      </div>
      <div class="box-body">
        <br />

        <form data-parsley-validate class="form-horizontal form-label-left" method="post" action="{{url('upload')}}" enctype="multipart/form-data">
          {{csrf_field()}}
          
          <div class="form-group">
            <label class="col-sm-3 control-label"><strong>Browse</strong></label>
            <input type="file" name="web" id="fileToUpload" accept=".zip,.rar">
          </div>

           <div class="form-group">
            <div class="col-md-6 col-sm-6 col-sm-offset-3">
              <input type="hidden" class="btn btn-success" value="{{Auth::user()->id}}" name="id">
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-sm-offset-3">
              <button type="submit" class="btn btn-success">Upload</button>
            </div>
          </div>
          
        </form>
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
          url: $('meta[name="base_url"]').attr('content') + '/users/' + id,
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