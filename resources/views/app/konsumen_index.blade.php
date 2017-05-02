@extends('app')

@include('plugins.datatable')
@include('plugins.datepicker')

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4>Tambah Konsumen</h4>
      </div>
      <div class="box-body">
        <form data-parsley-validate class="form-horizontal form-label-left" method="post" action="{{url('konsumen')}}">
          {{csrf_field()}}
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Nama <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="nama" required="required" class="form-control col-md-7">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Tanggal Lahir <span class="required">*</span></label>
            <div class="col-sm-6">
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right datepicker" name="tanggal_lahir" placeholder="YYYY-MM-DD">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Alamat <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="alamat" required="required" class="form-control col-md-7">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Nomor telepon</label>
            <div class="col-md-6 col-sm-6">
              <input type="text" class="form-control col-md-7" name="telepon">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Nomor handphone <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="hp" required="required" class="form-control col-md-7">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Nama Restoran <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="nama_restoran" required="required" class="form-control col-md-7">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Telepon Restoran
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="telepon_restoran" class="form-control col-md-7">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Nama CP <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="nama_cp" required="required" class="form-control col-md-7">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Telepon CP <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="telepon_cp" required="required" class="form-control col-md-7">
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
      <div class="box-header with-border">
        <h4>Data Konsumen</h4>
      </div>
      <div class="box-body">
        <div class="table-responsive">
        <table id="datatable-buttons" class="table table-striped table-bordered datatabel">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>No Telepon</th>
              <th>No Handphone</th>
              <th>Nama Restoran</th>
              <th>Telepon Restoran</th>
              <th>Nama CP</th>
              <th>Telepon CP</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($konsumen as $kons)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>{{$kons->nama}}</td>
              <td>{{$kons->alamat}}</td>
              <td>{{$kons->telepon}}</td>
              <td>{{$kons->hp}}</td>
              <td>{{$kons->nama_restoran}}</td>
              <td>{{$kons->telepon_restoran}}</td>
              <td>{{$kons->nama_cp}}</td>
              <td>{{$kons->telepon_cp}}</td>
              <td>
                <a class="btn btn-primary fa fa-edit" href="/konsumen/{{$kons->id}}/edit"></a>
                <a class="btn btn-danger fa fa-trash delete-resource" data-id="{{encrypt($kons->id)}}"></a>
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
          url: $('meta[name="base_url"]').attr('content') + '/konsumen/' + id,
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