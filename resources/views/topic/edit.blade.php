@extends('layouts.dashboard')
@section('page-script')
    <script type="text/javascript">
        $( document ).ready(function() {
            var markupStr = $("#topic-content").val();
            $('#topic-content').summernote('code', markupStr);
        });
    </script>
@stop
@section('page_heading_tree')
    <div class="navigation">
        <a href="{{ url('/subjects/') }}">{{ $subject->title }}</a>
    </div>
@stop
@section('page_heading')
    Edit Topic
    @stop
@section('section')
    <!-- Edit Topic Form -->
    <form action="{{ url('/subjects/'.$subject->id.'/topics/'.$topic->id.'/edit') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

                <!-- Topic Title -->
        <div class="form-group">
            <label for="task-name" class="col-sm-2 control-label">Title</label>

            <div class="col-sm-6">
                <input type="text" name="title" id="topic-title" class="form-control" value="{{ $topic->title }}">
            </div>
        </div>

        <!-- Topic Description -->
        <div class="form-group">
            <label for="task-name" class="col-sm-2 control-label">Description</label>

            <div class="col-sm-6">
                <input type="text" name="description" id="topic-description" class="form-control" value="{{ $topic->description }}">
            </div>
        </div>

        <!-- Topic Content -->
        <div class="form-group">
            <label for="task-name" class="col-sm-2 control-label">Content</label>

            <div class="col-sm-8">
                    <textarea name="topic_content" id="topic-content" rows="18" class="form-control">
                        {!! $topic->topic_content !!}
                    </textarea>
            </div>
        </div>

        <!-- Add Topic Button -->
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Update Topic
                </button>
            </div>
        </div>
    </form>

@endsection