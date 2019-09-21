<div id="{{ $id }}" class="info-box {{ $class }}" style="position: relative;">
    <span class="info-box-icon" style="position: absolute;height: 100%;"><i class="{{ $icon }}"></i></span>

    <div class="info-box-content">
        <span class="info-box-text">{{ $title }}</span>
        <span class="info-box-number {{ $dcolor }}">{{ $bsymbol }}{{ $data }}{{ $asymbol }}</span>

        <div class="progress">
            <div class="progress-bar" style="width: {{ $per }}%"></div>
        </div>
        <span class="progress-description {{ $dcolor1 }}">
            <b>{{ $labels }}</b>
                  </span>
    </div>
    <!-- /.info-box-content -->
</div>
<!-- /.info-box -->
