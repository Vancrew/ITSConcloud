@section('js') @parent
<script type="text/javascript" src="{{url('bower_components/cleave.js/dist/cleave.min.js')}}"></script>
<script type="text/javascript" src="{{url('bower_components/numeral/min/numeral.min.js')}}"></script>
<script>
cleaved = [];
$(function() {
  $(".input-accounting").each(function() {
    var cleave = new Cleave(this, {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
    });
    cleaved.push(cleave);
  })
});

accounting = function(n) {
  return numeral(n).format('0,0');
}
unaccounting = function (n) {
  return numeral(n).value();
}
</script>
@endsection