@extends('layouts.master.dashboard')

@section('page_title')

@endsection
@section('content')
    @parent
    {!! pageitem($pagename,'layouts.dashboard.template.views.view') !!}
@endsection
