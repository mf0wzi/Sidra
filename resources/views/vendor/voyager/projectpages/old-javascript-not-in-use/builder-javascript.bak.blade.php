<script>
    $(document).on('focusin', function(e) {
        if ($(e.target).closest(".mce-window, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
            e.stopImmediatePropagation();
        }
    });
    $(document).ready(function () {
        @if ($isModelTranslatable)
        /**
         * Multilingual setup for main page
         */
        $('.side-body').multilingual({
            "transInputs": '.dd-list input[data-i18n=true]'
        });

        /**
         * Multilingual for Add/Edit Menu
         */
        $('#menu_item_modal').multilingual({
            "form":          'form',
            "transInputs":   '#menu_item_modal input[data-i18n=true]',
            "langSelectors": '.language-selector input',
            "editing":       true
        });

        /**
         * Popover
         */
        $('[data-toggle="popovers"]').popover();
        @endif

        $('.dd').nestable({
            expandBtnHTML: '',
            collapseBtnHTML: ''
        });

        /**
         * Set Container Variables
         */
        var $con_modal           = $('#container_modal'),
            $con_hd_add          = $('#con_hd_add').hide().removeClass('hidden'),
            $con_hd_edit         = $('#con_hd_edit').hide().removeClass('hidden'),
            $con_form            = $('#con_form'),
            $con_form_method     = $('#con_form_method'),
            $con_title           = $('#con_title'),
            $con_title_i18n      = $('#title_i18n'),
            $con_col_type        = $('#con_col_type'),
            $con_col_lg          = $('#con_col_lg'),
            $con_col_md          = $('#con_col_md'),
            $con_col_sm          = $('#con_col_sm'),
            $con_col_xs          = $('#con_col_xs'),
            $con_class_type      = $('#con_class_type'),
            $con_class           = $('#con_class'),
            $con_container_type  = $('#con_container_type'),
            $con_id              = $('#con_id');

        /////////////////////////////////////////////////////////////////

        /**
         * Set Widget Variables
         */
        var $widg_modal             = $('#widget_modal'),
            $widg_hd_add            = $('#widg_hd_add').hide().removeClass('hidden'),
            $widg_hd_edit           = $('#widg_hd_edit').hide().removeClass('hidden'),
            $widg_form              = $('#widg_form'),
            $widg_form_method       = $('#widg_form_method'),
            $widg_title             = $('#widg_title'),
            $widg_title_i18n        = $('#title_i18n'),
            $widg_container_type    = $('#widg_container_type'),
            $widg_class_type        = $('#widg_class_type'),
            $widg_class             = $('#widg_class'),
            $widg_color             = $('#widg_color'),
            $widg_icon_class        = $('#widg_icon_class'),
            $widg_labels            = $('#widg_labels'),
            $widg_editor            = ace.edit("widg_labels"),
            $widg_labels_textarea   = $('#widg_labels_textarea'),
            $widg_info              = $('#widg_info'),
            $widg_url_type          = $('#widg_url_type'),
            $widg_url               = $('#widg_url'),
            $widg_sql_editor        = ace.edit("widg_sql"),
            $widg_sql               = $('#widg_sql_textarea'),
            $widg_description_type  = $('#widg_description_type'),
            $widg_description       = $('#widg_description'),
            $widg_id                = $('#widg_id');

        //////////////////////////////////////////////////////////////////////////

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
         * Set map Variables
         */
        var $map_modal             = $('#map_modal'),
            $map_hd_add            = $('#map_hd_add').hide().removeClass('hidden'),
            $map_hd_edit           = $('#map_hd_edit').hide().removeClass('hidden'),
            $map_form              = $('#map_form'),
            $map_form_method       = $('#map_form_method'),
            $map_title             = $('#map_title'),
            $map_title_i18n        = $('#title_i18n'),
            $map_container_type    = $('#map_container_type'),
            $map_sub_type          = $('#map_sub_type'),
            $map_class_type        = $('#map_class_type'),
            $map_class             = $('#map_class'),
            $map_color             = $('#map_color'),
            $map_icon_class        = $('#map_icon_class'),
            $map_labels            = $('#map_labels'),
            $map_editor            = ace.edit("map_labels"),
            $map_labels_textarea   = $('#map_labels_textarea'),
            $map_info              = $('#map_info'),
            $map_url_type          = $('#map_url_type'),
            $map_url               = $('#map_url'),
            $map_dataset           = $('#map_dataset'),
            $map_dataset_editor    = ace.edit("map_dataset"),
            $map_options           = $('#map_options'),
            $map_options_editor    = ace.edit("map_options"),
            $map_sql               = $('#map_sql'),
            $map_sql_editor        = ace.edit("map_sql"),
            $map_description_type  = $('#map_description_type'),
            $map_description       = $('#map_description'),
            $map_id                = $('#map_id');


        /////////////////////////////////////////////////////////////////////////////////

        /**
         *  Container Add
         */
        $('.add_container').click(function() {
            $con_form.trigger('reset');
            $con_form.find("input[type=submit]").val('{{ __('voyager::generic.add') }}');
            $con_modal.modal('show', {data: null});
        });

        /**
         *  Container Edit
         */
        $('.item_actions_container').on('click', '.edit', function (e) {
            $con_form.find("input[type=submit]").val('{{ __('voyager::generic.update') }}');
            $con_modal.modal('show', {data: $(e.currentTarget)});
        });

        //////////////////////////////////////////////

        /**
         *  Widget Add
         */
        $('.add_widget').click(function() {
            $widg_form.trigger('reset');
            $widg_form.find("input[type=submit]").val('{{ __('voyager::generic.add') }}');
            $widg_modal.modal('show', {data: null});
        });

        /**
         *  Widget Edit
         */
        $('.item_actions_widget').on('click', '.edit', function (e) {
            $widg_form.find("input[type=submit]").val('{{ __('voyager::generic.update') }}');
            $widg_modal.modal('show', {data: $(e.currentTarget)});
        });

        ////////////////////////////////////////////

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
         * Container Modal is Open
         */
        $con_modal.on('show.bs.modal', function(e, data) {
            var _adding      = e.relatedTarget.data ? false : true,
                translatable = $con_modal.data('multilingual'),
                $_str_i18n   = '';

            if (_adding) {
                $con_form.attr('action', $con_form.data('action-add'));
                $con_form_method.val('POST');
                $con_hd_add.show();
                $con_hd_edit.hide();
                $con_container_type.val('type').change();

            } else {
                $con_form.attr('action', $con_form.data('action-update'));
                $con_form_method.val('PUT');
                $con_hd_add.hide();
                $con_hd_edit.show();

                var _src = e.relatedTarget.data, // the source
                    id   = _src.data('id');

                $con_title.val(_src.data('title'));
                $con_col_lg.val(checkColumn('col-lg-',_src.data('class')));
                $con_col_md.val(checkColumn('col-md-',_src.data('class')));
                $con_col_sm.val(checkColumn('col-sm-',_src.data('class')));
                $con_col_xs.val(checkColumn('col-xs-',_src.data('class')));
                $con_class.val(_src.data('class'));
                $con_id.val(id);

                if(translatable){
                    $_str_i18n = $("#title" + id + "_i18n").val();
                }

                /**
                 *  Add the values of container
                 */

                $con_container_type.find("option[value='']").removeAttr('selected');
                $con_container_type.find("option[value='"+_src.data('type')+"']").attr('selected', 'selected');
                $con_container_type.val(_src.data('type'));
                $con_container_type.val(_src.data('type')).change();

                //////////////////////////////////////////////////////////////

                if($con_container_type.val() == 'tab' || $con_container_type.val() == 'row') {
                    $con_class_type.show();
                    $con_col_lg.val('');
                    $con_col_md.val('');
                    $con_col_sm.val('');
                    $con_col_xs.val('');
                    $con_class.val('');
                    $con_col_type.hide();
                } else if($con_container_type.val() == 'col') {
                    $con_class_type.show();
                    $con_col_type.show();
                } else {
                    $con_col_lg.val('');
                    $con_col_md.val('');
                    $con_col_sm.val('');
                    $con_col_xs.val('');
                    $con_class.val('');
                    $con_col_type.hide();
                }
            }

            if (translatable) {
                $con_title_i18n.val($_str_i18n);
                translatable.refresh();
            }
        });

        /////////////////////////////////////////////////

        /**
         * Widget Modal is Open
         */
        $widg_modal.on('show.bs.modal', function(e, data) {
            var _adding      = e.relatedTarget.data ? false : true,
                translatable = $widg_modal.data('multilingual'),
                $_str_i18n   = '';

            if (_adding) {
                $widg_form.attr('action', $widg_form.data('action-add'));
                $widg_form_method.val('POST');
                $widg_hd_add.show();
                $widg_hd_edit.hide();
                $widg_container_type.val('type').change();

            } else {
                $widg_form.attr('action', $widg_form.data('action-update'));
                $widg_form_method.val('PUT');
                $widg_hd_add.hide();
                $widg_hd_edit.show();

                var _src = e.relatedTarget.data, // the source
                    id   = _src.data('id');

                $widg_title.val(_src.data('title'));
                $widg_container_type.val(_src.data('type'));
                $widg_icon_class.val(_src.data('icon_class'));
                $widg_class.val(_src.data('class'));
                $widg_editor.session.setValue(JSON.stringify(_src.data('labels'),null,2));
                $widg_sql_editor.session.setValue(_src.data('sql'));
                $widg_url.val(_src.data('url'));
                tinymce.get("widg_description").setContent(_src.data('description'));
                $widg_id.val(id);

                var type = _src.data('type');
                if(type == 'small-box' ||
                    type == 'small-box-two' ||
                    type == 'small-box-detail' ||
                    type == 'info-box' ||
                    type == 'info-box-two' ||
                    type == 'info-box-detail' ||
                    type == 'widget-user'){
                    type = getColor('bg-',_src.data('class'));
                } else {
                    type = getColor(_src.data('type')+'-',_src.data('class'));
                }
                $widg_color.val(type);

                if(translatable){
                    $_str_i18n = $("#title" + id + "_i18n").val();
                }

                /**
                 *  Add the values of widget
                 */
                if (_src.data('type') == "box" || _src.data('type') == "callout") {
                    $widg_container_type.find("option[value='']").removeAttr('selected');
                    $widg_container_type.find("option[value='"+_src.data('type')+"']").attr('selected', 'selected');
                    $widg_container_type.val(_src.data('type'));
                    $widg_container_type.val(_src.data('type')).change();
                    $widg_color.children('option').hide();
                    $widg_color.children('option[value="'+_src.data('type')+'-solid"]').show();
                    $widg_color.children('option[value="'+_src.data('type')+'-default"]').show();
                    $widg_color.children('option[value="'+_src.data('type')+'-primary"]').show();
                    $widg_color.children('option[value="'+_src.data('type')+'-success"]').show();
                    $widg_color.children('option[value="'+_src.data('type')+'-warning"]').show();
                    $widg_color.children('option[value="'+_src.data('type')+'-danger"]').show();
                } else if(_src.data('type') == "small-box" ||
                    _src.data('type') == "small-box-two" ||
                    _src.data('type') == "small-box-detail" ||
                    _src.data('type') == "info-box" ||
                    _src.data('type') == "info-box-two" ||
                    _src.data('type') == "info-box-detail" ||
                    _src.data('type') == "widget-user") {
                    $widg_container_type.find("option[value='']").removeAttr('selected');
                    $widg_container_type.find("option[value='"+_src.data('type')+"']").attr('selected', 'selected');
                    $widg_container_type.val(_src.data('type'));
                    $widg_container_type.val(_src.data('type')).change();
                    $widg_color.children('option').hide();
                    $widg_color.children('option[value="bg-default"]').show();
                    $widg_color.children('option[value="bg-aqua"]').show();
                    $widg_color.children('option[value="bg-green"]').show();
                    $widg_color.children('option[value="bg-yellow"]').show();
                    $widg_color.children('option[value="bg-red"]').show();
                    $widg_labels.prop('required',true);
                    $widg_url_type.show();
                } else {
                    $widg_labels.prop('required',false);
                    $widg_url_type.hide();
                }

                if($widg_container_type.val() == 'box' || $widg_container_type.val() == 'callout') {
                    $widg_description_type.show();
                } else {
                    $widg_description_type.hide();
                }
            }

            if (translatable) {
                $widg_title_i18n.val($_str_i18n);
                translatable.refresh();
            }
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
                $chart_sub_type.val(_src.data('subtype'));
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

            } else {
                $map_form.attr('action', $map_form.data('action-update'));
                $map_form_method.val('PUT');
                $map_hd_add.hide();
                $map_hd_edit.show();

                var _src = e.relatedTarget.data, // the source
                    id   = _src.data('id');

                $map_title.val(_src.data('title'));
                $map_container_type.val(_src.data('type'));
                $map_sub_type.val(_src.data('subtype'));
                $map_icon_class.val(_src.data('icon_class'));
                $map_class.val(_src.data('class'));
                $map_editor.session.setValue(JSON.stringify(_src.data('labels'),null,2));
                //$map_dataset.val(JSON.stringify(_src.data('dataset'),null, 2));
                $map_dataset_editor.session.setValue(_src.data('dataset'));
                $map_options_editor.session.setValue(_src.data('options'));
                $map_sql_editor.session.setValue(_src.data('sql'));
                $map_url.val(_src.data('url'));
                tinymce.get("map_description").setContent(_src.data('description'));
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
                    $map_description_type.show();
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
         * Toggle From Container Type
         */
        $con_container_type.on('change', function (e) {
            if($con_container_type.val() == 'tab' || $con_container_type.val() == 'row') {
                $con_class_type.show();
                $con_col_lg.val('');
                $con_col_md.val('');
                $con_col_sm.val('');
                $con_col_xs.val('');
                $con_class.val('');
                $con_col_type.hide();
            } else if($con_container_type.val() == 'col') {
                $con_class_type.show();
                $con_col_type.show();
            } else {
                $con_col_lg.val('');
                $con_col_md.val('');
                $con_col_sm.val('');
                $con_col_xs.val('');
                $con_class.val('');
                $con_col_type.hide();
            }
        });

        /**
         * Toggle Columns size Type
         */
        $con_col_lg.on('input', function (e) {
            colSize($con_col_lg.val(),'col-lg-');
        });

        $con_col_md.on('input', function (e) {
            colSize($con_col_md.val(),'col-md-');
        });

        $con_col_sm.on('input', function (e) {
            colSize($con_col_sm.val(),'col-sm-');
        });

        $con_col_xs.on('input', function (e) {
            colSize($con_col_xs.val(),'col-xs-');
        });

        ///////////////////////////////////////////

        /**
         * Toggle From Widget Type
         */
        $widg_container_type.on('change', function (e) {
            if($widg_container_type.val() == 'box') {
                $widg_description_type.show();
                $widg_color.children('option').hide();
                $widg_color.children('option[value="box-solid"]').show();
                $widg_color.children('option[value="box-default"]').show();
                $widg_color.children('option[value="box-primary"]').show();
                $widg_color.children('option[value="box-success"]').show();
                $widg_color.children('option[value="box-warning"]').show();
                $widg_color.children('option[value="box-danger"]').show();
                $widg_editor.setValue('');
                $widg_labels_textarea.val('');
                $widg_labels.prop('required',false);
                if($('#widg_labels > textarea[class="ace_text-input"]').val() == "" ){
                    $widg_editor.session.setValue(JSON.stringify(JSON.parse('{"HeaderClass": "NULL","BodyClass": "NULL"}'),null,2),1);
                    $widg_editor.clearSelection();
                    //$widg_labels_textarea.val(JSON.stringify(JSON.parse('{"Value": "NULL","BeforeSymbol": "NULL","AfterSymbol": "NULL","FooterLabel": "More info","FooterIcon": "fa fa-arrow-circle-right","DataType_number": "NULL","DataColor": "NULL"}'),null,2));
                }
                $widg_url_type.hide();
            } else if($widg_container_type.val() == 'callout') {
                $widg_description_type.show();
                $widg_color.children('option').hide();
                $widg_color.children('option[value="callout-default"]').show();
                $widg_color.children('option[value="callout-info"]').show();
                $widg_color.children('option[value="callout-success"]').show();
                $widg_color.children('option[value="callout-warning"]').show();
                $widg_color.children('option[value="callout-danger"]').show();
                $widg_editor.setValue('');
                $widg_labels_textarea.val('');
                $widg_labels.prop('required',false);
                $widg_url_type.hide();
            } else if($widg_container_type.val() == 'small-box') {
                $widg_description_type.show();
                $widg_color.children('option').hide();
                $widg_color.children('option[value="bg-default"]').show();
                $widg_color.children('option[value="bg-aqua"]').show();
                $widg_color.children('option[value="bg-green"]').show();
                $widg_color.children('option[value="bg-yellow"]').show();
                $widg_color.children('option[value="bg-red"]').show();
                $widg_labels.prop('required',true);
                if($('#widg_labels > textarea[class="ace_text-input"]').val() == "" ){
                    $widg_editor.session.setValue(JSON.stringify(JSON.parse('{"Value": "NULL","BeforeSymbol": "NULL","AfterSymbol": "NULL","FooterLabel": "More info","FooterIcon": "fa fa-arrow-circle-right","DataType_number": "NULL","DataColor": "NULL"}'),null,2),1);
                    $widg_editor.clearSelection();
                    //$widg_labels_textarea.val(JSON.stringify(JSON.parse('{"Value": "NULL","BeforeSymbol": "NULL","AfterSymbol": "NULL","FooterLabel": "More info","FooterIcon": "fa fa-arrow-circle-right","DataType_number": "NULL","DataColor": "NULL"}'),null,2));
                }
                $widg_description_type.hide();
                $widg_url_type.show();
            } else if($widg_container_type.val() == 'small-box-two') {
                $widg_description_type.show();
                $widg_color.children('option').hide();
                $widg_color.children('option[value="bg-default"]').show();
                $widg_color.children('option[value="bg-aqua"]').show();
                $widg_color.children('option[value="bg-green"]').show();
                $widg_color.children('option[value="bg-yellow"]').show();
                $widg_color.children('option[value="bg-red"]').show();
                $widg_labels.prop('required',true);
                if($('#widg_labels > textarea[class="ace_text-input"]').val() == "" ) {
                    $widg_editor.session.setValue(JSON.stringify(JSON.parse('{"Value": "NULL","Value1": "NULL","Value2": "NULL",' +
                        '"BeforeSymbol": "NULL","BeforeSymbol1": "NULL","BeforeSymbol2": "NULL",' +
                        '"AfterSymbol": "NULL","AfterSymbol1": "NULL","AfterSymbol2": "NULL",' +
                        '"FirstLabel": "NULL","SecondLabel": "NULL","FooterIcon": "NULL",' +
                        '"DataType_number": "NULL","DataType1_number": "NULL","DataType2_number": "NULL",' +
                        '"DataColor": "NULL","DataColor1": "NULL","DataColor2": "NULL"}'),null,2));
                }
                $widg_description_type.hide();
                $widg_url_type.show();
            } else if($widg_container_type.val() == 'small-box-detail') {
                $widg_description_type.show();
                $widg_color.children('option').hide();
                $widg_color.children('option[value="bg-default"]').show();
                $widg_color.children('option[value="bg-aqua"]').show();
                $widg_color.children('option[value="bg-green"]').show();
                $widg_color.children('option[value="bg-yellow"]').show();
                $widg_color.children('option[value="bg-red"]').show();
                $widg_labels.prop('required',true);
                if($('#widg_labels > textarea[class="ace_text-input"]').val() == "" ) {
                    // console.log('here');
                    $widg_editor.session.setValue(JSON.stringify(JSON.parse('{"Value": "NULL","Value1": "NULL","Value2": "NULL",' +
                        '"Label": "NULL","Label1": "NULL","Label2": "NULL","TargetSize": "NULL","TargetName": "NULL","TargetColor": "NULL",' +
                        '"Icon1": "NULL","Icon2": "NULL","Icon3": "NULL","BeforeSymbol": "NULL","BeforeSymbol1": "NULL","BeforeSymbol2": "NULL",' +
                        '"AfterSymbol": "NULL","FooterIcon": "NULL","DataType_number": "NULL","DataType1_number": "NULL","DataType2_number": "NULL",' +
                        '"DataColor": "NULL","DataColor1": "NULL","DataColor2": "NULL","DataColor3": "NULL"}'),null,2));
                }
                $widg_description_type.hide();
                $widg_url_type.show();
            } else if($widg_container_type.val() == 'info-box') {
                $widg_description_type.show();
                $widg_color.children('option').hide();
                $widg_color.children('option[value="bg-default"]').show();
                $widg_color.children('option[value="bg-aqua"]').show();
                $widg_color.children('option[value="bg-green"]').show();
                $widg_color.children('option[value="bg-yellow"]').show();
                $widg_color.children('option[value="bg-red"]').show();
                $widg_labels.prop('required',true);
                if($('#widg_labels > textarea[class="ace_text-input"]').val() == "" ){
                    $widg_editor.session.setValue(JSON.stringify(JSON.parse('{"Value": "NULL","BeforeSymbol": "NULL","AfterSymbol": "NULL","DataType_number": "NULL","DataColor": "NULL","DataColor1": "NULL"}'),null,2));
                }
                $widg_description_type.hide();
                $widg_url_type.show();
            } else if($widg_container_type.val() == 'info-box-two') {
                $widg_description_type.show();
                $widg_color.children('option').hide();
                $widg_color.children('option[value="bg-default"]').show();
                $widg_color.children('option[value="bg-aqua"]').show();
                $widg_color.children('option[value="bg-green"]').show();
                $widg_color.children('option[value="bg-yellow"]').show();
                $widg_color.children('option[value="bg-red"]').show();
                $widg_labels.prop('required',true);
                if($('#widg_labels > textarea[class="ace_text-input"]').val() == "" ){
                    $widg_editor.session.setValue(JSON.stringify(JSON.parse('{"Value": "NULL","Value1": "NULL","Per": "NULL","BeforeSymbol": "NULL","AfterSymbol": "NULL","DataType_number": "NULL","DataType1_number": "NULL","DataColor": "NULL","DataColor1": "NULL"}'),null,2));
                }
                $widg_description_type.hide();
                $widg_url_type.show();
            } else if($widg_container_type.val() == 'info-box-detail') {
                $widg_description_type.show();
                $widg_color.children('option').hide();
                $widg_color.children('option[value="bg-default"]').show();
                $widg_color.children('option[value="bg-aqua"]').show();
                $widg_color.children('option[value="bg-green"]').show();
                $widg_color.children('option[value="bg-yellow"]').show();
                $widg_color.children('option[value="bg-red"]').show();
                $widg_labels.prop('required',true);
                if($('#widg_labels > textarea[class="ace_text-input"]').val() == "" ){
                    $widg_editor.session.setValue(JSON.stringify(JSON.parse('{"Value": "NULL","Value1": "NULL","Value2": "NULL","BeforeSymbol": "NULL","BeforeSymbol1": "NULL","BeforeSymbol2": "NULL","AfterSymbol": "NULL","AfterSymbol1": "NULL","AfterSymbol2": "NULL","Label1": "NULL","Label2": "NULL","DataType_number": "NULL","DataType1_number": "NULL","DataType2_number": "NULL","DataColor": "NULL","DataColor1": "NULL"}'),null,2));
                }
                $widg_description_type.hide();
                $widg_url_type.show();
            } else if($widg_container_type.val() == 'widget-user') {
                $widg_description_type.show();
                $widg_color.children('option').hide();
                $widg_color.children('option[value="bg-default"]').show();
                $widg_color.children('option[value="bg-aqua"]').show();
                $widg_color.children('option[value="bg-green"]').show();
                $widg_color.children('option[value="bg-yellow"]').show();
                $widg_color.children('option[value="bg-red"]').show();
                $widg_labels.prop('required',true);
                if($('#widg_labels > textarea[class="ace_text-input"]').val() == "" ){
                    $widg_editor.session.setValue(JSON.stringify(JSON.parse('{"Value": "NULL","Value1": "NULL","Value2": ["NULL"],"ValueColor": ["NULL"],"Label1": "NULL","Label2": ["NULL"],"DataType_number": "NULL","DataType1_number": "NULL","DataType2_number": ["NULL"]}'),null,2));
                }
                $widg_description_type.hide();
                $widg_url_type.show();
            } else {
                $widg_description_type.hide();
                $widg_color.children('option').hide();
                $widg_editor.setValue('');
                $widg_labels.prop('required',false);
                $widg_url_type.hide();
            }
        });

        /**
         * Toggle From Widget Color
         */
        $widg_color.on('change', function (e) {
            if($widg_container_type.val() != 'info-box' &&
                $widg_container_type.val() != 'info-box-detail' &&
                $widg_container_type.val() != 'widget-user'){
                var color_type = $widg_color.val();
                var starter = color_type.substr(0,color_type.indexOf('-'))+'-';

                var classes = $widg_class.val();
                var box_default = checkColor($widg_color.val(),starter,classes);
                var classAll;
                classes = $widg_class.val();

                classAll = box_default + classes;
                $widg_class.val('');
                $widg_class.val(classAll);

            }
        });

        //////////////////////////////////////////

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
                    $map_editor.session.setValue(JSON.stringify(JSON.parse('{"Value": "NULL","ValueLabels": "NULL", "mapWidth": "NULL", "mapHeight": "NULL"}'),null,2),1);
                    $map_editor.clearSelection();
                    //$widg_labels_textarea.val(JSON.stringify(JSON.parse('{"Value": "NULL","BeforeSymbol": "NULL","AfterSymbol": "NULL","FooterLabel": "More info","FooterIcon": "fa fa-arrow-circle-right","DataType_number": "NULL","DataColor": "NULL"}'),null,2));
                }
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
                $map_url_type.hide();
            } else {
                $map_description_type.hide();
                $map_color.children('option').hide();
                $map_labels.val('');
                $map_labels.prop('required',false);
                $map_url_type.hide();
            }
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


        //////////////////////////////////////////

        /**
         * Delete Container item
         */
        $('.item_actions_container').on('click', '.delete', function (e) {
            id = $(e.currentTarget).data('id');
            $('#delete_form')[0].action = '{{ route('projectpages.item.destroy', ['projectpage' => $projectpage->id, 'id' => '']) }}/' + id;
            $('#delete_modal').modal('show');
        });

        /**
         * Delete Widget item
         */
        $('.item_actions_widget').on('click', '.delete', function (e) {
            id = $(e.currentTarget).data('id');
            $('#delete_form')[0].action = '{{ route('projectpages.item.destroy', ['projectpage' => $projectpage->id, 'id' => '']) }}/' + id;
            $('#delete_modal').modal('show');
        });

        /**
         * Delete chart item
         */
        $('.item_actions_chart').on('click', '.delete', function (e) {
            id = $(e.currentTarget).data('id');
            $('#delete_form')[0].action = '{{ route('projectpages.item.destroy', ['projectpage' => $projectpage->id, 'id' => '']) }}/' + id;
            $('#delete_modal').modal('show');
        });

        /**
         * Delete map item
         */
        $('.item_actions_map').on('click', '.delete', function (e) {
            id = $(e.currentTarget).data('id');
            $('#delete_form')[0].action = '{{ route('projectpages.item.destroy', ['projectpage' => $projectpage->id, 'id' => '']) }}/' + id;
            $('#delete_modal').modal('show');
        });

        ////////////////////////////////////////////

        /**
         * Reorder items
         */
        $('.dd').on('change', function (e) {
            $.post('{{ route('projectpages.order',['projectpage' => $projectpage->id]) }}', {
                order: JSON.stringify($('.dd').nestable('serialize')),
                _token: '{{ csrf_token() }}'
            }, function (data) {
                toastr.success("{{ __('Successfully Updated Item Order') }}");
            });
        });

        //////////////////////////////////////////

        function colSize($con_col,$starter){
            var classes = $con_class.val();
            var col = checkData($con_col,$starter,classes);
            var classAll;
            classes = $con_class.val();

            classAll = col + classes;
            $con_class.val('');
            $con_class.val(classAll);
        }

        function checkData(value,type,classes) {

            var column,index,start,end,i,searchcolumn;
            if(isNaN(value)) {
                return "";
            } else if(!$.isNumeric(value)){
                return "";
            } else if(value === null){
                return "";
            } else if(classes.indexOf(type) >= 0) {

                column = type + value;
                index = classes.indexOf(type);

                if(index >= 0) {
                    start = index + 7;
                    end = classes.indexOf(' ',start);

                    if(end == -1){
                        end = start + 2;
                    }
                    i = classes.substring(start, end);

                    if($.isNumeric(i)){
                        searchcolumn = type + i;
                        if (classes.indexOf(searchcolumn) >= 0) {
                            $con_class.val(classes.replace(searchcolumn, column));
                        }
                    }
                    return "";
                }
            } else {
                column = type + value;
                return column+" ";

            }
        }

        function checkColumn(type,classes) {
            var index,start,end,i,result,searchcolumn;
            index = classes.indexOf(type);
            if(index >= 0) {
                start = index + 7;
                end = classes.indexOf(' ',start);
                if(end == -1){
                    end = start + 2;
                }
                i = classes.substring(start, end);
                if($.isNumeric(i)){
                    result = i;
                } else {
                    result = "";
                }
                return result;
            } else {
                return "";
            }
        }

        function checkColor(color,start,classes){
            var index,starts,end,searchcolor,result;
            index = classes.indexOf(start);
            if(index >= 0) {
                starts = index;
                end = classes.indexOf(' ',starts);
                if(end == -1){
                    end = classes.length;
                }
                searchcolor = classes.substring(starts, end);
                if (classes.indexOf(searchcolor) >= 0) {
                    $widg_class.val(classes.replace(searchcolor, color));
                }
                return "";
            } else {
                return color + " ";
            }
        }

        function getColor(start, classes){
            var index,starts,end,searchcolor,result;
            index = classes.indexOf(start);
            if(index >= 0) {
                starts = index;
                end = classes.indexOf(' ',starts);
                if(end == -1){
                    end = classes.length;
                }
                searchcolor = classes.substring(starts, end);
                return searchcolor;
            }
        }
    });
</script>
