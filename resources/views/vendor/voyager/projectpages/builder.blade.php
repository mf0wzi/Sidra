@extends('voyager::master')

@section('page_title', __('PP Builder'))
@section('page_header')
    <h1 class="page-title">
        <i class="voyager-list"></i>{{ __('PP Builder') }} ({{ $projectpage->page_name }})
        {{--        <div class="btn btn-sm btn-success add_item add_container"><i class="voyager-code"></i> {{ __('Container') }}</div>--}}
        <div class="btn btn-sm btn-dark add_item add_container"><i class="voyager-code"></i> {{ __('Container') }}</div>
        <div class="btn btn-sm btn-warning add_item add_widget"><i class="voyager-categories"></i> {{ __('Widget') }}</div>
        <div class="btn btn-sm btn-primary add_item add_chart"><i class="voyager-bar-chart"></i> {{ __('Charts') }}</div>
        <div class="btn btn-sm btn-danger add_item add_map"><i class="voyager-ship"></i> {{ __('Maps') }}</div>
        <div class="btn btn-sm btn-default add_item add_tooltip"><i class="voyager-chat"></i> {{ __('Tooltips') }}</div>
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    @include('vendor.voyager.projectpages.notice')

    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-heading">
                        <p class="panel-title" style="color:#777">{{ __('Drag and drop the page Items below to re-arrange them.') }}</p>
                    </div>

                    <div class="panel-body" style="padding:30px;">
                        <div class="dd">
                            {!! pageitem($projectpage->page_name, 'admin', ['isModelTranslatable' => $isModelTranslatable]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::menu_builder.delete_item_question') }}</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('projectpages.item.destroy', ['projectpage' => $projectpage->id, 'id' => '__id']) }}"
                          id="delete_form"
                          method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('voyager::menu_builder.delete_item_confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    @include('vendor.voyager.projectpages.modal.container.container')


    @include('vendor.voyager.projectpages.modal.widget.widget')


    @include('vendor.voyager.projectpages.modal.chart.chart')


    @include('vendor.voyager.projectpages.modal.map.map')

@stop
@section('jslibs')
    <script type="text/javascript" src="{{ asset('js/admin-brace.js') }}"></script>
@endsection
@section('javascript')
    @include('vendor.voyager.projectpages.builder-javascript')
    @include('vendor.voyager.projectpages.modal.container.container-javascript')
    @include('vendor.voyager.projectpages.modal.widget.widget-javascript')
    @include('vendor.voyager.projectpages.modal.chart.chart-javascript')
    @include('vendor.voyager.projectpages.modal.map.map-javascript')
@stop
