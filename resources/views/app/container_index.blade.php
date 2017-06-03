@extends('app')

@include('plugins.datatable')
@include('plugins.datepicker')

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4>Tambah Container</h4>
      </div>
      <div class="box-body">
        <form data-parsley-validate class="form-horizontal form-label-left" method="post" action="{{url('container')}}">
          {{csrf_field()}}
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Nama Image <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <select class="form-control col-md-7" required="required" name="nama_image">
                 @foreach($images as $ima)
                  <option value="{{$ima->Repo_tags}}"> {{$ima->Repo_tags}} </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-6 col-sm-6">
              <input type="hidden" class="btn btn-success" value="{{Auth::user()->id}}" name="id">
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-md-offset-3">
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="box box-primary">
      <div class="box-header">
        <h4>Container</h4>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table id="datatable-buttons" class="table table-hover datatabel">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>Id Image</th>
                <th>Name Image</th>
                <th>Created</th>
                <th>Size</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($container as $ima)
              <tr>
                <td class="text-center">{{$loop->iteration}}</td>
                <td>{{$ima->id_con}}</td>
                <td>{{$ima->id_user}}</td>
                <td>{{$ima->id_user}}</td>
                <td>{{$ima->id_user}} MB</td>
                <td>
                  <a class="btn btn-danger fa fa-trash delete-resource" data-id="{{encrypt($ima->id_user)}}"></a>
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