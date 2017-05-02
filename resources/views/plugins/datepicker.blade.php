@section('css') @parent
<link href="{{url('bower_components/AdminLTE/plugins/datepicker/datepicker3.css')}}" rel="stylesheet">
@endsection

@section('js') @parent
<script src="{{url('bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script>
$(function(){
  $('.datepicker').datepicker({
    autoclose: true,
    format:"yyyy-mm-dd"
  });
})
</script>
@endsection