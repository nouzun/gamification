@extends('layouts.dashboard')
@section('page-script')
    <script type="text/javascript">
        $( document ).ready(function() {
            var markupStr = $("#question-content").val();
            $('#question-content').summernote('code', markupStr);
        });
    </script>
@stop
@section('page_heading_tree')
    <div class="navigation">
        <a href="{{ url('/subjects/') }}">{{ $subject->title }}</a>
        <span class="fa fa-chevron-right"></span>
        <a href="{{ url('/subjects/'.$subject->id.'/topics/') }}">{{ $topic->title }}</a>
        <span class="fa fa-chevron-right"></span>
        <a href="{{ url('/subjects/'.$subject->id.'/topics/'.$topic->id.'/knowledgeunits/') }}">{{ $knowledge_unit->title }}</a>
        <span class="fa fa-chevron-right"></span>
        <a href="{{ url('/subjects/'.$subject->id.'/topics/'.$topic->id.'/knowledgeunits/'.$knowledge_unit->id.'/questions/') }}">{{ $question->title }}</a>
    </div>
@stop
@section('page_heading')
    Edit Question
    @stop
@section('section')
    <!-- Edit Question Form -->
    <form action="{{ url('/subjects/'.$subject->id.'/topics/'.$topic->id.'/knowledgeunits/'.$knowledge_unit->id.'/questions/'.$question->id.'/edit') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- Question Title -->
        <div class="form-group">
            <label for="task-name" class="col-sm-2 control-label">Title</label>

            <div class="col-sm-6">
                <input type="text" name="title" id="question-title" class="form-control" value="{{ $question->title }}">
            </div>
        </div>

        <!-- Question Description -->
        <div class="form-group">
            <label for="task-name" class="col-sm-2 control-label">Description</label>

            <div class="col-sm-8">
                    <textarea name="description" id="question-description" rows="18" class="form-control">
                        {!! $question->description !!}
                    </textarea>
            </div>
        </div>

        <!-- Add Topic Button -->
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Update Question
                </button>
            </div>
        </div>
    </form>

@endsection