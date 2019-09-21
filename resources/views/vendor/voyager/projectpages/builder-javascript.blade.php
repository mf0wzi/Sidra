<script type="application/javascript">
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

        {{--/**--}}
        {{-- *  Include Container--}}
        {{-- */--}}

        {{--@include('vendor.voyager.projectpages.modal.container.container-javascript')--}}

        {{-- ////////////////////////////////////////////////////////////////////////////--}}

        {{--/**--}}
        {{-- *  Include Widget--}}
        {{-- */--}}

        {{--@include('vendor.voyager.projectpages.modal.widget.widget-javascript')--}}

        {{-- ////////////////////////////////////////////////////////////////////////////--}}

        {{--/**--}}
        {{-- *  Include Chart--}}
        {{-- */--}}

        {{--@include('vendor.voyager.projectpages.modal.chart.chart-javascript')--}}

        {{--////////////////////////////////////////////////////////////////////////////--}}

        {{--/**--}}
        {{-- *  Include Map--}}
        {{-- */--}}

        {{--@include('vendor.voyager.projectpages.modal.map.map-javascript')--}}

        {{--////////////////////////////////////////////////////////////////////////////--}}

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
</script>
