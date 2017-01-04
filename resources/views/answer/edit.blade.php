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
        {!! $nav !!}
    </div>
@stop
@section('page_heading')
    Edit Answer
    @stop
@section('section')
    <!-- Edit Answer Form -->
    @if (isset($quiz_id))
        <form action="{{ url('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/quizzes/'.$quiz_id.'/questions/'.$question_id.'/answers/'.$answer->id.'/edit') }}" method="POST" class="form-horizontal">
    @else
        <form action="{{ url('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledgeunit_id.'/assignments/'.$assignment_id.'/questions/'.$question_id.'/answers/'.$answer->id.'/edit') }}" method="POST" class="form-horizontal">
    @endif
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