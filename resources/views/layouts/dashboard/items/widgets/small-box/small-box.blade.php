<!-- small box -->
<div id="{{ $id }}" class="small-box {{ $class }}">
    <div class="inner">
        <h3 class="{{ $dcolor }}">{{ $bsymbol }}{{ $data }}<sup style="font-size: 25px;">{{ $asymbol }}</sup></h3>
        <p>{{ $title }}</p>
    </div>
    <div class="icon">
        <i class="{{ $icon }}"></i>
    </div>
    <a href="@if($url != null){{ url($url) }}@else{{ $url }}@endif" class="small-box-footer">
        {{ $flabel }} <i class="{{ $ficon }}"></i>
    </a>
</div>
