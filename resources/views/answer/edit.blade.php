@extends('layouts.dashboard')
@section('page-script')
    <script type="text/javascript">
        $( document ).ready(function() {
            var markupStr = $("#answer-description").val();
            $('#answer-description').summernote('code', markupStr);
        });
    </script>
@stop
@section('page_heading_tree')
    <div class="navigation">
        <a href="{{ url('/lectures/') }}">{{ $lecture->title }}</a>
        <span class="fa fa-chevron-right"></span>
        <a href="{{ url('/lectures/'.$lecture->id.'/subjects/') }}">{{ $subject->title }}</a>
        <span class="fa fa-chevron-right"></span>
        <a href="{{ url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/topics/') }}">{{ $topic->title }}</a>
        <span class="fa fa-chevron-right"></span>
        <a href="{{ url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/topics/'.$topic->id.'/knowledgeunits/') }}">{{ $knowledge_unit->title }}</a>
        <span class="fa fa-chevron-right"></span>
        <a href="{{ url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/topics/'.$topic->id.'/knowledgeunits/'.$knowledge_unit->id.'/questions/') }}">{{ $question->title }}</a>
        <!--
        <span class="fa fa-chevron-right"></span>
        <a href="{{ url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/topics/'.$topic->id.'/knowledgeunits/'.$knowledge_unit->id.'/questions/'.$question->id.'/answers') }}">{{ $answer->id }}</a>
        -->
    </div>
@stop
@section('page_heading')
    Edit Answer
    @stop
@section('section')
    <!-- Edit Answer Form -->
    <form action="{{ url('/lecture/'.$lecture->id.'/subjects/'.$subject->id.'/topics/'.$topic->id.'/knowledgeunits/'.$knowledge_unit->id.'/questions/'.$question->id.'/answers/'.$answer->id.'/edit') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- Answer Description -->
        <div class="form-group">
            <label for="task-name" class="col-sm-2 control-label">Description</label>

            <div class="col-sm-8">
                    <textarea name="description" id="answer-description" rows="18" class="form-control">
                        {!! $answer->description !!}
                    </textarea>
            </div>
        </div>

        <!-- Answer Correct -->
        <div class="form-group">
            <label for="task-name" class="col-sm-2 control-label">Correct?</label>

            <div class="col-sm-1">
                <input type="checkbox" name="correct" id="answer-correct" class="form-control" value="1" @if($answer->correct) checked="checked" @endif>
            </div>
        </div>

        <!-- Update Answer Button -->
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Update Answer
                </button>
            </div>
        </div>
    </form>

@endsection