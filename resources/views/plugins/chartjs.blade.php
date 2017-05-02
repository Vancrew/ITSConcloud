@section('js') @parent
<script src="{{url('bower_components/chart.js/dist/Chart.min.js')}}"></script>
<script>
  Chart.defaults.global.scale.yAxes.ticks.beginAtZero = true;
  //Boolean - If we should show the scale at all
  Chart.defaults.global.showScale = true;
  //Boolean - Whether grid lines are shown across the chart
  Chart.defaults.global.scaleShowGridLines = false;
  //String - Colour of the grid lines
  Chart.defaults.global.scaleGridLineColor = "rgba(0,0,0,.05)";
  //Number - Width of the grid lines
  Chart.defaults.global.scaleGridLineWidth = 1;
  //Boolean - Whether to show horizontal lines (except X axis)
  Chart.defaults.global.scaleShowHorizontalLines = true;
  //Boolean - Whether to show vertical lines (except Y axis)
  Chart.defaults.global.scaleShowVerticalLines = true;
  //Boolean - Whether the line is curved between points
  Chart.defaults.global.bezierCurve = true;
  //Number - Tension of the bezier curve between points
  Chart.defaults.global.bezierCurveTension = 0.3;
  //Boolean - Whether to show a dot for each point
  Chart.defaults.global.pointDot = false;
  //Number - Radius of each point dot in pixels
  Chart.defaults.global.pointDotRadius = 4;
  //Number - Pixel width of point dot stroke
  Chart.defaults.global.pointDotStrokeWidth = 1;
  //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
  Chart.defaults.global.pointHitDetectionRadius = 25;
  //Boolean - Whether to show a stroke for datasets
  Chart.defaults.global.datasetStroke = true;
  //Number - Pixel width of dataset stroke
  Chart.defaults.global.datasetStrokeWidth = 2;
  //Boolean - Whether to fill the dataset with a color
  Chart.defaults.global.datasetFill = false;
  //String - A legend template
  Chart.defaults.global.legendTemplate = "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>";
  //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
  maintainAspectRatio: true;
  //Boolean - whether to make the chart responsive to window resizing
  Chart.defaults.global.responsive = true;
  // Chart.defaults.global.spanGaps = false;
</script>
@endsection