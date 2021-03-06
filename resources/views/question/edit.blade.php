@extends('layouts.dashboard')
@section('page-script')
    <script type="text/javascript">
        $( document ).ready(function() {
            var markupStr = $("#question-description").val();
            $('#question-description').summernote('code', markupStr);
        });
    </script>
@stop
@section('page_heading_tree')
    <div class="navigation">
        {!! $nav !!}
    </div>
@stop
@section('page_heading')
    Edit Question
    @stop
@section('section')
    <!-- Edit Question Form -->
    @if (isset($quiz_id))
        <form action="{{ url('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/quizzes/'.$quiz_id.'/questions/'.$question->id.'/edit') }}" method="POST" class="form-horizontal">
    @else
        <form action="{{ url('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledgeunit_id.'/assignments/'.$assignment_id.'/questions/'.$question->id.'/edit') }}" method="POST" class="form-horizontal">
    @endif
        {{ csrf_field() }}

        <div class="form-group">
            <label for="task-name" class="col-sm-2 control-label">Points</label>
            <div class="col-sm-6">
                <select name="point" id="question-point" class="form-control" style="width: 100px;">
                    <option value="1" @if($question->point == 1) selected @endif>1</option>
                    <option value="2" @if($question->point == 2) selected @endif>2</option>
                    <option value="3" @if($question->point == 3) selected @endif>3</option>
                    <option value="4" @if($question->point == 4) selected @endif>4</option>
                    <option value="5" @if($question->point == 5) selected @endif>5</option>
                </select>
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