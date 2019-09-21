<!-- Containers -->
<div class="modal modal-dark fade" tabindex="-1" id="container_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span
                        aria-hidden="true">&times;</span></button>
                <h4 id="con_hd_add" class="modal-title hidden"><i class="voyager-plus"></i> <i class="voyager-code"></i> {{ __('Create New Container') }}</h4>
                <h4 id="con_hd_edit" class="modal-title hidden"><i class="voyager-edit"></i> <i class="voyager-code"></i> {{ __('Edit Container Item') }}</h4>
            </div>
            <form action="" id="con_form" method="POST"
                  data-action-add="{{ route('projectpages.item.add', ['projectpage' => $projectpage->id]) }}"
                  data-action-update="{{ route('projectpages.item.update', ['projectpage' => $projectpage->id]) }}">

                <input id="con_form_method" type="hidden" name="_method" value="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    @include('voyager::multilingual.language-selector')
                    <label for="name">{{ __('Title of Container Item') }}</label> <i class="icon voyager-helm small text-danger"></i>
                    @include('voyager::multilingual.input-hidden', ['_field_name' => 'title', '_field_trans' => ''])
                    <input type="text" class="form-control" id="con_title" name="title" placeholder="{{ __('voyager::generic.title') }}" required="required"><br>
                    <label for="type">{{ __('Component Type') }}</label> <i class="icon voyager-helm small text-danger"></i>
                    <select id="con_container_type" class="form-control" name="type" required="required">
                        <option value="" selected="selected" disabled="disabled" hidden>{{ __('Select your Container') }}</option>
                        <option value="tab">{{ __('Tab') }}</option>
                        <option value="row">{{ __('Row') }}</option>
                        <option value="col">{{ __('Columns') }}</option>
                    </select><br>
                    <div id="con_col_type">
                        <label for="class">{{ __('col-xs-') }}</label> <i class="icon voyager-helm small text-danger"></i>
                        <input type="number" class="form-control" id="con_col_xs" name="col_xs" pattern="[1-9]{2}" min="1" max="12" placeholder="{{ __('Add a Number from 1 to 12') }}"><br>
                        <label for="class">{{ __('col-sm-') }}</label> <i class="icon voyager-helm small text-danger"></i>
                        <input type="number" class="form-control" id="con_col_sm" name="col_sm" pattern="[1-9]{2}" min="1" max="12" placeholder="{{ __('Add a Number from 1 to 12') }}"><br>
                        <label for="class">{{ __('col-md-') }}</label> <i class="icon voyager-helm small text-danger"></i>
                        <input type="number" class="form-control" id="con_col_md" name="col_md" pattern="[1-9]{2}" min="1" max="12" placeholder="{{ __('Add a Number from 1 to 12') }}"><br>
                        <label for="class">{{ __('col-lg-') }}</label> <i class="icon voyager-helm small text-danger"></i>
                        <input type="number" class="form-control" id="con_col_lg" name="col_lg" pattern="[1-9]{2}" min="1" max="12" placeholder="{{ __('Add a Number from 1 to 12') }}"><br>
                    </div>
                    <div id="con_class_type">
                        <label for="class">{{ __('Class') }}</label> <i class="icon voyager-helm small text-danger"></i>
                        <textarea rows="3" class="form-control" id="con_class" name="class" placeholder="{{ __('Add your Class Here') }}"></textarea><br>
                    </div>

                    <input type="hidden" name="projectpage_id" value="{{ $projectpage->id }}">
                    <input type="hidden" name="id" id="con_id" value="">
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success pull-right delete-confirm__" value="{{ __('voyager::generic.update') }}">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
