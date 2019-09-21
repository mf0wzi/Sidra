<script type="application/javascript">
    $(document).ready(function () {
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
                $widg_color.val(_src.data('color'));
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
                } else if(type == 'box' || type == 'table') {
                    type = getColor('box-',_src.data('class'));
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
                if (_src.data('type') == "box" || _src.data('type') == "callout" || _src.data('type') == "table") {
                    var $type;
                    if(_src.data('type') == "table"){
                        $type = 'box';
                    } else {
                        $type = _src.data('type');
                    }
                    $widg_container_type.find("option[value='']").removeAttr('selected');
                    $widg_container_type.find("option[value='"+_src.data('type')+"']").attr('selected', 'selected');
                    $widg_container_type.val(_src.data('type'));
                    $widg_container_type.val(_src.data('type')).change();

                    $widg_color.children('option').hide();
                    $widg_color.children('option[value="'+$type+'-solid"]').show();
                    $widg_color.children('option[value="'+$type+'-default"]').show();
                    $widg_color.children('option[value="'+$type+'-primary"]').show();
                    $widg_color.children('option[value="'+$type+'-success"]').show();
                    $widg_color.children('option[value="'+$type+'-warning"]').show();
                    $widg_color.children('option[value="'+$type+'-danger"]').show();
                    $widg_color.find("option[value='"+_src.data('color')+"']").attr('selected', 'selected');
                    $widg_color.val(_src.data('color'));
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
                    $widg_color.find("option[value='"+_src.data('color')+"']").attr('selected', 'selected');
                    $widg_color.val(_src.data('color'));
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
                //$widg_editor.setValue('');
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
                //$widg_editor.setValue('');
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
            } else if($widg_container_type.val() == 'table') {
                $widg_description_type.show();
                $widg_color.children('option').hide();
                $widg_color.children('option[value="box-solid"]').show();
                $widg_color.children('option[value="box-default"]').show();
                $widg_color.children('option[value="box-primary"]').show();
                $widg_color.children('option[value="box-success"]').show();
                $widg_color.children('option[value="box-warning"]').show();
                $widg_color.children('option[value="box-danger"]').show();
                $widg_labels_textarea.val('');
                $widg_labels.prop('required',false);
                if($('#widg_labels > textarea[class="ace_text-input"]').val() == "" ){
                    $widg_editor.session.setValue(JSON.stringify(JSON.parse('{"HeaderClass": "NULL","BodyClass": "NULL", "TableClass": "NULL", "Pagination": "NULL"}'),null,2),1);
                    $widg_editor.clearSelection();
//$widg_labels_textarea.val(JSON.stringify(JSON.parse('{"Value": "NULL","BeforeSymbol": "NULL","AfterSymbol": "NULL","FooterLabel": "More info","FooterIcon": "fa fa-arrow-circle-right","DataType_number": "NULL","DataColor": "NULL"}'),null,2));
                }
                $widg_url_type.hide();
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
         * Delete Widget item
         */
        $('.item_actions_widget').on('click', '.delete', function (e) {
            id = $(e.currentTarget).data('id');
            $('#delete_form')[0].action = '{{ route('projectpages.item.destroy', ['projectpage' => $projectpage->id, 'id' => '']) }}/' + id;
            $('#delete_modal').modal('show');
        });
    });
</script>
