@extends('layouts.dashboard')
@section('page-script')
@stop
@section('page_heading_tree')
    <div class="navigation">
        <a href="{{ url('/subjects/') }}">{{ $subject->title }}</a>
        <span class="fa fa-chevron-right"></span>
        <a href="{{ url('/subjects/'.$subject->id.'/topics/') }}">{{ $topic->title }}</a>
        <span class="fa fa-chevron-right"></span>
        <a href="{{ url('/subjects/'.$subject->id.'/topics/'.$topic->id.'/knowledgeunits/') }}">{{ $knowledge_unit->title }}</a>
    </div>
@stop
@section('page_heading')
    Edit Knowledge Unit
@stop
@section('section')
    <!-- Edit Knowledge Unit Form -->
    <form action="{{ url('/subjects/'.$subject->id.'/topics/'.$topic->id.'/knowledgeunits/'.$knowledge_unit->id.'/edit') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- Knowledge Unit Title -->
        <div class="form-group">
            <label for="task-name" class="col-sm-2 control-label">Title</label>

            <div class="col-sm-6">
                <input type="text" name="title" id="knowledgeunit-title" class="form-control" value="{{ $knowledge_unit->title }}">
            </div>
        </div>

        <!-- Knowledge Unit Description -->
        <div class="form-group">
            <label for="task-name" class="col-sm-2 control-label">Description</label>

            <div class="col-sm-6">
                <input type="text" name="description" id="knowledgeunit-description" class="form-control" value="{{ $knowledge_unit->description }}">
            </div>
        </div>

        <!-- Update Knowledge Unit Button -->
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Update Knowledge Unit
                </button>
            </div>
        </div>
    </form>
@endsection