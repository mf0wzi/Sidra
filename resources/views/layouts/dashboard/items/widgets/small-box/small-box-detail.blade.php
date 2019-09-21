<!-- small box detail-->
<div id="{{ $id }}" class="small-box {{ $class }}">
    <div class="inner">
        <h3 class="{{ $dcolor }}" id="appliedBrave">{{ $data1 }}<sub class="{{ $tcolor }}" style="font-size: 20px;@media  screen and (max-width: 450px){font-size: 15px;}">{{ $targetLabel }}</sub></h3>

        <p class="{{ $dcolor1 }}"><i class="{{ $icon1 }}"></i> {{ $label }} <b>{{ $per1 }}</b></p>
        <p class="{{ $dcolor2 }}"><i class="{{ $icon2 }}"></i> {{ $data2 }} <b>{{ $per2 }}</b></p>
        <p class="{{ $dcolor3 }}"><i class="{{ $icon3 }}"></i> {{ $data3 }} <b>{{ $per3 }}</b></p>
    </div>
    <div class="icon" id="testpopper" data-toggle="tooltip" title="Hooray!">
        <i class="{{ $titleIcon }}"></i>
    </div>
    <a href="@if($url != null){{ url($url) }}@else{{ $url }}@endif" class="small-box-footer">{{ $title }} <i class="{{ $ficon }}"></i></a>
</div>
