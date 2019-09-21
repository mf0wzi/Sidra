@inject('GetData','App\Http\Controllers\DataController')

@php
    if (Voyager::translatable($items)) {
        $items = $items->load('translations');
    }
    $connections = null;
@endphp

@foreach ($connection_type as $connection)
    @php
        $connections = $connection;
    @endphp
@endforeach

@foreach ($items->sortBy('order') as $item)

    @php
        if($connections == 'all'){
              $connections = 'all';
        } else if($connections == 'database1'){
              $connections = 'mysql';
        } else if($connections == 'database2'){
              $connections = 'mysql2';
        } else if($connections == 'database3'){
            $connections = 'mysql3';
        }

        $originalItem = $item;

        if (Voyager::translatable($item)) {
            $item = $item->translate($options->locale);
        }

        $id = null;
        $title = null;
        $template = null;
        $tile = null;
        $sub_type = null;
        $iconClass = null;
        $mainClass = null;
        $class = null;
        $color = null;
        $labels = null;
        $dataset = null;
        $chart_options = null;
        $map_options = null;
        $marker = null;
        $tooltip = null;
        $popup = null;
        $map_functions = null;
        $sql = null;
        $url = null;
        $description = null;
        $arguments = array();
        $id = $item->item_id;
        $title = $item->title;
        $template = $item->type;

        if ($template == 'row') {
            $class = $item->type.' '.$item->class;
        } else if ($template == 'col') {
            $class = $item->class;
        } else if($template == 'map') {
            $arguments = ['item_id' => $id,
            'title' => $title,
            'template' => $template,
            'tile' => $item->tile,
            'sub_type' => $item->sub_type,
            'connection_type' => $connections,
            'labels' => $item->labels,
            'dataset' => $item->dataset,
            'map_options' => $item->options,
            'marker' => $item->marker,
            'tooltip' => $item->tooltip,
            'popup' => $item->popup,
            'map_functions' => $item->map_functions,
            'sql' => $item->sql,
            'class' => $item->class,
            'iconClass' => $item->icon_class,
            'color' => $item->color,
            'description' => $item->description,
            'url' => $item->url];
            //dd($arguments);
        } else {
            $arguments = ['item_id' => $id,
            'title' => $title,
            'template' => $template,
            'sub_type' => $item->sub_type,
            'connection_type' => $connections,
            'labels' => $item->labels,
            'dataset' => $item->dataset,
            'chart_options' => $item->options,
            'sql' => $item->sql,
            'class' => $item->class,
            'iconClass' => $item->icon_class,
            'color' => $item->color,
            'description' => $item->description,
            'url' => $item->url];
        }

        // Background Color or Color
        if (isset($options->color) && $options->color == true) {
            $styles = 'color:'.$item->color;
        }
        if (isset($options->background) && $options->background == true) {
            $styles = 'background-color:'.$item->color;
        }

        // With Children Attributes
        if(!$originalItem->children->isEmpty()) {
            $linkAttributes =  'yes';
        }
    $mainClass = $class;
    @endphp

    @if($template == 'row' || $template == 'col')
        <div id="{{ $id }}" class="{{ $mainClass }}">
            @if(!$originalItem->children->isEmpty())
                @include('layouts.dashboard.template.views.child', ['items' => $originalItem->children, 'options' => $options, 'connection_type' => $connection_type])
            @endif
        </div>
    @else
        {!! $GetData::getData($arguments) !!}
    @endif
@endforeach

@if($item->type == 'tab')
    @foreach($array as $key => $row)
        @if($key == 0)
            <ul id="navtabs" class="nav nav-tabs">
        @endif
                <li>
                    <a id="tab-{{ $row }}" data-toggle="tab" href="#{{ $row }}">{{ $row }}</a>
                </li>
        @if($row === end($array))
            </ul>
            <div class="tab-content">
        @endif
    @endforeach
            </div>
@endif
