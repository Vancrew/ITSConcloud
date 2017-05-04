@extends('app')

@include('plugins.datepicker')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <a class="btn btn-sm btn-success modalMd" href="{{ action('FileController@create') }}" title="Upload File"><span class="glyphicon glyphicon-upload"></span> Upload Foto</a>
        <div class="row" style="margin-top: 10px">
            @foreach($file as $row)
            <div class="col-sm-3">
                <div class="thumbnail">
                    {{ Html::image('images/'.$row->file,$row->nama) }}
                    <div class="caption">
                        <h3>{{ $row->nama }}</h3>
                        <form action="{{ action('FileController@destroy',['id'=>$row->id]) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="btn btn-xs btn-danger" title="Delete InspTemuanItem" onclick="return confirm('Confirm delete?')" type="submit">
                                Hapus Foto <i class="glyphicon glyphicon-trash"></i>
                            </button>   
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-lg-12">
                {!! $file->links() !!}
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
$('.modalMd').off('click').on('click', function (e) {
    $("#modalMd").modal('show');
    $('#modalMdContent').load($(this).attr('href'));
    $('#modalMdTitle').html($(this).attr('title'));
    e.preventDefault();
});
</script>
@endsection
