@if(config('voyager.show_dev_tips'))
    <div class="container-fluid">
        <div class="alert alert-info">
            <strong>{{ __('voyager::generic.how_to_use') }}:</strong>
            <p>{{ trans_choice('You can output an item anywhere on your site by calling', !empty($menu) ? 0 : 1) }} <code>pageitem('{{ !empty($menu) ? $menu->name : 'name' }}')</code></p>
        </div>
    </div>
@endif