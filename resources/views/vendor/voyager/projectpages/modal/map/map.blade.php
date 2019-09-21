<!-- Widgets -->
<div class="modal modal-danger fade" tabindex="-1" id="map_modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span
                        aria-hidden="true">&times;</span></button>
                <h4 id="map_hd_add" class="modal-title hidden"><i class="voyager-plus"></i> <i class="voyager-ship"></i> {{ __('Create New Map') }}</h4>
                <h4 id="map_hd_edit" class="modal-title hidden"><i class="voyager-edit"></i> <i class="voyager-ship"></i> {{ __('Edit Map') }}</h4>
            </div>
            <form action="" id="map_form" method="POST"
                  data-action-add="{{ route('projectpages.item.add', ['projectpage' => $projectpage->id]) }}"
                  data-action-update="{{ route('projectpages.item.update', ['projectpage' => $projectpage->id]) }}">

                <input id="map_form_method" type="hidden" name="_method" value="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    @include('voyager::multilingual.language-selector')
                    <label for="title">{{ __('Title of Map Item') }}</label> <i class="icon voyager-helm small text-danger"></i>
                    @include('voyager::multilingual.input-hidden', ['_field_name' => 'title', '_field_trans' => ''])
                    <input type="text" class="form-control" id="map_title" name="title" placeholder="{{ __('voyager::generic.title') }}" required><br>
                    <label for="type">{{ __('Map Type') }}</label> <i class="icon voyager-helm small text-danger"></i>
                    <select id="map_container_type" class="form-control" name="type" required> <i class="icon voyager-helm small text-danger"></i>
                        <option value="" selected="selected" disabled="disabled" hidden>{{ __('Select your Map') }}</option>
                        <option value="map">{{ __('Map') }}</option>
                        <option value="map-statistics">{{ __('Map With Statistics') }}</option>
                        <option value="map-in-box">{{ __('Map in Box') }}</option>
                        <option value="map-in-box-statistics">{{ __('Map in Box With Statistics') }}</option>
                    </select><br>
                    <label for="tile">{{ __('Map Tile') }}</label> <i class="icon voyager-helm small text-danger"></i>
                    <select id="map_tile" class="form-control" name="tile" required> <i class="icon voyager-helm small text-danger"></i>
                        <option value="" selected="selected" disabled="disabled" hidden>{{ __('Select your Map Tile') }}</option>
                        <option value="openstreet">{{ __('Open Street Map') }}</option>
                        <option value="opentopo">{{ __('Open topo Map') }}</option>
                        <option value="openmapsurfer">{{ __('Open Map Surfer') }}</option>
                        <option value="custom">{{ __('Custom Map') }}</option>
                    </select><br>
                    <label for="sub_type">{{ __('Map Setting') }}</label> <i class="icon voyager-helm small text-danger"></i>
                    <select id="map_sub_type" class="form-control" name="sub_type" required> <i class="icon voyager-helm small text-danger"></i>
                        <option value="" selected="selected" disabled="disabled" hidden>{{ __('Select your Sub Map') }}</option>
                        <option value="default">{{ __('Default Setting') }}</option>
                        <option value="cluster">{{ __('Cluster Setting') }}</option>
                        <option value="custom">{{ __('Custom Setting') }}</option>
                    </select><br>
                    <label for="icon_class">{{ __('Icon Class') }}</label> <i class="icon voyager-helm small text-danger"></i>
                    <input type="text" class="form-control" id="map_icon_class" name="icon_class" placeholder="{{ __('Add your Icon Class Here') }}" required><br>
                    <div id="map_class_type">
                        <label for="color">{{ __('Map Color') }}</label> <i class="icon voyager-helm small text-danger"></i>
                        <select id="map_color" class="form-control" name="color" required> <i class="icon voyager-helm small text-danger"></i>
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
                        <textarea rows="3" class="form-control" id="map_class" name="class" placeholder="{{ __('Add your Class Here') }}" required></textarea><br>
                    </div>
                    <div>
                        <label for="labels">{{ __('Labels') }}</label> <i class="icon voyager-helm small text-danger"></i> <a herf="#" id="map_info" for="labels" data-toggle="popovers" title="Popover Header" data-trigger="hover" data-content="Some content inside the popover">Data Format</a>
                        <div id="map_labels" data-theme="monokai" data-language="json" class="ace_editor ace_dark ace-monokai min_height_200" name="labels" placeholder="{{ json_encode(['key' => 'value'], JSON_PRETTY_PRINT) }}">
                        </div>
                        <textarea rows="10" class="form-control hidden" id="map_labels_textarea" name="labels" data-editor="json" placeholder="{{ __('Add your Dataset Here') }}"></textarea><br>
                    </div>
                    <div id="options_type">
                        <label for="options">{{ __('Map Options') }}</label> <i class="icon voyager-helm small text-danger"></i>
                        <div id="map_options" data-theme="monokai" data-language="json" class="ace_editor ace_dark ace-monokai min_height_200" name="options">
                        </div>
                        <textarea rows="10" class="form-control hidden" id="map_options_textarea" name="options" data-editor="json" placeholder="{{ __('Add your Dataset Here') }}"></textarea><br>
                    </div>
                    <div id="dataset_type">
                        <label for="dataset">{{ __('DataSet') }}</label> <i class="icon voyager-helm small text-danger"></i>
                        <div id="map_dataset" data-theme="monokai" data-language="javascript" class="ace_editor ace_dark ace-monokai min_height_200" name="dataset">
                        </div>
                        <textarea rows="3" class="form-control hidden" id="map_dataset_textarea" name="dataset" data-editor="javascript"></textarea><br>
                    </div>
                    <div id="marker_type">
                        <label for="marker">{{ __('Marker') }}</label> <i class="icon voyager-helm small text-danger"></i>
                        <div id="map_marker" data-theme="monokai" data-language="javascript" class="ace_editor ace_dark ace-monokai min_height_200" name="marker">
                        </div>
                        <textarea rows="10" class="form-control hidden" id="map_marker_textarea" name="marker" data-editor="javascript" placeholder="{{ __('Add your Marker Here') }}"></textarea><br>
                    </div>
                    <div id="tooltip_type">
                        <label for="tooltip">{{ __('Tooltip') }}</label> <i class="icon voyager-helm small text-danger"></i>
                        <div id="map_tooltip" data-theme="monokai" data-language="javascript" class="ace_editor ace_dark ace-monokai min_height_200" name="tooltip">
                        </div>
                        <textarea rows="10" class="form-control hidden" id="map_tooltip_textarea" name="tooltip" data-editor="javascript" placeholder="{{ __('Add your Tooltip Here') }}"></textarea><br>
                    </div>
                    <div id="popup_type">
                        <label for="popup">{{ __('Popup') }}</label> <i class="icon voyager-helm small text-danger"></i>
                        <div id="map_popup" data-theme="monokai" data-language="javascript" class="ace_editor ace_dark ace-monokai min_height_200" name="popup">
                        </div>
                        <textarea rows="10" class="form-control hidden" id="map_popup_textarea" name="popup" data-editor="javascript" placeholder="{{ __('Add your Popup Here') }}"></textarea><br>
                    </div>
                    <div id="custom_function_type">
                        <label for="custom_function">{{ __('Custom Functions') }}</label> <i class="icon voyager-helm small text-danger"></i>
                        <div id="map_custom_function" data-theme="monokai" data-language="javascript" class="ace_editor ace_dark ace-monokai min_height_200" name="custom_function">
                        </div>
                        <textarea rows="10" class="form-control hidden" id="map_custom_function_textarea" name="custom_function" data-editor="javascript" placeholder="{{ __('Add your Popup Here') }}"></textarea><br>
                    </div>
                    <div>
                        <label for="sql">{{ __('SQL') }}</label> <i class="icon voyager-helm small text-danger"></i>
                        <div id="map_sql" data-theme="monokai" data-language="mysql" class="ace_editor ace_dark ace-monokai min_height_200" name="sql">
                        </div>
                        <textarea rows="10" class="form-control hidden" id="map_sql_textarea" name="sql" data-language=mysql" placeholder="{{ __('Add your SQL Here') }}"></textarea><br>
                    </div>
                    <div id="map_url_type">
                        <label for="url">{{ __('URL') }}</label> <i class="icon voyager-helm small text-danger"></i> <label for="url"> {{ __('Use a Protocol like http:// or https:// to make URL external') }}</label>
                        <input type="text" class="form-control" id="map_url" name="url" placeholder="{{ __('Add your URL Here') }}"><br>
                    </div>
                    <div id="map_description_type">
                        <label for="description">{{ __('Description') }}</label> <i class="icon voyager-helm small text-danger"></i>
                        <textarea rows="5" class="form-control richTextBox" id="map_description" name="description" placeholder="{{ __('Add your Description Here') }}"></textarea><br>
                    </div>
                    <input type="hidden" name="projectpage_id" value="{{ $projectpage->id }}">
                    <input type="hidden" name="id" id="map_id" value="">
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success pull-right delete-confirm__" value="{{ __('voyager::generic.update') }}">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
