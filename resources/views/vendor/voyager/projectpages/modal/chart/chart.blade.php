<!-- Widgets -->
<div class="modal modal-info fade" tabindex="-1" id="chart_modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span
                        aria-hidden="true">&times;</span></button>
                <h4 id="chart_hd_add" class="modal-title hidden"><i class="voyager-plus"></i> <i class="voyager-bar-chart"></i> {{ __('Create New Chart Item') }}</h4>
                <h4 id="chart_hd_edit" class="modal-title hidden"><i class="voyager-edit"></i> <i class="voyager-bar-chart"></i> {{ __('Edit Chart Item') }}</h4>
            </div>
            <form action="" id="chart_form" method="POST"
                  data-action-add="{{ route('projectpages.item.add', ['projectpage' => $projectpage->id]) }}"
                  data-action-update="{{ route('projectpages.item.update', ['projectpage' => $projectpage->id]) }}">

                <input id="chart_form_method" type="hidden" name="_method" value="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    @include('voyager::multilingual.language-selector')
                    <label for="title">{{ __('Title of Chart Item') }}</label> <i class="icon voyager-helm small text-danger"></i>
                    @include('voyager::multilingual.input-hidden', ['_field_name' => 'title', '_field_trans' => ''])
                    <input type="text" class="form-control" id="chart_title" name="title" placeholder="{{ __('voyager::generic.title') }}" required><br>
                    <label for="type">{{ __('Chart Type') }}</label> <i class="icon voyager-helm small text-danger"></i>
                    <select id="chart_container_type" class="form-control" name="type" required> <i class="icon voyager-helm small text-danger"></i>
                        <option value="" selected="selected" disabled="disabled" hidden>{{ __('Select your Chart') }}</option>
                        <option value="chart">{{ __('Chart') }}</option>
                        <option value="chart-statistics">{{ __('Chart With Statistics') }}</option>
                        <option value="chart-in-box">{{ __('Chart in Box') }}</option>
                        <option value="chart-in-box-statistics">{{ __('Chart in Box With Statistics') }}</option>
                    </select><br>
                    <label for="sub_type">{{ __('Chart Sub Type') }}</label> <i class="icon voyager-helm small text-danger"></i>
                    <select id="chart_sub_type" class="form-control" name="sub_type" required> <i class="icon voyager-helm small text-danger"></i>
                        <option value="" selected="selected" disabled="disabled" hidden>{{ __('Select your Sub Chart') }}</option>
                        <option value="line">{{ __('Line Chart') }}</option>
                        <option value="bar">{{ __('Bar Chart') }}</option>
                        <option value="horizontalBar">{{ __('Horizontal Bar Chart') }}</option>
                        <option value="radar">{{ __('Radar Chart') }}</option>
                        <option value="pie">{{ __('Pie Chart') }}</option>
                        <option value="doughnut">{{ __('Doughnut Chart') }}</option>
                        <option value="polarArea">{{ __('Polar Area Chart') }}</option>
                        <option value="bubble">{{ __('Bubble Area Chart') }}</option>
                        <option value="scatter">{{ __('Scatter Area Chart') }}</option>
                    </select><br>
                    <label for="icon_class">{{ __('Icon Class') }}</label> <i class="icon voyager-helm small text-danger"></i>
                    <input type="text" class="form-control" id="chart_icon_class" name="icon_class" placeholder="{{ __('Add your Icon Class Here') }}" required><br>
                    <div id="chart_class_type">
                        <label for="color">{{ __('Chart Color') }}</label> <i class="icon voyager-helm small text-danger"></i>
                        <select id="chart_color" class="form-control" name="color" required> <i class="icon voyager-helm small text-danger"></i>
                            <option value="" selected="selected" disabled="disabled" hidden>{{ __('Select your Color') }}</option>
                            <option value="box-solid">{{ __('Box Solid') }}</option>
                            <option value="box-default">{{ __('Box Default') }}</option>
                            <option value="box-primary">{{ __('Box Primary') }}</option>
                            <option value="box-success">{{ __('Box Success') }}</option>
                            <option value="box-warning">{{ __('Box Warning') }}</option>
                            <option value="box-danger">{{ __('Box Danger') }}</option>
                            <option class="bg-default" value="bg-default">{{ __('Default') }}</option>
                            <option value="bg-gray">{{ __('Gray') }}</option>
                            <option value="bg-gray-light">{{ __('Light Gray') }}</option>
                            <option value="bg-aqua">{{ __('Aqua') }}</option>
                            <option value="bg-blue">{{ __('Blue') }}</option>
                            <option value="bg-light-blue">{{ __('Light Blue') }}</option>
                            <option value="bg-green">{{ __('Green') }}</option>
                            <option value="bg-teal">{{ __('Teal') }}</option>
                            <option value="bg-olive">{{ __('Olive') }}</option>
                            <option value="bg-lime">{{ __('Lime') }}</option>
                            <option value="bg-yellow">{{ __('Yellow') }}</option>
                            <option value="bg-orange">{{ __('Orange') }}</option>
                            <option value="bg-red">{{ __('Red') }}</option>
                            <option value="bg-maroon">{{ __('Maroon') }}</option>
                            <option value="bg-fuchsia">{{ __('Fuchsia') }}</option>
                            <option value="bg-purple">{{ __('Purple') }}</option>
                            <option value="bg-black">{{ __('Black') }}</option>
                            <option value="bg-navy">{{ __('Navy') }}</option>
                            <option value="bg-gray-active">{{ __('Active Gray') }}</option>
                        </select><br>
                        <label for="class">{{ __('Class') }}</label> <i class="icon voyager-helm small text-danger"></i>
                        <textarea rows="3" class="form-control" id="chart_class" name="class" placeholder="{{ __('Add your Class Here') }}" required></textarea><br>
                    </div>
                    <label for="labels">{{ __('Labels') }}</label> <i class="icon voyager-helm small text-danger"></i> <a herf="#" id="chart_info" for="labels" data-toggle="popovers" title="Popover Header" data-trigger="hover" data-content="Some content inside the popover">Data Format</a>
                    <div id="chart_labels" data-theme="monokai" data-language="json" class="ace_editor ace_dark ace-monokai min_height_200" name="labels" placeholder="{{ json_encode(['key' => 'value'], JSON_PRETTY_PRINT) }}">
                    </div>
                    <textarea rows="3" class="form-control hidden" id="chart_labels_textarea" name="labels" data-editor="json" placeholder="{{ json_encode(['key' => 'value'], JSON_PRETTY_PRINT) }}"></textarea><br>
                    <label for="dataset">{{ __('DataSet') }}</label> <i class="icon voyager-helm small text-danger"></i>
                    <div id="chart_dataset" data-theme="monokai" data-language="json" class="ace_editor ace_dark ace-monokai min_height_200" name="dataset">
                    </div>
                    <textarea rows="10" class="form-control hidden" id="chart_dataset_textarea" name="dataset" data-editor="json" placeholder="{{ __('Add your Dataset Here') }}"></textarea><br>
                    <label for="options">{{ __('Chart Options') }}</label> <i class="icon voyager-helm small text-danger"></i>
                    <div id="chart_options" data-theme="monokai" data-language="json" class="ace_editor ace_dark ace-monokai min_height_200" name="options">
                    </div>
                    <textarea rows="10" class="form-control hidden" id="chart_options_textarea" name="options" data-language="json" placeholder="{{ json_encode(['key' => 'value'], JSON_PRETTY_PRINT) }}"></textarea><br>
                    <label for="sql">{{ __('SQL') }}</label> <i class="icon voyager-helm small text-danger"></i>
                    <div id="chart_sql" data-theme="monokai" data-language="mysql" class="ace_editor ace_dark ace-monokai min_height_200" name="sql">
                    </div>
                    <textarea rows="10" class="form-control hidden" id="chart_sql_textarea" name="sql" data-language=mysql" placeholder="{{ __('Add your SQL Here') }}"></textarea><br>
                    <div id="chart_url_type">
                        <label for="url">{{ __('URL') }}</label> <i class="icon voyager-helm small text-danger"></i> <label for="url"> {{ __('Use a Protocol like http:// or https:// to make URL external') }}</label>
                        <input type="text" class="form-control" id="chart_url" name="url" placeholder="{{ __('Add your URL Here') }}"><br>
                    </div>
                    <div id="chart_description_type">
                        <label for="description">{{ __('Description') }}</label> <i class="icon voyager-helm small text-danger"></i>
                        <textarea rows="5" class="form-control richTextBox" id="chart_description" name="description" placeholder="{{ __('Add your Description Here') }}"></textarea><br>
                    </div>
                    <input type="hidden" name="projectpage_id" value="{{ $projectpage->id }}">
                    <input type="hidden" name="id" id="chart_id" value="">
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success pull-right delete-confirm__" value="{{ __('voyager::generic.update') }}">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
