<!-- Widgets -->
<div class="modal modal-warning fade" tabindex="-1" id="widget_modal" style="z-index: 55555;" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span
                        aria-hidden="true">&times;</span></button>
                <h4 id="widg_hd_add" class="modal-title hidden"><i class="voyager-plus"></i> <i class="voyager-categories"></i> {{ __('Create New Widget Item') }}</h4>
                <h4 id="widg_hd_edit" class="modal-title hidden"><i class="voyager-edit"></i> <i class="voyager-categories"></i> {{ __('Edit Widget Item') }}</h4>
            </div>
            <form action="" id="widg_form" method="POST"
                  data-action-add="{{ route('projectpages.item.add', ['projectpage' => $projectpage->id]) }}"
                  data-action-update="{{ route('projectpages.item.update', ['projectpage' => $projectpage->id]) }}">

                <input id="widg_form_method" type="hidden" name="_method" value="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    @include('voyager::multilingual.language-selector')
                    <label for="title">{{ __('Title of Widget Item') }}</label> <i class="icon voyager-helm small text-danger"></i>
                    @include('voyager::multilingual.input-hidden', ['_field_name' => 'title', '_field_trans' => ''])
                    <input type="text" class="form-control" id="widg_title" name="title" placeholder="{{ __('voyager::generic.title') }}" required><br>
                    <label for="type">{{ __('Widget Type') }}</label> <i class="icon voyager-helm small text-danger"></i>
                    <select id="widg_container_type" class="form-control" name="type" required> <i class="icon voyager-helm small text-danger"></i>
                        <option value="" selected="selected" disabled="disabled" hidden>{{ __('Select your Widget') }}</option>
                        <option value="box">{{ __('Box') }}</option>
                        <option value="callout">{{ __('Callout') }}</option>
                        <option value="small-box">{{ __('Small Box') }}</option>
                        <option value="small-box-two">{{ __('Small Box Two') }}</option>
                        <option value="small-box-detail">{{ __('Small Box Detail') }}</option>
                        <option value="info-box">{{ __('Info Box') }}</option>
                        <option value="info-box-two">{{ __('Info Box Two') }}</option>
                        <option value="info-box-detail">{{ __('Info Box Detail') }}</option>
                        <option value="widget-user">{{ __('Widget User') }}</option>
                        <option value="table">{{ __('Table') }}</option>
                    </select><br>
                    <label for="icon_class">{{ __('Icon Class') }}</label> <i class="icon voyager-helm small text-danger"></i>
                    <input type="text" class="form-control" id="widg_icon_class" name="icon_class" placeholder="{{ __('Add your Icon Class Here') }}" required><br>
                    <div id="widg_class_type">
                        <label for="color">{{ __('Widget Color') }}</label> <i class="icon voyager-helm small text-danger"></i>
                        <select id="widg_color" class="form-control" name="color" required> <i class="icon voyager-helm small text-danger"></i>
                            <option value="" selected="selected" disabled="disabled" hidden>{{ __('Select your Color') }}</option>
                            <option value="box-solid">{{ __('Box Solid') }}</option>
                            <option value="box-default">{{ __('Box Default') }}</option>
                            <option value="box-primary">{{ __('Box Primary') }}</option>
                            <option value="box-success">{{ __('Box Success') }}</option>
                            <option value="box-warning">{{ __('Box Warning') }}</option>
                            <option value="box-danger">{{ __('Box Danger') }}</option>
                            <option value="callout-default">{{ __('Callout Default') }}</option>
                            <option value="callout-info">{{ __('Callout Info') }}</option>
                            <option value="callout-success">{{ __('Callout Success') }}</option>
                            <option value="callout-warning">{{ __('Callout Warning') }}</option>
                            <option value="callout-danger">{{ __('Callout Danger') }}</option>
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
                        <textarea rows="3" class="form-control" id="widg_class" name="class" placeholder="{{ __('Add your Class Here') }}" required></textarea><br>
                    </div>
                    <label for="labels">{{ __('Labels') }}</label> <i class="icon voyager-helm small text-danger"></i> <a herf="#" id="widg_info" for="labels" data-toggle="popovers" title="Popover Header" data-trigger="hover" data-content="Some content inside the popover">Data Format</a>
                    <div id="widg_labels" data-theme="monokai" data-language="json" class="ace_editor ace_dark ace-monokai min_height_200" name="labels" placeholder="{{ json_encode(['key' => 'value'], JSON_PRETTY_PRINT) }}">
                    </div>
                    <textarea rows="3" class="form-control hidden" id="widg_labels_textarea" name="labels" data-editor="json" placeholder="{{ json_encode(['key' => 'value'], JSON_PRETTY_PRINT) }}"></textarea><br>
                    <label for="sql">{{ __('SQL') }}</label> <i class="icon voyager-helm small text-danger"></i>
                    <div id="widg_sql" data-theme="monokai" data-language="mysql" class="ace_editor ace_dark ace-monokai min_height_200" name="sql">
                    </div>
                    <textarea rows="3" class="form-control hidden" id="widg_sql_textarea" name="sql" data-editor="sql" placeholder="{{ __('Add your SQL Here') }}"></textarea><br>
                    <div id="widg_url_type">
                        <label for="url">{{ __('URL') }}</label> <i class="icon voyager-helm small text-danger"></i> <label for="url"> {{ __('Use a Protocol like http:// or https:// to make URL external') }}</label>
                        <input type="text" class="form-control" id="widg_url" name="url" placeholder="{{ __('Add your URL Here') }}"><br>
                    </div>
                    <div id="widg_description_type">
                        <label for="description">{{ __('Description') }}</label> <i class="icon voyager-helm small text-danger"></i>
                        <textarea rows="5" class="form-control richTextBox" id="widg_description" name="description" placeholder="{{ __('Add your Description Here') }}"></textarea><br>
                    </div>
                    <input type="hidden" name="projectpage_id" value="{{ $projectpage->id }}">
                    <input type="hidden" name="id" id="widg_id" value="">
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success pull-right delete-confirm__" value="{{ __('voyager::generic.update') }}">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
