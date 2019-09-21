<!-- small box -->
<div id="{{ $id }}" class="small-box {{ $class }}">
    <div class="inner">
        <h3 class="{{ $dcolor }}">{{ $bsymbol }}{{ $data1 }}<sup style="font-size: 25px;">{{ $asymbol }}</sup></h3>
        <span class="{{ $dcolor1 }}">{{ $data2 }} {{ $flabel }}</span> <span class="{{ $dcolor2 }}">{{ $data3 }} {{ $slabel }}</span>
    </div>
    <div class="icon">
        <i class="{{ $icon }}"></i>
    </div>
    <a href="@if($url != null){{ url($url) }}@else{{ $url }}@endif" class="small-box-footer">
        {{ $title }} <i class="{{ $ficon }}"></i>
    </a>
</div>
