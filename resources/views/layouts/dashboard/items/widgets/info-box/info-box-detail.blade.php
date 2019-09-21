<!-- info-box-detail -->
<div id="{{ $id }}" class="info-box {{ $class }}" style="position: relative;">
    <span class="info-box-icon {{ $color }}" style="position: absolute;height: 100%;"><i class="{{ $icon }}"></i></span>

    <div class="info-box-content">
        <span class="info-box-text {{ $dcolor }}">{{ $title }}</span>
        <span class="info-box-number {{ $dcolor1 }}">{{ $data1 }}{{ $asymbol }}</span>
        <div style="padding-left: 30px;">
            <span class="info-box-text"><span class="{{ $dotcolor }}" style="font-size: 30px;">•</span> {{ $label1 }}</span>
            <span class="info-box-number">{{ $data2 }}{{ $asymbol1 }}</span>
            <span class="info-box-text"><span class="{{ $dotcolor }}" style="font-size: 30px;">•</span> {{ $label2 }}</span>
            <span class="info-box-number">{{ $data3 }}{{ $asymbol2 }}</span>
        </div>
    </div>
    <!-- /.info-box-content -->
</div>
<!-- /.info-box-detail -->
