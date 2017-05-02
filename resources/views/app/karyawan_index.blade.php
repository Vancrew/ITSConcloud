@extends('app')

@include('plugins.datatable')
@include('plugins.datepicker')

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4>Tambah Karyawan</h4>
      </div>
      <div class="box-body">
        <br />

        <form data-parsley-validate class="form-horizontal form-label-left" method="post" action="{{url('users')}}">
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
            <label class="control-label col-md-3 col-sm-3">Tempat Lahir <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="tempatlahir" required="required" class="form-control col-md-7">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Alamat <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="alamat" required="required" class="form-control col-md-7">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Nomor Handphone <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="number" name="hp" required="required" class="form-control col-md-7">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Jabatan <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <select name="jabatan" required="required" class="form-control col-md-7">
                @foreach (['admin', 'petugas', 'keuangan'] as $jabatan)
                <option value="{{$jabatan}}">{{$jabatan}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Username <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="text" name="username" required="required" class="form-control col-md-7">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Password <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="password" name="password" required="required" class="form-control col-md-7">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3">Confirm Password <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
              <input type="password" name="confirmpassword" required="required" class="form-control col-md-7">
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-sm-offset-3">
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4>Karyawan</h4>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table id="datatable-buttons" class="table table-hover datatabel">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tanggal Lahir</th>
                    <th>Tempat Lahir</th>
                    <th>Alamat</th>
                    <th>No Handphone</th>
                    <th>Jabatan</th>
                    <th>Username</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($user as $userdata)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$userdata->nama}}</td>
                    <td>{{$userdata->tanggal_lahir}}</td>
                    <td>{{$userdata->tempat_lahir}}</td>
                    <td>{{$userdata->alamat}}</td>
                    <td>{{$userdata->hp}}</td>
                    <td>{{$userdata->jabatan}}</td>
                    <td>{{$userdata->username}}</td>
                    <td><a class="btn btn-primary fa fa-edit" href="/users/{{$userdata->id}}/edit"></a>
                      <a class="btn btn-danger fa fa-trash delete-resource" data-id="{{encrypt($userdata->id)}}"></a>
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
