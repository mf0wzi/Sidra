<ul class="treeview-menu">

    @php

        if (Voyager::translatable($items)) {
            $items = $items->load('translations');
        }

    @endphp

    @foreach ($items as $item)

        @php

            $originalItem = $item;
            if (Voyager::translatable($item)) {
                $item = $item->translate($options->locale);
            }

            $menuClass = null;
            $isActive = null;
            $styles = null;
            $icon = null;
            $listItemClass = null;
            $linkAttributes = null;

            // Background Color or Color
            if (isset($options->color) && $options->color == true) {
                $styles = 'color:'.$item->color;
            }
            if (isset($options->background) && $options->background == true) {
                $styles = 'background-color:'.$item->color;
            }


            // Check if link is current
            if(url($item->link()) == url()->current()){
                $isActive = ' active';
            }

            // With Children Attributes
            if(!$originalItem->children->isEmpty()) {
                $linkAttributes =  'nav-dropdown-toggle';
                //$caret = '<span class="caret"></span>';

                if(url($item->link()) == url()->current()){
                   $listItemClass = ' menu-open';
                   }else{
                   $listItemClass = ' ';
                   }
            }

            // Set Icon
            if(isset($options->icon) && $options->icon == true){
                $icon = '<i class="' . $item->icon_class . '"></i>';
            }

        $menuClass = $isActive;
        @endphp

        <li class="{{ $menuClass }}">
            <a href="{{ url($item->link()) }}" target="{{ $item->target }}" style="{{ $styles }}">
                {{--                {!! $icon !!}--}}
                <i class="{{$item->icon_class}}"></i> {{ $item->title }}
            </a>
            @if(!$originalItem->children->isEmpty())
                @include('layouts.dashboard.template.sidebar.submenu', ['items' => $originalItem->children, 'options' => $options])
            @endif
        </li>
    @endforeach

</ul>
