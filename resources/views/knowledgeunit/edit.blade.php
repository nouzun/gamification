@extends('layouts.dashboard')
@section('page-script')
@stop
@section('page_heading_tree')
    <div class="navigation">
        {!! $nav !!}
    </div>
@stop
@section('page_heading')
    Edit Knowledge Unit
@stop
@section('section')
    <!-- Edit Knowledge Unit Form -->
    <form action="{{ url('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledge_unit->id.'/edit') }}" method="POST" class="form-horizontal">
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

        <div class="form-group">
            <label for="task-name" class="col-sm-2 control-label">Difficulty Level</label>

            <div class="col-sm-6">
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-primary @if ($knowledge_unit->difficulty_level == 1) active @endif">
                        <input name="difficulty_level" id="knowledgeunit-difficulty_level_easy" type="radio" value="1" @if ($knowledge_unit->difficulty_level == 1) checked="checked" @endif>Easy
                    </label>
                    <label class="btn btn-primary @if ($knowledge_unit->difficulty_level == 2) active @endif">
                        <input name="difficulty_level" id="knowledgeunit-difficulty_level_medium" type="radio" value="2" @if ($knowledge_unit->difficulty_level == 2) checked="checked" @endif>Medium
                    </label>
                    <label class="btn btn-primary @if ($knowledge_unit->difficulty_level == 3) active @endif">
                        <input name="difficulty_level" id="knowledgeunit-difficulty_level_hard" type="radio" value="3" @if ($knowledge_unit->difficulty_level == 3) checked="checked" @endif>Hard
                    </label>
                </div>
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