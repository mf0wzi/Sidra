<script type="application/javascript">
    $(document).ready(function () {
        /**
         * Set chart Variables
         */
        var $chart_modal             = $('#chart_modal'),
            $chart_hd_add            = $('#chart_hd_add').hide().removeClass('hidden'),
            $chart_hd_edit           = $('#chart_hd_edit').hide().removeClass('hidden'),
            $chart_form              = $('#chart_form'),
            $chart_form_method       = $('#chart_form_method'),
            $chart_title             = $('#chart_title'),
            $chart_title_i18n        = $('#title_i18n'),
            $chart_container_type    = $('#chart_container_type'),
            $chart_sub_type          = $('#chart_sub_type'),
            $chart_class_type        = $('#chart_class_type'),
            $chart_class             = $('#chart_class'),
            $chart_color             = $('#chart_color'),
            $chart_icon_class        = $('#chart_icon_class'),
            $chart_labels            = $('#chart_labels'),
            $chart_editor            = ace.edit("chart_labels"),
            $chart_labels_textarea   = $('#chart_labels_textarea'),
            $chart_info              = $('#chart_info'),
            $chart_url_type          = $('#chart_url_type'),
            $chart_url               = $('#chart_url'),
            $chart_dataset           = $('#chart_dataset'),
            $chart_dataset_editor    = ace.edit("chart_dataset"),
            $chart_options           = $('#chart_options'),
            $chart_options_editor    = ace.edit("chart_options"),
            $chart_sql               = $('#chart_sql'),
            $chart_sql_editor        = ace.edit("chart_sql"),
            $chart_description_type  = $('#chart_description_type'),
            $chart_description       = $('#chart_description'),
            $chart_id                = $('#chart_id');


/////////////////////////////////////////////////////////////////////////////////

        /**
         *  Chart Add
         */
        $('.add_chart').click(function() {
            $chart_form.trigger('reset');
            $chart_form.find("input[type=submit]").val('{{ __('voyager::generic.add') }}');
            $chart_modal.modal('show', {data: null});
        });

        /**
         *  Chart Edit
         */
        $('.item_actions_chart').on('click', '.edit', function (e) {
            $chart_form.find("input[type=submit]").val('{{ __('voyager::generic.update') }}');
            $chart_modal.modal('show', {data: $(e.currentTarget)});
        });

/////////////////////////////////////////////////

        /**
         * Chart Modal is Open
         */
        $chart_modal.on('show.bs.modal', function(e, data) {
            var _adding      = e.relatedTarget.data ? false : true,
                translatable = $chart_modal.data('multilingual'),
                $_str_i18n   = '';

            if (_adding) {
                $chart_form.attr('action', $chart_form.data('action-add'));
                $chart_form_method.val('POST');
                $chart_hd_add.show();
                $chart_hd_edit.hide();
                $chart_container_type.val('type').change();
                $chart_sub_type.val('sub_type').change();

            } else {
                $chart_form.attr('action', $chart_form.data('action-update'));
                $chart_form_method.val('PUT');
                $chart_hd_add.hide();
                $chart_hd_edit.show();

                var _src = e.relatedTarget.data, // the source
                    id   = _src.data('id');

                $chart_title.val(_src.data('title'));
                $chart_container_type.val(_src.data('type'));
                $chart_sub_type.val(_src.data('sub_type'));
                $chart_icon_class.val(_src.data('icon_class'));
                $chart_class.val(_src.data('class'));
                $chart_editor.session.setValue(JSON.stringify(_src.data('labels'),null,2));
//$chart_dataset.val(JSON.stringify(_src.data('dataset'),null, 2));
                $chart_dataset_editor.session.setValue(_src.data('dataset'));
                $chart_options_editor.session.setValue(_src.data('options'));
                $chart_sql_editor.session.setValue(_src.data('sql'));
                $chart_url.val(_src.data('url'));
                tinymce.get("chart_description").setContent(_src.data('description'));
                $chart_id.val(id);

                var type;
                if(_src.data('type') == 'chart' || _src.data('type') == 'chart-statistics'){
                    type = getColor('box-',_src.data('class'));
                } else if(_src.data('type') == 'chart-in-box' || _src.data('type') == 'chart-in-box-statistics') {
                    type = getColor('bg-',_src.data('color'));
                }
                $chart_color.val(type);

                if(translatable){
                    $_str_i18n = $("#title" + id + "_i18n").val();
                }

                /**
                 *  Add the values of chart
                 */
                if (_src.data('type') == "chart" || _src.data('type') == "chart-statistics") {
                    $chart_container_type.find("option[value='']").removeAttr('selected');
                    $chart_container_type.find("option[value='"+_src.data('type')+"']").attr('selected', 'selected');
                    $chart_container_type.val(_src.data('type'));
                    $chart_container_type.val(_src.data('type')).change();
                    $chart_color.children('option').hide();
                    $chart_color.children('option[value="box-solid"]').show();
                    $chart_color.children('option[value="box-default"]').show();
                    $chart_color.children('option[value="box-primary"]').show();
                    $chart_color.children('option[value="box-success"]').show();
                    $chart_color.children('option[value="box-warning"]').show();
                    $chart_color.children('option[value="box-danger"]').show();
                } else if(_src.data('type') == "chart-in-box" || _src.data('type') == "chart-in-box-statistics") {
                    $chart_container_type.find("option[value='']").removeAttr('selected');
                    $chart_container_type.find("option[value='"+_src.data('type')+"']").attr('selected', 'selected');
                    $chart_container_type.val(_src.data('type'));
                    $chart_container_type.val(_src.data('type')).change();
                    $chart_color.children('option').hide();
                    $chart_color.children('option[value="bg-default"]').show();
                    $chart_color.children('option[value="bg-info"]').show();
                    $chart_color.children('option[value="bg-success"]').show();
                    $chart_color.children('option[value="bg-warning"]').show();
                    $chart_color.children('option[value="bg-danger"]').show();
                } else {
                    $chart_labels.prop('required',false);
                    $chart_url_type.hide();
                }

                if (_src.data('sub_type') == null){
                    $chart_labels.prop('required',false);
                    $chart_url_type.hide();
                } else {
                    $chart_sub_type.find("option[value='']").removeAttr('selected');
                    $chart_sub_type.find("option[value='"+_src.data('sub_type')+"']").attr('selected', 'selected');
                    $chart_sub_type.val(_src.data('sub_type'));
                    $chart_sub_type.val(_src.data('sub_type')).change();
                }

                if($chart_container_type.val() == 'chart') {
                    $chart_description_type.show();
                } else {
                    $chart_description_type.hide();
                }
            }

            if (translatable) {
                $chart_title_i18n.val($_str_i18n);
                translatable.refresh();
            }
        });

////////////////////////////////////////////////

        /**
         * Toggle From Chart Type
         */
        $chart_container_type.on('change', function (e) {
            if($chart_container_type.val() == 'chart') {
                $chart_description_type.show();
                $chart_color.children('option').hide();
                $chart_color.children('option[value="box-solid"]').show();
                $chart_color.children('option[value="box-default"]').show();
                $chart_color.children('option[value="box-primary"]').show();
                $chart_color.children('option[value="box-success"]').show();
                $chart_color.children('option[value="box-warning"]').show();
                $chart_color.children('option[value="box-danger"]').show();
                $chart_labels.val('');
                $chart_labels.prop('required',false);
                if($('#chart_labels > textarea[class="ace_text-input"]').val() == "" ){
                    $chart_editor.session.setValue(JSON.stringify(JSON.parse('{"Value": "NULL","ValueLabels": "NULL", "ChartWidth": "NULL", "ChartHeight": "NULL"}'),null,2),1);
                    $chart_editor.clearSelection();
//$widg_labels_textarea.val(JSON.stringify(JSON.parse('{"Value": "NULL","BeforeSymbol": "NULL","AfterSymbol": "NULL","FooterLabel": "More info","FooterIcon": "fa fa-arrow-circle-right","DataType_number": "NULL","DataColor": "NULL"}'),null,2));
                }
                $chart_url_type.hide();
            } else if($chart_container_type.val() == 'chart-statistics') {
                $chart_description_type.show();
                $chart_color.children('option').hide();
                $chart_color.children('option[value="box-solid"]').show();
                $chart_color.children('option[value="box-default"]').show();
                $chart_color.children('option[value="box-primary"]').show();
                $chart_color.children('option[value="box-success"]').show();
                $chart_color.children('option[value="box-warning"]').show();
                $chart_color.children('option[value="box-danger"]').show();
                $chart_labels.val('');
                $chart_labels.prop('required',false);
                if($('#chart_labels > textarea[class="ace_text-input"]').val() == ""){
                    $chart_editor.session.setValue(JSON.stringify(JSON.parse('{"Value": "NULL","ValueColor": ["NULL"], "ValueLabels": "NULL", "StatisticsPosition": "NULL", "ChartWidth": "NULL", "ChartHeight": "NULL", "DataType_number": "NULL"}'),null,2),1);
                    $chart_editor.clearSelection();
                }
                $chart_url_type.hide();
            } else if($chart_container_type.val() == 'chart-in-box') {
                $chart_description_type.hide();
                $chart_color.children('option').hide();
                $chart_color.children('option[value="bg-default"]').show();
                $chart_color.children('option[value="bg-aqua"]').show();
                $chart_color.children('option[value="bg-green"]').show();
                $chart_color.children('option[value="bg-yellow"]').show();
                $chart_color.children('option[value="bg-red"]').show();
                $chart_dataset.val();
                $chart_labels.val('');
                $chart_labels.prop('required',false);
                if($('#chart_labels > textarea[class="ace_text-input"]').val() == ""){
                    $chart_editor.session.setValue(JSON.stringify(JSON.parse('{"Value": "NULL","ValueColor": ["NULL"], "ValueLabels": "NULL", "Label1": "NULL", "Label2": "NULL", "StatisticsPosition": "NULL", "ChartWidth": "NULL", "ChartHeight": "NULL", "DataType_number": "NULL"}'),null,2),1);
                    $chart_editor.clearSelection();
                }
                $chart_url_type.hide();
            } else if($chart_container_type.val() == 'chart-in-box-statistics') {
                $chart_description_type.hide();
                $chart_color.children('option').hide();
                $chart_color.children('option[value="bg-default"]').show();
                $chart_color.children('option[value="bg-aqua"]').show();
                $chart_color.children('option[value="bg-green"]').show();
                $chart_color.children('option[value="bg-yellow"]').show();
                $chart_color.children('option[value="bg-red"]').show();
                $chart_dataset.val();
                $chart_labels.val('');
                $chart_labels.prop('required',false);
                if($('#chart_labels > textarea[class="ace_text-input"]').val() == ""){
                    $chart_editor.session.setValue(JSON.stringify(JSON.parse('{"Value": "NULL","ValueColor": ["NULL"], "ValueLabels": "NULL", "Label1": "NULL", "Label2": "NULL", "StatisticsPosition": "NULL", "ChartWidth": "NULL", "ChartHeight": "NULL", "DataType_number": "NULL"}'),null,2),1);
                    $chart_editor.clearSelection();
                }
                $chart_url_type.hide();
            } else {
                $chart_description_type.hide();
                $chart_color.children('option').hide();
                $chart_labels.val('');
                $chart_labels.prop('required',false);
                $chart_url_type.hide();
            }
        });

        /**
         * Toggle From Chart Color
         */
        $chart_color.on('change', function (e) {
            var color_type = $chart_color.val();
            var starter = color_type.substr(0,color_type.indexOf('-'))+'-';
            if(starter != 'bg-') {
                var classes = $chart_class.val();
                var box_default = checkColor($chart_color.val(), starter, classes);
                var classAll;
                classes = $chart_class.val();

                classAll = box_default + classes;
                $chart_class.val('');
                $chart_class.val(classAll);
            }
        });


//////////////////////////////////////////


        /**
         * Delete chart item
         */
        $('.item_actions_chart').on('click', '.delete', function (e) {
            id = $(e.currentTarget).data('id');
            $('#delete_form')[0].action = '{{ route('projectpages.item.destroy', ['projectpage' => $projectpage->id, 'id' => '']) }}/' + id;
            $('#delete_modal').modal('show');
        });
    });
</script>
