<ul class="sidebar-menu" data-widget="tree">
    <li class="header">MAIN NAVIGATION</li>
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
            $treeview = null;
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
                $isActive = 'active';
            }



            // With Children Attributes
            if(!$originalItem->children->isEmpty()) {
                $linkAttributes =  'yes';
                $treeview = 'treeview ';
                //$caret = '<span class="caret"></span>';

                /*if(url($item->link()) == url()->current()){
                   $isActive = 'active';
                   $listItemClass = ' menu-open';
                   }else{
                   $isActive = '';
                   $listItemClass = '';
                   }*/
                foreach($originalItem->children as $childrenItem){
                        if(url($childrenItem->link()) == url()->current()){
                           $isActive = 'active';
                           $listItemClass = ' menu-open';
                           break;
                        }else{
                            $isActive = '';
                            $listItemClass = '';
                        }
                }
            }

            // Set Icon
            if(isset($options->icon) && $options->icon == true){
                $icon = '<i class="' . $item->icon_class . '"></i>';
            }

        $menuClass = $treeview.$isActive.$listItemClass;
        @endphp

        <li class="{{ $menuClass }}">
            <a href="{{ url($item->link()) }}" target="{{ $item->target }}" style="{{ $styles }}">
                {{--                {!! $icon !!}--}}
                <i class="{{$item->icon_class}}"></i>
                <span>{{ $item->title }}</span>
                @if($linkAttributes == 'yes')
                    <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                </span>
                @endif
            </a>
            @if(!$originalItem->children->isEmpty())
                @include('layouts.dashboard.template.sidebar.submenu', ['items' => $originalItem->children, 'options' => $options])
            @endif
        </li>
    @endforeach

</ul>
