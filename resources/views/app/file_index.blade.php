@extends('app')

@include('plugins.datatable')
@include('plugins.datepicker')

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4>Upload Aplikasi</h4>
      </div>
      <div class="box-body">
        <br />

        <form data-parsley-validate class="form-horizontal form-label-left" method="post" action="{{url('file')}}" enctype="multipart/form-data">
          {{csrf_field()}}
          
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Nama Aplikasi <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="namerepo" required="required" class="form-control col-md-7">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Jenis File <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <select class="form-control col-md-7" required="required" name="jenis_file">
                  <!-- <option value="web"> web (.zip) </option> -->
                  <!-- <option value="database"> file database </option> -->
                  <option value="dockerfile"> dockerfile ( *.tar.gz ) </option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Browse <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="file" name="web" required="required" id="fileToUpload" accept=".tar.gz" class="form-control col-md-7">
            </div>
          </div>
         
          <div class="form-group">
            <div class="col-md-6 col-sm-6">
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

    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4>Web</h4>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table id="datatable-buttons" class="table table-hover datatabel">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Aplikasi</th>
                    <th>Nama File</th>
                    <th>Tipe File</th>
                    <th>Tanggal</th>
                    <th>Ukuran</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($files as $file)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$file->random_name}}</td>
                    <td>{{$file->name}}</td>
                    <td>{{$file->jenis_file}}</td>
                    <td>{{$file->created_at}}</td>
                    <td>{{$file->size}} KB</td>
                    <td>
                      <a class="btn btn-primary fa fa-search" href="/file/{{$file->id}}/show"></a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            {{ $files->links('vendor.pagination.custom') }}
          </div>
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
