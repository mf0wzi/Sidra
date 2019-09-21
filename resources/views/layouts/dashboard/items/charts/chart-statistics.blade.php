<!-- CHART -->
<div id="{{ $id }}" class="box {{ $class }}">
    <div class="box-header with-border">
        <i class="{{ $icon }}"></i><h3 class="box-title">{{ $title }}</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-setting"></i></button>
        </div>
        @if($statisticsPosition != null && $statisticsPosition == 'top')
            <ul class="nav nav-pills nav-stacked">
                @foreach($values as $key => $data)
                    <li><a href="#">{{ $valuesLabel[$key] }} <span class="pull-right badge {{ $valueLabelColor[$key] }}">{{ $data }}</span></a></li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="box-body">
        {!! $chartjs->container() !!}
    </div>
    <!-- /.box-body -->
@if($statisticsPosition == null || $statisticsPosition == 'bottom')
    <!-- .box-footer -->
        <div class="box-footer no-padding">
            <ul class="nav nav-pills nav-stacked">
                @foreach($values as $key => $data)
                    <li><a href="#">{{ $valuesLabel[$key] }} <span class="pull-right badge {{ $valueLabelColor[$key] }}">{{ $data }}</span></a></li>
                @endforeach
            </ul>
        </div>
@endif
<!-- /.box-footer -->
</div>
<!-- /.box -->
@section('chartjs')
    @parent
    {!! $chartjs->script() !!}
@endsection
