@extends('layouts.dashboard')
@section('page-script')

@stop
@section('page_heading_tree')
    <div class="navigation">
        <a href="{{ url('/subjects/') }}">{{ $subject->title }}</a>
    </div>
@stop
@section('page_heading',$topic->title)
@section('section')
    <div class="col-sm-12">
        {{ $topic->description }}<br /><br />
        {!! $topic->topic_content !!}
    </div>
@stop