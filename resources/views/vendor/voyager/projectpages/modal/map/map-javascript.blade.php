<script type="application/javascript">
    $(document).ready(function () {
        /**
         * Set map Variables
         */
        var $map_modal                      = $('#map_modal'),
            $map_hd_add                     = $('#map_hd_add').hide().removeClass('hidden'),
            $map_hd_edit                    = $('#map_hd_edit').hide().removeClass('hidden'),
            $map_form                       = $('#map_form'),
            $map_form_method                = $('#map_form_method'),
            $map_title                      = $('#map_title'),
            $map_title_i18n                 = $('#title_i18n'),
            $map_container_type             = $('#map_container_type'),
            $map_sub_type                   = $('#map_sub_type'),
            $map_tile                       = $('#map_tile'),
            $map_class_type                 = $('#map_class_type'),
            $map_class                      = $('#map_class'),
            $map_color                      = $('#map_color'),
            $map_icon_class                 = $('#map_icon_class'),
            $map_labels                     = $('#map_labels'),
            $map_editor                     = ace.edit("map_labels"),
            $map_labels_textarea            = $('#map_labels_textarea'),
            $map_info                       = $('#map_info'),
            $map_url_type                   = $('#map_url_type'),
            $map_url                        = $('#map_url'),
            $map_dataset                    = $('#map_dataset'),
            $map_dataset_type               = $('#dataset_type'),
            $map_dataset_editor             = ace.edit("map_dataset"),
            $map_options                    = $('#map_options'),
            $map_options_type               = $('#options_type'),
            $map_options_editor             = ace.edit("map_options"),
            $map_marker                     = $('#map_marker'),
            $map_marker_type                = $('#marker_type'),
            $map_marker_editor              = ace.edit("map_marker"),
            $map_tooltip                    = $('#map_tooltip'),
            $map_tooltip_type               = $('#tooltip_type'),
            $map_tooltip_editor             = ace.edit("map_tooltip"),
            $map_popup                      = $('#map_popup'),
            $map_popup_type                 = $('#popup_type'),
            $map_popup_editor               = ace.edit("map_popup"),
            $map_custom_functions           = $('#map_custom_function'),
            $map_custom_functions_type      = $('#custom_function_type'),
            $map_custom_functions_editor    = ace.edit("map_custom_function"),
            $map_sql                        = $('#map_sql'),
            $map_sql_editor                 = ace.edit("map_sql"),
            $map_description_type           = $('#map_description_type'),
            $map_description                = $('#map_description'),
            $map_id                         = $('#map_id');

        /////////////////////////////////////////////////////////////////////////////////


        /**
         *  map Add
         */
        $('.add_map').click(function() {
            $map_form.trigger('reset');
            $map_form.find("input[type=submit]").val('{{ __('voyager::generic.add') }}');
            $map_modal.modal('show', {data: null});
        });

        /**
         *  map Edit
         */
        $('.item_actions_map').on('click', '.edit', function (e) {
            $map_form.find("input[type=submit]").val('{{ __('voyager::generic.update') }}');
            $map_modal.modal('show', {data: $(e.currentTarget)});
        });

        /////////////////////////////////////////////////

        /**
         * map Modal is Open
         */
        $map_modal.on('show.bs.modal', function(e, data) {
            var _adding      = e.relatedTarget.data ? false : true,
                translatable = $map_modal.data('multilingual'),
                $_str_i18n   = '';

            if (_adding) {
                $map_form.attr('action', $map_form.data('action-add'));
                $map_form_method.val('POST');
                $map_hd_add.show();
                $map_hd_edit.hide();
                $map_container_type.val('type').change();
                $map_sub_type.val('sub_type').change();
                $map_tile.val('tile').change();

            } else {
                $map_form.attr('action', $map_form.data('action-update'));
                $map_form_method.val('PUT');
                $map_hd_add.hide();
                $map_hd_edit.show();

                var _src = e.relatedTarget.data, // the source
                    id   = _src.data('id');

                $map_title.val(_src.data('title'));
                $map_container_type.val(_src.data('type'));
                $map_sub_type.val(_src.data('sub_type'));
                $map_tile.val(_src.data('tile'));
                $map_icon_class.val(_src.data('icon_class'));
                $map_class.val(_src.data('class'));
                $map_editor.session.setValue(JSON.stringify(_src.data('labels'),null,2));
//$map_dataset.val(JSON.stringify(_src.data('dataset'),null, 2));
                $map_dataset_editor.session.setValue(_src.data('dataset'));
                $map_options_editor.session.setValue(_src.data('options'));
                $map_marker_editor.session.setValue(_src.data('marker'));
                $map_tooltip_editor.session.setValue(_src.data('tooltip'));
                $map_popup_editor.session.setValue(_src.data('popup'));
                $map_custom_functions_editor.session.setValue(_src.data('custom_function'));
                $map_sql_editor.session.setValue(_src.data('sql'));
                // $map_url.val(_src.data('url'));
                // tinymce.get("map_description").setContent(_src.data('description'));
                $map_id.val(id);

                var type;
                if(_src.data('type') == 'map' || _src.data('type') == 'map-statistics'){
                    type = getColor('box-',_src.data('class'));
                } else if(_src.data('type') == 'map-in-box' || _src.data('type') == 'map-in-box-statistics') {
                    type = getColor('bg-',_src.data('color'));
                }
                $map_color.val(type);

                if(translatable){
                    $_str_i18n = $("#title" + id + "_i18n").val();
                }

                /**
                 *  Add the values of map
                 */
                if (_src.data('type') == "map" || _src.data('type') == "map-statistics") {
                    $map_container_type.find("option[value='']").removeAttr('selected');
                    $map_container_type.find("option[value='"+_src.data('type')+"']").attr('selected', 'selected');
                    $map_container_type.val(_src.data('type'));
                    $map_container_type.val(_src.data('type')).change();
                    $map_color.children('option').hide();
                    $map_color.children('option[value="box-solid"]').show();
                    $map_color.children('option[value="box-default"]').show();
                    $map_color.children('option[value="box-primary"]').show();
                    $map_color.children('option[value="box-success"]').show();
                    $map_color.children('option[value="box-warning"]').show();
                    $map_color.children('option[value="box-danger"]').show();
                } else if(_src.data('type') == "map-in-box" || _src.data('type') == "map-in-box-statistics") {
                    $map_container_type.find("option[value='']").removeAttr('selected');
                    $map_container_type.find("option[value='"+_src.data('type')+"']").attr('selected', 'selected');
                    $map_container_type.val(_src.data('type'));
                    $map_container_type.val(_src.data('type')).change();
                    $map_color.children('option').hide();
                    $map_color.children('option[value="bg-default"]').show();
                    $map_color.children('option[value="bg-info"]').show();
                    $map_color.children('option[value="bg-success"]').show();
                    $map_color.children('option[value="bg-warning"]').show();
                    $map_color.children('option[value="bg-danger"]').show();
                } else {
                    $map_labels.prop('required',false);
                    $map_url_type.hide();
                }

                if (_src.data('sub_type') == null){
                    $map_labels.prop('required',false);
                    $map_url_type.hide();
                } else {
                    $map_sub_type.find("option[value='']").removeAttr('selected');
                    $map_sub_type.find("option[value='"+_src.data('sub_type')+"']").attr('selected', 'selected');
                    $map_sub_type.val(_src.data('sub_type'));
                    $map_sub_type.val(_src.data('sub_type')).change();
                }

                if($map_container_type.val() == 'map') {
                    $map_description_type.hide();
                } else {
                    $map_description_type.hide();
                }

            }

            if (translatable) {
                $map_title_i18n.val($_str_i18n);
                translatable.refresh();
            }
        });

        ////////////////////////////////////////////////


        /**
         * Toggle From map Type
         */
        $map_container_type.on('change', function (e) {
            if($map_container_type.val() == 'map') {
                $map_description_type.show();
                $map_color.children('option').hide();
                $map_color.children('option[value="box-solid"]').show();
                $map_color.children('option[value="box-default"]').show();
                $map_color.children('option[value="box-primary"]').show();
                $map_color.children('option[value="box-success"]').show();
                $map_color.children('option[value="box-warning"]').show();
                $map_color.children('option[value="box-danger"]').show();
                $map_labels.val('');
                $map_labels.prop('required',false);
                if($('#map_labels > textarea[class="ace_text-input"]').val() == "" ){
                    $map_editor.session.setValue(JSON.stringify(JSON.parse('{"Value": "NULL", "ValueLabels": "NULL", ' +
                        '"mapLong": "NULL", "mapLat": "NULL", "mapWidth": "NULL", "mapHeight": "NULL",' +
                        '"mapMax": "NULL", "mapMin": "NULL", "mapStart": "NULL"}'),null,2),1);
                    $map_editor.clearSelection();
//$widg_labels_textarea.val(JSON.stringify(JSON.parse('{"Value": "NULL","BeforeSymbol": "NULL","AfterSymbol": "NULL","FooterLabel": "More info","FooterIcon": "fa fa-arrow-circle-right","DataType_number": "NULL","DataColor": "NULL"}'),null,2));
                }
                $map_description_type.hide();
                $map_url_type.hide();
            } else if($map_container_type.val() == 'map-statistics') {
                $map_description_type.show();
                $map_color.children('option').hide();
                $map_color.children('option[value="box-solid"]').show();
                $map_color.children('option[value="box-default"]').show();
                $map_color.children('option[value="box-primary"]').show();
                $map_color.children('option[value="box-success"]').show();
                $map_color.children('option[value="box-warning"]').show();
                $map_color.children('option[value="box-danger"]').show();
                $map_labels.val('');
                $map_labels.prop('required',false);
                if($('#map_labels > textarea[class="ace_text-input"]').val() == ""){
                    $map_editor.session.setValue(JSON.stringify(JSON.parse('{"Value": "NULL","ValueColor": ["NULL"], "ValueLabels": "NULL", "StatisticsPosition": "NULL", "mapWidth": "NULL", "mapHeight": "NULL", "DataType_number": "NULL"}'),null,2),1);
                    $map_editor.clearSelection();
                }
                $map_description_type.hide();
                $map_url_type.hide();
            } else if($map_container_type.val() == 'map-in-box') {
                $map_description_type.hide();
                $map_color.children('option').hide();
                $map_color.children('option[value="bg-default"]').show();
                $map_color.children('option[value="bg-aqua"]').show();
                $map_color.children('option[value="bg-green"]').show();
                $map_color.children('option[value="bg-yellow"]').show();
                $map_color.children('option[value="bg-red"]').show();
                $map_dataset.val();
                $map_labels.val('');
                $map_labels.prop('required',false);
                if($('#map_labels > textarea[class="ace_text-input"]').val() == ""){
                    $map_editor.session.setValue(JSON.stringify(JSON.parse('{"Value": "NULL","ValueColor": ["NULL"], "ValueLabels": "NULL", "Label1": "NULL", "Label2": "NULL", "StatisticsPosition": "NULL", "mapWidth": "NULL", "mapHeight": "NULL", "DataType_number": "NULL"}'),null,2),1);
                    $map_editor.clearSelection();
                }
                $map_description_type.hide();
                $map_url_type.hide();
            } else if($map_container_type.val() == 'map-in-box-statistics') {
                $map_description_type.hide();
                $map_color.children('option').hide();
                $map_color.children('option[value="bg-default"]').show();
                $map_color.children('option[value="bg-aqua"]').show();
                $map_color.children('option[value="bg-green"]').show();
                $map_color.children('option[value="bg-yellow"]').show();
                $map_color.children('option[value="bg-red"]').show();
                $map_dataset.val();
                $map_labels.val('');
                $map_labels.prop('required',false);
                if($('#map_labels > textarea[class="ace_text-input"]').val() == ""){
                    $map_editor.session.setValue(JSON.stringify(JSON.parse('{"Value": "NULL","ValueColor": ["NULL"], "ValueLabels": "NULL", "Label1": "NULL", "Label2": "NULL", "StatisticsPosition": "NULL", "mapWidth": "NULL", "mapHeight": "NULL", "DataType_number": "NULL"}'),null,2),1);
                    $map_editor.clearSelection();
                }
                $map_description_type.hide();
                $map_url_type.hide();
            } else {
                $map_description_type.hide();
                $map_color.children('option').hide();
                $map_labels.val('');
                $map_labels.prop('required',false);
                $map_description_type.hide();
                $map_url_type.hide();
            }
        });

        /**
         * Toggle From map Setting
         */
        $map_sub_type.on('change', function (e) {
            map_setting();
        });

        /**
         * Toggle From map Color
         */
        $map_color.on('change', function (e) {
            var color_type = $map_color.val();
            var starter = color_type.substr(0,color_type.indexOf('-'))+'-';
            if(starter != 'bg-') {
                var classes = $map_class.val();
                var box_default = checkColor($map_color.val(), starter, classes);
                var classAll;
                classes = $map_class.val();

                classAll = box_default + classes;
                $map_class.val('');
                $map_class.val(classAll);
            }
        });

        /////////////////////////////////////////

        function map_setting(){
            if($map_sub_type.val() == 'default') {
                $map_options_type.show();
                $map_dataset_type.hide();
                $map_tooltip_type.show();
                $map_popup_type.show();
                $map_custom_functions_type.show();
            } else if($map_sub_type.val() == 'cluster') {
                $map_options_type.show();
                $map_dataset_type.hide();
                $map_tooltip_type.show();
                $map_popup_type.show();
                $map_custom_functions_type.show();
            } else if($map_sub_type.val() == 'custom'){
                $map_options_type.hide();
                $map_dataset_type.show();
                $map_tooltip_type.hide();
                $map_popup_type.hide();
                $map_custom_functions_type.hide();
            } else {
                $map_options_type.hide();
                $map_dataset_type.hide();
                $map_tooltip_type.hide();
                $map_popup_type.hide();
                $map_custom_functions_type.hide();
            }
        }


        //////////////////////////////////////////

        /**
         * Delete map item
         */
        $('.item_actions_map').on('click', '.delete', function (e) {
            id = $(e.currentTarget).data('id');
            $('#delete_form')[0].action = '{{ route('projectpages.item.destroy', ['projectpage' => $projectpage->id, 'id' => '']) }}/' + id;
            $('#delete_modal').modal('show');
        });
    });
</script>
