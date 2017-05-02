@section('css') @parent
<link href="{{url('bower_components/AdminLTE/plugins/select2/select2.min.css')}}" rel="stylesheet">
<style>
  .select2-selection--single {
    background-color: #fff;
    border-radius: 0px !important;
    box-shadow: none !important;
    border-color: #d2d6de !important;
    height: 34px !important;
  }
</style>
@endsection

@section('js') @parent
<script src="{{url('bower_components/AdminLTE/plugins/select2/select2.full.min.js')}}"></script>
<script>
  $($(".select2").select2()).addClass("form-control");
</script>
@endsection