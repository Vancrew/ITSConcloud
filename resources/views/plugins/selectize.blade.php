@section('css') @parent
<link href="{{url('bower_components/selectize/dist/css/selectize.css')}}" rel="stylesheet">
<style type="text/css">
  .form-inline .selectize-control {
    margin-bottom: -5px;
  }
  .selectize-control {
    height: 35px;
  }
</style>
@endsection

@section('js') @parent
<script type="text/javascript" src="{{url('bower_components/selectize/dist/js/standalone/selectize.js')}}"></script>
@endsection