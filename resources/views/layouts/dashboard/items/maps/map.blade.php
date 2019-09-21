<!-- CHART -->
<div id="{{ $id }}" class="box {{ $class }}">
    <div class="box-header with-border">
        <i class="{{ $icon }}"></i><h3 class="box-title">{{ $title }}</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-setting"></i></button>
        </div>
    </div>
    <div class="box-body no-padding">
        {!! $mapleaflet->container() !!}
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
@section('leafletFunction')
    {!! $mapleaflet->mapFunctions() !!}
@endsection
@section('leaflet')
    @parent
    {!! $mapleaflet->script() !!}
@endsection
