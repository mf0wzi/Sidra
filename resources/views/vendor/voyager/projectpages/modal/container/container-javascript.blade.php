<script type="application/javascript">
    let $con_modal,$con_hd_add,$con_hd_edit,$con_form,$con_form_method,$con_title,$con_title_i18n,$con_col_type,
        $con_col_lg,$con_col_md,$con_col_sm,$con_col_xs,$con_class_type,$con_class,$con_container_type,$con_id;
    $(document).ready(function () {
        /**
         * Set Container Variables
         */
            $con_modal           = $('#container_modal'),
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

//////////////////////////////////////////////////////////////////

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
         * Delete Container item
         */
        $('.item_actions_container').on('click', '.delete', function (e) {
            id = $(e.currentTarget).data('id');
            $('#delete_form')[0].action = '{{ route('projectpages.item.destroy', ['projectpage' => $projectpage->id, 'id' => '']) }}/' + id;
            $('#delete_modal').modal('show');
        });
    });
</script>
