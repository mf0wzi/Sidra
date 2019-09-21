<!-- small box -->
<div class="small-box">
    <div class="inner">
        <h3>{{ $data }}</h3>
        <p>{{ $title }}</p>
    </div>
    <div id="error" class="icon" data-toggle="popovers" data-popover data-trigger="hover" data-container="body" data-placement="left" data-html="true" title="Error Message" data-content="<p>{{ $error }}</p>">
        <i class="fa fa-exclamation"></i>
    </div>
    <a href="#" class="small-box-footer" data-popover data-toggle="popovers" data-trigger="hover" title="Error Message" data-content="<p>{{ $error }}</p>">
        Couldn't load please check the error
    </a>
</div>
