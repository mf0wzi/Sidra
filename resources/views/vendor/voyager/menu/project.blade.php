<ol class="dd-lists">

    @foreach ($items->sortBy('order') as $item)
        @php
            if($item->type == 'tab' || $item->type == 'row' || $item->type == 'col')
            {$item_action = "item_actions_container";}
            else if($item->type == 'box' ||
             $item->type == 'callout' ||
             $item->type == 'small-box' ||
             $item->type == 'small-box-two' ||
             $item->type == 'small-box-detail' ||
             $item->type == 'info-box' ||
             $item->type == 'info-box-two' ||
             $item->type == 'info-box-detail' ||
             $item->type == 'widget-user' ||
             $item->type == 'table')
            {$item_action = "item_actions_widget";}
            else if($item->type == 'chart' ||
              $item->type == 'chart-statistics' ||
              $item->type == 'chart-in-box' ||
              $item->type == 'chart-in-box-statistics')
            {$item_action = "item_actions_chart";}
            else if($item->type == 'map' ||
              $item->type == 'map-statistics' ||
              $item->type == 'map-in-box' ||
              $item->type == 'map-in-box-statistics')
            {$item_action = "item_actions_map";}
        @endphp
        @if($item_action == "item_actions_container")

            <li class="dd-item" data-id="{{ $item->id }}">
                <div class="pull-right {{ $item_action }}">
                    <div class="btn btn-sm btn-danger pull-right delete" data-id="{{ $item->id }}">
                        <i class="voyager-trash"></i> <span class="hidden-sm hidden-xs">{{ __('voyager::generic.delete') }}</span>
                    </div>
                    <div class="btn btn-sm btn-primary pull-right edit"
                         data-id="{{ $item->id }}"
                         data-uuid="{{ $item->item_id }}"
                         data-title="{{ $item->title }}"
                         data-type="{{ $item->type }}"
                         data-class="{{ $item->class }}"
                    >
                        <i class="voyager-edit"></i> <span class="hidden-sm hidden-xs">{{ __('voyager::generic.edit') }}</span>
                    </div>
                </div>
                <div class="dd-handle border border-dark">
                    @if($options->isModelTranslatable)
                        @include('voyager::multilingual.input-hidden', [
                            'isModelTranslatable' => true,
                            '_field_name'         => 'title'.$item->id,
                            '_field_trans'        => json_encode($item->getTranslationsOf('title'))
                        ])
                    @endif
                    <div class="text-truncate" style="display: inline-block;max-width: 55%;"><i class="voyager-code"></i> <span>{{ $item->title }}</span> <small class="url">Type ({{ $item->type }})</small><small class="url">Class ({{ $item->class }})</small></div>
                </div>
                @if(!$item->children->isEmpty())
                    @include('vendor.voyager.menu.project', ['items' => $item->children])
                @endif
            </li>

        @elseif($item_action == "item_actions_widget")

            <li class="dd-item" data-id="{{ $item->id }}">
                <div class="pull-right {{ $item_action }}">
                    <div class="btn btn-sm btn-danger pull-right delete" data-id="{{ $item->id }}">
                        <i class="voyager-trash"></i> <span class="hidden-sm hidden-xs">{{ __('voyager::generic.delete') }}</span>
                    </div>
                    <div class="btn btn-sm btn-primary pull-right edit"
                         data-id="{{ $item->id }}"
                         data-uuid="{{ $item->item_id }}"
                         data-title="{{ $item->title }}"
                         data-type="{{ $item->type }}"
                         data-icon_class="{{ $item->icon_class }}"
                         data-color="{{ $item->color }}"
                         data-class="{{ $item->class }}"
                         data-labels="{{ $item->labels }}"
                         data-sql="{{ $item->sql }}"
                         data-url="{{ $item->url }}"
                         data-description="{{ $item->description }}"
                         data-target="{{ $item->target }}"
                    >
                        <i class="voyager-edit"></i> <span class="hidden-sm hidden-xs">{{ __('voyager::generic.edit') }}</span>
                    </div>
                </div>
                <div class="dd-handle border border-warning">
                    @if($options->isModelTranslatable)
                        @include('voyager::multilingual.input-hidden', [
                            'isModelTranslatable' => true,
                            '_field_name'         => 'title'.$item->id,
                            '_field_trans'        => json_encode($item->getTranslationsOf('title'))
                        ])
                    @endif
                    <div class="text-truncate" style="display: inline-block;max-width: 55%;"><i class="voyager-categories"></i> <span>{{ $item->title }}</span> <small class="url">Type ({{ $item->type }})</small><small class="url">Class ({{ $item->class }})</small></div>
                </div>
                @if(!$item->children->isEmpty())
                    @include('vendor.voyager.menu.project', ['items' => $item->children])
                @endif
            </li>

        @elseif($item_action == "item_actions_chart")

            <li class="dd-item" data-id="{{ $item->id }}">
                <div class="pull-right {{ $item_action }}">
                    <div class="btn btn-sm btn-danger pull-right delete" data-id="{{ $item->id }}">
                        <i class="voyager-trash"></i> <span class="hidden-sm hidden-xs">{{ __('voyager::generic.delete') }}</span>
                    </div>
                    <div class="btn btn-sm btn-primary pull-right edit"
                         data-id="{{ $item->id }}"
                         data-uuid="{{ $item->item_id }}"
                         data-title="{{ $item->title }}"
                         data-type="{{ $item->type }}"
                         data-subtype="{{ $item->sub_type }}"
                         data-icon_class="{{ $item->icon_class }}"
                         data-class="{{ $item->class }}"
                         data-color="{{ $item->color }}"
                         data-labels="{{ $item->labels }}"
                         data-dataset="{{ $item->dataset }}"
                         data-options="{{ $item->options }}"
                         data-sql="{{ $item->sql }}"
                         data-url="{{ $item->url }}"
                         data-description="{{ $item->description }}"
                         data-target="{{ $item->target }}"
                    >
                        <i class="voyager-edit"></i> <span class="hidden-sm hidden-xs">{{ __('voyager::generic.edit') }}</span>
                    </div>
                </div>
                <div class="dd-handle border border-primary">
                    @if($options->isModelTranslatable)
                        @include('voyager::multilingual.input-hidden', [
                            'isModelTranslatable' => true,
                            '_field_name'         => 'title'.$item->id,
                            '_field_trans'        => json_encode($item->getTranslationsOf('title'))
                        ])
                    @endif
                    <div class="text-truncate" style="display: inline-block;max-width: 55%;"><i class="voyager-bar-chart"></i> <span>{{ $item->title }}</span> <small class="url">Type ({{ $item->type }})</small> <small class="url">Sub Type ({{ $item->sub_type }})</small><small class="url">Class ({{ $item->class }})</small></div>
                </div>
                @if(!$item->children->isEmpty())
                    @include('vendor.voyager.menu.project', ['items' => $item->children])
                @endif
            </li>

        @elseif($item_action == "item_actions_map")

            <li class="dd-item" data-id="{{ $item->id }}">
                <div class="pull-right {{ $item_action }}">
                    <div class="btn btn-sm btn-danger pull-right delete" data-id="{{ $item->id }}">
                        <i class="voyager-trash"></i> <span class="hidden-sm hidden-xs">{{ __('voyager::generic.delete') }}</span>
                    </div>
                    <div class="btn btn-sm btn-primary pull-right edit"
                         data-id="{{ $item->id }}"
                         data-uuid="{{ $item->item_id }}"
                         data-title="{{ $item->title }}"
                         data-type="{{ $item->type }}"
                         data-tile="{{ $item->tile }}"
                         data-subtype="{{ $item->sub_type }}"
                         data-icon_class="{{ $item->icon_class }}"
                         data-class="{{ $item->class }}"
                         data-color="{{ $item->color }}"
                         data-labels="{{ $item->labels }}"
                         data-dataset="{{ $item->dataset }}"
                         data-options="{{ $item->options }}"
                         data-marker="{{ $item->marker }}"
                         data-tooltip="{{ $item->tooltip }}"
                         data-popup="{{ $item->popup }}"
                         data-custom_function="{{ $item->custom_function }}"
                         data-sql="{{ $item->sql }}"
{{--                         data-url="{{ $item->url }}"--}}
{{--                         data-description="{{ $item->description }}"--}}
{{--                         data-target="{{ $item->target }}"--}}
                    >
                        <i class="voyager-edit"></i> <span class="hidden-sm hidden-xs">{{ __('voyager::generic.edit') }}</span>
                    </div>
                </div>
                <div class="dd-handle border border-danger">
                    @if($options->isModelTranslatable)
                        @include('voyager::multilingual.input-hidden', [
                            'isModelTranslatable' => true,
                            '_field_name'         => 'title'.$item->id,
                            '_field_trans'        => json_encode($item->getTranslationsOf('title'))
                        ])
                    @endif
                    <div class="text-truncate" style="display: inline-block;max-width: 55%;"><i class="voyager-ship"></i><span> {{ $item->title }}</span> <small class="url">Type ({{ $item->type }})</small> <small class="url">Sub Type ({{ $item->sub_type }})</small><small class="url">Class ({{ $item->class }})</small></div>
                </div>
                @if(!$item->children->isEmpty())
                    @include('vendor.voyager.menu.project', ['items' => $item->children])
                @endif
            </li>

        @endif

    @endforeach

</ol>
