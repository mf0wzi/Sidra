@inject('GetData','App\Http\Controllers\DataController')
@php
    $array = array();
    $connections = null;
    $item = null;
@endphp
@foreach($items as $item)
    @if($item->type == 'tab')
        @php
            $array[] = $item->title;
        @endphp
    @endif
@endforeach

@if($item == null)
   {!! $GetData::abortCustom('NoItemFound','No Item Found, Please add an item to view it here') !!}
@elseif($item->type != null && $item->type == 'tab')
    @foreach($array as $key => $row)
        @if($key == 0)
            <ul id="navtabs" class="nav nav-tabs tab-brave">
                @endif
                <li @if($key == 0)class="active"@endif>
                    <a id="tab-{{ $row }}" data-toggle="tab" href="#{{ $row }}">{{ $row }}</a>
                </li>
                @if($row === end($array))
            </ul>
            <div class="tab-content">
                @endif
                @endforeach
                @endif

                @php
                    if(Voyager::translatable($items)) {
                        $items = $items->load('translations');
                    }
                @endphp

                @foreach($items->sortBy('order') as $key => $item)
                    {{--  --}}

                    @php
                        $originalItem = $item;
                        if(Voyager::translatable($item)) {
                            $item = $item->translate($options->locale);
                        }

                        $id = null;
                        $title = null;
                        $iconClass = null;
                        $class = null;
                        $template = null;
                        $menuClass = null;
                        $isActive = null;
                        $styles = null;
                        $icon = null;
                        $listItemClass = null;
                        $linkAttributes = null;

                        if($item->type == 'tab') {
                            $class = "tab-content";
                            $template = "container";
                        } else if($item->type == 'row') {
                            $id = $item->item_id;
                            $class = 'row';
                            $template = 'container';
                        } else if($item->type == 'col') {
                            $id = $item->item_id;
                            $class = 'col-lg-3';
                            $template = 'container';
                        }

                        // With Children Attributes
                        if(!$originalItem->children->isEmpty()) {
                            $linkAttributes =  'yes';
                            if(url($item->link()) == url()->current()) {
                               $listItemClass = ' menu-open';
                               } else {
                               $listItemClass = '';
                               }
                        }
                        // Set Icon
                        if(isset($options->icon) && $options->icon == true){
                            $icon = '<i class="' . $item->icon_class . '"></i>';
                        }
                    $mainClass = $class.$isActive.$listItemClass;
                    @endphp

                    @if($item->type == 'tab')
                        <div id="{{ $item->title }}" class="tab-pane fade {{ $key==0 ? 'active in' : ''}}">
                            @if(!$originalItem->children->isEmpty())
                                @include('layouts.dashboard.template.views.child', ['items' => $originalItem->children, 'options' => $options, 'connection_type' => $connection_type])
                            @endif
                        </div>
                    @else
                        <div id="{{ $id }}" class="{{ $mainClass }}">
                            @if(!$originalItem->children->isEmpty())
                                @include('layouts.dashboard.template.views.child', ['items' => $originalItem->children, 'options' => $options, 'connection_type' => $connection_type])
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
