<ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('home') }}">Dashboard</a></li>
    <li><a href="{{ url($url) }}">{{ ucfirst($project_name) }}</a></li>
    <li class="active">{{ ucfirst($page_name) }}</li>
</ol>