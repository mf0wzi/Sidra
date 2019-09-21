<div id="{{ $id }}" class="box {{ $class }}">
    <h4 class="box-header {{ $hclass }}"><i class="{{$icon}}"></i> {{ $title }}</h4>
    <div class="box-body {{ $bclass }}">
        <table id="{{ $id }}_table" class="table {{ $tclass }}">
            <thead>
            <tr>
                <th class="hidden-sm hidden-xs">#</th>
                @foreach($tableheaderfooter as $row)
                    {!! $row !!}
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($tabledata as $row)
                {!! $row !!}
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th class="hidden-sm hidden-xs">#</th>
                @foreach($tableheaderfooter as $row)
                    {!! $row !!}
                @endforeach
            </tr>
            </tfoot>
        </table>
    </div>
</div>

@section('datatables')
    @parent
    <script type="application/javascript">
        $(document).ready(function() {
            var pagination = '{{ $pagination }}';
            if(pagination == 'YES') {
                var table_size = '{{ count($tabledata) }}';
                if (table_size > 10) {
                    var table_name = '{{ $id }}' + '_table';
                    $('#' + table_name).DataTable();
                    $('#' + table_name + '_paginate').removeClass('dataTables_paginate');
                    $('#' + table_name + '_paginate').css('float', 'right');
                }
            }
        });
    </script>
@endsection
