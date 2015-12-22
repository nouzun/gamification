@extends('layouts.dashboard')
@section('page-script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>
    @stop
@section('page_heading_tree')
    <ul class="tree">
        <li>{{ $subject->title }}</li>
        <ul>
            <li>{{ $topic->title }}</li>
            <ul>
                <li>{{ $knowledgeunit->title }}</li>
            </ul>
        </ul>
    </ul>
    @stop
@section('page_heading','Questions')
@section('section')

        <!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

            <!-- New Question Form -->
    <form action="{{ url('/subjects/'.$topic->subject_id.'/topics/'. $topic->id .'/knowledgeunits/'. $knowledgeunit->id .'/questions') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

                <!-- Question Title -->
        <div class="form-group">
            <label for="task-name" class="col-sm-3 control-label">Question</label>

            <div class="col-sm-6">
                <input type="text" name="title" id="question-title" class="form-control">
            </div>
        </div>

        <!-- Question Description -->
        <div class="form-group">
            <label for="task-name" class="col-sm-3 control-label">Description</label>

            <div class="col-sm-6">
                <div id="summernote">Hello Summernote</div>
            </div>
        </div>

        <!-- Add Question Button -->
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Add Question
                </button>
            </div>
        </div>
    </form>
</div>

<!-- TODO: Current Question -->
@endsection